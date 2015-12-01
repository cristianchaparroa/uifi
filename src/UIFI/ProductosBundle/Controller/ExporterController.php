<?php

namespace UIFI\ProductosBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

/**
 *  Controlador Exporta Entidades c
*/
class ExporterController extends Controller
{
  public function descargarProductos($filename) {
      $path = $this->container->getParameter('kernel.root_dir').'/../web/productos/' . $filename . '.xls';
      $content = file_get_contents($path);
      $response = new Response();
      $response->headers->set('Content-Type', 'text/xls');
      $response->headers->set('Content-Disposition', 'attachment;filename="'.$filename);
      $response->setContent($content);
      return $response;
  }

  /**
   *
   * @Route("/productos/excel/articulos", name="productos_excel_articulos")
  */
  public function getArticulos() {
    $filename = 'articulos';
    $file =  $this->get('uifi.productos.exporter')->getArticulos($filename);
    return $this->descargarProductos($filename);
  }

  /**
   *
   * @Route("/productos/excel/capitulosLibro", name="productos_excel_capitulos_libro")
  */
  public function getCapitulosLibro() {
    $filename = 'capitulosLibro';
    $file =  $this->get('uifi.productos.exporter')->getCapitulosLibro($filename);
    return $this->descargarProductos($filename);
  }

  /**
   *
   * @Route("/productos/excel/libros", name="productos_excel_libros")
  */
  public function getLibros() {
    $filename = 'libros';
    $file =  $this->get('uifi.productos.exporter')->getLibros($filename);
    return $this->descargarProductos($filename);
  }

  /**
   *
   * @Route("/productos/excel/proyectosDirigidos", name="productos_excel_proyectos_dirigidos")
  */
  public function getProyectosDirigidos() {
    $filename = 'proyectosDirigidos';
    $file =  $this->get('uifi.productos.exporter')->getProyectosDirigidos($filename);
    return $this->descargarProductos($filename);
  }

  /**
   *
   * @Route("/productos/excel/software", name="productos_excel_software")
  */
  public function getSoftware() {
    $filename = 'software';
    $file =  $this->get('uifi.productos.exporter')->getSoftware($filename);
    return $this->descargarProductos($filename);
  }
}
