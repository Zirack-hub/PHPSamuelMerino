<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Recogemos los datos del formulario y los limpiamos
    $nombre     = limpiar_campos($_POST['nombre']);
    $apellido1  = limpiar_campos($_POST['apellido1']);
    $apellido2  = limpiar_campos(($_POST['apellido2']));
    $fecha_nac  = limpiar_campos($_POST['fecha_nac']);
    $localidad  = limpiar_campos($_POST['localidad']);

    // --- Función para ajustar campos ---
    function ajustarCampo($texto, $longitud) {
        // Corta si es más largo y rellena con espacios si es más corto
        $texto = mb_substr($texto, 0, $longitud, 'UTF-8');
        return str_pad($texto, $longitud, ' ');
    }

    // --- Creamos la cadena del alumno con posiciones fijas ---
    $registro  = ajustarCampo($nombre, 40);
    $registro .= ajustarCampo($apellido1, 41);
    $registro .= ajustarCampo($apellido2, 42);
    $registro .= ajustarCampo($fecha_nac, 10);
    $registro .= ajustarCampo($localidad, 27);
    $registro .= "\n";


    // --- Abrimos el fichero en modo "a+" (leer/escribir, añadir al final) ---
    $f1 = fopen("./ficheros/fichero1.txt", "a+");

    if ($f1) {
        fwrite($f1, $registro); // Escribimos la línea del alumno
        fclose($f1);            // Cerramos el fichero
        echo "<p>✅ Alumno guardado correctamente en <strong>./ficheros/fichero1.txt</strong></p>";
    } else {
        echo "<p>❌ Error: No se pudo abrir el fichero.</p>";
    }
}
function limpiar_campos($data) { //Evita la Injección de Código
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Registro de Alumnos</title>
</head>
<body>
  <h2>Formulario de Alumnos</h2>
  <form action="fichero1.php" method="post">
    <label>Nombre:</label><br>
    <input type="text" name="nombre" maxlength="40" required><br><br>

    <label>Primer Apellido:</label><br>
    <input type="text" name="apellido1" maxlength="41" required><br><br>

    <label>Segundo Apellido:</label><br>
    <input type="text" name="apellido2" maxlength="42" required><br><br>

    <label>Fecha de Nacimiento:</label><br>
    <input type="date" name="fecha_nac" required><br><br>

    <label>Localidad:</label><br>
    <input type="text" name="localidad" maxlength="27" required><br><br>

    <input type="submit" value="Guardar Alumno">
  </form>
</body>
</html>
