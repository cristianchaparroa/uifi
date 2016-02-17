<?php

namespace UIFI\GrupLACScraperBundle\Assembler;

use UIFI\GrupLACScraperBundle\Core\CVLACScraper;
use UIFI\ProductosBundle\Entity\Prototipo;
use Symfony\Component\DependencyInjection\Container;

/**
  *@file
  *
  *  Clase que se encarga de transformar un arreglo asociativo a un modelo
  * de grupo.
  *
  *@author: Cristian Camilo Chaparro A.
  */

class PrototipoAssembler{

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
  public function crearModelo($prototipoDTO) {
    $prototipo = new Prototipo();
    $prototipo->setTitulo(array_key_exists('titulo',$prototipoDTO) ? $prototipoDTO['titulo'] : "");
    $prototipo->setTipo(array_key_exists('tipo',$prototipoDTO) ? $prototipoDTO['tipo'] : "");
    $prototipo->setAnual(array_key_exists('anual',$prototipoDTO) ? $prototipoDTO['anual'] : "");
    $prototipo->setPais(array_key_exists('pais',$prototipoDTO) ? $prototipoDTO['pais'] : "");
    $prototipo->setDisponibilidad(array_key_exists('disponibilidad',$prototipoDTO) ? $prototipoDTO['disponibilidad'] : "");
    $prototipo->setInstitucionFinanciadora(array_key_exists('institucion_financiadora',$prototipoDTO) ? $prototipoDTO['institucion_financiadora'] : "");

    $prototipo->setNombreGrupo(array_key_exists('nombreGrupo',$prototipoDTO) ?  $prototipoDTO['nombreGrupo'] : "");
    $prototipo->setGrupo(array_key_exists('grupo',$prototipoDTO) ?  $prototipoDTO['grupo'] : "");
    return $prototipo;
  }
  /**
   * Convierte una lista de arreglos asociativos a una lista de modelos
   * @param lista de arreglos asociativos
   * @return lista de modelos
  */
  public function crearLista($prototiposDTO) {
    $prototipos = array();
    foreach($prototiposDTO as $prototipoDTO){
        $prototipos[]  = $this->crearModelo($prototipoDTO);
    }
    return $prototipos;
  }
}
