<?php

namespace UIFI\GrupLACScraperBundle\Assembler;

use UIFI\GrupLACScraperBundle\Core\CVLACScraper;
use UIFI\ProductosBundle\Entity\Evento;
use Symfony\Component\DependencyInjection\Container;

/**
  *@file
  *
  *  Clase que se encarga de transformar un arreglo asociativo a un modelo
  * de grupo.
  *
  *@author: Cristian Camilo Chaparro A.
  */

class EventoAssembler{
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
  public function crearModelo($eventoDTO) {
    $evento = new Evento();
    $evento->setTipo(array_key_exists('tipo',$eventoDTO) ? $eventoDTO['tipo'] : "");
    $evento->setTitulo(array_key_exists('titulo',$eventoDTO) ? $eventoDTO['titulo'] : "");
    $evento->setCiudad(array_key_exists('ciudad',$eventoDTO) ? $eventoDTO['ciudad'] : "");
    $evento->setDesde(array_key_exists('desde',$eventoDTO) ? $eventoDTO['desde'] : "");
    $evento->setHasta(array_key_exists('hasta',$eventoDTO) ? $eventoDTO['hasta'] : "");
    $evento->setAmbito(array_key_exists('ambito',$eventoDTO) ? $eventoDTO['ambito'] : "");
    $evento->setInstitucion(array_key_exists('institucion',$eventoDTO) ? $eventoDTO['institucion'] : "");
    $evento->setParticipacion(array_key_exists('participacion',$eventoDTO) ?  $eventoDTO['participacion'] : "");

    $evento->setNombreGrupo(array_key_exists('nombreGrupo',$eventoDTO) ?  $eventoDTO['nombreGrupo'] : "");
    $evento->setGrupo(array_key_exists('grupo',$eventoDTO) ?  $eventoDTO['grupo'] : "");
    return $evento;
  }
  /**
   * Convierte una lista de arreglos asociativos a una lista de modelos
   * @param lista de arreglos asociativos
   * @return lista de modelos
  */
  public function crearLista($eventossDTO) {
    $eventos = array();
    foreach($eventossDTO as $eventosDTO) {
      foreach($eventosDTO as $eventoDTO){
          $eventos[]  = $this->crearModelo($eventoDTO);
      }
    }
    return $eventos;
  }
}
