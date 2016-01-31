<?php
namespace UIFI\GrupLACScraperBundle\Util;

use Symfony\Component\DependencyInjection\Container;
/**
  * @author: Cristian Camilo Chaparro A.
  */
class GrupoCollectionUtilities {
  public function __construct(Container $container) {
     $this->container = $container;
     $this->em = $container->get('doctrine.orm.entity_manager');
     $this->logger = $container->get('logger');
  }
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
