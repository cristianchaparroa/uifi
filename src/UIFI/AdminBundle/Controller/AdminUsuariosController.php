<?php

namespace UIFI\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use UIFI\IntegrantesBundle\Form\UsuarioIntegranteType;

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


    /**
     * @Route("/admin/usuarios/nuevo", name="admin_usuarios_nuevo")
     */
    public function newAction()
    {
      $integrantes =  $this->get('uifi.admin.usuarios')->getIntegrantesSinUsuario();
      $form = $this->get('form.factory')->create(new UsuarioIntegranteType($integrantes) );
      $parametros = array( 'form' => $form->createView() );
      return  $this->render('UIFIAdminBundle:Usuarios:new.html.twig', $parametros );
    }
}
