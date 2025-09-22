<HTML>
<HEAD><TITLE> EJ1-Conversion IP Decimal a Binario </TITLE></HEAD>
<BODY>
<?php
$ip = "192.18.16.204";


$p1 = strpos($ip, ".");                  
$p2 = strpos($ip, ".", $p1 + 1);         
$p3 = strpos($ip, ".", $p2 + 1);         

$byte1 = (int)substr($ip, 0, $p1);                
$byte2 = (int)substr($ip, $p1 + 1, $p2 - $p1 - 1);
$byte3 = (int)substr($ip, $p2 + 1, $p3 - $p2 - 1);
$byte4 = (int)substr($ip, $p3 + 1);               


$bin1 = sprintf("%08b", $byte1);
$bin2 = sprintf("%08b", $byte2);
$bin3 = sprintf("%08b", $byte3);
$bin4 = sprintf("%08b", $byte4);


echo "IP $ip en binario es $bin1.$bin2.$bin3.$bin4";
?>
</BODY>
</HTML>
