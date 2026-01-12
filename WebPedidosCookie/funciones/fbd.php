<?php


function openBD() {
    try {
        $conn = new PDO("mysql:host=localhost;dbname=webpedidos;charset=utf8",
            "root",
            "rootroot");
        $conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        return $conn;
        }
    catch(PDOException $e)
        {
        echo "Connection failed: " . $e->getMessage();
        }
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

//function mostrarOpciones($clave, $resultado, $etiqueta,$mostrar=null){
//    if (empty($mostrar)) {
//        $mostrar = $clave;
//    }
//
//    echo "<label for='opcion'>".$etiqueta.":</label>";
//    echo "<select id='".$etiqueta."' name='".$etiqueta."'>";
//    foreach ($resultado as $row) {
//        echo "<option value='" . $row[$clave] . "'>" . $row[$mostrar] . "</option>";
//    }
//    echo "</select>";
//}


function mostrarOpciones($clave, $resultado, $etiqueta, $mostrar = null, $seleccionado = null) {
    if (empty($mostrar)) {
        $mostrar = $clave;
    }

    // Escapar el nombre de etiqueta para HTML
    $etiquetaEscapada = htmlspecialchars($etiqueta);

    echo "<label for='{$etiquetaEscapada}'>{$etiquetaEscapada}:</label>";
    echo "<select id='{$etiquetaEscapada}' name='{$etiquetaEscapada}'>";
    echo "<option value=''>Selecciona...</option>";

    foreach ($resultado as $row) {
        $valor = htmlspecialchars($row[$clave]);
        $texto = htmlspecialchars($row[$mostrar]);

        // Marcar como seleccionado si coincide con $seleccionado
        $selectedAttr = ($seleccionado !== null && $seleccionado == $row[$clave]) ? " selected" : "";

        echo "<option value='{$valor}'{$selectedAttr}>{$texto}</option>";
    }

    echo "</select>";
}


?>


