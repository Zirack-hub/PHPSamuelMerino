<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Combinados</title>
</head>
<body>
  <h1>Combinados</h1>

  <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
      <label>Primer número:</label>
      <input type="number" name="num" required><br><br>


      <label>Operación:</label>
      <select name="operacion" required>
        <option value ="bin">Binario (2)</option>
        <option value="octal">Octal (8)</option>
        <option value="hexa">Hexadecimal (16)</option>
        <option value="todos">Todos (2, 8, 16)</option>
      </select><br><br>

    <input type="submit" value="Calcular">
  </form>
</body>
</html>

<?php
 $num= 0;
 $operacion="";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $num = $_REQUEST['num'];
    $operacion = $_REQUEST['operacion'] ?? '';
    $num = limpiar_campos($num);
    $operacion = limpiar_campos($operacion);
}

$num = limpiar_campos($num);
$operacion = limpiar_campos($operacion);


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
  <title>Resultado</title>
</head>
<body>
  <h1>Cambio de Base</h1>
  <p><?php 
    echo '<label>Primer número:</label>';
    echo  "<input type='number' name='num' value = '$num' required><br><br>";
switch ($operacion) {
    case 'bin':
        echo '<table border="1">';
        echo "<tr><th>Base</th><th>Valor</th></tr>";
        echo "<tr><td>Decimal</td><td>$num</td></tr>";
        echo "<tr><td>Binario</td><td>" . decbin($num) . "</td></tr>";
        echo '</table>';
        break;

    case 'octal':
        echo '<table border="1">';
        echo "<tr><th>Base</th><th>Valor</th></tr>";
        echo "<tr><td>Decimal</td><td>$num</td></tr>";
        echo "<tr><td>Octal</td><td>" . decoct($num) . "</td></tr>";
        echo '</table>';
        break;

    case 'hexa':
        echo '<table border="1">';
        echo "<tr><th>Base</th><th>Valor</th></tr>";
        echo "<tr><td>Decimal</td><td>$num</td></tr>";
        echo "<tr><td>Hexadecimal</td><td>" . dechex($num) . "</td></tr>";
        echo '</table>';
        break;

    case 'todos':
        echo '<table border="1">';
        echo "<tr><th>Base</th><th>Valor</th></tr>";
        echo "<tr><td>Decimal</td><td>$num</td></tr>";
        echo "<tr><td>Binario</td><td>" . decbin($num) . "</td></tr>";
        echo "<tr><td>Octal</td><td>" . decoct($num) . "</td></tr>";
        echo "<tr><td>Hexadecimal</td><td>" . dechex($num) . "</td></tr>";
        echo '</table>';
        break;

    default:
        echo "Operación no válida";
        break;
}

   ?></p>
</body>
</html>

