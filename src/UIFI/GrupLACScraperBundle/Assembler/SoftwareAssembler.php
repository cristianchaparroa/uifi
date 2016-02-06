<?php

namespace UIFI\GrupLACScraperBundle\Assembler;

use UIFI\GrupLACScraperBundle\Core\CVLACScraper;
use UIFI\ProductosBundle\Entity\Software;
use Symfony\Component\DependencyInjection\Container;

/**
  *@file
  *
  *  Clase que se encarga de transformar un arreglo asociativo a un modelo
  * de grupo.
  *
  *@author: Cristian Camilo Chaparro A.
  */

class SoftwareAssembler {
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
  public function crearModelo($softwareDTO) {
    $software = new Software();
    $software->setPais(array_key_exists('pais', $softwareDTO) ? $softwareDTO['pais'] : "");
    $software->setTitulo(array_key_exists('titulo',$softwareDTO) ? $softwareDTO['titulo'] : "");
    $software->setAnual(array_key_exists('anual',$softwareDTO) ? $softwareDTO['anual' ] : "" );
    $software->setDisponible(array_key_exists('disponibilidad',$softwareDTO) ? $softwareDTO['disponibilidad'] : "");
    $software->setTipo(array_key_exists('nombreComercial',$softwareDTO) ? $softwareDTO['nombreComercial'] : "");
    $software->setSitioWeb(array_key_exists('sitioWeb',$softwareDTO) ? $softwareDTO['sitioWeb'] : "");
    $software->setInstitucionFinanciera(array_key_exists('institucionFinanciera',$softwareDTO) ? $softwareDTO['institucionFinanciera'] : "");
    $software->setNombreGrupo(array_key_exists('nombreGrupo',$softwareDTO) ?  $softwareDTO['nombreGrupo'] : "");
    $software->setGrupo(array_key_exists('grupo',$softwareDTO) ?  $softwareDTO['grupo'] : "");
    $autores = array_key_exists('autores',$softwareDTO) ?  $softwareDTO['autores'] : array();
    $autoresString = "";
    foreach($autores as $autor) {
      $autoresString = $autoresString . $autor .",";
    }
    $autoresString = substr($autoresString, 0, -1);
    $software->setAutores( $autoresString );
    return $software;
  }
  /**
   * Convierte una lista de arreglos asociativos a una lista de modelos
   * @param lista de arreglos asociativos
   * @return lista de modelos
  */
  public function crearLista($softwaresDTO) {
    $software = array();
    foreach($softwaresDTO as $softwareDTO) {
        $software[]  = $this->crearModelo($softwareDTO);
    }
    return $software ;
  }
}
