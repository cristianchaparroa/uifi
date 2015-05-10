<?php

namespace UIFI\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class AdminUsuariosController extends Controller
{
    /**
     * @Route("/admin/usuarios/", name="admin_usuarios")
     */
    public function indexAction()
    {
      $entities =  $this->get('uifi.admin.usuarios')->getUsuarios();
      $parametros = array( 'entities' => $entities );
      return  $this->render('UIFIAdminBundle:Usuarios:index.html.twig', $parametros );
    }

}
