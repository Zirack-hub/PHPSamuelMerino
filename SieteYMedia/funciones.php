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
    $ganadores = array();
    $ganadores = array_filter($manos, function($valor){
        return $valor <= 7.5;
    });

    echo "\n";

    if (empty($ganadores)) {
        echo "No hay ganadores (todos se pasaron de 7.5)\n";
        return [];
    }
    //  Obtener el valor máximo
    $valor_max = max($ganadores);
    //  Filtrar solo los jugadores con ese valor máximo
    $ganadores = array_filter($ganadores, function($valor) use ($valor_max) {
        return $valor == $valor_max;
    });

    //  Mostrar resultados
    return $ganadores;
}

function mostrarCartas($j1, $j2, $j3, $j4, $j1ARR, $j2ARR, $j3ARR, $j4ARR) {
    // Unificamos los jugadores y sus cartas
    $jugadores = [
        $j1 => $j1ARR,
        $j2 => $j2ARR,
        $j3 => $j3ARR,
        $j4 => $j4ARR
    ];

    echo '<table border="1" cellpadding="8" cellspacing="0" style="border-collapse:collapse; text-align:center; margin:auto;">';
    echo '<th>Jugador</th>';
    echo '<th colspan="10">Cartas</th>'; // Hasta 10 columnas de cartas
    echo '</tr>';

    foreach ($jugadores as $nombre => $cartas) {
        echo "<tr>";
        echo "<td style='font-weight:bold; background-color:#f9f9f9;'>$nombre</td>";

        if (!empty($cartas)) {
            foreach ($cartas as $carta => $valor) {
                $ruta = "./images/" . $carta . ".png";
                echo "<td><img src='$ruta' alt='$carta' width='80' height='120'></td>";
            }
        } else {
            echo "<td colspan='10' style='color:gray;'>Sin cartas</td>";
        }

        echo "</tr>";
    }

    echo "</table>";
}



function dineroRepartir($apuesta, $ganadores) {
    if (empty($ganadores)) {
        echo "No hay ganadores. La casa se queda con todo.<br>";
        return;
    }

    $puntuacion = max($ganadores);

    // Determinar premio
    $premio = ($puntuacion == 7.5) ? ($apuesta * 0.8) : ($apuesta * 0.5);

    // Si hay varios ganadores
    if (count($ganadores) > 1) {
        echo "Los jugadores ";
        foreach ($ganadores as $nombre => $valor) {
            echo "$nombre ";
        }
        echo "ganaron con $puntuacion puntos y reciben $premio € cada uno.<br>";
    } else {
        // Solo un ganador
        $nombre = array_key_first($ganadores);
        echo "El jugador $nombre ganó con $puntuacion puntos y recibe $premio €.<br>";
    }
}



?>