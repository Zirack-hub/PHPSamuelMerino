<?php
    if(!isset($_COOKIE['usuariopedidos'])) {
        header("Location: ./pe_login.php");
    }
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
            

            $conn = openBD();
            
            $resultado = selectASSOC("SELECT PRODUCTCODE, PRODUCTNAME FROM PRODUCTS WHERE QUANTITYINSTOCK > 0", $conn);
            mostrarOpciones("PRODUCTCODE", $resultado, "PRODUCTS", "PRODUCTNAME");
            
            ?>
            Cantidad de productos <input type="text" name="cantidad">
            <input type="submit" name="submit" value="Añadir">
            <input type="submit" name="submit" value="Eliminar">
            <input type="submit" name="submit" value="Finalizar Compra">

        </form>
        <p>Carrito</p>
        <?php
            foreach ($_SESSION['carrito'] as $producto => $cantidad){
                $nombre = selectCOL("SELECT PRODUCTNAME FROM PRODUCTS WHERE PRODUCTCODE = '$producto'", $conn);
                $precio = selectCOL("SELECT BUYPRICE FROM PRODUCTS WHERE PRODUCTCODE = '$producto'", $conn);
                $total = $precio * $cantidad;
                echo("$nombre.......... cantidad: $cantidad .......... total = $total $<br>");
            }

        ?>



</body>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $eleccion = limpiar_campos($_POST["submit"]);

    $producto = isset($_POST["PRODUCTS"])
        ? limpiar_campos($_POST["PRODUCTS"])
        : null;

    $cantidad = isset($_POST["cantidad"])
        ? limpiar_campos($_POST["cantidad"])
        : null;
    
    if ($eleccion == "Añadir") {
        agregarProducto($producto, $cantidad);
        var_dump($_SESSION['carrito']);
    }elseif ($eleccion == "Eliminar") {
        eliminarProducto($producto, $cantidad);
    }elseif ($eleccion == "Finalizar Compra") {
        $flag = comprobarCarrito($conn);
        if ($flag == true){
            echo '
                    <form name="alta" action="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '" method="post">
                        <br><br>
                        MetodoDepago(AA99999) <input type="text" name="pago">
                        <input type="submit" name="submit" value="Validar Compra">
                    </form>';
        }else{
            echo ("NO SE PUEDE REALIZAR LA COMPRA.");
    
    }

    }elseif ($eleccion == "Validar Compra") {
        $pago = limpiar_campos($_POST["pago"]);
        if (comprobarNumero($pago)== TRUE){

            realizarCompra($conn, $pago);
            session_destroy();
            closeBD($conn);
        
        }else{
            echo("NO SE HA INTRODUCIDO BIEN EL METODO DE PAGO");
        }

        
 
    }
}


?>
</html>