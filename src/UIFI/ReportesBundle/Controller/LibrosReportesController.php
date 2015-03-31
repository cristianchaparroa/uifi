<?php

namespace UIFI\ReportesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class LibrosReportesController extends Controller
{
    /**
     * @Route("/reportes/libros", name="reportes_libros")
     */
    public function indexAction()
    {
      return  $this->render('UIFIReportesBundle:LibrosReportes:index.html.twig');
    }

}
