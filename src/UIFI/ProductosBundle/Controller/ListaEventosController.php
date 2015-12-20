<?php

namespace UIFI\ProductosBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\JsonResponse;
/**
 *  Controlador para listar la información
*/
class ListaEventosController extends Controller
{
  /**
   * Punto de entrada para los productos de investigacion de la plataforma.
   *
   * @Route("/productos/eventos", name="productos_eventos")
  */
  public function indexAction() {
    $entities =  $this->get('uifi.productos')->getEventos();
    return $this->render('UIFIProductosBundle:Productos:listaEventos.html.twig',array('entities' => $entities));
  }
}
