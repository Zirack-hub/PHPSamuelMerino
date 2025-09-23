<HTML>
<HEAD><TITLE> EJ3B – Conversor Decimal a base 16</TITLE></HEAD>
<BODY>
<?php
$num="255";
 $base="16";
 $resultado="";
$numcalc=$num;
while ($num>=1) {
    $resto = $num%$base;

    switch ($resto){
        case 10 : $digito = "A"; break;
        case 11 : $digito = "B"; break;
        case 12 : $digito = "C"; break;
        case 13 : $digito = "D"; break;
        case 14 : $digito = "E"; break;
        case 15 : $digito = "F"; break;
        default: $digito = $resto; break;
    }
    $resultado = $digito . $resultado;
    $num=(int)($num/$base);
}
echo "El número " . $numcalc . " en base " . $base . " es: " . $resultado;
?>
</BODY>
</HTML>