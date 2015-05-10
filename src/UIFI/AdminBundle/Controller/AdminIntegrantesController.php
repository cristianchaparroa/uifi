<?php

namespace UIFI\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class AdminIntegrantesController extends Controller
{
    /**
     * @Route("/admin/integrantes/", name="admin_integrantes")
     */
    public function indexAction()
    {
      $entities =  $this->get('uifi.admin.integrantes')->getIntegrantes();
      $parametros = array( 'entities' => $entities );
      return  $this->render('UIFIAdminBundle:Integrantes:index.html.twig', $parametros );
    }

}
