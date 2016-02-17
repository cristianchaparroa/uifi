<?php

namespace UIFI\GrupLACScraperBundle\Assembler;

use UIFI\GrupLACScraperBundle\Core\CVLACScraper;
use UIFI\ProductosBundle\Entity\ConsultoriaCientifica;
use Symfony\Component\DependencyInjection\Container;

/**
  *@file
  *
  *  Clase que se encarga de transformar un arreglo asociativo a un modelo
  * de grupo.
  *
  *@author: Cristian Camilo Chaparro A.
  */

class ConsultoriaCientificaAssembler{

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
  public function crearModelo($consultoriaDTO) {
    $consultoria = new ConsultoriaCientifica();
    $consultoria->setTipo(array_key_exists('tipo',$consultoriaDTO) ? $consultoriaDTO['tipo'] : "");
    $consultoria->setTitulo(array_key_exists('titulo',$consultoriaDTO) ? $consultoriaDTO['titulo'] : "");
    $consultoria->setPais(array_key_exists('pais',$consultoriaDTO) ? $consultoriaDTO['pais'] : "");
    $consultoria->setAnual(array_key_exists('anual',$consultoriaDTO) ? $consultoriaDTO['anual'] : "");
    $consultoria->setIdioma(array_key_exists('idioma',$consultoriaDTO) ? $consultoriaDTO['idioma'] : "");
    $consultoria->setDisponibilidad(array_key_exists('disponibilidad',$consultoriaDTO) ? $consultoriaDTO['disponibilidad'] : "");
    $consultoria->setNumeroContrato(array_key_exists('numero_contrato',$consultoriaDTO) ? $consultoriaDTO['numero_contrato'] : "");
    $consultoria->setInstitucionBeneficiaria(array_key_exists('institucionBeneficiaria',$consultoriaDTO) ?  $consultoriaDTO['institucionBeneficiaria'] : "");
    $consultoria->setAutores(array_key_exists('autores',$consultoriaDTO) ? $consultoriaDTO['autores'] :"");
    $consultoria->setNombreGrupo(array_key_exists('nombreGrupo',$consultoriaDTO) ?  $consultoriaDTO['nombreGrupo'] : "");
    $consultoria->setGrupo(array_key_exists('grupo',$consultoriaDTO) ?  $consultoriaDTO['grupo'] : "");
    return $consultoria;
  }
  /**
   * Convierte una lista de arreglos asociativos a una lista de modelos
   * @param lista de arreglos asociativos
   * @return lista de modelos
  */
  public function crearLista($consultoriasDTO) {
    $consultorias = array();
    foreach($consultoriasDTO as $consultoriaDTO){
        $consultorias[]  = $this->crearModelo($consultoriaDTO);
    }
    return $consultorias;
  }
}
