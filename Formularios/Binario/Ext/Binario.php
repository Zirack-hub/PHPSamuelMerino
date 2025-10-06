<?php

function limpiar(&$data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
}

$decimal = $_REQUEST['decimal'];
limpiar($decimal);
$binario = decbin($decimal);



?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Resultado Binario</title>
</head>
<body>
  <h1>Convertidor de Decimal a Binario</h1>

  <!-- Mostrar resultado -->
  <?php if ($decimal !== ""): ?>
    <h2>Resultado:</h2>
    <p><?php echo htmlspecialchars($decimal) . " en binario es: " . $binario; ?></p>
  <?php endif; ?>
</body>
</html>