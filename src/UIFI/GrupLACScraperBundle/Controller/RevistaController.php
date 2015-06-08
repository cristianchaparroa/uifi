<?php

namespace UIFI\GrupLACScraperBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

use UIFI\ProductosBundle\Entity\Document;

class RevistaController extends Controller
{
    /**
     * Funcion que muestra la página para subir un archivo CSV.
     *
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
     * Funcion que se encarga de importar las revistas y asignarle la categoria
     * especifica.
     *
     * @param fieldID Identificador del Archivo CSV que se importo
     *
     * @Route("/admin/revistas/importar/{fileId}",name="revistas_importar")
     */
    public function importarAction($fileId){
      $this->get('uifi.gruplac.importar.revistas')->importar($fileId);
      return $this->redirect($this->generateUrl('revistas_lista' ));
    }

    /**
     * Función que redirige a la lista de revistas de indexación.
     *
     * @Route("/admin/revistas/lista",name="revistas_lista")
     * @Method("POST")
    */
    public function listaAction(){
      return $this->render('UIFIGrupLACScraperBundle:Revista:lista.html.twig');
    }
    /**
     * Función que redirige a la lista de revistas de indexación.
     *
     * @Route("/admin/revistas/getlistarevistas",name="revistas_getlistarevista")
     * @Method("POST")
    */
    public function getListaRevistas(){
      $revistas = $this->get('uifi.gruplac.revistas')->listar();
      $parametros = array( 'revistas' => $revistas );
      return new JsonResponse( $parametros );
    }

    /**
   * Displays a form to create a new Operador entity.
   *
   * @Route("/admin/revistas/download",name="revistas_descargar")
   * @Method("GET")
   */
  public function downloadAction()
  {
    return   $this->get('uifi.gruplac.importar.revistas')->download();
  }




}
