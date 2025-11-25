<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cambiar departamento</title>
</head>
<body>
    <h1>Cambiar departamento</h1>
        <p>Cambiar departamento<p>
        <div class="card-body">
        <form name="alta" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
         <?php
            require_once ("./funciones/funciones.php");
            require_once ("./funciones/fbd.php");

            $conn = $conn = openBD('empleados');

                $resultado = selectASSOC("SELECT dni FROM empleado", $conn);
                mostrarOpciones("dni", $resultado, "DNI");

                $resultado = selectASSOC("SELECT cod_dpto, nombre_dpto FROM departamento", $conn);
                mostrarOpciones("cod_dpto", $resultado, "DEPARTAMENTO", "nombre_dpto");
            

            ?>  
          <input type="submit" name="submit" value="Cambiar Departamento"> 
        </form>
</body>
</html>
<?php
require_once("./funciones/funciones.php");
require_once("./funciones/fbd.php");
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $dni = limpiar_campos($_POST["DNI"]);
    $departamento = limpiar_campos($_POST["DEPARTAMENTO"]);
    $dbname = "empleados";
    $codigo=0;
    try {
        $conn->beginTransaction();
            $stmt = $conn->prepare("UPDATE emple_depart SET fecha_fin = :fecfin WHERE dni = :dni AND fecha_fin IS NULL");
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