<?php

namespace UIFI\IntegrantesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Facultad
 *
 * @ORM\Table( "facultad" )
 * @ORM\Entity
 */
class Facultad
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * Nombre de la facultad.
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=255)
     */
    private $nombre;

    /**
      * Proyectos curriculares que tiene una facultad.
      * @ORM\OneToMany(targetEntity="Grupo", mappedBy="facultad")
      */
    protected $grupos;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     * @return Facultad
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }
    /**
     * Constructor
     */
    public function __construct()
    {

    }

    public function __toString(){
        return $this->getNombre();
    }


    /**
     * Add grupos
     *
     * @param \UIFI\IntegrantesBundle\Entity\Grupo $grupos
     * @return Facultad
     */
    public function addGrupo(\UIFI\IntegrantesBundle\Entity\Grupo $grupos)
    {
        $this->grupos[] = $grupos;

        return $this;
    }

    /**
     * Remove grupos
     *
     * @param \UIFI\IntegrantesBundle\Entity\Grupo $grupos
     */
    public function removeGrupo(\UIFI\IntegrantesBundle\Entity\Grupo $grupos)
    {
        $this->grupos->removeElement($grupos);
    }

    /**
     * Get grupos
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getGrupos()
    {
        return $this->grupos;
    }
}
