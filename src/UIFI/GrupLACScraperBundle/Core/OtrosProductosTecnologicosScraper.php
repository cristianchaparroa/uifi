<?php

namespace UIFI\GrupLACScraperBundle\Core;

class OtrosProductosTecnologicosScraper  extends  Scraper
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
     * @return
     * $producto['tipo']
     * $producto['titulo']
     * $producto['anual']
     * $producto['disponibilidad']
     * $producto['nombre_comercial']
     * $producto['institucion_financiadora']
    */
    public function getOtrosProductosTecnologicos() {
  		 $query = '/html/body/table[26]';
  		 $array = $this->extraer( $query );
  		 $productos = array();
  		 foreach($array as $item ){
  			 $doc = new \DOMDocument();
  			 $doc->loadHTML( $item );
  			 $xpath = new \DOMXPath($doc);
  			 $list = $doc->getElementsByTagName('strong');
  			 $producto = array();
         $producto['nombreGrupo'] = $this->grupoDTO['nombre'];
         $producto['grupo'] = $this->grupoDTO['id'];
  			 foreach($list as $node ){
  				 $producto['tipo'] = $node->nodeValue;
  				 $tituloNode = $node->nextSibling;
  				 $titulo = $tituloNode->nodeValue;
  				 $titulo = str_replace(':','',$titulo);
  				 $titulo = utf8_encode ($titulo);
  				 $producto['titulo'] = $titulo;
  				 $list = $doc->getElementsByTagName('br');
  				 foreach($list as $node) {
  					 $nodesiguiente = $node->nextSibling;
  					 $value = $nodesiguiente->nodeValue;
  					 $valores = explode(",",$value);
  					 $pais = count($valores) > 1 ? $this->eliminarSaltoLinea($valores[0]) : "";
  					 $producto['pais'] = $pais;
  					 $anual = count($valores) > 1 ? $this->eliminarSaltoLinea($valores[1]) : "";
  					 $producto['anual'] = $anual;

  					 foreach($valores as $valor) {
  							 if(strpos($valor,'Disponibilidad')) {
  						      $result = explode(':',$valor);
      					    $disponibilidad = count($result) > 1 ? $this->eliminarSaltoLinea($result[1]) : "";
      						  $producto['disponibilidad'] = $disponibilidad;
  							 }
  							 if(strpos($valor,'Nombre comercial')) {
      						 $result = explode(':',$valor);
      						 $nombreComercial = count($result) > 1 ? $this->eliminarSaltoLinea($result[1]) : "";
      						 $producto['nombre_comercial'] = $nombreComercial;
  							 }
  							 if(strpos($valor,'Institución financiadora')) {
      						 $result = explode(':',$valor);
      						 $institucionFinanciadora = count($result) > 1 ? $this->eliminarSaltoLinea($result[1]) : "";
      						 $producto['institucion_financiadora'] = $institucionFinanciadora;
  							 }
  					 }
  				 }
  			 }
  			 $productos[] = $producto;
  		 }
  		 return $productos;
  	}


}
