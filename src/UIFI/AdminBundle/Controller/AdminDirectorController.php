<?php

namespace UIFI\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class AdminDirectorController extends Controller
{
    /**
     * @Route("/admin/director/", name="admin_director")
     */
    public function indexAction()
    {
      $entities =  $this->get('uifi.admin.director')->getDirectores();
      $parametros = array( 'entities' => $entities );
      return  $this->render('UIFIAdminBundle:Director:index.html.twig', $parametros );
    }

}
