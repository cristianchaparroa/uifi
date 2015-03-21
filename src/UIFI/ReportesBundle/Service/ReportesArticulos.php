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
class ReportesArticulos
{
    /**
     * Constructor
    */
    public function __construct(Container $container)
    {
       $this->container = $container;
       $this->em = $container->get('doctrine.orm.entity_manager');
       $this->translator = $container->get('translator');
    }

    /**
     * Función que se encarga de configurar la gráfica de acuerdo de los
     * parámetros seleccionados por el usuario.
     *
     * @param $mapParameters Mapa de parámetros generados por la petición generada
     *  por el formulario.
    */
    private function configurarGrafica($mapParameters)
    {
        $allCategories = array();
        $series = array();
        $categorias = array();
        $grupo = $mapParameters['grupo'];
        $repositoryGrupo= $this->em->getRepository('UIFIIntegrantesBundle:Grupo');
        $repositoryGrupo = $this->em->getRepository('UIFIIntegrantesBundle:Grupo');
        /**
         * Si el usuario NO selecciono ningún grupo de la lista de grupos de
         * investigación,se deben generar reportes  para todos los grupos,
         * discriminados por años o por grupo.
        */


        if( $grupo == '' )
        {
             $repositoryGrupo = $this->em->getRepository('UIFIIntegrantesBundle:Grupo');
             $discriminarGrupo = $mapParameters['discriminarGrupo'];
             $grupos = $repositoryGrupo->findAll();
             if(  $discriminarGrupo == 'grupo' ){
               foreach( $grupos as $group ){
                  $articulosGrupo = $repositoryGrupo->getCountArticulosByGrupo( $group->getId() );
                  $series[] = array( 'name'=> $group->getNombre(), 'data'=> array($articulosGrupo) );
               }
             }
             if( $discriminarGrupo == 'fecha' )
             {
               $grafica = array();
               foreach( $grupos as $group )
               {
                   $results = $repositoryGrupo->getCountArticulosByYear( $group->getId() );
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
        }
        return array( 'series'=> $series, 'categorias' =>  $categorias );
    }
    /**
    * Normalización de series, cuando no se selecciona un grupo de investigación
    * y se discrimina por Año.
    * @param
    * @return Arreglo con las categorias y series normalizadas.
    */
    private function normalizarGraficaGruposAnual( $grafica )
    {
        $mayor =  0;
        $idGrupo = 0;
        foreach( $grafica as $key=>$value){
          if( $mayor < count($value) ){
             $mayor = count($value);
             $idGrupo = $key;
          }
        }
        $grupoSerie = $grafica[$idGrupo];
        $grafic = array();

        foreach( $grafica as $codeGrupo => $serieGrupo ){
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
        $ob = new Highchart();
        $ob->chart->renderTo('linechart');  // The #id of the div where to render the chart
        $ob->chart->type('column');

        $ob->xAxis->categories($categorias);
        $title = $this->translator->trans('reportes.articulos.title.grupos');
        $yTitle = $this->translator->trans('reportes.articulos.ytitle.produccion');
        $ob->title->text( $title  );
        $ob->yAxis->title(array('text'  => $yTitle ));
        $ob->series($series);
        $func = new \Zend\Json\Expr("function(){return 'Número de Artículos: <b>'+ this.y +'</b>';}");
        $ob->tooltip->formatter($func);
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
