<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Aprovisionar</title>
</head>
<body>
    <h1>Consultar Stock</h1>
        <p>Consultar Stock<p>
        <div class="card-body">
        <form name="alta" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
            <?php
            require_once ("./funciones/funciones.php");
            require_once ("./funciones/fbd.php");

            $conn = $conn = openBD('comprasweb');

            
            $resultado = selectASSOC("SELECT ID_PRODUCTO, NOMBRE FROM PRODUCTO", $conn);
            mostrarOpciones("ID_PRODUCTO", $resultado, "PRODUCTO", "NOMBRE");
            
            ?>
            <input type="submit" name="submit" value="Buscar">
        </form>
</body>
</html>
<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $producto = limpiar_campos($_POST["PRODUCTO"]);
        $numProd = selectASSOC("SELECT NUM_ALMACEN, CANTIDAD FROM ALMACENA WHERE ID_PRODUCTO = '$producto'", $conn);
        if ($numProd==null) {
           echo"No hay existencias de este producto en ningun almacen.";
        }else {
            foreach ($numProd as $fila) {
                echo "El almacén: " . $fila['NUM_ALMACEN'] . ", tiene: " . $fila['CANTIDAD'];
                echo "<br>";
            }
        }
        closeBD($conn);

    }




?>