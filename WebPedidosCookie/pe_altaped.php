<?php
ob_start();

require_once "./funciones/funciones.php";
require_once "./funciones/fbd.php";
require_once "./funciones/fcompras.php";

iniciarCarrito();

if (!isset($_COOKIE['usuariopedidos'])) {
    header("Location: ./pe_login.php");
    exit();
}

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

        if (isset($_COOKIE['carrito'])) {
            $carrito = unserialize($_COOKIE['carrito']);
        } else {
            $carrito = array();
        }
        echo "<pre>";
        var_dump($carrito);
        echo "</pre>";

    } elseif ($eleccion == "Eliminar") {
        eliminarProducto($producto, $cantidad);

    } elseif ($eleccion == "Cerrar Sesion") {
        cerrarSesion("usuariopedidos");
    }
}

$conn = openBD();
$resultado = selectASSOC("SELECT PRODUCTCODE, PRODUCTNAME FROM PRODUCTS WHERE QUANTITYINSTOCK > 0", $conn);

if (isset($_COOKIE['carrito'])) {
    $carrito = unserialize($_COOKIE['carrito']);
} else {
    $carrito = array();
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
            mostrarOpciones("PRODUCTCODE", $resultado, "PRODUCTOS", "PRODUCTNAME");
            ?>
            Cantidad de productos <input type="text" name="cantidad">
            <input type="submit" name="submit" value="Añadir">
            <input type="submit" name="submit" value="Eliminar">
            <input type="submit" name="submit" value="Finalizar Compra">
            <br>
            <input type="submit" name="submit" value="Cerrar Sesion">
            <br>
            <a href='./pe_inicio.php'> Volver Inicio</a><br>
        </form>

        <p>Carrito</p>
        <?php
        foreach ($carrito as $producto => $cantidad) {
            $nombre = selectCOL("SELECT PRODUCTNAME FROM PRODUCTS WHERE PRODUCTCODE = '$producto'", $conn);
            $precio = selectCOL("SELECT BUYPRICE FROM PRODUCTS WHERE PRODUCTCODE = '$producto'", $conn);
            $total = $precio * $cantidad;
            echo("$nombre.......... cantidad: $cantidad .......... total = $total $<br>");
        }
        ?>
    </div>
</body>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $eleccion = limpiar_campos($_POST["submit"]);

    if ($eleccion == "Finalizar Compra") {
        $flag = comprobarCarrito($conn);
        if ($flag == true){
            echo '
                <form name="alta" action="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '" method="post">
                    <br><br>
                    MetodoDepago(AA999999) <input type="text" name="pago">
                    <input type="submit" name="submit" value="Validar Compra">
                </form>';
        } else {
            echo ("NO SE PUEDE REALIZAR LA COMPRA.");
        }
    } elseif ($eleccion == "Validar Compra") {
        if (isset($_POST["pago"])) {
            $pago = limpiar_campos($_POST["pago"]);
        } else {
            $pago = null;
        }

        if (comprobarNumero($pago) == TRUE){
            realizarCompra($conn, $pago);
            closeBD($conn);
            setcookie("carrito", "", time() - 3600,"/");
        } else {
            echo("NO SE HA INTRODUCIDO BIEN EL METODO DE PAGO");
        }
    }
}

ob_end_flush();
?>
</html>
