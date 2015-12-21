<?php

namespace UIFI\ProductosBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="curso_corta_duracion_dictado")
 * @ORM\Entity(repositoryClass="UIFI\ProductosBundle\Repository\CursoCortaDuracionDictadoRepository")
 */
class CursoCortaDuracionDictado {
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
     * @ORM\Column(name="pais", type="string",nullable=true)
     */
    private $pais;
    /**
     * @ORM\Column(name="fecha", type="string",length=10,nullable=true)
     */
    private $anual;
    /**
     * @ORM\Column(name="idioma", type="string",nullable=true)
     */
    private $idioma;
    /**
     * @ORM\Column(name="medio_divulgacion", type="string",nullable=true)
     */
    private $medioDivulgacion;
    /**
     * @ORM\Column(name="sitio_web", type="string",nullable=true)
     */
    private $sitioWeb;
    /**
     * @ORM\Column(name="duracion", type="string",nullable=true)
     */
    private $duracion;
    /**
     * @ORM\Column(name="finalidad", type="string",nullable=true)
     */
    private $finalidad;
    /**
     * @ORM\Column(name="lugar", type="string",nullable=true)
     */
    private $lugar;
    /**
     * @ORM\Column(name="institucion_financiadora", type="string",nullable=true)
     */
    private $institucionFinanciadora;
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
     * @return CursoCortaDuracionDictado
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
     * @return CursoCortaDuracionDictado
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
     * @return CursoCortaDuracionDictado
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
     * @return CursoCortaDuracionDictado
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
     * @return CursoCortaDuracionDictado
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
     * @return CursoCortaDuracionDictado
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
     * @return CursoCortaDuracionDictado
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
     * Set duracion
     *
     * @param string $duracion
     * @return CursoCortaDuracionDictado
     */
    public function setDuracion($duracion)
    {
        $this->duracion = $duracion;

        return $this;
    }

    /**
     * Get duracion
     *
     * @return string 
     */
    public function getDuracion()
    {
        return $this->duracion;
    }

    /**
     * Set finalidad
     *
     * @param string $finalidad
     * @return CursoCortaDuracionDictado
     */
    public function setFinalidad($finalidad)
    {
        $this->finalidad = $finalidad;

        return $this;
    }

    /**
     * Get finalidad
     *
     * @return string 
     */
    public function getFinalidad()
    {
        return $this->finalidad;
    }

    /**
     * Set lugar
     *
     * @param string $lugar
     * @return CursoCortaDuracionDictado
     */
    public function setLugar($lugar)
    {
        $this->lugar = $lugar;

        return $this;
    }

    /**
     * Get lugar
     *
     * @return string 
     */
    public function getLugar()
    {
        return $this->lugar;
    }

    /**
     * Set institucionFinanciadora
     *
     * @param string $institucionFinanciadora
     * @return CursoCortaDuracionDictado
     */
    public function setInstitucionFinanciadora($institucionFinanciadora)
    {
        $this->institucionFinanciadora = $institucionFinanciadora;

        return $this;
    }

    /**
     * Get institucionFinanciadora
     *
     * @return string 
     */
    public function getInstitucionFinanciadora()
    {
        return $this->institucionFinanciadora;
    }

    /**
     * Set grupo
     *
     * @param string $grupo
     * @return CursoCortaDuracionDictado
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
     * @return CursoCortaDuracionDictado
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
     * @return CursoCortaDuracionDictado
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
