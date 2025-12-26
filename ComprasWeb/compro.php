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
            
            $resultado = selectASSOC("SELECT ID_PRODUCTO, NOMBRE FROM PRODUCTO", $conn);
            mostrarOpciones("ID_PRODUCTO", $resultado, "PRODUCTO", "NOMBRE");
            
            ?>
            <input type="submit" name="submit" value="Añadir">
        </form>
</body>
</html>
<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        
        $producto = limpiar_campos($_POST["PRODUCTO"]);

        $almacen = selectCOL("SELECT NUM_ALMACEN FROM ALMACENA WHERE ID_PRODUCTO = '$producto' AND CANTIDAD > 0", $conn);
        
        if ($almacen != null){
            echo "Has seleccionado $producto<br>";
            $cantidad = selectCOL("SELECT CANTIDAD FROM ALMACENA WHERE ID_PRODUCTO = '$producto' AND NUM_ALMACEN = '$almacen'", $conn);
            echo "Se ha encontrado el producto $producto en el almacen $almacen, con un total de $cantidad unidades<br>";
            try {
        $conn->beginTransaction();
            $stmt = $conn->prepare("UPDATE ALMACENA SET CANTIDAD = CANTIDAD - 1 WHERE ID_PRODUCTO = :producto AND NUM_ALMACEN = :almacen");
                $stmt->bindParam(':producto', $producto);
                $stmt->bindParam(':almacen', $almacen);
            $stmt->execute();
            $conn->commit();

            $cantidad = selectCOL("SELECT CANTIDAD FROM ALMACENA WHERE ID_PRODUCTO = '$producto' AND NUM_ALMACEN = '$almacen'", $conn);
            echo "Se ha encontrado el producto $producto en el almacen $almacen, con un total de $cantidad unidades<br>";
        closeBD($conn);
        }
            catch(PDOException $e)
                {
                if ($conn && $conn->inTransaction()) {
                    $conn->rollback();
                }
                echo "Connection failed: " . $e->getMessage();
                echo "Código de error: " . $e->getCode() . "<br>";
                }
        }else{
            echo "El producto que has seleccionado no se encuentra en ningun alamacen";
        }

        


    }




?>