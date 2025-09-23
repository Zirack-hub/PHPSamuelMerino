<HTML>
<HEAD><TITLE> EJ2-Direccion Red – Broadcast y Rango</TITLE></HEAD>
<BODY>
<?php
$ip="192.168.16.100/16";
$p1 = strpos($ip, ".");                  
$p2 = strpos($ip, ".", $p1 + 1);         
$p3 = strpos($ip, ".", $p2 + 1);       
$barra = strpos($ip, "/");  

$byte1 = (int)substr($ip, 0, $p1);                
$byte2 = (int)substr($ip, $p1 + 1, $p2 - $p1 - 1);
$byte3 = (int)substr($ip, $p2 + 1, $p3 - $p2 - 1);    
$byte4 = (int)substr($ip, $p3 + 1, $barra - $p3 - 1);  

$mascara = (int)substr($ip, $barra +1);

$bin1 = sprintf("%08b", $byte1);
$bin2 = sprintf("%08b", $byte2);
$bin3 = sprintf("%08b", $byte3);
$bin4 = sprintf("%08b", $byte4);

$binario = "$bin1$bin2$bin3$bin4";

$broadcastbin = str_pad(substr($binario, 0, $mascara), 32, "1", STR_PAD_RIGHT);
$rangoa = $broadcastbin+1;
$networkbin = str_pad(substr($binario, 0, $mascara), 32, "0", STR_PAD_RIGHT);
$rangob = $networkbin-1;

$netbin1 = bindec(substr($networkbin, 0, 8));
$netbin2 = bindec(substr($networkbin, 8, 8));
$netbin3 = bindec(substr($networkbin, 16, 8));
$netbin4 = bindec(substr($networkbin, 24, 8));
$network = "$netbin1.$netbin2.$netbin3.$netbin4";

$rangoabin1 = bindec(substr($rangoa, 0, 8));
$rangoabin2 = bindec(substr($rangoa, 8, 8));
$rangoabin3 = bindec(substr($rangoa, 16, 8));
$rangoabin4 = bindec(substr($rangoa, 24, 8));
$rangoa = "$rangoabin1.$rangoabin2.$rangoabin3.$rangoabin4";

$brodbin1 = bindec(substr($broadca  stbin, 0, 8));
$brodbin2 = bindec(substr($broadcastbin, 8, 8));
$brodbin3 = bindec(substr($broadcastbin, 16, 8));
$brodbin4 = bindec(substr($broadcastbin, 24, 8));
$broadcast = "$brodbin1.$brodbin2.$brodbin3.$brodbin4";

echo "IP $ip en binario es $bin1.$bin2.$bin3.$bin4<br>";
echo "La IP es $ip<br>";
echo "La mascara es: $mascara<br>";
echo "La direccion de Red es: $network<br>";
echo "La direccion de broadcast es: $broadcast<br>";
?>
</BODY>
</HTML>
