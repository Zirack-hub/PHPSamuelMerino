<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta Operaciones en IBEX35</title>
</head>
<body>
    <h2>Consulta Operaciones en IBEX35</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <label>Mostrar: </label>
        <select id="valor" name="valor">
            <<option value="total volumen">Total Volumen</option>
            <option value="total capitalizacion">Total Capitalización</option>
        </select>
        <input type="submit" name="visualizar" value="Visualizar">
        <input type="submit" name="borrar" value="Borrar">
    </form>
    <div id="resultado">
        <?php
            require_once("funciones_bolsa.php");

            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                if (isset($_POST["visualizar"])) {
                    $valor = limpiar_campos($_POST["valor"]);
                    $total = calcularTotal($valor);

                    echo "<pre>";
                    mostrarTotal($valor,$total);
                    echo "</pre>";
                }

                if (isset($_POST["borrar"])) {}
            }
        ?>
    </div>
</body>
</html> 