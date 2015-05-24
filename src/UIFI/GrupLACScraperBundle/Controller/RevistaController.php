<?php

namespace UIFI\GrupLACScraperBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use  UIFI\ProductosBundle\Entity\Document;

class RevistaController extends Controller
{
    /**
     * @Route("/admin/revistas/", name="admin_revistas")
     */
    public function indexAction(){
      $request = $this->getRequest();
      $file = new Document();
      $form = $this->createFormBuilder($file)
          ->add('file')
          ->getForm();
      $form->add('submit', 'submit', array('label' => 'Importar', 'attr' => array('class'=> 'btn btn-success' ) ));
      $form->handleRequest($request);

      if ($form->isValid() )
      {
          $em = $this->getDoctrine()->getManager();
          $file->upload();
          $em->persist($file);
          $em->flush();
          $parameters = array( 'fileId'=>$file->getId() );
          return $this->redirect($this->generateUrl('revistas_importar', $parameters ));
      }
      $parametros = array('form' => $form->createView());
      return $this->render('UIFIGrupLACScraperBundle:Revista:index.html.twig', $parametros );
    }
    /**
     * @Route("/admin/revistas/importar/{fileId}",name="revistas_importar")
     */
    public function importarAction($fileId){
      $this->get('uifi.gruplac.importar.revistas')->importar($fileId);
      echo "termino";
      return new JsonResponse( );
    }



}
