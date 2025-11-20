<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Alta productos</title>
    <link rel="stylesheet" href="bootstrap.min.css">
</head>

<body>

    <h1 class="text-center">Alta en categorías</h1>

    <div class="container">

        <div class="card border-success mb-3" style="max-width: 30rem; margin: auto;">
            <div class="card-header">Alta en categorías</div>

            <div class="card-body">

                <form id="product-form" name="media7" 
                      action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>"  
                      method="post">

                    <div class="form-group">
                        <label for="localidad">Localidad</label>
                        <input type="text" id="localidad" name="localidad" 
                               placeholder="Nombre" class="form-control">
                    </div>

                    <input type="submit" name="submit" value="Enviar" 
                           class="btn btn-warning mt-3">

                </form>

            </div>
        </div>

    </div>

</body>
</html>

<?php
require_once ("./funciones/funciones.php");
require_once ("./funciones/fbd.php");
if ($_SERVER["REQUEST_METHOD"] == "POST") {
$dbname="comprasweb";
$tabla="almacen";
 $nombre = limpiar_campos($_POST["localidad"]);
 $codigo = 0;
 try {
        $conn = openBD($dbname);
        echo "Connected successfully";
        echo "</br>";

        $stmt = select("SELECT MAX(NUM_ALMACEN)FROM almacen", $conn);
        $codigo = $stmt->fetchColumn() +1;
        echo "Numero de almacen: " . $codigo;
        echo "</br>";
        echo "Localidad: " . $nombre;

        $stmt = $conn->prepare("INSERT INTO almacen(NUM_ALMACEN,LOCALIDAD) VALUES (:num_almacen,:localidad)");
        $stmt->bindParam(':num_almacen', $codigo);
        $stmt->bindParam(':localidad', $nombre);
        $stmt->execute();
        closeBD($conn);

        closeBD($conn);
    }
    catch(PDOException $e)
        {
        echo "Connection failed: " . $e->getMessage();
        }
    }
?>
