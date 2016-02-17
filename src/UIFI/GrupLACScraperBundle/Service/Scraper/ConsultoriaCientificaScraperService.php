<?php

namespace UIFI\GrupLACScraperBundle\Service\Scraper;

use Symfony\Component\DependencyInjection\Container;

use UIFI\GrupLACScraperBundle\Core\ConsultoriaCientificaScraper;
/**
  * Clase que encarga de obtener la informacion de los Articulos
  * de un grupo de Investigación
  *
*/
 class ConsultoriaCientificaScraperService {

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
    public function getConsultoriasCientificasGrupo($grupoDTO) {
      $grupoScraper = new ConsultoriaCientificaScraper($grupoDTO,$this->logger);
      return $grupoScraper->getConsultoriaCientifica();
    }

     /**
      * Obtienes las consultorias cientificas de un grupo de Investigacion
      * @param $grupoDTo del cual se desean obtener las consultorias
      * @return arreglo de consultorias del grupo de Investigacion.
     */
    public function getConsultoriasCientificas($gruposDTO) {
       $consultorias = array();
       foreach($gruposDTO as $grupoDTO) {
         $consultoriasGrupo = $this->getConsultoriasCientificasGrupo($grupoDTO);
         $consultorias = array_merge($consultorias,$consultoriasGrupo);
       }
       return  $consultorias ;
    }
 }
