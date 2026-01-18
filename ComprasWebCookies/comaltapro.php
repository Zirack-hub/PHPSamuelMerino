<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Alta en productos</title>
</head>
<body>
    <h1>Alta en productos</h1>
        <p>Dar de alta productos<p>
        <div class="card-body">
        <form name="alta" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
            <?php
            $servername = "localhost";
            $username = "root";
            $password = "rootroot";
            $dbname="comprasweb";
            $conn = new PDO("mysql:host=$servername;dbname=$dbname",$username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
            $stmt = $conn->prepare("SELECT * FROM categoria;");
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $resultado=$stmt->fetchAll();
            echo "<label for='opcion'>Categoría:</label>";
            echo "<select id='opcion' name='opcion'>";
            foreach($resultado as $row) {
                echo "<option value='" . $row['ID_CATEGORIA'] . "'>" . $row['NOMBRE'] . "</option>";
            }
            echo "</select>";
            ?>
            Nombre <input type="text" name="nombre">
            Precio <input type="text" name="precio">
            <input type="submit" name="submit" value="Añadir">
        </form>
</body>
</html>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    function limpiar_campos($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    $servername = "localhost";
    $username = "root";
    $password = "rootroot";
    $dbname="comprasweb";
    $nombre= limpiar_campos($_POST["nombre"]);
    $precio = limpiar_campos($_POST["precio"]);
    $id_cat= limpiar_campos($_POST["opcion"]);
    $codigo=0;
    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname",$username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        $stmt = $conn->prepare("SELECT MAX(SUBSTR(ID_PRODUCTO, -4)) FROM producto;");
        $stmt->execute();
        $codigo = $stmt->fetchColumn() +1;
        $codigo = str_pad((string)$codigo, 4, "0", STR_PAD_LEFT);
        $id_prod = "P" . $codigo;
        $stmt = $conn->prepare("INSERT INTO producto(ID_CATEGORIA,ID_PRODUCTO,NOMBRE,PRECIO) VALUES (:id_categoria,:id_producto,:nombre,:precio)");
        $stmt->bindParam(':id_categoria', $id_cat);
        $stmt->bindParam(':id_producto', $id_prod);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':precio', $precio);
        $stmt->execute();
        }
    catch(PDOException $e)
        {
        echo "Connection failed: " . $e->getMessage();
        }
}
?>