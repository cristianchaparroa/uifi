<?php

namespace UIFI\ProductosBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Revista
 *
 * @ORM\Table( "revista")
 * @ORM\Entity
 */
class Revista
{
    /**
     * El identificador de la revista es el ISBN de esta.
     * @var string
     *
     * @ORM\Column(name="id",  type="string",length=255)
     * @ORM\Id
     */
    private $id;

    /**
     * Nombre de la revista.
     * @var String
     *
     * @ORM\Column(name="nombre", type="string",length=255)
     */
    private $nombre;

    /**
      * Categorias que tiene una Revista de indexación.
      *
      * @ORM\OneToMany(targetEntity="Categoria", mappedBy="revista")
      */
    protected $categorias;




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
     * Set isbnRevista
     *
     * @param string $isbnRevista
     * @return Revista
     */
    public function setIsbnRevista($isbnRevista)
    {
        $this->isbnRevista = $isbnRevista;

        return $this;
    }

    /**
     * Get isbnRevista
     *
     * @return string
     */
    public function getIsbnRevista()
    {
        return $this->isbnRevista;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->categorias = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set id
     *
     * @param string $id
     * @return Revista
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     * @return Revista
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string 
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Add categorias
     *
     * @param \UIFI\ProductosBundle\Entity\Categoria $categorias
     * @return Revista
     */
    public function addCategoria(\UIFI\ProductosBundle\Entity\Categoria $categorias)
    {
        $this->categorias[] = $categorias;

        return $this;
    }

    /**
     * Remove categorias
     *
     * @param \UIFI\ProductosBundle\Entity\Categoria $categorias
     */
    public function removeCategoria(\UIFI\ProductosBundle\Entity\Categoria $categorias)
    {
        $this->categorias->removeElement($categorias);
    }

    /**
     * Get categorias
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCategorias()
    {
        return $this->categorias;
    }
}
