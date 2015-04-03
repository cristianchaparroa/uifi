<?php

namespace UIFI\ReportesBundle\Service;

use Symfony\Component\DependencyInjection\Container;
use Ob\HighchartsBundle\Highcharts\Highchart;
use Zend\Json\Expr;

use UIFI\GrupLACScraperBundle\Core\PageGrupLACScraper;

/**
 * Lógica que permite generar la gráfica de reportes Artículos.
 * @author: Cristian Camilo Chaparro Africano <cristianchaparroa@gmail.com>
*/
abstract class Reporte
{
  /**
   * Método que se encarga de generar la configuracion de la series
   * @return Arreglo con los siguientes atributos
   *     configuracion['series']
   *     configuracion['categorias']
   *     configuracion['titulo']
   */
  //abstract protected function configurarGrafica($mapParameters);

  /**
   * @param $titulos, Arreglo con los titulos empleados en los diferentes graficos
   * @param $repositoryEntity , repositorio sobre el cual se esta generando el gráfico.
  */
  public function  __construct( $titulos , $repositoryEntity ){
    $this->titulos = $titulos;
    $this->repositoryEntity = $repositoryEntity;
  }

  protected function configurarGrafica($mapParameters)
  {

      $allCategories = array();
      $series = array();
      $categorias = array();
      $grupo = $mapParameters['grupo'];
      $repositoryGrupo = $this->em->getRepository('UIFIIntegrantesBundle:Grupo');
      $repositoryIntegrante = $this->em->getRepository('UIFIIntegrantesBundle:Integrante');
      /**
       * Si el usuario NO selecciono ningún grupo de la lista de grupos de
       * investigación,se deben generar reportes  para todos los grupos,
       * discriminados por años o por grupo.
      */
      if( $grupo == '' )
      {
           $title = $this->translator->trans('reportes.articulos.title.grupos');
           $discriminarGrupo = $mapParameters['discriminarGrupo'];
           $grupos = $repositoryGrupo->findAll();
           if(  $discriminarGrupo == 'grupo' ){
             foreach( $grupos as $group ){
                $entityGrupo = $this->repositoryEntity->getCountByGrupo( $group->getId() );
                $series[] = array( 'name'=> $group->getNombre(), 'data'=> array($entityGrupo) );
             }
           }
           if( $discriminarGrupo == 'fechaGrupo' )
           {
             $grafica = array();
             foreach( $grupos as $group )
             {
                 $results = $this->repositoryEntity->getCountByYear( $group->getId() );
                 $categoriesGroup = array();
                 foreach($results as $result){
                   $categoriesGroup[ $result['anual'] ] = intval($result['cantidad']) ;
                 }
                 $grafica[ $group->getNombre() ]  = $categoriesGroup;
             }
             $normalizacion  = $this->normalizarGraficaGruposAnual( $grafica );
             $categorias = $normalizacion['categorias'];
             $series = $normalizacion['series'];
           }
           if($discriminarGrupo =='totalFecha' )
           {
             $titulo = $this->titulos[ 'totalFecha' ];
             $results = $this->repositoryEntity->getCountAllByYear();
             $data = array();

             foreach($results as $result ){
               $anual = $result['fecha'];
               $cantidad = intval($result['cantidad']);
               $series[] = array( 'name'=> $anual , 'data'=> array($cantidad) );
               $categorias[] = $anual;
             }
           }
      }

      /**
      * Significa que se selecciono un grupo de investigación
      */
      else{
        $grupo =  $repositoryGrupo->find($grupo);

        $seleccionaIntegrante = $mapParameters['integrantes'];
        if( $seleccionaIntegrante=='' )
        {
            $title = $this->translator->trans('reportes.articulos.title.porgrupo') . $grupo->getNombre();

            $discriminarIntegrante = $mapParameters['discriminarIntegrante'];
            if($discriminarIntegrante == 'integrante')
            {
                $integrantes = $grupo->getIntegrantes();
                /**
                 * Si el grupo tiene integrantes.
                */
                if($integrantes)
                {
                    $integrantes = $integrantes->toArray();
                    foreach($integrantes as $integrante ){
                      $entiyPublicados = $this->repositoryEntity->getCantidadByIntegrante( $integrante->getId(),$grupo->getId() );
                      if($entiyPublicados>0){
                        $series[] = array( 'name'=> $integrante->getNombres(), 'data'=> array($entiyPublicados ) );
                      }
                    }
                    $categorias[] = 'Integrantes';
               }
            }
            if($discriminarIntegrante=='fecha')
            {
                $grupos [] = $grupo;
                foreach( $grupos as $group )
                {
                    $results = $this->repositoryEntity->getCountByYear( $group->getId() );
                    $categoriesGroup = array();
                    $dataGroup = array();
                    foreach($results as $result)
                    {
                      $categorias[] = $result['anual'];
                      $dataGroup[] = intval($result['cantidad']) ;
                    }
                    $series[] = array( 'name'=> $group->getNombre(), 'data'=> $dataGroup );
                }
            }
        }
        else{
          $entityIntegrante = $repositoryIntegrante->find($seleccionaIntegrante);
          $title = "Entity publicados por " . $entityIntegrante->getNombres(). " en ".$grupo->getNombre();
          $results = $this->repositoryEntity->getCantidadIntegranteAnual($entityIntegrante->getId(),$grupo->getId() );
          $dataGroup = array();
          foreach( $results as $result ){
              $dataGroup[] = intval( $result['cantidad'] );
              $categorias[] = $result['anual'];
          }
          $series[] = array( 'name'=> $entityIntegrante ->getNombres(), 'data'=> $dataGroup );
        }
      }
      return array( 'series'=> $series, 'categorias' =>  $categorias, 'title'=>$title );
  }
  /**
  * Función que se encarga de verificar si todos las series tiene el mismo tamaño
  * @return Devuleve true si todas las series tienen el mismo tamaño.
  */
  protected function allSameSize($grafic)
  {
    $sizes = array();
    foreach( $grafic as $key=>$value){
      $sizes[] = count($value);
    }
    return (   (count(array_unique($sizes)) === 1) ? true: false );
  }
  /**
   * Funcioón que se encarga de genrar las series y categorias después de
   * normalizar las series de  grafica.
   *
  */
  protected function generateSeriesAndCategories($grafic){
    $categorias = array();
    $series = array();
    foreach($grafic as $codigoGrupo => $sucesion ){
      $dataGroup = array();
      foreach($sucesion as $anual=>$numeroArticulos){
        $dataGroup[] = $numeroArticulos;
        $categorias[] = $anual;
      }
      $series[] = array( 'name'=> $codigoGrupo, 'data'=> $dataGroup );
    }
    $categorias = array_unique( $categorias);
    return array( 'series'=> $series, 'categorias' =>  $categorias );
  }
  /**
  * Normalización de series, cuando no se selecciona un grupo de investigación
  * y se discrimina por Año.
  * @param
  * @return Arreglo con las categorias y series normalizadas.
  */
  protected function normalizarGraficaGruposAnual( $grafica )
  {
      $mayor =  0;
      $idGrupo = 0;
      $arrayFirst = array();

      foreach( $grafica as $key=>$value){
        $cantidad = count($value);
        if( $mayor < $cantidad ){
           $mayor = $cantidad;
           $idGrupo = $key;
        }
      }
      $grupoSerie = $grafica[$idGrupo];
      $grafic = array();

      foreach( $grafica as $codeGrupo => $serieGrupo )
      {
        $dataGroup = array();

        foreach($grupoSerie as $anualSerie => $value )
        {
          $existeAnual = array_key_exists( $anualSerie, $serieGrupo );
          if( !$existeAnual ){
            $dataGroup[$anualSerie] = 0;
          }
        }

        foreach($serieGrupo as $anualSerie => $numeroArticulos){
          $dataGroup[$anualSerie] = $numeroArticulos;
          $existeAnual = array_key_exists( $anualSerie,$grupoSerie);
          if(!$existeAnual){
            $grupoSerie[$anualSerie]=0;
          }
        }
        ksort($dataGroup);
        $grafic[$codeGrupo] = $dataGroup;
      }
      //al finalizar esta primera normalizacion aún pueden quedar sin normalizar
      // hay que normalizar hasta que todos las series tengan el mismo tamano
      //
      $iguales = $this->allSameSize($grafic);
      if( $iguales ){
        return $this->generateSeriesAndCategories($grafic);
      }
      else
      {
        return $this->normalizarGraficaGruposAnual( $grafic );
      }
  }
  /**
   * Función que se encarga de generar el reporte de acuerdo a los parámetros
   * selecionados por el usuario.
   *
   * @return Gráfico ObHighchart configurado.
  */
  public function generarGrafica( $mapParameters )
  {
      $configuracion  = $this->configurarGrafica($mapParameters);
      $series = $configuracion['series'];
      $categorias = $configuracion['categorias'];
      $title = $configuracion['title'];
      $ob = new Highchart();
      $ob->chart->renderTo('linechart');  // The #id of the div where to render the chart
      $ob->chart->type('column');
      $ob->chart->zoomType ('xy');
      $ob->chart->pinchType('xy');
      $ob->xAxis->categories($categorias);

      $yTitle = $this->translator->trans('reportes.articulos.ytitle.produccion');
      $ob->title->text( $title  );
      $ob->yAxis->title(array('text'  => $yTitle ));
      $ob->series($series);
      $ob->tooltip->headerFormat('<span style="font-size:11px">{series.name}</span><br>');
      //$ob->legend->enabled(false);
      return $ob;
  }
  /**
   * @param Codigo del grupo de Investigación.
   * @return array Integrantes.
  */
  public function getIntegrantes($code){
    $repositoryGrupo = $this->em->getRepository('UIFIIntegrantesBundle:Grupo');
    $grupo = $repositoryGrupo->find($code);
    $integrantes=  $grupo->getIntegrantes()->toArray();
    $result = array();
    foreach( $integrantes as $integrante){
      $int = array( 'id'=> $integrante->getId(), 'nombre'=> $integrante->getNombres() );
      $result[] = $int;
    }
    return $result;
  }
}
