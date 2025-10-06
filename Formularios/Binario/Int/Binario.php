<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Convertidor a Binario</title>
</head>
<body>
  <h1>Convertidor de Decimal a Binario</h1>

  <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    <label>Ingresa un número decimal:</label>
    <input type="number" name="decimal" required><br><br>
    <input type="submit" value="Convertir a binario">
  </form>
</body>
</html>

<?php

function limpiar($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return($data);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
$decimal = $_REQUEST['decimal'];
}

$decimal = limpiar($decimal);
$binario = decbin($decimal);



?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Resultado Binario</title>
</head>
<body>

  <!-- Mostrar resultado -->
  <?php if ($decimal !== ""): ?>
    <h2>Resultado:</h2>
    <p><?php echo htmlspecialchars($decimal) . " en binario es: " . $binario; ?></p>
  <?php endif; ?>
</body>
</html>