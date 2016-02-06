<?php

namespace UIFI\GrupLACScraperBundle\Service\Scraper;

use Symfony\Component\DependencyInjection\Container;

use UIFI\GrupLACScraperBundle\Core\SoftwareScraper;
/**
  * Clase que encarga de obtener la informacion de los Software
  * de un grupo de Investigación
  *
*/
 class SoftwareScraperService {
   public function __construct(Container $container) {
      $this->container = $container;
      $this->em = $container->get('doctrine.orm.entity_manager');
      $this->logger = $container->get('logger');
   }
    /**
    * Obtiene los Software de un grupo de Investigacion.
    * @param $grupoDTO grupo del cual se obtienen los software
    * @return arreglo con los software del grupo
    */
    public function getSoftwareGrupo($grupoDTO) {
      $grupoScraper = new SoftwareScraper($grupoDTO,$this->logger);
      return $grupoScraper->getSoftware();
    }

     /**
      * Obtienes los  Software de un grupo de Investigacion
      * @param $grupoDTo del cual se desean obtener los software
      * @return arreglo de software del grupo de Investigacion.
     */
     public function getSoftware($gruposDTO) {
       $software = array();
       foreach($gruposDTO as $grupoDTO) {
         $soft = $this->getSoftwareGrupo($grupoDTO);
         $software = array_merge($software,$soft);
       }
       return  $software;
     }
 }
