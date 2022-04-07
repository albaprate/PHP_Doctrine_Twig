<?php

namespace App\Models;
use App\Core\Interfaces\IDataBase;
use mysqli;

class Tareas
{
    private IDataBase $database;
    public $datos = [];
    public $cabeceras = [];
    public function __construct(IDataBase $database)
    {
        $this->database = $database;        
    }    
    
    //esta función mira si los datos ya están en la bbdd o no
   /*  public function ComprobarExistenciaDatos($name, $password)
    {      
        if ($name == NULL | $password == NULL ) // si $name y $password no tienen valor se devuelve vacío
        {
            return "";
        }else{          
            //Si las variables tienen valor, hago un select para comprobar si los datos están en la bbdd
            $sql = "SELECT agent_name 
                    FROM agent 
                    WHERE agent_name = '".$name."' ";    
            return mysqli_num_rows($this->database->actionSQL($sql)); // devuelve 1 si el registro existe o 0 en caso contrario 
        }     
    } */

    //inserto la información del formulario de resgristro a la bbdd, así el usuario estará registrado
  /*   public function InsertUser($name, $password, $faction)
    {
        $encryptpassword = hash('sha256', $password);  //encripto la contraseña
        
        $sql = "INSERT INTO agent (agent_name, password, faction)
                VALUES ('$name', '$encryptpassword', '$faction')";  
        
        //inserto los datos en la tabla                     
        $insert = $this->database->actionSQL($sql);       
        return $insert;
    } */


    ///subir estadisticas    
    //el array lo divido en dos array, uno de cabeceras y otro con los campos
/*      public function ObtenerDatos($info)
     {
         $registros = explode ( "\n", $info);  //separo por tabulación   
         $cabeceras = explode ( "\t", $registros[0]);       
         $datos = explode ( "\t", $registros[1]);     
         $this->cabeceras = $cabeceras;    // guardo el valor en los atributos de clase
         $this->datos = $datos;        
     }
 */
     //de forma dinámica, 
      public function ObtenerValor($array)
     {
        $obtenerValor = array_shift($array); // obtengo el 1er elemento del array       
        $clave = key($obtenerValor); //obtengo la clave del array
        $valor = $obtenerValor[$clave]; //accedo al valor que hay bajo esa clave
        return $valor;
     } 

    //obtengo el id_span
    public function SelectId_span()
    {        
        $sql = "SELECT id_span 
                FROM span 
                WHERE time_span ='".$this->datos[0]."' "; //= time_span
        $sql_time_span = $this->database->executeSQL($sql);         
        $time_span = $this->ObtenerValor($sql_time_span);         
        return $time_span; 
    }
    //obtengo el id_agent
    public function SelectId_agent()
    {
        $sql = "SELECT id_agent 
                FROM agent 
                WHERE agent_name = '".$this->datos[1]."' "; // = id_agent        
        $sql_id_agent = $this->database->executeSQL($sql);         
        $id_agent = $this->ObtenerValor($sql_id_agent); 
        return $id_agent; 
    }

    //obtengo el id_upload
    public function SelectId_upload()
    {  
        $sql = "SELECT id_upload 
                FROM uploads 
                ORDER BY id_upload DESC LIMIT 1";
        $sql_id_upload = $this->database->executeSQL($sql);  
        $id_upload = $this->ObtenerValor($sql_id_upload); 
        return $id_upload; 
    }

    // inserto los datos obtenidos del array y los métodos en la tabla uploads
    public function InsertUpload()
    {      
         $date = $this->datos[3];
         $time = $this->datos[4];      
                  
        $sql = "INSERT INTO uploads (date, time, id_agent, time_span) 
        VALUES ('$date', '$time', '".$this->SelectId_agent()."', '".$this->SelectId_span()."')";
        return $this->database->actionSQL($sql);       
    }

    //formateo los campos para insertarlos posteriormente
    public function CamposStats()
    {        
        $campos = "";
        $contador = 0;      ;
        for ($i = 5; $i <count($this->datos); $i++) //recorro el array
        {
            if ($i > 0){
                $campos .= ", " .$this->datos[$i]; //separo los campos por comas
            } else{
                $campos .= $this->datos[$i]; //al 1er campo no le añado la coma
            }  
            $contador++;         
        }       
        return $campos; //todos los campos 
    }

    //formateo las cabeceras para insertarlas posteriormente
    public function CabecerasCampos()
    {       
        $cabeceras = "";
        $contador = 0;

        for ($i = 5; $i <count($this->cabeceras)-1; $i++) //recorro el array
        {
            $minusculas = strtolower($this->cabeceras[$i]); // convierto las letras a minúsculas
            $formato = str_replace(" " , "_", $minusculas); // reemplazo pos espacios por guiones bajos

             if($formato == "mission_day(s)_attended"){ // como el paréntesis es un carácter especial
                $formato = "`mission_day(s)_attended`"; // añado comillas
            }
            if($formato == "nl-1331_meetup(s)_attended"){
                $formato = "`nl-1331_meetup(s)_attended`";
            } 

            if ($i > 5){               
                $cabeceras .= ", " .$formato; //separo los campos por comas
            } else{
                $cabeceras .= $formato;
            }           
            $contador++;
        }               
        return $cabeceras; // todas las cabeceras
    }

    //inserto los campos y los datos en stats
    public function InsertStat()
    {         
       $sql = "INSERT INTO stats (id_upload, id_agent, ".$this->CabecerasCampos().") 
              VALUES (".$this->SelectId_upload().", ".$this->SelectId_agent()." ".$this->CamposStats().")";       
       $insert = $this->database->actionSQL($sql);        
    }


    // datos perfil
    // select de los datos del usuario actual cuyo nombre está guardado en una variable de sesión
 /*    public function Profile()    
    {            
        $sql = "SELECT agent_name, faction, level, livetime_ap, current_ap 
               FROM agent INNER JOIN stats ON agent.id_agent=stats.id_agent 
               WHERE agent_name='".$_SESSION["nombre"]."' ORDER BY id_stats DESC LIMIT 1";       
        return $this->database->executeSQL($sql);       
    } */

    //comparar estadísticas

    //obtengo un select con los datos de cada campo, y lo ordeno según el campo que llega por post
    public function OrdenarDatosPorCampo($campo)
    {        
       $sql = "SELECT agent_name, livetime_ap, portals_discovered, hacks, resonators_destroyed
               FROM stats 
               INNER JOIN agent ON stats.id_agent = agent.id_agent ORDER BY $campo DESC";              
       return $this->database->executeSQL($sql);
    }

 
    
}