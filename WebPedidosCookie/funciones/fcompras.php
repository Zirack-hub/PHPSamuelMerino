<?php
require_once ("./funciones/funciones.php");
require_once ("./funciones/fbd.php");


function iniciarCarrito() {
    if (!isset($_COOKIE['carrito'])) {
        $carrito = [];
        setcookie('carrito', serialize($carrito), time() + (86400 * 30), "/");
    }
}


function cerrarSesion ($cookie_name){
    if (isset($_COOKIE['PHPSESSID'])){
        session_destroy();
        setcookie("PHPSESSID", "", time() - 3600,"/");
    }
    setcookie("$cookie_name", "", time() - 3600,"/");
    header("Location: ./pe_login.php");
    exit();
}

function agregarProducto($id, $cantidad) {
    $cantidad = (int) $cantidad;

    if ($cantidad <= 0) {
        return;
    }

    // Leer carrito desde la cookie
    if (!isset($_COOKIE['carrito'])) {
        $carrito = [];
    } else {
        $carrito = unserialize($_COOKIE['carrito']);
    }

    // Agregar o actualizar producto
    if (isset($carrito[$id])) {
        $carrito[$id] += $cantidad;
    } else {
        $carrito[$id] = $cantidad;
    }

    // Guardar carrito en la cookie
    setcookie('carrito', serialize($carrito), time() + (86400 * 30), "/");
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

function eliminarProducto($id, $cantidad) {
    $cantidad = (int) $cantidad;

    if ($cantidad <= 0) {
        return;
    }

    // Leer carrito desde la cookie
    if (!isset($_COOKIE['carrito'])) {
        $carrito = [];
    } else {
        $carrito = unserialize($_COOKIE['carrito']);
    }

    // Verificar si el producto existe en el carrito
    if (isset($carrito[$id])) {
        $carrito[$id] -= $cantidad;

        // Si la cantidad es 0 o menos, eliminamos el producto
        if ($carrito[$id] <= 0) {
            unset($carrito[$id]);
        }

        // Guardar carrito actualizado
        setcookie('carrito', serialize($carrito), time() + (86400 * 30), "/");

    } 
}



function comprobarCarrito($conn){
    $flag = true;
    $carrito = unserialize($_COOKIE['carrito']);
    foreach ($carrito as $producto => $cantidad){
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
    $fecha = date("Y-m-d H:i:s");
    $numero = selectCol("SELECT ORDERNUMBER FROM ORDERS ORDER BY ORDERNUMBER DESC LIMIT 1", $conn);
    $numero += 1;
    $status = "Unshipped";
    $total = 0;
    $orderlinenumber = 1;
    $carrito = unserialize($_COOKIE['carrito']);
    try{
        $conn->beginTransaction();
        $stmt = $conn->prepare("INSERT INTO ORDERS(ORDERNUMBER, ORDERDATE, REQUIREDDATE, SHIPPEDDATE, `STATUS`, COMMENTS, CUSTOMERNUMBER) VALUES (:ORDERNUMBER,:ORDERDATE,:REQUIREDDATE,NULL,:STATUS,NULL,:CUSTOMERNUMBER)");
        $stmt->bindParam(':ORDERNUMBER', $numero);
        $stmt->bindParam(':ORDERDATE', $fecha);
        $stmt->bindParam(':REQUIREDDATE', $fecha);
        $stmt->bindParam(':STATUS', $status);
        $stmt->bindParam(':CUSTOMERNUMBER', $_COOKIE['usuariopedidos']);
        $stmt->execute();
    
    
    foreach ($carrito as $producto => $cantidad){
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
        $stmt->bindParam(':CUSTOMERNUMBER', $_COOKIE['usuariopedidos']);
        $stmt->bindParam(':CHECKNUMBER', $pago);
        $stmt->bindParam(':PAYMENTDATE', $fecha);
        $stmt->bindParam(':AMOUNT', $total);
        $stmt->execute();
        $conn->commit(); 
    }
    catch(PDOException $e){
        if ($conn && $conn->inTransaction()) {
            $conn->rollback();
        }
        echo "Connection failed: " . $e->getMessage();
        echo "C贸digo de error: " . $e->getCode() . "<br>";
    }
}

?>