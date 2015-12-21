<?php

namespace UIFI\ProductosBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Proyectos de un grupo de Investigacion
 * @ORM\Table(name="redes_conocimiento_especializado")
 * @ORM\Entity(repositoryClass="UIFI\ProductosBundle\Repository\RedesConocimientoEspecializadoRepository")
 */
class RedesConocimientoEspecializado {
    /**
     * @var integer
     *
     * @ORM\Id
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    /**
     * @ORM\Column(name="tipo", type="string",length=255,nullable=true)
     */
    private $tipo;
    /**
     * @ORM\Column(name="titulo", type="string", length=10000,nullable=true)
     */
    private $titulo;
    /**
     * @ORM\Column(name="lugar", type="string",length=50,nullable=true)
     */
    private $lugar;
    /**
     * @ORM\Column(name="desde", type="string",length=50,nullable=true)
     */
    private $desde;
    /**
     * @ORM\Column(name="hasta", type="string",length=50,nullable=true)
     */
    private $hasta;
    /**
     * @ORM\Column(name="numero_participantes", type="string",length=10,nullable=true)
     */
    private $numeroParticipantes;
    /**
     * @ORM\Column(name="grupo", type="string", length=255)
     */
    private $grupo;
    /**
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
     * Set tipo
     *
     * @param string $tipo
     * @return RedesConocimientoEspecializado
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
     * @return RedesConocimientoEspecializado
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
     * Set lugar
     *
     * @param string $lugar
     * @return RedesConocimientoEspecializado
     */
    public function setLugar($lugar)
    {
        $this->lugar = $lugar;

        return $this;
    }

    /**
     * Get lugar
     *
     * @return string 
     */
    public function getLugar()
    {
        return $this->lugar;
    }

    /**
     * Set desde
     *
     * @param string $desde
     * @return RedesConocimientoEspecializado
     */
    public function setDesde($desde)
    {
        $this->desde = $desde;

        return $this;
    }

    /**
     * Get desde
     *
     * @return string 
     */
    public function getDesde()
    {
        return $this->desde;
    }

    /**
     * Set hasta
     *
     * @param string $hasta
     * @return RedesConocimientoEspecializado
     */
    public function setHasta($hasta)
    {
        $this->hasta = $hasta;

        return $this;
    }

    /**
     * Get hasta
     *
     * @return string 
     */
    public function getHasta()
    {
        return $this->hasta;
    }

    /**
     * Set numeroParticipantes
     *
     * @param string $numeroParticipantes
     * @return RedesConocimientoEspecializado
     */
    public function setNumeroParticipantes($numeroParticipantes)
    {
        $this->numeroParticipantes = $numeroParticipantes;

        return $this;
    }

    /**
     * Get numeroParticipantes
     *
     * @return string 
     */
    public function getNumeroParticipantes()
    {
        return $this->numeroParticipantes;
    }

    /**
     * Set grupo
     *
     * @param string $grupo
     * @return RedesConocimientoEspecializado
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
     * @return RedesConocimientoEspecializado
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
