<?php

namespace App\Controllers;
use App\Core\AbstractController;
use App\Core\EntityManager;
use App\Entity\{Agent, StatsEvents, Events};
use Doctrine\Common\Util\Debug;


class ProfileController extends AbstractController
{
    public function showProfile()
    {
        // 1 obtengo el entity manager
        // 2 obtengo el repositorio de la clase
        $em = (new EntityManager())->get(); 
        $agentRepository = $em->getRepository(Agent::class); 
        $StatsEventsRepository = $em->getRepository(StatsEvents::class); 
        
        //llamo al método del repositorio, devuelve la fila agente
        $profile = $agentRepository->Profile();
        $idAgent = $profile->getIdAgent(); //accedo al campo id_agent

        //busco por id del agente los statsEvents 
        $statsEventAgent = $StatsEventsRepository->findBy(['id_agent'=> $idAgent]);

      
        $mensaje = "";
        $arrayDiff = [];
        // si el agente tiene statsevents
        if($statsEventAgent){

            $mensaje = "Puntos que ha mejorado el agente entre la 1era y última estadística subida, por cada evento:";

            $event = "";
            $EventsNameArray = [];
           
            //itero los statsevents y accedo al nombre del evento al que pertenecen
            foreach ($statsEventAgent as $statEvent){
                $eventsName = $statEvent->getEvent()->getName_event(); //guardo nombre evento
                // si el array no contiene el nombre, añado el nombre al array
                if (!in_array($eventsName, $EventsNameArray)){
                    array_push($EventsNameArray, $eventsName);
                }
            }

             // obtengo el repositorio de la clase
            $eventsRepository = $em->getRepository(Events::class); 
        
            $statsEvents = "";
            $statsEventsArray = [];
            //itero los nombres de los eventos, de cada uno obtengo los statsEvents asociados
            // añado a un array los statsevents que pertenecen a cada evento
            foreach($EventsNameArray as $eventName){
                $statsEvents = $eventsRepository->findOneBy(['name_event' => $eventName])->getStatsEvents(); 
                array_push($statsEventsArray, $statsEvents);
            }

       
           
            $i = 0;  // esta variable la uso para poder iterar los nombres de los eventos y en la vista tener los datos con el evento perteneciente
            //itero los statsevents de cada evento
            foreach($statsEventsArray as $event){

                $length = count($event); // length de cada evento, es decir la cantidad de statsevents que tiene
                $statsEvents = [$event[$length-1], $event[0]]; // guardo el último y el primero
                echo "</pre>";
                    Debug::dump($statsEvents);
        
                // al último registro le resto el 1ero, campo por campo
                $livetimeDiff = $statsEvents[0]->getLifetime_ap() - $statsEvents[1]->getLifetime_ap();
                $uniquePvisitedDiff = $statsEvents[0]->getUnique_portals_visited() - $statsEvents[1]->getUnique_portals_visited();
                $resDeployed = $statsEvents[0]->getResonators_deployed() - $statsEvents[1]->getResonators_deployed();
                $linkCreatedDiff = $statsEvents[0]->getLinks_created() - $statsEvents[1]->getLinks_created();
                $fieldCreatedDiff = $statsEvents[0]->getControl_fields_created() - $statsEvents[1]->getControl_fields_created();
                $rechargedDiff = $statsEvents[0]->getXm_recharged() - $statsEvents[1]->getXm_recharged();
                $pCapturedDiff = $statsEvents[0]->getPortals_captured() - $statsEvents[1]->getPortals_captured();
                $hacksDiff = $statsEvents[0]->getHacks() - $statsEvents[1]->getHacks();
                $resDestroyedDiff = $statsEvents[0]->getResonators_destroyed() - $statsEvents[1]->getResonators_destroyed(); 
    
                // pongo los resultados en un array así como el nombre del evento 
                $diff = [$EventsNameArray[$i], $livetimeDiff, $uniquePvisitedDiff, $resDeployed, $linkCreatedDiff, 
                        $fieldCreatedDiff, $rechargedDiff, $pCapturedDiff, $hacksDiff, $resDestroyedDiff]; 
                
                // añado a un array vacío el array resultante
                array_push($arrayDiff, $diff); 
                $i += 1; // aumento su valor para iterar
            } 
            //si el agente no tiene statsevents
            } else {
                $mensaje = "";
        }

       
         

        //render() de la clase que hereda para llamar a la plantilla TWIG y pasarle parámetros
        $this->render("profile.html", 
                [      
            "titulo" => "TWIG - ALBA" ,        
            "userdata" => $profile,
            "diference" => $arrayDiff,
            "mensaje" => $mensaje,
        ]);
    }
}