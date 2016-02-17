<?php

namespace UIFI\GrupLACScraperBundle\Assembler;

use UIFI\GrupLACScraperBundle\Core\CVLACScraper;
use UIFI\ProductosBundle\Entity\SignoDistintivo;
use Symfony\Component\DependencyInjection\Container;

/**
  *@file
  *
  *  Clase que se encarga de transformar un arreglo asociativo a un modelo
  * de grupo.
  *
  *@author: Cristian Camilo Chaparro A.
  */

class SignosDistintivosAssembler{

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
  public function crearModelo($signoDTO) {
    $signo = new SignoDistintivo();

    $signo->setTitulo(array_key_exists('titulo',$signoDTO) ? $signoDTO['titulo'] : "");
    $signo->setTipo(array_key_exists('tipo',$signoDTO) ? $signoDTO['tipo'] : "");
    $signo->setAnual(array_key_exists('anual',$signoDTO) ? $signoDTO['anual'] : "");
    $signo->setPais(array_key_exists('pais',$signoDTO) ? $signoDTO['pais'] : "");
    $signo->setNumeroRegistro(array_key_exists('numeroRegistro',$signoDTO) ? $signoDTO['numeroRegistro'] : "");

    $signo->setNombreGrupo(array_key_exists('nombreGrupo',$signoDTO) ?  $signoDTO['nombreGrupo'] : "");
    $signo->setGrupo(array_key_exists('grupo',$signoDTO) ?  $signoDTO['grupo'] : "");
    return $signo;
  }
  /**
   * Convierte una lista de arreglos asociativos a una lista de modelos
   * @param lista de arreglos asociativos
   * @return lista de modelos
  */
  public function crearLista($signosDTO) {
    $signos = array();
    foreach($signosDTO as $signoDTO){
        $signos[]  = $this->crearModelo($signoDTO);
    }
    return $signos;
  }
}
