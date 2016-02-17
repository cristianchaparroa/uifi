<?php

namespace UIFI\GrupLACScraperBundle\Assembler;

use UIFI\GrupLACScraperBundle\Core\CVLACScraper;
use UIFI\ProductosBundle\Entity\DisenoIndustrial;
use Symfony\Component\DependencyInjection\Container;

/**
  *@file
  *
  *  Clase que se encarga de transformar un arreglo asociativo a un modelo
  * de grupo.
  *
  *@author: Cristian Camilo Chaparro A.
  */

class DisenoIndustrialAssembler{

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
  public function crearModelo($disenoDTO) {
    $diseno = new DisenoIndustrial();

    $diseno->setTipo(array_key_exists('tipo',$disenoDTO) ? $disenoDTO['tipo'] : "");
    $diseno->setTitulo(array_key_exists('titulo',$disenoDTO) ? $disenoDTO['titulo'] : "");
    $diseno->setPais(array_key_exists('pais',$disenoDTO) ? $disenoDTO['pais'] : "");
    $diseno->setAnual(array_key_exists('anual',$disenoDTO) ? $disenoDTO['anual'] : "");
    $diseno->setDisponibilidad(array_key_exists('disponibilidad',$disenoDTO) ? $disenoDTO['disponibilidad'] : "");
    $diseno->setInstitucionFinanciadora(array_key_exists('institucion_financiadora',$disenoDTO) ? $disenoDTO['institucion_financiadora']: "");
    $diseno->setNombreGrupo(array_key_exists('nombreGrupo',$disenoDTO) ?  $disenoDTO['nombreGrupo'] : "");
    $diseno->setGrupo(array_key_exists('grupo',$disenoDTO) ?  $disenoDTO['grupo'] : "");
    return $diseno;
  }
  /**
   * Convierte una lista de arreglos asociativos a una lista de modelos
   * @param lista de arreglos asociativos
   * @return lista de modelos
  */
  public function crearLista($disenosDTO) {
    $disenos = array();
    foreach($disenosDTO as $disenoDTO){
        $disenos[]  = $this->crearModelo($disenoDTO);
    }
    return $disenos;
  }
}
