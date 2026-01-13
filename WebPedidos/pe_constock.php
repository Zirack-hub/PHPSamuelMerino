<?php
ob_start();
require_once "./funciones/funciones.php";
require_once "./funciones/fbd.php";
require_once "./funciones/fcompras.php";


if (!isset($_COOKIE['usuariopedidos'])) {
    header("Location: ./pe_login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST"
    && isset($_POST["submit"])
    && $_POST["submit"] === "Cerrar Sesion") {
    cerrarSesion("usuariopedidos");
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Aprovisionar</title>
</head>
<body>
    <h1>Portal de compras</h1>
        <p>Portal de compras</p>
        <div class="card-body">
        <form name="alta" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
            <?php
            

            $conn = openBD();
            
            $resultado = selectASSOC("SELECT PRODUCTLINE FROM PRODUCTS GROUP BY PRODUCTLINE", $conn);
            mostrarOpciones("PRODUCTLINE", $resultado, "LINEADEPRODUCTOS", );
            
            ?>
            <input type="submit" name="submit" value="Añadir">
            <br>
            <input type="submit" name="submit" value="Cerrar Sesion">
            <br>
            <a href='./pe_inicio.php'> Volver Inicio</a><br>


        </form>
        



</body>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $eleccion = limpiar_campos($_POST["submit"]);
    $linea = isset($_POST["LINEADEPRODUCTOS"])
        ? limpiar_campos($_POST["LINEADEPRODUCTOS"])
        : null;

    
    if ($eleccion == "Añadir") {
        $cantidad = selectASSOC("SELECT PRODUCTNAME, QUANTITYINSTOCK FROM PRODUCTS WHERE PRODUCTLINE = '$linea'", $conn);
        foreach ($cantidad as $mostrar){
            echo "Stock del producto {$mostrar['PRODUCTNAME']} : {$mostrar['QUANTITYINSTOCK']}<br>";
        }
    }
}


    

ob_end_flush();
?>
</html>