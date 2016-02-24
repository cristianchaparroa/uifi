<?php

namespace UIFI\ProductosBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Clase que mapea un Artículo de investigación
 *
 * @ORM\Table(name="documento_trabajo")
 * @ORM\Entity(repositoryClass="UIFI\ProductosBundle\Repository\DocumentoTrabajoRepository")
 */
class DocumentoTrabajo
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
    * Titulo del artículo de investigación
     * @var string
     *
     * @ORM\Column(name="tipo", type="string", length=255,nullable=true)
     */
    private $tipo;


    /**
    * Titulo del artículo de investigación
     * @var string
     *
     * @ORM\Column(name="anual", type="string", length=10,nullable=true)
     */
    private $anual;


    /**
    * Titulo del artículo de investigación
     * @var string
     *
     * @ORM\Column(name="paginas", type="string", length=10,nullable=true)
     */
    private $paginas;

    /**
    * Titulo del artículo de investigación
     * @var string
     *
     * @ORM\Column(name="instituciones", type="string", length=255,nullable=true)
     */
    private $instituciones;

    /**
    * Titulo del artículo de investigación
     * @var string
     *
     * @ORM\Column(name="url", type="string", length=1000,nullable=true)
     */
    private $url;

    /**
    * Titulo del artículo de investigación
     * @var string
     *
     * @ORM\Column(name="doi", type="string", length=255,nullable=true)
     */
    private $doi;
    /**
     * Codigo del grupo en el cual fue publicado el articulo
     *
     * @ORM\Column(name="grupo", type="string", length=255)
     */
    private $grupo;
    /**
     * @var string
     *
     * @ORM\Column(name="nombre_grupo", type="string", length=255)
     */
    private $nombreGrupo;

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
     * @return DocumentoTrabajo
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
     * @return DocumentoTrabajo
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
     * Set paginas
     *
     * @param string $paginas
     * @return DocumentoTrabajo
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
     * Set instituciones
     *
     * @param string $instituciones
     * @return DocumentoTrabajo
     */
    public function setInstituciones($instituciones)
    {
        $this->instituciones = $instituciones;

        return $this;
    }

    /**
     * Get instituciones
     *
     * @return string
     */
    public function getInstituciones()
    {
        return $this->instituciones;
    }

    /**
     * Set url
     *
     * @param string $url
     * @return DocumentoTrabajo
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set doi
     *
     * @param string $doi
     * @return DocumentoTrabajo
     */
    public function setDoi($doi)
    {
        $this->doi = $doi;

        return $this;
    }

    /**
     * Get doi
     *
     * @return string
     */
    public function getDoi()
    {
        return $this->doi;
    }

    /**
     * Add integrantes
     *
     * @param \UIFI\IntegrantesBundle\Entity\Integrante $integrantes
     * @return DocumentoTrabajo
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
     * Set tipo
     *
     * @param string $tipo
     * @return DocumentoTrabajo
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
     * Set grupo
     *
     * @param string $grupo
     * @return DocumentoTrabajo
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
     * @return DocumentoTrabajo
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
     * Set autores
     *
     * @param string $autores
     * @return DocumentoTrabajo
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
