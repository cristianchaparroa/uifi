<?php

namespace UIFI\GrupLACScraperBundle\Assembler;

use UIFI\GrupLACScraperBundle\Core\CVLACScraper;
use UIFI\ProductosBundle\Entity\DocumentoTrabajo;
use Symfony\Component\DependencyInjection\Container;

/**
  *@file
  *
  *  Clase que se encarga de transformar un arreglo asociativo a un modelo
  * de grupo.
  *
  *@author: Cristian Camilo Chaparro A.
  */

class DocumentoTrabajoAssembler{

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
  public function crearModelo($documentoDTO) {
    $documento = new DocumentoTrabajo();
    
    $documento->setTitulo(array_key_exists('titulo',$documentoDTO) ? $documentoDTO['titulo'] : "");
    $documento->setTipo(array_key_exists('tipo',$documentoDTO) ? $documentoDTO['tipo'] : "");
    $documento->setAnual(array_key_exists('anual',$documentoDTO) ? $documentoDTO['anual'] : "");
    $documento->setPaginas(array_key_exists('paginas',$documentoDTO) ? $documentoDTO['paginas'] : "");
    $documento->setInstituciones(array_key_exists('instituciones',$documentoDTO) ? $documentoDTO['instituciones'] : "");
    $documento->setUrl(array_key_exists('url',$documentoDTO) ? $documentoDTO['url'] : "");
    $documento->setDoi(array_key_exists('doi',$documentoDTO) ? $documentoDTO['doi'] : "");

    $documento->setNombreGrupo(array_key_exists('nombreGrupo',$documentoDTO) ?  $documentoDTO['nombreGrupo'] : "");
    $documento->setGrupo(array_key_exists('grupo',$documentoDTO) ?  $documentoDTO['grupo'] : "");
    return $documento;
  }
  /**
   * Convierte una lista de arreglos asociativos a una lista de modelos
   * @param lista de arreglos asociativos
   * @return lista de modelos
  */
  public function crearLista($documentosDTO) {
    $documentos = array();
    foreach($documentosDTO as $documentoDTO){
        $documentos[]  = $this->crearModelo($documentoDTO);
    }
    return $documentos;
  }
}
