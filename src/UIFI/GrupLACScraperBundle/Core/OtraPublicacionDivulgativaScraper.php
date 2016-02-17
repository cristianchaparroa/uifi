<?php

namespace UIFI\GrupLACScraperBundle\Core;

class OtraPublicacionDivulgativaScraper  extends  Scraper
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
    		* Obtienen las otras publicaciones divulgativas
    		* @return Arreglo de arreglos
    		* 		$publicacion['titulo'] el titulo de la publicación
    		* 		$publicacion['país'] el país de la publicación
    		* 		$publicacion['anual'] el año de la publicación
    		* 		$publicacion['isbn'] el isbn de la publicación
    		* 		$publicacion['tipo'] el tipo de la publicación
    		* 		$publicacion['volumen'] el volumen de la publicación
    		* 		$publicacion['paginas'] las páginas de la publicación
    		* 		$publicacion['editorial'] la editorial de la publicación
    		*/
    public function getOtrasPublicaciones() {
    		 $query = '/html/body/table[12]';
    		 $array = $this->extraer( $query );
    		 $publicaciones = array();
    		 foreach($array as $item ){
    			 $doc = new \DOMDocument();
    			 $doc->loadHTML( $item );
    			 $xpath = new \DOMXPath($doc);
    			 $list = $doc->getElementsByTagName('strong');
    			 $publicacion = array();
           $publicacion['nombreGrupo'] = $this->grupoDTO['nombre'];
           $publicacion['grupo'] = $this->grupoDTO['id'];


    			 foreach($list as $node ){
    				 $publicacion['tipo'] = $node->nodeValue;
    				 $tituloNode = $node->nextSibling;
    				 $titulo = $tituloNode->nodeValue;
    				 $titulo = str_replace(':','',$titulo);
    				 $titulo = utf8_encode ($titulo);
    				 $publicacion['titulo'] = $titulo;
    				 $list = $doc->getElementsByTagName('br');
    				 foreach($list as $node){
    					 $nodesiguiente = $node->nextSibling;
    					 $value = $nodesiguiente->nodeValue;
    					 $valores = explode(",",$value);
    					 $pais = count($valores) > 1 ? $this->eliminarSaltoLinea($valores[0]) : "";
    					 $publicacion['pais'] = $pais;
    					 $anual = count($valores) > 1 ? $this->eliminarSaltoLinea($valores[1]) : "";
    					 $publicacion['anual'] = $anual;
    					 foreach($valores as $valor) {
    							 if(strpos($valor,'págs')){
    						      $result = explode(':',$valor);
    						      $paginas = count($result) > 1 ? $this->eliminarSaltoLinea($result[1]) : "";
    						      $publicacion['paginas'] = $paginas;
    							 }
    							 if(strpos($valor,'vol')){
    						      $result = explode('.',$valor);
    						      $vol = count($result) > 1 ? $this->eliminarSaltoLinea($result[1]) : "";
    						      $documento['volumen'] = $vol;
    							 }
    							 if(strpos($valor,'Ed')){
    						      $result = explode('.',$valor);
    						      $editorial = count($result) > 1 ? $this->eliminarSaltoLinea($result[1]) : "";
    						      $documento['editorial'] = $editorial;
    							 }
    					 }
    				 }
    			 }
    			 $publicaciones[] = $publicacion;
    		 }
    		 return $publicaciones;
    }
}
