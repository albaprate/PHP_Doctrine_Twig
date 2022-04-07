<?php

namespace App\Entity;
use App\Repository\AgentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity(repositoryClass=AgentRepository::class)
 * @ORM\Table(name="agent")
 */

class Agent
{

    //campos tabla
    /**
     * @ORM\Id
     * @ORM\Column(type="integer", name="id_agent")
     * @ORM\GeneratedValue
     */
    private $idAgent;

    /**  @ORM\Column(type="string", length="100", name="agent_name", unique=true)*/
    private $agentName;

    /**  @ORM\Column(type="string", length="64", name="`password`")*/
    private $password;
 
    /**  @ORM\Column(type="string", length="100")*/
    private $faction;

    //relaciones tablas
    /**
     * 1 Agent tiene N Uploads
     * @ORM\OneToMany(targetEntity="Uploads", mappedBy="agent")
     */
    private $uploads;

    /**
     * 1 agent tiene N Stats
     * @ORM\OneToMany(targetEntity="Stats", mappedBy="agent")
     */
    private $stats;

    /**
     * 1 agent tiene N StatsEvents
     * @ORM\OneToMany(targetEntity="StatsEvents", mappedBy="agent")
     */
    private $statsEvents;

    public function __construct() {
        $this->stats = new ArrayCollection();
        $this->uploads = new ArrayCollection();
        $this->statsEvents = new ArrayCollection();
    }
    
    //SET
    public function setUploads($uploads){
        $this->uploads = $uploads;
        return $this;
    } 
   
    public function setStats($stats){
        $this->stats = $stats;
        return $this;
    }
  
    public function setStatsEvents($statsEvents){
        $this->statsEvents = $statsEvents;
        return $this;
    }
   
    public function setAgentName($agentName){
        $this->agentName = $agentName;
        return $this;
    }
  
    public function setPassword($password){
        $this->password = $password;
        return $this;
    }

    public function setFaction($faction){
        $this->faction = $faction;
        return $this;
    }

    //GET
    public function getUploads(){
        return $this->uploads;
    }
 
    public function getStats(){
        
        return $this->stats;
    }
    public function getStatsEvents(){
        return $this->statsEvents;
    }

    public function getIdAgent(){
        return $this->idAgent;
    }

    public function getAgentName(){
        return $this->agentName;
    }

    public function getPassword(){
        return $this->password;
    }
    
    public function getFaction(){
        return $this->faction;
    }

          /**
     * Set un agent tiene muchos Uploads. Este es el lado inverso.
     *
     * @return  self
     */ 
    public function addUploads(Uploads $upload): self
    {
        if (!$this->uploads->contains($upload)) { // si el registro no está en bbdd
            $this->uploads[] = $upload; // lo añade al final del arrayCollection
            $upload->setAgent($this); //setAgent es el campo de relación de la tabla uploads
        }
        return $this;
    }

    public function addStats(Stats $stat): self
    {
        if (!$this->stats->contains($stat)) { // si el registro no está en bbdd
            $this->stats[] = $stat; // lo añade al final del arrayCollection
            $stats->setAgent($this); //setAgent es el campo de relación de la tabla stats
        }
        return $this;
    }

    public function addStatsEvents(StatsEvents $statEvent): self
    {
        if (!$this->statsEvents->contains($statEvent)) { // si el registro no está en bbdd
            $this->statsEvents[] = $statEvent; // lo añade al final del arrayCollection
            $statsEvents->setAgent($this); //setStatEvents es el campo de relación de la tabla stats
        }
        return $this;
    }
}

?>