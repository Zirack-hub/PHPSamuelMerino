<HTML>
<HEAD>
    <TITLE>EJ5B – Tabla multiplicar con TD</TITLE>
</HEAD>
<BODY>
<?php
$num = "8";
$multiplicador = 1;

echo "<h2>Tabla de multiplicar del $num</h2>";
echo "<table border='1' cellpadding='6' cellspacing='0'>";
echo "<tr><th>Operación</th><th>Resultado</th></tr>";

while ($multiplicador <= 10) {
    $resultado = $num * $multiplicador;
    echo "<tr>";
    echo "<td>$num x $multiplicador</td>";
    echo "<td>$resultado</td>";
    echo "</tr>";
    $multiplicador++;
}

echo "</table>";
?>
</BODY>
</HTML>
