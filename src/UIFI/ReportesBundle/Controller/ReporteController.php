<?php

namespace UIFI\ReportesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use UIFI\ReportesBundle\Form\ArticuloReportesType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;


class ReporteController extends Controller{
  /**
   * Función que se encarga de filtrar la información de acuerdo de los
   * parámetros seleccionados por el usuario.
   *
   * @Route("/reportes/filtrar", name="reportes_filtrar", options={"expose":true} )
   * @Method("GET")
   * @param Request
   * @return JsonResponse
  */
  public function filterAction(){
      $params = $this->getRequest()->query->all();
      $codeGrupo = $params['grupo'];
      if($codeGrupo!==''){
          $integrantes =  $this->get('uifi.reportes.articulos')->getIntegrantes( $codeGrupo );
          return new JSONResponse( array('success' => true, 'integrantes'=>$integrantes)  );
      }
      return new JSONResponse( array('success'=>false) );
  }
}
