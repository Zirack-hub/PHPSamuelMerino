<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login cliente</title>
</head>
<body>
    <h1>Login cliente</h1>
		<p>Login clientes<p>
		<div class="card-body">
		<form name="alta" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
            <?php
                $cookie_name = "usuariopedidos";
                require_once("./funciones/funciones.php");
                require_once("./funciones/fbd.php");
                require_once("./funciones/fcompras.php");

                $conn = openBD("webpedidos");

                if(!isset($_COOKIE[$cookie_name])) {
                ?>
                    Usuario (CustomerNumber): <input type="text" name="usuario">
                    contraseña (ContactLastname): <input type="text" name="clave">
                    <input type="submit" name="submit" value="Iniciar Sesión">
                <?php
                } 
                else {
                    $name = selectCol("SELECT CUSTOMERNAME FROM CUSTOMERS WHERE CUSTOMERNUMBER = '$_COOKIE[$cookie_name]'",$conn);
                    echo "Has iniciado sesión como $name<br>";
                    echo "COMPRAS: <br>";
                    echo "<a href='./pe_altaped.php'> Ver compras</a><br>";
                    echo "HISTORIAL: <br>";
                    echo "<a href='./pe_consped.php'> Ver historial</a><br>";
                    echo "STOCK: <br>";
                    echo "<a href='./pe_consprodstock.php'> Ver historial</a><br>";
                    echo "STOCK LINEAS PRODUCCION: <br>";
                    echo "<a href='./pe_constock.php'> Ver historial</a><br>";
                    echo "</br></br><input type='submit' name='submit' value='Cerrar Sesión'>";

                }
            ?>
        </form>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $eleccion = limpiar_campos($_POST["submit"]);

        if ($eleccion == "Iniciar Sesión") {
            $usuario = limpiar_campos($_POST["usuario"]);
            $clave = limpiar_campos($_POST["clave"]);

            $registro = selectCOL("SELECT CUSTOMERNUMBER FROM CUSTOMERS WHERE CONTACTLASTNAME = '$clave' AND CUSTOMERNUMBER = '$usuario'",$conn);
            
            if ($registro != null) {
                $name = selectCol("SELECT CUSTOMERNAME FROM CUSTOMERS WHERE CUSTOMERNUMBER = '$usuario'",$conn);
                setcookie($cookie_name, $registro, time() + (86400 * 30), "/");
                echo "Has iniciado sesión como $name <br>";
                echo "COMPRAS: <br>";
                echo "<a href='./pe_altaped.php'> Ver compras</a><br>";
                echo "HISTORIAL: <br>";
                echo "<a href='./pe_consped.php'> Ver historial</a><br>";
                echo "STOCK: <br>";
                echo "<a href='./pe_consprodstock.php'> Ver historial</a><br>";
                echo "STOCK LINEAS PRODUCCION: <br>";
                echo "<a href='./pe_constock.php'> Ver historial</a><br>";
                
                echo '
                        <form name="alta" action="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '" method="post">
                            <br><br>
                            <input type="submit" name="submit" value="Cerrar Sesión">
                        </form>';

                
            }
            else {
                echo "El usuario y la contraseña no coinciden";
            }
        }
        elseif ($eleccion == "Cerrar Sesión") {
            cerrarSesion($cookie_name);
        }
}
?>
</body>
</html>