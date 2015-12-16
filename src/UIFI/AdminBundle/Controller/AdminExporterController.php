<?php

namespace UIFI\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

/**
 *  Controlador los integrantes en el sistema para el adminsitrador del sistema.
*/
class AdminExporterController extends Controller
{
  public function descargar($filename) {
      $path = $this->container->getParameter('kernel.root_dir').'/../web/integrantes/' . $filename . '.xls';
      $content = file_get_contents($path);
      $response = new Response();
      $response->headers->set('Content-Type', 'text/xls');
      $response->headers->set('Content-Disposition', 'attachment;filename="'.$filename);
      $response->setContent($content);
      return $response;
  }

  /**
   *
   * @Route("/admin/integrantes/excel/all", name="admin_integrantes_excel_all")
  */
  public function getAllIntegrantes() {
    $filename = 'integrantes';
    $file =  $this->get('uifi.integrantes.exporter')->getAllIntegrantes($filename);
    return $this->descargar($filename);
  }
}
