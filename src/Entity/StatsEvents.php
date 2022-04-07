<?php

namespace App\Entity;
use App\Repository\StatsEventsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=StatsEventsRepository::class)
 * @ORM\Table(name="stats_events")
 */

class StatsEvents
{
    // relaciones tablas
     /**
     * N StatsEvents tiene 1 Agent
     * @ORM\ManyToOne(targetEntity="Agent", inversedBy="statsEvents")
     * @ORM\JoinColumn(name="id_agent", referencedColumnName="id_agent")
     */
    private $agent;
     /**
     * N StatsEvents tiene 1 Events
     * @ORM\ManyToOne(targetEntity="Events", inversedBy="statsEvents")
     * @ORM\JoinColumn(name="id_event", referencedColumnName="id_event")
     */
    private $event;
     /**
     * 1 StatsEvents tiene 1 Uploads
     * @ORM\ManyToOne(targetEntity="Uploads", inversedBy="statsEvents")
     * @ORM\JoinColumn(name="id_upload", referencedColumnName="id_upload")
     */
    private $upload;

    //campos tabla
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    private $id_stats;

    /**  @ORM\Column(type="integer")*/
    private $id_event;

    /**  @ORM\Column(type="integer")*/
    private $id_upload;

    /**  @ORM\Column(type="integer")*/
    private $id_agent;

    /**  @ORM\Column(type="integer")*/
    private $lifetime_ap;

        /**  @ORM\Column(type="integer", nullable=true)*/
    private $unique_portals_visited;

        /**  @ORM\Column(type="integer", nullable=true)*/
    private $resonators_deployed;

        /**  @ORM\Column(type="integer", nullable=true)*/
    private $links_created;

        /**  @ORM\Column(type="integer", nullable=true)*/
    private $control_fields_created;

        /**  @ORM\Column(type="integer", nullable=true)*/
    private $xm_recharged;

        /**  @ORM\Column(type="integer", nullable=true)*/
    private $portals_captured;
    
        /**  @ORM\Column(type="integer", nullable=true)*/
    private $hacks;

    /**  @ORM\Column(type="integer", nullable=true)*/
    private $resonators_destroyed;

    //SET
    public function setAgent($agent){
        $this->agent = $agent;
        return $this;
    }

    public function setEvent($event){
        $this->event = $event;
        return $this;
    }

    public function setUpload($upload){
        $this->upload = $upload;
        return $this;
    }

    public function setId_event($id_event){
        $this->id_event = $id_event;
        return $this;
    }

    public function setId_upload($id_upload){
        $this->id_upload = $id_upload;
        return $this;
    }
    
    public function setId_agent($id_agent){
        $this->id_agent = $id_agent;
        return $this;
    }
    
    public function setLifetime_ap($lifetime_ap){
        $this->lifetime_ap = $lifetime_ap;
        return $this;
    }

    public function setUnique_portals_visited($unique_portals_visited){
        $this->unique_portals_visited = $unique_portals_visited;
        return $this;
    }

    public function setResonators_deployed($resonators_deployed){
        $this->resonators_deployed = $resonators_deployed;
        return $this;
    }

    public function setLinks_created($links_created){
        $this->links_created = $links_created;
        return $this;
    }

    public function setControl_fields_created($control_field_created){
        $this->control_field_created = $control_field_created;
        return $this;
    }

    public function setXm_recharged($xm_recharged){
        $this->xm_recharged = $xm_recharged;
        return $this;
    }

    public function setPortals_captured($portals_captured){
        $this->portals_captured = $portals_captured;
        return $this;
    }

    public function setHacks($hacks){
        $this->hacks = $hacks;
        return $this;
    }

    public function setResonators_destroyed($resonators_destroyed){
        $this->resonators_destroyed = $resonators_destroyed;
        return $this;
    }

    //GET
    public function getAgent(){
        return $this->agent;
    }

    public function getEvent(){
        return $this->event;
    }
 
    public function getUpload(){
        return $this->upload;
    }

    public function getId_stats(){
        return $this->id_stats;
    }

    public function getId_event(){
        return $this->id_event;
    }

    public function getId_upload(){
        return $this->id_upload;
    }

    public function getId_agent(){
        return $this->id_agent;
    }

    public function getLifetime_ap(){
        return $this->lifetime_ap;
    }

    public function getUnique_portals_visited(){
        return $this->unique_portals_visited;
    }

    public function getResonators_deployed(){
        return $this->resonators_deployed;
    }

    public function getLinks_created(){
        return $this->links_created;
    }

    public function getControl_fields_created(){
        return $this->control_fields_created;
    }

    public function getXm_recharged(){
        return $this->xm_recharged;
    }

    public function getPortals_captured(){
        return $this->portals_captured;
    }

    public function getHacks(){
        return $this->hacks;
    }

    public function getResonators_destroyed(){
        return $this->resonators_destroyed;
    }



}

?>