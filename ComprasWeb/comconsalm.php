<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Aprovisionar</title>
</head>
<body>
    <h1>Consultar Almacenes</h1>
        <p>Consultar Almacenes<p>
        <div class="card-body">
        <form name="alta" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
            <?php
            require_once ("./funciones/funciones.php");
            require_once ("./funciones/fbd.php");

            $conn = $conn = openBD('comprasweb');

            $resultado = selectASSOC("SELECT NUM_ALMACEN FROM ALMACEN", $conn);
            mostrarOpciones("NUM_ALMACEN", $resultado, "ALMACEN");
            
            
            ?>
            <input type="submit" name="submit" value="Buscar">
        </form>
</body>
</html>
<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $almacen = limpiar_campos($_POST["ALMACEN"]);
        $numProd = selectASSOC("SELECT A.ID_PRODUCTO, P.ID_PRODUCTO, A.NUM_ALMACEN, NOMBRE, CANTIDAD, PRECIO 
                                FROM ALMACENA A, PRODUCTO P 
                                WHERE P.ID_PRODUCTO = A.ID_PRODUCTO 
                                AND NUM_ALMACEN = '$almacen'", $conn);

        if ($numProd==null) {
           echo"No hay existencias en este almacen.";
        }else {
            echo "El almacén Nº " . $almacen . " tiene el producto:<br>";
            foreach ($numProd as $fila) {
                echo "-ID Producto: " . $fila['ID_PRODUCTO']."<br>";
                echo "-Nombre: " . $fila['NOMBRE']."<br>";
                echo "-Cantidad: " . $fila['CANTIDAD']."<br>";
                echo "-Precio: " . $fila['PRECIO'] . " €"."<br>";
                echo "<br>";
                }
        }

        closeBD($conn);

    }




?>