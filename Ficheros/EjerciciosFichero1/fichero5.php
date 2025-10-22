













<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Operaciones Ficheros</title>
</head>
<body>
  <h2>Formulario de Alumnos</h2>
  <form action="fichero1.php" method="post">
    <label>Fichero (Path/nombre):</label><br>
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
