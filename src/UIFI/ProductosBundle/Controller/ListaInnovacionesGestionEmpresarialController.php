<?php

namespace UIFI\ProductosBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\JsonResponse;
/**
 *  Controlador para listar la información
*/
class ListaInnovacionesGestionEmpresarialController extends Controller
{
  /**
   * Punto de entrada para los productos de investigacion de la plataforma.
   *
   * @Route("/productos/lista/innovacion_gestionEmpresarial", name="productos_lista_innovaciones_gestion_empresarial")
  */
  public function indexAction() {
    $entities =  $this->get('uifi.productos')->getInnovacionGestionEmpreserial();
    return $this->render('UIFIProductosBundle:Productos:listaArticulos.html.twig',array('entities' => $entities));
  }
}
