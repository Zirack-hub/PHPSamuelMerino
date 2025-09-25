<HTML>
<HEAD><TITLE> EJ6B – Factorial</TITLE></HEAD>
<BODY>
<?php
$binarios=[];
$invertido=[];
$contador=0;

for ($i=0; $i <20 ; $i++) { 
    $binarios[$i]=decbin($i);
}
for ($i = count($binarios) - 1; $i >= 0; $i--) { 
    $invertido[$contador] = $binarios[$i];
    $contador++;
}

echo "<h2>Tabla de Impares</h2>";
echo "<table border='1' cellpadding='6' cellspacing='0'>";
echo "<tr><th>Indice</th><th>Binario</th><th>invertido</th></tr>";


for ($i=0; $i <count($binarios) ; $i++) { 
    echo "<tr>";
    echo "<td>$i</td>";
    echo "<td>$binarios[$i]</td>";
    echo "<td>$invertido[$i]</td>";
    echo "</tr>";
}
echo "</table>";
?>
</BODY>
</HTML>