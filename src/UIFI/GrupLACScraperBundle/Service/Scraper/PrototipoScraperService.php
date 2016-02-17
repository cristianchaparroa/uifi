<?php

namespace UIFI\GrupLACScraperBundle\Service\Scraper;

use Symfony\Component\DependencyInjection\Container;

use UIFI\GrupLACScraperBundle\Core\PrototipoScraper;
/**
  * Clase que encarga de obtener la informacion de los Documentos de trabajo
  * de un grupo de Investigación
  *
*/
 class PrototipoScraperService {

    public function __construct(Container $container) {
      $this->container = $container;
      $this->em = $container->get('doctrine.orm.entity_manager');
      $this->logger = $container->get('logger');
    }
    /**
    * Obtiene los docuementros de trabajo  de un grupo de Investigacion.
    * @param $grupoDTO grupo del cual se obtienen los documentos
    * @return arreglo de docuementos del grupo
    */
    public function getPrototiposGrupo($grupoDTO) {
      $scraper = new PrototipoScraper($grupoDTO);
      return $scraper->getPrototipos();
    }

     /**
      * Obtienes los documentors de trabajo de los grupos de Investigacion
      * @param $grupoDTo del cual se desean obtener los documentos
      * @return arreglo de  documentos de los  grupos de Investigacion.
     */
    public function getPrototipos($gruposDTO) {
       $innovacion = array();
       foreach($gruposDTO as $grupoDTO) {
         $innovacionGrupo = $this->getPrototiposGrupo($grupoDTO);
         $innovacion = array_merge($innovacion,$innovacionGrupo);
       }
       return  $innovacion;
    }
 }
