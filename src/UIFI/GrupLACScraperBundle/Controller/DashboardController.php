<?php

namespace UIFI\GrupLACScraperBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\JsonResponse;
/**
 *  El dashboard de la aplicación para controlar la automatización de la
 *  Extración de la información del GrupLAC de los grupos de investigación
 *  configurados previamente.
*/
class DashboardController extends Controller
{
    /**
     * @Route("/gruplac/dashboard", name="gruplac_dashboard")
     */
    public function indexAction()
    {
        return  $this->render('UIFIGrupLACScraperBundle:Dashboard:index.html.twig');
    }

    /**
     *  Función que se encarga de crear el proceso de Scrap de información
     *  de los diferentes grupos de investigación desde el GrupLAC de colciencias.
     *
     *  @Route( "/api/gruplac/getInformacion", name="dasboard_get_informacion", options={"expose"=true} )
    */
    public function getInformacion()
    {
        $success = $this->get('uifi.gruplac.scrap.getinfo')->scrap();
        return new JsonResponse(array('success' =>  $success ));
    }

    /**
     *  Función que se encarga de crear el proceso de Scrap de información
     *  de los diferentes grupos de investigación desde el GrupLAC de colciencias.
     *
     *  @Route( "/api/gruplac/getProgress", name="dasboard_get_progress", options={"expose"=true} )
    */
    public function getProgress()
    {
      $porcentaje = $this->get('uifi.gruplac.scrap.getinfo')->progress();
      return new JsonResponse(array('porcentaje' =>  $porcentaje ));
    }

}
