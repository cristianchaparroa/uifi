<?php

namespace UIFI\GrupLACScraperBundle\Assembler;

use UIFI\GrupLACScraperBundle\Core\CVLACScraper;
use UIFI\ProductosBundle\Entity\InnovacionGestionEmpresarial;
use Symfony\Component\DependencyInjection\Container;

/**
  *@file
  *
  *  Clase que se encarga de transformar un arreglo asociativo a un modelo
  * de grupo.
  *
  *@author: Cristian Camilo Chaparro A.
  */

class InnovacionGestionEmpresarialAssembler{

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
  public function crearModelo($innovacionDTO) {
    $innovacion = new InnovacionGestionEmpresarial();
    $innovacion->setTitulo(array_key_exists('titulo',$innovacionDTO) ? $innovacionDTO['titulo'] : "");
    $innovacion->setTipo(array_key_exists('tipo',$innovacionDTO) ? $innovacionDTO['tipo'] : "");
    $innovacion->setAnual(array_key_exists('anual',$innovacionDTO) ? $innovacionDTO['anual'] : "");
    $innovacion->setPais(array_key_exists('pais',$innovacionDTO) ? $innovacionDTO['pais'] : "");
    $innovacion->setDisponibilidad(array_key_exists('disponibilidad',$innovacionDTO) ? $innovacionDTO['disponibilidad'] : "");
    $innovacion->setInstitucionFinanciadora(array_key_exists('institucionFinanciadora',$innovacionDTO) ? $innovacionDTO['institucionFinanciadora'] : "");
    $innovacion->setNombreGrupo(array_key_exists('nombreGrupo',$innovacionDTO) ?  $innovacionDTO['nombreGrupo'] : "");
    $innovacion->setGrupo(array_key_exists('grupo',$innovacionDTO) ?  $innovacionDTO['grupo'] : "");
    return $innovacion;
  }
  /**
   * Convierte una lista de arreglos asociativos a una lista de modelos
   * @param lista de arreglos asociativos
   * @return lista de modelos
  */
  public function crearLista($innovacionesDTO) {
    $innovaciones = array();
    foreach($innovacionesDTO as $innovacionDTO){
        $innovaciones[]  = $this->crearModelo($innovacionDTO);
    }
    return $innovaciones;
  }
}
