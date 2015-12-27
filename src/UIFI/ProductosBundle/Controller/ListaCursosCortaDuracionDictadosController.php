<?php

namespace UIFI\ProductosBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\JsonResponse;
/**
 *  Controlador para listar la información
*/
class ListaCursosCortaDuracionDictadosController extends Controller
{
  /**
   * Punto de entrada para los productos de investigacion de la plataforma.
   *
   * @Route("/productos/lista/cursos_corta_duracion_dictados", name="productos_lista_cursos_corta_duracion_dictados")
  */
  public function indexAction() {
    $entities =  $this->get('uifi.productos')->getCursosCortaDuracionDictados();
    return $this->render('UIFIProductosBundle:Productos:listaArticulos.html.twig',array('entities' => $entities));
  }
}
