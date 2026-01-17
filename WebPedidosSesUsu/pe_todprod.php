<?php
ob_start();
require_once "./funciones/funciones.php";
require_once "./funciones/fbd.php";
require_once "./funciones/fcompras.php";
if (session_status() == PHP_SESSION_NONE) {
    session_name($sesname); 
    session_start();
}
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
            var_dump($_SESSION['usuariopedidos']);
            ?>
            
            Inicio Busqueda <input type="date" name="inicio">
            Fin Busqueda <input type="date" name="fin">
            cliente <input type="text" name="cliente">

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
    
    $inicio = (isset($_POST["inicio"]) && !empty($_POST["inicio"])) 
    ? limpiar_campos($_POST["inicio"]) 
    : '1800-01-01';

    $fin = (isset($_POST["fin"]) && !empty($_POST["fin"])) 
        ? limpiar_campos($_POST["fin"]) 
        : date('Y-m-d');

    $cliente = (isset($_POST["cliente"]) && !empty($_POST["cliente"])) 
        ? limpiar_campos($_POST["cliente"]) 
        : ($_SESSION['usuariopedidos']) ;

    
    if ($eleccion == "Añadir") {
            $total = selectASSOC("SELECT 
                                    P.CHECKNUMBER,
                                    P.PAYMENTDATE,
                                    P.AMOUNT,
                                    C.CUSTOMERNAME
                                FROM PAYMENTS P
                                JOIN CUSTOMERS C ON C.CUSTOMERNUMBER = P.CUSTOMERNUMBER
                                WHERE P.PAYMENTDATE BETWEEN '$inicio' AND '$fin'
                                AND C.CUSTOMERNUMBER = '$cliente'
                                ORDER BY P.PAYMENTDATE DESC", $conn);
            $DINEROGASTADO = 0;
            foreach ($total as $linea){
                echo "CHECKE: {$linea['CHECKNUMBER']}-------- FECHA: {$linea['PAYMENTDATE']}-------- IMPORTE: {$linea['AMOUNT']}$-------- NOMBRE: {$linea['CUSTOMERNAME']}<BR>";
                $DINEROGASTADO += $linea['AMOUNT'];
            }
            echo "TOTAL GASTADO: $DINEROGASTADO $";
            
    }
}


    

ob_end_flush();
?>
</html>