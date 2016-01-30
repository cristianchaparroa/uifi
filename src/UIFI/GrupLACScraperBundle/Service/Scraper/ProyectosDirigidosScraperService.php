<?php

namespace UIFI\GrupLACScraperBundle\Service\Scraper;

use Symfony\Component\DependencyInjection\Container;

use UIFI\GrupLACScraperBundle\Core\ProyectosDirigidosScraper;
/**
  * Clase que encarga de obtener la informacion de los Articulos
  * de un grupo de Investigación
  *
*/
 class ProyectosDirigidosScraperService {
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
    public function getProyectosDirigidosGrupo($grupoDTO) {
      $grupoScraper = new ProyectosDirigidosScraper($grupoDTO);
      return $grupoScraper->getProyectosDirigidos();
    }

     /**
      * Obtienes los  Eventos de un grupo de Investigacion
      * @param $grupoDTo del cual se desean obtener los eventos
      * @return arreglo de eventos del grupo de Investigacion.
     */
     public function getProyectosDirigidos($gruposDTO) {
       $proyectos = array();
       foreach($gruposDTO as $grupoDTO) {
         $proyectos[] = $this->getProyectosDirigidosGrupo($grupoDTO);
       }
       return $proyectos;
     }
 }
