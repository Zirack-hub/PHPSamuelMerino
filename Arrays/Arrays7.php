<HTML>
<HEAD><TITLE> EJ6B – Factorial</TITLE></HEAD>
<BODY>
<?php

$alumnos=array("Charlie"=> 18,
                "Samuel" => 28,
                "Rizwan"=> 68,
                "Alvaro"=> 19,
                "Carlos"=> 20);
$unionb=array();


foreach ($alumnos as $alumno => $edad) {
    echo "$alumno $edad <br>";
}

echo "<h3>Segunda posición:</h3>";
reset($alumnos);
next($alumnos);
$segundo = current($alumnos);
$nombre_segundo = key($alumnos);
echo "Nombre: $nombre_segundo - Edad: $segundo <br>";

echo "<h3>Tercera posición:</h3>";
next($alumnos);
$tercero = current($alumnos);
$nombre_tercero = key($alumnos);
echo "Nombre: $nombre_tercero - Edad: $tercero <br>";

echo "<h3>Última posición:</h3>";
end($alumnos);
$ultimo = current($alumnos);
$nombre_ultimo = key($alumnos);
echo "Nombre: $nombre_ultimo - Edad: $ultimo <br>";

echo "<h3>Ordenar el Array</h3>";
asort($alumnos);
reset($alumnos);
echo key($alumnos). " Tiene: ". current($alumnos);
end($alumnos);
echo "<br>";
echo key($alumnos). " Tiene: ". current($alumnos);

?>
</BODY>
</HTML>