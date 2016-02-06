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
class SoftwareScraper extends  Scraper
{
		const URL_BASE='http://scienti.colciencias.gov.co:8080/gruplac/jsp/visualiza/visualizagr.jsp?nro=';
	  /**
	    * Constructor del objeto
	    */
	  public function __construct($grupoDTO,$logger) {
       Scraper::__construct( self::URL_BASE . $grupoDTO['id'] );
			 $this->grupoDTO = $grupoDTO;
			 $this->logger = $logger;
	  }

		/**
		 * Obtiene un arreglo de arreglos de software del grupo
		 * de investigacion.
		 *
		 * return
		 * 		$programa['pais']
		 *		$programa['anual']
		 * 		$programa['disponibilidad']
		 *		$programa['sitioWeb']
		 *		$programa['tipo']
		 *		$programa['nombreComercial']
		 *		$programa['nombreProyecto']
		 *		$programa['institucionFinanciera']
		 *		$programa['autores'] arreglo de string
		*/
		public function getSoftware() {
			$query = '/html/body/table[31]';
			$array = $this->extraer( $query );
			$programas = array();
			foreach( $array as $item ){
				$doc = new \DOMDocument();
				$doc->loadHTML( $item );
				$xpath = new \DOMXPath($doc);

				$programa = array();
				$programa['nombreGrupo'] = $this->grupoDTO['nombre'];
				$programa['grupo'] = $this->grupoDTO['id'];
				//obtengo el tipo de programa.
				$list = $doc->getElementsByTagName('strong');
				foreach($list as $node ){
					$programa['tipo'] = $node->nodeValue;
					//obtengo el nombre
					$tituloNode = $node->nextSibling;
					$titulo = $tituloNode->nodeValue;
					$titulo = str_replace(':','',$titulo);
					$programa['titulo'] = $titulo;
				}

				$list = $doc->getElementsByTagName('br');
				foreach($list as $node) {
					$nodesiguiente = $node->nextSibling;
					$value = $nodesiguiente->nodeValue;


					if( strpos($value ,'Disponibilidad')) {
						$paisResult = explode('Disponibilidad',$value);
						$paisResult = count($paisResult) > 0 ? $paisResult[0] : "" ;
						$paisResult = explode(',',$paisResult);
						$pais = count($paisResult) > 0  ? $this->eliminarSaltoLinea($paisResult[0]) : "";
						$programa['pais']  = $pais;
					}

					$valores = explode(",",$value);
					foreach($valores as $valor) {
						if(is_numeric($valor) ){
							$programa['anual'] = $valor;
						}

						if( strpos($valor,'Disponibilidad')){
								$disponibilidad = explode(':', $valor);
								$disponibilidad = ( count($disponibilidad) >1 ? $disponibilidad[1]:1);
								$disponibilidad = $this->eliminarSaltoLinea($disponibilidad);
								$programa['disponibilidad'] = $disponibilidad;
						}
						if( strpos($valor,'Sitio web') ){
								$sitioWeb = explode(':',$valor );
								$sitioWeb = ( count($sitioWeb)>1 ?  $sitioWeb[1] : "" );
								$programa['sitioWeb'] =$sitioWeb;
						}
						if( strpos($valor,'Nombre comercial') ){
								$nombreComercial = explode( ':', $valor );
								$nombreComercial = ( count($nombreComercial)>1 ? $nombreComercial[1] : "" );
								$nombreComercial = $this->eliminarSaltoLinea($nombreComercial);
								$programa['nombreComercial'] = $nombreComercial;
						}

						if( strpos($valor,'Nombre del proyecto') ){
							 	$nombreProyecto = explode(':',$valor);
								$nombreProyecto = ( count($nombreProyecto)>1 ? $nombreProyecto[1] : "");
								$nombreProyecto = $this->eliminarSaltoLinea($nombreProyecto);
								$programa['nombreProyecto'] = $nombreProyecto;

						}
						if( strpos($valor,'Institución financiadora') ){
								$institucionFinanciera = explode(':',$valor);
								$institucionFinanciera = (  count($institucionFinanciera)>1 ?  $institucionFinanciera[1]:"" );
								$institucionFinanciera = $this->eliminarSaltoLinea($institucionFinanciera);
								$programa['institucionFinanciera'] = $institucionFinanciera;
						}
					}
				}
				//obtengo los autores
				$list = $doc->getElementsByTagName('br');
				foreach($list as $node){
					$nodesiguiente = $node->nextSibling;
					$value = $nodesiguiente->nodeValue;
					$result = explode(':',$value);
					$result = $result[1];
					$result =  trim(preg_replace('/\s\s+/', ' ', $result));
					$autores = explode(',',$result);
					$autores = array_filter( $autores );
					$programa['autores'] = $autores;
				}
				$programas[] = $programa;
			}
			return $programas;
		}
}
