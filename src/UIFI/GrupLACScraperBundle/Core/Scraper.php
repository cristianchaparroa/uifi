<?php

namespace UIFI\GrupLACScraperBundle\Core;
/**
  * Clase encargada de proporcionar las funciones básicas del Scraper del GrupLac
  * @author : Cristian Camilo Chaparro A.
  */
class Scraper
{

	/**
	  *
	  */
	protected $urlBase = '';
	/**
	 * DOM html
	 */
	protected $dom;
	/**
	  * Objeto Xpath que permite interactuar con el dom a través de queries xpath.
	  */
	protected $xpath;
	/**
	  *
	  */
	protected $html;

	protected $error;

	/**
	  * Constructor de la clase CVLACScraper
	  * @param url Url en la cual se va a realizar el web scraping
	  */
	public function __construct( $url )
	{
			$this->urlBase = $url;
			//$proxy = $container->getParameter('proxy.gruplac_scrapper');;

			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL,  $this->urlBase);
			//curl_setopt($ch, CURLOPT_PROXY, $proxy);
			//curl_setopt($ch, CURLOPT_PROXYUSERPWD, $proxyauth);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_HEADER, 1);
			$this->html = curl_exec($ch);
			$this->html  = $this->convertToUTF8( $this->html );
			if( $this->html !=='' )
			{
				$this->dom = new \DOMDocument();
				libxml_use_internal_errors(true);
				$this->dom->loadHTML($this->html);
				$this->dom->encoding = 'utf8';
				$this->xpath = new \DOMXPath($this->dom);
				$this->xpath->registerNamespace('html','http://www.w3.org/1999/xhtml');
			}
			else{
				$this->error = true;
			}
			curl_close($ch);
	}
	/**
	 * Función que se encarcarga aplicar una codificación UTF-8 al contenido
	 * obtendio desde la url especificada.
	*/
	public function convertToUTF8($html){
		return preg_replace("@(^[\s\S]+?<meta[\s\S]+?charset=['\"]?)(.+?)(['\"]\s*/?>[\s\S]+$)@i","$1UTF-8$3",$html);
	}
	public function isError(){
		return $this->error;
	}

	public function eliminarSaltoLinea( $string ){
		$string =  trim(preg_replace('/\s\s+/', ' ', $string ));
		$string =  trim(preg_replace('/\s+/', ' ', $string));
		return str_replace(array("\n", "\r"), ' ', $string);
	}
	public function getDOM(){
		return $this->dom;
	}

	public function elimiarElementosVacios($array){
		$newArray= array();
		foreach( $array as $item){
			 $elemento = $this->eliminarSaltoLinea($item);
			 if( !empty($elemento)  ){
				 $newArray [] = $elemento;
			 }
		}
		return $newArray;
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
	public function extraer($query){
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

}
