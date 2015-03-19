<?php

namespace UIFI\IntegrantesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Clase que se encarga de mapear los atributos de un integrante de grupo de
 * un grupo de investigacion en la base de datos.
 *
 * @author Cristian Camilo Chaparro Africano <cristianchaparroa@gmail.com>
 * @package UIFIIntegrantesBundle
 *
 * @ORM\Entity(repositoryClass="UIFI\IntegrantesBundle\Repository\IntegranteRepository")
 * @ORM\Table(name="integrante")
 */
class Integrante
{
    /**
     * URL del cvlac del Integrante del grupo de investigación
     * @var string
     * @ORM\Id
     * @ORM\Column(name="id", type="string", length=255)
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity="UsersBundle\Entity\Usuario")
     * @ORM\JoinColumn(name="usuario_id", referencedColumnName="id")
     */
    private $usuario;


    /**
     * Número de documento de identificación.
     * @var string
     *
     * @ORM\Column(name="documento", type="string", length=10,nullable=true)
     */
    private $documento;

    /**
     * Nombres del integrante del grupo de investigación.
     * @var string
     *
     * @ORM\Column(name="nombres", type="string", length=255)
     */
    private $nombres;
    /**
     * Código del Integrante del grupo de investigación
     * @var string
     * @ORM\Column(name="codigo", type="string", length=12,nullable=true)
     */
    private $codigo;



    /**
     * Telefono Fijo
     * @var string
     *
     * @ORM\Column(name="telefono", type="string", length=255,nullable=true)
     */
    private $telefono;
    /**
     * Número celular del integrante del grupo de investigacion
     * @var string
     *
     * @ORM\Column(name="celular", type="string", length=10,nullable=true)
     */
    private $celular;

    /**
     * Correo institucional del integrnate del grupo de investigación.
     * @var string
     *
     * @ORM\Column(name="correo_institucional", type="string", length=255,nullable=true)
     */
    private $correoInstitucional;
    /**
     * Correo personal del integrnate del grupo de investigación.
     * @var string
     *
     * @ORM\Column(name="correo_personal", type="string", length=255,nullable=true)
     */
    private $correoPersonal;

    /**
     * Artículos de investigación publicados por uno o varios integrantes de un grupo de
     * Investigación.
     *
     * @ORM\ManyToMany( targetEntity="UIFI\ProductosBundle\Entity\Articulo" , inversedBy="integrantes",cascade={"remove", "persist"})
     * @ORM\JoinTable( name="integrantes_articulos")
    */
    protected $articulos;
    /**
     * Proyecto curricular al que pertence  un grupo de investigación.
     *
     * @ORM\ManyToOne(targetEntity="Grupo", inversedBy="integrantes" )
     * @ORM\JoinColumn(name="grupo_id" ,referencedColumnName="id")
    */
    protected $grupo;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->articulos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set id
     *
     * @param string $id
     * @return Integrante
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get id
     *
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set documento
     *
     * @param string $documento
     * @return Integrante
     */
    public function setDocumento($documento)
    {
        $this->documento = $documento;

        return $this;
    }

    /**
     * Get documento
     *
     * @return string
     */
    public function getDocumento()
    {
        return $this->documento;
    }

    /**
     * Set nombres
     *
     * @param string $nombres
     * @return Integrante
     */
    public function setNombres($nombres)
    {
        $this->nombres = $nombres;

        return $this;
    }

    /**
     * Get nombres
     *
     * @return string
     */
    public function getNombres()
    {
        return $this->nombres;
    }

    /**
     * Set codigo
     *
     * @param string $codigo
     * @return Integrante
     */
    public function setCodigo($codigo)
    {
        $this->codigo = $codigo;

        return $this;
    }

    /**
     * Get codigo
     *
     * @return string
     */
    public function getCodigo()
    {
        return $this->codigo;
    }

    /**
     * Set telefono
     *
     * @param string $telefono
     * @return Integrante
     */
    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;

        return $this;
    }

    /**
     * Get telefono
     *
     * @return string
     */
    public function getTelefono()
    {
        return $this->telefono;
    }

    /**
     * Set celular
     *
     * @param string $celular
     * @return Integrante
     */
    public function setCelular($celular)
    {
        $this->celular = $celular;

        return $this;
    }

    /**
     * Get celular
     *
     * @return string
     */
    public function getCelular()
    {
        return $this->celular;
    }

    /**
     * Set correoInstitucional
     *
     * @param string $correoInstitucional
     * @return Integrante
     */
    public function setCorreoInstitucional($correoInstitucional)
    {
        $this->correoInstitucional = $correoInstitucional;

        return $this;
    }

    /**
     * Get correoInstitucional
     *
     * @return string
     */
    public function getCorreoInstitucional()
    {
        return $this->correoInstitucional;
    }

    /**
     * Set correoPersonal
     *
     * @param string $correoPersonal
     * @return Integrante
     */
    public function setCorreoPersonal($correoPersonal)
    {
        $this->correoPersonal = $correoPersonal;

        return $this;
    }

    /**
     * Get correoPersonal
     *
     * @return string
     */
    public function getCorreoPersonal()
    {
        return $this->correoPersonal;
    }

    /**
     * Set usuario
     *
     * @param \UsersBundle\Entity\Usuario $usuario
     * @return Integrante
     */
    public function setUsuario(\UsersBundle\Entity\Usuario $usuario = null)
    {
        $this->usuario = $usuario;

        return $this;
    }

    /**
     * Get usuario
     *
     * @return \UsersBundle\Entity\Usuario
     */
    public function getUsuario()
    {
        return $this->usuario;
    }

    /**
     * Add articulos
     *
     * @param \UIFI\ProductosBundle\Entity\Articulo $articulos
     * @return Integrante
     */
    public function addArticulo(\UIFI\ProductosBundle\Entity\Articulo $articulos)
    {
        $this->articulos[] = $articulos;

        return $this;
    }

    /**
     * Remove articulos
     *
     * @param \UIFI\ProductosBundle\Entity\Articulo $articulos
     */
    public function removeArticulo(\UIFI\ProductosBundle\Entity\Articulo $articulos)
    {
        $this->articulos->removeElement($articulos);
    }

    /**
     * Get articulos
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getArticulos()
    {
        return $this->articulos;
    }

    /**
     * Set grupo
     *
     * @param \UIFI\IntegrantesBundle\Entity\Grupo $grupo
     * @return Integrante
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

    public function __toString(){
      return $this->nombres;
    }
}
