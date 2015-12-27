<?php

namespace UIFI\ProductosBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\JsonResponse;
/**
 *  Controlador para listar la información
*/
class ListaDocumentosTrabajoController extends Controller
{
  /**
   * Punto de entrada para los productos de investigacion de la plataforma.
   *
   * @Route("/productos/lista/documentos_trabajo", name="productos_lista_documentos_trabajo")
  */
  public function indexAction() {
    $entities =  $this->get('uifi.productos')->getDocumentosTrabajo();
    return $this->render('UIFIProductosBundle:Productos:listaArticulos.html.twig',array('entities' => $entities));
  }
}
