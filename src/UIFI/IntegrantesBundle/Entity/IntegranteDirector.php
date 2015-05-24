<?php

namespace UIFI\IntegrantesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Entididad que permite establecer el director de un grupo de investigacion
 * en especifico.
 *
 * @ORM\Table( "integrante_director" )
 * @ORM\Entity(repositoryClass="UIFI\IntegrantesBundle\Repository\IntegranteDirectorRepository")
 */
class IntegranteDirector
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
     * @ORM\OneToOne(targetEntity="Integrante")
     * @ORM\JoinColumn(name="integrante_id", referencedColumnName="id")
     **/
    private $integrante;

    /**
     * @ORM\OneToOne(targetEntity="Grupo")
     * @ORM\JoinColumn(name="grupo_id", referencedColumnName="id")
     **/
    protected $grupo;

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
     * Set integrante
     *
     * @param \UIFI\IntegrantesBundle\Entity\Integrante $integrante
     * @return IntegranteDirector
     */
    public function setIntegrante(\UIFI\IntegrantesBundle\Entity\Integrante $integrante = null)
    {
        $this->integrante = $integrante;

        return $this;
    }

    /**
     * Get integrante
     *
     * @return \UIFI\IntegrantesBundle\Entity\Integrante
     */
    public function getIntegrante()
    {
        return $this->integrante;
    }

    /**
     * Set grupo
     *
     * @param \UIFI\IntegrantesBundle\Entity\Grupo $grupo
     * @return IntegranteDirector
     */
    public function setGrupo(\UIFI\IntegrantesBundle\Entity\Grupo $grupo = null)
    {
        $this->grupo = $grupo;

        return $this;
    }

    /**
     * Get grupo
     *
     * @return \UIFI\IntegrantesBundle\Entity\Grupo
     */
    public function getGrupo()
    {
        return $this->grupo;
    }
}
