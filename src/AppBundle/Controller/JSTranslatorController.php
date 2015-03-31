<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\JsonResponse;

class JSTranslatorController extends Controller
{

  /**
   * Función que se encarga de emplear locale con los archivos javascript.
   *
   * @Route( "/api/translation",name="js_translate", options={"expose"=true} )
   * @Method("POST")
   *
   * @param  $path, Path del identificador de la cadena a traducir.
   * @return JsonResponse
  */
  public function translate()
  {
    $translator = $this->get('translator');
    $parameters = $this->getRequest()->request->all();
    $path = $parameters['path'];
    $translate =  $translator->trans( $path );
    $success= false;
    if( $translate ){
      $success = true;
    }
    return new JsonResponse(array( 'success'=>$success,  'translation' => $translate  ));
  }
}
