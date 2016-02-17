<?php

namespace UIFI\GrupLACScraperBundle\Core;

class NormasRegulacionesScraper  extends  Scraper
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
  		* Obtienen las normas y regulaciones
  		* @return Arreglo de arreglos
  		* 		$norma['tipo'] el tipo de la norma
  		* 		$norma['titulo'] el titulo de la norma
  		* 		$norma['pais'] el pais de la norma
  		* 		$norma['anual'] el año de la norma
  		* 		$norma['ambito'] el ambito de la norma
  		* 		$norma['objeto'] el objeto de la norma
  		* 		$norma['institucion_financiadora'] la institucion financiadora de la norma
  		*/
  	public function getNormasRegulaciones() {
  		 $query = '/html/body/table[28]'; 
  		 $array = $this->extraer( $query );
  		 $normas = array();
  		 foreach($array as $item ){
  			 $doc = new \DOMDocument();
  			 $doc->loadHTML( $item );
  			 $xpath = new \DOMXPath($doc);
  			 $list = $doc->getElementsByTagName('strong');
  			 $norma = array();
         $norma['nombreGrupo'] = $this->grupoDTO['nombre'];
         $norma['grupo'] = $this->grupoDTO['id'];


  			 foreach($list as $node ){
  				 $norma ['tipo'] = $node->nodeValue;
  				 $tituloNode = $node->nextSibling;
  				 $titulo = $tituloNode->nodeValue;
  				 $titulo = str_replace(':','',$titulo);
  				 $titulo = utf8_encode ($titulo);
  				 $norma ['titulo'] = $titulo;
  				 $list = $doc->getElementsByTagName('br');
  				 foreach($list as $node){
  					 $nodesiguiente = $node->nextSibling;
  					 $value = $nodesiguiente->nodeValue;
  					 $valores = explode(",",$value);
  					 $pais = count($valores) > 1 ? $this->eliminarSaltoLinea($valores[0]) : "";
  					 $norma['pais'] = $pais;
  					 $anual = count($valores) > 1 ? $this->eliminarSaltoLinea($valores[1]) : "";
  					 $norma['anual'] = $anual;
  					 foreach($valores as $valor) {
  							 if(strpos($valor,'Ambito')){
      						 $result = explode(':',$valor);
      						 $ambito = count($result) > 1 ? $this->eliminarSaltoLinea($result[1]) : "";
      						 $norma['ambito'] = $ambito;
  							 }
  							 if(strpos($valor,'Objeto')){
      						 $result = explode(':',$valor);
      						 $objeto = count($result) > 1 ? $this->eliminarSaltoLinea($result[1]) : "";
      						 $norma['objeto'] = $objeto;
  							 }
  							 if(strpos($valor,'Institución financiadora')){
      						 $result = explode(':',$valor);
      						 $institucionFinanciadora = count($result) > 1 ? $this->eliminarSaltoLinea($result[1]) : "";
      						 $norma['institucion_financiadora'] = $institucionFinanciadora;
  							 }
  					 }
  				 }
  			 }
  			 $normas[] = $norma;
  		 }
  		 return $normas;
  	}

}
