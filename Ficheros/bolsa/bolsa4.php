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
        <label>Valores: </label>
        <select id="valor" name="valor">
            <option value="acciona">ACCIONA</option>
            <option value="acerinox">ACERINOX</option>
            <option value="acs">ACS</option>
            <option value="aena">AENA</option>
            <option value="amadeus it group">AMADEUS IT GROUP</option>
            <option value="arcelormittal">ARCELORMITTAL</option>
            <option value="banco sabadell">BANCO SABADELL</option>
        </select>
        <label>Mostrar: </label>
        <select id="elemento" name="elemento">
            <<option value="ultimo">Último valor</option>
            <option value="varPorc">Variación %</option>
            <option value="varEur">Variación €</option>
            <option value="acAno">Ac%Anual</option>
            <option value="max">Máximo</option>
            <option value="min">Mínimo</option>
            <option value="vol">Volumen</option>
            <option value="capit">Capitalización</option>
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
                    $elemento = limpiar_campos($_POST["elemento"]);
                    $posicion = buscarValor($valor);
                    $datos = leerElementos($posicion);

                    echo "<pre>";
                    mostrarElemento($datos, $elemento, $valor);
                    echo "</pre>";
                }

                if (isset($_POST["borrar"])) {}
            }
        ?>
    </div>
</body>
</html> 