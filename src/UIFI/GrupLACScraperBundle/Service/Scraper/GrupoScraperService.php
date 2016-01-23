<?php

namespace UIFI\GrupLACScraperBundle\Service\Scraper;

use UIFI\GrupLACScraperBundle\Core\GrupLACScraper;

/**
  * Clase que encarga de obtener la informacion general de un grupo de
  * investigacion.
*/
class GrupoScraperService  {
  /**
   * obtiene una lista de grupos con la informacion general de estos
   * @param Lista de  codigos de los gruplas
   * @param Lista de arreglos asociativos con la informacion correspondiente
  */
  public function getGrupos($codes) {
    $grupos = array();
    foreach($codes as $code) {
      $grupo = $this->getGrupo($code);
      $grupos[] = $grupo;
    }
    return $grupos;
  }
  /**
   * Obtiene la información básica de un grupo de Investigación
   * @param $code, codigo del  GrupLAC
   * @return arreglo asociativo con la informacion
  */
  public function getGrupo($code) {
    $grupoScraper = new GrupLACScraper($code);
    $grupo  = array();
    $grupo['id'] = $code;
    $grupo['urlGruplac']  = $grupoScraper->getURL();
    $grupo['nombre'] =  "". $grupoScraper->getNombreGrupo();
    $grupo['email'] = $grupoScraper->extraerEmail();
    $grupo['clasificacion'] = $grupoScraper->extraerClasificacion();
    return $grupo;
  }
}
