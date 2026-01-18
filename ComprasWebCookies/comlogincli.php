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
                $cookie_name = "usuariocompras";
                require_once("./funciones/funciones.php");
                require_once("./funciones/fbd.php");
                require_once("./funciones/fcompras.php");

                $conn = openBD("comprasweb");

                if(!isset($_COOKIE[$cookie_name])) {
                ?>
                    Usuario: <input type="text" name="usuario">
                    Contraseña: <input type="text" name="clave">
                    <input type="submit" name="submit" value="Iniciar Sesión">
                <?php
                } 
                else {
                    $name = selectCol("SELECT NOMBRE FROM CLIENTE WHERE NIF = '$_COOKIE[$cookie_name]'",$conn);
                    echo "Has iniciado sesión como $name<br>";
                    echo "COMPRAS: <br>";
                    echo "<a href='./comprocli.php'> Ver compras</a><br>";
                    echo "HISTORIAL: <br>";
                    echo "<a href='./comconscli.php'> Ver compras</a><br>";
                    echo "</br></br><input type='submit' name='submit' value='Cerrar Sesión'>";
                }
            ?>
        </form>
</body>
</html>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $eleccion = limpiar_campos($_POST["submit"]);

        if ($eleccion == "Iniciar Sesión") {
            $usuario = limpiar_campos($_POST["usuario"]);
            $clave = limpiar_campos($_POST["clave"]);

            $registro = selectCOL("SELECT NIF FROM CLIENTE WHERE CLAVE = '$clave' AND NOMBRE = '$usuario'",$conn);
            
            if ($registro != null) {
                setcookie($cookie_name, $registro, time() + (86400 * 30), "/");
                echo "Has iniciado sesión como $usuario <br>";
                echo "COMPRAS: <br>";
                echo "<a href='./comprocli.php'> Ver compras</a><br>";
                echo "HISTORIA: <br>";
                echo "<a href='./comconscli.php'> Ver compras</a><br>";
                echo "</br></br><input type='submit' name='submit' value='Cerrar Sesión'>";
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
