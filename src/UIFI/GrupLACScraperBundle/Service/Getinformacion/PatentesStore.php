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
use UIFI\ProductosBundle\Entity\Patente;
/**
 * Servicio que obtiene la información del GrupLAC de Colciencias de los articulos
 * de investigación  y los guarda en la base de datos del sistema.
 *
 * @author Cristian Camilo Chaparro Africano <cristianchaparroa@gmail.com>
*/
class PatentesStore implements IStore
{
  /**
   * Constructor
   * @param $em Entity Manager del sistema
   * @param $grupo del cual se va a extraer los integrantes
   * @param $articulos Lista de artículos scrapeados del GrupLAC.
  */
  public function __construct( $em, $grupo, $patentes){
    $this->em = $em;
    $this->grupo = $grupo;
    $this->patentes = $patentes;
    $this->repositoryIntegrante = $this->em->getRepository('UIFIIntegrantesBundle:Integrante');
  }


  public function guardar(){
    $patentesGrupo = $this->patentes;
    $index = 0;
    foreach($patentesGrupo as $patente )
    {
      $codeArticulo =  $this->grupo->getId() ."-". $index;
      $autores  = $patente['autores'];

      $patente = new Patente();
      $patente ->setTitulo($patente['titulo']);
      $patente ->setAnual( $patente['anual'] );
      $patente ->setGrupo( $this->grupo->getId() );
      $this->em->persist( $patente  );
      $this->em->flush();
      foreach( $autores as $autor )
      {
         $nombres = strtoupper(substr($autor,1));
         $resultIntegrante  = $this->repositoryIntegrante->findBy( array('nombres' => $nombres) );
         if( count(  $resultIntegrante  )>0 ){
             $entityIntegrante =   $resultIntegrante[0];
             $entityIntegrante->addPatente($article);
             $this->em->persist($entityIntegrante);
             $this->em->flush();
             $this->em->persist( $patente  );
             $this->em->flush();
         }
      }
      $index++;
    }
  }
}
