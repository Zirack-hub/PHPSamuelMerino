<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Alta departamentos</title>
</head>
<body>
    <h1>Alta empleados</h1>
        <p>Dar de alta empleados<p>
        <div class="card-body">
        <form name="alta" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
         <?php
            require_once ("./funciones/funciones.php");
            require_once ("./funciones/fbd.php");

            $conn = $conn = openBD('empleados');

            
            
            $resultado = selectASSOC("SELECT cod_dpto, nombre_dpto FROM departamento", $conn);
            mostrarOpciones("cod_dpto", $resultado, "DEPARTAMENTO", "nombre_dpto");
            
            var_dump($resultado);

            ?>  
            DNI <input type="text" name="DNI">  
            Nombre <input type="text" name="nombre">
            Apellidos <input type="text" name="apellido">
            Salario <input type="text" name="salario">
            Fecha Naciminiento <input type="date" name="FecNa">
            <input type="submit" name="submit" value="Añadir">
        </form>
</body>
</html>
<?php
require_once("./funciones/funciones.php");
require_once("./funciones/fbd.php");
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $dni = limpiar_campos($_POST["DNI"]);
    $nombre = limpiar_campos($_POST["nombre"]);
    $apellido = limpiar_campos($_POST["apellido"]);
    $salario = limpiar_campos($_POST["salario"]);
    $fecNa = limpiar_campos($_POST["FecNa"]);
    $departamento = limpiar_campos($_POST["DEPARTAMENTO"]);
    var_dump($departamento);
    $dbname = "empleados";
    $codigo=0;
    try {
        $conn->beginTransaction();
        $stmt = $conn->prepare("INSERT INTO empleado(dni,nombre, apellidos, salario, fecha_nac) VALUES (:dni,:nombre,:apellido,:salario,:fecna)");
        $stmt->bindParam(':dni', $dni);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':apellido', $apellido);
        $stmt->bindParam(':salario', $salario);
        $stmt->bindParam(':fecna', $fecNa);
        $stmt->execute();
        $stmt = $conn->prepare("INSERT INTO emple_depart(cod_dpto,dni,fecha_fin,fecha_ini) VALUES (:departamento,:dni,:fecfin,:fecini)");
        $stmt->bindParam(':departamento', $departamento);
        $stmt->bindParam(':dni', $dni);
        $stmt->bindValue(':fecfin', null, PDO::PARAM_NULL);
        $fecini = date('Y-m-d H:i:s');
        $stmt->bindParam(':fecini', $fecini);
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