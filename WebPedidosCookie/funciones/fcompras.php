<?php
require_once ("./funciones/funciones.php");
require_once ("./funciones/fbd.php");

function nombreCarrito() {
    return 'carrito' . $_COOKIE['usuariopedidos'];
}

function iniciarCarrito() {
    if (!isset($_COOKIE['usuariopedidos'])) return;

    $cookieCarrito = nombreCarrito();
    if (!isset($_COOKIE[$cookieCarrito])) {
        setcookie($cookieCarrito, serialize([]), time() + (86400 * 30), "/");
    }
}

function cerrarSesion($cookie_name) {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    session_destroy();
    setcookie("PHPSESSID", "", time() - 3600, "/");
    setcookie($cookie_name, "", time() - 3600, "/");
    header("Location: ./pe_login.php");
    exit();
}

function agregarProducto($id, $cantidad) {
    if (!isset($_COOKIE['usuariopedidos'])) return;

    $cantidad = (int)$cantidad;
    if ($cantidad <= 0) return;

    $cookieCarrito = nombreCarrito();
    $carrito = isset($_COOKIE[$cookieCarrito]) ? unserialize($_COOKIE[$cookieCarrito]) : [];

    if (isset($carrito[$id])) {
        $carrito[$id] += $cantidad;
    } else {
        $carrito[$id] = $cantidad;
    }

    setcookie($cookieCarrito, serialize($carrito), time() + (86400 * 30), "/");
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

function eliminarProducto($id, $cantidad) {
    if (!isset($_COOKIE['usuariopedidos'])) return;

    $cantidad = (int)$cantidad;
    if ($cantidad <= 0) return;

    $cookieCarrito = nombreCarrito();
    if (!isset($_COOKIE[$cookieCarrito])) return;

    $carrito = unserialize($_COOKIE[$cookieCarrito]);

    if (isset($carrito[$id])) {
        $carrito[$id] -= $cantidad;
        if ($carrito[$id] <= 0) {
            unset($carrito[$id]);
        }
        setcookie($cookieCarrito, serialize($carrito), time() + (86400 * 30), "/");
    }
}

function comprobarCarrito($conn) {
    if (!isset($_COOKIE['usuariopedidos'])) return true;

    $cookieCarrito = nombreCarrito();
    if (!isset($_COOKIE[$cookieCarrito])) return true;

    $carrito = unserialize($_COOKIE[$cookieCarrito]);

    foreach ($carrito as $producto => $cantidad) {
        $stmt = $conn->prepare("SELECT QUANTITYINSTOCK FROM PRODUCTS WHERE PRODUCTCODE = :producto");
        $stmt->execute([':producto' => $producto]);
        $stock = $stmt->fetchColumn();

        if ($cantidad > $stock) {
            return false;
        }
    }
    return true;
}

function realizarCompra($conn, $pago) {
    if (!isset($_COOKIE['usuariopedidos'])) return;

    $cookieCarrito = nombreCarrito();
    if (!isset($_COOKIE[$cookieCarrito])) return;

    $carrito = unserialize($_COOKIE[$cookieCarrito]);
    $fecha = date("Y-m-d H:i:s");

    $numero = selectCol("SELECT MAX(ORDERNUMBER) FROM ORDERS", $conn) + 1;
    $status = "Unshipped";
    $total = 0;
    $orderlinenumber = 1;

    try {
        $conn->beginTransaction();

        $stmt = $conn->prepare(
            "INSERT INTO ORDERS (ORDERNUMBER, ORDERDATE, REQUIREDDATE, SHIPPEDDATE, STATUS, COMMENTS, CUSTOMERNUMBER)
             VALUES (:ORDERNUMBER, :ORDERDATE, :REQUIREDDATE, NULL, :STATUS, NULL, :CUSTOMERNUMBER)"
        );
        $stmt->execute([
            ':ORDERNUMBER' => $numero,
            ':ORDERDATE' => $fecha,
            ':REQUIREDDATE' => $fecha,
            ':STATUS' => $status,
            ':CUSTOMERNUMBER' => $_COOKIE['usuariopedidos']
        ]);

        foreach ($carrito as $producto => $cantidad) {
            $stmt = $conn->prepare("SELECT BUYPRICE FROM PRODUCTS WHERE PRODUCTCODE = :producto");
            $stmt->execute([':producto' => $producto]);
            $precio = $stmt->fetchColumn();

            $total += $precio * $cantidad;

            $stmt = $conn->prepare(
                "UPDATE PRODUCTS SET QUANTITYINSTOCK = QUANTITYINSTOCK - :cantidad WHERE PRODUCTCODE = :producto"
            );
            $stmt->execute([
                ':cantidad' => $cantidad,
                ':producto' => $producto
            ]);

            $stmt = $conn->prepare(
                "INSERT INTO ORDERDETAILS (ORDERNUMBER, PRODUCTCODE, QUANTITYORDERED, PRICEEACH, ORDERLINENUMBER)
                 VALUES (:ORDERNUMBER, :PRODUCTCODE, :QUANTITYORDERED, :PRICEEACH, :ORDERLINENUMBER)"
            );
            $stmt->execute([
                ':ORDERNUMBER' => $numero,
                ':PRODUCTCODE' => $producto,
                ':QUANTITYORDERED' => $cantidad,
                ':PRICEEACH' => $precio,
                ':ORDERLINENUMBER' => $orderlinenumber
            ]);

            $orderlinenumber++;
        }

        $stmt = $conn->prepare(
            "INSERT INTO PAYMENTS (CUSTOMERNUMBER, CHECKNUMBER, PAYMENTDATE, AMOUNT)
             VALUES (:CUSTOMERNUMBER, :CHECKNUMBER, :PAYMENTDATE, :AMOUNT)"
        );
        $stmt->execute([
            ':CUSTOMERNUMBER' => $_COOKIE['usuariopedidos'],
            ':CHECKNUMBER' => $pago,
            ':PAYMENTDATE' => $fecha,
            ':AMOUNT' => $total
        ]);

        $conn->commit();
        setcookie($cookieCarrito, "", time() - 3600, "/");

    } catch (PDOException $e) {
        if ($conn->inTransaction()) {
            $conn->rollback();
        }
        throw $e;
    }
}
?>
