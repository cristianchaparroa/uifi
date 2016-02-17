<?php

namespace UIFI\GrupLACScraperBundle\Core;

class SignosDistintivosScraper  extends  Scraper
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
  		* Obtienen los signos distintivos
  		* @return Arreglo de arreglos
  		* 		$signo['tipo'] el tipo del signo distintivo
  		* 		$signo['titulo'] el titulo del signo distintivo
  		* 		$signo['pais'] el pais del signo distintivo
  		* 		$signo['anual'] el año del signo distintivo
  		* 		$signo['numeroRegistro'] el número de registro del signo distintivo
  		*/
  	public function getSignosDistintivos() {
  		 $query = '/html/body/table[30]';
  		 $array = $this->extraer( $query );
  		 $signos = array();
  		 foreach($array as $item ){
  			 $doc = new \DOMDocument();
  			 $doc->loadHTML( $item );
  			 $xpath = new \DOMXPath($doc);
  			 $list = $doc->getElementsByTagName('strong');
  			 $signo = array();
         $signo['nombreGrupo'] = $this->grupoDTO['nombre'];
         $signo['grupo'] = $this->grupoDTO['id'];

  			 foreach($list as $node ) {
  				 $signo ['tipo'] = $node->nodeValue;
  				 $tituloNode = $node->nextSibling;
  				 $titulo = $tituloNode->nodeValue;
  				 $titulo = str_replace(':','',$titulo);
  				 $titulo = utf8_encode ($titulo);
  				 $signo ['titulo'] = $titulo;
  				 $list = $doc->getElementsByTagName('br');
  				 foreach($list as $node) {
  					 $nodesiguiente = $node->nextSibling;
  					 $value = $nodesiguiente->nodeValue;
  					 $valores = explode(",",$value);
  					 $pais = count($valores) > 1 ? $this->eliminarSaltoLinea($valores[0]) : "";
  					 $signo['pais'] = $pais;

  					 $anual = count($valores) > 1 ? $this->eliminarSaltoLinea($valores[1]) : "";
  					 $signo['anual'] = $anual;
  					 foreach($valores as $valor) {
  							 if(strpos($valor,'Número del registro')) {
    						 $result = explode(':',$valor);
    						 $numeroRegistro = count($result) > 1 ? $this->eliminarSaltoLinea($result[1]) : "";
    						 $signo['numeroRegistro'] = $numeroRegistro;
  							 }
  					 }
  				 }
  			 }
  			 $signos[] = $signo;
  		 }
  		 return $signos;
  	}

}
