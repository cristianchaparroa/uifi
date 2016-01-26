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
class IntegrantesScraper extends  Scraper
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
		* Obtener todos los  nombres de los integrantes en
		* el grupo de investigación.
		* @return Arreglo clave valor
		*		{url cvlac, array( nombre del integrante, vinculacion:rango de fecha)}
		*/
		public function obtenerIntegrantes()
		{
			//query que extraer la tabla con los integrantes del grupo
			$query = '/html/body/table[6]';
			$resultados = $this->xpath->query( $query );
			$integrantes = Array();
			foreach( $resultados as  $registro ){
				$nodeList = $registro->childNodes ;
				foreach(  $nodeList as $node )
				{
						$cells = $node->getElementsByTagName('td');
						$fecha  = $cells->item($cells->length-1);
						$vinculacion = $fecha->nodeValue;
						$element =  $node->firstChild ;
						$listLinks =  $element->getElementsByTagName('a');

						foreach( $listLinks as $link ) {
							$array = explode('=', $link->getAttribute('href') );
							$urlCVLAC = $array[1];
							$nombre = $link->nodeValue;

							$integrantes[] =  array(
									'codigoIntegrante' 	=> $urlCVLAC,
									'nombre'						=> $nombre,
									'vinculacion'  			=> $vinculacion ,
									'nombreGrupo'	 			=> $this->grupoDTO['nombre'] ,
									'grupo'							=> $this->grupoDTO
							);
						}
				}
			}
			return $integrantes;
		}
}
