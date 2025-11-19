<?php
require_once ("./funciones.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

   $j1 = limpiar($_POST['nombre1']);
   $j2 = limpiar($_POST{'nombre2'});
   $j3 = limpiar($_POST{'nombre3'});
   $j4 = limpiar($_POST{'nombre4'});
   $apuesta = limpiar($_POST{'apuesta'});

   $baraja =[
    '1C' => 1, '1D' =>1, '1T' =>1, '1P' =>1,
    '2C' => 1, '2D' =>1, '2T' =>1, '2P' =>1,
    '3C' => 10, '3D' =>10, '3T' =>10, '3P' =>10,
    '4C' => 4, '4D' =>4, '4T' =>4, '4P' =>4,
    '5C' => 5, '5D' =>5, '5T' =>5, '5P' =>5,
    '6C' => 6, '6D' =>6, '6T' =>6, '6P' =>6,
    '7C' => 7, '7D' =>7, '7T' =>7, '7P' =>7,
    'JC' => 10, 'JD' =>10, 'JT' =>10, 'JP' =>10,
    'QC' => 10, 'QD' =>10, 'QT' =>10, 'QP' =>10,
    'KC' => 10, 'KD' =>10, 'KT' =>10, 'KP' =>10,
    ];
    
    $jugadores = crearJugadores($j1,$j2,$j3,$j4);
    repartirMano ($baraja, $jugadores);
    
    calcularPuntos($jugadores);
    encontrarJugada($jugadores);
    $pganadores=mejorPuntuacion($jugadores);
    $jganadores=ganadorJugada($jugadores);
    repartirDinero($pganadores, $jganadores, $apuesta);
    mostrarCartas($jugadores);
    generarFichero($jugadores, $jganadores,$pganadores, $apuesta);
    
    






}




?>