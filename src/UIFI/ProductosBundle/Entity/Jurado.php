<?php

namespace UIFI\ProductosBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Jurado/Comisiones evaluadoras de trabajo de grado
 *
 * @ORM\Table(name="jurado")
 * @ORM\Entity(repositoryClass="UIFI\ProductosBundle\Repository\JuradoRepository")
 */
class Jurado {
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
     * @ORM\Column(name="pais", type="string",length=255,nullable=true)
     */
    private $pais;
    /**
     * @ORM\Column(name="anual", type="string",length=255,nullable=true)
     */
    private $anual;
    /**
     * @ORM\Column(name="idioma", type="string",length=255,nullable=true)
     */
    private $idioma;
    /**
     * @ORM\Column(name="medio_divulgacion", type="string",length=255,nullable=true)
     */
    private $medioDivulgacion;
    /**
     * @ORM\Column(name="sitio_web", type="string",nullable=true)
     */
    private $sitioWeb;

    /**
    * @ORM\Column(name="nombre_orientado", type="string",length=1000,nullable=true)
    */
   private $nombreOrientado;
   /**
   * @ORM\Column(name="programa_academico", type="string",length=1000,nullable=true)
   */
   private $programaAcademico;
   /**
   * @ORM\Column(name="institucion", type="string",length=1000,nullable=true)
   */
   private $institucion;
    /**
     * Integrantes de un grupo de un investigacion que publicaron el articulo.
     *
     * @ORM\ManyToMany(targetEntity="UIFI\IntegrantesBundle\Entity\Integrante", mappedBy="proyectosDirigidos")
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
     * @return Jurado
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
     * @return Jurado
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
     * Set pais
     *
     * @param string $pais
     * @return Jurado
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
     * Set anual
     *
     * @param string $anual
     * @return Jurado
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
     * Set idioma
     *
     * @param string $idioma
     * @return Jurado
     */
    public function setIdioma($idioma)
    {
        $this->idioma = $idioma;

        return $this;
    }

    /**
     * Get idioma
     *
     * @return string 
     */
    public function getIdioma()
    {
        return $this->idioma;
    }

    /**
     * Set medioDivulgacion
     *
     * @param string $medioDivulgacion
     * @return Jurado
     */
    public function setMedioDivulgacion($medioDivulgacion)
    {
        $this->medioDivulgacion = $medioDivulgacion;

        return $this;
    }

    /**
     * Get medioDivulgacion
     *
     * @return string 
     */
    public function getMedioDivulgacion()
    {
        return $this->medioDivulgacion;
    }

    /**
     * Set sitioWeb
     *
     * @param string $sitioWeb
     * @return Jurado
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
     * Set nombreOrientado
     *
     * @param string $nombreOrientado
     * @return Jurado
     */
    public function setNombreOrientado($nombreOrientado)
    {
        $this->nombreOrientado = $nombreOrientado;

        return $this;
    }

    /**
     * Get nombreOrientado
     *
     * @return string 
     */
    public function getNombreOrientado()
    {
        return $this->nombreOrientado;
    }

    /**
     * Set programaAcademico
     *
     * @param string $programaAcademico
     * @return Jurado
     */
    public function setProgramaAcademico($programaAcademico)
    {
        $this->programaAcademico = $programaAcademico;

        return $this;
    }

    /**
     * Get programaAcademico
     *
     * @return string 
     */
    public function getProgramaAcademico()
    {
        return $this->programaAcademico;
    }

    /**
     * Set institucion
     *
     * @param string $institucion
     * @return Jurado
     */
    public function setInstitucion($institucion)
    {
        $this->institucion = $institucion;

        return $this;
    }

    /**
     * Get institucion
     *
     * @return string 
     */
    public function getInstitucion()
    {
        return $this->institucion;
    }

    /**
     * Set grupo
     *
     * @param string $grupo
     * @return Jurado
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
     * @return Jurado
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
     * @return Jurado
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
