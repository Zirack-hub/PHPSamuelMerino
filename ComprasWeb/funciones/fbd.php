<?php

function openBD($dbname){
    $servername = "localhost";
    $username = "root";
    $password = "rootroot";

    $conn = new PDO("mysql:host=$servername;dbname=$dbname",$username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

    return $conn;
}

function closeBD(&$conn){
  $conn=null;
}

function selectASSOC($sentencia, $conn) {
    $stmt = $conn->prepare("$sentencia");
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    return $stmt->fetchAll();
}


function selectCOL($sentencia, $conn){
    $stmt = $conn->prepare("$sentencia");
    $stmt->execute();
    return $stmt->fetchColumn();
}

function mostrarOpciones($clave, $resultado, $etiqueta,$mostrar=null){
    if (empty($mostrar)) {
        $mostrar = $clave;
    }

    echo "<label for='opcion'>$etiqueta:</label>";
    echo "<select id='opcion' name='opcion'>";
    foreach ($resultado as $row) {
        echo "<option value='" . $row[$clave] . "'>" . $row[$mostrar] . "</option>";
    }
    echo "</select>";
}




//function insert($sentencia, $conn,$tabla){
//    $stmt = select($conn, "Describe $tabla");
//    $campos = $stmt->fetchAll(PDO:FETCH_COLUMN);
//    $stmt =$conn->prepare("$sentencia");
//    foreach ($campos as $campo) {
//        $stmt->bindParam(".'".$campo."'",)
//    }
//}
?>


