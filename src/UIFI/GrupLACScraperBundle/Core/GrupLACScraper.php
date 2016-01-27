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

}
