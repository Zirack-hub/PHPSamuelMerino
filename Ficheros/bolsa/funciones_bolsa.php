<?php

$ruta = "./ibex35.txt";

/*Muestra los elementos correspodientes al valor bursátil*/
function mostrarElementos($datos) {
    echo sprintf(
        "%-20s %-8s %-8s %-8s %-11s %-8s %-8s %-12s %-8s\n",
        $datos['nombre'],
        $datos['ultimo'],
        $datos['varPorc'],
        $datos['varEur'],
        $datos['acAno'],
        $datos['max'],
        $datos['min'],
        $datos['vol'],
        $datos['capit']
    );
}

/*Muestra uno de los elementos del valor bursátil*/
function mostrarElemento($datos, $elemento, $valor) {
    $valor = strtoupper($valor);
    echo "El valor $elemento de $valor es " . $datos[$elemento]; 
}

/*Muestra el total de volumen o de capitalización*/
function mostrarTotal($valor, $total) {
    if ($valor == "total volumen") {
        echo "Total Volumen $total";
    }   
    elseif ($valor == "total capitalizacion") {
        echo "Total Capitalización $total";
    }
}

/*Evita la inyección de código*/
function limpiar_campos($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

/*Calcula el total del volumen o de la capitalización, dependiendo del dato que reciba*/
function calcularTotal($valor) {
    global $ruta;
    $archivo = (file($ruta));

    if ($valor == "total volumen") {
        $total = 0;
        for ($i=1; $i < count($archivo); $i++) { 
            $datos = leerElementos($i);
            $total += (float) str_replace('.', '', $datos['vol']);
        }
    }   
    elseif ($valor == "total capitalizacion") {
        $total = 0;
        for ($i=1; $i < count($archivo); $i++) { 
            $datos = leerElementos($i);
            $total += (float) str_replace('.', '', $datos['capit']);
        }
    }

    return $total;
}

/*Busca un valor bursátil en IBEX35 y devuelve su posicion en el array para ser utilizada para leer los elementos e imprimirlos*/
function buscarValor($valor) {
    global $ruta;
    $archivo = (file($ruta));
    $encontrado = false;
    $i = 0;

    do {
        $linea = $archivo[$i];
        $linea = trim($linea);

        if (stripos($linea, $valor) !== false) {
            $posicion = $i;
            $encontrado = true;
        }
        $i++;
    } while ($i < count($archivo) && $encontrado == false); 

    return $posicion;
}

/*Lee los elementos del valor bursátil*/
function leerElementos($posicion) {
    global $ruta;
    $archivo = (file($ruta));

    $claves = ['hora', 'capit', 'vol', 'min', 'max', 'acAno', 'varEur', 'varPorc', 'ultimo'];

    $datos = [];

    $elementos = preg_split('/\s+/', trim($archivo[$posicion]));

   foreach ($claves as $clave) {
            $datos[$clave] = array_pop($elementos);
    }

    $datos['nombre'] = implode(' ', $elementos);

    $datos = array_reverse($datos, true);

    return $datos;
}

/*Lee todos los elementos de IBEX35 y los imprime por pantalla*/
function leerArchivo_y_Mostrar() {
    global $ruta;
    $archivo = (file($ruta));

    printf(
        "%-19s %8s %7s %10s %12s %8s %9s %8s %14s\n",
        "Valor", "Último", "Var.%", "Var.€", "Ac.% año", "Máx.", "Mín.", "Vol.", "Capit.",
    );


    for ($i=1; $i < count($archivo); $i++) { 
        $datos = leerElementos($i);
        mostrarElementos($datos);
    }
}   
?>