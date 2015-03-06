<?php

namespace UIFI\GrupLACScraperBundle\Core
/**
  *@file
  *
  *Clase encargada de extraer toda la información respecto al
  *GrupLAC de un integrante del grupo de Investigación GIIRA.
  *
  *@author: Cristian Camilo Chaparro A.
  */

class IndividualCVLACScraper extends GrupLACScraper
{
  /**
   * Código del  CvLAC de una paresona en el grupo de investigación Especificado.
   */
  private $code;

	/**
	  * Constructor del objeto
	  */
	public function __construct( $url )
	{
      $this->code = $url;
      CVLACScraper::__construct( $url );
	}
  private function extraerValor($query){
      $resultados = $this->xpath->query( $query );
      return $resultados ->item(0)->nodeValue;
  }
  /**
   *Extrae el nombre del CvLAC de la persona de acuerdo al código.
   *@return Nombre del perfil del CvLAC.
   */
  public function getNombre()
  {
      $query = '/html/body/div/div[3]/table/tr[2]/td/table/tr[1]/td[2]';
      return $this->extraerValor( $query );
  }
  /**
    * Método que se encarga de extraer el nombre en citaciones del CvLAC
    * de una persona de acuerdo al código.
    * @return Nombre de la persona usado en citaciones
    */
  public function getNombreCitaciones(){
      $query = '/html/body/div/div[3]/table/tr[2]/td/table/tr[2]/td[2]';
       return $this->extraerValor( $query );
  }
  /**
    *Método que se encarga de extrar la nacionalidad de una persona de
    *acuerdo al CvLAC.
    *@return Nacionalidad
    */
  public function getNacionalidad(){
      $query = '/html/body/div/div[3]/table/tr[2]/td/table/tr[3]/td[2]';
      return $this->extraerValor( $query );
  }
  public function extraer($query){
      $items =  array();
      $listaNodos = $this->xpath->query( $query );
      foreach( $listaNodos as $element )
      {
          $nodeList =  $element->getElementsByTagName( 'td' );
          foreach( $nodeList as $node ){
              $doc = new DOMDocument();
              $doc->appendChild($doc->importNode($node, true));
              $value =  $doc->saveHTML() ;
              $value = str_replace('<li>&nbsp;</li>', '', $value );
              $value = str_replace('&nbsp;', '', $value );
              $items[] = $value ;
          }
      }
      array_shift($items);//elimana el titulo
      return $items;
  }
  /**
    * Método que se encarga de extrar la información relacionada con
    * la formación academica de un integrante del grupo de investigación.
    * @return Arreglo con la lista de items de formación academica.
    */
  public function getFormacionAcademica()
  {
    $query = '/html/body/div/div[3]/table/tr[4]/td/table';
    return $this->extraer($query);
  }
  public function getFormacioncomplementaria(){
    $query = '/html/body/div/div[3]/table/tr[6]/td/table';
    return $this->extraer($query);
  }
  public function getExperienciaProfesional(){
    $query='/html/body/div/div[3]/table/tr[8]/td/table';
    return $this->extraer($query);
  }
  public function getAreasActuacion(){
    $query = '/html/body/div/div[3]/table/tr[11]/td/table';
    return  $this->extraer($query);
  }
  public function getLineasInvestigacion(){
    $query = '/html/body/div/div[3]/table/tr[13]/td/table';
    return $this->extraer($query);
  }
  public function getReconocimientos(){
    $query = '/html/body/div/div[3]/table/tr[14]/td/table';
    return $this->extraer( $query );
  }
  public function getTrabajosDirigidosTutorias(){
    $query = '/html/body/div/div[3]/table/tr[18]/td/table';
    return $this->extraer($query);
  }
  public function getEdicionesRevisiones(){
    $query = '/html/body/div/div[3]/table/tr[23]/td/table';
    return $this->extraer($query);
  }
  public function getEventosCientificos(){
    $query = '/html/body/div/div[3]/table/tr[24]/td/table';
    $array = $this->extraer($query);
    $items = array();
    foreach( $array as $item )
    {
      $doc = new DOMDocument();
      $doc->loadHTML( $item );
      $list = $doc->getElementsByTagName('strong');
      foreach( $list as $node )
      {
         $node->nodeValue= str_replace('&nbsp', '', $node->nodeValue );
         echo $node->firstChild ->nodeValue . '<br><br>';
         if (is_numeric ($node->nodeValue)){
            $node->nodeValue='';
         }
      }
      $itemFiltered =  $doc->saveHTML() ;
      $items[] = $itemFiltered;
    }
    return $items;
  }
  public function redesConocimientoEspecializado(){
    $query = '/html/body/div/div[3]/table/tr[25]/td/table';
    return $this->extraer($query);
  }
  public function getArticulos(){
    $query = '/html/body/div/div[3]/table/tr[34]/td/table';
    return $this->extraer($query);
  }
  public function getLibros(){
    $query = '/html/body/div/div[3]/table/tr[36]/td/table';
    return $this->extraer($query);
  }
  public function getCapitulosLibros(){
    $query = '/html/body/div/div[3]/table/tr[38]/td/table';
    return $this->extraer($query);
  }
  public function getCapitulosMemoria(){
    $query = '/html/body/div/div[3]/table/tr[40]/td';
    return $this->extraer($query);
  }
  public function getSoftwares(){
    $query = '/html/body/div/div[3]/table/tr[50]/td';
    return $this->extraer($query);
  }
  public function getProyectos(){
    $query = '/html/body/div/div[3]/table/tr[86]/td/table';
    return $this->extraer($query);
  }
}
