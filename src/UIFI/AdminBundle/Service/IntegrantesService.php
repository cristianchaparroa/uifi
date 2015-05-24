<?php

namespace UIFI\AdminBundle\Service;

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
   * Obtiene todos los directores de los diferentes grupos de investigación.
   *
   * @return Arreglo de Directores
  */
  public function getIntegrantes(){
    $entities = $this->em->getRepository('UIFIIntegrantesBundle:Integrante')->findAll();
    return $entities;
  }
}
