<?php

function limpiar(&$data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
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
    }
    return $total;
}

function extraerIniciales($nombre){ 
    $nomap = preg_split('/\s+/', trim($nombre));
    $inicial = $nomap[0][0]; 
    $inicial .= $nomap[1][0]; 
    return strtoupper($inicial); 
}


function ganadores($mano1, $mano2, $mano3, $mano4){
    $manos = [
        'j1' => $mano1,
        'j2' => $mano2,
        'j3' => $mano3,
        'j4' => $mano4,
    ];
    $valor_max =0;
    $ganadores = [];
    foreach ($manos as $jugador => $valor) {
        if($valor <=7.5){
            if($valor > $valor_max)
                $valor_max = $valor;
                $ganadores[$jugador] =$valor;
        }elseif ($valor == $valor_max){
            $ganadores[$jugador] = $valor;
        }
    }

     return $ganadores;
}

function dineroRepartir($apuesta, $ganadores){

}



?>