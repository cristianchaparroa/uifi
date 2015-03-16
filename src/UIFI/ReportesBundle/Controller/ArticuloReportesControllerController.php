<?php

namespace UIFI\ReportesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use UIFI\ReportesBundle\Filter\ArticuloReportesFilterType;

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
      $form = $this->get('form.factory')->create(new ArticuloReportesFilterType($grupos) );
      $view =  $form->createView();
      $parameters = array('form' => $view);
      return  $this->render('UIFIReportesBundle:ArticuloReportes:index.html.twig',$parameters);
    }
}
