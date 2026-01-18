<?php
session_start();
ob_start();
require_once "./funciones/funciones.php";
require_once "./funciones/fbd.php";
require_once "./funciones/fcompras.php";

if (!isset($_COOKIE['PHPSESSID'])) {
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
            ?>
            
            Inicio Busqueda <input type="date" name="inicio">
            Fin Busqueda <input type="date" name="fin">
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
    $inicio = isset($_POST["inicio"])
        ? limpiar_campos($_POST["inicio"])
        : null;
    $fin = isset($_POST["fin"])
        ? limpiar_campos($_POST["fin"])
        : null;
    
    if ($eleccion == "Añadir") {
        if ($inicio === null or $fin === null){
            echo "DEBES INCLUIR AMBAS FECHAS";
        }else{
            $total = selectASSOC("SELECT 
                                    P.PRODUCTCODE,
                                    P.PRODUCTNAME,
                                    SUM(OD.QUANTITYORDERED) AS TOTAL_UNIDADES
                                FROM ORDERS O
                                JOIN ORDERDETAILS OD ON O.ORDERNUMBER = OD.ORDERNUMBER
                                JOIN PRODUCTS P ON OD.PRODUCTCODE = P.PRODUCTCODE
                                WHERE O.ORDERDATE BETWEEN '$inicio' AND '$fin'
                                GROUP BY P.PRODUCTCODE, P.PRODUCTNAME
                                ORDER BY TOTAL_UNIDADES DESC", $conn);
            foreach ($total as $linea){
                echo "Producto: {$linea['PRODUCTNAME']}-------- Unidades vendidas: {$linea['TOTAL_UNIDADES']}<BR>";
            }
        }   
    }
}


    

ob_end_flush();
?>
</html>