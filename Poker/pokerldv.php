<?php


require_once("./funciones.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
   main();
}


function main(){
    $j1 = limpiar($_POST['nombre1']);
    $j2 = limpiar($_POST{'nombre2'});
    $j3 = limpiar($_POST{'nombre3'});
    $j4 = limpiar($_POST{'nombre4'});
    $apuesta = limpiar($_POST{'bote'});

   
    $baraja = [
        "1C1", "1C2", "1D1", "1D2",
        "1P1", "1P2", "1T1", "1T2",
        "JC1", "JC2", "JD1", "JD2",
        "JP1", "JP2", "JT1", "JT2",
        "KC1", "KC2", "KD1", "KD2",
        "KP1", "KP2", "KT1", "KT2",
        "QC1", "QC2", "QD1", "QD2",
        "QP1", "QP2", "QT1", "QT2"
    ];

    $nombres = [$j1, $j2, $j3, $j4];

    $jugadores= array();

    for ($j=0; $j < 4; $j++) {
        $jugadores[$j]["nombre"] = $nombres[$j];
        for ($i=0; $i < 4 ; $i++) { 
            $jugadores[$j]["cartas"][$i] = robarCarta($baraja);
        }
    }

   
   
   foreach ($jugadores as $jugador) {
    print ($jugador["nombre"]."<br>");
    foreach ($jugador["cartas"] as $carta) {
        print($carta);
        echo " ";
    }
    echo "<br>";
    echo "<br>";
   };

   

$resultadoPoker = calcularPoker($jugadores);
print_r($resultadoPoker);
}



?>