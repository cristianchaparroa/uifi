<?php

namespace UIFI\GrupLACScraperBundle\Service\Scraper;

use Symfony\Component\DependencyInjection\Container;
use UIFI\GrupLACScraperBundle\Core\ArticulosScraper;
/**
  * Clase que encarga de obtener la informacion de los Articulos
  * de un grupo de Investigación
  *
*/
 class ArticulosScraperService {

   public function __construct(Container $container) {
      $this->container = $container;
      $this->em = $container->get('doctrine.orm.entity_manager');
      $this->logger = $container->get('logger');
   }
    /**
    * Obtiene los Articulos de un grupo de Investigacion.
    * @param $grupoDTO grupo del cual se obtienen los articulos
    * @return arreglo con los articulos del grupo
    */
    public function getArticulosGrupo($grupoDTO) {
      $grupoScraper = new ArticulosScraper($grupoDTO);
      return $grupoScraper->getArticulos();
    }

     /**
      * Obtienes los Articulos de un grupo de Investigacion
      * @param $grupoDTo del cual se desean obtener los articulos
      * @return arreglo de articulos de los  grupos de Investigacion.
     */
     public function getArticulos($gruposDTO) {
       $articulos = array();
       foreach($gruposDTO as $grupoDTO) {
         $articulosGrupo = $this->getArticulosGrupo($grupoDTO);
         $articulos = array_merge($articulos,$articulosGrupo);
       }
       return  $articulos;
     }
 }
