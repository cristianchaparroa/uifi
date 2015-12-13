<?php


namespace UIFI\GrupLACScraperBundle\Service\Getinformacion;


use Symfony\Bundle\DoctrineBundle\Registry;
use Symfony\Component\HttpKernel\Log\LoggerInterface;
use UIFI\GrupLACScraperBundle\Core\GrupLACScraper;
use UIFI\GrupLACScraperBundle\Core\CVLACScraper;
use Symfony\Component\DependencyInjection\Container;

use UIFI\IntegrantesBundle\Entity\Grupo;
use UIFI\IntegrantesBundle\Entity\Integrante;
use UIFI\ProductosBundle\Entity\Evento;

/**
 * Servicio que obtiene la información del GrupLAC de Colciencias de los eventos
 * en los que se presenta un grupo de investigación  y los guarda en la base de 
 * datos del sistema.
 *
 * @author Wilson Albeiro Salamanca Saboyá <wsalamanca91@gmail.com>
*/
class EventoStore implements IStore
{
  /**
   * Constructor
   * @param $em Entity Manager del sistema
   * @param $grupo del cual se va a extraer los integrantes
   * @param $eventos Lista de eventos scrapeados del GrupLAC.
  */
  public function __construct( $em, $grupo, $eventos){
    $this->em = $em;
    $this->grupo = $grupo;
    $this->eventos = $eventos;
    $this->repositoryIntegrante = $this->em->getRepository('UIFIIntegrantesBundle:Integrante');
  }


  public function guardar(){
    $eventosGrupo = $this->eventos;
    foreach($eventosGrupo as $evento ) {
      
      $event = new Evento();
      $event->setTitulo($evento['titulo']);
      $event->setTipo( $evento['tipo'] );
      $event->setGrupo( $this->grupo->getId() );
      $event->setCiudad(  $evento['ciudad']  );
      $event->setDesde( $evento['desde'] );
      $event->setHasta( $evento['hasta'] );
      $event->setAmbito(  $evento['ambito']  );
      $event->setParticipacion(  intval($evento['participacion'] ) );
      $event->setInstitucion(  $evento['institucion']  );
      $event->SetNombreGrupo($this->grupo->getNombre());

      $this->em->persist( $event );
      $this->em->flush();
    }

  }
}
