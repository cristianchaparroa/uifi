<?php


namespace UIFI\GrupLACScraperBundle\Service\Getinformacion;


use Symfony\Bundle\DoctrineBundle\Registry;
use Symfony\Component\HttpKernel\Log\LoggerInterface;
use UIFI\GrupLACScraperBundle\Core\GrupLACScraper;
use UIFI\GrupLACScraperBundle\Core\CVLACScraper;
use Symfony\Component\DependencyInjection\Container;

use UIFI\IntegrantesBundle\Entity\Grupo;
use UIFI\IntegrantesBundle\Entity\Integrante;
use UIFI\ProductosBundle\Entity\Software;
/**
 * Servicio que obtiene la información del GrupLAC de Colciencias de los articulos
 * de investigación  y los guarda en la base de datos del sistema.
 *
 * @author Cristian Camilo Chaparro Africano <cristianchaparroa@gmail.com>
*/
class SoftwareStore implements IStore
{
  /**
   * Constructor
   * @param $em Entity Manager del sistema
   * @param $grupo del cual se va a extraer los integrantes
   * @param $articulos Lista de artículos scrapeados del GrupLAC.
  */
  public function __construct( $em, $grupo, $software){
    $this->em = $em;
    $this->grupo = $grupo;
    $this->software = $software;
    $this->repositoryIntegrante = $this->em->getRepository('UIFIIntegrantesBundle:Integrante');
  }


  public function guardar(){
    $softwareGrupo = $this->software;
    foreach($softwareGrupo as $software )
    {
      $autores  = $software['autores'];
      $soft = new Software();
      $soft->setTitulo($software['titulo']);
      $soft->setAnual( $software['anual'] );
      $soft->setGrupo( $this->grupo->getId() );
      $this->em->persist( $soft );
    //  $this->em->flush();
      foreach( $autores as $autor )
      {
         $nombres = strtoupper(substr($autor,1));
         $resultIntegrante  = $this->repositoryIntegrante->findBy( array('nombres' => $nombres) );

         if( count(  $resultIntegrante  )>0 ){
             $entityIntegrante =   $resultIntegrante[0];
             $entityIntegrante->addSoftware($soft);
             $this->em->persist($entityIntegrante);
             //$this->em->flush();
             $this->em->persist( $soft );
             //$this->em->flush();
         }
         //si no existe que lo cree.
         else{
           
         }
      }
      $this->em->flush(); // Persist objects that did not make up an entire batch
      $this->em->clear();

    }

  }
}
