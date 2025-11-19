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

function select($sentencia, $conn){
    $stmt = $conn->prepare("$sentencia");
    $stmt->execute();
    return $stmt;
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


