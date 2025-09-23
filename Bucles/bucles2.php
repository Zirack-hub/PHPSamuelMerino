<HTML>
<HEAD><TITLE> EJ2B – Conversor Decimal a base n </TITLE></HEAD>
<BODY>
<?php
$num="48";
 $base="8";
$resultado="";
$numcalc=$num;
while ($num>=1) {
    $resultado=$num%$base . $resultado;

    $num=(int)($num/$base);
}
echo "El número " . $numcalc . " en base " . $base . " es: " . $resultado;
?>
</BODY>
</HTML>