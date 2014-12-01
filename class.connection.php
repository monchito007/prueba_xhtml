<?php

/* 
 * Clase para conecta con la Base de Datos MySQL
 */

class Conexion{
    
    //Atributos
    private $con=NULL;
    private $servidor=NULL;
    private $usuario=NULL;
    private $contraseña=NULL;
    private $bd=NULL;
    private $isOpen=false;

    //Constructor
    function __construct($servidor=NULL,$usuario=NULL,$contraseña=NULL,$bd=NULL) {
        $this->SetServidor($servidor);
        $this->SetUsuario($usuario);
        $this->SetContraseña($contraseña);
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
    
    public function SetContraseña($contraseña){
        
        if(isset($contraseña)){
            $this->contraseña = $contraseña;
        }else{
            $this->contraseña = "12345";
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
        
        //Si la conexión no está abierta previamente
        if(!$this->isOpen){
            
            $this->con = mysqli_init();
            
            if(!$this->con){
                die('Falló mysqli_init');
            }
            
            if(!$this->con->real_connect($this->servidor,  $this->usuario, $this->contraseña, $this->bd)){
                
                die('Error de conexión (' . mysqli_connect_errno() . ')' . mysqli_connect_error());
                
            }
            
            echo 'Éxito... '. $this->con->host_info."<br>";
            
            $this->isOpen = true;
            
        }else{
            
            echo 'La conexión ya había sido establecida.<br>';
            
        }
        
        
    }
    
    public function CerrarConexion(){
        
        if($this->isOpen){
            
            $this->con->close();
            echo 'Conexión cerrada con éxito.<br>';
            $this->isOpen = false;
            
        }else{
            
            echo 'La conexión no había sido establecida.<br>';
            
        }
        
    }
    
    public function EjecutarConsulta($sql){
        
        //Array donde almacenaremos los resultados de salida.
        $ret=NULL;
        //Boleano que determinará si la conexión estaba abierta.
        $ConClose = false;
        
        //Si la conexion no está abierta la abrimos.
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
        
        //Si la conexión estaba cerrada antes de realizar la consulta la cerramos.
        if($ConClose){
            $this->CerrarConexion();
        }
        
        return $ret;
        
    }
    
    
}

