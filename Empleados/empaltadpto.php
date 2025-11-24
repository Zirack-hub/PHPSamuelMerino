<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Alta departamentos</title>
</head>
<body>
    <h1>Alta departamentos</h1>
        <p>Dar de alta departamos<p>
        <div class="card-body">
        <form name="alta" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
            Nombre <input type="text" name="nombre">
            <input type="submit" name="submit" value="Añadir">
        </form>
</body>
</html>
<?php
require_once("./funciones/funciones.php");
require_once("./funciones/fbd.php");
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre_dpto = limpiar_campos($_POST["nombre"]);
    $dbname = "empleados";
    $codigo=0;
    try {
        $conn = openBD($dbname);
        $conn->beginTransaction();
        $dpto = selectCOL("SELECT MAX(SUBSTR(COD_DPTO, -3)) FROM departamento;", $conn) +1;
        $dpto = str_pad((string)$dpto, 3, "0", STR_PAD_LEFT);
        $cod_dpto = "D" . $dpto;
        $stmt = $conn->prepare("INSERT INTO departamento(COD_DPTO,NOMBRE_DPTO) VALUES (:cod_dpto,:nombre_dpto)");
        $stmt->bindParam(':cod_dpto', $cod_dpto);
        $stmt->bindParam(':nombre_dpto', $nombre_dpto);
        $stmt->execute();
        $conn->commit();
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
}
?>