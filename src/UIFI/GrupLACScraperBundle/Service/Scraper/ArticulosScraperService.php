<?php

namespace UIFI\GrupLACScraperBundle\Service\Scraper;

use UIFI\GrupLACScraperBundle\Core\GrupLACScraper;
/**
  * Clase que encarga de obtener la informacion de los Articulos
  * de un grupo de Investigación
  *
*/
 class ArticulosScraperService {
    /**
    * Obtiene los articulos de los grupos de un
    * cojunto de grupos de investigacion
    * @param $codes, codigos de los grupos de investigacion
    * @return arreglo con los articulos de cada grupo.
    */
    public function getArticulosGrupos($codes) {
       $articulos = array();
       foreach($codes as $code) {
         $articulos[] =  $this->getArticulos($code);
       }
       return $articulos;
    }

     /**
      * Obtienes los articulos de un grupo de Investigacion
      * @param $code, codigo del grupo de Investigacion
      * @return arreglo de articulos del grupo de Investigacion.
     */
     public function getArticulos($code) {
       $grupoScraper = new GrupLACScraper($code);
       $articulos    = $grupoScraper->getArticulos();
       return $articulos;
     }
 }
