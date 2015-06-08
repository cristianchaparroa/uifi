<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\JsonResponse;

class AppController extends Controller
{

  /**
   * Función que se encarga de redireccionar la raíz de la aplicación al login
   *
   * @Route( "/" , name="root")
   *
  */
  public function indexAction()
  {
      //return $this->redirect($this->generateUrl('login'));
      return $this->render('AppBundle::index.html.twig');

  }
}
