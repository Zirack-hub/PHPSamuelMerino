<?php
$num1 = $_REQUEST['num1'];
$num2 = $_REQUEST['num2'];
$operacion = $_REQUEST['operacion'] ?? '';

limpiar_campos($num1);
limpiar_campos($num2);
limpiar_campos($operacion);


function limpiar_campos($data) { //Evita la Injección de Código
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

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
    return $a/$b;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Resultado</title>
</head>
<body>
  <h1>CALCULADORA</h1>
  <p><?php echo "$num1 $signo $num2 = $resultado"; ?></p>
  <a href="./CalculadoraExterno.html">Volver</a>
</body>
</html>
