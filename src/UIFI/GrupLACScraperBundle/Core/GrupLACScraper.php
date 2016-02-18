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
class GrupLACScraper extends  Scraper
{
		const URL_BASE='http://scienti.colciencias.gov.co:8080/gruplac/jsp/visualiza/visualizagr.jsp?nro=';
	  /**
	    * Constructor del objeto
	    */
	  public function __construct( $url )
	  {
       Scraper::__construct( self::URL_BASE . $url );
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

						foreach( $listLinks as $link ){
							$array = explode('=', $link->getAttribute('href') );
							$urlCVLAC = $array[1];
							$nombre = $link->nodeValue;
							$integrantes[ $urlCVLAC ] = array( 'nombre' => $nombre, 'vinculacion' =>$vinculacion  );
						}
				}
			}
			return $integrantes;
		}
		/**
		* Método que se encarga de extraer un valor a partir de un query
		* especifico.
		* @return valor
		*/
		public function extraerValue($query){
				$listaNodos = $this->xpath->query( $query );
				foreach( $listaNodos as $nodo ){
					$value =  $nodo->nodeValue;
				}
				return isset( $value) ? $value : "";
		}
		/**
			*Función para extrer información de un query.
			*@param Arreglo con el resultado del query.
			*/
		private function extraer($query){
			$producciones = array();
			$listaNodos = $this->xpath->query( $query );
			foreach( $listaNodos as $element ){
					$elemento =  $element->getElementsByTagName( 'td' );
					foreach ( $elemento as $node ){
						$doc = new \DOMDocument();
						$doc->appendChild($doc->importNode($node, true));
						$produccion =  $doc->saveHTML() ;
						$producciones[ ] = $produccion;
					}
			}
			$temp = array();
			foreach( $producciones as $produccion ){
				$arreglo = explode( '-', $produccion);
					if( isset( $arreglo[1] ) ){
							$produccion = '';
							for( $var =1 ; $var<count($arreglo); $var++ )
							{
									$produccion  = $produccion .'-'.$arreglo[$var];
							}

							$temp [] =  substr($produccion,1) ;
					}
			}
			return $temp;
		}
		/**
		*  Obtiene los artículos publicados en el grupo de Investigación
		*  @return Arreglo con la siguiente información
		* 			articulo['titulo'] , título de articulo
		* 			articulo['anual']  , año en el que fue publicado el artículo
		* 			articulo['autores'], arreglo con los nombres de los autores
		* 			articulo['issn'], arreglo con los nombres de los autores
		*/
		public function getArticulos()
		{
			$query = '/html/body/table[8]';
			$array = $this->extraer( $query );
			$items = array();
			$articulos = array();

			foreach( $array as $item )
			{
				$articulo = array();
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
		/**
     * Extrae la lista de capítulos publicados en libros por integrantes
     * del grupo de investigación.
     * @return Arreglo con la lista de capitulos publicados
    */
    public function capitulosLibrosPublicados(){
      $query = '/html/body/table[10]';
      return $this->extraer( $query );
    }
		/**
		 * Función que se encarga de extraer los capítulos de libros publicados
		 * por los integrantes del grupo de investigación
		 *
		 * @return arreglo de arreglos con los capitulos así
		 *  $capitulo['titulo']
		 *  $capitulo['autores']
		 *  $capitulo['pais']
  	 *  $capitulo['anual']
		 *  $capitulo['isbn']
		 *  $capitulo['editorial']
		*/
		public function getCapitulosLibros(){
			$query = '/html/body/table[10]';

			$array=  $this->extraer( $query );
			$capitulos = array();

			foreach( 	$array as $item ){
					$capitulo = array();

					$doc = new \DOMDocument();
					$doc->loadHTML( $item );
					$xpath = new \DOMXPath($doc);
					$list = $doc->getElementsByTagName('strong');

					//Obtengo el titulo del capitulo
					foreach($list as $node ){
						$tipo = $node->nodeValue;
						$capitulo['tipo'] = $tipo;
						$tituloNode = $node->nextSibling;
						$titulo = $tituloNode->nodeValue;
						$titulo = str_replace( ':','',$titulo);
						$capitulo['titulo'] = $titulo;
					}

					$list = $doc->getElementsByTagName('br');
					$autores = array();
					foreach( $list as $node ){
						$nodesiguiente = $node->nextSibling;
						//se obtienen los autores que publicaron el capitulo de libro
						if( strpos($nodesiguiente->nodeValue, 'Autores') ){
							$result = $nodesiguiente->nodeValue;
							$results = explode( ':',$result);
							$results = $results[1];
							$results = str_replace( '\n','',$results);
							$autores = explode(',',$results);
						}
						$text =  $nodesiguiente->nodeValue;
						$resultados = explode( ',',$text	);
						//se obtiene el paise de publicacion
						if( !strpos($text,'Autores') ){
							$pais = $resultados[0];
							$capitulo['pais']  = $this->eliminarSaltoLinea($pais);
						}
						//se obtiene el año de publicacion
						if( is_numeric($resultados[1]) ){
							$capitulo['anual'] = $resultados[1];
						}
						if( count($resultados)>=5){
							$resultsVolumen = $resultados[4];
							$resultsVolumen = explode('Vol.',$resultsVolumen );
							$volumen = count($resultsVolumen)>=2 ? $this->eliminarSaltoLinea(str_replace(' ','',$resultsVolumen[1])) : "";
							$capitulo['volumen'] = $volumen;
						}
						if( count($resultados)>=6){
							$resultsPaginas = $resultados[5];
							$resultsPaginas = explode('págs:',$resultsPaginas  );
							$paginas = count($resultsPaginas)>1  ? $resultsPaginas[1] : "";
							$capitulo['paginas'] = $paginas;
						}
						if( count($resultados)>2  && isset($resultados[3]) ){
							$isbn = $resultados[3];

							if( strpos($isbn,'ISBN') ){
								$isbnr = explode(':',$isbn);
								$isbn = count($isbnr) >= 2 ?  $isbnr[1] : "";
								$capitulo['isbn'] = $isbn;
							}
						}
						if( count($resultados)>6) {
							$editorialResult = $resultados[6];
							$editorialResult = explode('Ed.', $editorialResult);
							$editorial = 	count($editorialResult) >=2 ? $this->eliminarSaltoLinea($editorialResult[1]) : "";
							$capitulo['editorial'] = 	$editorial;
						}
						if ( count($resultados)>3) {
							$libro = $resultados[2];
							$capitulo['libro'] = $this->eliminarSaltoLinea($libro);
						}

				  }
					array_pop($autores );
					$autores  = array_unique($autores );
					$capitulo['autores']  = $autores;
					$capitulos[] = $capitulo;
			}
			return $capitulos;
		}
		/**
     * Extrae la lista de libros publicados por el grupo
     * de investigación.
     * @return Arreglo de libros publicados
    */
    public function librosPublicados(){
      $query = '/html/body/table[8]';
      return $this->extraer( $query );
    }
		/**
		 * Obtienen los libros publicados pro el grupo de investigación,
		 * @return Arreglo de arreglos
		 * 		$libro['titulo'] tītulo del libro
		 * 		$libro['ISBN']   ISBN del libro
		 * 		$libro['pais']   pais en el que se publico el libro
		 * 		$libro['anual']  año en el que se publico el libro
		*/
		public function getLibros(){
			$query = '/html/body/table[9]';
			$array =  $this->extraer( $query );
			$libros  = array();
			foreach( $array as $item )
			{
					$doc = new \DOMDocument();
					$doc->loadHTML( $item );
					$xpath = new \DOMXPath($doc);
					$list = $doc->getElementsByTagName('strong');

					$libro = array();
					foreach($list as $node ){
						$tipo =  $node->nodeValue;
						$libro['tipo'] = $tipo;
						$tituloNode = $node->nextSibling;
						$libro['titulo'] = $tituloNode->nodeValue;
					}
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
							if( strpos($nodesiguiente->nodeValue, 'ISBN') ){
								$result = $nodesiguiente->nodeValue;
								$resultsVolumen = explode('vol:',$result);

								if(count($resultsVolumen )>=2){
									$resultsVolumen = explode('págs:',$resultsVolumen[1]);
									$volumen =  count(	$resultsVolumen )>1 ? $this->eliminarSaltoLinea( str_replace(' ','',$resultsVolumen[0]) ) : "";
									$libro['volumen'] = $volumen;
									$resultsPaginas = $resultsVolumen[1];
									$resultsEditorial = explode('Ed.',$resultsPaginas);
									$editorial = count($resultsEditorial)>=2 ? $this->eliminarSaltoLinea($resultsEditorial[1]) :  "";
								  $libro['editorial'] = $editorial;
									$resultsPaginas = explode(',',	$resultsPaginas);
									$paginas = count($resultsPaginas) > 1 ?  str_replace(' ','',$resultsPaginas[0]) : "";
									$libro['paginas'] = $paginas;
								}

								$results = explode(':',$result);
								$isbn = $results[1];
								$results = explode( ' ',$isbn);
								$isbn = $results[1];
								$libro['ISBN'] = $isbn;
							}
							if( strpos($nodesiguiente->nodeValue, 'ISBN') ){
								$result = $nodesiguiente->nodeValue;
								$results = explode(',',$result);
								$libro[ 'pais']  =  count($results)> 1 ? $this->eliminarSaltoLinea(str_replace(' ','',$results[0])) : "";
								$libro[ 'anual' ] = count($results)>=2 ? $results[1] : "";
							}
					}
					array_pop($autores);
					$autores = array_unique($autores);
					$libro['autores']  = $autores;
					$libros[] = $libro;
			}
			return $libros;
		}
		/**
		 * Software desarrollado a partir de la producción Investigativa en
		 * en el grupo.
		 * @return Arreglo con la producción de software.
		*/
		public function obtenerSoftwares(){
			$query = '/html/body/table[16]';
			return $this->extraer( $query );
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
		public function getSoftware(){
			$query = '/html/body/table[31]';
			$array = $this->extraer( $query );
			$programas = array();
			foreach( $array as $item ){
				$doc = new \DOMDocument();
				$doc->loadHTML( $item );
				$xpath = new \DOMXPath($doc);

				$programa = array();

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
				foreach($list as $node){
					$nodesiguiente = $node->nextSibling;
					$value = $nodesiguiente->nodeValue;
					$valores = explode(",",$value);
					if(count($valores)>3){
						$programa['pais'] = $this->eliminarSaltoLinea($valores[0]);
					}
					foreach($valores as $valor)
					{
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
		 */
		public function getProyectosDirigidos(){
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

    /**
     * Método que extrae la fecha(año y mes) de formación del
     * grupo de investigación.
     * @return fecha
    */
    public function extraerFechaFormacion(){
      $query = '/html/body/table[1]/tr[2]/td[2]';
      return $this->extraerValue($query);
    }
    /**
     * Método que extrae el departamento y ciudad en donde
     * funciona el grupo de investigación.
     * @return String con el departamento ciudad
    */
    public function departamentoCidudad(){
      $query = '/html/body/table[1]/tr[3]/td[2]';
      return $this->extraerValue($query);
    }
    /**
     *Método que extrae el Lider del grupo de investigación.
     * @return Nombre del lider.
    */
    public function extraerLider(){
      $query = '/html/body/table[1]/tr[4]/td[2]';
      return $this->extraerValue($query);
    }
    /**
     * Obtiene una cadena  en la cuál indica si el
     * la información del grupo esta certificada y si es así
     * en que fecha.
     * @return String.
    */
    public function isInformacionCertificada(){
      $query = '/html/body/table[1]/tr[5]/td[2]';
      return $this->extraerValue($query);
    }
    /**
     * Extrae la dirección de la página web.
     * @return url de la página web.
    */
    public function paginaWeb(){
      $query = '/html/body/table[1]/tr[6]/td[2]/a';
      return $this->extraerValue($query);
    }
    /**
     * Método que se encarga de extraer el email del grupo
     * de investgiación.
     * @return email.
    */
    public function extraerEmail(){
      $query = '/html/body/table[1]/tr[7]/td[2]/a';
      return $this->extraerValue($query);
    }
    /**
     * Método que se encarga de extraer que tipo de clasificación
     * de grupo de investigación.
     * @return Tipo de clasificación.
    */
    public function extraerClasificacion(){
      $query = '/html/body/table[1]/tr[8]/td[2]';
      return $this->extraerValue($query);
    }
    /**
     * Método que extrae el area de conocimiento.
    * @return Nombre del area de conocimiento.
    */
    public function areaConocimiento(){
      $query = '/html/body/table[1]/tr[9]/td[2]';
      return $this->extraerValue($query);
    }
    /**
     * Extrae el programa Nacional de ciencias de tecnología.
     * @return Nombre del programa.
    */
    public function programaNacionalCT(){
      $query = '/html/body/table[1]/tr[10]/td[2]';
      return $this->extraerValue($query);
    }
    /**
     * Extrae el programa Nacional de ciencias de tecnología
     * secundario
     * @return Nombre del programa.
    */
    public function programaNacionaCTS(){
      $query =  '/html/body/table[1]/tr[11]/td[2]';
      return $this->extraerValue($query);
    }
    /**
     * extraer la instituciones a las cuales pertence el grupo de investigación.
     * @return Arreglo con el nombre de las instituciones.
     */
    public function obtenerInstituciones(){
      $query = '/html/body/table[2]';
      return $instituciones;
      return $this->extraer( $query );
    }
    /**
      *Extrae las lineas de investigación del grupo.
      *@return Arreglo con los nombres de las lineas de investigación.
      */
    public function lineasInvestigacion(){
      $query = '/html/body/table[3]';
      return $this->extraer( $query );
    }
    /**
     * Extraer la producción cientifica generada en el grupo
     * de investigación.
     * @return Arreglo con las producciones cientificas en el grupo.
    */
    public function obtenerProduccion()
    {
      $query = '/html/body/table[6]';
      return $this->extraer( $query );
    }
    /**
     * Extraer las memorias generadas en los diferentes memorias en los
     * que se le han otorgado el grupo de investiación.
    */
    public function obtenerMemorias(){
      $query = '/html/body/table[7]';
      return $this->extraer( $query );
    }
    /**
     * Extraer los eventos en los que ha participado el grupo de
     * investigación.
    */
    public function obtenerEventos(){
      $query = '/html/body/table[14]';
      return $this->extraer( $query );
    }
    /**
     * Extraee las redes académicas de las cual hace participe el
     * grupo de investigación.
     *@return Arreglo con las redes académicas
     */
    public function obtenerRedes(){
      $query = '/html/body/table[15]';
      return $this->extraer( $query );
    }



    /**
     * Retorna otro tipo de articulos publicados por el
     * grupo de investigación.
     * @return Arreglo con la lista de articulos publicados.
    */
    public function otrosArticulosPublicados(){
      $query='/html/body/table[10]';
      return $this->extraer( $query );
    }


		/**
		 * Obtiene el nombre del grupo de investigación.
		*  @return String Nombre del grupo
		*/
		public function getNombreGrupo(){
			$query = '/html/body/span';
			$nombre  = $this->extraerValue($query) ;
			$nombre = utf8_encode ( $nombre );
			return $nombre;
		}
		/**
		 * obtiene la url completa del gruplac del grupo de investigación.
		 * @retunr String URL
		*/
		public function getURL(){
			return   $this->urlBase;
		}



    	/**
     * Extrae la lista de eventos a los que asiste el grupo
     * de investigación.
     * @return Arreglo de eventos del grupo
    */
    public function eventos(){
      $query = '/html/body/table[35]'; //Qué es?
      return $this->extraer( $query );
    }
		/**
		 * Obtienen los eventos a los que asiste el grupo de investigación,
		 * @return Arreglo de arreglos
		 * 		$evento['facultad'] facultad del evento
		 * 		$evento['nro_id']   id del evento
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
		/*
		* Obtienen los otros productos tecnologicos de un grupo de investgiación
		* @return Arreglo de arreglos
		* 		$producto['tipo'] el tipo del producto
		* 		$producto['titulo'] el titulo del producto
		* 		$producto['pais'] pais del grupo
		* 		$producto['anual'] año del producto
		* 		$producto['disponibilidad'] disponibilidad del producto
		* 		$producto['nombre_comercial'] nombre comercial del producto
		* 		$producto['institucion_financiadora'] institucion_financiadora del producto
		*/
		public function getOtrosProductosTecnologicos(){
		 $query = '/html/body/table[35]'; //pendiente
		 $array = $this->extraer( $query );
		 $productos = array();
		 foreach($array as $item ){
			 $doc = new \DOMDocument();
			 $doc->loadHTML( $item );
			 $xpath = new \DOMXPath($doc);
			 $list = $doc->getElementsByTagName('strong');
			 $producto = array();
			 foreach($list as $node ){
				 $producto['tipo'] = $node->nodeValue;
				 $tituloNode = $node->nextSibling;
				 $titulo = $tituloNode->nodeValue;
				 $titulo = str_replace(':','',$titulo);
				 $titulo = utf8_encode ($titulo);
				 $producto['titulo'] = $titulo;
				 $list = $doc->getElementsByTagName('br');
				 foreach($list as $node){
					 $nodesiguiente = $node->nextSibling;
					 $value = $nodesiguiente->nodeValue;
					 $valores = explode(",",$value);
					 $pais = count($valores) > 1 ? $this->eliminarSaltoLinea($valores[0]) : "";
					 $producto['pais'] = $pais;
					 $anual = count($valores) > 1 ? $this->eliminarSaltoLinea($valores[1]) : "";
					 $producto['anual'] = $anual;
					 foreach($valores as $valor) {
							 if(strpos($valor,'Disponibilidad')){
						 $result = explode(':',$valor);
						 $disponibilidad = count($result) > 1 ? $this->eliminarSaltoLinea($result[1]) : "";
						 $producto['disponibilidad'] = $disponibilidad;
							 }
							 if(strpos($valor,'Nombre comercial')){
						 $result = explode(':',$valor);
						 $nombreComercial = count($result) > 1 ? $this->eliminarSaltoLinea($result[1]) : "";
						 $producto['nombre_comercial'] = $nombreComercial;
							 }
							 if(strpos($valor,'Institución financiadora')){
						 $result = explode(':',$valor);
						 $institucionFinanciadora = count($result) > 1 ? $this->eliminarSaltoLinea($result[1]) : "";
						 $producto['institucion_financiadora'] = $institucionFinanciadora;
							 }
					 }
				 }
			 }
			 $productos[] = $producto;
		 }
		 return $productos;
		}
		/**
		 *Obtienen los otros libros publicados
		 * @return Arreglo de libros publicados
		 */
		public function otrosLibrosPublicados(){
			 $query = '/html/body/table[35]'; //Qué es?
			 return $this->extraer( $query );
		}
		 /**
		* Obtienen los otros libros publicados
		* @return Arreglo de arreglos
		* 		$libro['titulo'] el titulo del libro
		* 		$libro['pais'] el país del libro
		* 		$libro['anual'] el año del libro
		* 		$libro['isbn'] el isbn del libro
		* 		$libro['tipo'] el tipo de libro
		* 		$libro['volumen'] el volumen del libro
		* 		$libro['paginas'] la cantidad de páginas del libro.
		* 		$libro['editorial'] la editorial del libro
		*/
		public function getOtrosLibrosPublicados(){
		 $query = '/html/body/table[35]'; //pendiente
		 $array = $this->extraer( $query );
		 $libros = array();
		 foreach($array as $item ){
			 $doc = new \DOMDocument();
			 $doc->loadHTML( $item );
			 $xpath = new \DOMXPath($doc);
			 $list = $doc->getElementsByTagName('strong');
			 $libro = array();
			 foreach($list as $node ){
				 $libro['tipo'] = $node->nodeValue;
				 $tituloNode = $node->nextSibling;
				 $titulo = $tituloNode->nodeValue;
				 $titulo = str_replace(':','',$titulo);
				 $titulo = utf8_encode ($titulo);
				 $libro['titulo'] = $titulo;
				 $list = $doc->getElementsByTagName('br');
				 foreach($list as $node){
					 $nodesiguiente = $node->nextSibling;
					 $value = $nodesiguiente->nodeValue;
					 $valores = explode(",",$value);
					 if(strpos($value,'Autores')){
						      $result = explode(':',$value);
						      $autores = count($result) > 1 ? $this->eliminarSaltoLinea($result[1]) : "";
						      $libro['autores'] = $autores;
					}else{
						$pais = count($valores) > 1 ? $this->eliminarSaltoLinea($valores[0]) : "";
						$libro['pais'] = $pais;
						$anual = count($valores) > 1 ? $this->eliminarSaltoLinea($valores[1]) : "";
						$libro['anual'] = $anual;
						$editorial = count($valores) > 2 ? $this->eliminarSaltoLinea($valores[3]) : "";
						$libro['editorial'] = $editorial;
					}
					 foreach($valores as $valor) {
						if(strpos($valor,'ISBN')){
						      $result = explode(':',$valor);
						      $isbn = count($result) > 1 ? $this->eliminarSaltoLinea($result[1]) : "";
						      $isbn = str_replace('vol','',$isbn);
						      $libro['isbn'] = $isbn;
						 }
						 if(strpos($valor,'vol')){
						      $result = explode(':',$valor);
						      $volumen = count($result) > 2 ? $this->eliminarSaltoLinea($result[2]) : "";
						      $volumen = str_replace('págs','',$volumen);
						      $libro['volumen'] = $volumen;
						 }
						 if(strpos($valor,'págs')){
						      $result = explode(':',$valor);
						      $paginas = count($result) > 3 ? $this->eliminarSaltoLinea($result[3]) : "";
						      $libro['volumen'] = $paginas;
						 }
					 }
				 }
			 }
			 $libros[] = $libro;
		 }
		 return $libros;
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
			 foreach($list as $node ){
				 $articulo['tipo'] = $node->nodeValue;
				 $tituloNode = $node->nextSibling;
				 $titulo = $tituloNode->nodeValue;
				 $titulo = str_replace(':','',$titulo);
				 $titulo = utf8_encode ($titulo);
				 $articulo['titulo'] = $titulo;
				 $list = $doc->getElementsByTagName('br');
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
						if(strpos($valor,'Contacto ISSN')){
						      $result = explode(':',$valor);
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
		 /**
		 *Obtienen los otros diseños industriales
		 * @return Arreglo de diseños indostriales
		 */
		 public function diseñosIndostriales(){
			 $query = '/html/body/table[35]'; //Qué es?
			 return $this->extraer( $query );
		 }
		 /**
		* Obtienen los otros articulos publicados
		* @return Arreglo de arreglos
		* 		$diseno['tipo'] el tipo del diseño
		* 		$diseno['titulo'] el titulo del diseño
		* 		$diseo['pais'] el pais del diseño
		* 		$diseno['tipo'] el tipo del diseño
		* 		$diseno['anual'] el año del diseño
		* 		$diseno['disponibilidad'] la disponibilidad del diseño
		* 		$diseno['institucion_financiadora'] la institucion financiadora del diseño
		*/
		public function getDiseñosIndustriales(){
		 $query = '/html/body/table[35]'; //pendiente
		 $array = $this->extraer( $query );
		 $disenos = array();
		 foreach($array as $item ){
			 $doc = new \DOMDocument();
			 $doc->loadHTML( $item );
			 $xpath = new \DOMXPath($doc);
			 $list = $doc->getElementsByTagName('strong');
			 $diseno = array();
			 foreach($list as $node ){
				 $diseno ['tipo'] = $node->nodeValue;
				 $tituloNode = $node->nextSibling;
				 $titulo = $tituloNode->nodeValue;
				 $titulo = str_replace(':','',$titulo);
				 $titulo = utf8_encode ($titulo);
				 $diseno ['titulo'] = $titulo;
				 $list = $doc->getElementsByTagName('br');
				 foreach($list as $node){
					 $nodesiguiente = $node->nextSibling;
					 $value = $nodesiguiente->nodeValue;
					 $valores = explode(",",$value);
					 $pais = count($valores) > 1 ? $this->eliminarSaltoLinea($valores[0]) : "";
					 $diseno['pais'] = $pais;
					 $anual = count($valores) > 1 ? $this->eliminarSaltoLinea($valores[1]) : "";
					 $diseno['anual'] = $anual;
					 foreach($valores as $valor) {
						if(strpos($valor,'Disponibilidad')){
						      $result = explode(':',$valor);
						      $disponibilidad = count($result) > 1 ? $this->eliminarSaltoLinea($result[1]) : "";
						      $diseno['disponibilidad'] = $disponibilidad;
						 }
						if(strpos($valor,'Institución financiadora')){
						      $result = explode(':',$valor);
						      $institucionFinanciadora = count($result) > 1 ? $this->eliminarSaltoLinea($result[1]) : "";
						      $diseno['institucion_financiadora'] = $institucionFinanciadora;
						}
					 }
				 }
			 }
			 $disenos[] = $diseno;
		 }
		 return $disenos;
		}
		/**
		 *Obtiene las normas y regulaciones
		 * @return Arreglo de normas y regulaciones
		 */
		 public function normasRegulaciones(){
			 $query = '/html/body/table[35]'; //Qué es?
			 return $this->extraer( $query );
		 }
		 /**
		* Obtienen las normas y regulaciones
		* @return Arreglo de arreglos
		* 		$norma['tipo'] el tipo de la norma
		* 		$norma['titulo'] el titulo de la norma
		* 		$norma['pais'] el pais de la norma
		* 		$norma['anual'] el año de la norma
		* 		$norma['ambito'] el ambito de la norma
		* 		$norma['objeto'] el objeto de la norma
		* 		$norma['institucion_financiadora'] la institucion financiadora de la norma
		*/
		public function getNormasRegulaciones(){
		 $query = '/html/body/table[35]'; //pendiente
		 $array = $this->extraer( $query );
		 $normas = array();
		 foreach($array as $item ){
			 $doc = new \DOMDocument();
			 $doc->loadHTML( $item );
			 $xpath = new \DOMXPath($doc);
			 $list = $doc->getElementsByTagName('strong');
			 $norma = array();
			 foreach($list as $node ){
				 $norma ['tipo'] = $node->nodeValue;
				 $tituloNode = $node->nextSibling;
				 $titulo = $tituloNode->nodeValue;
				 $titulo = str_replace(':','',$titulo);
				 $titulo = utf8_encode ($titulo);
				 $norma ['titulo'] = $titulo;
				 $list = $doc->getElementsByTagName('br');
				 foreach($list as $node){
					 $nodesiguiente = $node->nextSibling;
					 $value = $nodesiguiente->nodeValue;
					 $valores = explode(",",$value);
					 $pais = count($valores) > 1 ? $this->eliminarSaltoLinea($valores[0]) : "";
					 $norma['pais'] = $pais;
					 $anual = count($valores) > 1 ? $this->eliminarSaltoLinea($valores[1]) : "";
					 $norma['anual'] = $anual;
					 foreach($valores as $valor) {
							 if(strpos($valor,'Ambito')){
								$result = explode(':',$valor);
								$ambito = count($result) > 1 ? $this->eliminarSaltoLinea($result[1]) : "";
								$norma['ambito'] = $ambito;
								}
							if(strpos($valor,'Objeto')){
								$result = explode(':',$valor);
								$objeto = count($result) > 1 ? $this->eliminarSaltoLinea($result[1]) : "";
								$norma['objeto'] = $objeto;
								}
							if(strpos($valor,'Institución financiadora')){
								$result = explode(':',$valor);
								$institucionFinanciadora = count($result) > 1 ? $this->eliminarSaltoLinea($result[1]) : "";
								$norma['institucion_financiadora'] = $institucionFinanciadora;
							 }
					 }
				 }
			 }
			 $normas[] = $norma;
		 }
		 return $normas;
		}
		/**
		 *Obtiene los signos distintivos
		 * @return Arreglo de signos distintivos
		 */
		 public function signosDistintivos(){
			 $query = '/html/body/table[35]'; //Qué es?
			 return $this->extraer( $query );
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
		public function getSignosDistintivos(){
		 $query = '/html/body/table[35]'; //pendiente
		 $array = $this->extraer( $query );
		 $signos = array();
		 foreach($array as $item ){
			 $doc = new \DOMDocument();
			 $doc->loadHTML( $item );
			 $xpath = new \DOMXPath($doc);
			 $list = $doc->getElementsByTagName('strong');
			 $signo = array();
			 foreach($list as $node ){
				 $signo ['tipo'] = $node->nodeValue;
				 $tituloNode = $node->nextSibling;
				 $titulo = $tituloNode->nodeValue;
				 $titulo = str_replace(':','',$titulo);
				 $titulo = utf8_encode ($titulo);
				 $signo ['titulo'] = $titulo;
				 $list = $doc->getElementsByTagName('br');
				 foreach($list as $node){
					 $nodesiguiente = $node->nextSibling;
					 $value = $nodesiguiente->nodeValue;
					 $valores = explode(",",$value);
					 $pais = count($valores) > 1 ? $this->eliminarSaltoLinea($valores[0]) : "";
					 $signo['pais'] = $pais;
					 $anual = count($valores) > 1 ? $this->eliminarSaltoLinea($valores[1]) : "";
					 $signo['anual'] = $anual;
					 foreach($valores as $valor) {
							 if(strpos($valor,'Número del registro')){
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
		/**
		 *
		 * @return Arreglo de innovación gestión empresarial
		 */
		 public function innovacionGestionEmpresarial(){
			 $query = '/html/body/table[35]'; //Qué es?
			 return $this->extraer( $query );
		 }
		 /**
		* Obtienen la innovación gestión empresarial
		* @return Arreglo de arreglos
		* 		$innovacion['tipo'] el tipo de innovación
		* 		$innovacion['titulo'] el titulo de innovación
		* 		$innovacion['pais'] el pais de innovación
		* 		$innovacion['anual'] el año de innovación
		* 		$innovacion['disponibilidad'] la disponibilidad de innovación
		* 		$innovacion['institucion_financiadora'] la institucion financiadora de innovación
		*/
		public function getInnovacionGestionEmpresarial(){
		 $query = '/html/body/table[35]'; //pendiente
		 $array = $this->extraer( $query );
		 $innovaciones = array();
		 foreach($array as $item ){
			 $doc = new \DOMDocument();
			 $doc->loadHTML( $item );
			 $xpath = new \DOMXPath($doc);
			 $list = $doc->getElementsByTagName('strong');
			 $innovacion = array();
			 foreach($list as $node ){
				 $innovacion['tipo'] = $node->nodeValue;
				 $tituloNode = $node->nextSibling;
				 $titulo = $tituloNode->nodeValue;
				 $titulo = str_replace(':','',$titulo);
				 $titulo = utf8_encode ($titulo);
				 $innovacion['titulo'] = $titulo;
				 $list = $doc->getElementsByTagName('br');
				 foreach($list as $node){
					 $nodesiguiente = $node->nextSibling;
					 $value = $nodesiguiente->nodeValue;
					 $valores = explode(",",$value);
					 $anual = count($valores) > 1 ? $this->eliminarSaltoLinea($valores[1]) : "";
					 $innovacion['anual'] = $anual;
					 foreach($valores as $valor) {
							 if(strpos($valor,'Disponibilidad')){
						 $result = explode(':',$valor);
						 $disponibilidad = count($result) > 1 ? $this->eliminarSaltoLinea($result[1]) : "";
						 $innovacion['disponibilidad'] = $disponibilidad;
							 }
							 if(strpos($valor,'Institución financiadora')){
						 $result = explode(':',$valor);
						 $institucionFinanciadora = count($result) > 1 ? $this->eliminarSaltoLinea($result[1]) : "";
						 $innovacion['institucion_financiadora'] = $institucionFinanciadora;
							 }
						if(strpos($valor,'Autores')){
							$result = explode(':',$valor);
							$autores = count($result) > 1 ? $this->eliminarSaltoLinea($result[1]) : "";
							$innovacion['autores'] = $autores;
						}else{
							$pais = count($valores) > 1 ? $this->eliminarSaltoLinea($valores[0]) : "";
							$innovacion['pais'] = $pais;
						}
					 }
				 }
			 }
			 $innovaciones[] = $innovacion;
		 }
		 return $innovaciones;
		}
		/**
		 *
		 * @return Arreglo de innovación gestión empresarial
		 */
		 public function innovacionProcesosProcedimientos(){
			 $query = '/html/body/table[35]'; //Qué es?
			 return $this->extraer( $query );
		 }
		 /**
		* Obtienen la innovación gestión empresarial
		* @return Arreglo de arreglos
		* 		$innovacion['tipo'] el tipo de innovación
		* 		$innovacion['titulo'] el titulo de innovación
		* 		$innovacion['pais'] el pais de innovación
		* 		$innovacion['anual'] el año de innovación
		* 		$innovacion['disponibilidad'] la disponibilidad de innovación
		* 		$innovacion['institucion_financiadora'] la institucion financiadora de innovación
		*/
		public function getInnovacionProcesosProcedimientos(){
		 $query = '/html/body/table[35]'; //pendiente
		 $array = $this->extraer( $query );
		 $innovaciones = array();
		 foreach($array as $item ){
			 $doc = new \DOMDocument();
			 $doc->loadHTML( $item );
			 $xpath = new \DOMXPath($doc);
			 $list = $doc->getElementsByTagName('strong');
			 $innovacion = array();
			 foreach($list as $node ){
				 $innovacion['tipo'] = $node->nodeValue;
				 $tituloNode = $node->nextSibling;
				 $titulo = $tituloNode->nodeValue;
				 $titulo = str_replace(':','',$titulo);
				 $titulo = utf8_encode ($titulo);
				 $innovacion['titulo'] = $titulo;
				 $list = $doc->getElementsByTagName('br');
				 foreach($list as $node){
					 $nodesiguiente = $node->nextSibling;
					 $value = $nodesiguiente->nodeValue;
					 $valores = explode(",",$value);
					 $pais = count($valores) > 1 ? $this->eliminarSaltoLinea($valores[0]) : "";
					 $innovacion['pais'] = $pais;
					 $anual = count($valores) > 1 ? $this->eliminarSaltoLinea($valores[1]) : "";
					 $innovacion['anual'] = $anual;
					 foreach($valores as $valor) {
							 if(strpos($valor,'Disponibilidad')){
						 $result = explode(':',$valor);
						 $disponibilidad = count($result) > 1 ? $this->eliminarSaltoLinea($result[1]) : "";
						 $innovacion['disponibilidad'] = $disponibilidad;
							 }
							 if(strpos($valor,'Institución financiadora')){
						 $result = explode(':',$valor);
						 $institucionFinanciadora = count($result) > 1 ? $this->eliminarSaltoLinea($result[1]) : "";
						 $innovacion['institucion_financiadora'] = $institucionFinanciadora;
							 }
					 }
				 }
			 }
			 $innovaciones[] = $innovacion;
		 }
		 return $innovaciones;
		}
		/**
		 *
		 * @return Arreglo de documentos de trabajo
		 */
		 public function documentoTrabajo(){
			 $query = '/html/body/table[35]'; //Qué es?
			 return $this->extraer( $query );
		 }
		 /**
		* Obtienen los documentos de trabajo
		* @return Arreglo de arreglos
		* 		$documento['titulo'] el titulo del documento
		* 		$documento['tipo'] el tipo del documento
		* 		$documento['anual'] el año del documento
		* 		$documento['paginas'] las páginas del documento
		* 		$documento['instituciones'] instituciones del documento
		* 		$documento['url'] la url del documento
		* 		$documento['doi'] doi del documento
		*/
		public function getDocumentoTrabajo(){
		 $query = '/html/body/table[35]'; //pendiente
		 $array = $this->extraer( $query );
		 $documentos = array();
		 foreach($array as $item ){
			 $doc = new \DOMDocument();
			 $doc->loadHTML( $item );
			 $xpath = new \DOMXPath($doc);
			 $list = $doc->getElementsByTagName('strong');
			 $documento = array();
			 foreach($list as $node ){
				 $documento['tipo'] = $node->nodeValue;
				 $tituloNode = $node->nextSibling;
				 $titulo = $tituloNode->nodeValue;
				 $titulo = str_replace(':','',$titulo);
				 $titulo = utf8_encode ($titulo);
				 $documento['titulo'] = $titulo;
				 $list = $doc->getElementsByTagName('br');
				 foreach($list as $node){
					 $nodesiguiente = $node->nextSibling;
					 $value = $nodesiguiente->nodeValue;
					 $valores = explode(",",$value);
					 
					 foreach($valores as $valor) {
							 if(strpos($valor,'Nro. Paginas')){
						 $result = explode(':',$valor);
						 $paginas = count($result) > 1 ? $this->eliminarSaltoLinea($result[1]) : "";
						 $documento['paginas'] = $paginas;
							 }
							 if(strpos($valor,'Instituciones participantes')){
						 $result = explode(':',$valor);
						 $instituciones= count($result) > 1 ? $this->eliminarSaltoLinea($result[1]) : "";
						 $documento['instituciones'] = $instituciones;
							 }
							 if(strpos($valor,'URL')){
						 $result = explode(':',$valor);
						 $url= count($result) > 1 ? $this->eliminarSaltoLinea($result[1]) : "";
						 $documento['url'] = $url;
							 }
							 if(strpos($valor,'DOI')){
						 $result = explode(':',$valor);
						 $doi= count($result) > 1 ? $this->eliminarSaltoLinea($result[1]) : "";
						 $documento['doi'] = $doi;
							 }
						if(strpos($valor,'Autores')){
							$result = explode(':',$valor);
							$autores= count($result) > 1 ? $this->eliminarSaltoLinea($result[1]) : "";
							$documento['autores'] = $autores;
						}else{
							 $anual = count($valores) > 1 ? $this->eliminarSaltoLinea($valores[0]) : "";
							 $documento['anual'] = $anual;
						}
					 }
				 }
			 }
			 $documentos[] = $documento;
		 }
		 return $documentos;
		}
		/**
		 *
		 * @return Arreglo de publicaciones
		 */
		 public function otraPublicacion(){
			 $query = '/html/body/table[35]'; //Qué es?
			 return $this->extraer( $query );
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
		public function getOtraPublicacion(){
		 $query = '/html/body/table[35]'; //pendiente
		 $array = $this->extraer( $query );
		 $publicaciones = array();
		 foreach($array as $item ){
			 $doc = new \DOMDocument();
			 $doc->loadHTML( $item );
			 $xpath = new \DOMXPath($doc);
			 $list = $doc->getElementsByTagName('strong');
			 $publicacion = array();
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
		/**
		 *
		 * @return Arreglo de consultorías
		 */
		 public function consultoriasCientifica(){
			 $query = '/html/body/table[35]'; //Qué es?
			 return $this->extraer( $query );
		 }
		 /**
		* Obtienen las consultorias Cientifico Tecnologicas
		* @return Arreglo de arreglos
		* 		$consultoria['tipo'] el tipo de la consultoria
		* 		$consultoria['titulo'] el titulo de la consultoria
		* 		$consultoria['país'] el país de la consultoria
		* 		$consultoria['anual'] el año de la consultoria
		* 		$consultoria['idioma'] el idioma de la consultoria
		* 		$consultoria['disponibilidad'] la disponibilidad de la consultoria
		* 		$consultoria['numero_contrato'] el número de contrato de la consultoria
		* 		$consultoria['institucion_financiaria'] la institucion financiaria de la consultoria
		*/
		public function getConsultoriaCientifica(){
		 $query = '/html/body/table[35]'; //pendiente
		 $array = $this->extraer( $query );
		 $consultorias = array();
		 foreach($array as $item ){
			 $doc = new \DOMDocument();
			 $doc->loadHTML( $item );
			 $xpath = new \DOMXPath($doc);
			 $list = $doc->getElementsByTagName('strong');
			 $consultoria = array();
			 foreach($list as $node ){
				 $consultoria['tipo'] = $node->nodeValue;
				 $tituloNode = $node->nextSibling;
				 $titulo = $tituloNode->nodeValue;
				 $titulo = str_replace(':','',$titulo);
				 $titulo = utf8_encode ($titulo);
				 $consultoria['titulo'] = $titulo;
				 $list = $doc->getElementsByTagName('br');
				 foreach($list as $node){
					 $nodesiguiente = $node->nextSibling;
					 $value = $nodesiguiente->nodeValue;
					 $valores = explode(",",$value);
					 $pais = count($valores) > 1 ? $this->eliminarSaltoLinea($valores[0]) : "";
					 $consultoria['pais'] = $pais;
					 $anual = count($valores) > 1 ? $this->eliminarSaltoLinea($valores[1]) : "";
					 $consultoria['anual'] = $anual;
					 foreach($valores as $valor) {
							 if(strpos($valor,'Idioma')){
						 $result = explode(':',$valor);
						 $idioma = count($result) > 1 ? $this->eliminarSaltoLinea($result[1]) : "";
						 $consultoria['idioma'] = $idioma;
							 }
							 if(strpos($valor,'Disponibilidad')){
						 $result = explode(':',$valor);
						 $disponibilidad = count($result) > 1 ? $this->eliminarSaltoLinea($result[1]) : "";
						 $consultoria['disponibilidad'] = $disponibilidad;
							 }
							 if(strpos($valor,'Número del contrato')){
						 $result = explode(':',$valor);
						 $numeroContrato = count($result) > 1 ? $this->eliminarSaltoLinea($result[1]) : "";
						 $consultoria['numero_contrato'] = $numeroContrato;
							 }
							 if(strpos($valor,'Institución que se benefició del servicio')){
						 $result = explode(':',$valor);
						 $institucion = count($result) > 1 ? $this->eliminarSaltoLinea($result[1]) : "";
						 $consultoria['institucion_financiaria'] = $institucion;
							 }
					 }
				 }
			 }
			 $consultorias[] = $consultoria;
		 }
		 return $consultorias;
		}
		/**
		 *
		 * @return Arreglo de prototipos
		 */
		 public function prototipos(){
			 $query = '/html/body/table[35]'; //Qué es?
			 return $this->extraer( $query );
		 }
		 /**
		* Obtienen los prototipos
		* @return Arreglo de arreglos
		* 		$prototipo['tipo'] el tipo del prototipo
		* 		$prototipo['titulo'] el titulo del prototipo
		* 		$prototipo['país'] el país del prototipo
		* 		$prototipo['anual'] el año del prototipo
		* 		$prototipo['disponibilidad'] la disponibilidad del prototipo
		* 		$prototipo['institucion_financiadora'] la institucion financiadora del prototipo
		*/
		public function getPrototipos(){
		 $query = '/html/body/table[35]'; //pendiente
		 $array = $this->extraer( $query );
		 $prototipos = array();
		 foreach($array as $item ){
			 $doc = new \DOMDocument();
			 $doc->loadHTML( $item );
			 $xpath = new \DOMXPath($doc);
			 $list = $doc->getElementsByTagName('strong');
			 $prototipo = array();
			 foreach($list as $node ){
				 $prototipo['tipo'] = $node->nodeValue;
				 $tituloNode = $node->nextSibling;
				 $titulo = $tituloNode->nodeValue;
				 $titulo = str_replace(':','',$titulo);
				 $titulo = utf8_encode ($titulo);
				 $prototipo['titulo'] = $titulo;
				 $list = $doc->getElementsByTagName('br');
				 foreach($list as $node){
					 $nodesiguiente = $node->nextSibling;
					 $value = $nodesiguiente->nodeValue;
					 $valores = explode(",",$value);
					 $pais = count($valores) > 1 ? $this->eliminarSaltoLinea($valores[0]) : "";
					 $prototipo['pais'] = $pais;
					 $anual = count($valores) > 1 ? $this->eliminarSaltoLinea($valores[1]) : "";
					 $prototipo['anual'] = $anual;
					 foreach($valores as $valor) {
							 if(strpos($valor,'Disponibilidad')){
						 $result = explode(':',$valor);
						 $disponibilidad = count($result) > 1 ? $this->eliminarSaltoLinea($result[1]) : "";
						 $prototipo['disponibilidad'] = $disponibilidad;
							 }
							 if(strpos($valor,'Institución financiadora')){
						 $result = explode(':',$valor);
						 $institucion = count($result) > 1 ? $this->eliminarSaltoLinea($result[1]) : "";
						 $prototipo['institucion_financiadora'] = $institucion;
							 }
					 }
				 }
			 }
			 $prototipos[] = $prototipo;
		 }
		 return $prototipos;
		}
		
	/**
		 *
		 * @return Arreglo de ediciones
		 */
		 public function ediciones(){
			 $query = '/html/body/table[34]';
			 return $this->extraer( $query );
		 }
		 /**
		* Obtienen las ediciones
		* @return Arreglo de arreglos
		* 		$edicion['tipo'] el tipo de la edición
		* 		$edicion['titulo'] el titulo de la edición
		* 		$edicion['pais'] el pais de la edición
		* 		$edicion['anual'] el año de la edicion
		* 		$edicion['editorial'] la editorial de la edicion
		* 		$edicion['idiomas'] los idiomas de la edicion
		* 		$edicion['paginas'] las páginas de la edicion
		*/
		public function getEdiciones(){
		 $query = '/html/body/table[34]';
		 $array = $this->extraer( $query );
		 $ediciones = array();
		 foreach($array as $item ){
			 $doc = new \DOMDocument();
			 $doc->loadHTML( $item );
			 $xpath = new \DOMXPath($doc);
			 $list = $doc->getElementsByTagName('strong');
			 $edicion = array();
			 foreach($list as $node ){
				 $edicion['tipo'] = $node->nodeValue;
				 $tituloNode = $node->nextSibling;
				 $titulo = $tituloNode->nodeValue;
				 $titulo = str_replace(':','',$titulo);
				 $titulo = utf8_encode ($titulo);
				 $edicion['titulo'] = $titulo;
				 $list = $doc->getElementsByTagName('br');
				 foreach($list as $node){
					 $nodesiguiente = $node->nextSibling;
					 $value = $nodesiguiente->nodeValue;
					 $valores = explode(",",$value);
					 if(strpos($value,'Autores'){
						$result = explode(':',$value);
						$autores = count($result) > 1 ? $this->eliminarSaltoLinea($result[1]) : "";
						$edicion['autores'] = $autores;
					 }else{
						$pais = count($valores) > 1 ? $this->eliminarSaltoLinea($valores[0]) : "";
						$edicion['pais'] = $pais;
						$anual = count($valores) > 1 ? $this->eliminarSaltoLinea($valores[1]) : "";
						$edicion['anual'] = $anual;
					 }
					 foreach($valores as $valor) {
							 if(strpos($valor,'Editorial')){
								  $result = explode(':',$valor);
								  $editorial = count($result) > 1 ? $this->eliminarSaltoLinea($result[1]) : "";
								  $edicion['editorial'] = $editorial;
							 }
							 if(strpos($valor,'Idiomas')){
								  $result = explode(':',$valor);
								  $idiomas = count($result) > 1 ? $this->eliminarSaltoLinea($result[1]) : "";
								  $edicion['idiomas'] = $idiomas;
							 }
							 if(strpos($valor,'Páginas')){
								  $result = explode(':',$valor);
								  $paginas = count($result) > 1 ? $this->eliminarSaltoLinea($result[1]) : "";
								  $edicion['paginas'] = $paginas;
							 }
						 }
					}
				}
			      $ediciones[] = $edicion;
			}
			return $ediciones;
		}
		
		
		
		/**
		 *
		 * @return Arreglo de informes de investiación
		 */
		 public function informesInvestigacion(){
			 $query = '/html/body/table[36]';
			 return $this->extraer( $query );
		 }
		 /**
		* Obtienen los informes de investiación
		* @return Arreglo de arreglos
		* 		$informe['tipo'] el tipo del informe
		* 		$informe['titulo'] el titulo del informe
		* 		$informe['anual'] el año del informe
		* 		$informe['proyecto_investigacion'] el proyecto del informe
		*/
		public function getInformesInvestigacion(){
		 $query = '/html/body/table[36]';
		 $array = $this->extraer( $query );
		 $informes = array();
		 foreach($array as $item ){
			 $doc = new \DOMDocument();
			 $doc->loadHTML( $item );
			 $xpath = new \DOMXPath($doc);
			 $list = $doc->getElementsByTagName('strong');
			 $informe = array();
			 foreach($list as $node ){
				 $informe['tipo'] = $node->nodeValue;
				 $tituloNode = $node->nextSibling;
				 $titulo = $tituloNode->nodeValue;
				 $titulo = str_replace(':','',$titulo);
				 $titulo = utf8_encode ($titulo);
				 $informe['titulo'] = $titulo;
				 $list = $doc->getElementsByTagName('br');
				 foreach($list as $node){
					 $nodesiguiente = $node->nextSibling;
					 $value = $nodesiguiente->nodeValue;
					 $valores = explode(",",$value);
					 if(strpos($value,'Autores'){
						$result = explode(':',$value);
						$autores = count($result) > 1 ? $this->eliminarSaltoLinea($result[1]) : "";
						$informe['autores'] = $autores;
					 }else{
						$anual = count($valores) > 1 ? $this->eliminarSaltoLinea($valores[0]) : "";
						$informe['anual'] = $anual;
					 }
					 foreach($valores as $valor) {
							 if(strpos($valor,'Proyecto de investigación')){
								  $result = explode(':',$valor);
								  $proyecto = count($result) > 1 ? $this->eliminarSaltoLinea($result[1]) : "";
								  $informe['proyecto_investigacion'] = $proyecto;
							 }
						 }
					}
				}
			      $informes[] = $informe;
			}
			return $informes;
		}
		
		
		/**
		 *
		 * @return Arreglo de redes de conocimiento
		 */
		 public function redesConocimiento(){
			 $query = '/html/body/table[37]';
			 return $this->extraer( $query );
		 }
		 /**
		* Obtienen las redes de conocimiento
		* @return Arreglo de arreglos
		* 		$red['tipo'] el tipo de la red
		* 		$red['titulo'] el titulo de la red
		* 		$red['anual'] el lugar de la red
		* 		$red['desde'] fecha inicio red
		* 		$red['hasta'] fecha fin red
		* 		$red['numero_participantes'] numero participantes red
		*/
		public function getRedesConocimiento(){
		 $query = '/html/body/table[37]';
		 $array = $this->extraer( $query );
		 $redes = array();
		 foreach($array as $item ){
			 $doc = new \DOMDocument();
			 $doc->loadHTML( $item );
			 $xpath = new \DOMXPath($doc);
			 $list = $doc->getElementsByTagName('strong');
			 $red = array();
			 foreach($list as $node ){
				 $red['tipo'] = $node->nodeValue;
				 $tituloNode = $node->nextSibling;
				 $titulo = $tituloNode->nodeValue;
				 $titulo = str_replace(':','',$titulo);
				 $titulo = utf8_encode ($titulo);
				 $red['titulo'] = $titulo;
				 $list = $doc->getElementsByTagName('br');
				 foreach($list as $node){
					 $nodesiguiente = $node->nextSibling;
					 $value = $nodesiguiente->nodeValue;
					 $valores = explode(",",$value);
					 $ciu = count($valores) > 1 ? $this->eliminarSaltoLinea($valores[0]) : "";
					 $ciudad = str_replace( 'en ','',$ciu);
					 $red['lugar'] = $ciudad;
					 foreach($valores as $valor) {
							 if(strpos($valor,'Número de participantes')){
								  $result = explode(':',$valor);
								  $participantes = count($result) > 1 ? $this->eliminarSaltoLinea($result[1]) : "";
								  $red['numero_participantes'] = $participantes;
							 }
							 if(strpos($valor, 'hasta')){
								$result = explode('hasta', $valor);
								$fechaInicial = $result[0];
								$desde = str_replace('desde ','', $fechaInicial);
								$red['desde'] =  $desde;
								$fechaFinal = count($result)>1 ? $result[1] : "";
								$red['hasta'] = $hasta;
							}
						 }
					}
				}
			      $redes[] = $red;
			}
			return $redes;
		}
}
