<?php
require_once ("./funciones.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nombre1 = limpiar_campos($_POST["nombre1"]);
    $nombre2 = limpiar_campos($_POST["nombre2"]);
    $nombre3 = limpiar_campos($_POST["nombre3"]);
    $nombre4 = limpiar_campos($_POST["nombre4"]);
    $bote = limpiar_campos($_POST["bote"]);

    $baraja = array(
            '1C1', '1C2', '1D1', '1D2', '1P1', '1P2', '1T1', '1T2',
            'JC1', 'JC2', 'JD1', 'JD2', 'JP1', 'JP2', 'JT1', 'JT2',
            'KC1', 'KC2', 'KD1', 'KD2', 'KP1', 'KP2', 'KT1', 'KT2',
            'QC1', 'QC2', 'QD1', 'QD2', 'QP1', 'QP2', 'QT1', 'QT2'
    );

   $jugadores =  crearJugadoresyRepartirCartas($baraja, $nombre1, $nombre2, $nombre3, $nombre4);

   encontrarJugada($jugadores);
   
   $ganadores = encontrarGanador($jugadores);

   mostrarGanador($ganadores, $bote);

   mostrarCartas($jugadores);
}
?>