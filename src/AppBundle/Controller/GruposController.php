<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\JsonResponse;

class GruposController extends Controller{

  /**
   * @Route( "app/api/grupos",name="app_list_grupos",options={"expose"=true})
   */
  public function getListGrupos(){
    $grupos = $this->get('uifi.integrantes.grupos')->getGrupos();
    return new JsonResponse( $grupos );
  }

  /**
   * @Route("/grupos",name="app_grupos_index",options={"expose"=true})
   */
  public function indexAction(){
    return  $this->render('AppBundle:Grupos:index.html.twig');
  }
}
