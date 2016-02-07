<?php

namespace UIFI\ProductosBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Clase que mapea un Artículo de investigación
 *
 * @ORM\Table(name="software")
 * @ORM\Entity(repositoryClass="UIFI\ProductosBundle\Repository\SoftwareRepository")
 */
class Software
{

    /**
     * @var integer
     *
     * @ORM\Id
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    /**
     * @var string
     *
     * @ORM\Column(name="titulo", type="string", length=10000,nullable=true)
     */
    private $titulo;

    /**
     * @var string
     *
     * @ORM\Column(name="tipo", type="string", nullable=true)
     */
    private $tipo;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre_comercial", type="string", length=1000,nullable=true)
     */
    private $nombreComercial;
    /**
     * @var string
     *
     * @ORM\Column(name="institucion_financiera", type="string", length=255,nullable=true)
     */
    private $institucionFinanciera;

    /**
      * Indica si un software esta disponible, estados:
      *   No disponible
      *   disponible
      *   restringido
      * @var boolean $disponible
      * @ORM\Column(name="disponible", type="string",  length=255,nullable=true )
      */
     private $disponible;

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
     * @ORM\ManyToMany(targetEntity="UIFI\IntegrantesBundle\Entity\Integrante", mappedBy="software")
    */
    private $integrantes;
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
    * @ORM\Column(name="pais", type="string",nullable=true)
    */
    private $pais;

    /**
    * @ORM\Column(name="sitio_web", type="string",nullable=true)
    */
    private $sitioWeb;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->integrantes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set titulo
     *
     * @param string $titulo
     * @return Software
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
     * Set nombreComercial
     *
     * @param string $nombreComercial
     * @return Software
     */
    public function setNombreComercial($nombreComercial)
    {
        $this->nombreComercial = $nombreComercial;

        return $this;
    }

    /**
     * Get nombreComercial
     *
     * @return string
     */
    public function getNombreComercial()
    {
        return $this->nombreComercial;
    }

    /**
     * Set nombreProyecto
     *
     * @param string $nombreProyecto
     * @return Software
     */
    public function setNombreProyecto($nombreProyecto)
    {
        $this->nombreProyecto = $nombreProyecto;

        return $this;
    }

    /**
     * Get nombreProyecto
     *
     * @return string
     */
    public function getNombreProyecto()
    {
        return $this->nombreProyecto;
    }

    /**
     * Set institucionFinanciera
     *
     * @param string $institucionFinanciera
     * @return Software
     */
    public function setInstitucionFinanciera($institucionFinanciera)
    {
        $this->institucionFinanciera = $institucionFinanciera;

        return $this;
    }

    /**
     * Get institucionFinanciera
     *
     * @return string
     */
    public function getInstitucionFinanciera()
    {
        return $this->institucionFinanciera;
    }

    /**
     * Set categoria
     *
     * @param string $categoria
     * @return Software
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
     * Set disponible
     *
     * @param string $disponible
     * @return Software
     */
    public function setDisponible($disponible)
    {
        $this->disponible = $disponible;

        return $this;
    }

    /**
     * Get disponible
     *
     * @return string
     */
    public function getDisponible()
    {
        return $this->disponible;
    }

    /**
     * Set anual
     *
     * @param string $anual
     * @return Software
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
     * @return Software
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
     * @param \UIFI\ProductosBundle\Entity\Software $integrantes
     * @return Software
     */
    public function addIntegrante(\UIFI\ProductosBundle\Entity\Software $integrantes)
    {
        $this->integrantes[] = $integrantes;

        return $this;
    }

    /**
     * Remove integrantes
     *
     * @param \UIFI\ProductosBundle\Entity\Software $integrantes
     */
    public function removeIntegrante(\UIFI\ProductosBundle\Entity\Software $integrantes)
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
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nombreGrupo
     *
     * @param string $nombreGrupo
     * @return Software
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
     * @return Software
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

    /**
     * Set pais
     *
     * @param string $pais
     * @return Software
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
     * Set tipo
     *
     * @param string $tipo
     * @return Software
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
     * Set sitioWeb
     *
     * @param string $sitioWeb
     * @return Software
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

    public function __toString() {
      return "Software[ titulo=".$this->titulo.", pais=".$this->pais.", anual=".$this->anual.", disponibilidad=".$this->disponible.", sitioWeb=".$this->sitioWeb."]";
    }
}
