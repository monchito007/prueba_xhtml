<?php

/* 
 * Clase para conecta con la Base de Datos MySQL
 */

class Conexion{
    
    //Atributos
    private $con=NULL;
    private $servidor=NULL;
    private $usuario=NULL;
    private $contrase�a=NULL;
    private $bd=NULL;
    private $isOpen=false;

    //Constructor
    function __construct($servidor=NULL,$usuario=NULL,$contrase�a=NULL,$bd=NULL) {
        $this->SetServidor($servidor);
        $this->SetUsuario($usuario);
        $this->SetContrase�a($contrase�a);
        $this->SetBD($bd);
    }
    
    //Metodos
    
    public function SetServidor($servidor){
        
        if(isset($servidor)){
            $this->servidor = $servidor;
        }else{
            $this->servidor = "localhost";
        }
        
    }
    
    public function SetUsuario($usuario){
        
        if(isset($usuario)){
            $this->usuario = $usuario;
        }else{
            $this->usuario = "root";
        }
        
    }
    
    public function SetContrase�a($contrase�a){
        
        if(isset($contrase�a)){
            $this->contrase�a = $contrase�a;
        }else{
            $this->contrase�a = "12345";
        }
        
    }
    
    public function SetBD($bd){
        
        if(isset($bd)){
            $this->bd = $bd;
        }else{
            $this->bd = "prueba_xhtml";
        }
        
    }
    
    public function AbrirConexion(){
        
        //Si la conexi�n no est� abierta previamente
        if(!$this->isOpen){
            
            $this->con = mysqli_init();
            
            if(!$this->con){
                die('Fall� mysqli_init');
            }
            
            if(!$this->con->real_connect($this->servidor,  $this->usuario, $this->contrase�a, $this->bd)){
                
                die('Error de conexi�n (' . mysqli_connect_errno() . ')' . mysqli_connect_error());
                
            }
            
            echo '�xito... '. $this->con->host_info."<br>";
            
            $this->isOpen = true;
            
        }else{
            
            echo 'La conexi�n ya hab�a sido establecida.<br>';
            
        }
        
        
    }
    
    public function CerrarConexion(){
        
        if($this->isOpen){
            
            $this->con->close();
            echo 'Conexi�n cerrada con �xito.<br>';
            $this->isOpen = false;
            
        }else{
            
            echo 'La conexi�n no hab�a sido establecida.<br>';
            
        }
        
    }
    
    public function EjecutarConsulta($sql){
        
        //Array donde almacenaremos los resultados de salida.
        $ret=NULL;
        //Boleano que determinar� si la conexi�n estaba abierta.
        $ConClose = false;
        
        //Si la conexion no est� abierta la abrimos.
        if(!$this->isOpen){
            
            $this->AbrirConexion();
            
            $ConClose = true;
            
        }
        
        //Ejectuamos la consulta
        $this->con->real_query($sql);
        
        //Obtenemos los datos de la consulta
        $resultado = $this->con->use_result();
        
        //Si hemos obtenido datos recorremos el Array.
        if($resultado){
                                    
            $ret=array();
            
            while($row=$resultado->fetch_array(MYSQLI_ASSOC)){
                
                array_push($ret,$row); //Afegim totes les files retornades a l'array de sortida
                    
            }
            //Liberamos la memoria de la consulta
            $resultado->free();

        }else{
            
            echo 'No se han obtenido datos de la consulta.';
        }
        
        //Si la conexi�n estaba cerrada antes de realizar la consulta la cerramos.
        if($ConClose){
            $this->CerrarConexion();
        }
        
        return $ret;
        
    }
    
    
}

