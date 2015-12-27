<?php

namespace UIFI\ProductosBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\JsonResponse;
/**
 *  Controlador para listar la información
*/
class ListaConsultoriasCientificaController extends Controller
{
  /**
   * Punto de entrada para los productos de investigacion de la plataforma.
   *
   * @Route("/productos/lista/consultorias_cientifica", name="productos_lista_consultorias_cientifica")
  */
  public function indexAction() {
    $entities =  $this->get('uifi.productos')->getConsultoriaCientificaTecnologica();
    return $this->render('UIFIProductosBundle:Productos:listaArticulos.html.twig',array('entities' => $entities));
  }
}
