<?php

/* 
 * CONSULTAS MEJORADAS A BASE DE DATOS MySQL CON PHP. 
 * http://www.aprenderaprogramar.com/index.php?option=com_content&view=article&id=613:ejemplo-consulta-php-mysql-select-bucle-while-mysqlifetcharray-recorrer-resultados-query-cu00842b&catid=70:tutorial-basico-programador-web-php-desde-cero&Itemid=193
 */

$host = 'localhost';
$user = 'root';
$password = '12345';
$db = 'prueba_xhtml';
$table = 'contacto';

//Abrimos la conexión al servidor MySQL
$link = mysqli_connect($host, $user, $password);
//Seleccionamos la Base de Datos
mysqli_select_db($link, $db);
//Para que se inserten las tildes correctamente
$tildes = $link->query("SET nombre 'utf8'");
//Ejecutamos la consulta SQL.
$result = mysqli_query($link, "SELECT * FROM ".$table);

//Si hemos obtenido datos recorremos el Array.
if($result){

    //Array donde almacenaremos los resultados
    $res=array();

    //Recorremos el array de resultados
    while($row=$result->fetch_array(MYSQLI_ASSOC)){

        //Añadimos cada fila al nuevo array
        array_push($res,$row); //Afegim totes les files retornades a l'array de sortida

    }
    //Liberamos la memoria de la consulta
    $result->free();

}else{

    echo 'No se han obtenido datos de la consulta.';
}

//Cerramos la conexión al servidor MySQL
mysqli_close($link);

//Imprmimos el Array.
print_r($res);

//------------- Mostramos los datos en una tabla -------------------

//Comprobamos que res contenga datos.
if(!$res){            
    die('La consulta no contiene datos.');            
}

//Comprobamos que res sea un array
if(gettype($res)!='array'){            
    die('El tipo de datos no es valido.');            
}

echo "<table summary='Resultados de la consulta'>";
echo "<caption>Tabla '".$table."'</caption>";
echo "<thead>";
echo "<tr>";

//Recorremos las claves.
foreach ($res[0] as $key => $value) {
        echo "<th scope='col'>";
        echo $key;
        echo "</th>";                
}        

echo "</tr>";
echo "</thead>";
echo "<tbody>";

//Recorremos el nombre de columnas
for($x=0;$x<count($res);$x++){
    echo "<tr>";

    //Recorremos las filas.
    foreach ($res[$x] as $key => $value) {
        echo "<td>";
        echo $value;
        echo "</td>";
    }            
    echo "</tr>";
}

echo "</tbody>";

echo "<tfoot>";
echo "<tr>";

//Recorremos las claves.
foreach ($res[0] as $key => $value) {
        echo "<th scope='col'>";
        echo $key;
        echo "</th>";                
}

echo "</tr>";
echo "</tfoot>";
        


