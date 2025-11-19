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
    $puntitos = array();
    $ganadores = array();
    foreach ($jugadores as $jugador) {
        
            array_push($puntitos, $jugador['puntos']);
        
    }

    $puntitos=array_filter($puntitos, function($valor){
        return $valor <= 40;
    });
    if (in_array(31, $puntitos)) {
        $puntitos=array_filter($puntitos, function($valor){
        return $valor == 31;
    });
    }elseif (in_array(40, $puntitos)) {
        $puntitos=array_filter($puntitos, function($valor){
        return $valor == 40;
    });
    }
     $maxValor=max($puntitos);
    foreach ($jugadores as $jugador) {
        if ($jugador['puntos']==$maxValor){
            array_push($ganadores, $jugador);
        }
    }

    return $ganadores;
}

function ganadorJugada($jugadores){
    $maxJugada=0;
    $jugadas=array();
    $ganadores=array();
    foreach ($jugadores as $jugador) {
        array_push($jugadas, $jugador['jugada']);
    }
    $maxJugada=max($jugadas);
    foreach ($jugadores as $jugador) {
        if($jugador['jugada']==$maxJugada){
            array_push($ganadores, $jugador);
        }
    }

    return $ganadores;
}

function repartirDinero($pganadores, $jganadores, $apuesta){
    echo"Ganador por <b>Puntos</b>: ";
    echo"<br>";
    if(count($pganadores)>1){
        echo "-Los ganadores ";
        foreach ($pganadores as $ganador) {
            echo $ganador['nombre'];
            echo " ";
        }
        echo" Han ganado ". $apuesta/2/count($pganadores);
    }else{
        echo"-El jugador ". $pganadores[0]['nombre']." ha ganado ". $apuesta/2;
    }
     echo"<br>";
     echo "------------------------------------------------------------------";
     echo"<br>";
     echo"Ganador por <b>Jugada</b>: ";
     echo"<br>";
     if(count($jganadores)>1){
        echo "-Los ganadores ";
        foreach ($jganadores as $ganador) {
            echo $ganador['nombre'];
            echo " ";
        }
        echo" Han ganado ". $apuesta/2/count($jganadores);
    }else{
        echo"-El jugador ". $jganadores[0]['nombre']." ha ganado ". $apuesta/2;
    }
}

function mostrarCartas($jugadores) {
    echo "<table border='1' cellpadding='5'>";

    foreach ($jugadores as $jugador) {
        echo "<tr>";
        echo "<td>" . $jugador['nombre'] . "</td>";
        foreach ($jugador['cartas'] as $carta=>$valor) {
            $ruta = "./images/" . $carta . ".PNG";
            echo "<td><img src='$ruta' alt='$carta' width='80' height='120'></td>";
        }
    }    
}


function generarFichero($jugadores, $jganadores,$pganadores, $premio){
    $mitad= $premio/2;
    $fecha = date("d-m-Y-H-i-s");
    if (!empty($jganadores)){
        $repartidoj = $premio /2/ count($jganadores);
    }else{
        $repartidoj=0;
    }
    $premiosj = count($jganadores);
    if (!empty($pganadores)){
        $repartidop = $premio /2/ count($pganadores);
    }else{
        $repartidop=0;
    }
    $premiosp = count($pganadores);
   $archivo = "";
    $archivo .= "PUNTUACIONES: \n";
    foreach ($jugadores as $jugador) {
        $premiop=0;
        foreach ($pganadores as $ganador) {
            if($jugador['nombre']==$ganador['nombre']){
            $premiop= $repartidop;
            }
        }
        $archivo .= $jugador['nombre'] . '##' . $jugador['puntos'] . '##' . $premiop . "\n";
    }
    $archivo .= "TOTAL PREMIOS PUNTUACION##$premiosp##$mitad\n";
    $archivo .= "\n";
    $archivo .= "JUGADAS: \n";
    foreach ($jugadores as $jugador) {
        $premioj=0;
        foreach ($jganadores as $ganador) {
            if($jugador['nombre']==$ganador['nombre']){
            $premioj= $repartidoj;
            }
        }
        $archivo .= $jugador['nombre'] . '##' . $jugador['puntos'] . '##' . $premioj . "\n";
    }
    $archivo .= "TOTAL PREMIOS JUGADA##$premiosj##$mitad\n";
    
    $f1 = fopen("./ficheros/$fecha.txt", "a+");
    fwrite($f1, $archivo);
    fclose($f1);
}
?>