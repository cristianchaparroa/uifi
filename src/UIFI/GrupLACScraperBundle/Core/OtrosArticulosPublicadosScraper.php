<?php

namespace UIFI\GrupLACScraperBundle\Core;

class OtrosArticulosPublicadosScraper  extends  Scraper
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
		 $query = '/html/body/table[35]'; //pendiente
		 $array = $this->extraer( $query );
		 $articulos = array();
		 foreach($array as $item ){
			 $doc = new \DOMDocument();
			 $doc->loadHTML( $item );
			 $xpath = new \DOMXPath($doc);
			 $list = $doc->getElementsByTagName('strong');
			 $articulo = array();
       $articulo['nombreGrupo'] = $this->grupoDTO['nombre'];
       $articulo['grupo'] = $this->grupoDTO['id'];


			 foreach($list as $node ){
				 $articulo['tipo'] = $node->nodeValue;
				 $tituloNode = $node->nextSibling;
				 $titulo = $tituloNode->nodeValue;

				 $titulo = str_replace(':','',$titulo);
				 $titulo = utf8_encode ($titulo);
				 $articulo['titulo'] = $titulo;

				 $list = $doc->getElementsByTagName('br');
				 $nodesiguiente = $node->nextSibling;
				 $value = $nodesiguiente->nodeValue;
				 $valores = explode(",",$value);
				 $pais = count($valores) > 1 ? $this->eliminarSaltoLinea($valores[0]) : "";
				 $articulo['pais'] = $pais;

				 $datos = count($valores) > 1 ? explode(":",$valores[1]) : "";
				 $revista = count($datos) > 1 ? $this->eliminarSaltoLinea($datos[0]) : "";
				 $revista = str_replace('ISSN','',$revista);
				 $articulo['revista'] = $revista;

				 $datos = count($valores) > 2 ? explode(":",$valores[2]) : "";
				 $anual = count($datos) > 1 ? $this->eliminarSaltoLinea($datos[0]) : "";
				 $anual = str_replace('vol','',$anual);
				 $articulo['anual'] = $anual;

				 $volumen = count($datos) > 1 ? $this->eliminarSaltoLinea($datos[1]) : "";
				 $volumen = str_replace('fasc','',$volumen);
				 $articulo['volumen'] = $volumen;

				 $fasciculo = count($datos) > 2 ? $this->eliminarSaltoLinea($datos[2]) : "";
				 $fasciculo = str_replace('págs','',$fasciculo);
				 $articulo['fasciculo'] = $fasciculo;

				 $paginas = count($datos) > 3 ? $this->eliminarSaltoLinea($datos[3]) : "";
				 $articulo['paginas'] = $paginas;
			 }
			 $articulos[] = $articulo;
		 }
		 return $articulos;
		}

}
