<?php

namespace UIFI\ProductosBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Libro
 *
 * @ORM\Table("otro_libro")
 * @ORM\Entity(repositoryClass="UIFI\ProductosBundle\Repository\OtroLibroRepository")
 */
class OtroLibro
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
     * @var string
     *
     * @ORM\Column(name="anual", type="string", length=255,nullable=true)
     */
    private $anual;

    /**
     * @var string
     *
     * @ORM\Column(name="isbn", type="string", length=255)
     */
    private $isbn;

    /**
     * Integrantes de un grupo de un investigación que publicaron el Libro
     *
     * @ORM\ManyToMany(targetEntity="UIFI\IntegrantesBundle\Entity\Integrante", mappedBy="libros")
    */
    private $integrantes;
    /**
     * Codigo del grupo en el cual fue publicado el articulo
     *
     * @ORM\Column(name="grupo", type="string", length=255)
     */
    private $grupo;

    /**
     * Volumen de libro
     *
     * @ORM\Column(name="tipo", type="string", length=50,nullable=true)
     */
    private $tipo;
    /**
     * Volumen de libro
     *
     * @ORM\Column(name="volumen", type="string", length=20,nullable=true)
     */
    private $volumen;

    /**
     * Numero de pagians que tiene el libro publicado
     *
     * @ORM\Column(name="paginas", type="string", length=20,nullable=true)
     */
    private $paginas;

    /**
     * Numero de pagians que tiene el libro publicado
     *
     * @ORM\Column(name="editorial", type="string", nullable=true)
     */
    private $editorial;

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
     * Set titulo
     *
     * @param string $titulo
     * @return OtroLibro
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
     * @return OtroLibro
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
     * @return OtroLibro
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
     * @return OtroLibro
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
     * Set grupo
     *
     * @param string $grupo
     * @return OtroLibro
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
     * Set tipo
     *
     * @param string $tipo
     * @return OtroLibro
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
     * Set volumen
     *
     * @param string $volumen
     * @return OtroLibro
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
     * @return OtroLibro
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
     * Set editorial
     *
     * @param string $editorial
     * @return OtroLibro
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
     * Set nombreGrupo
     *
     * @param string $nombreGrupo
     * @return OtroLibro
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
     * @return OtroLibro
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
