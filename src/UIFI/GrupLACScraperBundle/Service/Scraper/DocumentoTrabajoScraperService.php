<?php

namespace UIFI\GrupLACScraperBundle\Service\Scraper;

use Symfony\Component\DependencyInjection\Container;

use UIFI\GrupLACScraperBundle\Core\DocumentoTrabajoScraper;
/**
  * Clase que encarga de obtener la informacion de los Documentos de trabajo
  * de un grupo de Investigación
  *
*/
 class DocumentoTrabajoScraperService {

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
    public function getDocumentosTrabajoGrupo($grupoDTO) {
      $scraper = new DocumentoTrabajoScraper($grupoDTO);
      return $scraper->getDocumentosTrabajo();
    }

     /**
      * Obtienes los documentors de trabajo de los grupos de Investigacion
      * @param $grupoDTo del cual se desean obtener los documentos
      * @return arreglo de  documentos de los  grupos de Investigacion.
     */
    public function getDocumentosTrabajo($gruposDTO) {
       $disenos = array();
       foreach($gruposDTO as $grupoDTO) {
         $disenosGrupo = $this->getDocumentosTrabajoGrupo($grupoDTO);
         $disenos= array_merge($disenos,$disenosGrupo);
       }
       return  $disenos ;
    }
 }
