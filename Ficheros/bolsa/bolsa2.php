<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buscar en IBEX35</title>
</head>
<body>
    <h2>Buscar valor en IBEX35</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <label>Introduce el valor a buscar: </label>
        <input type="text" name="valor">
        <input type="submit" value="Buscar">
    </form>
    <?php

    require_once("funciones_bolsa.php");

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

         $valor = limpiar_campos($_POST["valor"]);
         $posicion = buscarValor($valor);
         $datos = leerElementos($posicion);
        echo "<pre>";
        echo mostrarElementos($datos);
        echo "</pre>";
    }
    ?>
</body>
</html> 