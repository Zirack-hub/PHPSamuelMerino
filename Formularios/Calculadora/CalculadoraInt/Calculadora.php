<?php

function limpiar_campos($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

function sumar($a,$b) {
    return $a+$b;
}

function restar($a,$b) {
    return $a-$b;
}

function multiplicar($a,$b) {
    return $a*$b;
}

function dividir($a,$b) {
   if ($b == 0) return "Error: no se puede dividir entre 0";
    return $a / $b;
}

$resultado = "";
$signo = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $num1 = limpiar_campos($_REQUEST['num1']);
  $num2 = limpiar_campos($_REQUEST['num2']);
  $operacion = limpiar_campos($_REQUEST['operacion']);

    switch ($operacion) {
        case 'suma':
            $resultado = sumar($num1, $num2);
            $signo = '+';
            break;
        case 'restar':
            $resultado = restar($num1, $num2);
            $signo = '-';
            break;
        case 'multiplicar':
            $resultado = multiplicar($num1, $num2);
            $signo = '*';
            break;
        case 'division':+
            $resultado = dividir($num1, $num2);
            $signo = '/';
            break;
        default:
            $resultado = "Operación no válida";
            $signo = '?';
            break;
    }
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Calculadora en un solo archivo</title>
</head>
<body>
  <h1>CALCULADORA</h1>

  <!-- Formulario -->
  <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    <label>Primer número:</label>
    <input type="number" name="num1" required><br><br>

    <label>Segundo número:</label>
    <input type="number" name="num2" required><br><br>

    <label>Operación:</label>
    <select name="operacion" required>
      <option value="suma">Suma (+)</option>
      <option value="resta">Resta (-)</option>
      <option value="multiplicacion">Multiplicación (*)</option>
      <option value="division">División (/)</option>
    </select><br><br>

    <input type="submit" value="Calcular">
  </form>

  <!-- Resultado -->
  <?php if ($resultado !== ""): ?>
    <h2>Resultado:</h2>
    <p><?php echo "$num1 $signo $num2 = $resultado"; ?></p>
  <?php endif; ?>

</body>
</html>
