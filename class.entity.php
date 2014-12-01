<?php

/* 
 * Classe para acceder a la base de datos.
 */

define(KType, 0);
define(KSize, 1);
define(KNot_Nullable, 2);
define(KNot_Visible, 3);
define(KReadOnly, 4);
define(KDisplayText, 5);

class Entidad{
    
    //Contantes que servirán para indicar el nombre que necesitamos.
    const KType = 0;
    const KSize = 1;
    const KNot_Nullable = 2;
    const KNot_Visible = 3;
    const KReadOnly = 4;
    const KDisplayText = 5;
    
    //Atributos
    
    //Nombre de la tabla
    protected $nombre_tabla;
    
    //Campos de la tabla base
    protected $campos = NULL;
    
    //Propiedades de la tabla base
    protected $propiedades = NULL;
    
    public function GetNombreTabla(){
        
        return $this->nombre_tabla;
        
    }
    
    public function GetCampos(){
        
        return $this->campos;
        
    }
    
    public function GetPropiedades(){
        
        return $this->propiedades;
        
    }
    
    public function SetNombreTabla($NombreTabla){
        
        $this->nombre_tabla = $NombreTabla;
        
    }
    
    public function SetCampos($Campos){
        
        $this->campos = $Campos;
        
    }
    
    public function SetPropiedades($Propiedades){
        
        $this->propiedades = $Propiedades;
        
    }
    
    //Metodos
    
    //Metodo para generar el comando Select
    public function get_select_cmd($where=NULL){
        
        $cmd = "SELECT * FROM ".$this->nombre_tabla;
        
        if(isset($where)){
            
            $cmd = $cmd . " WHERE ".$where;
            
        }
        
        return $cmd;
        
    }
    
    //Metodo para generar el comando Insert
    public function get_insert_cmd($values){
        
        //Añadimos las comas a los valores de tipo string
        foreach ($this->propiedades as $clave => $valor) {
            
            if($valor[KType]=='char'){
                
                $values[$clave]="'".$values[$clave]."'";
                
            }
            
        }
        
        //Obtenemos el array con los nombres de los campos.
        $campos = $this->GetCampos();
        
        //Añadimos las comas a los nombres de campo
        /*
        foreach ($campos as $clave => &$valor){
            
            $valor="'".$valor."'";
            
        }
        */
        
        $column_string = implode(",", $campos);
        
        $values_string = implode(",", $values);
        
        $cmd = "INSERT INTO ".$this->nombre_tabla." (".$column_string.") values(".$values_string.")";
        
        return $cmd;
        
    }
    
    public function get_update_cmd($values,$where=NULL){
        
        foreach ($this->propiedades as $clave => $valor){
            
            if($valor[KType]=='char'){
                
                $values[$clave] = $clave."='".$values[$clave]."'";
                
            }else{
                
                $values[$clave] = $clave."=".$values[$clave];
                
            }
            
        }
        
        $values_string = implode(",",$values);
        
        $cmd = "UPDATE ".$this->nombre_tabla." SET ".$values_string;
        
        if(isset($where)){
            $cmd = $cmd . " WHERE " .$where;
        }
        
        return $cmd;
        
    }
    
    public function get_delete_cmd($where){
        
        $cmd = "DELETE FROM ".$this->nombre_tabla." WHERE ".$where;
        
        return $cmd;
        
    }
    
    public function MostrarTablaDatos($res){
        
        //Comprobamos que res contenga datos.
        if(!$res){            
            die('La consulta no contiene datos.');            
        }
        
        //Comprobamos que res sea un array
        if(gettype($res)!='array'){            
            die('El tipo de datos no es valido.');            
        }
        
        echo "<table summary='Resultados de la consulta'>";
        echo "<caption>Tabla '".$this->nombre_tabla."'</caption>";
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

    }
    
}

class entContacto extends Entidad{
    
    public function __construct() {
        
        $this->SetNombreTabla("contacto");
        $this->SetCampos(array("nombre","email","telefono"));
        $this->SetPropiedades( array(
            
            "nombre"=>array("char",30,0,0,0,"Nombre"),
            "email"=>array("char",80,0,0,0,"E-mail"),
            "telefono"=>array("char",9,0,0,0,"Telefono")
            
        ));
        
    }
    
}

class MostrarDatos extends Entidad{
    
    
    
}
