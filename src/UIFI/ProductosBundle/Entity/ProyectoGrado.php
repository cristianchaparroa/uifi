<?php

namespace UIFI\ProductosBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Clase que mapea un Artículo de investigación
 *
 * @ORM\Table(name="proyecto")
 * @ORM\Entity(repositoryClass="UIFI\ProductosBundle\Repository\ArticuloRepository")
 */
class ProyectoGrado
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
     * Contenido generado por el Scraper desde el CVLAC
     * @var string
     *
     * @ORM\Column(name="contenido", type="string", length=255,nullable=true)
     */
    private $contenido;
    /**
     * Contenido generado por el Scraper desde el CVLAC
     * @var string
     *
     * @ORM\Column(name="idioma", type="string", length=255,nullable=true)
     */
    private $idioma;

    /**
     * Año en el que fue publicado el articulo
     * @var \DateTime
     *
     * @ORM\Column(name="anual", type="string",length=255,nullable=true)
     */
    private $anual;

    /**
     * Integrantes de un grupo de un investigacion que publicaron el articulo.
     *
     * @ORM\ManyToMany(targetEntity="UIFI\IntegrantesBundle\Entity\Integrante", mappedBy="articulos")
    */
    private $integrantes;

    /**
     * Codigo del grupo en el cual fue publicado el articulo
     *
     * @ORM\Column(name="grupo", type="string", length=255)
     */
    private $grupo;

    /**
     * Tipo de proceso con el que se creo el artículo :
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
     * @param integer $id
     * @return Articulo
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
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
     * @return Articulo
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
     * Set contenido
     *
     * @param string $contenido
     * @return Articulo
     */
    public function setContenido($contenido)
    {
        $this->contenido = $contenido;

        return $this;
    }

    /**
     * Get contenido
     *
     * @return string
     */
    public function getContenido()
    {
        return $this->contenido;
    }

    /**
     * Set editorial
     *
     * @param string $editorial
     * @return Articulo
     */
    public function setEditorial($editorial)
    {
        $this->editorial = $editorial;

        return $this;
    }

    /**
     * Get editorial
     *
     * @return string
     */
    public function getEditorial()
    {
        return $this->editorial;
    }

    /**
     * Set ISSN
     *
     * @param string $iSSN
     * @return Articulo
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
     * Set palabras
     *
     * @param string $palabras
     * @return Articulo
     */
    public function setPalabras($palabras)
    {
        $this->palabras = $palabras;

        return $this;
    }

    /**
     * Get palabras
     *
     * @return string
     */
    public function getPalabras()
    {
        return $this->palabras;
    }

    /**
     * Set categoria
     *
     * @param string $categoria
     * @return Articulo
     */
    public function setCategoria($categoria)
    {
        $this->categoria = $categoria;

        return $this;
    }

    /**
     * Get categoria
     *
     * @return string
     */
    public function getCategoria()
    {
        return $this->categoria;
    }

    /**
     * Set anual
     *
     * @param \DateTime $anual
     * @return Articulo
     */
    public function setAnual($anual)
    {
        $this->anual = $anual;

        return $this;
    }

    /**
     * Get anual
     *
     * @return \DateTime
     */
    public function getAnual()
    {
        return $this->anual;
    }

    /**
     * Set grupo
     *
     * @param string $grupo
     * @return Articulo
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
     * @return Articulo
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
     * Set proceso
     *
     * @param string $proceso
     * @return Articulo
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
}