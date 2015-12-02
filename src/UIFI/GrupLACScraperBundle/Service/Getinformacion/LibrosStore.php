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
 * Servicio que obtiene la información del GrupLAC de Colciencias de los grupos
 * de investigación  y los guarda en la base de datos del sistema.
 *
 * @author Cristian Camilo Chaparro Africano <cristianchaparroa@gmail.com>
*/
class LibrosStore implements IStore
{
  /**
   * Constructor
   * @param $em Entity Manager del sistema
   * @param $grupo del cual se va a extraer los integrantes
   * @param $libros Lista de libros scrapeados del GrupLAC.
  */
  public function __construct( $em, $grupo, $libros){
    $this->em = $em;
    $this->grupo = $grupo;
    $this->libros = $libros;
    $this->repositoryIntegrante = $this->em->getRepository('UIFIIntegrantesBundle:Integrante');
  }

  /**
   *
  */
  public function guardar() {
    $librosGrupo = $this->libros;
    foreach($librosGrupo as $libro)
    {
       $autores  = $libro['autores'];
       $ebook = new Libro();
       $ebook->setTitulo($libro['titulo']);
       $ebook->setAnual( $libro['anual'] );
       $ebook->setIsbn( $libro['ISBN'] );
       $ebook->setGrupo( $this->grupo->getId() );
       $ebook->setPais( $libro['pais'] );
       $this->em->persist( $ebook );
       $this->em->flush();

       foreach( $autores as $autor )
       {
          $nombres = strtoupper(substr($autor,1));
          $resultIntegrante  = $this->repositoryIntegrante->findBy( array('nombres' => $nombres) );
          if( count(  $resultIntegrante  )>0 ){
              $entityIntegrante =   $resultIntegrante[0];
              $entityIntegrante->addLibro($ebook);
              $this->em->persist($entityIntegrante);
              $this->em->flush();
              $this->em->persist( $ebook );
              $this->em->flush();
          }
       }
    }//end for libros
  }
}
