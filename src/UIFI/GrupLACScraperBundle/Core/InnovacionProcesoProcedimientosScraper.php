<?php

namespace UIFI\GrupLACScraperBundle\Core;

class InnovacionProcesoProcedimientosScraper  extends  Scraper
{
    const URL_BASE='http://scienti.colciencias.gov.co:8080/gruplac/jsp/visualiza/visualizagr.jsp?nro=';
     /**
      * Constructor del objeto
      */
    public function __construct( $grupoDTO ) {
         Scraper::__construct( self::URL_BASE . $grupoDTO['id'] );
         $this->grupoDTO = $grupoDTO;
    }
    /**
    		* Obtienen la innovación gestión empresarial
    		* @return Arreglo de arreglos
    		* 		$innovacion['tipo'] el tipo de innovación
    		* 		$innovacion['titulo'] el titulo de innovación
    		* 		$innovacion['pais'] el pais de innovación
    		* 		$innovacion['anual'] el año de innovación
    		* 		$innovacion['disponibilidad'] la disponibilidad de innovación
    		* 		$innovacion['institucion_financiadora'] la institucion financiadora de innovación
    		*/
    public function getInnovacionProcesosProcedimientos(){
    		 $query = '/html/body/table[21]'; 
    		 $array = $this->extraer( $query );
    		 $innovaciones = array();
    		 foreach($array as $item ) {
    			 $doc = new \DOMDocument();
    			 $doc->loadHTML( $item );
    			 $xpath = new \DOMXPath($doc);
    			 $list = $doc->getElementsByTagName('strong');
    			 $innovacion = array();
           $innovacion['nombreGrupo'] = $this->grupoDTO['nombre'];
           $innovacion['grupo'] = $this->grupoDTO['id'];

    			 foreach($list as $node ) {
    				 $innovacion['tipo'] = $node->nodeValue;
    				 $tituloNode = $node->nextSibling;
    				 $titulo = $tituloNode->nodeValue;
    				 $titulo = str_replace(':','',$titulo);
    				 $titulo = utf8_encode ($titulo);
    				 $innovacion['titulo'] = $titulo;
    				 $list = $doc->getElementsByTagName('br');
    				 foreach($list as $node) {
    					 $nodesiguiente = $node->nextSibling;
    					 $value = $nodesiguiente->nodeValue;
    					 $valores = explode(",",$value);
    					 $pais = count($valores) > 1 ? $this->eliminarSaltoLinea($valores[0]) : "";
    					 $innovacion['pais'] = $pais;

    					 $anual = count($valores) > 1 ? $this->eliminarSaltoLinea($valores[1]) : "";
    					 $innovacion['anual'] = $anual;
    					 foreach($valores as $valor) {
    							 if(strpos($valor,'Disponibilidad')) {
    						      $result = explode(':',$valor);
    						      $disponibilidad = count($result) > 1 ? $this->eliminarSaltoLinea($result[1]) : "";
    						      $innovacion['disponibilidad'] = $disponibilidad;
    							 }
    							 if(strpos($valor,'Institución financiadora')) {
    						      $result = explode(':',$valor);
    						      $institucionFinanciadora = count($result) > 1 ? $this->eliminarSaltoLinea($result[1]) : "";
    						      $innovacion['institucion_financiadora'] = $institucionFinanciadora;
    							 }
    					 }
    				 }
    			 }
    			 $innovaciones[] = $innovacion;
    		 }
    		 return $innovaciones;
    }
}
