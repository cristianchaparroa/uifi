<?php

namespace UIFI\GrupLACScraperBundle\Core;

class PrototipoScraper  extends  Scraper
{
    const URL_BASE='http://scienti.colciencias.gov.co:8080/gruplac/jsp/visualiza/visualizagr.jsp?nro=';
     /**
      * Constructor del objeto
      */
    public function __construct($grupoDTO) {
         Scraper::__construct( self::URL_BASE . $grupoDTO['id'] );
         $this->grupoDTO = $grupoDTO;
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
		public function getPrototipos() {
		 $query = '/html/body/table[27]';
		 $array = $this->extraer( $query );
		 $prototipos = array();
		 foreach($array as $item ){
			 $doc = new \DOMDocument();
			 $doc->loadHTML( $item );
			 $xpath = new \DOMXPath($doc);
			 $list = $doc->getElementsByTagName('strong');
			 $prototipo = array();
       $prototipo['nombreGrupo'] = $this->grupoDTO['nombre'];
       $prototipo['grupo'] = $this->grupoDTO['id'];

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

           if(strpos($value,'Disponibilidad:')) {
             $data = explode(",",$value);
             $pais = count($data) > 1 ? $this->eliminarSaltoLinea($data[0]) : "";
             $prototipo['pais'] = $pais;
             $anual = count($data) > 1 ? $this->eliminarSaltoLinea($data[1]) : "";
             $prototipo['anual'] = $anual;
           }
           if(strpos($value,'Autores:')){
             $resultAutores = explode('Autores:',$value);
             $autores = count($resultAutores) >= 1 ? $resultAutores[1] : "";
             $prototipo['autores'] = $autores;
           }
           if(strpos($value,'Institución financiadora:')){
              $result = explode('Institución financiadora:',$value);
              $institucion = count($result) > 1 ? $this->eliminarSaltoLinea($result[1]) : "";
              $prototipo['institucion_financiadora'] = $institucion;
           }
           $valores = explode(",",$value);
					 foreach($valores as $valor) {
							 if(strpos($valor,'Disponibilidad:')){
						      $result = explode(':',$valor);
						      $disponibilidad = count($result) > 1 ? $result[1] : "";
						      $prototipo['disponibilidad'] = $disponibilidad;
							 }
					 }
				 }
			 }
			 $prototipos[] = $prototipo;
		 }
		 return $prototipos;
		}
}
