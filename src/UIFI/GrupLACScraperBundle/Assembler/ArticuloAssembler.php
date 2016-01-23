<?php

namespace UIFI\GrupLACScraperBundle\Assembler;

use UIFI\ProductosBundle\Entity\Articulo;
/**

  *
  * Clase que se encarga de transformar un arreglo asociativo a un modelo
  * de Articulo.
  *
  * @author: Cristian Camilo Chaparro A.
  *
  */
class ArticuloAssembler{
  /**
   * Convierte un arreglo asocitivo a un modelo.
   * @param arreglo asociativo
   * @return modelo
  */
  public function crearModelo($articuloDTO) {
      $articulo = new Articulo();
      // $articulo->setId( $codeArticulo  );
      $articulo->setTitulo($articuloDTO['titulo']);
      $articulo->setAnual($articuloDTO['anual']);
      $articulo->setISSN($articuloDTO['issn'] );
      $articulo->setTipo(array_key_exists('tipo',$articuloDTO) ?  $articuloDTO['tipo']:"");
      $articulo->setRevista(array_key_exists('revista',$articuloDTO) ?  $articuloDTO['revista']:"");
      $articulo->setVolumen(array_key_exists('volumen',$articuloDTO) ?  $articuloDTO['volumen']:"");
      $articulo->setFasciculo(array_key_exists('fasc',$articuloDTO) ?  $articuloDTO['fasc']:"");
      $articulo->setPaginas(array_key_exists('paginas',$articuloDTO) ?  $articuloDTO['paginas']:"");
      $articulo->setPais(array_key_exists('pais',$articuloDTO) ?  $articuloDTO['pais']:"");
      return $articulo;
  }
  /**
   * Convierte una lista de arreglos asociativos a una lista de modelos
   * @param lista de arreglos asociativos
   * @return lista de modelos
  */
  public function crearLista ($articuloDTOs) {
      $articulos = array();
      foreach ($articuloDTOs as $articuloDTO) {
        $articulos[] = $this->crearModelo($articuloDTO);
      }
      return $articulos;
  }
}
