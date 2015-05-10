<?php

namespace UIFI\IntegrantesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller
{
    /**
     * @Route("/director")
     */
    public function indexAction($name)
    {
      return  $this->render('UIFIGrupLACIntegrantesBundle:Director:index.html.twig');
    }
}
