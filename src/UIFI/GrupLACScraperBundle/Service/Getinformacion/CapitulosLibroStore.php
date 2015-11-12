<?php


namespace UIFI\GrupLACScraperBundle\Service\Getinformacion;


use Symfony\Bundle\DoctrineBundle\Registry;
use Symfony\Component\HttpKernel\Log\LoggerInterface;
use UIFI\GrupLACScraperBundle\Core\GrupLACScraper;
use UIFI\GrupLACScraperBundle\Core\CVLACScraper;
use Symfony\Component\DependencyInjection\Container;
use UIFI\ProductosBundle\Entity\CapitulosLibro;
/**
 * Servicio que obtiene la información  de los capítulos de Libros
 * del GrupLAC de Colciencias de los grupos de investigación  y los guarda
 * en la base de datos del sistema.
 *
 * @author Cristian Camilo Chaparro Africano <cristianchaparroa@gmail.com>
*/
class CapitulosLibroStore implements IStore
{
  /**
   * Constructor
   * @param $em Entity Manager del sistema
   * @param $grupo del cual se va a extraer los integrantes
   * @param $libros Lista de libros scrapeados del GrupLAC.
  */
  public function __construct( $em, $grupo, $capitulos){
    $this->em = $em;
    $this->grupo = $grupo;
    $this->capitulos = $capitulos;
    $this->repositoryIntegrante = $this->em->getRepository('UIFIIntegrantesBundle:Integrante');
  }

  /**
   * Fución que guarda la informacion de los capítulos de libros scrapeados
  */
  public function guardar()
  {
    foreach($this->capitulos as $capitulo )
    {
       /**
        * Registro los capitulos de libro
       */
       $autores  = $capitulo['autores'];
       $chapter = new CapitulosLibro();
       $chapter->setTitulo($capitulo['titulo']);
       $chapter->setAnual( $capitulo['anual'] );
       $chapter->setIsbn(  array_key_exists('isbn',$capitulo) ? $capitulo['isbn'] : "" );
       $chapter->setPais( $capitulo['pais'] );
       //Indico el grupo al cual pertenece el capítulo de libro.
       $chapter->setGrupo( $this->grupo->getId() );
       $this->em->persist( $chapter );
       $this->em->flush();
       //Agrego los autores a los cuales pertence el capitulo de libro
       foreach( $autores as $autor )
       {
          $nombres = strtoupper(substr($autor,1));
          $resultIntegrante  = $this->repositoryIntegrante->findBy( array('nombres' => $nombres) );
          if( count(  $resultIntegrante  )>0 ){
              $entityIntegrante =   $resultIntegrante[0];
              $entityIntegrante->addCapituloslibro($chapter);
              $this->em->persist($entityIntegrante);
              $this->em->flush();
              $this->em->persist( $chapter );
              $this->em->flush();
          }
       }
    }//endforeach
  }
}
