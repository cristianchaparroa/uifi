<?php


namespace UIFI\GrupLACScraperBundle\Service\Getinformacion;


use Symfony\Bundle\DoctrineBundle\Registry;
use Symfony\Component\HttpKernel\Log\LoggerInterface;
use UIFI\GrupLACScraperBundle\Core\GrupLACScraper;
use UIFI\GrupLACScraperBundle\Core\CVLACScraper;
use Symfony\Component\DependencyInjection\Container;

use UIFI\IntegrantesBundle\Entity\Grupo;
use UIFI\IntegrantesBundle\Entity\Integrante;
use UIFI\ProductosBundle\Entity\Articulo;
use UIFI\ProductosBundle\Entity\Libro;
/**
 * Servicio que obtiene la información del GrupLAC de Colciencias de los integrantes
 * de investigación  y los guarda en la base de datos del sistema.
 *
 * @author Cristian Camilo Chaparro Africano <cristianchaparroa@gmail.com>
*/
class IntegrantesStore implements IStore
{
  /**
   * Constructor
   * @param $em Entity Manager del sistema
   * @param $grupo del cual se va a extraer los integrantes
   * @param $integrantes Lista de integrantes scrapeados del GrupLAC.
  */
  public function __construct( $em, $grupo, $integrantes){
    $this->em = $em;
    $this->grupo = $grupo;
    $this->integrantes = $integrantes;
    $this->repositoryIntegrante = $this->em->getRepository('UIFIIntegrantesBundle:Integrante');
  }
  /**
   * Función que se encarga persistirla los integrantes
   * en la base de datos del sistema.
  */
  public function guardar()
  {
    $integrantes = $this->integrantes;
    foreach( $integrantes as $codeIntegrante => $result ){
       $nombreIntegrante = $result['nombre'];
       $vinculacion = $result['vinculacion'];
       $integranteScraper = new CVLACScraper( $codeIntegrante );
       $existIntegrante = $this->repositoryIntegrante->find($codeIntegrante);
       if($existIntegrante){
           $entityIntegrante = $existIntegrante;
       }
       else{
          $integrante = new Integrante();
          $cvlacIntegrante = $integranteScraper->getURL();
          $integrante->addGrupo( $this->grupo );
          $integrante->setId( $cvlacIntegrante );
          $integrante->setCodigoGruplac( $integranteScraper->getCode()  );
          $integrante->setNombres( $nombreIntegrante );
          //se setea la demas información posible.
          $this->em->persist( $integrante );
          $this->em->flush();
          $entityIntegrante = $this->repositoryIntegrante->find($codeIntegrante);
       }

       $this->grupo->addIntegrante($entityIntegrante);
       $this->em->persist($this->grupo);
    }
  }
}
