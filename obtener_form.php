<?php
session_start();
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function identical_values( $arrayA , $arrayB ) {

    sort( $arrayA );
    sort( $arrayB );

    return $arrayA == $arrayB;
} 

include 'class.connection.php';
include 'class.entity.php';

$nombre = $_REQUEST["nombre"];
$email = $_REQUEST["email"];
$telefono = $_REQUEST["telefono"];

$values = array(
    'nombre'=>utf8_decode($nombre),
    'email'=>$email,
    'telefono'=>$telefono
);



echo "<h1>Formulario enviado</h1>";
echo "<a href='index.xhtml'>Volver</a>";
echo "<hr>";

$conexion = new Conexion();

$conexion->AbrirConexion();

$entidad = new entContacto();

$sql = $entidad->get_insert_cmd($values);

//Comprobamos que la variable de sesion esté inicializada, sinó la inicializamos.
if(!$_SESSION['values']){
    
    $_SESSION['values'] = $values;
    
}

//Si el contenido es diferente al anterior guardamos los datos.
if(!identical_values($_SESSION['values'], $values)){
    
    $conexion->EjecutarConsulta($sql);
    
};


$sql = $entidad->get_select_cmd();

$res = $conexion->EjecutarConsulta($sql);

echo "<hr>";

$entidad->MostrarTablaDatos($res);

$conexion->CerrarConexion();

echo "<hr>";

/*
echo $entidad->get_select_cmd();
echo "<br>";
echo $entidad->get_insert_cmd($values);
echo "<br>";
echo $entidad->get_update_cmd($values,"id=1");
echo "<br>";
echo $entidad->get_delete_cmd("id=1");
*/


?>

