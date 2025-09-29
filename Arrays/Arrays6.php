<HTML>
<HEAD><TITLE> EJ6B – Factorial</TITLE></HEAD>
<BODY>
<?php
$asignaturas1 = ["Bases Datos", "Entornos Desarrollo", "Programación"];
$asignaturas2 = ["Sistemas Informáticos", "FOL", "Mecanizado"];
$asignaturas3 = ["Desarrollo Web ES", "Desarrollo Web EC", "Despliegue", "Desarrollo Interfaces", "Inglés"];
$union=[];
$unionb=[];
$contador=count($asignaturas1)+count($asignaturas2)+count($asignaturas3);
$cont1=0;
$cont2=0;
$union = array_merge($asignaturas1, $asignaturas2, $asignaturas3);
$eliminar= array_search("Mecanizado", $union);

for ($i=$eliminar; $i < count($union)-1; $i++) { 
    $union[$i]=$union[$i+1];
    
}
unset($union[count($union)-1]);
$unionb = array_reverse($union);
echo "Union A: <br>";
print_r($union);
echo "<br>";
echo "Union B: <br>";
print_r($unionb);


?>
</BODY>
</HTML>