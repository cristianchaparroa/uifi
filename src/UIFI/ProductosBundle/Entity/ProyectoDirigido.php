<?php

namespace UIFI\ProductosBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Clase que mapea un Proyecto  de grado
 *  Tesis doctorado,
 *  Proyecto de grado de maestria,
 *  Proyecto de gradodo de pregrado
 *
 *
 * @ORM\Table(name="proyecto_dirigido")
 * @ORM\Entity(repositoryClass="UIFI\ProductosBundle\Repository\ProyectoDirigidoRepository")
 */
class ProyectoDirigido
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
    * Titulo del artículo de investigación
     * @var string
     *
     * @ORM\Column(name="titulo", type="string", length=10000,nullable=true)
     */
    private $titulo;
    /**
     * Año en el que fue publicado el articulo
     * @var \DateTime
     *
     * @ORM\Column(name="anual", type="string",length=255,nullable=true)
     */
    private $anual;

    /**
     *  -Trabajo de conclusión de curso de pregrado
     *  Trabajos dirigidos/Tutorías de otro tipo
     *  Monografía de conclusión de curso de perfeccionamiento/especialización
     *  Trabajos dirigidos/Tutorías de otro tipo
     *  -Trabajo de grado de maestría o especialidad médica
     *  -Tesis de doctorado
     * @ORM\Column(name="tipo", type="string",length=255,nullable=true)
     */
    private $tipo;

    /**
    * @ORM\Column(name="nombre_estudiante", type="string",length=1000,nullable=true)
    */
   private $nombreEstudiante;

   /**
   * @ORM\Column(name="tipo_orientacion", type="string",length=1000,nullable=true)
   */
   private $tipoOrientacion;

   /**
   * @ORM\Column(name="proyecto_academico", type="string",length=1000,nullable=true,nullable=true)
   */
   private $proyectoAcademico;

   /**
   * @ORM\Column(name="valoracion", type="string",length=1000,nullable=true,nullable=true)
   */
   private $valoracion;

   /**
    * @var integer
    *
    * @ORM\Column(name="numero_paginas", type="integer",nullable=true)
    */
   private $numeroPaginas;


   /**
   * @ORM\Column(name="institucion", type="string",length=1000,nullable=true)
   */
   private $institucion;
   /**
   * @ORM\Column(name="autores", type="string",length=1000,nullable=true)
   */
   private $autores;

    /**
     * Integrantes de un grupo de un investigacion que publicaron el articulo.
     * @ORM\Column(name="integrante", type="string",length=1000,nullable=true)
    */
    private $integranteProyectoDirigido;

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
     * @var string
     *
     * @ORM\Column(name="nombre_grupo", type="string", length=255)
     */
    private $nombreGrupo;


    /**
     * @var string
     *
     * @ORM\Column(name="mes_inicial", type="string", length=10,nullable=true)
     */
    private $mesInicial;

    /**
     * @var string
     *
     * @ORM\Column(name="mes_final", type="string", length=10,nullable=true)
     */
    private $mesFinal;

    /**
     * @var string
     *
     * @ORM\Column(name="anual_inicial", type="string", length=10,nullable=true)
     */
    private $anualInicial;

    /**
     * @var string
     *
     * @ORM\Column(name="anual_final", type="string", length=10,nullable=true)
     */
    private $anualFinal;

    /**
     * Set id
     *
     * @param integer $id
     * @return ProyectoDirigido
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
     * @return ProyectoDirigido
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
     * @return ProyectoDirigido
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
     * @return ProyectoDirigido
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
     * Set nombreEstudiante
     *
     * @param string $nombreEstudiante
     * @return ProyectoDirigido
     */
    public function setNombreEstudiante($nombreEstudiante)
    {
        $this->nombreEstudiante = $nombreEstudiante;

        return $this;
    }

    /**
     * Get nombreEstudiante
     *
     * @return string
     */
    public function getNombreEstudiante()
    {
        return $this->nombreEstudiante;
    }

    /**
     * Set tipoOrientacion
     *
     * @param string $tipoOrientacion
     * @return ProyectoDirigido
     */
    public function setTipoOrientacion($tipoOrientacion)
    {
        $this->tipoOrientacion = $tipoOrientacion;

        return $this;
    }

    /**
     * Get tipoOrientacion
     *
     * @return string
     */
    public function getTipoOrientacion()
    {
        return $this->tipoOrientacion;
    }

    /**
     * Set proyectoAcademico
     *
     * @param string $proyectoAcademico
     * @return ProyectoDirigido
     */
    public function setProyectoAcademico($proyectoAcademico)
    {
        $this->proyectoAcademico = $proyectoAcademico;

        return $this;
    }

    /**
     * Get proyectoAcademico
     *
     * @return string
     */
    public function getProyectoAcademico()
    {
        return $this->proyectoAcademico;
    }

    /**
     * Set valoracion
     *
     * @param string $valoracion
     * @return ProyectoDirigido
     */
    public function setValoracion($valoracion)
    {
        $this->valoracion = $valoracion;

        return $this;
    }

    /**
     * Get valoracion
     *
     * @return string
     */
    public function getValoracion()
    {
        return $this->valoracion;
    }

    /**
     * Set numeroPaginas
     *
     * @param integer $numeroPaginas
     * @return ProyectoDirigido
     */
    public function setNumeroPaginas($numeroPaginas)
    {
        $this->numeroPaginas = $numeroPaginas;

        return $this;
    }

    /**
     * Get numeroPaginas
     *
     * @return integer
     */
    public function getNumeroPaginas()
    {
        return $this->numeroPaginas;
    }

    /**
     * Set institucion
     *
     * @param string $institucion
     * @return ProyectoDirigido
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
     * Set autores
     *
     * @param string $autores
     * @return ProyectoDirigido
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
     * Set integranteProyectoDirigido
     *
     * @param string $integranteProyectoDirigido
     * @return ProyectoDirigido
     */
    public function setIntegranteProyectoDirigido($integranteProyectoDirigido)
    {
        $this->integranteProyectoDirigido = $integranteProyectoDirigido;

        return $this;
    }

    /**
     * Get integranteProyectoDirigido
     *
     * @return string
     */
    public function getIntegranteProyectoDirigido()
    {
        return $this->integranteProyectoDirigido;
    }

    /**
     * Set grupo
     *
     * @param string $grupo
     * @return ProyectoDirigido
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
     * @return ProyectoDirigido
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
     * Set nombreGrupo
     *
     * @param string $nombreGrupo
     * @return ProyectoDirigido
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
     * Set mesInicial
     *
     * @param string $mesInicial
     * @return ProyectoDirigido
     */
    public function setMesInicial($mesInicial)
    {
        $this->mesInicial = $mesInicial;

        return $this;
    }

    /**
     * Get mesInicial
     *
     * @return string
     */
    public function getMesInicial()
    {
        return $this->mesInicial;
    }

    /**
     * Set mesFinal
     *
     * @param string $mesFinal
     * @return ProyectoDirigido
     */
    public function setMesFinal($mesFinal)
    {
        $this->mesFinal = $mesFinal;

        return $this;
    }

    /**
     * Get mesFinal
     *
     * @return string
     */
    public function getMesFinal()
    {
        return $this->mesFinal;
    }

    /**
     * Set anualInicial
     *
     * @param string $anualInicial
     * @return ProyectoDirigido
     */
    public function setAnualInicial($anualInicial)
    {
        $this->anualInicial = $anualInicial;

        return $this;
    }

    /**
     * Get anualInicial
     *
     * @return string
     */
    public function getAnualInicial()
    {
        return $this->anualInicial;
    }

    /**
     * Set anualFinal
     *
     * @param string $anualFinal
     * @return ProyectoDirigido
     */
    public function setAnualFinal($anualFinal)
    {
        $this->anualFinal = $anualFinal;

        return $this;
    }

    /**
     * Get anualFinal
     *
     * @return string
     */
    public function getAnualFinal()
    {
        return $this->anualFinal;
    }
    public function __toString(){
      return "ProyectoDirigido [ tipo=".$this->tipo.", titulo=".$this->titulo."]";
    }
}
