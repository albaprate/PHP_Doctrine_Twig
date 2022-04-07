<?php

namespace App\Entity;
use App\Repository\UploadsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UploadsRepository::class)
 * @ORM\Table(name="uploads")
 */

class Uploads
{
    //relaciones tablas
    /**
     * N Uploads tiene 1 Span
     * @ORM\ManyToOne(targetEntity="Span", inversedBy="uploads")
     * @ORM\JoinColumn(name="time_span", referencedColumnName="id_span")
     */
    private $span;
    /**
     * N Uploads tiene 1 Agent
     * @ORM\ManyToOne(targetEntity="Agent", inversedBy="uploads")
     * @ORM\JoinColumn(name="id_agent", referencedColumnName="id_agent")
     */
    private $agent;
    /**
     * 1 Uploads tiene 1 Stats
     * @ORM\OneToMany(targetEntity="Stats", mappedBy="upload")
     */
    private $stats;
      /**
     * 1 Uploads tiene 1 StatsEvents
     * @ORM\OneToMany(targetEntity="StatsEvents", mappedBy="upload")
     */
    private $statsEvents;

    //campos tabla
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    private $id_upload;

    /**  @ORM\Column(type="date")*/
    private $date;

    /**  @ORM\Column(type="time")*/
     private $time;

    /**  @ORM\Column(type="integer")*/
    private $id_agent;

    /**  @ORM\Column(type="integer", name="time_span")*/
    private $upload_time_span;

    /**  @ORM\Column(type="boolean")*/
    private $id_event;

    public function __construct() {
        $this->stats = new ArrayCollection();
        $this->statsEvents = new ArrayCollection();
    }

    //SET
    public function setSpan($span){
        $this->span = $span;
        return $this;
    } 
    
    public function setAgent($agent){
        $this->agent = $agent;
        return $this;
    } 
   
    public function setStats($stats){
        $this->stats= $stats;
        return $this;
    } 
    
    public function setStatsEvents($statsEvents){
        $this->statsEvents = $statsEvents;
        return $this;
    } 
   
    public function setDate($date){
        $this->date= $date;
        return $this;
    }
   
    public function setTime($time){
        $this->time= $time;
        return $this;
    }
   
    public function setId_agent($id_agent){
        $this->id_agent = $id_agent;
        return $this;
    }
  
    public function setTime_span($upload_time_span){
        $this->upload_time_span = $upload_time_span;
        return $this;
    }
   
    public function setId_event($id_event){
        $this->id_event = $id_event;
        return $this;
    }

    //GET
    public function getSpan(){
        return $this->span;
    }
    
    public function getAgent(){
        return $this->agent;
    }
    
    public function getStats(){
        return $this->stats;
    }
    
    public function getStatsEvents(){
        return $this->statsEvents;
    }

    public function getId_upload(){
        return $this->id_upload;
    }
    
    public function getDate($date){
        return $this->date;
    }
    
    public function getTime($time){
        return $this->time;
    }

    public function getId_agent(){
        return $this->id_agent;
    }
    
    public function getTime_span(){
        return $this->upload_time_span;
    }
    
    public function getId_event(){
        return $this->id_event;
    }


    public function addStats(Stats $stat): self
    {
        if (!$this->stats->contains($stat)) { // si el registro no está en bbdd
            $this->stats[] = $stat; // lo añade al final del arrayCollection
            $stats->setUpload($this); //setUpload es el campo de relación de la tabla stats
        }
        return $this;
    }

    public function addStatsEvents(StatsEvents $statEvent): self
    {
        if (!$this->statsEvents->contains($statEvent)) { // si el registro no está en bbdd
            $this->statsEvents[] = $statEvent; // lo añade al final del arrayCollection
            $statsEvents->setUpload($this); //setUpload es el campo de relación de la tabla stats
        }
        return $this;
    }

}

?>
