<?php
ob_start();

require_once "./funciones/funciones.php";
require_once "./funciones/fbd.php";
require_once "./funciones/fcompras.php";

if (!isset($_COOKIE['usuariopedidos'])) {
    header("Location: ./pe_login.php");
    exit();
}

iniciarCarrito();
$cookieCarrito = 'carrito' . $_COOKIE['usuariopedidos'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $eleccion = limpiar_campos($_POST["submit"]);

    if (isset($_POST["PRODUCTOS"])) {
        $producto = limpiar_campos($_POST["PRODUCTOS"]);
    } else {
        $producto = null;
    }

    if (isset($_POST["cantidad"])) {
        $cantidad = limpiar_campos($_POST["cantidad"]);
    } else {
        $cantidad = null;
    }

    if ($eleccion == "Añadir") {
        agregarProducto($producto, $cantidad);

    } elseif ($eleccion == "Eliminar") {
        eliminarProducto($producto, $cantidad);

    } elseif ($eleccion == "Cerrar Sesion") {
        cerrarSesion("usuariopedidos");
    }
}

$conn = openBD();
$resultado = selectASSOC("SELECT PRODUCTCODE, PRODUCTNAME FROM PRODUCTS WHERE QUANTITYINSTOCK > 0", $conn);

if (isset($_COOKIE[$cookieCarrito])) {
    $carrito = unserialize($_COOKIE[$cookieCarrito]);
} else {
    $carrito = array();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Aprovisionar</title>
</head>
<body>
<h1>Portal de compras</h1>

<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
    <?php mostrarOpciones("PRODUCTCODE", $resultado, "PRODUCTOS", "PRODUCTNAME"); ?>
    Cantidad <input type="text" name="cantidad">
    <input type="submit" name="submit" value="Añadir">
    <input type="submit" name="submit" value="Eliminar">
    <input type="submit" name="submit" value="Finalizar Compra">
    <input type="submit" name="submit" value="Cerrar Sesion">
</form>

<p>Carrito</p>
<?php
foreach ($carrito as $producto => $cantidad) {
    $nombre = selectCol("SELECT PRODUCTNAME FROM PRODUCTS WHERE PRODUCTCODE = '$producto'", $conn);
    $precio = selectCol("SELECT BUYPRICE FROM PRODUCTS WHERE PRODUCTCODE = '$producto'", $conn);
    $total = $precio * $cantidad;
    echo "$nombre.......... cantidad: $cantidad .......... total = $total $<br>";
}
?>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $eleccion = limpiar_campos($_POST["submit"]);

    if ($eleccion == "Finalizar Compra") {

        $flag = comprobarCarrito($conn);
        if ($flag == true) {
            echo '
            <form action="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '" method="post">
                <br><br>
                Metodo de pago (AA999999) <input type="text" name="pago">
                <input type="submit" name="submit" value="Validar Compra">
            </form>';
        } else {
            echo "NO SE PUEDE REALIZAR LA COMPRA.";
        }

    } elseif ($eleccion == "Validar Compra") {

        if (isset($_POST["pago"])) {
            $pago = limpiar_campos($_POST["pago"]);
        } else {
            $pago = null;
        }

        if (comprobarNumero($pago) == true) {
            realizarCompra($conn, $pago);
            closeBD($conn);
        } else {
            echo "NO SE HA INTRODUCIDO BIEN EL METODO DE PAGO";
        }
    }
}

ob_end_flush();
?>
</body>
</html>
