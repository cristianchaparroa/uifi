<?php

namespace UIFI\ProductosBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Ediciones
 *
 * @ORM\Table("edicion")
 * @ORM\Entity(repositoryClass="UIFI\ProductosBundle\Repository\EdicionRepository")
 */
class Edicion
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
     * Volumen de libro
     *
     * @ORM\Column(name="tipo", type="string", length=50,nullable=true)
     */
    private $tipo;

    /**
     * @var string
     *
     * @ORM\Column(name="titulo", type="string", length=10000)
     */
    private $titulo;

    /**
     * @var string
     *
     * @ORM\Column(name="pais", type="string", length=255,nullable=true)
     */
    private $pais;

    /**
     *
     * @ORM\Column(name="anual", type="string", length=255,nullable=true)
     */
    private $anual;
    /**
     * @ORM\Column(name="editorial", type="string", nullable=true)
     */
    private $editorial;

    /**
     * @var string
     *
     * @ORM\Column(name="idiomas", type="string", length=255,nullable=true)
     */
    private $idiomas;

    /**
     * @ORM\Column(name="paginas", type="string", length=20,nullable=true)
     */
    private $paginas;
    /**
     * @ORM\Column(name="grupo", type="string", length=255)
     */
    private $grupo;
    /**
     * @ORM\Column(name="nombre_grupo", type="string", length=255)
     */
    private $nombreGrupo;
    /**
     * Integrantes de un grupo de un investigación que publicaron el producto
     *
     * @ORM\ManyToMany(targetEntity="UIFI\IntegrantesBundle\Entity\Integrante", mappedBy="libros")
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
     * @return Edicion
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
     * @return Edicion
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
     * @return Edicion
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
     * @return Edicion
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
     * Set editorial
     *
     * @param string $editorial
     * @return Edicion
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
     * Set idiomas
     *
     * @param string $idiomas
     * @return Edicion
     */
    public function setIdiomas($idiomas)
    {
        $this->idiomas = $idiomas;

        return $this;
    }

    /**
     * Get idiomas
     *
     * @return string 
     */
    public function getIdiomas()
    {
        return $this->idiomas;
    }

    /**
     * Set paginas
     *
     * @param string $paginas
     * @return Edicion
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
     * Set grupo
     *
     * @param string $grupo
     * @return Edicion
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
     * @return Edicion
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
     * @return Edicion
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
