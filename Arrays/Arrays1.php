<HTML>
<HEAD><TITLE> EJ6B – Factorial</TITLE></HEAD>
<BODY>
<?php
$contador=0;
$factorial= 1;
$impares=[];
$num=1;
$sumatorio=0;
while ($contador <20) {
    if ($num%2!=0) {
        
        $impares[$contador]=$num;
        $contador++;
    }
    $num++;
}
echo "<h2>Tabla de Impares</h2>";
echo "<table border='1' cellpadding='6' cellspacing='0'>";
echo "<tr><th>Indice</th><th>Valor</th><th>Suma</th></tr>";


for ($i=0; $i <count($impares) ; $i++) { 
    $sumatorio+=$impares[$i];
    echo "<tr>";
    echo "<td>$i</td>";
    echo "<td>$impares[$i]</td>";
    echo "<td>$sumatorio</td>";
    echo "</tr>";
}
?>
</BODY>
</HTML>