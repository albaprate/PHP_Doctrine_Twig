<?php
namespace App\Repository;

use App\Entity\Stats;
use App\Core\EntityManager;
use Doctrine\ORM\EntityRepository;


class StatsRepository extends EntityRepository
{

    public $cabeceras = []; 
    // obtengo los campos que necesito del txt
    public function ObtenerDatos($info)
    {
        $registros = explode ( "\n", $info);  //separo por salto de línea   
        $cabeceras = explode ( "\t", $registros[0]);  //separo por tabulación
        $datos = explode ( "\t", $registros[1]);    //separo por tabulación
        
        $this->cabeceras = $cabeceras;  // guardo el valor en los atributos de clase
        return $datos;   // obtengo los valores que insertaré en la bbdd
    }

    // obtengo todos los stats ordenados por un campo 
    public function getStadistics($campo){
        $estadisticas = $this->findBy([],[$campo => 'DESC']);
        return $estadisticas;
    }
}


?>