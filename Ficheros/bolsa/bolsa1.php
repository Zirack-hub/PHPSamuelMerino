<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>IBEX35 sin hora</title>
</head>
<body>
    <?php
        $archivo = (file("ibex35.txt"));
        require_once("funciones_bolsa.php");
        
        echo"<pre>";
        mostrarArchivo($archivo);
        echo"</pre>";

    ?>
</body>
</html>

