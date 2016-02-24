<?php

namespace UIFI\GrupLACScraperBundle\Core;

class DocumentoTrabajoScraper  extends  Scraper
{
    const URL_BASE='http://scienti.colciencias.gov.co:8080/gruplac/jsp/visualiza/visualizagr.jsp?nro=';
     /**
      * Constructor del objeto
      */
    public function __construct( $grupoDTO ,$logger) {
         Scraper::__construct( self::URL_BASE . $grupoDTO['id'] );
         $this->grupoDTO = $grupoDTO;
         $this->logger = $logger;
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
  	public function getDocumentosTrabajo() {
  		 $query = '/html/body/table[11]'; //pendiente
  		 $array = $this->extraer( $query );
  		 $documentos = array();
  		 foreach($array as $item ){
  			 $doc = new \DOMDocument();
  			 $doc->loadHTML( $item );
  			 $xpath = new \DOMXPath($doc);
  			 $list = $doc->getElementsByTagName('strong');
  			 $documento = array();
         $documento['nombreGrupo'] = $this->grupoDTO['nombre'];
         $documento['grupo'] = $this->grupoDTO['id'];

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

             if(strpos($value,' Nro. Paginas:')){
               $resultAnual = explode(' Nro. Paginas:',$value);
               $anual = count($resultAnual) > 1 ? $resultAnual[0] : "";
               $anual = str_replace(',','',$anual);
               $documento['anual'] = $this->eliminarSaltoLinea($anual);
             }
             if(strpos($value,'Autores:')){
               $this->logger->err($value);
               $resultAutores = explode('Autores:',$this->eliminarSaltoLinea($value));
               $this->logger->err(json_encode($resultAutores));
               $autores = count($resultAutores) > 1  ? $resultAutores[1] : "";
               $this->logger->err($autores);
               $documento['autores'] = $autores;
             }
  					 foreach($valores as $valor) {
  							 if(strpos($valor,'Nro. Paginas')) {
  						      $result = explode(':',$valor);
  						      $paginas = count($result) > 1 ? $this->eliminarSaltoLinea($result[1]) : "";
  						      $documento['paginas'] = $paginas;
  							 }
  							 if(strpos($valor,'Instituciones participantes')) {
  						      $result = explode(':',$valor);
  						      $instituciones= count($result) > 1 ? $this->eliminarSaltoLinea($result[1]) : "";
  						      $documento['instituciones'] = $instituciones;
  							 }
  							 if(strpos($valor,'URL')) {
      						  $result = explode(':',$valor);
      						  $url= count($result) > 1 ? $this->eliminarSaltoLinea($result[1]) : "";
      						  $documento['url'] = $url;
  							 }
  							 if(strpos($valor,'DOI')) {
  						      $result = explode(':',$valor);
  						      $doi= count($result) > 1 ? $this->eliminarSaltoLinea($result[1]) : "";
  						      $documento['doi'] = $doi;
  							 }
  					 }
  				 }
  			 }
  			 $documentos[] = $documento;
  		 }
  		 return $documentos;
  	}

}
