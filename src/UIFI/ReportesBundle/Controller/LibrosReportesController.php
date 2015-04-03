<?php

namespace UIFI\ReportesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use UIFI\ReportesBundle\Form\ReportesType;
use Symfony\Component\HttpFoundation\JsonResponse;

class LibrosReportesController extends Controller
{
    /**
     * @Route("/reportes/libros", name="reportes_libros")
     */
    public function indexAction()
    {
      $em = $this->getDoctrine()->getManager();
      $grupos = $em->getRepository('UIFIIntegrantesBundle:Grupo')->findAll();
      $form = $this->get('form.factory')->create(new ReportesType($grupos) );
      $view =  $form->createView();
      $parameters = array('form' => $view, 'ruta'=>'reportes_libros_graficar');
      return  $this->render('UIFIReportesBundle:LibrosReportes:index.html.twig',$parameters);
    }

    /**
      * Función que se encarga de generar el reporte de acuerdo de los parámetros
      * seleccionados por el usuario.
      *
      * @Route("/reportes/libros/graficar",name="reportes_libros_graficar")
      * @param Request
      * @return Template
    */
     public function graficarAction()
     {
        $this->em = $this->getDoctrine()->getManager();
        $parameters = $this->getRequest()->request->all();
        $mapParameters = $parameters['uifi_reportes'];
        $ob =  $this->get('uifi.reportes.libros')->generarGrafica( $mapParameters );
        $parametros = array('chart' => $ob );
        return $this->render('UIFIReportesBundle:LibrosReportes:reporte.html.twig',$parametros);
     }
}
