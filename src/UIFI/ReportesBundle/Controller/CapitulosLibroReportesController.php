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
 * Controlador que se encarga de mostrar los reportes referentes a los
 * capitulos de libors generados por un grupo de investigación.
 *
 * @author Cristian Camilo Chaparro <cristianchaparroa@gmail.com>
*/
class CapitulosLibroReportesController extends Controller
{
  /**
   * Función que muestra el formulario para filtrar la información relacionada
   * con los artículos de la facultad.
   *
   * @Route("/reportes/capituloslibros", name="reportes_capituloslibros")
   */
  public function indexAction(){
      $em = $this->getDoctrine()->getManager();
      $grupos = $em->getRepository('UIFIIntegrantesBundle:Grupo')->findAll();
      $form = $this->get('form.factory')->create(new ReportesType($grupos) );
      $view =  $form->createView();
      $parameters = array('form' => $view, 'ruta'=> 'reportes_capituloslibros_graficar' );
      return  $this->render('UIFIReportesBundle:CapitulosLibrosReportes:index.html.twig',$parameters);
  }

  /**
   * Función que se encarga de generar el reporte de acuerdo de los parámetros
   * seleccionados por el usuario.
   *
   * @Route("/reportes/capituloslibros/graficar",name="reportes_capituloslibros_graficar")
   * @param Request
   * @return Template
  */
  public function graficarAction(){
      $this->em = $this->getDoctrine()->getManager();
      $parameters = $this->getRequest()->request->all();
      $mapParameters = $parameters['uifi_reportes'];
      $ob =  $this->get('uifi.reportes.capituloslibros')->generarGrafica( $mapParameters );
      $parameters =  array(  'chart' => $ob );
      return $this->render('UIFIReportesBundle:CapitulosLibrosReportes:reporte.html.twig',$parameters);
  }
}
