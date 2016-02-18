<?php

namespace UIFI\ProductosBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 *  Normas y regulaciones
 *
 * @ORM\Table(name="norma_regulacion")
 * @ORM\Entity(repositoryClass="UIFI\ProductosBundle\Repository\NormaRegulacionRepository")
 */
class NormaRegulacion {
      /**
       * @var integer
       *
       * @ORM\Column(name="id", type="integer")
       * @ORM\Id
       * @ORM\GeneratedValue(strategy="AUTO")
       */
      private $id;
      /**
       * @var string
       *
       * @ORM\Column(name="tipo", type="string",nullable=true)
       */
      private $tipo;
      /**
      * Titulo del artículo de investigación
       * @var string
       *
       * @ORM\Column(name="titulo", type="string", length=10000,nullable=true)
       */
      private $titulo;
      /**
       * @var string
       *
       * @ORM\Column(name="pais", type="string", length=60, nullable=true )
       */
      private $pais;

      /**
       * Año en el que fue publicado el articulo
       *
       * @ORM\Column(name="anual", type="string",length=10,nullable=true)
       */
      private $anual;

      /**
       *
       * @ORM\Column(name="ambito", type="string",nullable=true)
       */
      private $ambito;
      /**
       *
       * @ORM\Column(name="objeto", type="string",nullable=true)
       */
      private $objeto;

      /**
       * @var string
       * @ORM\Column(name="institucion_financiadora", type="string",length=555 ,nullable=true)
       */
      private $institucionFinanciadora;

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
     * Set tipo
     *
     * @param string $tipo
     * @return NormaRegulacion
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
     * @return NormaRegulacion
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
     * @return NormaRegulacion
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
     * @return NormaRegulacion
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
     * Set ambito
     *
     * @param string $ambito
     * @return NormaRegulacion
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
     * Set objeto
     *
     * @param string $objeto
     * @return NormaRegulacion
     */
    public function setObjeto($objeto)
    {
        $this->objeto = $objeto;

        return $this;
    }

    /**
     * Get objeto
     *
     * @return string
     */
    public function getObjeto()
    {
        return $this->objeto;
    }

    /**
     * Set institucionFinanciadora
     *
     * @param string $institucionFinanciadora
     * @return NormaRegulacion
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
     * Set nombreGrupo
     *
     * @param string $nombreGrupo
     * @return NormaRegulacion
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
     * @return NormaRegulacion
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
     * @return NormaRegulacion
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
     * @return NormaRegulacion
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
