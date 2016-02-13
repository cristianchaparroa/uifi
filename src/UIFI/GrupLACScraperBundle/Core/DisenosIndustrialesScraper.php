<?php

namespace UIFI\GrupLACScraperBundle\Core;

class DisenosIndustrialesScraper  extends  Scraper
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
		* Obtienen los  disenos industriales
		* @return Arreglo de arreglos
		* 		$diseno['tipo'] el tipo del diseño
		* 		$diseno['titulo'] el titulo del diseño
		* 		$diseno['pais'] el pais del diseño
		* 		$diseno['tipo'] el tipo del diseño
		* 		$diseno['anual'] el año del diseño
		* 		$diseno['disponibilidad'] la disponibilidad del diseño
		* 		$diseno['autores'] la institucion financiadora del diseño
		*/
		public function getDisenosIndustriales(){
		 $query = '/html/body/table[19]';
		 $array = $this->extraer( $query );
		 $disenos = array();
		 foreach($array as $item ){
			 $doc = new \DOMDocument();
			 $doc->loadHTML( $item );
			 $xpath = new \DOMXPath($doc);
			 $list = $doc->getElementsByTagName('strong');
			 $diseno = array();
       $diseno['nombreGrupo'] = $this->grupoDTO['nombre'];
       $diseno['grupo'] = $this->grupoDTO['id'];
			 foreach($list as $node ){
				 $diseno ['tipo'] = $node->nodeValue;

				 $tituloNode = $node->nextSibling;
				 $titulo = $tituloNode->nodeValue;
				 $titulo = str_replace(':','',$titulo);
				 $titulo = utf8_encode ($titulo);
				 $diseno ['titulo'] = $titulo;

				 $list = $doc->getElementsByTagName('br');
				 $nodesiguiente = $node->nextSibling;
				 $value = $nodesiguiente->nodeValue;
				 $valores = explode(",",$value);
				 $pais = count($valores) > 1 ? $this->eliminarSaltoLinea($valores[0]) : "";
				 $diseno['pais'] = $pais;

				 $anual = count($valores) > 1 ? $this->eliminarSaltoLinea($valores[1]) : "";
				 $diseno['anual'] = $anual;

				 $datos = count($valores) > 2 ? explode(":",$valores[2]) : "";
				 $disponibilidad = count($datos) > 1 ? $this->eliminarSaltoLinea($datos[1]) : "";
				 $diseno['disponibilidad'] = $disponibilidad;
			 }
			 $disenos[] = $diseno;
		 }
		 return $disenos;
		}

}
