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
     * Código del gruplac
     * @var string
     * @ORM\Column(name="codigogruplac", type="string", length=14,nullable=true)
     */
    private $codigoGruplac;

    /**
     * @ORM\OneToOne(targetEntity="UsersBundle\Entity\Usuario")
     * @ORM\JoinColumn(name="usuario_id", referencedColumnName="id", nullable=true)
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
     * @var string
     *
     * @ORM\Column(name="nombre_grupo", type="string", length=255)
     */
    private $nombreGrupo;

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
     * Libros publicados por uno o varios integrantes de un grupo de
     * Investigación.
     *
     * @ORM\ManyToMany( targetEntity="UIFI\ProductosBundle\Entity\Libro" , inversedBy="integrantes",cascade={"remove", "persist"})
     * @ORM\JoinTable( name="integrantes_libros")
    */
    protected $libros;

    /**
     * Libros publicados por uno o varios integrantes de un grupo de
     * Investigación.
     *
     * @ORM\ManyToMany( targetEntity="UIFI\ProductosBundle\Entity\Patente" , inversedBy="integrantes",cascade={"remove", "persist"})
     * @ORM\JoinTable( name="integrantes_patentes")
    */
    protected $patentes;
    /**
     * Software publicados por uno o varios integrantes de un grupo de
     * Investigación.
     *
     * @ORM\ManyToMany( targetEntity="UIFI\ProductosBundle\Entity\Software" , inversedBy="integrantes",cascade={"remove", "persist"})
     * @ORM\JoinTable( name="integrantes_software")
    */
    protected $software;

    /**
     * Proyectos dirigidos por uno o varios integrantes de un grupo de
     * Investigación.
     *
     * @ORM\ManyToMany( targetEntity="UIFI\ProductosBundle\Entity\ProyectoDirigido" , inversedBy="integrantes",cascade={"remove", "persist"})
     * @ORM\JoinTable( name="integrantes_proyectos_dirigido")
    */
    protected $proyectosDirigidos;

    /**
     * Libros publicados por uno o varios integrantes de un grupo de
     * Investigación.
     *
     * @ORM\ManyToMany( targetEntity="UIFI\ProductosBundle\Entity\CapitulosLibro" , inversedBy="integrantes",cascade={"remove", "persist"})
     * @ORM\JoinTable( name="integrantes_capituloslibro")
    */
    protected $capituloslibro;
    /**
     * Proyecto curricular al que pertence  un grupo de investigación.
     *
     * @ORM\ManyToMany(targetEntity="Grupo", mappedBy="integrantes" )
    */
    protected $grupos;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->articulos = new \Doctrine\Common\Collections\ArrayCollection();
    }
    public function __toString(){
      return $this->nombres;
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
     * Add grupos
     *
     * @param \UIFI\IntegrantesBundle\Entity\Grupo $grupos
     * @return Integrante
     */
    public function addGrupo(\UIFI\IntegrantesBundle\Entity\Grupo $grupos)
    {
        $this->grupos[] = $grupos;

        return $this;
    }

    /**
     * Remove grupos
     *
     * @param \UIFI\IntegrantesBundle\Entity\Grupo $grupos
     */
    public function removeGrupo(\UIFI\IntegrantesBundle\Entity\Grupo $grupos)
    {
        $this->grupos->removeElement($grupos);
    }

    /**
     * Get grupos
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getGrupos()
    {
        return $this->grupos;
    }

    /**
     * Set codigoGruplac
     *
     * @param string $codigoGruplac
     * @return Integrante
     */
    public function setCodigoGruplac($codigoGruplac)
    {
        $this->codigoGruplac = $codigoGruplac;

        return $this;
    }

    /**
     * Get codigoGruplac
     *
     * @return string
     */
    public function getCodigoGruplac()
    {
        return $this->codigoGruplac;
    }

    /**
     * Add libros
     *
     * @param \UIFI\ProductosBundle\Entity\Libro $libros
     * @return Integrante
     */
    public function addLibro(\UIFI\ProductosBundle\Entity\Libro $libros)
    {
        $this->libros[] = $libros;

        return $this;
    }

    /**
     * Remove libros
     *
     * @param \UIFI\ProductosBundle\Entity\Libro $libros
     */
    public function removeLibro(\UIFI\ProductosBundle\Entity\Libro $libros)
    {
        $this->libros->removeElement($libros);
    }

    /**
     * Get libros
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getLibros()
    {
        return $this->libros;
    }

    /**
     * Add capituloslibro
     *
     * @param \UIFI\ProductosBundle\Entity\CapitulosLibro $capituloslibro
     * @return Integrante
     */
    public function addCapituloslibro(\UIFI\ProductosBundle\Entity\CapitulosLibro $capituloslibro)
    {
        $this->capituloslibro[] = $capituloslibro;

        return $this;
    }

    /**
     * Remove capituloslibro
     *
     * @param \UIFI\ProductosBundle\Entity\CapitulosLibro $capituloslibro
     */
    public function removeCapituloslibro(\UIFI\ProductosBundle\Entity\CapitulosLibro $capituloslibro)
    {
        $this->capituloslibro->removeElement($capituloslibro);
    }

    /**
     * Get capituloslibro
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCapituloslibro()
    {
        return $this->capituloslibro;
    }

    /**
     * Add software
     *
     * @param \UIFI\ProductosBundle\Entity\Software $software
     * @return Integrante
     */
    public function addSoftware(\UIFI\ProductosBundle\Entity\Software $software)
    {
        $this->software[] = $software;

        return $this;
    }

    /**
     * Remove software
     *
     * @param \UIFI\ProductosBundle\Entity\Software $software
     */
    public function removeSoftware(\UIFI\ProductosBundle\Entity\Software $software)
    {
        $this->software->removeElement($software);
    }

    /**
     * Get software
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSoftware()
    {
        return $this->software;
    }

    /**
     * Add patentes
     *
     * @param \UIFI\ProductosBundle\Entity\Patente $patentes
     * @return Integrante
     */
    public function addPatente(\UIFI\ProductosBundle\Entity\Patente $patentes)
    {
        $this->patentes[] = $patentes;

        return $this;
    }

    /**
     * Remove patentes
     *
     * @param \UIFI\ProductosBundle\Entity\Patente $patentes
     */
    public function removePatente(\UIFI\ProductosBundle\Entity\Patente $patentes)
    {
        $this->patentes->removeElement($patentes);
    }

    /**
     * Get patentes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPatentes()
    {
        return $this->patentes;
    }

    /**
     * Add proyectosDirigidos
     *
     * @param \UIFI\ProductosBundle\Entity\ProyectoDirigido $proyectosDirigidos
     * @return Integrante
     */
    public function addProyectosDirigido(\UIFI\ProductosBundle\Entity\ProyectoDirigido $proyectosDirigidos)
    {
        $this->proyectosDirigidos[] = $proyectosDirigidos;

        return $this;
    }

    /**
     * Remove proyectosDirigidos
     *
     * @param \UIFI\ProductosBundle\Entity\ProyectoDirigido $proyectosDirigidos
     */
    public function removeProyectosDirigido(\UIFI\ProductosBundle\Entity\ProyectoDirigido $proyectosDirigidos)
    {
        $this->proyectosDirigidos->removeElement($proyectosDirigidos);
    }

    /**
     * Get proyectosDirigidos
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProyectosDirigidos()
    {
        return $this->proyectosDirigidos;
    }

    /**
     * Set nombreGrupo
     *
     * @param string $nombreGrupo
     * @return Integrante
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
