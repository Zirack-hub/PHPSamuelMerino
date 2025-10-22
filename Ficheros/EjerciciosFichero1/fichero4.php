<html>
    <?php
    $contador=(int)0;
    echo "<h2>Alumnos</h2>";
    echo "<table border='1' cellpadding='6' cellspacing='0'>";
    echo "<tr><th>Nombre</th><th>Apellido1</th><th>Apellido2</th><th>Fecna</th><th>Localidad</th></tr>";
     $f1 = fopen("./ficheros/fichero2.txt", "r");
    while (($linea = fgets($f1)) !== false) {
    // Eliminamos saltos de línea y espacios
    $linea = trim($linea);

    // Evitamos procesar líneas vacías
    if ($linea === "") continue;

    // Dividimos por el separador ##
    $campos = explode("##", $linea);

    echo "<tr>";
    foreach ($campos as $campo) {
        echo "<td>" . htmlspecialchars(trim($campo)) . "</td>";
    }
    echo "</tr>";
    $contador++;
}

    fclose($f1);
    echo "</table>";
    echo "Sen han impreso $contador lineas"
    ?>
</html>