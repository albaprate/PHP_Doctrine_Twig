<?php

namespace App\Entity;
use App\Repository\StatsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=StatsRepository::class)
 * @ORM\Table(name="stats")
 */

class Stats
{

    // relaciones tablas
    /**
     * 1 Stats 1 Uploads
     * @ORM\ManyToOne(targetEntity="Uploads", inversedBy="stats")
     * @ORM\JoinColumn(name="id_upload", referencedColumnName="id_upload")
     */
    private $upload;
    /**
     * N Stats tiene 1 Agent
     * @ORM\ManyToOne(targetEntity="Agent", inversedBy="stats")
     * @ORM\JoinColumn(name="id_agent", referencedColumnName="id_agent")
     */

    private $agent;
    
    // campos tabla
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    private $id_stats;

    /**  @ORM\Column(type="integer")*/
    private $id_upload;

    /**  @ORM\Column(type="integer")*/
    private $id_agent;

    /**  @ORM\Column(type="integer")*/
    private $level;

    /**  @ORM\Column(type="integer")*/
    private $lifetime_ap;

    /**  @ORM\Column(type="integer")*/
    private $current_ap;

        /**  @ORM\Column(type="integer", name="`mission_day(s)_attended`", nullable=true)*/
    private $mission_day_attended;

        /**  @ORM\Column(type="integer", name="`nl-1331_meetup(s)_attended`", nullable=true)*/
    private $nl_meetup_attended;

    //SET
    public function setUpload($upload){
        $this->upload = $upload;
        return $this;
    } 

    public function setAgent($agent){
        $this->agent = $agent;
        return $this;
    }
    public function getUpload(){
        return $this->upload;
    }
   
    public function setId_upload($id_upload){
        $this->id_upload = $id_upload;
        return $this;
    }
   
    public function setId_agent($id_agent){
        $this->id_agent = $id_agent;
        return $this;
    }
   
    public function setLevel($level){
        $this->level = $level;
        return $this;
    }
    
    public function setLifetime_ap($lifetime_ap){
        $this->lifetime_ap = $lifetime_ap;
        return $this;
    }
   
    public function setCurrent_ap($current_ap){
        $this->current_ap = $current_ap;
        return $this;
    }
   
    public function setMission_day_attended($mission_day_attended){
        $this->mission_day_attended = $mission_day_attended;
        return $this;
    }
  

    public function setNl_meetup_attended($nl_meetup_attended){
        $this->nl_meetup_attended = $nl_meetup_attended;
        return $this;
    }

    //GET
    public function getAgent(){
        return $this->agent;
    }

    public function getId_stats(){
        return $this->id_stats;
    }
    
    public function getId_upload(){
        return $this->id_upload;
    }
    
    public function getId_agent(){
        return $this->id_agent;
    }
    
    public function getLevel(){
        return $this->level;
    }
    
    public function getLifetime_ap(){
        return $this->lifetime_ap;
    }
    
    public function getCurrent_ap(){
        return $this->current_ap;
    }

    public function getMission_day_attended(){
        return $this->mission_day_attended;
    }

    public function getNl_meetup_attended(){
        return $this->nl_meetup_attended;
    }

}

?>