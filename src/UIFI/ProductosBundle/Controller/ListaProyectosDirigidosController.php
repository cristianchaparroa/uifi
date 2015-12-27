<?php

namespace UIFI\ProductosBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\JsonResponse;
/**
 *  Controlador para listar la información
*/
class ListaProyectosDirigidosController extends Controller
{
  /**
   * Punto de entrada para los productos de investigacion de la plataforma.
   *
   * @Route("/productos/lista/proyectos_dirigidos", name="productos_lista_proyectos_dirigidos")
  */
  public function indexAction() {
    $entities =  $this->get('uifi.productos')->getProyectosDirigidos();
    return $this->render('UIFIProductosBundle:Productos:listaProyectosDirigidos.html.twig',array('entities' => $entities));
  }
}
