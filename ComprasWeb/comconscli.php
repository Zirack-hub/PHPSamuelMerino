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
            $usuario = selectASSOC("SELECT NOMBRE, APELLIDO, NIF FROM CLIENTE WHERE NIF = '" . $_COOKIE['usuariocompras'] . "'",$conn);

            $cliente = $usuario[0];
            echo "Hola {$cliente['NOMBRE']} {$cliente['APELLIDO']}<br>";



            echo "REGISTRO:<br>";
            $compras = selectASSOC("SELECT NOMBRE, FECHA_COMPRA, UNIDADES FROM COMPRA C, PRODUCTO P WHERE NIF = '" . $cliente['NIF'] . "' AND C.ID_PRODUCTO = P.ID_PRODUCTO ORDER BY FECHA_COMPRA DESC",$conn);
            foreach ($compras as $compra){
                echo "{$compra['NOMBRE']} --- {$compra['UNIDADES']} --- {$compra['FECHA_COMPRA']}<br>";
            }
            echo "<a href='./comlogcli.php'>VOLVER AL REGISTRO</a><br>";
            ?>
            
            
            
            
        </form>
</body>
</html>
<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        
        closeBD($conn);
        }
    

    




?>
    
