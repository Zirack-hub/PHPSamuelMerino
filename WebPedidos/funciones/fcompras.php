<?php
require_once ("./funciones/funciones.php");
require_once ("./funciones/fbd.php");


function iniciarCarrito (){
    if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [];
    }
}

function cerrarSesion ($cookie_name){
    setcookie("$cookie_name", "", time() - 3600,"/");
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
    $fecha = date("Y-m-d H:i:s");
    $numero = selectCol("SELECT ORDERNUMBER FROM ORDERS ORDER BY ORDERNUMBER DESC LIMIT 1", $conn);
    $numero += 1;
    $status = "Unshipped";
    $total = 0;
    $orderlinenumber = 19;
    
    try{
        $conn->beginTransaction();
        $stmt = $conn->prepare("INSERT INTO ORDERS(ORDERNUMBER, ORDERDATE, REQUIREDDATE, SHIPPEDDATE, `STATUS`, COMMENTS, CUSTOMERNUMBER) VALUES (:ORDERNUMBER,:ORDERDATE,:REQUIREDDATE,NULL,:STATUS,NULL,:CUSTOMERNUMBER)");
        $stmt->bindParam(':ORDERNUMBER', $numero);
        $stmt->bindParam(':ORDERDATE', $fecha);
        $stmt->bindParam(':REQUIREDDATE', $fecha);
        $stmt->bindParam(':STATUS', $status);
        $stmt->bindParam(':CUSTOMERNUMBER', $_COOKIE['usuariopedidos']);
        $stmt->execute();
        $conn->commit(); 
    }
    catch(PDOException $e){
        if ($conn && $conn->inTransaction()) {
            $conn->rollback();
        }
        echo "Connection failed: " . $e->getMessage();
        echo "Codigo de error: " . $e->getCode() . "<br>";
    }
    
    foreach ($_SESSION['carrito'] as $producto => $cantidad){
        $precio = selectCOL("SELECT BUYPRICE FROM PRODUCTS WHERE PRODUCTCODE = '$producto'",$conn);
        $precioTotal = $precio * $cantidad;
        $total += $precioTotal;

        try{
            $conn->beginTransaction();
            $stmt = $conn->prepare("UPDATE PRODUCTS SET QUANTITYINSTOCK = QUANTITYINSTOCK - :cantidad WHERE PRODUCTCODE = :producto");
            $stmt->bindParam(':producto', $producto);
            $stmt->bindParam(':cantidad', $cantidad);
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

        try{
            $conn->beginTransaction();
            $stmt = $conn->prepare("INSERT INTO ORDERDETAILS(ORDERNUMBER, PRODUCTCODE, QUANTITYORDERED, PRICEEACH, ORDERLINENUMBER) VALUES (:ORDERNUMBER,:PRODUCTCODE,:QUANTITYORDERED,:PRICEEACH, :ORDERLINENUMBER)");
            $stmt->bindParam(':ORDERNUMBER', $numero);
            $stmt->bindParam(':PRODUCTCODE', $producto);
            $stmt->bindParam(':QUANTITYORDERED', $cantidad);
            $stmt->bindParam(':PRICEEACH', $precio);
            $stmt->bindParam(':ORDERLINENUMBER', $orderlinenumber);
            $stmt->execute();
            $conn->commit(); 
        }
        catch(PDOException $e){
            if ($conn && $conn->inTransaction()) {
                $conn->rollback();
            }
            echo "Connection failed: " . $e->getMessage();
            echo "Codigo de error: " . $e->getCode() . "<br>";
        }
    }

    try{
        $conn->beginTransaction();
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