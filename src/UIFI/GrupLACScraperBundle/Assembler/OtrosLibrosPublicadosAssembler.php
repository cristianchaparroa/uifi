<?php

namespace UIFI\GrupLACScraperBundle\Assembler;

use UIFI\GrupLACScraperBundle\Core\CVLACScraper;
use UIFI\ProductosBundle\Entity\OtroLibro;
use Symfony\Component\DependencyInjection\Container;

/**
  *@file
  *
  *  Clase que se encarga de transformar un arreglo asociativo a un modelo
  * de grupo.
  *
  *@author: Cristian Camilo Chaparro A.
  */

class OtrosLibrosPublicadosAssembler{

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
  public function crearModelo($libroDTO) {
    $libro = new OtroLibro();
    $libro->setIsbn(array_key_exists('isbn',$libroDTO)?$libroDTO['isbn']:"");
    $libro->setTitulo(array_key_exists('titulo',$libroDTO) ? $libroDTO['titulo'] : "");
    $libro->setTipo(array_key_exists('tipo',$libroDTO) ? $libroDTO['tipo'] : "");
    $libro->setAnual(array_key_exists('anual',$libroDTO) ? $libroDTO['anual'] : "");
    $libro->setPais(array_key_exists('pais',$libroDTO) ? $libroDTO['pais'] : "");
    $libro->setVolumen(array_key_exists('volumen',$libroDTO) ? $libroDTO['volumen'] : "");
    $libro->setPaginas(array_key_exists('paginas',$libroDTO) ? $libroDTO['paginas'] : "");
    $libro->setEditorial(array_key_exists('editorial',$libroDTO) ? $libroDTO['editorial'] : "");
    $libro->setAutores(array_key_exists('autores',$libroDTO)?$libroDTO['autores']:"");
    $libro->setNombreGrupo(array_key_exists('nombreGrupo',$libroDTO) ?  $libroDTO['nombreGrupo'] : "");
    $libro->setGrupo(array_key_exists('grupo',$libroDTO) ?  $libroDTO['grupo'] : "");
    return $libro;
  }
  /**
   * Convierte una lista de arreglos asociativos a una lista de modelos
   * @param lista de arreglos asociativos
   * @return lista de modelos
  */
  public function crearLista($librosDTO) {
    $libros = array();
    foreach($librosDTO as $libroDTO){
        $libros[]  = $this->crearModelo($libroDTO);
    }
    return $libros;
  }
}
