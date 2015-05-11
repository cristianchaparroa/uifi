<?php

namespace UIFI\IntegrantesBundle\Service;

use Symfony\Bundle\DoctrineBundle\Registry;
use Symfony\Component\HttpKernel\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\Container;

/**
 * @author Cristian Camilo Chaparro A <cristianchaparroa@gmail.com>
*/
class UsuariosService {

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
  public function getUsuarios($director){
    $integrante = $this->em->getRepository('UIFIIntegrantesBundle:Integrante')
      ->findOneBy( array('usuario'=>$director));
    if( $integrante ){
        $integranteDirector = $this->em->getRepository('UIFIIntegrantesBundle:IntegranteDirector')
            ->findOneBy(array('integrante' => $integrante));
        if($integranteDirector){
          $grupo = $integranteDirector->getGrupo();
          $integrantes = $grupo->getIntegrantes();
          $integrantes = $integrantes->toArray();
          $usuarios = array();
          foreach( $integrantes as $int){
              $usuario = $int->getUsuario();
              if( $usuario ){
                $usuarios[]  = $usuario;
              }
          }

          return array( 'integrante'=>$integrante,'usuarios'=>$usuarios, 'grupo'=>$grupo);
        }
    }
    return null;
  }
}
