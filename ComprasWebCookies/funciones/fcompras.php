<?php
require_once ("./funciones/funciones.php");
require_once ("./funciones/fbd.php");


function nombreCarrito() {
    return 'carrito' . $_COOKIE['usuariocompras'];
}

function iniciarCarrito() {
    if (!isset($_COOKIE['usuariocompras'])) return;

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
    header("Location: ./comlogincli.php");
    exit();
}

function agregarProducto($id, $cantidad) {
    if (!isset($_COOKIE['usuariocompras'])) return;

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
    if (!isset($_COOKIE['usuariocompras'])) return;

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
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}


function comprobarCarrito($conn){
    $flag = true;

    if (!isset($_COOKIE['usuariopedidos'])) return true;

    $cookieCarrito = nombreCarrito();
    if (!isset($_COOKIE[$cookieCarrito])) return true;

    $carrito = unserialize($_COOKIE[$cookieCarrito]);

    foreach ($carrito as $producto => $cantidad){
        $cotejar =  selectCol("SELECT SUM(CANTIDAD) AS TOTAL FROM ALMACENA WHERE ID_PRODUCTO = '$producto'", $conn);
        if ($cantidad > $cotejar){
            $nombre = selectCol("SELECT NOMBRE FROM PRODUCTO WHERE ID_PRODUCTO = '$producto'", $conn);
            echo ("La cantidad seleccionada del articulo $nombre no existe");
            $flag = false;
        }
    }
    var_dump($flag);
    return $flag;
}

function realizarCompra($conn){
    if (!isset($_COOKIE['usuariocompras'])) return;

    $cookieCarrito = nombreCarrito();
    if (!isset($_COOKIE[$cookieCarrito])) return;

    $carrito = unserialize($_COOKIE[$cookieCarrito]);
    var_dump($carrito);
    foreach ($carrito as $producto => $cantidad){
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