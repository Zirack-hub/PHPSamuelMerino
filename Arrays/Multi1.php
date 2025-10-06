<HTML>
<HEAD><TITLE> EJ6B – Factorial</TITLE></HEAD>
<BODY>
<?php
$matriz = array();
$numero = 2;
for ($i=0; $i <3 ; $i++) { 
    for ($j=0; $j <3 ; $j++) { 
        $matriz [$i][$j] = $numero;
        $numero +=2;
    }
}
echo "<table border='1' cellpadding='5' cellspacing='0'>";
echo "<tr>";
echo "<th>Columna 1</th>";
echo "<th>Columna 2</th>";
echo "<th>Columna 3</th>";
echo "</tr>";
for ($i=0; $i <3 ; $i++) { 
    echo "<tr>";
    for ($j = 0; $j < 3; $j++) { 
        echo "<td>". $matriz[$i][$j] . "</td>";
    }
    echo "</tr>";
}
echo "</table>";
?>
</BODY>
</HTML>