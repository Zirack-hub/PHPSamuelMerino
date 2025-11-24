<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Aprovisionar</title>
</head>
<body>
    <h1>Aprovisionar Productos</h1>
        <p>Aprovisionar Productos<p>
        <div class="card-body">
        <form name="alta" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
            <?php
            require_once ("./funciones/funciones.php");
            require_once ("./funciones/fbd.php");

            $conn = $conn = openBD('comprasweb');

            $resultado = selectASSOC("SELECT NUM_ALMACEN FROM ALMACEN", $conn);
            mostrarOpciones("NUM_ALMACEN", $resultado, "ALMACEN");
            
            $resultado = selectASSOC("SELECT ID_PRODUCTO, NOMBRE FROM PRODUCTO", $conn);
            mostrarOpciones("ID_PRODUCTO", $resultado, "PRODUCTO", "NOMBRE");
            
            ?>
            Cantidad de productos <input type="text" name="cantidad">
            <input type="submit" name="submit" value="Añadir">
        </form>
</body>
</html>
<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $almacen = limpiar_campos($_POST["ALMACEN"]);
        $producto = limpiar_campos($_POST["PRODUCTO"]);
        $cantidad = limpiar_campos($_POST["cantidad"]);

        $stmt = $conn->prepare("INSERT INTO almacena(NUM_ALMACEN,ID_PRODUCTO,CANTIDAD) VALUES(:almacen,:producto,:cantidad)");
        $stmt->bindParam(':almacen', $almacen);
        $stmt->bindParam(':producto', $producto);
        $stmt->bindParam(':cantidad', $cantidad);
        $stmt->execute();
        closeBD($conn);

    }




?>