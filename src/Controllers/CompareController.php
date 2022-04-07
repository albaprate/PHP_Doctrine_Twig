<?php

namespace App\Controllers;
//use App\Models\Tareas;
//use App\Core\DataBase;
use App\Core\EntityManager;
use App\Core\AbstractController;
use Doctrine\Common\Util\Debug;
use App\Entity\{Agent, Stats};

class CompareController extends AbstractController
{
    public function compare()
    {
        //$tareas = new Tareas(new DataBase); 
        $data = ""; //si datos está vacío la vista solo mostrará el formulario
        $campo = isset($_POST['campo']) ? $_POST['campo'] : NULL;       
    

        if ($campo != NULL){
            //$datos = $tareas->OrdenarDatosPorCampo($campo);  // si datos tiene valor la vista mostrará el ranking
            
            
            // 1 obtengo el entity manager
            // 2 obtengo el repositorio de la clase
            // 3 llamo al método del repositorio que buscará los stats ordenados según el campo recibido por post
            $em = (new EntityManager())->get(); 
            $statsRepository = $em->getRepository(Stats::class); 
            $data = $statsRepository->getStadistics($campo);

            //echo "<pre/>";
            //Debug::dump($data);
       
        }
        
        $this->render("ranking.html", 
                [          
            "titulo" => "TWIG - ALBA",
            "datos" => $data,
            "campo" => $campo        
        ]);
    }
}

?>