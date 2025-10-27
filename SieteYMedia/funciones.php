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
    return $valor;
}
?>