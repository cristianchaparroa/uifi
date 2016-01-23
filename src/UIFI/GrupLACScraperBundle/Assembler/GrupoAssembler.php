<?php

namespace UIFI\GrupLACScraperBundle\Assembler;

use UIFI\IntegrantesBundle\Entity\Grupo;

/**
  *@file
  *
  * Clase que se encarga de transformar un arreglo asociativo a un modelo
  * de grupo.
  *
  * @author: Cristian Camilo Chaparro A.
  *
  */

class GrupoAssembler{
  /**
   * Convierte un arreglo asocitivo a un modelo.
   * @param arreglo asociativo
   * @return modelo
  */
  public function crearModelo($grupoDTO) {
    $grupo = new Grupo();
    $grupo->setId($grupoDTO['id']);
    $grupo->setGruplac($grupoDTO['urlGruplac']);
    $grupo->setNombre($grupoDTO['nombre']);
    $grupo->setEmail($grupoDTO['email']);
    $grupo->setClasificacion($grupoDTO['clasificacion']);
    return $grupo;
  }
  /**
   * Convierte una lista de arreglos asociativos a una lista de modelos
   * @param lista de arreglos asociativos
   * @return lista de modelos
  */
  public function crearLista ($gruposDTO) {
    $grupos = array();
    foreach( $gruposDTO as $grupoDTO) {
      $grupos[] = $this->crearModelo($grupoDTO);
    }
    return $grupos;
  }
}
