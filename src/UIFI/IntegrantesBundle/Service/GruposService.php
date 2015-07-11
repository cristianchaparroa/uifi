<?php

namespace UIFI\IntegrantesBundle\Service;

use Symfony\Bundle\DoctrineBundle\Registry;
use Symfony\Component\HttpKernel\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\Container;

use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;

/**
 * @author Cristian Camilo Chaparro A <cristianchaparroa@gmail.com>
*/
class GruposService {

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
   * Obtiene todos los grupos de investigación en el sistema.
   * @return Arreglo json.
  */
  public function getGrupos(){
      $grupoRepository = $this->em->getRepository('UIFIIntegrantesBundle:Grupo');
      $grupos = $grupoRepository->findAll();
      $encoders = array(new JsonEncoder());
      $normalizer = new GetSetMethodNormalizer();
      //el normalizador no funciona con atributos many to many
      //por esta razon se le dice que evite serializar la propiedad
      //integrantes.
      $normalizer->setIgnoredAttributes(array('integrantes'));
      $normalizers = array($normalizer);
      $serializer = new Serializer($normalizers, $encoders);

      $respuesta   = array();
      foreach( $grupos as $grupo ){
        $group = $serializer->serialize($grupo, 'json');
        $respuesta[] = $group;
      }
      return $respuesta;
  }
}
