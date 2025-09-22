<HTML>
<HEAD><TITLE> EJ2-Direccion Red – Broadcast y Rango</TITLE></HEAD>
<BODY>
<?php
$ip="192.168.16.100/16";
$p1 = strpos($ip, ".");                  
$p2 = strpos($ip, ".", $p1 + 1);         
$p3 = strpos($ip, ".", $p2 + 1);       
$barra =strpos ($ip, "/");  

$byte1 = (int)substr($ip, 0, $p1);                
$byte2 = (int)substr($ip, $p1 + 1, $p2 - $p1 - 1);
$byte3 = (int)substr($ip, $p2 + 1, $p3 - $p2 - 1);
$byte4 = (int)substr($ip, $p3 + 1, $barra-1);    
echo "El byte 4 es : ". $byte4 . "<br>";           
$mascara = (int)substr($ip , $barra +1);
echo "La mascara es: ". $mascara . "<br>";

$bin1 = sprintf("%08b", $byte1);
$bin2 = sprintf("%08b", $byte2);
$bin3 = sprintf("%08b", $byte3);
$bin4 = sprintf("%08b", $byte4);

$binario = "$bin1$bin2$bin3$bin4";

$broadcastbin = str_pad(substr($binario, 0, $mascara), 32, "1", STR_PAD_RIGHT);
$networkbin = str_pad(substr($binario, 0, $mascara), 32, "0", STR_PAD_RIGHT);


echo "$broadcastbin". "<br>";
echo "$networkbin". "<br>";

$netbin1= (int)substr($networkbin, 0, 7);
$netbin2= (int)substr($networkbin, 8, 15);
$netbin3= (int)substr($networkbin, 16, 23);
$netbin4= (int)substr($networkbin, 24, 31);
$network = "$netbin1.$netbin2.$netbin3.$netbin4"


$brodbin1 = bindec(substr($broadcastbin, 0, 7));
$brodbin2 = bindec(substr($broadcastbin, 8, 15));
$brodbin3 = bindec(substr($broadcastbin, 16, 23));
$brodbin4 = bindec(substr($broadcastbin, 24, 31));

$broadcast = "$brodbin1.$brodbin2.$brodbin3.$brodbin4";




echo "IP $ip en binario es $bin1.$bin2.$bin3.$bin4";
echo "La IP es $ip";
echo "La mascara es: $mascara";
echo "La direccion de Red es: $network";
echo"La direccion de broadcast es: $broadcast";

?>
</BODY>
</HTML>