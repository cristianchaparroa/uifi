<?php

namespace UIFI\ReportesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use UIFI\ReportesBundle\Form\ReportesType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;



/**
 * Controllador que se encarga de mostrar los reportes referentes al software
 * desarrollado en un grupo de investigiacion.
*/
class ProyectosDirigidosReportesControllerController extends Controller
{
    /**
     * Función que muestra el formulario para filtrar la información relacionada
     * con el software de la facultad.
     *
     * @Route("/reportes/proyectos_dirigidos", name="reportes_proyectos_dirigidos")
     */
    public function indexAction(){
        $em = $this->getDoctrine()->getManager();
        $grupos = $em->getRepository('UIFIIntegrantesBundle:Grupo')->findAll();
        $form = $this->get('form.factory')->create(new ReportesType($grupos) );
        $view =  $form->createView();
        $parameters = array('form' => $view, 'ruta'=> 'reportes_proyectos_dirigidos_graficar' );
        return  $this->render('UIFIReportesBundle:ProyectosDirigidosReportes:index.html.twig',$parameters);
    }

    /**
     * Función que se encarga de generar el reporte de acuerdo de los parámetros
     * seleccionados por el usuario.
     *
     * @Route("/reportes/proyectos_dirigidos/graficar",name="reportes_proyectos_dirigidos_graficar")
     * @param Request
     * @return Template
    */
    public function graficarAction(){
        $this->em = $this->getDoctrine()->getManager();
        $parameters = $this->getRequest()->request->all();
        $mapParameters = $parameters['uifi_reportes'];
        $ob =  $this->get('uifi.reportes.proyectosdirigidos')->generarGrafica( $mapParameters );
        $parameters = array( 'chart' => $ob );
        return $this->render('UIFIReportesBundle:ProyectosDirigidosReportes:reporte.html.twig',$parameters );
    }
}
