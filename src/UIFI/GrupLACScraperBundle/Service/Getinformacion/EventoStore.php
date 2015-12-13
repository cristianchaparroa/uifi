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
      $event->setGrupo( $this->grupo->getId() );
      $event->SetNombreGrupo($this->grupo->getNombre());
      $event->setTitulo( array_key_exists('titulo',$evento) ?  $evento['titulo'] : "");
      $event->setTipo( array_key_exists('tipo',$evento)  ? $evento['tipo']: "" );
      $event->setCiudad(  array_key_exists('ciudad',$evento) ?  $evento['ciudad'] : "" );
      $event->setDesde( array_key_exists('desde',$evento) ?   $evento['desde'] : "");
      $event->setHasta(  array_key_exists('hasta',$evento) ? $evento['hasta'] : "");
      $event->setAmbito(  array_key_exists('ambito',$evento) ? $evento['ambito']:""  );
      $event->setParticipacion( array_key_exists('participacion',$evento) ?  intval($evento['participacion']) : "" );
      $event->setInstitucion( array_key_exists('institucion',$evento)   ? $evento['institucion'] : ""  );
      $this->em->persist( $event );
      $this->em->flush();
    }

  }
}
