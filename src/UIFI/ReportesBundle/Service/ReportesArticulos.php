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
     * párametros seleccionados por el usuario.
     *
     * @param $mapParameters Mapa de parámetros generados por la petición generada
     *  por el formulario.
    */
    private function configurarGrafica($mapParameters)
    {
        var_dump($mapParameters);

        $series = array();
        $categorias = array();
        $grupo = $mapParameters['grupo'];
        $repositoryGrupo= $this->em->getRepository('UIFIIntegrantesBundle:Grupo');
        /**
         *  Significa que no se seleccionó ningún grupo de Investigación.
        */
        $grupos = array();
        if( $grupo === ''){
            $grupos = $repositoryGrupo->findAll();
        }
        else
        {
            $grupo = $repositoryGrupo->find($grupo);
            $grupos[] = $grupo;
        }

        foreach( $grupos as $grupo ){
          $code = $grupo->getId();
          $articulosGrupo  = $repositoryGrupo->getCountArticulosByGrupo($code);
          $data = array(
              "name" => $grupo->getNombre(),
              "data" =>array($articulosGrupo)
          );
          $series[] = $data;
          $categorias[] = $grupo->getNombre();
        }
        return array( 'series'=> $series, 'categorias' => $categorias );
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
        // $ob->xAxis->categories($categorias);
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
