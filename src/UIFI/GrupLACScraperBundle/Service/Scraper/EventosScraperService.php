<?php

namespace UIFI\GrupLACScraperBundle\Service\Scraper;

use Symfony\Component\DependencyInjection\Container;

use UIFI\GrupLACScraperBundle\Core\EventosScraper;
/**
  * Clase que encarga de obtener la informacion de los Articulos
  * de un grupo de Investigación
  *
*/
 class EventosScraperService {
   public function __construct(Container $container) {
      $this->container = $container;
      $this->em = $container->get('doctrine.orm.entity_manager');
      $this->logger = $container->get('logger');
   }
    /**
    * Obtiene los Eventos de un grupo de Investigacion.
    * @param $grupoDTO grupo del cual se obtienen los eventos
    * @return arreglo con los eventos del grupo
    */
    public function getEventosGrupo($grupoDTO) {
      $grupoScraper = new EventosScraper($grupoDTO);
      return $grupoScraper->getEventos();
    }

     /**
      * Obtienes los  Eventos de un grupo de Investigacion
      * @param $grupoDTo del cual se desean obtener los eventos
      * @return arreglo de eventos del grupo de Investigacion.
     */
     public function getEventos($gruposDTO) {
       $eventos = array();
       foreach($gruposDTO as $grupoDTO) {
         $eventos[] = $this->getEventosGrupo($grupoDTO);
       }
       return $eventos;
     }
 }
