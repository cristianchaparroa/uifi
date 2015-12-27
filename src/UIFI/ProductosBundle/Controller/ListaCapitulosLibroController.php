<?php

namespace UIFI\ProductosBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\JsonResponse;
/**
 *  Controlador para listar la información
*/
class ListaCapitulosLibroController extends Controller
{
  /**
   * Punto de entrada para los productos de investigacion de la plataforma.
   *
   * @Route("/productos/lista/capitulos_libro", name="productos_lista_capitulos_libro")
  */
  public function indexAction() {
    $entities =  $this->get('uifi.productos')->getCapitulosLibro();
    return $this->render('UIFIProductosBundle:Productos:listaCapitulosLibro.html.twig',array('entities' => $entities));
  }

}
