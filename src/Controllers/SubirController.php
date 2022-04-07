<?php
namespace App\Controllers;
//use App\Core\DataBase;
//use App\Models\Tareas;
use App\Core\EntityManager;
use App\Core\AbstractController;
use App\Entity\{Agent,Events,Stats,Uploads,Span, StatsEvents};
use Doctrine\Common\Util\Debug;

class SubirController extends AbstractController{

    // subirEstadisticas() recibe en un textarea los datos de la actividad del usuario y hace un insert en la bbdd
    public function subirEstadisticas()
    {
        // recibo datos por POST
        // si los datos no tienen valor, lo establezco en NULL
        $info = isset($_POST['datos']) ? $_POST['datos'] : "";     
        $event = isset($_POST['checkevent']) ? $_POST['checkevent'] : false; // no retorna valor
        $eventname = isset ($_POST['evento']) ? $_POST['evento'] : NULL;

        // 1 obtengo el entity manager
        $em = (new EntityManager())->get(); 

        // si recibo post del formulario
        $mensaje = "";
        //si no hay estadísticas se indica que deben subirse
        if (empty($info)){
            $mensaje = "suba las estadísticas";
         //si hay estadísticas 
        }else{     
            // 1 obtengo el entity manager
            // 2 obtengo el repositorio de la clase
            $em = (new EntityManager())->get(); 
            $statsRepository = $em->getRepository(Stats::class); 
            //llamo al método del repositorio Stats
            $datos = $statsRepository->ObtenerDatos($info);
          
            // obj AGENT
            // obtengo el repositorio de la clase
            // método findOneBy() busca el registro por el nombre del agente 
            $agentRepository = $em->getRepository(Agent::class); 
            $agent = $agentRepository->findOneBy(['agentName' => $datos[1]]);

            // obj SPAN
            // obtengo el repositorio de la clase
            // método findOneBy() busca el registro por el nombre del timeSpan
            $spanRepository = $em->getRepository(Span::class); 
            $span = $spanRepository->findOneBy(['time_span' => $datos[0]]);
            
           
            // obtengo el repositorio de la clase
            $uploadsRepository = $em->getRepository(Uploads::class); 
           
            
            // INSERT INTO UPLOADS
            // instancio la clase y establezco los valores de los campos a insertar
            $upload = new Uploads();
            
            $upload->setDate(new \DateTime($datos[3]));
            $upload->setTime(new \DateTime($datos[4]));
            $upload->setAgent($agent);
            $upload->setSpan($span);
            $upload->setId_event($event); 
            
            //$agent->addUploads($upload);
            $em->persist($upload);
            $em->flush();
     
            //lista uploads por orden descendente por el id
            $uploadList = $uploadsRepository->findBy(array(), array('id_upload' => 'DESC'));
            //echo "</pre>";
            //Debug::dump($uploadList);
            // el último upload, en 1era posición
            $lastUpload = $uploadList[0];

            // si hay evento seleccionado
            if ($event) {
                
                //obj EVENT
                $eventsRepository = $em->getRepository(Events::class); 
                // llama al método pasándole en nombre del evento recibido por post y el repo devuelve un registro 
                $eventObj = $eventsRepository->getEvent($eventname);
            
                // INSERT INTO stats_events(id_event, id_upload, id_agent, lifetime_ap, ....)
                // instancio la clase y establezco los valores de los campos a insertar
                $statsevents = new StatsEvents();
             
                $statsevents
                    ->setEvent($eventObj)
                    ->setUpload($lastUpload)
                    ->setAgent($agent)
                    ->setLifetime_ap($datos[6])
                    ->setUnique_portals_visited($datos[8])
                    ->setResonators_deployed([9])
                    ->setLinks_created([10])
                    ->setControl_fields_created([11])
                    ->setXm_recharged([12])
                    ->setPortals_captured([13])
                    ->setHacks([14])
                    ->setResonators_destroyed([15]);
                
                //$agent->addStatsEvents($statsevents);
                $em->persist($statsevents);
                // $em->flush(); 
                $em->flush();

            //si no hay evento seleccionado
            } else {
                
                // INSERT INTO stats (id_upload, id_agent, level, lifetime_ap, current_ap, mission, meetup
                // instancio la clase y establezco los valores de los campos a insertar
                $stats = new Stats();

               $stats
                ->setUpload($lastUpload)
                ->setAgent($agent)
                ->setLevel($datos[5])
                ->setLifetime_ap($datos[6])
                ->setCurrent_ap($datos[7])
                ->setMission_day_attended($datos[16])
                ->setNl_meetup_attended($datos[17]); 
            
                $em->persist($stats);
                // $em->flush(); 
                $em->flush();
            }
        }

        //usa el método render() de la clase que hereda para llamar a la plantilla TWIG y pasarle parámetros
        $this->render("subirdatos.html", 
            [                      
                "titulo" => "TWIG - ALBA",   
                "mensaje" => $mensaje,             
            ]);
        }
}
?>