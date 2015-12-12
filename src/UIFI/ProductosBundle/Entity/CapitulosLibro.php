<?php

namespace UIFI\ProductosBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CapitulosLibro
 *
 * @ORM\Table("capitulosLibro")
 * @ORM\Entity(repositoryClass="UIFI\ProductosBundle\Repository\CapitulosLibroRepository")
 */
class CapitulosLibro
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
     * @ORM\Column(name="titulo", type="string", length=10000,nullable=true)
     */
    private $titulo;

    /**
     * @var string
     *
     * @ORM\Column(name="titulo_libro", type="string", length=10000,nullable=true)
     */
    private $tituloLibro;

    /**
     * @var string
     *
     * @ORM\Column(name="pais", type="string", length=255)
     */
    private $pais;

    /**
     * @var string
     *
     * @ORM\Column(name="anual", type="string", length=255)
     */
    private $anual;

    /**
     * @var string
     *
     * @ORM\Column(name="isbn", type="string", length=255,nullable=true)
     */
    private $isbn;

    /**
     * Integrantes de un grupo de un investigacion que publicaron el capitulo de un libro.
     *
     * @ORM\ManyToMany(targetEntity="UIFI\IntegrantesBundle\Entity\Integrante", mappedBy="capituloslibro")
    */
    private $integrantes;
    /**
     * Codigo del grupo en el cual fue publicado el articulo
     *
     * @ORM\Column(name="grupo", type="string", length=255)
     */
    private $grupo;

    /**
     * Editorial que publico el libro y por ende el capitulo de libro.
     *
     * @ORM\Column(name="editorial", type="string", nullable=true)
     */
    private $editorial;

    /**
     * Volumen
     *
     * @ORM\Column(name="volumen", type="string", length=10, nullable=true)
     */
    private $volumen;

    /**
     * Paginas del libro en las que fue publicado el capitulo de libro.
     *
     * @ORM\Column(name="paginas", type="string", length=10,nullable=true)
     */
    private $paginas;

    /**
     * Tipo de capitulo de libro
     *
     * @ORM\Column(name="tipo", type="string",nullable=true)
     */
    private $tipo;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre_grupo", type="string", length=255)
     */
    private $nombreGrupo;



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
     * @return CapitulosLibro
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
     * @return CapitulosLibro
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
     * @return CapitulosLibro
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
     * Set isbn
     *
     * @param string $isbn
     * @return CapitulosLibro
     */
    public function setIsbn($isbn)
    {
        $this->isbn = $isbn;

        return $this;
    }

    /**
     * Get isbn
     *
     * @return string
     */
    public function getIsbn()
    {
        return $this->isbn;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->integrantes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add integrantes
     *
     * @param \UIFI\IntegrantesBundle\Entity\Integrante $integrantes
     * @return CapitulosLibro
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
     * Set grupo
     *
     * @param string $grupo
     * @return CapitulosLibro
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
     * Set tituloLibro
     *
     * @param string $tituloLibro
     * @return CapitulosLibro
     */
    public function setTituloLibro($tituloLibro)
    {
        $this->tituloLibro = $tituloLibro;

        return $this;
    }

    /**
     * Get tituloLibro
     *
     * @return string
     */
    public function getTituloLibro()
    {
        return $this->tituloLibro;
    }

    /**
     * Set editorial
     *
     * @param string $editorial
     * @return CapitulosLibro
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
     * Set volumen
     *
     * @param string $volumen
     * @return CapitulosLibro
     */
    public function setVolumen($volumen)
    {
        $this->volumen = $volumen;

        return $this;
    }

    /**
     * Get volumen
     *
     * @return string
     */
    public function getVolumen()
    {
        return $this->volumen;
    }

    /**
     * Set paginas
     *
     * @param string $paginas
     * @return CapitulosLibro
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
     * Set tipo
     *
     * @param string $tipo
     * @return CapitulosLibro
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
     * Set nombreGrupo
     *
     * @param string $nombreGrupo
     * @return CapitulosLibro
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
}
