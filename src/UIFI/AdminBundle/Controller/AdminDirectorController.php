<?php

namespace UIFI\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;


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

    /**
     * Función que se encarga de crear un usuario para un IntegranteDirector
     *
     * @Route("/admin/director/crear", name="admin_director_crear",  options={"expose"=true} )
     * @Method("POST")
     *
     * @param idDirector identificador del director seleccionado por el administrador.
     * @param email asignado por el administrador
    */
    public function createUsuarioDirector(){
      $parameters = $this->getRequest()->request->all();
      $idDirector = $parameters['codigo'];
      $email = $parameters['email'];
      $usuario =  $this->get('uifi.admin.director')->crearUsuario($idDirector,$email);
      $success = ( $usuario ? true: false);
      return new JsonResponse(array('success' =>  $success));
    }

    /**
    * Función que se encarga de verificar si un email ya existe en la
    * plataforma
    * @Route("/admin/director/verificaremail", name="admin_director_verificaremail",  options={"expose"=true} )
    * @Method("POST")
    *
    * @param email a verficar
    * @return JSON response con el estado de la validación
    */
    public function verificarEmail(){
      $parameters = $this->getRequest()->request->all();
      $email = $parameters['email'];
      $success = $this->container->get('uifi.users')->verificarEmail($email);
      return new JsonResponse(array('success' =>  $success));
    }

}
