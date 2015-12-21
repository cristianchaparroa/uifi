<?php

namespace UIFI\ProductosBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Generación de Contenido Impreso
 * @ORM\Table(name="contenido_impreso")
 * @ORM\Entity(repositoryClass="UIFI\ProductosBundle\Repository\ContenidoImpresoRepository")
 */
class ContenidoImpreso {
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
     * @ORM\Column(name="ambito", type="string",length=20,nullable=true)
     */
    private $ambito;
    /**
     * @ORM\Column(name="medio_circulacion", type="string",nullable=true)
     */
    private $medioCirculacion;
    /**
     * @ORM\Column(name="lugar_publicacion",length=1000, type="string", length=255)
     */
    private $lugarPublicacion;
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
     * @return ContenidoImpreso
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
     * @return ContenidoImpreso
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
     * @return ContenidoImpreso
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
     * Set ambito
     *
     * @param string $ambito
     * @return ContenidoImpreso
     */
    public function setAmbito($ambito)
    {
        $this->ambito = $ambito;

        return $this;
    }

    /**
     * Get ambito
     *
     * @return string 
     */
    public function getAmbito()
    {
        return $this->ambito;
    }

    /**
     * Set medioCirculacion
     *
     * @param string $medioCirculacion
     * @return ContenidoImpreso
     */
    public function setMedioCirculacion($medioCirculacion)
    {
        $this->medioCirculacion = $medioCirculacion;

        return $this;
    }

    /**
     * Get medioCirculacion
     *
     * @return string 
     */
    public function getMedioCirculacion()
    {
        return $this->medioCirculacion;
    }

    /**
     * Set lugarPublicacion
     *
     * @param string $lugarPublicacion
     * @return ContenidoImpreso
     */
    public function setLugarPublicacion($lugarPublicacion)
    {
        $this->lugarPublicacion = $lugarPublicacion;

        return $this;
    }

    /**
     * Get lugarPublicacion
     *
     * @return string 
     */
    public function getLugarPublicacion()
    {
        return $this->lugarPublicacion;
    }

    /**
     * Set grupo
     *
     * @param string $grupo
     * @return ContenidoImpreso
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
     * @return ContenidoImpreso
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
     * @return ContenidoImpreso
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
