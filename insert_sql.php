<?php

/* 
 * INSERCIÓN DE DATOS CON PHP Y MySQL.
 * http://www.aprenderaprogramar.com/index.php?option=com_content&view=article&id=615:php-insert-into-values-insertar-datos-registros-filas-en-base-de-datos-mysql-ejemplos-y-ejercicio-cu00843b&catid=70:tutorial-basico-programador-web-php-desde-cero&Itemid=193
 */

//$_REQUEST[]
$nombre = 'Moisés';
$email = 'moielking@gmail.com';
$telefono = '666999666';


$host = 'localhost';
$user = 'root';
$password = '12345';
$db = 'prueba_xhtml';
$table = 'contacto';

//Conectamos con el servidor MySQL
$link = mysqli_connect($host, $user, $password);

//Seleccionamos la Base de Datos
mysqli_select_db($link, $db);

//Para que se inserten las tildes correctamente
$tildes = $link->query("SET nombre 'utf8'");

//Ejecutamos la consulta
if(!mysqli_query($link, "INSERT INTO ".$table." (nombre,email,telefono) VALUES ('".$nombre."','".$email."','".$telefono."')")){
    
    die('Error en la consulta SQL.');
    
}
    
echo 'Los datos han sido insertados en la base de datos';
    
//Cerramos la conexión al servidor MySQL
mysqli_close($link);



