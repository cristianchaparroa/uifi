<?php

namespace UIFI\IntegrantesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;


class DirectorUsuariosController extends Controller
{
    /**
     * @Route("/director/usuarios", name="director_usuarios")
     */
    public function IndexAction(){
      $director = $this->get('security.token_storage')->getToken()->getUser();
      $result = $this->get('uifi.integrantes.usuarios')->getUsuarios($director);
      $parametros = array(
        'entities' => $result['usuarios'],
        'grupo'=>$result['grupo'],
        'director'=>$result['integrante']
      );
      return  $this->render('UIFIIntegrantesBundle:Usuarios:index.html.twig',$parametros);
    }
}
