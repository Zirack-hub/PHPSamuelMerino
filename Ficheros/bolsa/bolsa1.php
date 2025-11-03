<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IBEX365 sin hora</title>
</head>
<body>
    <h2>Leer y mostrar IBEX35</h2>
    <?php
        require_once("funciones_bolsa.php");

        echo "<pre>";
        leerArchivo_y_Mostrar();
        echo "</pre>";
    ?>
</body>
</html>