<?php
namespace UIFI\GrupLACScraperBundle\Util;

use Symfony\Component\DependencyInjection\Container;
/**
  * @author: Cristian Camilo Chaparro A.
  */
class ProyectoDirigidoCollectionUtilities {
  public function __construct(Container $container) {
     $this->container = $container;
     $this->em = $container->get('doctrine.orm.entity_manager');
     $this->logger = $container->get('logger');
  }
  /**
    * @param proyectosDTO, todos los proyectos
    * @param proyecto(Model) proyecto al cual se le busca el integrante
    * @param integrantes{Models} integrantes en el sistema.
   */
  public function getAutores($proyectosDTO,$proyecto,$integrantes) {
    $members = array();
    foreach($proyectosDTO as $proyectoDTO) {
        if ($proyectoDTO['titulo'] === $proyecto->GetTitulo()) {
          $autores = $proyectoDTO['autores'];
          foreach($integrantes as $integrante) {
              foreach($autores as $autor) {
                if(strtolower($autor) === strtolower($integrante->getNombres())) {
                  $members[] = $integrante;
                }
              }
          }
        }
    }
    return $members;
  }
}
