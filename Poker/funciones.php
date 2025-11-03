<?php

function limpiar($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
function robarCarta(&$baraja){

    $poscart = array_rand($baraja);
    $carta = $baraja[$poscart];
    unset($baraja[$poscart]);
    return $carta;


}

function calcularPoker ($jugadores){
    $poker = false;
    foreach ($jugadores as $jugador) {
        $valor = substr($jugador["cartas"][0],0,1); 
        if (($valor ==substr($jugador["cartas"][1],0,1))
            &&($valor ==substr($jugador["cartas"][2],0,1))
            &&($valor ==substr($jugador["cartas"][3],0,1))) {
            $jugador["poker"] = true;
        }else $jugador["poker"] = false;      
    }
    

    
return $jugadores;
}


?>