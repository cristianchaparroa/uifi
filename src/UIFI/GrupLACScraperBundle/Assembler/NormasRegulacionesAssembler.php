<?php

namespace UIFI\GrupLACScraperBundle\Assembler;

use UIFI\GrupLACScraperBundle\Core\CVLACScraper;
use UIFI\ProductosBundle\Entity\NormaRegulacion;
use Symfony\Component\DependencyInjection\Container;

/**
  *@file
  *
  *  Clase que se encarga de transformar un arreglo asociativo a un modelo
  * de grupo.
  *
  *@author: Cristian Camilo Chaparro A.
  */

class NormasRegulacionesAssembler{

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
  public function crearModelo($normaDTO) {
    $norma = new NormaRegulacion();
    $norma->setTitulo(array_key_exists('titulo',$normaDTO) ? $normaDTO['titulo'] : "");
    $norma->setTipo(array_key_exists('tipo',$normaDTO) ? $normaDTO['tipo'] : "");
    $norma->setAnual(array_key_exists('anual',$normaDTO) ? $normaDTO['anual'] : "");
    $norma->setPais(array_key_exists('pais',$normaDTO) ? $normaDTO['pais'] : "");
    $norma->setAmbito(array_key_exists('ambito',$normaDTO) ? $normaDTO['ambito'] : "");
    $norma->setInstitucionFinanciadora(array_key_exists('institucion_financiadora',$normaDTO) ? $normaDTO['institucion_financiadora'] : "");
    $norma->setObjeto(array_key_exists('objeto',$normaDTO) ? $normaDTO['objeto'] : "");
    $norma->setAutores(array_key_exists('autores',$normaDTO) ? $normaDTO['autores'] : "");
    $norma->setNombreGrupo(array_key_exists('nombreGrupo',$normaDTO) ?  $normaDTO['nombreGrupo'] : "");
    $norma->setGrupo(array_key_exists('grupo',$normaDTO) ?  $normaDTO['grupo'] : "");
    return $norma;
  }
  /**
   * Convierte una lista de arreglos asociativos a una lista de modelos
   * @param lista de arreglos asociativos
   * @return lista de modelos
  */
  public function crearLista($normasDTO) {
    $normas = array();
    foreach($normasDTO as $normaDTO){
        $normas[]  = $this->crearModelo($normaDTO);
    }
    return $normas;
  }
}
