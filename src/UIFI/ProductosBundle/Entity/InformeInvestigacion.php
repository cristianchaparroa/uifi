<?php

namespace UIFI\ProductosBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Ediciones
 *
 * @ORM\Table("informe_investigacion")
 * @ORM\Entity(repositoryClass="UIFI\ProductosBundle\Repository\InformeInvestigacionRepository")
 */
class InformeInvestigacion
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
     * @ORM\Column(name="tipo", type="string", length=50,nullable=true)
     */
    private $tipo;

    /**
     * @ORM\Column(name="titulo", type="string", length=10000)
     */
    private $titulo;
    /**
     *
     * @ORM\Column(name="anual", type="string", length=255,nullable=true)
     */
    private $anual;
    /**
     * @ORM\Column(name="proyecto_investigacion", type="string", nullable=true)
     */
    private $proyectoInvestigacion;
    /**
     * @ORM\Column(name="grupo", type="string", length=255)
     */
    private $grupo;
    /**
     * @ORM\Column(name="nombre_grupo", type="string", length=255)
     */
    private $nombreGrupo;
    /**
     * Integrantes de un grupo de un investigación que publicaron el producto
     *
     * @ORM\ManyToMany(targetEntity="UIFI\IntegrantesBundle\Entity\Integrante", mappedBy="libros")
    */
    private $integrantes;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->integrantes = new \Doctrine\Common\Collections\ArrayCollection();
    }

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
     * Set tipo
     *
     * @param string $tipo
     * @return InformeInvestigacion
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;

        return $this;
    }

    /**
     * Get tipo
     *
     * @return string 
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * Set titulo
     *
     * @param string $titulo
     * @return InformeInvestigacion
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
     * @return InformeInvestigacion
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
     * Set proyectoInvestigacion
     *
     * @param string $proyectoInvestigacion
     * @return InformeInvestigacion
     */
    public function setProyectoInvestigacion($proyectoInvestigacion)
    {
        $this->proyectoInvestigacion = $proyectoInvestigacion;

        return $this;
    }

    /**
     * Get proyectoInvestigacion
     *
     * @return string 
     */
    public function getProyectoInvestigacion()
    {
        return $this->proyectoInvestigacion;
    }

    /**
     * Set grupo
     *
     * @param string $grupo
     * @return InformeInvestigacion
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
     * Set nombreGrupo
     *
     * @param string $nombreGrupo
     * @return InformeInvestigacion
     */
    public function setNombreGrupo($nombreGrupo)
    {
        $this->nombreGrupo = $nombreGrupo;

        return $this;
    }

    /**
     * Get nombreGrupo
     *
     * @return string 
     */
    public function getNombreGrupo()
    {
        return $this->nombreGrupo;
    }

    /**
     * Add integrantes
     *
     * @param \UIFI\IntegrantesBundle\Entity\Integrante $integrantes
     * @return InformeInvestigacion
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
