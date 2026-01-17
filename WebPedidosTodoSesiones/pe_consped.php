<?php
if (!isset($_COOKIE['usuariopedidos'])) {
    header("Location: ./pe_login.php");
    exit();
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
    <h1>Registro de Clientes</h1>
        <p>Registro de Clientes<p>
        <div class="card-body">
        <form name="alta" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
            <?php
            $cookie_name = "usuariopedidos";
            require_once ("./funciones/funciones.php");
            require_once ("./funciones/fbd.php");
            $numero = $_COOKIE['usuariopedidos'];
            $conn = openBD();
            $usuario = selectASSOC("SELECT CUSTOMERNAME FROM CUSTOMERS WHERE CUSTOMERNUMBER = $numero",$conn);
            $cliente = $usuario[0];
            echo "Hola {$cliente['CUSTOMERNAME']}<br>";



            echo "REGISTRO:<br>";
            $compras = selectASSOC("SELECT ORDERNUMBER, ORDERDATE, STATUS FROM ORDERS WHERE CUSTOMERNUMBER = $numero",$conn);
            foreach ($compras as $compra){
                echo "{$compra['ORDERNUMBER']} --- {$compra['ORDERDATE']} --- {$compra['STATUS']}<br>";
                $linea = selectASSOC("SELECT PRODUCTCODE, QUANTITYORDERED, PRICEEACH, ORDERLINENUMBER FROM ORDERDETAILS WHERE ORDERNUMBER = '".$compra['ORDERNUMBER']."' ORDER BY ORDERLINENUMBER", $conn);
                foreach($linea as $lineap){
                    $nompro = selectCOL("SELECT PRODUCTNAME FROM PRODUCTS WHERE PRODUCTCODE = '".$lineap['PRODUCTCODE']."'",$conn);
                    echo "- NOMBRE: $nompro----CANTIDAD: {$lineap['QUANTITYORDERED']}----IMPORTE UNIDAD: {$lineap['PRICEEACH']}---- LINEA FACTURA: {$lineap['ORDERLINENUMBER']}<BR>";

                }
                
            }
            echo "<a href='./pe_inicio.php'>VOLVER AL REGISTRO</a><br>";
            closeBD($conn);
            ?>
            
            
            
            
        </form>
</body>
</html>
<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        
        closeBD($conn);
        }
    

    




?>
    
