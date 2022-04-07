<?php

namespace App\Entity;
use App\Repository\EventsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EventsRepository::class)
 * @ORM\Table(name="events")
 */
class Events
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer", name="id_event")
     * @ORM\GeneratedValue
     */
    private $id_event;

    /**  @ORM\Column(type="string", length="100", unique=true)*/
    private $name_event;

    /**  @ORM\Column(type="string", length="100")*/
    private $alias_event;

    /**  @ORM\Column(type="string", length="250", nullable=true)*/
    private $descrip_event;

    /**  @ORM\Column(type="date")*/ 
    private $date_event;

    /**  @ORM\Column(type="string", length="250")*/
    private $place_event;

    //relaciones tablas
    /**
     * 1 Events tiene N StatsEvents
     * @ORM\OneToMany(targetEntity="StatsEvents", mappedBy="event")
     */
    private $statsEvents;

    public function __construct() {
        $this->statsEvents = new ArrayCollection();
    }

    //SET
    public function setName_event($name_event){
        $this->name_event = $name_event;
        return $this;
    }
   
    public function setAlias_event($alias_event){
        $this->alias_event = $alias_event;
        return $this;
    }
   
    public function setDescrip_event($descrip_event){
        $this->descrip_event = $descrip_event;
        return $this;
    }
   
    public function setDate_event($date_event){
        $this->date_event = $date_event;
        return $this;
    }
   
    public function setPlace_event($place_event){
        $this->place_event = $place_event;
        return $this;
    }

    public function setStatsEvents($statsEvents){
        $this->statsEvents = $statsEvents;
        return $this;
    }

    //GET
    public function getId_event(){
        return $this->id_event;
    }

    public function getName_event(){
        return $this->name_event;
    }
    
    public function getAlias_event(){
        return $this->alias_event;
    }
    
    public function getDescrip_event(){
        return $this->descrip_event;
    }
    
    public function getDate_event(){
        return $this->date_event;
    }
    
    public function getPlace_event(){
        return $this->place_event;
    }

    public function getStatsEvents(){
        return $this->statsEvents;
    }

    public function addStatsEvents(StatsEvents $statEvent): self
    {
        if (!$this->statsEvents->contains($statEvent)) { // si el registro no está en bbdd
            $this->statsEvents[] = $statEvent; // lo añade al final del arrayCollection
            $statsEvents->setEvent($this); //setStatEvents es el campo de relación de la tabla stats
        }
        return $this;
    }
}

?>