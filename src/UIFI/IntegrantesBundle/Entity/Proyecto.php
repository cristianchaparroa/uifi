<?php

namespace UIFI\IntegrantesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Proyecto
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Proyecto
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
     * Nombre del proyecto curricular
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=255)
     */
    private $nombre;

    /**
      * Facultad a la que pertenece el proyecto curricular
      * @ORM\ManyToOne(targetEntity="Facultad", inversedBy="proyectos")
      * @ORM\JoinColumn(name="facultad_id", referencedColumnName="id")
      */
     protected $facultad;

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
     * @return Proyecto
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
     * Set facultad
     *
     * @param \UIFI\IntegrantesBundle\Entity\Facultad $facultad
     * @return Proyecto
     */
    public function setFacultad(\UIFI\IntegrantesBundle\Entity\Facultad $facultad = null)
    {
        $this->facultad = $facultad;

        return $this;
    }

    /**
     * Get facultad
     *
     * @return \UIFI\IntegrantesBundle\Entity\Facultad 
     */
    public function getFacultad()
    {
        return $this->facultad;
    }
}
