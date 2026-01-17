<?php
require_once ("./funciones/funciones.php");
require_once ("./funciones/fbd.php");

$sesname = "usuariopedidos";
if (session_status() == PHP_SESSION_NONE) {
    session_name($sesname);
    session_start();
}

function iniciarCarrito()
{
    global $sesname;

    if (!isset($_SESSION['carrito'])) {

        if (isset($_SESSION[$sesname])) {
            var_dump($_SESSION[$sesname]);
            $cookieCarrito = 'carrito' . $_SESSION[$sesname];

            if (isset($_COOKIE[$cookieCarrito])) {
                $_SESSION[$sesname];
                $_SESSION['carrito'] = unserialize($_COOKIE[$cookieCarrito]);
                return;
            }
        }

        $_SESSION['carrito'] = [];
    }
}

function cerrarSesion($cookie_name){
    global $sesname;

    if (isset($_SESSION['carrito'])) {
        $carrito = $_SESSION['carrito'];
    } else {
        $carrito = [];
    }

    // Nombre de la cookie del carrito
    if (isset($_SESSION[$sesname])) {
        $carritoCookieName = 'carrito' . $_SESSION[$sesname];

        // Guardar carrito antes de cerrar sesión
        setcookie(
            $carritoCookieName,
            serialize($carrito),
            time() + (86400 * 30),
            "/"
        );
    }

    // Destruir sesión
    if (isset($_COOKIE[$sesname])) {
        session_destroy();
        setcookie($sesname, "", time() - 3600, "/");
    }

    header("Location: ./pe_login.php");
    exit();
}

function agregarProducto($id, $cantidad) {

    $cantidad = (int) $cantidad;

    if ($cantidad <= 0) {
        echo '<span style="color:red;">Introduce un número</span>';
        return;
    }

    if (!isset($_SESSION['carrito'])) {
        $_SESSION['carrito'] = [];
    }

    if (isset($_SESSION['carrito'][$id])) {
        $_SESSION['carrito'][$id] += $cantidad;
    } else {
        $_SESSION['carrito'][$id] = $cantidad;
    }
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

function eliminarProducto($id, $cantidad) {
    $cantidad = (int) $cantidad;

    if ($cantidad <= 0) {
        echo '<span style="color:red;">Introduce un número válido</span>';
        return;
    }

    if (!isset($_SESSION['carrito'])) {
        $_SESSION['carrito'] = [];
    }

    if (isset($_SESSION['carrito'][$id])) {
        // Restamos la cantidad
        $_SESSION['carrito'][$id] -= $cantidad;

        // Si llega a 0 o menos, eliminamos el producto
        if ($_SESSION['carrito'][$id] <= 0) {
            unset($_SESSION['carrito'][$id]);
        }
    }
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

function comprobarCarrito($conn){
    $flag = true;
    foreach ($_SESSION['carrito'] as $producto => $cantidad){
        $cotejar =  selectCol("SELECT QUANTITYINSTOCK FROM PRODUCTS WHERE PRODUCTCODE = '$producto'", $conn);
        if ($cantidad > $cotejar){
            $nombre = selectCol("SELECT PRODUCTNAME FROM PRODUCTS WHERE PRODUCTCODE = '$producto'", $conn);
            echo ("La cantidad seleccionada del articulo $nombre no existe");
            $flag = false;
        }
    }
    return $flag;
}

function realizarCompra($conn, $pago){
    global $sesname;
    $fecha = date("Y-m-d H:i:s");
    $numero = selectCol("SELECT ORDERNUMBER FROM ORDERS ORDER BY ORDERNUMBER DESC LIMIT 1", $conn);
    $numero += 1;
    $status = "Unshipped";
    $total = 0;
    $orderlinenumber = 1;
    if (!isset($_SESSION[$sesname]) && isset($_COOKIE[$sesname])) {
    $_SESSION[$sesname] = $_COOKIE[$sesname];
}

// Ahora ya se puede usar seguro
if (isset($_SESSION[$sesname])) {
    var_dump($_SESSION[$sesname]);
} else {
    echo "No hay usuario logueado";
}

    try{
        $conn->beginTransaction();
        $stmt = $conn->prepare("INSERT INTO ORDERS(ORDERNUMBER, ORDERDATE, REQUIREDDATE, SHIPPEDDATE, `STATUS`, COMMENTS, CUSTOMERNUMBER) VALUES (:ORDERNUMBER,:ORDERDATE,:REQUIREDDATE,NULL,:STATUS,NULL,:CUSTOMERNUMBER)");
        $stmt->bindParam(':ORDERNUMBER', $numero);
        $stmt->bindParam(':ORDERDATE', $fecha);
        $stmt->bindParam(':REQUIREDDATE', $fecha);
        $stmt->bindParam(':STATUS', $status);
        $stmt->bindParam(':CUSTOMERNUMBER', $_SESSION[$sesname]);
        $stmt->execute();
    
        foreach ($_SESSION['carrito'] as $producto => $cantidad){
            $precio = selectCOL("SELECT BUYPRICE FROM PRODUCTS WHERE PRODUCTCODE = '$producto'",$conn);
            $precioTotal = $precio * $cantidad;
            $total += $precioTotal;

            $stmt = $conn->prepare("UPDATE PRODUCTS SET QUANTITYINSTOCK = QUANTITYINSTOCK - :cantidad WHERE PRODUCTCODE = :producto");
            $stmt->bindParam(':producto', $producto);
            $stmt->bindParam(':cantidad', $cantidad);
            $stmt->execute();
       
            $stmt = $conn->prepare("INSERT INTO ORDERDETAILS(ORDERNUMBER, PRODUCTCODE, QUANTITYORDERED, PRICEEACH, ORDERLINENUMBER) VALUES (:ORDERNUMBER,:PRODUCTCODE,:QUANTITYORDERED,:PRICEEACH, :ORDERLINENUMBER)");
            $stmt->bindParam(':ORDERNUMBER', $numero);
            $stmt->bindParam(':PRODUCTCODE', $producto);
            $stmt->bindParam(':QUANTITYORDERED', $cantidad);
            $stmt->bindParam(':PRICEEACH', $precio);
            $stmt->bindParam(':ORDERLINENUMBER', $orderlinenumber);
            $stmt->execute();
            $orderlinenumber +=1;
        }

        $stmt = $conn->prepare("INSERT INTO PAYMENTS(CUSTOMERNUMBER, CHECKNUMBER, PAYMENTDATE, AMOUNT) VALUES (:CUSTOMERNUMBER,:CHECKNUMBER,:PAYMENTDATE,:AMOUNT)");
        $stmt->bindParam(':CUSTOMERNUMBER', $_SESSION[$sesname]);
        $stmt->bindParam(':CHECKNUMBER', $pago);
        $stmt->bindParam(':PAYMENTDATE', $fecha);
        $stmt->bindParam(':AMOUNT', $total);
        $stmt->execute();
        $conn->commit(); 

        if (isset($_COOKIE['carrito' . $_SESSION[$sesname]])) {
            setcookie('carrito' . $_SESSION[$sesname], "", time() - 3600, "/");
        }
    }
    catch(PDOException $e){
        if ($conn && $conn->inTransaction()) {
            $conn->rollback();
        }
        echo "Connection failed: " . $e->getMessage();
        echo "Código de error: " . $e->getCode() . "<br>";
    }
}

?>
