<?php


require_once("./funciones.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

   $j1 = limpiar($_POST['nombre1']);
   $j2 = limpiar($_POST{'nombre2'});
   $j3 = limpiar($_POST{'nombre3'});
   $j4 = limpiar($_POST{'nombre4'});
   $cartas = (int)limpiar($_POST{'numcartas'});
   $apuesta = limpiar($_POST{'apuesta'});
   $baraja =[
    '1C' => 1, '1D' =>1, '1T' =>1, '1P' =>1,
    '2C' => 2, '2D' =>2, '2T' =>2, '2P' =>2,
    '3C' => 3, '3D' =>3, '3T' =>3, '3P' =>3,
    '4C' => 4, '4D' =>4, '4T' =>4, '4P' =>4,
    '5C' => 5, '5D' =>5, '5T' =>5, '5P' =>5,
    '6C' => 6, '6D' =>6, '6T' =>6, '6P' =>6,
    '7C' => 7, '7D' =>7, '7T' =>7, '7P' =>7,
    'JC' => 0.5, 'JD' =>0.5, 'JT' =>0.5, 'JP' =>0.5,
    'QC' => 0.5, 'QD' =>0.5, 'QT' =>0.5, 'QP' =>0.5,
    'KC' => 0.5, 'KD' =>0.5, 'KT' =>0.5, 'KP' =>0.5,
    ];

    $j1ARR =array();
    $j2ARR =array();
    $j3ARR =array();
    $j4ARR =array();

    for ($i=0; $i < $cartas ; $i++) { 
        robarCarta($baraja, $j1ARR);
    };

    for ($i=0; $i < $cartas ; $i++) { 
        robarCarta($baraja, $j2ARR);
    };

    for ($i=0; $i < $cartas ; $i++) { 
        robarCarta($baraja, $j3ARR);
    };

    for ($i=0; $i < $cartas ; $i++) { 
        robarCarta($baraja, $j4ARR);
    };

    $mano1=contarMano($j1ARR);
    $mano2=contarMano($j2ARR);
    $mano3=contarMano($j3ARR);
    $mano4=contarMano($j4ARR);

    $ganadores=ganadores($mano1,$mano2,$mano3,$mano4);

}








?>