<?php

namespace UIFI\ProductosBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Innovaciones generadas en la Gestión Empresarial
 *
 * @ORM\Table(name="innovacion_gestion_empresarial")
 * @ORM\Entity(repositoryClass="UIFI\ProductosBundle\Repository\InnovacionGestionEmpresarialRepository")
 */
class InnovacionGestionEmpresarial
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
       * @ORM\Column(name="disponibilidad", type="string",length=20,nullable=true)
       */
      private $disponibilidad;

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
     * @return InnovacionGestionEmpresarial
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
     * @return InnovacionGestionEmpresarial
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
     * @return InnovacionGestionEmpresarial
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
     * @return InnovacionGestionEmpresarial
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
     * Set disponibilidad
     *
     * @param string $disponibilidad
     * @return InnovacionGestionEmpresarial
     */
    public function setDisponibilidad($disponibilidad)
    {
        $this->disponibilidad = $disponibilidad;

        return $this;
    }

    /**
     * Get disponibilidad
     *
     * @return string
     */
    public function getDisponibilidad()
    {
        return $this->disponibilidad;
    }

    /**
     * Set institucionFinanciadora
     *
     * @param string $institucionFinanciadora
     * @return InnovacionGestionEmpresarial
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
     * @return InnovacionGestionEmpresarial
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
     * @return InnovacionGestionEmpresarial
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
     * @return InnovacionGestionEmpresarial
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
