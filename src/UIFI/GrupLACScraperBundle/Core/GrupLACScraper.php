<?php

namespace UIFI\GrupLACScraperBundle\Core
/**
  * Clase encargada de proporcionar las funciones básicas del Scraper del GrupLac
  * @author : Cristian Camilo Chaparro A.
  */
class GrupLACScraper
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
			$this->dom = new DOMDocument();
			libxml_use_internal_errors(true);
			$this->dom->loadHTML($this->html);
			$this->xpath = new DOMXPath($this->dom);
			curl_close($ch);
	}
}
