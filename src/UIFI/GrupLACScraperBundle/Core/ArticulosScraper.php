<?php

namespace UIFI\GrupLACScraperBundle\Core;
/**
  * @file
  *
  * Clase encargada de extraer toda la información respecto a
  * la página  de un grupo de investiación.
  *
  * @author: Cristian Camilo Chaparro A.
  */
class ArticulosScraper extends  Scraper
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
		 		*  Obtiene los artículos publicados en el grupo de Investigación
		 		*  @return Arreglo con la siguiente información
		 		* 			articulo['titulo'] , título de articulo
		 		* 			articulo['anual']  , año en el que fue publicado el artículo
		 		* 			articulo['autores'], arreglo con los nombres de los autores
		 		* 			articulo['issn'], arreglo con los nombres de los autores
		 		*/
		 public function getArticulos() {
		 			$query = '/html/body/table[8]';
		 			$array = $this->extraer( $query );
		 			$items = array();
		 			$articulos = array();

		 			foreach( $array as $item ) {
		 				$articulo = array();
						$articulo['nombreGrupo'] = $this->grupoDTO['nombre'];
						$articulo['grupo'] = $this->grupoDTO['id'];
		 				$doc = new \DOMDocument();
		 				$doc->loadHTML( $item );
		 				$xpath = new \DOMXPath($doc);
		 				$list = $doc->getElementsByTagName('strong');

		 				//Obtengo el titulo del artículo
		 				foreach($list as $node ){
		 					$tipo = $node->nodeValue;
		 					$tipo = str_replace( '"','',$tipo);
		 					$tipo = str_replace( '\\','',$tipo);
		 					$tipo = str_replace( ':','',$tipo);
		 					$articulo['tipo'] = $tipo;
		 					$tituloNode = $node->nextSibling;
		 					$articulo['titulo'] = $tituloNode->nodeValue;
		 				}

		 				//obtengo los autores del artículo
		 				$list = $doc->getElementsByTagName('br');
		 				$autores = array();
		 				foreach( $list as $node ){
		 					$nodesiguiente = $node->nextSibling;
		 					if( strpos($nodesiguiente->nodeValue, 'Autores') ){
		 						$result = $nodesiguiente->nodeValue;
		 						$results = explode( ':',$result);
		 						$results = $results[1];
		 						$results = str_replace( '\n','',$results);
		 						$autores = explode(',',$results);
		 					}
		 					//se obtiene el año en  el que se publico el artículo
		 					if( strpos($nodesiguiente->nodeValue,'ISSN') ){
		 						$result = $nodesiguiente->nodeValue;
		 						$resultPais = explode(',',$result);
		 						$pais = count($resultPais)>1 ? ($this->eliminarSaltoLinea($resultPais[0])) : "";
		 						$articulo['pais'] = $pais;

		 						if (count($resultPais)>2) {
		 							$revista = $resultPais[1];
		 							$revista = explode('ISSN',$revista);
		 							$revista = count($revista)>1 ? $revista[0] : "";
		 							$articulo['revista'] = $revista;
		 						}

		 						$results = explode( 'vol',$result );
		 						$resultsVolumen =  $results[1];
		 						$resultsVolumen = explode('fasc',$resultsVolumen);
		 						if (count($resultsVolumen)>1) {
		 							$resultsPag = explode('págs',$resultsVolumen[1]);
		 							$fasc =  count($resultsPag)>1 ? str_replace(':','',$resultsPag[0]) : "";
		 							$articulo ['fasc'] = str_replace(' ','',$fasc);
		 							$paginas = count($resultsPag)==2 ? $this->eliminarSaltoLinea(str_replace(':','',$resultsPag[1])) : "";
		 							$articulo['paginas'] = $paginas;
		 						}

		 						$volumen = count($resultsVolumen)>1 ? ($this->eliminarSaltoLinea($resultsVolumen[0])) : "";
		 						$volumen = str_replace(':','',$volumen);
		 						$articulo['volumen'] = $volumen;

		 						$results = $results[0];
		 						$results = explode( ',', $result );
		 						$resultsISSN = $results[1];
		 						$resultsISSN = explode( ':', $resultsISSN);
		 						$resultsISSN =  count($resultsISSN) > 1  ? $resultsISSN[1] : "";
		 						$resultsISSN = str_replace(' ', '',$resultsISSN);
		 						$articulo['issn'] = $resultsISSN;
		 						$results = $results[ count($results)-1 ];
		 						$results =explode(' ',$results );
		 						$anual  = $results[1];
		 						$articulo['anual'] = $anual;
		 					}
		 				}
		 				array_pop($autores);
		 				$autores = array_unique($autores);
		 				$articulo['autores']  = $autores;
		 				$articulos[] = $articulo;
		 			}

		 			return $articulos;
		 }
}
