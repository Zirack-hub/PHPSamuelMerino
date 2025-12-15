<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Aprovisionar</title>
</head>
<body>
    <h1>Registro de clientes</h1>
        <p>Registro de Clientes<p>
        <div class="card-body">
        <form name="alta" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
            <?php
            require_once ("./funciones/funciones.php");
            require_once ("./funciones/fbd.php");

            $conn = $conn = openBD('comprasweb');

            
            
            ?>
            Nombre: <input type="text" name="nombre">
            Apellido: <input type="text" name="apellido">
            
            <input type="submit" name="submit" value="Añadir">
        </form>
</body>
</html>
<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nombre = limpiar_campos($_POST["nombre"]);
        $apellido = limpiar_campos($_POST["apellido"]);

        
        $conn->beginTransaction();
            $stmt = $conn->prepare("INSERT INTO ecliente(nif,nombre, apellidos, cp, direccion, ciudad) VALUES (:nif,:nombre,:apellido,:cp,:direccion,:ciudad)");
                $stmt->bindParam(':nif', $nif);
                $stmt->bindParam(':nombre', $nombre);
                $stmt->bindParam(':apellido', $apellido);
                $stmt->bindParam(':cp', $cp);
                $stmt->bindParam(':direccion', $direccion);
                $stmt->bindParam(':ciudad', $ciudad);
            $stmt->execute();
            $conn->commit();
        closeBD($conn);
        }
    catch(PDOException $e)
        {
        if ($conn && $conn->inTransaction()) {
            $conn->rollback();
        }
        echo "Connection failed: " . $e->getMessage();
        echo "Código de error: " . $e->getCode() . "<br>";
        }
        }else{
            Echo "No Puedes dar de alta dos usuarios con el mismo nif"
        }
        } else {
        echo "El NIF debe contener 8 números y una letra mayuscula.";
        }
        closeBD($conn);

    }