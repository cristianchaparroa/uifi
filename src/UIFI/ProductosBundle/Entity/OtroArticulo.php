<?php

namespace UIFI\ProductosBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Clase que mapea un Artículo de investigación
 *
 * @ORM\Table(name="otro_articulo")
 * @ORM\Entity(repositoryClass="UIFI\ProductosBundle\Repository\OtroArticuloRepository")
 */
class OtroArticulo
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
    * Titulo del artículo de investigación
     * @var string
     *
     * @ORM\Column(name="titulo", type="string", length=10000,nullable=true)
     */
    private $titulo;
    /**
     * Contenido generado por el Scraper desde el CVLAC
     * @var string
     *
     * @ORM\Column(name="ISSN", type="string", length=50,nullable=true)
     */
    private $ISSN;

    /**
     * Año en el que fue publicado el articulo
     * @var \DateTime
     *
     * @ORM\Column(name="anual", type="string",length=10,nullable=true)
     */
    private $anual;
    /**
     * @var string
     * @ORM\Column(name="tipo", type="string",nullable=true)
     */
    private $tipo;
    /**
     * @var string
     * @ORM\Column(name="revista", type="string",nullable=true)
     */
    private $revista;

    /**
     * @var string
     * @ORM\Column(name="volumen", type="string",length=5 ,nullable=true)
     */
    private $volumen;

    /**
     * @var string
     * @ORM\Column(name="fasciculo", type="string",length=3 ,nullable=true)
     */
    private $fasciculo;

    /**
     * @var string
     * @ORM\Column(name="paginas", type="string",length=10 ,nullable=true)
     */
    private $paginas;
    /**
     * @var string
     *
     * @ORM\Column(name="pais", type="string", length=60, nullable=true )
     */
    private $pais;
    /**
     * @var string
     *
     * @ORM\Column(name="nombre_grupo", type="string", length=255)
     */
    private $nombreGrupo;
    /**
     * Codigo del grupo en el cual fue publicado el articulo
     *
     * @ORM\Column(name="grupo", type="string", length=255)
     */
    private $grupo;
    /**
    * @ORM\Column(name="autores", type="string",length=1000,nullable=true)
    */
    private $autores;
    /**
     * Integrantes de un grupo de un investigacion que publicaron el articulo.
     *
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
     * Set titulo
     *
     * @param string $titulo
     * @return OtroArticulo
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
     * Set ISSN
     *
     * @param string $iSSN
     * @return OtroArticulo
     */
    public function setISSN($iSSN)
    {
        $this->ISSN = $iSSN;

        return $this;
    }

    /**
     * Get ISSN
     *
     * @return string
     */
    public function getISSN()
    {
        return $this->ISSN;
    }

    /**
     * Set anual
     *
     * @param string $anual
     * @return OtroArticulo
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
     * Set tipo
     *
     * @param string $tipo
     * @return OtroArticulo
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
     * Set revista
     *
     * @param string $revista
     * @return OtroArticulo
     */
    public function setRevista($revista)
    {
        $this->revista = $revista;

        return $this;
    }

    /**
     * Get revista
     *
     * @return string
     */
    public function getRevista()
    {
        return $this->revista;
    }

    /**
     * Set volumen
     *
     * @param string $volumen
     * @return OtroArticulo
     */
    public function setVolumen($volumen)
    {
        $this->volumen = $volumen;

        return $this;
    }

    /**
     * Get volumen
     *
     * @return string
     */
    public function getVolumen()
    {
        return $this->volumen;
    }

    /**
     * Set fasciculo
     *
     * @param string $fasciculo
     * @return OtroArticulo
     */
    public function setFasciculo($fasciculo)
    {
        $this->fasciculo = $fasciculo;

        return $this;
    }

    /**
     * Get fasciculo
     *
     * @return string
     */
    public function getFasciculo()
    {
        return $this->fasciculo;
    }

    /**
     * Set paginas
     *
     * @param string $paginas
     * @return OtroArticulo
     */
    public function setPaginas($paginas)
    {
        $this->paginas = $paginas;

        return $this;
    }

    /**
     * Get paginas
     *
     * @return string
     */
    public function getPaginas()
    {
        return $this->paginas;
    }

    /**
     * Set pais
     *
     * @param string $pais
     * @return OtroArticulo
     */
    public function setPais($pais)
    {
        $this->pais = $pais;

        return $this;
    }

    /**
     * Get pais
     *
     * @return string
     */
    public function getPais()
    {
        return $this->pais;
    }

    /**
     * Set nombreGrupo
     *
     * @param string $nombreGrupo
     * @return OtroArticulo
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
     * Set grupo
     *
     * @param string $grupo
     * @return OtroArticulo
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
     * Add integrantes
     *
     * @param \UIFI\IntegrantesBundle\Entity\Integrante $integrantes
     * @return OtroArticulo
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

    /**
     * Set autores
     *
     * @param string $autores
     * @return OtroArticulo
     */
    public function setAutores($autores)
    {
        $this->autores = $autores;

        return $this;
    }

    /**
     * Get autores
     *
     * @return string 
     */
    public function getAutores()
    {
        return $this->autores;
    }
}
