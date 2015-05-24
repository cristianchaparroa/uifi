<?php

namespace UIFI\AdminBundle\Service;

use Symfony\Bundle\DoctrineBundle\Registry;
use Symfony\Component\HttpKernel\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\Container;

/**
 * @author Cristian Camilo Chaparro A <cristianchaparroa@gmail.com>
*/
class DirectorService {

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
   * Obtiene todos los directores de los diferentes grupos de investigación.
   *
   * @return Arreglo de Directores
  */
  public function getDirectores(){
    $entities = $this->em->getRepository('UIFIIntegrantesBundle:IntegranteDirector')->findAll();
    return $entities;
  }

  /**
   * Crea un usuario en el sistema.
   * Este usa la funcionalidad de FOSUserBundle
   *
   * @param $idIntegrante
   * @param $email
   * @return
  */
  public function crearUsuario( $idIntegrante, $email){
    $userManager = $this->container->get('fos_user.user_manager');
    $result = $this->container->get('uifi.users')->crearUsuario($idIntegrante,$email,'ROLE_DIRECTOR');
    $integrante = $this->em->getRepository('UIFIIntegrantesBundle:Integrante')->find( $idIntegrante );
    if( $integrante ){
        $integrante->setUsuario( $result['user'] );
        $this->em->persist($integrante);
        $this->em->flush();
    }
    $this->sendEmail( $integrante->getNombres(), $email, $result['password'] );
    return $integrante;
  }
  /**
   * Función que se encarga de enviar un email
   * @param $nombre
   * @param $email
   * @param $password
   *
  */
  public function sendEmail( $nombres, $email, $password ){
      $parametros = array(
        'email'    => $email,
        'nombres'  => $nombres,
        'password' => $password
      );
      $message = \Swift_Message::newInstance()
         ->setSubject('Usuario UIFI')
         ->setFrom('noreply@uifi.com')
         ->setTo( $email )
         ->setBody(
           $this->container->get('templating')->render(
           'UIFIAdminBundle:Director:email.txt.twig', $parametros)
         );

      $this->container->get('mailer')->send($message);
  }

}
