<HTML>
<HEAD><TITLE> EJ1-Conversion IP Decimal a Binario </TITLE></HEAD>
<BODY>
<?php
$ip="192.18.16.204";
$byte1= (int)substr($ip,0,strpos($ip,"."));
$byte2 = (int)substr($ip,strpos($ip,".")+1,strpos($ip,".",strpos($ip,".")));
$byte3 = (int)substr($ip,strpos($ip,".")+1,strpos($ip,".",strpos($ip,".")));

echo $byte1 . "<br>";
echo $byte2 . "<br>";
?>
</BODY>
</HTML>