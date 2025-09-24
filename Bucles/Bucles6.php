<HTML>
<HEAD><TITLE> EJ6B – Factorial</TITLE></HEAD>
<BODY>
<?php
$num=5;
$factorial= 1;
echo "$num!= ";
for ($i=$num; $i >= 1; $i--) { 
    echo "$i";
    if ($i> 1) {
        echo "x";
    }
    $factorial *=$i;
}
echo " =$factorial";
?>
</BODY>
</HTML>