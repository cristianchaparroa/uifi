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
class EventosScraper extends  Scraper
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
		 * Obtienen los eventos a los que asiste el grupo de investigación,
		 * @return Arreglo de arreglos
		 * 		$evento['facultad'] facultad del evento
		 * 		$evento['tipo']   tipo de evento
		 * 		$evento['titulo']  nombre del evento
		 * 		$evento['ciudad']  ciudad en que se realiza el evento
		 * 		$evento['deste']  fecha de inicio del evento
		 * 		$evento['hasta']  fecha de finalización del evento
		 * 		$evento['ambito']  ambito del evento
		 * 		$evento['participacion']  participación del evento
		 * 		$evento['institucion']  institución del evento
		*/
		public function getEventos(){
			$query = '/html/body/table[35]';
			$array = $this->extraer( $query );
			$eventos = array();

			foreach($array as $item ){
				$doc = new \DOMDocument();
				$doc->loadHTML( $item );
				$xpath = new \DOMXPath($doc);
				$list = $doc->getElementsByTagName('strong');

				$evento = array();
				foreach($list as $node ){
					$evento['nombreGrupo'] = $this->grupoDTO['nombre'];
					$evento['grupo'] = $this->grupoDTO['id'];
					$evento['tipo'] = $node->nodeValue;
					$tituloNode = $node->nextSibling;
					$titulo = $tituloNode->nodeValue;

					$titulo = str_replace(':','',$titulo);
					$titulo = utf8_encode ($titulo);
					$evento['titulo'] = $titulo;
					$list = $doc->getElementsByTagName('br');

					foreach($list as $node){
						$nodesiguiente = $node->nextSibling;
						$value = $nodesiguiente->nodeValue;
						$valores = explode(",",$value);
						$ciudad = count($valores) > 1 ? $this->eliminarSaltoLinea($valores[0]) : "";
						$evento['ciudad'] = $ciudad;
						foreach($valores as $valor) {
							if(strpos($valor, 'hasta')){
								$result = explode('hasta', $valor);
								$fechaInicial = $result[0];
								$fechaInicial = explode('desde',$fechaInicial);
								$desde = count($fechaInicial)>1 ? $this->eliminarSaltoLinea($fechaInicial[1]):"";
								$desde = str_replace(' ','', $desde );
								$desde = substr( $desde,0,-1);
								$evento['desde'] =  $desde;
								$fechaFinal = count($result)>1 ? $result[1] : "";
								$fechaFinal = $this->eliminarSaltoLinea($fechaFinal);
								$fechaFinal = explode('Ámbito:',$fechaFinal);
								$hasta = count($fechaFinal) > 1 ? str_replace(' ','',$fechaFinal[0]) : "";
								$evento['hasta'] = $hasta;
							}
							if(strpos($valor,'Ámbito')){
								$ambito = explode(':', $valor);
								$ambito = count($ambito)>1 ? $ambito[1] : "";
								$ambito = $this->eliminarSaltoLinea($ambito);
								$evento['ambito'] = $ambito;
							}
							if(strpos($valor,'Tipos de participación')){
								$tipoParticipacion = explode(':', $valor);
								$tipoParticipacion = count($tipoParticipacion)>1 ? $tipoParticipacion[1] : "";
								$tipoParticipacion = $this->eliminarSaltoLinea($tipoParticipacion);
								$evento['participacion'] = $tipoParticipacion;
							}
							if(strpos($valor,'Institución')){
								$institucion = explode(':', $valor);
								$institucion = count($institucion)>1 ? $institucion[1] : "";
								$institucion = $this->eliminarSaltoLinea($institucion);
								$evento['institucion'] = $institucion;
							}
							if(strpos($valor,'Institución')){
								$institucion = explode(':', $valor);
								$institucion = count($institucion)>1 ? $institucion[1] : "";
								$institucion = $this->eliminarSaltoLinea($institucion);
								$evento['institucion'] = $institucion;
							}
						}
					}
				}
				$eventos[] = $evento;
			}
			return $eventos;
		}
}
