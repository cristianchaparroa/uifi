<?php

namespace UIFI\IntegrantesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;


class DirectorController extends Controller
{
    /**
     * @Route("/director", name="director_home")
     */
    public function IndexAction()
    {
      return  $this->render('UIFIIntegrantesBundle:Director:index.html.twig');
    }
}
