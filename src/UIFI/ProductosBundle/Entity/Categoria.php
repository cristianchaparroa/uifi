<?php

namespace UIFI\ProductosBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Categoria
 *
 * @ORM\Table("categoria")
 * @ORM\Entity
 */
class Categoria
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
     * Vigencia Inicial desde la cual la categoria se avala
     * @var date $vigenciaInicial
     *
     * @ORM\Column(name="vigenciaInicial", type="date",nullable=true)
     */
    private $vigenciaInicial;

    /**
     * Vigencia final hasta la cual la categoria se avala
     * @var date $vigenciaFinal
     *
     * @ORM\Column(name="vigenciaFinal", type="date", nullable=true)
     */
    private $vigenciaFinal;

    /**
     * Tipo de revista A1,A2, B1,B2,C...
     * @var String
     *
     * @ORM\Column(name="tipo", type="string",length=10)
     */
    private $tipo;

    /**
     * Revista a la que esta asociada la categoria.
     *
     * @ORM\ManyToOne(targetEntity="Revista", inversedBy="categorias" )
     * @ORM\JoinColumn(name="revista_id" ,referencedColumnName="id")
    */
    protected $revista;



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
     * @return Categoria
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
     * Set vigenciaInicial
     *
     * @param \DateTime $vigenciaInicial
     * @return Categoria
     */
    public function setVigenciaInicial($vigenciaInicial)
    {
        $this->vigenciaInicial = $vigenciaInicial;

        return $this;
    }

    /**
     * Get vigenciaInicial
     *
     * @return \DateTime
     */
    public function getVigenciaInicial()
    {
        return $this->vigenciaInicial;
    }

    /**
     * Set vigenciaFinal
     *
     * @param \DateTime $vigenciaFinal
     * @return Categoria
     */
    public function setVigenciaFinal($vigenciaFinal)
    {
        $this->vigenciaFinal = $vigenciaFinal;

        return $this;
    }

    /**
     * Get vigenciaFinal
     *
     * @return \DateTime
     */
    public function getVigenciaFinal()
    {
        return $this->vigenciaFinal;
    }

    /**
     * Set revista
     *
     * @param \UIFI\ProductosBundle\Entity\Revista $revista
     * @return Categoria
     */
    public function setRevista(\UIFI\ProductosBundle\Entity\Revista $revista = null)
    {
        $this->revista = $revista;

        return $this;
    }

    /**
     * Get revista
     *
     * @return \UIFI\ProductosBundle\Entity\Revista
     */
    public function getRevista()
    {
        return $this->revista;
    }

    public function __toString(){
      return $this->tipo;
    }
}
