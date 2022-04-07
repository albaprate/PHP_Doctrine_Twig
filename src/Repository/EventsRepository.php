<?php
namespace App\Repository;

use App\Entity\Events;
use App\Core\EntityManager;
use Doctrine\ORM\EntityRepository;

class EventsRepository extends EntityRepository
{
    public function getListEvents(){
      // busca todos los registros de la entidad Events
      $events = $this->findAll();
      return $events;
    }

    //devuelve el registro cuyo nombre coincide con el parámetro
    public function getEvent($eventname){
      $event = $this->findOneBy(['name_event' => $eventname]);
      return $event;
    }
}


?>