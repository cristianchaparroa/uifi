<?php

namespace UIFI\IntegrantesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;


class DirectorIntegrantesController extends Controller
{
    /**
     * @Route("/director/integrantes", name="director_integrantes")
     */
    public function IndexAction(){
      $director = $this->get('security.token_storage')->getToken()->getUser();
      $result = $this->get('uifi.integrantes.integrantes')->getIntegrantes($director);
      $parametros = array(
        'entities' => $result['integrantes'],
        'grupo'=>$result['grupo'],
        'director'=>$result['integrante']
      );
      return  $this->render('UIFIIntegrantesBundle:Integrantes:index.html.twig',$parametros);
    }
}
