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



$bin1 = str_pad(decbin($byte1), 8, "0", STR_PAD_LEFT);
$bin2 = str_pad(decbin($byte2), 8, "0", STR_PAD_LEFT);
$bin3 = str_pad(decbin($byte3), 8, "0", STR_PAD_LEFT);
$bin4 = str_pad(decbin($byte4), 8, "0", STR_PAD_LEFT);




echo "IP $ip en binario es $bin1.$bin2.$bin3.$bin4";
?>
</BODY>
</HTML>
