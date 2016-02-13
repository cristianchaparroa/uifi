<?php

namespace UIFI\GrupLACScraperBundle\Core;

class ConsultoriaCientificaScraper extends  Scraper
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
		* Obtienen las consultorias Cientifico Tecnologicas
		* @return Arreglo de arreglos
		* 		$consultoria['tipo'] el tipo de la consultoria
		* 		$consultoria['titulo'] el titulo de la consultoria
		* 		$consultoria['pais'] el país de la consultoria
		* 		$consultoria['anual'] el año de la consultoria
		* 		$consultoria['idioma'] el idioma de la consultoria
		* 		$consultoria['disponibilidad'] la disponibilidad de la consultoria
		* 		$consultoria['numero_contrato'] el número de contrato de la consultoria
		* 		$consultoria['institucionBeneficiaria'] la institucion que se beneficia de la consultoria
		*/
		public function getConsultoriaCientifica() {
		 $query = '/html/body/table[18]'; //pendiente /html/body/table[18]
		 $array = $this->extraer( $query );
		 $consultorias = array();
		 foreach($array as $item ) {
			 $doc = new \DOMDocument();
			 $doc->loadHTML( $item );
			 $xpath = new \DOMXPath($doc);
			 $list = $doc->getElementsByTagName('strong');
			 $consultoria = array();
       $consultoria['nombreGrupo'] = $this->grupoDTO['nombre'];
       $consultoria['grupo'] = $this->grupoDTO['id'];

			 foreach($list as $node ) {

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
							 if(strpos($valor,'Idioma')) {
						      $result = explode(':',$valor);
						      $idioma = count($result) > 1 ? $this->eliminarSaltoLinea($result[1]) : "";
						      $consultoria['idioma'] = $idioma;
							 }
							 if(strpos($valor,'Disponibilidad')) {
						      $result = explode(':',$valor);
						      $disponibilidad = count($result) > 1 ? $this->eliminarSaltoLinea($result[1]) : "";
						      $consultoria['disponibilidad'] = $disponibilidad;
							 }
							 if(strpos($valor,'Número del contrato')) {
						      $result = explode(':',$valor);
						      $numeroContrato = count($result) > 1 ? $this->eliminarSaltoLinea($result[1]) : "";
						      $consultoria['numero_contrato'] = $numeroContrato;
							 }
							 if(strpos($valor,'Institución que se benefició del servicio')) {
						      $result = explode(':',$valor);
						      $institucion = count($result) > 1 ? $this->eliminarSaltoLinea($result[1]) : "";
						      $consultoria['institucionBeneficiaria'] = $institucion;
							 }
					 }
				 }
			 }
			 $consultorias[] = $consultoria;
		 }
		 return $consultorias;
		}
}
