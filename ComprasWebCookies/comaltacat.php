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
    <h1 class="text-center">Alta en categorias</h1>

    <div class="container ">
        <!--Aplicacion-->
		<div class="card border-success mb-3" style="max-width: 30rem;">
		<div class="card-header">Alta en categorias</div>
		<div class="card-body">
		<form id="product-form" name="media7" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>"  method="post" class="card-body">
						<div class="form-group">
                            Producto <input type="text" name="alta" placeholder="Nombre" class="form-control">
                        </div>
                        <input type="submit" name="submit" value="Jugar" class="btn btn-warning disabled">
                       
                    </form>
		
	</div>



            </div>

        </div>
        <br>


    </div>



</body>

</html>
<?php
require_once ("./funciones/funciones.php");
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $servername = "localhost";
    $username = "root";
    $password = "rootroot";
    $dbname="comprasweb";
    $nombre = limpiar_campos($_POST["alta"]);
    $codigo = 0;


    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname",$username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        echo "Connected successfully";
        echo "</br>";
        $stmt = $conn->prepare("SELECT MAX(SUBSTR(ID_CATEGORIA, -3)) FROM categoria;");
        $stmt->execute();
        $codigo = $stmt->fetchColumn() +1;
        $codigo = str_pad((string)$codigo, 3, "0", STR_PAD_LEFT);
        $id_cat = "C-" . $codigo;
        echo "ID Categoría: " . $id_cat;
        echo "</br>";
        echo "Nombre: " . $nombre;
        $stmt = $conn->prepare("INSERT INTO categoria(ID_CATEGORIA,NOMBRE) VALUES (:id_categoria,:nombre)");
        $stmt->bindParam(':id_categoria', $id_cat);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->execute();
    }
    catch(PDOException $e)
        {
        echo "Connection failed: " . $e->getMessage();
        }
}        
?>