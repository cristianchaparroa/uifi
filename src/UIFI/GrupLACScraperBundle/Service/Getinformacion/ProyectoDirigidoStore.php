<?php


namespace UIFI\GrupLACScraperBundle\Service\Getinformacion;


use Symfony\Bundle\DoctrineBundle\Registry;
use Symfony\Component\HttpKernel\Log\LoggerInterface;
use UIFI\GrupLACScraperBundle\Core\GrupLACScraper;
use UIFI\GrupLACScraperBundle\Core\CVLACScraper;
use Symfony\Component\DependencyInjection\Container;

use UIFI\IntegrantesBundle\Entity\Grupo;
use UIFI\IntegrantesBundle\Entity\Integrante;
use UIFI\ProductosBundle\Entity\ProyectoDirigido;

/**
 * Servicio que obtiene la información del GrupLAC de Colciencias de los articulos
 * de investigación  y los guarda en la base de datos del sistema.
 *
 * @author Cristian Camilo Chaparro Africano <cristianchaparroa@gmail.com>
*/
class ProyectoDirigidoStore implements IStore
{
  /**
   * Constructor
   * @param $em Entity Manager del sistema
   * @param $grupo del cual se va a extraer los integrantes
   * @param $proyectos Lista de proyectos dirigidos scrapeados del GrupLAC.
  */
  public function __construct( $em, $grupo, $proyectos){
    $this->em = $em;
    $this->grupo = $grupo;
    $this->proyectos = $proyectos;
    $this->repositoryIntegrante = $this->em->getRepository('UIFIIntegrantesBundle:Integrante');
  }


  public function guardar(){
    $proyectosGrupo = $this->proyectos;
    foreach($proyectosGrupo as $proyecto ) {
      $autores  = $proyecto['autores'];
      $project = new ProyectoDirigido();
      $project->setTitulo($proyecto['titulo']);
      $project->setAnual( $proyecto['anualInicial'] );
      $project->setTipo( $proyecto['tipo'] );
      $project->setGrupo( $this->grupo->getId() );
      $project->setNombreEstudiante(  $proyecto['nombreEstudiante']  );
      $project->setTipoOrientacion( $proyecto['tipoOrientacion'] );
      $project->setProyectoAcademico( $proyecto['proyectoAcademico'] );
      $project->setValoracion(  $proyecto['valoracion']  );
      $project->setNumeroPaginas(  intval($proyecto['numeroPaginas'] ) );
      $project->setInstitucion(  $proyecto['institucion']  );

      $this->em->persist( $project );
      $this->em->flush();

      foreach( $autores as $autor )
      {
         $nombres = strtoupper(substr($autor,1));
         $resultIntegrante  = $this->repositoryIntegrante->findBy( array('nombres' => $nombres) );
         if( count(  $resultIntegrante  )>0 ){
             $entityIntegrante =   $resultIntegrante[0];
             $entityIntegrante->addProyectosDirigido($project);
             $this->em->persist($entityIntegrante);
             $this->em->flush();
             $this->em->persist( $project );
             $this->em->flush();
         }
      }
    }

  }
}
