<?php

namespace UIFI\IntegrantesBundle\Service;

use Symfony\Bundle\DoctrineBundle\Registry;
use Symfony\Component\HttpKernel\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\Container;

/**
 * @author Cristian Camilo Chaparro A <cristianchaparroa@gmail.com>
*/
class IntegrantesService {

  /**
   * Constructor de la clase.
   *
   * @param Container
   *
  */
  public function __construct(Container $container)
  {
     $this->container = $container;
     $this->em = $container->get('doctrine.orm.entity_manager');
  }

  /**
   * Obtiene todos los integrantes que pertenecen a un grupo de investigacion.
   *
   * @param $director Usuario que es director y esta en el sistema.
   *
   * @return Arreglo de Directores
  */
  public function getIntegrantes($director){
    $integrante = $this->em->getRepository('UIFIIntegrantesBundle:Integrante')
      ->findOneBy( array('usuario'=>$director));
    if( $integrante ){
        $integranteDirector = $this->em->getRepository('UIFIIntegrantesBundle:IntegranteDirector')
            ->findOneBy(array('integrante' => $integrante));
        if($integranteDirector){
          $grupo = $integranteDirector->getGrupo();
          $integrantes = $grupo->getIntegrantes();
          return array( 'integrante'=>$integrante,'integrantes'=>$integrantes, 'grupo'=>$grupo);
        }
    }
    return null;
  }
}
