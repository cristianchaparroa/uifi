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
class ProyectosDirigidosScraper extends  Scraper
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
		 * Obtiene la lista de proyectos de un grupo de investigacion.
		 *
		 * @return
		 *			$proyecto['titulo']
		 *			$proyecto['tipo']
		 *			$proyecto['autores']
		 *			$proyecto['tipoOrientacion']
		 *			$proyecto['nombreEstudiante']
		 *			$proyecto['proyectoAcademico']
		 *			$proyecto['numeroPaginas']
		 *			$proyecto['valoracion']
		 *			$proyecto['institucion']
		 * 			$proyecto['mesInicial']
		 * 			$proyecto['anualInicial']
		 * 			$proyecto['mesFinal']
		 * 			$proyecto['anualFinal']
		 */
		public function getProyectosDirigidos() {
			$query = '/html/body/table[49]';
			$array = $this->extraer( $query );
			$proyectos = array();

			foreach($array as $item ){
				$doc = new \DOMDocument();
				$doc->loadHTML( $item );
				$xpath = new \DOMXPath($doc);
				$list = $doc->getElementsByTagName('strong');

				$proyecto = array();
				foreach($list as $node ){
					$proyecto['nombreGrupo'] = $this->grupoDTO['nombre'];
					$proyecto['grupo'] = $this->grupoDTO['id'];
					$proyecto['tipo'] = $node->nodeValue;
					$tituloNode = $node->nextSibling;
					$titulo = $tituloNode->nodeValue;
					$titulo = str_replace(':','',$titulo);
					$proyecto['titulo'] = utf8_encode ($titulo);
					$list = $doc->getElementsByTagName('br');

					foreach($list as $node){
						$nodesiguiente = $node->nextSibling;
						$value = $nodesiguiente->nodeValue;
						$valores = explode(",",$value);


						foreach($valores as $valor)
						{
							if( strpos($valor, 'hasta') ){
								$result = explode('hasta',$valor);

								$fechaInicial =  $result[0];
								$fechaInicial = explode(' ',$fechaInicial );
								$fechaInicial = $this->elimiarElementosVacios($fechaInicial);
								$mesInicial = 	count($fechaInicial)>1 ? $fechaInicial[1]:"";
								$anualInicial = count($fechaInicial)>1 ? $fechaInicial[2]:"";

								$fechaFinal  = count($result)>1 ? $result[1] : "";
								$fechaFinal = explode(' ', $fechaFinal);
								$fechaFinal = $this->elimiarElementosVacios($fechaFinal);

								$mesFinal = empty($fechaFinal) ? "" : $fechaFinal[0];
								$anualFinal = count($fechaFinal)>1 ?  $fechaFinal[1]:"";

								$proyecto['mesInicial']   = $this->eliminarSaltoLinea($mesInicial);
								$proyecto['anualInicial'] = $this->eliminarSaltoLinea($anualFinal);
								$proyecto['mesFinal'] 		= $this->eliminarSaltoLinea($mesFinal);
								$proyecto['anualFinal'] 	= $this->eliminarSaltoLinea($anualFinal);
							}
							if( strpos($valor,'Tipo de orientación') ){
								$tipoOrientacion = explode(':',$valor);
								$tipoOrientacion = ( count($tipoOrientacion)>1 ? $tipoOrientacion[1] :"");
								$tipoOrientacion = $this->eliminarSaltoLinea($tipoOrientacion);
								$proyecto['tipoOrientacion'] = $tipoOrientacion;
							}
							if( strpos($valor,'Nombre del estudiante') ){
								$nombreEstudiante = explode(':',$valor);
								$nombreEstudiante = ( count($nombreEstudiante)>1 ? $nombreEstudiante[1] :"");
								$nombreEstudiante = $this->eliminarSaltoLinea($nombreEstudiante);
								$proyecto['nombreEstudiante'] = $nombreEstudiante;
							}
							if( strpos($valor,'Programa académico') ){
								$proyectoAcademico = explode( ':',$valor );
								$proyectoAcademico = ( count($proyectoAcademico)>1 ? $proyectoAcademico[1]:"" );
								$proyectoAcademico = $this->eliminarSaltoLinea($proyectoAcademico);
								$proyecto['proyectoAcademico'] = $proyectoAcademico;
							}

							if( strpos($valor,'Número de páginas')  ){
								$numeroPaginas = explode( ':',$valor);
								$numeroPaginas = ( count($numeroPaginas)>1 ? $numeroPaginas[1] : "");
								$numeroPaginas = $this->eliminarSaltoLinea($numeroPaginas);
								$proyecto['numeroPaginas'] = $numeroPaginas;
							}
							if( strpos($valor,'Valoración:')  ){
								$valoracion = explode( ":",$valor);
								$valoracion = (  count($valoracion)>1 ? $valoracion[1]: ""  );
								$valoracion = $this->eliminarSaltoLinea($valoracion);
								$proyecto['valoracion'] = $valoracion;
							}
							if( strpos($valor,'Institución')  ){
								$institucion = explode( ':',$valor );
								$institucion = (  count($institucion)>1 ? $institucion[1]:""  );
								$institucion = $this->eliminarSaltoLinea( $institucion );
								$proyecto['institucion'] = $institucion;
							}
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
					$proyecto['autores'] = $autores;
				}
				$proyectos[] = $proyecto;
			}
			return $proyectos;
		}
}
