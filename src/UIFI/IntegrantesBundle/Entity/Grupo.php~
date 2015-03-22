<?php

namespace UIFI\IntegrantesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Grupo
 *
 * @ORM\Table("grupo")
 * @ORM\Entity(repositoryClass="UIFI\IntegrantesBundle\Repository\GrupoRepository")
 */
class Grupo
{
    /**
     * @var string
     * Identificador del grupo de investigacion.
     *
     * @ORM\Column(name="id", type="string", length=255)
     * @ORM\Id
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=255)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="gruplac", type="string", length=255)
     */
    private $gruplac;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="clasificacion", type="string", length=255)
     */
    private $clasificacion;

    /**
     * Facultdad a la que pertence  un grupo de investigación.
     *
     * @ORM\ManyToOne(targetEntity="Facultad", inversedBy="grupos" )
     * @ORM\JoinColumn(name="facultad_id" ,referencedColumnName="id")
    */
    protected $facultad;
    /**
     * Estudiantes que pertenecen a un grupo de investigacion.
     * @ORM\ManyToMany( targetEntity="Integrante", inversedBy="grupos", cascade={"remove","persist"})
     * @ORM\JoinTable(name="grupo_integrante")
    */
    protected $integrantes;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->integrantes = new \Doctrine\Common\Collections\ArrayCollection();
    }
    public function __toString(){
      return $this->nombre;
    }

    /**
     * Set id
     *
     * @param string $id
     * @return Grupo
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get id
     *
     * @return string 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     * @return Grupo
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
     * Set gruplac
     *
     * @param string $gruplac
     * @return Grupo
     */
    public function setGruplac($gruplac)
    {
        $this->gruplac = $gruplac;

        return $this;
    }

    /**
     * Get gruplac
     *
     * @return string 
     */
    public function getGruplac()
    {
        return $this->gruplac;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return Grupo
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set clasificacion
     *
     * @param string $clasificacion
     * @return Grupo
     */
    public function setClasificacion($clasificacion)
    {
        $this->clasificacion = $clasificacion;

        return $this;
    }

    /**
     * Get clasificacion
     *
     * @return string 
     */
    public function getClasificacion()
    {
        return $this->clasificacion;
    }

    /**
     * Set facultad
     *
     * @param \UIFI\IntegrantesBundle\Entity\Facultad $facultad
     * @return Grupo
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

    /**
     * Add integrantes
     *
     * @param \UIFI\IntegrantesBundle\Entity\Integrante $integrantes
     * @return Grupo
     */
    public function addIntegrante(\UIFI\IntegrantesBundle\Entity\Integrante $integrantes)
    {
        $this->integrantes[] = $integrantes;

        return $this;
    }

    /**
     * Remove integrantes
     *
     * @param \UIFI\IntegrantesBundle\Entity\Integrante $integrantes
     */
    public function removeIntegrante(\UIFI\IntegrantesBundle\Entity\Integrante $integrantes)
    {
        $this->integrantes->removeElement($integrantes);
    }

    /**
     * Get integrantes
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getIntegrantes()
    {
        return $this->integrantes;
    }
}
