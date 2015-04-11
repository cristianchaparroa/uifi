<?php


namespace UIFI\GrupLACScraperBundle\Service\Getinformacion;


use Symfony\Bundle\DoctrineBundle\Registry;
use Symfony\Component\HttpKernel\Log\LoggerInterface;
use UIFI\GrupLACScraperBundle\Core\GrupLACScraper;
use UIFI\GrupLACScraperBundle\Core\CVLACScraper;
use Symfony\Component\DependencyInjection\Container;

use UIFI\IntegrantesBundle\Entity\Grupo;
use UIFI\IntegrantesBundle\Entity\Integrante;
use UIFI\ProductosBundle\Entity\Articulo;
use UIFI\ProductosBundle\Entity\Libro;
/**
 * Servicio que obtiene la información del GrupLAC de Colciencias de los articulos
 * de investigación  y los guarda en la base de datos del sistema.
 *
 * @author Cristian Camilo Chaparro Africano <cristianchaparroa@gmail.com>
*/
class GrupoStore
{

  private  $grupo;

  public function __construct( $em, $code)
  {
    $this->em = $em;
    $this->code = $code;
  }

  public function guardar(){
    $grupoScraper = new GrupLACScraper($this->code);
    /**
     * Registro el grupo de investigación en el sistema
    */
    $this->grupo  = new Grupo();
    $this->grupo->setId( $code );
    $this->grupo->setGruplac( $grupoScraper->getURL() );
    $nombreGrupo =  "". $grupoScraper->getNombreGrupo();
    $this->grupo->setNombre( $nombreGrupo );
    $this->grupo->setEmail( $grupoScraper->extraerEmail() );
    $this->grupo->setClasificacion( $grupoScraper->extraerClasificacion() );
    $this->em->persist( $this->grupo );
    $this->em->flush();
  }
  public function getGrupo(){
    return $this->grupo;
  }
}
