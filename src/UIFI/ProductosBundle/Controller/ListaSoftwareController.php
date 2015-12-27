<?php

namespace UIFI\ProductosBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\JsonResponse;
/**
 *  Controlador para listar la información
*/
class ListaSoftwareController extends Controller
{
  /**
   * Punto de entrada para los productos de investigacion de la plataforma.
   *
   * @Route("/productos/lista/software", name="productos_lista_software")
  */
  public function indexAction() {
    $entities =  $this->get('uifi.productos')->getSoftware();
    return $this->render('UIFIProductosBundle:Productos:listaSoftware.html.twig',array('entities' => $entities));
  }
}
