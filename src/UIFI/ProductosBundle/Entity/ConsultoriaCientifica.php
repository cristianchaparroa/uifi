<?php

namespace UIFI\ProductosBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Consultorías científico tecnológicas e Informes técnicos
 * @ORM\Table(name="consultoria_cientifica")
 * @ORM\Entity(repositoryClass="UIFI\ProductosBundle\Repository\ConsultoriaCientificaRepository")
 */
class ConsultoriaCientifica
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
       * Contenido generado por el Scraper desde el CVLAC
       * @var string
       *
       * @ORM\Column(name="tipo", type="string", length=50,nullable=true)
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
       * @var \DateTime
       *
       * @ORM\Column(name="anual", type="string",length=10,nullable=true)
       */
      private $anual;
      /**
       * @var string
       * @ORM\Column(name="idioma", type="string",nullable=true)
       */
      private $idioma;

      /**
       * @var string
       * @ORM\Column(name="disponibilidad", type="string",length=5 ,nullable=true)
       */
      private $disponibilidad;

      /**
       * @var string
       * @ORM\Column(name="numero_contrato", type="string",length=50 ,nullable=true)
       */
      private $numeroContrato;

      /**
       * @var string
       * @ORM\Column(name="institucion_beneficiaria", type="string",length=255 ,nullable=true)
       */
      private $institucionBeneficiaria;

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
     * @return ConsultoriaCientifica
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
     * @return ConsultoriaCientifica
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
     * @return ConsultoriaCientifica
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
     * @return ConsultoriaCientifica
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
     * @return ConsultoriaCientifica
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
     * Set disponibilidad
     *
     * @param string $disponibilidad
     * @return ConsultoriaCientifica
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
     * Set numeroContrato
     *
     * @param string $numeroContrato
     * @return ConsultoriaCientifica
     */
    public function setNumeroContrato($numeroContrato)
    {
        $this->numeroContrato = $numeroContrato;

        return $this;
    }

    /**
     * Get numeroContrato
     *
     * @return string 
     */
    public function getNumeroContrato()
    {
        return $this->numeroContrato;
    }

    /**
     * Set institucionBeneficiaria
     *
     * @param string $institucionBeneficiaria
     * @return ConsultoriaCientifica
     */
    public function setInstitucionBeneficiaria($institucionBeneficiaria)
    {
        $this->institucionBeneficiaria = $institucionBeneficiaria;

        return $this;
    }

    /**
     * Get institucionBeneficiaria
     *
     * @return string 
     */
    public function getInstitucionBeneficiaria()
    {
        return $this->institucionBeneficiaria;
    }

    /**
     * Set nombreGrupo
     *
     * @param string $nombreGrupo
     * @return ConsultoriaCientifica
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
     * @return ConsultoriaCientifica
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
     * @return ConsultoriaCientifica
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
