<?php

namespace UIFI\ProductosBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\JsonResponse;
/**
 *  Controlador para listar la información
*/
class ListaPrototiposController extends Controller
{
  /**
   * Punto de entrada para los productos de investigacion de la plataforma.
   *
   * @Route("/productos/lista/prototipos", name="productos_lista_prototipos")
  */
  public function indexAction() {
    $entities =  $this->get('uifi.productos')->getPrototipos();
    return $this->render('UIFIProductosBundle:Productos:listaArticulos.html.twig',array('entities' => $entities));
  }
}
