<?php

namespace UIFI\GrupLACScraperBundle\Entity;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;;

use Doctrine\ORM\Mapping as ORM;

/**
 * Gruplac
 *
 * @ORM\Table( name="gruplac")
 * @ORM\Entity(repositoryClass="UIFI\GrupLACScraperBundle\Repository\GruplacRepository")
 */
class Gruplac
{
    /**
     *
     * @ORM\Column(name="id", type="string", length=14)
     * @ORM\Id
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=255)
     */
    private $nombre;

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
     * Set nombre
     *
     * @param string $nombre
     * @return Gruplac
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
     * Set id
     *
     * @param integer $id
     * @return Gruplac
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }
}
