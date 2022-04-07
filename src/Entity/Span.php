<?php

namespace App\Entity;
use App\Repository\SpanRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SpanRepository::class)
 * @ORM\Table(name="span")
 */

class Span
{
    //relaciones tablas
      /**
     * 1 Span tiene N Uploads
     * @ORM\OneToMany(targetEntity="Uploads", mappedBy="span")
     */
    private $uploads;

    // campos tabla
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    private $id_span;

    /**  @ORM\Column(type="string", length="100", unique=true)*/
    private $time_span;

    public function __construct() {
        $this->uploads = new ArrayCollection();
    }

    //SET
    public function setUlpoads($uploads){
        $this->uploads = $uploads;
        return $this;
    }
    public function setTime_span($time_span){
        $this->time_span = $time_span;
        return $this;
    }

    //GET
    public function getId_span(){
        return $this->id_span;
    }
    public function getTime_span(){
        return $this->time_span;
    }

    public function getUploads(){
        return $this->uploads;
    }

    public function addUploads(Uploads $upload): self
    {
        if (!$this->uploads->contains($upload)) { // si el registro no está en bbdd
            $this->uploads[] = $upload; // lo añade al final del arrayCollection
            $uploads->setSpan($this); //setSpan es el campo de relación de la tabla stats
        }
        return $this;
    }
}

?>