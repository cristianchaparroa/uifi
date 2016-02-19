<?php

namespace UIFI\GrupLACScraperBundle\Core;

class OtrosLibrosPublicadosScraper  extends  Scraper
{
    const URL_BASE='http://scienti.colciencias.gov.co:8080/gruplac/jsp/visualiza/visualizagr.jsp?nro=';
     /**
      * Constructor del objeto
      */
    public function __construct( $grupoDTO) {
         Scraper::__construct( self::URL_BASE . $grupoDTO['id'] );
         $this->grupoDTO = $grupoDTO;
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
    		 $query = '/html/body/table[14]';
    		 $array = $this->extraer( $query );
    		 $libros = array();
    		 foreach($array as $item ){
    			 $doc = new \DOMDocument();
    			 $doc->loadHTML( $item );
    			 $xpath = new \DOMXPath($doc);
    			 $list = $doc->getElementsByTagName('strong');
    			 $libro = array();
           $libro ['nombreGrupo'] = $this->grupoDTO['nombre'];
           $libro ['grupo'] = $this->grupoDTO['id'];
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
                 $resultAutores = explode('Autores:',$value);
                 $autores = count($resultAutores)>1 ? $resultAutores[1] : "";
                 $libro['autores'] = $this->eliminarSaltoLinea($autores);
               }
               if(strpos($value,'ISBN:')){
                 $resultPais = explode('ISBN:',$value);
                 $resultPais = count($resultPais)>1 ? $resultPais[0] :"";
                 $resultPais = explode(',',$resultPais);
                 $pais = count($resultPais)> 1 ? $resultPais[0] : "";
                 $libro['pais'] = $this->eliminarSaltoLinea($pais);
                 $anual = count($resultPais)> 1 ? $resultPais[1] : "";
                 $libro['anual'] = $anual;
               }
               foreach($valores as $valor){
                 if(strpos($valor,'ISBN:')) {
                   $resultIsbn = explode('ISBN:',$valor);
                   $resuttIsbn = count($resultIsbn)>1 ? $resultIsbn[1] : "";
                   $resultIsbn = explode('vol:',$resuttIsbn );
                   $isbn =  count($resultIsbn)>1 ?  $resultIsbn[0]:"";
                   $libro['isbn'] = $isbn;

                   $resultVolumen = count( $resultIsbn ) >1 ? $resultIsbn[1]: "";
                   $resultVolumen = explode('págs:',$resultVolumen);

                   $volumen = count($resultVolumen) > 1 ?  $resultVolumen[0] : "";
                   $libro['volumen'] = $volumen;
                   $paginas = count($resultVolumen) > 1 ?  $resultVolumen[1] : "";
                   $libro['paginas'] = $paginas;

                 }
                 if(strpos($valor,'Ed.')){
                   $resultEditorial = explode('Ed.',$valor);
                   $editorial = count($resultEditorial)>1 ? $resultEditorial[1] : "";
                   $libro['editorial'] = $editorial;
                 }
               }

             }

    			 }
    			 $libros[] = $libro;
    		 }
    		 return $libros;
    }
}
