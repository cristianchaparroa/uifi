<?php

namespace UIFI\GrupLACScraperBundle\Assembler;

use UIFI\GrupLACScraperBundle\Core\CVLACScraper;
use UIFI\IntegrantesBundle\Entity\Integrante;
use UIFI\IntegrantesBundle\Entity\IntegranteDirector;
use Symfony\Component\DependencyInjection\Container;
/**
  *@file
  *
  *  Clase que se encarga de transformar un arreglo asociativo a un modelo
  * de grupo.
  *
  *@author: Cristian Camilo Chaparro A.
  */

class IntegranteAssembler{
  public function __construct(Container $container) {
     $this->container = $container;
     $this->em = $container->get('doctrine.orm.entity_manager');
  }
  /**
   * Convierte un arreglo asocitivo a un modelo.
   * @param arreglo asociativo
   * @return modelo
  */
  public function crearModelo($integranteDTO) {
    $logger = $this->container->get('logger');
    $integrante = new Integrante();
    // $integrante->setGruplac();
    $integrante->setNombres(array_key_exists('nombre',$integranteDTO) ? $integranteDTO['nombre'] : "");
    $integrante->setNombreGrupo(array_key_exists('nombreGrupo',$integranteDTO) ?  $integranteDTO['nombreGrupo'] : "");
    $logger->err($integrante);
    return $integrante;
  }
  /**
   * Convierte una lista de arreglos asociativos a una lista de modelos
   * @param lista de arreglos asociativos
   * @return lista de modelos
  */
  public function crearLista($integrantessDTO) {
    $integrantes = array();
    foreach( $integrantessDTO as $integrantesDTO) {
      foreach($integrantesDTO as $integranteDTO) {
        $integrantes[] = $this->crearModelo($integranteDTO);
      }
    }
    return $integrantes;
  }
}
