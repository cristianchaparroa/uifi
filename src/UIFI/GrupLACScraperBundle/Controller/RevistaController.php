<?php

namespace UIFI\GrupLACScraperBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class RevistaController extends Controller
{
    /**
     * @Route("/admin/revistas/")
     */
    public function indexAction(){
      return $this->render('UIFIGrupLACScraperBundle:Revista:index.html.twig');
    }
    /**
     * @Route("/admin/revistas/importar",name="revistas_importar")
     */
    public function importarAction(Request $request){
      $files = $this->getRequest()->files;
      echo json_encode($files);

      $this->get('uifi.gruplac.importar.revistas')->importar();
      return new JsonResponse( );
    }

}
