<?php
function mostrarArchivo($archivo) {
    $cabecera = true;

    foreach ($archivo as $linea) {
        $linea = trim($linea);
        if ($linea === "") continue; // ignorar líneas vacías

        if ($cabecera) {
            $cabecera = false;
            continue;
        }

        $partes = preg_split('/\s+/', $linea);

        $hora = array_pop($partes);

        // Extraemos las 8 siguientes columnas (numéricas)
        $capit = array_pop($partes);
        $vol = array_pop($partes);
        $min = array_pop($partes);
        $max = array_pop($partes);
        $acAno = array_pop($partes);
        $varEur = array_pop($partes);
        $varPorc = array_pop($partes);
        $ultimo = array_pop($partes);

        // Todo lo que queda al principio es el nombre (puede tener espacios)
        $nombre = implode(' ', $partes);

        // Mostramos todo excepto la hora
        echo sprintf(
            "%-20s %-8s %-8s %-8s %-8s %-8s %-8s %-12s %-8s\n",
            $nombre, $ultimo, $varPorc, $varEur, $acAno, $max, $min, $vol, $capit
        );
    }
}
?>
