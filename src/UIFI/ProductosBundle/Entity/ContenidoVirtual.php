<?php

namespace UIFI\ProductosBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Generación de Contenido virtual
 * @ORM\Table(name="contenido_virtual")
 * @ORM\Entity(repositoryClass="UIFI\ProductosBundle\Repository\ContenidoVirtualRepository")
 */
class ContenidoVirtual {
    /**
     * @var integer
     *
     * @ORM\Id
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    /**
     * @ORM\Column(name="tipo", type="string",length=255,nullable=true)
     */
    private $tipo;
    /**
     * @ORM\Column(name="titulo", type="string", length=10000,nullable=true)
     */
    private $titulo;
    /**
     * @ORM\Column(name="fecha", type="string",length=50,nullable=true)
     */
    private $fecha;
    /**
     * @ORM\Column(name="entidades_vinculadas", type="string",nullable=true)
     */
    private $entidadesVinculadas;
    /**
     * @ORM\Column(name="sitio_web", type="string",nullable=true)
     */
    private $sitioWeb;
    /**
     * @ORM\Column(name="grupo", type="string", length=255)
     */
    private $grupo;
    /**
     * @ORM\Column(name="nombre_grupo", type="string", length=255)
     */
    private $nombreGrupo;
    /**
     * @ORM\ManyToMany(targetEntity="UIFI\IntegrantesBundle\Entity\Integrante", mappedBy="articulos")
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
     * @return ContenidoVirtual
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
     * @return ContenidoVirtual
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
     * Set fecha
     *
     * @param string $fecha
     * @return ContenidoVirtual
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;

        return $this;
    }

    /**
     * Get fecha
     *
     * @return string 
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * Set entidadesVinculadas
     *
     * @param string $entidadesVinculadas
     * @return ContenidoVirtual
     */
    public function setEntidadesVinculadas($entidadesVinculadas)
    {
        $this->entidadesVinculadas = $entidadesVinculadas;

        return $this;
    }

    /**
     * Get entidadesVinculadas
     *
     * @return string 
     */
    public function getEntidadesVinculadas()
    {
        return $this->entidadesVinculadas;
    }

    /**
     * Set sitioWeb
     *
     * @param string $sitioWeb
     * @return ContenidoVirtual
     */
    public function setSitioWeb($sitioWeb)
    {
        $this->sitioWeb = $sitioWeb;

        return $this;
    }

    /**
     * Get sitioWeb
     *
     * @return string 
     */
    public function getSitioWeb()
    {
        return $this->sitioWeb;
    }

    /**
     * Set grupo
     *
     * @param string $grupo
     * @return ContenidoVirtual
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
     * @return ContenidoVirtual
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
     * @return ContenidoVirtual
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
