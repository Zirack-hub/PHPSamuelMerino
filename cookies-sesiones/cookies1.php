<!DOCTYPE html>
<?php
/* Una cookie es un fragmento de información que un navegador web almacena en el disco duro del visitante a una página web. 
La información se almacena a petición del servidor web, ya sea directamente desde la propia página web con JavaScript o 
desde el servidor web mediante las cabeceras HTTP, que pueden ser generadas desde PHP. 
La información almacenada en una cookie puede ser recuperada por el servidor web en posteriores visitas a la misma página web.
Las cookies resuelven un grave problema del protocolo HTTP: al ser un protocolo de comunicación "sin estado" (stateless), 
no es capaz de mantener información persistente entre diferentes peticiones. 
Gracias a las cookies se puede compartir información entre distintas páginas de un sitio web o incluso en la misma página web 
pero en diferentes instantes de tiempo.

En PHP se emplea la función setcookie() para asignar valor a una cookie.
Para borrar una cookie, se tiene que asignar a la cookie una fecha de caducidad (expire) en el pasado, es decir, 
una fecha anterior a la actual.
Para recuperar el valor de una cookie se emplea el array predefinido $_COOKIE con el nombre de la cookie como índice. 
También se puede emplear $_REQUEST, que contiene la unión de $_COOKIE, $_POST y $_GET. 
*/

// CREAR UNA COOKIE
// Uso de la función setcookie para asignar valor la cookie usuario

$cookie_name = "usuario";

// Si el usuario envía el formulario
if (isset($_POST['nombre'])) {
    $cookie_value = $_POST['nombre'];
    setcookie($cookie_name, $cookie_value, time() + (86400 * 1), "/"); // 1 día
    header("Refresh:0"); // recarga la página para leer la cookie
}
?>

<html>
<body>

<h2>Introduce tu nombre</h2>

<form method="post">
    <input type="text" name="nombre" required>
    <input type="submit" value="Guardar nombre">
</form>

<hr>

<?php
// Comprobamos si la cookie existe
if (!isset($_COOKIE[$cookie_name])) {
    echo "Cookie <strong>$cookie_name</strong> no definida.<br>";
    echo "<p><strong>Importante:</strong> Introduce tu nombre y envía el formulario.</p>";
} else {
    echo "Cookie <strong>$cookie_name</strong> definida.<br>";
    echo "Nombre guardado: <strong>" . $_COOKIE[$cookie_name] . "</strong>";
}
?>

</body>
</html>
