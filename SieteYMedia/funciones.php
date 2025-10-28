<?php

function limpiar($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

function robarCarta(&$baraja, &$jugador) {
    $carta = array_rand($baraja);
    $jugador[$carta] = $baraja[$carta];
    unset($baraja[$carta]);
}

function contarMano(&$jugador){
    $total =0;
    foreach ($jugador as $valor){
        $total += $valor;
    };
    return $total;
}

function extraerIniciales($nombre){ 
    $nomap = preg_split('/\s+/', trim($nombre));
    $inicial = $nomap[0][0]; 
    $inicial .= $nomap[1][0]; 
    return strtoupper($inicial); 
}


function ganadores($manos){

    $ganadores = array_filter($manos, function($valor){
        return $valor <= 7.5;
    });
    
    arshort($ganadores);
    $ganadores = array_filter($ganadores, function($valor){
        return $valor == $ganadores[0] ;
    });
    print_r($ganadres);
    return $ganadores;
}

function dineroRepartir($apuesta, $ganadores){
    if ($ganadores == null) {
        echo " no hay ganadores la casa se queda con todo";
    }else if ($ganadores[0] == 7.5){
        if (c) {
            # code...
        }
        echo "El jugador recibe ". $apuesta*0.8;

    }
}



?>