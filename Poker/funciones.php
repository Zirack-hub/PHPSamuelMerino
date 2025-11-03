<?php
/*Recoge un dato y limpia el dato para evitar inyección de código*/
function limpiar_campos($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

/*Recoge la baraja de cartas y los nombres de los jugadores, con esta información, llama a la funcion repartir cartas para cada jugador y devuelve un array de jugadores*/
function crearJugadoresyRepartirCartas($baraja, $nombre1, $nombre2, $nombre3, $nombre4) {
    shuffle($baraja);
    $index = 0;

    for ($i=1; $i <= 4; $i++) { 
        ${"jugador$i"} = repartir_cartas(${"nombre$i"}, $baraja, $index);
    }

    $jugadores = array('jugador1' => $jugador1, 'jugador2' => $jugador2, 'jugador3' => $jugador3, 'jugador4' => $jugador4);

    return $jugadores;

}

/*Recibe la baraja, un index para controlar la indexacion de cartas, indexa cartas en un array cartas y devuelve un array jugador que contiene su nombre, 
el array cartas y campo jugada en null*/
function repartir_cartas($nombre, $baraja, &$index) {
    $cartas = array();
    $limite = $index + 4;

    for (; $index < $limite ;$index++) {
        array_push($cartas,$baraja[$index]);
    }

    $jugador = array('nombre' => $nombre, 'cartas' => $cartas, 'jugada' => null);
    return $jugador;
}

/*Recibe jugadores y calcula la jugada que tienen cada uno de ellos, obtengo los valores de las cartas a traves de la funcion separarValores, después cuento las veces repetidas de esos valores,
con esa información llamo a la funcion elegirJugada que con el dato de repeticion saca el nombre de la jugada, tras esto se asigna la jugada al jugador*/
function encontrarJugada(&$jugadores) {
    foreach ($jugadores as &$jugador) {
        $valores = separarValores($jugador['cartas']);
        $repeticiones = array_values(array_count_values($valores));
        $jugada = elegirJugada($repeticiones);        
        $jugador['jugada'] = $jugada; 
    }
}

/*Recibe carta, obtiene el primer valor de estas y devuelve el array con los valores*/
function separarValores($cartas) {
    $valores = array();

    foreach ($cartas as $carta) {
        array_push($valores,$carta[0]);
    }

    return $valores;
}

/*Recibe repeticiones, que contiene numeros, ordena esos numeros y depediendo de ellos saca la jugada obtenida*/
function elegirJugada($repeticiones) {
    rsort($repeticiones);
    $jugada = "ninguna"; 

    if (count($repeticiones) > 1) {
        if ($repeticiones[0] == 2 && $repeticiones[1] == 2) {
            $jugada = "doble pareja";
        }
        elseif ($repeticiones[0] == 2) {
            $jugada = "pareja";
        }
        elseif ($repeticiones[0] == 3) {
            $jugada = "trio";
        }
    }
    else {
        $jugada = "poker";
    }

    return $jugada;
}

/*Recibe jugadores, encuentra la mejor jugada y obtiene los ganadores respecto a esta*/
function encontrarGanador($jugadores) {
    $ganadores = array();
    $ranking = array(
        'poker' => 4,
        'trio' => 3,
        'doble pareja' => 2,
        'pareja' => 1,
        'ninguna' => 0
    );

    $mejorValor = 0;
    foreach ($jugadores as $jugador) {
        if ($ranking[$jugador['jugada']] > $mejorValor) {
            $mejorValor = $ranking[$jugador['jugada']];
        }
    }

    foreach ($jugadores as $jugador) {
        if ($ranking[$jugador['jugada']] == $mejorValor && $mejorValor != 0) {
            array_push($ganadores, $jugador);
        }
    }

    return $ganadores;
}

/*Recibe los ganadores y el bote, y muestra en pantalla la información correspodiente a ganadores*/
function mostrarGanador($ganadores, $bote) {
    $cantidad = count($ganadores);
    if ($cantidad == 0) {
        echo "Nadie ha sacado nada, por lo tanto, no se reparte ningún premio";
    }
    elseif ($ganadores[0]['jugada'] == "pareja") {
        echo "La jugada ganadora es pareja, por lo tanto, no se reparte ningún premio";
    }
    elseif ($cantidad > 1) {
        if ($ganadores[0]['jugada'] == "poker") {
            echo "La jugada ganadora es poker, por lo tanto, ";
            echo "los jugadores ";
            foreach ($ganadores as $ganador) {
                echo "" . $ganador['nombre'] . " ";
            }
            echo "se reparten el bote completo ($bote$)";
        }
        elseif ($ganadores[0]['jugada'] == "trio") {
            echo "La jugada ganadora es trio, por lo tanto, ";
            echo "los jugadores ";
            foreach ($ganadores as $ganador) {
                echo "" . $ganador['nombre'] . " ";
            }
            echo "se reparten el 70% del bote ($bote$)";
        }
        elseif ($ganadores[0]['jugada'] == "doble pareja") {
            echo "La jugada ganadora es doble pareja, por lo tanto, ";
            echo "los jugadores ";
            foreach ($ganadores as $ganador) {
                echo "" . $ganador['nombre'] . " ";
            }
            echo "se reparten el 50$ del bote ($bote$)";
        }
    }
    elseif ($cantidad == 1) {
        if ($ganadores[0]['jugada'] == "poker") {
            echo "La jugada ganadora es poker, por lo tanto, el jugador ". $ganadores[0]['nombre'] . " ";
            echo "obtiene el bote completo ($bote$)";
        }
        elseif ($ganadores[0]['jugada'] == "trio") {
            echo "La jugada ganadora es trio, por lo tanto, el jugador ". $ganadores[0]['nombre'] . " ";
            echo "obtiene el 70% del bote ($bote$)";
        }
        elseif ($ganadores[0]['jugada'] == "doble pareja") {
            echo "La jugada ganadora es doble pareja, por lo tanto, el jugador ". $ganadores[0]['nombre'] . " ";
            echo "obtiene el 50% del bote ($bote$)";
        }
    }
}

/*Recibe el array jugadores e imprime la informacion de ellos en una tabla con su nombre y sus cartas*/
function mostrarCartas($jugadores) {
    echo "<table border='1' cellpadding='5'>";

    foreach ($jugadores as $jugador) {
        echo "<tr>";
        echo "<td>" . $jugador['nombre'] . "</td>";
        foreach ($jugador['cartas'] as $carta) {
            $ruta = "./images/" . $carta . ".png";
            echo "<td><img src='$ruta' alt='$carta' width='80' height='120'></td>";
        }
    }    
}
?>