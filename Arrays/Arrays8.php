<HTML>
<HEAD><TITLE> EJ6B – Factorial</TITLE></HEAD>
<BODY>
<?php
$media =0.0;
$notas=array("Charlie"=> 7,
                "Samuel" => 7,
                "Rizwan"=> 5,
                "Alvaro"=> 4,
                "Martin"=> 8);
$unionb=array();





echo "<h3>Ordenar el Array</h3>";
asort($notas);
reset($notas);
echo key($notas). " Tiene: ". current($notas);
end($notas);
echo "<br>";
echo key($notas). " Tiene: ". current($notas);

foreach ($notas as $nombre => $nota) {
    $media += $nota;
}
echo "<br>";
echo "La nota media de los alumnos es de: ".$media/count($notas);
?>
</BODY>
</HTML>