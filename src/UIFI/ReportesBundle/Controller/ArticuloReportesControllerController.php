<?php

namespace UIFI\ReportesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use UIFI\ReportesBundle\Form\ArticuloReportesType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

use Ob\HighchartsBundle\Highcharts\Highchart;

/**
 * Controllador que se encarga de mostrar los reportes referentes a los artículos.
*/
class ArticuloReportesControllerController extends Controller
{
    /**
     * Función que muestra el formulario para filtrar la información relacionada
     * con los artículos de la facultad.
     *
     * @Route("/reportes/articulos", name="reportes_articulos")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $grupos = $em->getRepository('UIFIIntegrantesBundle:Grupo')->findAll();
        $form = $this->get('form.factory')->create(new ArticuloReportesType($grupos) );
        $view =  $form->createView();
        $parameters = array('form' => $view);
        return  $this->render('UIFIReportesBundle:ArticuloReportes:index.html.twig',$parameters);
    }

    /**
     * Función que se encarga de filtrar la información de acuerdo de los parametros
     * seleccionados por el usuario.
     *
     * @Route("/reportes/articulos/filtro",name="reportes_articulos_filtro", options={"expose":true} )
     * @param Request
     * @return JsonResponse
    */
    public function filterAction(Request $request)
    {
        $this->em = $this->getDoctrine()->getManager();
        $parameters = $this->getRequest()->request->all();
        $mapParameters = $parameters['uifi_reportes_articulo'];
        $ob = $this->generarGrafica( $mapParameters );
        return $this->render('UIFIReportesBundle:ArticuloReportes:reporte.html.twig', array(
            'chart' => $ob
        ));
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
        else{
          $grupo = $repositoryGrupo->find($code);
          $grupos[] = $grupo;
        }
        $translator = $this->get('translator');
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
        $translator = $this->get('translator');
        $ob = new Highchart();
        $ob->chart->renderTo('linechart');  // The #id of the div where to render the chart
        $ob->chart->type('column');
        // $ob->xAxis->categories($categorias);
        $title = $translator->trans('reportes.articulos.title.grupos');
        $yTitle = $translator->trans('reportes.articulos.ytitle.produccion');
        $ob->title->text( $title  );
        $ob->yAxis->title(array('text'  => $yTitle ));
        $ob->series($series);
        return $ob;
    }
}
