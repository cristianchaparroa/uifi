<?php

namespace UIFI\GrupLACScraperBundle\Assembler;

use UIFI\IntegrantesBundle\Entity\Integrante;
use UIFI\IntegrantesBundle\Entity\IntegranteDirector;
/**
  *@file
  *
  *  Clase que se encarga de transformar un arreglo asociativo a un modelo
  * de grupo.
  *
  *@author: Cristian Camilo Chaparro A.
  */

class IntegranteAssembler{
  /**
   * Convierte un arreglo asocitivo a un modelo.
   * @param arreglo asociativo
   * @return modelo
  */
  public function crearModelo($integranteDTO) {
    $integrante = new Integrante();
    $integrante->setNombres($integranteDTO['nombre']);
    $integrante->setVinculacion($integranteDTO['vinculacion']);
    $integrantesDTOcraper = new CVLACScraper($integranteDTO['codigoIntegrante']);
    // $integrante->addGrupo( $this->grupo );
    $integrante->setId( $cvlacIntegrante );
    $integrante->setCodigoGruplac( $integrantesDTOcraper->getCode()  );
    // $integrante->setNombreGrupo( $this->grupo->getNombre());
    $integrante->setNombres( $nombreIntegrante );
    return $integrante;
  }
  /**
   * Convierte una lista de arreglos asociativos a una lista de modelos
   * @param lista de arreglos asociativos
   * @return lista de modelos
  */
  public function crearLista ($integrantesDTO) {
    $integrantes = array();
    foreach($integrantesDTO as $integrante) {
      $integrante[] = $this->crearModelo($integrante);
    }
    return $integrante;
  }
  public function crearListas($gruposDTO){

  }
}
