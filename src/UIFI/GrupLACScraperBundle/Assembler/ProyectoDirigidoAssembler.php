<?php

namespace UIFI\GrupLACScraperBundle\Assembler;

use UIFI\GrupLACScraperBundle\Core\CVLACScraper;
use UIFI\ProductosBundle\Entity\ProyectoDirigido;
use Symfony\Component\DependencyInjection\Container;

/**
  *@file
  *
  *  Clase que se encarga de transformar un arreglo asociativo a un modelo
  * de grupo.
  *
  *@author: Cristian Camilo Chaparro A.
  */

class ProyectoDirigidoAssembler{
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
  public function crearModelo($proyectoDirigidoDTO) {
    $proyectDirigido = new ProyectoDirigido();
    $proyectDirigido->setTitulo(array_key_exists('titulo',$proyectoDirigidoDTO) ? $proyectoDirigidoDTO['titulo'] : "");
    $proyectDirigido->setTipo(array_key_exists('tipo',$proyectoDirigidoDTO) ? $proyectoDirigidoDTO['tipo'] : "");
    $proyectDirigido->setTipoOrientacion(array_key_exists('titulo',$proyectoDirigidoDTO) ? $proyectoDirigidoDTO['titulo'] : "");
    $proyectDirigido->setNombreEstudiante(array_key_exists('nombreEstudiante',$proyectoDirigidoDTO) ? $proyectoDirigidoDTO['nombreEstudiante'] : "");
    $proyectDirigido->setProyectoAcademico(array_key_exists('proyectoAcademico',$proyectoDirigidoDTO) ? $proyectoDirigidoDTO['proyectoAcademico'] : "");
    $proyectDirigido->setNumeroPaginas(array_key_exists('numeroPaginas',$proyectoDirigidoDTO) ? $proyectoDirigidoDTO['numeroPaginas'] : "");
    $proyectDirigido->setValoracion(array_key_exists('valoracion',$proyectoDirigidoDTO) ? $proyectoDirigidoDTO['valoracion'] : "");
    $proyectDirigido->setInstitucion(array_key_exists('institucion',$proyectoDirigidoDTO) ? $proyectoDirigidoDTO['institucion'] : "");
    $proyectDirigido->setNombreGrupo(array_key_exists('nombreGrupo',$proyectoDirigidoDTO) ?  $proyectoDirigidoDTO['nombreGrupo'] : "");
    $proyectDirigido->setGrupo(array_key_exists('grupo',$proyectoDirigidoDTO) ?  $proyectoDirigidoDTO['grupo'] : "");

    $proyectDirigido->setMesInicial(array_key_exists('mesInicial',$proyectoDirigidoDTO) ?  $proyectoDirigidoDTO['mesInicial'] : "");
    $proyectDirigido->setMesFinal(array_key_exists('mesFinal',$proyectoDirigidoDTO) ?  $proyectoDirigidoDTO['mesFinal'] : "");
    $proyectDirigido->setAnualInicial(array_key_exists('anualInicial',$proyectoDirigidoDTO) ?  $proyectoDirigidoDTO['anualInicial'] : "");
    $proyectDirigido->setAnualFinal(array_key_exists('anualFinal',$proyectoDirigidoDTO) ?  $proyectoDirigidoDTO['anualFinal'] : "");
    return $proyectDirigido;
  }
  /**
   * Convierte una lista de arreglos asociativos a una lista de modelos
   * @param lista de arreglos asociativos
   * @return lista de modelos
  */
  public function crearLista($proyectosDTO) {
    $proyectos = array();
    foreach($proyectosDTO as $pryectoDirigidoDTO){
        $proyectos[]  = $this->crearModelo($pryectoDirigidoDTO);
    }
    return $proyectos;
  }
}
