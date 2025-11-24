<?php
/* Inserción en tabla con Prepared Statement y gestión de transacciones - MySQL PDO */

$servername = "localhost";
$username   = "root";
$password   = "rootroot";
$dbname     = "empleados1n";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // Lanzar excepciones ante errores
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Iniciar transacción
    $conn->beginTransaction();

    // Preparar SQL y asociar parámetros
    $stmt = $conn->prepare(
        "INSERT INTO departamento (cod_dpto, nombre)
         VALUES (:cod_dpto, :nombre)"
    );

    $stmt->bindParam(':cod_dpto', $cod_dpto);
    $stmt->bindParam(':nombre',    $nombre);

    // ---- 1ª fila ----
    $cod_dpto = 'D001';
    $nombre   = 'VENTAS';
    $stmt->execute();

    // ---- 2ª fila ----
    $cod_dpto = 'D002';
    $nombre   = 'MARKETING';
    $stmt->execute();

    // ---- 3ª fila ----
    $cod_dpto = 'D003';
    $nombre   = 'COMPRAS';
    $stmt->execute();

    // Si todo va bien, confirmamos la transacción
    $conn->commit();

    echo "Departamentos insertados correctamente.<br>";

} catch (PDOException $e) {

  
    echo "Error: " . $e->getMessage() . "<br>";

    // Código de error (SQLSTATE)
    echo "Código de error: " . $e->getCode() . "<br>";

    
    }


$conn = null;
?>