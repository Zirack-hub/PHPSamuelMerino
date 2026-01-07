<?php
    session_start();
    require_once ("./funciones/funciones.php");
    require_once ("./funciones/fbd.php");
    require_once ("./funciones/fcompras.php");
    iniciarCarrito();
    
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Aprovisionar</title>
</head>
<body>
    <h1>Portal de compras</h1>
        <p>Portal de compras</p>
        <div class="card-body">
        <form name="alta" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
            <?php
            

            $conn = openBD('comprasweb');
            
            $resultado = selectASSOC("SELECT ID_PRODUCTO, NOMBRE FROM PRODUCTO", $conn);
            mostrarOpciones("ID_PRODUCTO", $resultado, "PRODUCTO", "NOMBRE");
            
            ?>
            Cantidad de productos <input type="text" name="cantidad">
            <input type="submit" name="submit" value="Añadir">
            <input type="submit" name="submit" value="Eliminar">
            <input type="submit" name="submit" value="Finalizar Compra">

        </form>
        <p>Carrito</p>
        <?php
            foreach ($_SESSION['carrito'] as $producto => $cantidad){
                $nombre = selectCOL("SELECT NOMBRE FROM PRODUCTO WHERE ID_PRODUCTO = '$producto'", $conn);
                echo("$nombre.......... cantidad: $cantidad <br>");
            }

        ?>



</body>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $eleccion = limpiar_campos($_POST["submit"]);
    $producto = limpiar_campos($_POST["PRODUCTO"]);
    $cantidad = limpiar_campos($_POST["cantidad"]);
    if ($eleccion == "Añadir") {
        agregarProducto($producto, $cantidad);
        var_dump($_SESSION);
        var_dump($_COOKIE['usuariocompras']);
    }elseif ($eleccion == "Eliminar") {
        eliminarProducto($producto, $cantidad);
    }elseif ($eleccion == "Finalizar Compra") {
        $flag = comprobarCarrito($conn);
        if ($flag == true){
            realizarCompra($conn);
            session_destroy();
            closeBD($conn);
        }else{
            echo ("NO SE PUEDE REALIZAR LA COMPRA.");
        }

    }

    }

?>
</html>