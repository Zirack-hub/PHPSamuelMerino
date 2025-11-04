<?php

function limpiar($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

function crearJugadores ($j1,$j2,$j3,$j4){
    for ($i=1; $i <5 ; $i++) { 
        $jugadores[] = ${"jugador$i"} = array('nombre' => ${"j$i"},
                                              'cartas'=> [],
                                              'jugada'=> null,
                                              'puntos'=> null);
    }
    return $jugadores;
}    

function repartirMano ($baraja, &$jugadores){
    for ($j=0; $j <count($jugadores) ; $j++) { 
        
    
        for ($i=0; $i<4 ;$i++) {
            $carta = array_rand($baraja);
            $jugadores[$j]['cartas'][$carta] =$baraja[$carta];
            unset($baraja[$carta]);

        }
    }
}

function calcularPuntos (&$jugadores){
    foreach ($jugadores as &$jugador) {
        $puntuacion =0;
        foreach ($jugador['cartas'] as $carta=>$puntos) {
            $puntuacion+=$puntos;

        }
        $jugador['puntos']=$puntuacion;
    }
}


function encontrarJugada(&$jugadores){
    foreach ($jugadores as &$jugador) {
        $valores = array();
        foreach ($jugador['cartas'] as $carta=>$puntos) {
            array_push($valores,$carta[0]);
        }
        $repeticiones = array_count_values($valores);
        $jugador['jugada']=elegirJugada($repeticiones);
    }
}

function elegirJugada($repeticiones){
    rsort($repeticiones);
    $jugada=0;
    
    if(count($repeticiones)>1){
        if($repeticiones[0]==2 && $repeticiones[1]==2){
            $jugada=2;
        }elseif ($repeticiones[0]==2) {
            $jugada=1;
        }elseif($repeticiones[0]==3){
            $jugada =3;
        }
    }else{
        $jugada=4;
    }
    return $jugada;
}

function mejorPuntuacion($jugadores){
    foreach
}
?>