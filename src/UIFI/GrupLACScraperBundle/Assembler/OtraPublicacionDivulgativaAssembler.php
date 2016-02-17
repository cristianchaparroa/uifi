<?php

namespace UIFI\GrupLACScraperBundle\Assembler;

use UIFI\GrupLACScraperBundle\Core\CVLACScraper;
use UIFI\ProductosBundle\Entity\OtraPublicacionDivulgativa;
use Symfony\Component\DependencyInjection\Container;

/**
  *@file
  *
  *  Clase que se encarga de transformar un arreglo asociativo a un modelo
  * de grupo.
  *
  *@author: Cristian Camilo Chaparro A.
  */

class OtraPublicacionDivulgativaAssembler
{

  public function __construct(Container $container) {
     $this->container = $container;
     $this->em = $container->get('doctrine.orm.entity_manager');
     $this->logger = $container->get('logger');
  }
  /**
   * Convierte un arreglo asocitivo a un modelo.
   * @param arreglo asociativo
   * @return modelo
  */
  public function crearModelo($publicacionDTO) {
    $publicacion = new OtraPublicacionDivulgativa();
    $publicacion->setTitulo(array_key_exists('titulo',$publicacionDTO) ? $publicacionDTO['titulo'] : "");
    $publicacion->setTipo(array_key_exists('tipo',$publicacionDTO) ? $publicacionDTO['tipo'] : "");
    $publicacion->setAnual(array_key_exists('anual',$publicacionDTO) ? $publicacionDTO['anual'] : "");
    $publicacion->setPais(array_key_exists('pais',$publicacionDTO) ? $publicacionDTO['pais'] : "");
    $publicacion->setIsbn(array_key_exists('isbn',$publicacionDTO) ? $publicacionDTO['isbn'] : "");
    $publicacion->setVolumen(array_key_exists('volumen',$publicacionDTO) ? $publicacionDTO['volumen'] : "");
    $publicacion->setPaginas(array_key_exists('paginas',$publicacionDTO) ? $publicacionDTO['paginas'] : "");

    $publicacion->setNombreGrupo(array_key_exists('nombreGrupo',$publicacionDTO) ?  $publicacionDTO['nombreGrupo'] : "");
    $publicacion->setGrupo(array_key_exists('grupo',$publicacionDTO) ?  $publicacionDTO['grupo'] : "");
    return $publicacion;
  }
  /**
   * Convierte una lista de arreglos asociativos a una lista de modelos
   * @param lista de arreglos asociativos
   * @return lista de modelos
  */
  public function crearLista($publicacionesDTO) {
    $publicaciones = array();
    foreach($publicacionesDTO as $publicacionDTO){
        $publicaciones[]  = $this->crearModelo($publicacionDTO);
    }
    return $publicaciones;
  }
}
