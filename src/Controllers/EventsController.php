<?php

namespace App\Controllers;
use App\Core\AbstractController;
use App\Core\EntityManager;
use App\Entity\{Events, StatsEvents, Agent};
use Doctrine\Common\Util\Debug;

class EventsController extends AbstractController
{
    public function listEvents()
    {
        //recibo nombre evento por post. Compruebo si tiene valor
        $eventname = isset ($_POST['evento']) ? $_POST['evento'] : NULL;

        // 1 obtengo el entity manager
        // 2 obtengo el repositorio de la clase
        // 3 llamo al método del repositorio que obtendrá la lista de eventos
        $em = (new EntityManager())->get(); 
        $eventsRepository = $em->getRepository(Events::class); 
        $eventslist = $eventsRepository->getListEvents();
       
        //inicializo las variables
        $mensaje = "";
        $agentsArray = []; // tendrá los nombres de los agentes que ha acudido al evento
        
       if (!empty($eventname)){
        // llamo el método que devuelve
        $event = $eventsRepository->getEvent($eventname);
 
        // obtengo el repositorio de la clase
        // llamo al método del repositorio que obtendrá la lista de statsevents cuyo id_event conincide con el id de la tabla event
        $statsEventsRepository = $em->getRepository(StatsEvents::class);
        $statsEvents = $statsEventsRepository->findBy(['id_event' => $event->getId_event()]);

        

        // si el evento tiene statsevents
            if ($statsEvents){
                // en cada registro obtengo el nombre del agente y si el aray no lo contiene, se lo añado
                foreach ($statsEvents as $one){
                    $agentName = $one->getAgent()->getAgentName();
                    if (!in_array($agentName, $agentsArray)){
                    array_push($agentsArray, $agentName);
                    }
                    $mensaje = "Al evento ha acudido:";
                }
                // si el evento no tiene estats, lo indico en el mensaje
            }else {
                $mensaje = "No acudieron agentes al evento";
            }
        } 

            $this->render("event.html", 
                [      
            "titulo" => "TWIG - ALBA",        
            "events" => $eventslist,
            "agents" => $agentsArray,
            "mensaje" => $mensaje,
            
            ]);  
        }
    
}