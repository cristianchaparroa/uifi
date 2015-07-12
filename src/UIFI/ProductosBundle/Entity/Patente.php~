<?php

namespace UIFI\ProductosBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Clase que mapea un Artículo de investigación
 *
 * @ORM\Table(name="patente")
 * @ORM\Entity(repositoryClass="UIFI\ProductosBundle\Repository\PatenteRepository")
 */
class Patente
{

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="string", length=255)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
    * Titulo del artículo de investigación
     * @var string
     *
     * @ORM\Column(name="titulo", type="string", length=10000,nullable=true)
     */
    private $titulo;
    /**
     * Año en el que fue publicado la patente
     * @var \DateTime
     *
     * @ORM\Column(name="anual", type="string",length=255,nullable=true)
     */
    private $anual;

    /**
     * Integrantes de un grupo de un investigacion que publicaron la patente.
     *
     * @ORM\ManyToMany(targetEntity="UIFI\IntegrantesBundle\Entity\Integrante", mappedBy="patentes")
    */
    private $integrantes;

    /**
     * Codigo del grupo en el cual fue publicado el articulo
     *
     * @ORM\Column(name="grupo", type="string", length=255)
     */
    private $grupo;

    /**
     * Tipo de proceso con el que se creo la patente :
     *    MANUAL
     *    AUTOMATICO
     * @var string
     *
     * @ORM\Column(name="proceso", type="string", length=10,nullable=true)
     */
    private $proceso;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->integrantes = new \Doctrine\Common\Collections\ArrayCollection();
    }




    /**
     * Set id
     *
     * @param string $id
     * @return Patente
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
     * Set titulo
     *
     * @param string $titulo
     * @return Patente
     */
    public function setTitulo($titulo)
    {
        $this->titulo = $titulo;

        return $this;
    }

    /**
     * Get titulo
     *
     * @return string
     */
    public function getTitulo()
    {
        return $this->titulo;
    }

    /**
     * Set anual
     *
     * @param string $anual
     * @return Patente
     */
    public function setAnual($anual)
    {
        $this->anual = $anual;

        return $this;
    }

    /**
     * Get anual
     *
     * @return string
     */
    public function getAnual()
    {
        return $this->anual;
    }

    /**
     * Set grupo
     *
     * @param string $grupo
     * @return Patente
     */
    public function setGrupo($grupo)
    {
        $this->grupo = $grupo;

        return $this;
    }

    /**
     * Get grupo
     *
     * @return string
     */
    public function getGrupo()
    {
        return $this->grupo;
    }

    /**
     * Set proceso
     *
     * @param string $proceso
     * @return Patente
     */
    public function setProceso($proceso)
    {
        $this->proceso = $proceso;

        return $this;
    }

    /**
     * Get proceso
     *
     * @return string
     */
    public function getProceso()
    {
        return $this->proceso;
    }

    /**
     * Add integrantes
     *
     * @param \UIFI\IntegrantesBundle\Entity\Integrante $integrantes
     * @return Patente
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
