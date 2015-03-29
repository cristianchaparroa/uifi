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
		const URL_BASE='http://scienti1.colciencias.gov.co:8080/gruplac/jsp/visualiza/visualizagr.jsp?nro=';
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
			$producciones = array();;
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
		* @return Arreglo con la siguiente información
		* 			articulo['titulo'] , título de articulo
		* 			articulo['anual']  , año en el que fue publicado el artículo
		* 			articulo['autores'], arreglo con los nombres de los autores
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
						$results = explode( ',',$result );
						$results = $results[2];
						$results =explode(' ',$results );
						$anual  = $results[1];
						$articulo['anual'] = $anual;
					}
				}
				array_pop($autores);
				$articulo['autores']  = $autores;
				$articulos[] = $articulo;
			}
			
			return$articulos;
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
     * Software desarrollado a partir de la producción Investigativa en
     * en el grupo.
     * @return Arreglo con la producción de software.
    */
    public function obtenerSoftwares(){
      $query = '/html/body/table[16]';
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
     * Extrae la lista de libros publicados por el grupo
     * de investigación.
     * @return Arreglo de libros publicados
    */
    public function librosPublicados(){
      $query = '/html/body/table[8]';
      return $this->extraer( $query );
    }
    /**
     * Extrae la lista de capítulos publicados en libros por integrantes
     * del grupo de investigación.
     * @return Arreglo con la lista de capitulos publicados
    */
    public function capitulosLibrosPublicados(){
      $query = '/html/body/table[9]';
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
}
