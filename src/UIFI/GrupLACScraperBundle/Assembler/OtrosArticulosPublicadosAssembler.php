<?php

namespace UIFI\GrupLACScraperBundle\Assembler;

use UIFI\GrupLACScraperBundle\Core\CVLACScraper;
use UIFI\ProductosBundle\Entity\OtroArticulo;
use Symfony\Component\DependencyInjection\Container;

/**
  *@file
  *
  *  Clase que se encarga de transformar un arreglo asociativo a un modelo
  * de grupo.
  *
  *@author: Cristian Camilo Chaparro A.
  */

class OtrosArticulosPublicadosAssembler{

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
  public function crearModelo($articuloDTO) {
    $articulo = new OtroArticulo();

    $articulo->setTitulo(array_key_exists('titulo',$articuloDTO) ? $articuloDTO['titulo'] : "");
    $articulo->setTipo(array_key_exists('tipo',$articuloDTO) ? $articuloDTO['tipo'] : "");
    $articulo->setAnual(array_key_exists('anual',$articuloDTO) ? $articuloDTO['anual'] : "");
    $articulo->setPais(array_key_exists('pais',$articuloDTO) ? $articuloDTO['pais'] : "");
    $articulo->setIssn(array_key_exists('issn',$articuloDTO) ? $articuloDTO['issn'] : "");
    $articulo->setRevista(array_key_exists('revista',$articuloDTO) ? $articuloDTO['revista'] : "");
    $articulo->setVolumen(array_key_exists('volumen',$articuloDTO) ? $articuloDTO['volumen'] : "");
    $articulo->setFasciculo(array_key_exists('fasciculo',$articuloDTO) ? $articuloDTO['fasciculo'] : "");
    $articulo->setPaginas(array_key_exists('paginas',$articuloDTO) ? $articuloDTO['paginas'] : "");
    $articulo->setAutores(array_key_exists('autores',$articuloDTO) ? $articuloDTO['autores']: "" );

    $articulo->setNombreGrupo(array_key_exists('nombreGrupo',$articuloDTO) ?  $articuloDTO['nombreGrupo'] : "");
    $articulo->setGrupo(array_key_exists('grupo',$articuloDTO) ?  $articuloDTO['grupo'] : "");
    return $articulo;
  }
  /**
   * Convierte una lista de arreglos asociativos a una lista de modelos
   * @param lista de arreglos asociativos
   * @return lista de modelos
  */
  public function crearLista($articulosDTO) {
    $articulos = array();
    foreach($articulosDTO as $articuloDTO){
        $articulos[]  = $this->crearModelo($articuloDTO);
    }
    return $articulos;
  }
}
