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
$networkbin   = str_pad(substr($binario, 0, $mascara), 32, "0", STR_PAD_RIGHT);

$networkdec   = bindec($networkbin);
$broadcastdec = bindec($broadcastbin);

$rangoadec = $networkdec + 1;
$rangobdec = $broadcastdec - 1;

$rangoabin = str_pad(decbin($rangoadec), 32, "0", STR_PAD_LEFT);
$rangobbin = str_pad(decbin($rangobdec), 32, "0", STR_PAD_LEFT);

$netbin1 = bindec(substr($networkbin, 0, 8));
$netbin2 = bindec(substr($networkbin, 8, 8));
$netbin3 = bindec(substr($networkbin, 16, 8));
$netbin4 = bindec(substr($networkbin, 24, 8));
$network = "$netbin1.$netbin2.$netbin3.$netbin4";

$rangoabin1 = bindec(substr($rangoabin, 0, 8));
$rangoabin2 = bindec(substr($rangoabin, 8, 8));
$rangoabin3 = bindec(substr($rangoabin, 16, 8));
$rangoabin4 = bindec(substr($rangoabin, 24, 8));
$rangoa = "$rangoabin1.$rangoabin2.$rangoabin3.$rangoabin4";

$brodbin1 = bindec(substr($broadcastbin, 0, 8));
$brodbin2 = bindec(substr($broadcastbin, 8, 8));
$brodbin3 = bindec(substr($broadcastbin, 16, 8));
$brodbin4 = bindec(substr($broadcastbin, 24, 8));
$broadcast = "$brodbin1.$brodbin2.$brodbin3.$brodbin4";

$rangobbin1 = bindec(substr($rangobbin, 0, 8));
$rangobbin2 = bindec(substr($rangobbin, 8, 8));
$rangobbin3 = bindec(substr($rangobbin, 16, 8));
$rangobbin4 = bindec(substr($rangobbin, 24, 8));
$rangob = "$rangobbin1.$rangobbin2.$rangobbin3.$rangobbin4";

echo "IP $ip en binario es $bin1.$bin2.$bin3.$bin4<br>";
echo "La IP es $ip<br>";
echo "La máscara es: /$mascara<br>";
echo "La dirección de Red es: $network<br>";
echo "La dirección de broadcast es: $broadcast<br>";
echo "El rango de direcciones es de: $rangoa hasta $rangob";
?>
</BODY>
</HTML>
