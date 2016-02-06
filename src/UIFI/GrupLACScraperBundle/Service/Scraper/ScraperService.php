<?php

namespace UIFI\GrupLACScraperBundle\Service\Scraper;

use Symfony\Bundle\DoctrineBundle\Registry;
use Symfony\Component\HttpKernel\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\Container;


use UIFI\IntegrantesBundle\Entity\Grupo;
use UIFI\IntegrantesBundle\Entity\Integrante;
use UIFI\IntegrantesBundle\Entity\IntegranteProyectoDirigido;
use UIFI\ProductosBundle\Entity\Articulo;
use UIFI\ProductosBundle\Entity\Evento;

/**
 * Servicio que obtiene la información del GrupLAC de Colciencias de los grupos
 * de investigación  y los guarda en la base de datos del sistema.
 *
 * @author Cristian Camilo Chaparro Africano <cristianchaparroa@gmail.com>

*/
class ScraperService {

   public function __construct(Container $container) {
      $this->container = $container;
      $this->em = $container->get('doctrine.orm.entity_manager');
   }
   /**
   * Función que se encarga de obtener la informacion desde el GrupLAC de
   * Colciencias de los grupos selccionados.
   *
   */
   public function scrap($codes) {
     $logger = $this->container->get('logger');
     $this->initDrop();
     $codes = array_unique($codes);
     $numeroGrupos = count($codes);
     if ($numeroGrupos  > 0) {
       //grupoDTO es un arreglo de arreglos
       $gruposDTO  = $this->container->get('uifi.gruplac.service.scraper.grupo')->getGrupos($codes);
       //grupos es un arreglpo de modelos de grupo
       $grupos = $this->container->get('uifi.gruplac.assembler.grupo')->crearLista($gruposDTO);
       foreach($grupos as $grupo) {
         $this->em->persist($grupo);
       }
      //  $integrantessDTO = $this->container->get('uifi.gruplac.service.scraper.integrantes')->getIntegrantes($gruposDTO);
      //  $integrantes = $this->container->get('uifi.gruplac.assembler.integrante')->crearLista($integrantessDTO);
      //  $grupo = NULL;
      //  foreach($integrantes  as $integrante) {
      //   //  if( is_null($grupo) || $grupo->getNombre() !== $integrante->getNombreGrupo()) {
      //        $grupo = $this->container->get('uifi.gruplac.util.collection.grupo')->getGrupo($grupos,$integrante->getNombreGrupo());
      //        if( !is_null($grupo)) {
      //          $integrante->addGrupo($grupo);
      //          $grupo->addIntegrante($integrante);
      //        }
      //   //  }
      //    $this->em->persist($integrante);
      //  }

      //  $proyectosDTO = $this->container->get('uifi.gruplac.service.scraper.proyectosDirigidos')->getProyectosDirigidos($gruposDTO);
      //  $proyectos = $this->container->get('uifi.gruplac.assembler.proyectoDirigido')->crearLista($proyectosDTO);
      //  foreach($proyectos as $proyecto) {
      //     // $autores =  $this->container->get('uifi.gruplac.util.collection.proyectoDirigido')->getAutores($proyectosDTO,$proyecto,$integrantes);
      //     $this->em->persist($proyecto);
      //  }

       $softwareDTO = $this->container->get('uifi.gruplac.service.scraper.software')->getSoftware($gruposDTO);
       $softwares = $this->container->get('uifi.gruplac.assembler.software')->crearLista($softwareDTO);
       foreach($softwares as $software) {
          $this->em->persist($software);
       }

      //  $eventosDTO = $this->container->get('uifi.gruplac.service.scraper.eventos')->getEventos($gruposDTO);
      //  $eventos = $this->container->get('uifi.gruplac.assembler.evento')->crearLista($eventosDTO);
      //  foreach($eventos as $evento) {
      //    $this->em->persist($evento);
      //  }
       $this->em->flush();
     }
     return true;
   }
   /**
    * Función que se encarga de eliminar todos los registros para inicializar
    * las tablas requeridas en el proceso de automatización.
   */
   public function initDrop(){
     $integranteDirectorRepository = $this->em->getRepository('UIFIIntegrantesBundle:IntegranteDirector');
     $integranteDirectorRepository->deleteAll();

     $articuloRepository = $this->em->getRepository('UIFIProductosBundle:Articulo');
     $articuloRepository->deleteAll();

     $integranteRepository = $this->em->getRepository('UIFIIntegrantesBundle:Integrante');
     $integranteRepository->deleteAll();

     $librosRepository = $this->em->getRepository('UIFIProductosBundle:Libro');
     $librosRepository->deleteAll();

     $capitulosLibroRepository = $this->em->getRepository('UIFIProductosBundle:CapitulosLibro');
     $capitulosLibroRepository->deleteAll();

     $softwareRepository = $this->em->getRepository('UIFIProductosBundle:Software');
     $softwareRepository->deleteAll();

     $proyectoDirigidoRepository = $this->em->getRepository('UIFIProductosBundle:ProyectoDirigido');
     $proyectoDirigidoRepository->deleteAll();

     $eventoRepository = $this->em->getRepository('UIFIProductosBundle:Evento');
     $eventoRepository->deleteAll();

     $grupoRepository = $this->em->getRepository('UIFIIntegrantesBundle:Grupo');
     $grupoRepository->deleteAll();

   }
}
