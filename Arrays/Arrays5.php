<HTML>
<HEAD><TITLE> EJ6B – Factorial</TITLE></HEAD>
<BODY>
<?php
$asignaturas1 = ["Bases Datos", "Entornos Desarrollo", "Programación"];
$asignaturas2 = ["Sistemas Informáticos", "FOL", "Mecanizado"];
$asignaturas3 = ["Desarrollo Web ES", "Desarrollo Web EC", "Despliegue", "Desarrollo Interfaces", "Inglés"];
$union=[];
$unionb=[];
$unionc=[];
$contador=count($asignaturas1)+count($asignaturas2)+count($asignaturas3);
$cont1=0;
$cont2=0;
$cont3=0;


for ($i = 0; $i < $contador; $i++) { 
    if ($cont1 < count($asignaturas1)) {
        $union[$i] = $asignaturas1[$cont1];
        $cont1++;
    } elseif ($cont2 < count($asignaturas2)) {
        $union[$i] = $asignaturas2[$cont2];
        $cont2++;
    } elseif ($cont3 < count($asignaturas3)) {
        $union[$i] = $asignaturas3[$cont3];
        $cont3++;
    }
}

echo "Union A: <br>";
print_r($union);
echo "<br>";
$unionb = array_merge($asignaturas1, $asignaturas2, $asignaturas3);
echo "Union B: <br>";
print_r($unionb);
echo "<br>";
echo "Union C: <br>";
array_push($unionc, ...$asignaturas1, ...$asignaturas2, ...$asignaturas3);
print_r($unionc);
echo "<br>";

?>
</BODY>
</HTML>