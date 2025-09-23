<HTML>
<HEAD><TITLE> EJ1B – Conversor decimal a binario</TITLE></HEAD>
<BODY>
<?php
$num="168";
$numOriginal = $num;
$binario="";
while ($num>=1) {
    $binario=$num%2 . $binario;
    $num=(int)($num/2);
}
echo "El número $numOriginal en binario es: " . $binario;
?>
</BODY>
</HTML>