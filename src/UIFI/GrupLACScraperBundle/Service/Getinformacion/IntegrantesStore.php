<?php


namespace UIFI\GrupLACScraperBundle\Service\Getinformacion;


use Symfony\Bundle\DoctrineBundle\Registry;
use Symfony\Component\HttpKernel\Log\LoggerInterface;
use UIFI\GrupLACScraperBundle\Core\GrupLACScraper;
use UIFI\GrupLACScraperBundle\Core\CVLACScraper;
use Symfony\Component\DependencyInjection\Container;

use UIFI\IntegrantesBundle\Entity\Grupo;
use UIFI\IntegrantesBundle\Entity\Integrante;
use UIFI\IntegrantesBundle\Entity\IntegranteDirector;
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
  public function __construct( $em, $grupo, $integrantes,$logger){
    $this->em = $em;
    $this->grupo = $grupo;
    $this->integrantes = $integrantes;
    $this->repositoryIntegrante = $this->em->getRepository('UIFIIntegrantesBundle:Integrante');
    $this->logger = $logger;
  }
  /**
   * Función que se encarga persistirla los integrantes
   * en la base de datos del sistema.
  */
  public function guardar() {
    $this->logger->err('Guardando integrantes...');
    $start = microtime(true);
    $integrantes = $this->integrantes;
    $numeroIntegrantes = count($integrantes);
    $this->logger->err('numero de integrantes: '.$numeroIntegrantes);
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
          $integrante->setNombreGrupo( $this->grupo->getNombre());
          $integrante->setNombres( $nombreIntegrante );


          //se setea la demas información posible.
          $this->em->persist( $integrante );
          // $this->em->flush();
          $entityIntegrante = $this->repositoryIntegrante->find($codeIntegrante);

          //se verifica si es director si es asi entonces se genera la
          //relacion entre el integrante y el grupo.
          if($this->esDirector($this->grupo,$nombreIntegrante)){
            $integranteDirector = new IntegranteDirector();
            $integranteDirector->setGrupo($this->grupo);
            $integranteDirector->setIntegrante($entityIntegrante);
            $this->em->persist( $integranteDirector );
            // $this->em->flush();
          }
       }

       $this->grupo->addIntegrante($entityIntegrante);
       $this->em->persist($this->grupo);
    }
    $time_elapsed_secs = microtime(true) - $start;
    $this->logger->err('tiempo de procesamienti de integrantes: '.$time_elapsed_secs);
  }

  /**
   * TODO: Verificar si con el nombre de un integrante es el director
   * del grupo que se esta procesando.
   *
   * @param $grupo que se esta procesando.
   * @param $nombreIngrente que se esta procesando
   *
   * @return Estado de la verificación.
  */
  private function esDirector($grupo, $nombreIntegrante){
    $nombreIntegrante = str_replace(' ', '', $nombreIntegrante );
    $grupoScraper = new GrupLACScraper( $grupo->getId() );
    $nombreDirector = $grupoScraper->extraerLider();
    $nombreDirector = str_replace(' ','', $nombreDirector );
    return  strtolower($nombreDirector) === strtolower($nombreIntegrante);
  }
}
