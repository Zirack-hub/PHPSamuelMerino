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
    header("Location: ./comlogincli.php");
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
        $cotejar =  selectCol("SELECT SUM(CANTIDAD) AS TOTAL FROM ALMACENA WHERE ID_PRODUCTO = '$producto'", $conn);
        if ($cantidad > $cotejar){
            $nombre = selectCol("SELECT NOMBRE FROM PRODUCTO WHERE ID_PRODUCTO = '$producto'", $conn);
            echo ("La cantidad seleccionada del articulo $nombre no existe");
            $flag = false;
        }
    }
    return $flag;
}

function realizarCompra($conn){
    foreach ($_SESSION['carrito'] as $producto => $cantidad){
        $cotejar =  selectCol("SELECT CANTIDAD FROM ALMACENA WHERE ID_PRODUCTO = '$producto'", $conn);
            $cant = $cantidad;
            while ($cant > 0){
                $cotejar =  selectCol("SELECT CANTIDAD FROM ALMACENA WHERE ID_PRODUCTO = '$producto' AND CANTIDAD > 0 ORDER BY NUM_ALMACEN LIMIT 1", $conn);
                try{
                    $conn->beginTransaction();
                if ($cotejar < $cant){
                    $stmt = $conn->prepare("UPDATE ALMACENA SET CANTIDAD = CANTIDAD - :cotejar WHERE ID_PRODUCTO = :producto AND CANTIDAD > 0 ORDER BY NUM_ALMACEN LIMIT 1");
                    $stmt->bindParam(':producto', $producto);
                    $stmt->bindParam(':cotejar', $cotejar);
                }else{
                    $stmt = $conn->prepare("UPDATE ALMACENA SET CANTIDAD = CANTIDAD - :cantidad WHERE ID_PRODUCTO = :producto AND CANTIDAD > 0 ORDER BY NUM_ALMACEN LIMIT 1");
                    $stmt->bindParam(':producto', $producto);
                    $stmt->bindParam(':cantidad', $cant);
                }
                $stmt->execute();
                $conn->commit(); 
                $cant = $cant - $cotejar;
                }
                 catch(PDOException $e)
                    {
                    if ($conn && $conn->inTransaction()) {
                        $conn->rollback();
                    }
                    echo "Connection failed: " . $e->getMessage();
                    echo "Código de error: " . $e->getCode() . "<br>";
                    }
            }
            
            try{
            $fecha = date("Y-m-d H:i:s"); 
            $stmt = $conn->prepare("INSERT INTO compra(NIF, ID_PRODUCTO, FECHA_COMPRA, UNIDADES) VALUES (:NIF,:ID_PRODUCTO,:FECHA_COMPRA,:UNIDADES)");
            $stmt->bindParam(':NIF', $_COOKIE['usuariocompras']);
            $stmt->bindParam(':ID_PRODUCTO', $producto);
            $stmt->bindParam(':FECHA_COMPRA', $fecha);
            $stmt->bindParam(':UNIDADES', $cantidad);
            $stmt->execute();
        }
        catch(PDOException $e)
           {
            if ($conn && $conn->inTransaction()) {
                $conn->rollback();
            }
            echo "Connection failed: " . $e->getMessage();
            echo "Código de error: " . $e->getCode() . "<br>";
           }
    }
}
?>