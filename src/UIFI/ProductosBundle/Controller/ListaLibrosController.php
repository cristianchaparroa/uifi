<?php

namespace UIFI\ProductosBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\JsonResponse;
/**
 *  Controlador para listar la información
*/
class ListaLibrosController extends Controller
{
  /**
   * Punto de entrada para los productos de investigacion de la plataforma.
   *
   * @Route("/productos/libros", name="productos_libros")
  */
  public function indexAction() {
    $entities =  $this->get('uifi.productos')->getLibros();
    return $this->render('UIFIProductosBundle:Productos:listaLibros.html.twig',array('entities' => $entities));
  }
}
