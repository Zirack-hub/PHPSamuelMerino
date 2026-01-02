<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Aprovisionar</title>
</head>
<body>
    <h1>Registro de Clientes</h1>
        <p>Registro de Clientes<p>
        <div class="card-body">
        <form name="alta" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
            <?php
            $cookie_name = "usuariocompras";
            require_once ("./funciones/funciones.php");
            require_once ("./funciones/fbd.php");

            $conn = openBD('comprasweb');
            if(!isset($_COOKIE[$cookie_name])) {
                ?>
                Nombre: <input type="text" name="nombre">
                Clave: <input type="text" name="clave">
                <input type="submit" name="submit" value="Añadir">
                <?php
            } else {

            $name = selectCol("SELECT NOMBRE FROM CLIENTE WHERE NIF = '$_COOKIE[$cookie_name]'", $conn);
            echo "Has iniciado sesion como $name<br>";
            echo "COMPRAS:<br>";
            echo "<a href='./comprocli.php'>Ver compras</a><br><br>";

            echo "HISTORIAL:<br>";
            echo "<a href='./comconscli.php'>Ver historial</a><br>";
            }
            ?>
            
            
            
            
        </form>
</body>
</html>
<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nombre = limpiar_campos($_POST["nombre"]);
        $clave = limpiar_campos($_POST["clave"]);

        $registro = selectCol("SELECT NIF FROM CLIENTE WHERE NOMBRE = '$nombre' AND CLAVE = '$clave'", $conn);
        
        if ($registro != null){
            echo "Has iniciado sesion como $nombre";
            setcookie($cookie_name, $registro, time() + (86400 * 30), "/");

            echo "COMPRAS:<br>";
            echo "<a href='./comprocli.php'>Ver compras</a><br><br>";

            echo "HISTORIAL:<br>";
            echo "<a href='./comconscli.php'>Ver historial</a><br>";
        
        }else{
            echo "EL USUARIO Y CONTRASEÑA NO COINCIDEN";
        }

            
        closeBD($conn);
        }
    

    




?>
    