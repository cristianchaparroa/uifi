<?php

namespace UIFI\GrupLACScraperBundle\Service\Scraper;

use UIFI\GrupLACScraperBundle\Core\IntegrantesScraper;
/**
  * Clase que encarga de obtener la informacion de los Articulos
  * de un grupo de Investigación
  *
*/
 class IntegrantesScraperService {
    /**
    * Obtiene los integrantes de un grupo de Investigacion.
    * @param $codes, codigos de los grupos de investigacion
    * @return arreglo con los articulos de cada grupo.
    */
    public function getIntegrantesGrupo($grupoDTO) {
      $grupoScraper = new IntegrantesScraper($grupoDTO);
      return $grupoScraper->obtenerIntegrantes();
    }

     /**
      * Obtienes los  Integrantes de un grupo de Investigacion
      * @param $grupo (Model) del cual se desean obtener los integrantes
      * @return arreglo de articulos del grupo de Investigacion.
     */
     public function getIntegrantes($gruposDTO) {
       $integrantes = array();
       foreach($gruposDTO as $grupoDTO){
         $integrantes[] = $this->getIntegrantesGrupo($grupoDTO);
       }
       return $integrantes;
     }
 }
