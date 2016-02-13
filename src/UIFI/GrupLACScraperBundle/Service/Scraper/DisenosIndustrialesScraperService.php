<?php

namespace UIFI\GrupLACScraperBundle\Service\Scraper;

use Symfony\Component\DependencyInjection\Container;

use UIFI\GrupLACScraperBundle\Core\DisenosIndustrialesScraper;
/**
  * Clase que encarga de obtener la informacion de los Articulos
  * de un grupo de Investigación
  *
*/
 class DisenosIndustrialesScraperService {

    public function __construct(Container $container) {
      $this->container = $container;
      $this->em = $container->get('doctrine.orm.entity_manager');
      $this->logger = $container->get('logger');
    }
    /**
    * Obtiene las consultorias cientificicas de un grupo de Investigacion.
    * @param $grupoDTO grupo del cual se obtienen las consultorias
    * @return arreglo de consultorias del grupo
    */
    public function getDisenosIndustrialesGrupo($grupoDTO) {
      $scraper = new DisenosIndustrialesScraper($grupoDTO);
      return $scraper->getDisenosIndustriales();
    }

     /**
      * Obtienes los diseños industriales de los grupos de Investigacion
      * @param $grupoDTo del cual se desean obtener las consultorias
      * @return arreglo de consultorias del grupo de Investigacion.
     */
    public function getDisenosIndustriales($gruposDTO) {
       $disenos = array();
       foreach($gruposDTO as $grupoDTO) {
         $disenosGrupo = $this->getDisenosIndustrialesGrupo($grupoDTO);
         $disenos= array_merge($disenos,$disenosGrupo);
       }
       return  $disenos ;
    }
 }
