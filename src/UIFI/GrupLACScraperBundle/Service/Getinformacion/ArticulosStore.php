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
 * Servicio que obtiene la información del GrupLAC de Colciencias de los articulos
 * de investigación  y los guarda en la base de datos del sistema.
 *
 * @author Cristian Camilo Chaparro Africano <cristianchaparroa@gmail.com>
*/
class ArticulosStore implements IStore
{
  /**
   * Constructor
   * @param $em Entity Manager del sistema
   * @param $grupo del cual se va a extraer los integrantes
   * @param $articulos Lista de artículos scrapeados del GrupLAC.
  */
  public function __construct( $em, $grupo, $articulos){
    $this->em = $em;
    $this->grupo = $grupo;
    $this->articulos = $articulos;
    $this->repositoryIntegrante = $this->em->getRepository('UIFIIntegrantesBundle:Integrante');
  }


  public function guardar(){
    $articulosGrupo = $this->articulos;
    $index = 0;
    foreach($articulosGrupo as $articulo )
    {
      $codeArticulo =  $this->grupo->getId() ."-". $index;
      $autores  = $articulo['autores'];
      $article = new Articulo();
      $article->setId( $codeArticulo  );
      $article->setTitulo($articulo['titulo']);
      $article->setAnual( $articulo['anual'] );
      $article->setISSN( $articulo['issn'] );
      $article->setGrupo( $this->grupo->getId() );
      $this->em->persist( $article );
      $this->em->flush();
      foreach( $autores as $autor ) {
         $nombres = strtoupper(substr($autor,1));
         $resultIntegrante  = $this->repositoryIntegrante->findBy( array('nombres' => $nombres) );
         if( count(  $resultIntegrante  )>0 ){
             $entityIntegrante =   $resultIntegrante[0];
             $entityIntegrante->addArticulo($article);
             $this->em->persist($entityIntegrante);
             $this->em->flush();
             $this->em->persist( $article );
             $this->em->flush();
         }
      }
      $index++;
    }//end for articulos

  }
}
