<?php

namespace UIFI\GrupLACScraperBundle\Core;

class OtrosArticulosPublicadosScraper  extends  Scraper
{
    const URL_BASE='http://scienti.colciencias.gov.co:8080/gruplac/jsp/visualiza/visualizagr.jsp?nro=';
     /**
      * Constructor del objeto
      */
    public function __construct($grupoDTO) {
         Scraper::__construct( self::URL_BASE . $grupoDTO['id'] );
         $this->grupoDTO = $grupoDTO;
    }
    /**
		* Obtienen los otros articulos publicados
		* @return Arreglo de arreglos
		* 		$articulo['titulo'] el titulo del articulo
		* 		$articulo['issn'] el issn del articulo
		* 		$articulo['anual'] el año del articulo
		* 		$articulo['tipo'] el tipo del articulo
		* 		$articulo['revista'] revista del articulo
		* 		$articulo['volumen'] el volumen del articulo
		* 		$articulo['fasciculo'] el fasciculo del articulo
		* 		$articulo['paginas'] páginas del articulo
		* 		$articulo['pais'] el país del articulo
		*/
    public function getOtrosArticulosPublicados(){
		 $query = '/html/body/table[13]'; //pendiente
		 $array = $this->extraer( $query );
		 $articulos = array();
		 foreach($array as $item ){
			 $doc = new \DOMDocument();
			 $doc->loadHTML( $item );
			 $xpath = new \DOMXPath($doc);
			 $list = $doc->getElementsByTagName('strong');
			 $articulo = array();
			 foreach($list as $node ){
				 $articulo['tipo'] = $node->nodeValue;
				 $tituloNode = $node->nextSibling;
				 $titulo = $tituloNode->nodeValue;
				 $titulo = str_replace(':','',$titulo);
				 $titulo = utf8_encode ($titulo);
				 $articulo['titulo'] = $titulo;
         $articulo ['nombreGrupo'] = $this->grupoDTO['nombre'];
         $articulo ['grupo'] = $this->grupoDTO['id'];

				 $list = $doc->getElementsByTagName('br');
				 $nodesiguiente = $node->nextSibling;
				 foreach($list as $node){
  					$nodesiguiente = $node->nextSibling;
  					$value = $nodesiguiente->nodeValue;
  					$valores = explode(",",$value);
  					if(strpos($value,'Autores')){
  						      $result = explode(':',$value);
  						      $autores = count($result) > 1 ? $this->eliminarSaltoLinea($result[1]) : "";
  						      $articulo['autores'] = $autores;
  					}else{
  						$pais = count($valores) > 1 ? $this->eliminarSaltoLinea($valores[0]) : "";
  						$articulo['pais'] = $pais;
  						$anual = count($valores) > 1 ? $this->eliminarSaltoLinea($valores[1]) : "";
  						$articulo['anual'] = $anual;
  					}
  					foreach($valores as $valor) {
    						if(strpos($valor,'ISSN:')){
    						      $result = explode('ISSN:',$valor);
                      $revista = count($result) > 1 ? $result[0] : "";
                      $articulo['revista'] = $revista;
    						      $issn = count($result) > 1 ? $this->eliminarSaltoLinea($result[1]) : "";
    						      $articulo['issn'] = $issn;
    						 }
    						 //2006 vol: fasc:  págs:  -
    						if(strpos($valor,'vol')){
    						      $result = explode('vol:',$valor);
    						      $anual = count($result) > 1 ? $this->eliminarSaltoLinea($result[0]) : "";
    						      $articulo['anual'] = $anual;
    						}
    						if(strpos($valor,'págs')){
    						      $result = explode('págs:',$valor);
    						      $paginas = count($result) > 1 ? $this->eliminarSaltoLinea($result[1]) : "";
    						      $articulo['paginas'] = $paginas;
    						}
    						$vals = explode(":",$valor);
    						foreach($vals as $val) {
    							if(strpos($valor,'fasc')){
    							      $result = explode('fasc',$valor);
    							      $volumen = count($result) > 1 ? $this->eliminarSaltoLinea($result[0]) : "";
    							      $articulo['volumen'] = $volumen;
    							}
    							if(strpos($valor,'págs')){
    							      $result = explode('págs',$valor);
    							      $fasciculo = count($result) > 1 ? $this->eliminarSaltoLinea($result[0]) : "";
    							      $articulo['fasciculo'] = $fasciculo;
    							}
    						}
  					}
				 }
			 }
			 $articulos[] = $articulo;
		 }
		 return $articulos;
		}

}
