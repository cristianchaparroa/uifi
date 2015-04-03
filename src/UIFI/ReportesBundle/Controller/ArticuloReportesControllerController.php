<?php

namespace UIFI\ReportesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use UIFI\ReportesBundle\Form\ArticuloReportesType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

use Ob\HighchartsBundle\Highcharts\Highchart;
use Zend\Json\Expr;

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
        $parameters = array('form' => $view, 'ruta'=> 'reportes_articulos_graficar' );
        return  $this->render('UIFIReportesBundle:ArticuloReportes:index.html.twig',$parameters);
    }

    /**
     * Función que se encarga de generar el reporte de acuerdo de los parámetros
     * seleccionados por el usuario.
     *
     * @Route("/reportes/articulos/graficar",name="reportes_articulos_graficar")
     * @param Request
     * @return Template
    */
    public function graficarAction()
    {
        $this->em = $this->getDoctrine()->getManager();
        $parameters = $this->getRequest()->request->all();
        $mapParameters = $parameters['uifi_reportes_articulo'];
        $ob =  $this->get('uifi.reportes.articulos')->generarGrafica( $mapParameters );
        return $this->render('UIFIReportesBundle:ArticuloReportes:reporte.html.twig', array(
            'chart' => $ob
        ));
    }
    /**
     * Función que se encarga de filtrar la información de acuerdo de los
     * parámetros seleccionados por el usuario.
     *
     * @Route("/reportes/articulos/filtrar", name="reportes_articulos_filtrar", options={"expose":true} )
     * @Method("GET")
     * @param Request
     * @return JsonResponse
    */
    public function filterAction()
    {
        $params = $this->getRequest()->query->all();
        $codeGrupo = $params['grupo'];
        if($codeGrupo!=='')
        {
            $integrantes =  $this->get('uifi.reportes.articulos')->getIntegrantes( $codeGrupo );
            return new JSONResponse( array('success' => true, 'integrantes'=>$integrantes)  );
        }
        return new JSONResponse( array('success'=>false) );
    }

}
