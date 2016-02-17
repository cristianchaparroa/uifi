<?php

namespace UIFI\GrupLACScraperBundle\Assembler;

use UIFI\GrupLACScraperBundle\Core\CVLACScraper;
use UIFI\ProductosBundle\Entity\OtroProductoTecnologico;
use Symfony\Component\DependencyInjection\Container;

/**
  *@file
  *
  *  Clase que se encarga de transformar un arreglo asociativo a un modelo
  * de grupo.
  *
  *@author: Cristian Camilo Chaparro A.
  */

class OtrosProductosTecnologicosAssembler{

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
  public function crearModelo($productoDTO) {
    $producto = new OtroProductoTecnologico();

    $producto->setTitulo(array_key_exists('titulo',$productoDTO) ? $productoDTO['titulo'] : "");
    $producto->setTipo(array_key_exists('tipo',$productoDTO) ? $productoDTO['tipo'] : "");
    $producto->setAnual(array_key_exists('anual',$productoDTO) ? $productoDTO['anual'] : "");
    $producto->setdisponibilidad(array_key_exists('disponibilidad',$productoDTO) ? $productoDTO['disponibilidad'] : "");
    $producto->setNombreComercial(array_key_exists('nombre_comercial',$productoDTO) ? $productoDTO['nombre_comercial'] : "");
    $producto->setInstitucionFinanciadora(array_key_exists('institucion_financiadora',$productoDTO) ? $productoDTO['institucion_financiadora'] : "");

    $producto->setNombreGrupo(array_key_exists('nombreGrupo',$productoDTO) ?  $productoDTO['nombreGrupo'] : "");
    $producto->setGrupo(array_key_exists('grupo',$productoDTO) ?  $productoDTO['grupo'] : "");
    return $producto;
  }
  /**
   * Convierte una lista de arreglos asociativos a una lista de modelos
   * @param lista de arreglos asociativos
   * @return lista de modelos
  */
  public function crearLista($productosDTO) {
    $productos = array();
    foreach($productosDTO as $productoDTO){
        $productos[]  = $this->crearModelo($productoDTO);
    }
    return $productos;
  }
}
