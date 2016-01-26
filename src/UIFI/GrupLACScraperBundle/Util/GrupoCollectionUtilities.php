<?php
namespace UIFI\GrupLACScraperBundle\Util;

/**
  * @author: Cristian Camilo Chaparro A.
  */
class GrupoCollectionUtilities {
  /**
    * @param grupos Arreglo de entities
    * @param nombre del grupo a buscar
   */
  public function getGrupo($grupos,$nombreGrupo) {
    $grupo = NULL;
    foreach($grupos as $grupo) {
        if($grupo->getNombre() === $nombreGrupo) {
          return $grupo;
        }
    }
    return NULL;
  }
}
