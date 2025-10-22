<html>
    <?php
    $contador=(int)0;
    echo "<h2>Alumnos</h2>";
    echo "<table border='1' cellpadding='6' cellspacing='0'>";
    echo "<tr><th>Nombre</th><th>Apellido1</th><th>Apellido2</th><th>Fecna</th><th>Localidad</th></tr>";
     $f1 = fopen("./ficheros/fichero1.txt", "r");
    while (($linea = fgets($f1)) !== false) {
    // Usamos substr() para cortar los campos según las posiciones fijas
        $nombre      = trim(substr($linea, 0, 40));
        $apellido1   = trim(substr($linea, 40, 40));
        $apellido2   = trim(substr($linea, 81, 41));
        $fecha       = trim(substr($linea, 123, 9));
        $ciudad      = trim(substr($linea, 133));

        // Mostramos la fila
        echo "<tr>";
        echo "<td>" . htmlspecialchars($nombre) . "</td>";
        echo "<td>" . htmlspecialchars($apellido1) . "</td>";
        echo "<td>" . htmlspecialchars($apellido2) . "</td>";
        echo "<td>" . htmlspecialchars($fecha) . "</td>";
        echo "<td>" . htmlspecialchars($ciudad) . "</td>";
        echo "</tr>";
        $contador++;
    }
    fclose($f1);
    echo "</table>";
    echo "Sen han impreso $contador lineas"
    ?>
</html>