<?php

namespace UIFI\GrupLACScraperBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use UIFI\GrupLACScraperBundle\Entity\Gruplac;

/**
 * Controlador que se encarga de manipular el crud de los GrupLAC's
 * @author Cristian Camilo Chaparro Africano <cristianchaparroa@gmail.com>
 *
 * @Route("/admin/configuration/gruplac")
 */
class GruplacController extends Controller
{

    /**
     * Lists all Gruplac entities.
     *
     * @Route("/", name="admin_configuration_gruplac" )
     * @Method("GET")
     */
    public function indexAction()
    {
        $entities =  $this->get('uifi.gruplac.scrap.gruplac')->getGruplacs();
        return $this->render('UIFIGrupLACScraperBundle:Gruplac:index.html.twig'
          ,array('entities' => $entities));
    }
    /**
     * Función que se encarga de verificar si existe un gruplac en el sistema
     * @Route( "/admin/configuration/gruplac/check", name="admin_configuration_gruplac_check", options={"expose"=true} )
     * @Method("POST")
     *
     * @param Codigo  del gruplac a verificar
     * @return JsonResponse
    */
    public function checkGrupLac()
    {
      $parameters = $this->getRequest()->request->all();
      $code = $parameters['code'];
      $success =  $this->get('uifi.gruplac.scrap.gruplac')->existe($code);
      return new JsonResponse(array('success' =>  $success, 'data'=>$code ));
    }

    /**
     * Función que se encarga de verificar si existe un gruplac en el sistema
     * @Route( "/admin/configuration/gruplac/new", name="admin_configuration_gruplac_new", options={"expose"=true} )
     * @Method("POST")
     *
     * @param Código  del gruplac a crear
     * @return JsonResponse
    */
    public function newGruplac(){
      $parameters = $this->getRequest()->request->all();
      $code = $parameters['code'];
      $success =  $this->get('uifi.gruplac.scrap.gruplac')->newGruplac($code);
      $entities =  $this->get('uifi.gruplac.scrap.gruplac')->getGruplacsJSON();
      return new JsonResponse(array('success' =>  $success, 'entities'=>$entities ));
    }

    /**
     * Función que se encarga de eliminar un gruplac del sistema.
     *
     * @Route( "/admin/configuration/gruplac/delete", name="admin_configuration_gruplac_delete", options={"expose"=true} )
     * @Method("POST")
     *
     * @param Codigo  del gruplac a eliminar
     * @return JsonResponse
    */
    public function delete(){
      $parameters = $this->getRequest()->request->all();
      $code = $parameters['code'];
      $success =  $this->get('uifi.gruplac.scrap.gruplac')->delete($code);
      return new JsonResponse(array('success' =>  $success));
    }

}
