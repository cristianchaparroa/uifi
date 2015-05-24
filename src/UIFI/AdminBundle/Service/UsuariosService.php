<?php

namespace UIFI\AdminBundle\Service;

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
   * Obtiene todos los directores de los diferentes grupos de investigación.
   *
   * @return Arreglo de Directores
  */
  public function getUsuarios(){
    $entities = $this->em->getRepository('UsersBundle:Usuario')->findAll();
    return $entities;
  }

  /**
   * Obtiene todos los integrantes que aún no tienen asignado un usuario
   * para logearse en el sistema.
   *
   * @return Arreglo de Integrantes
  */
  public function getIntegrantesSinUsuario(){
    $repo = $this->em->getRepository('UIFIIntegrantesBundle:Integrante');
    $query = $repo
      ->createQueryBuilder('i')
      ->andWhere('i.usuario IS  NULL')
      ->getQuery();
    return $query->getResult();
  }
}
