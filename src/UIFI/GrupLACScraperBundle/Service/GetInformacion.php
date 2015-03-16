<?php


namespace UIFI\GrupLACScraperBundle\Service;


use Symfony\Bundle\DoctrineBundle\Registry;
use Symfony\Component\HttpKernel\Log\LoggerInterface;
use UIFI\GrupLACScraperBundle\Core\PageGrupLACScraper;
use UIFI\GrupLACScraperBundle\Core\IndividualCVLACScraper;
use Symfony\Component\DependencyInjection\Container;

use UIFI\IntegrantesBundle\Entity\Grupo;
use UIFI\IntegrantesBundle\Entity\Integrante;
use UIFI\ProductosBundle\Entity\Articulo;
/**
 * Servicio que obtiene la información del GrupLAC de Colciencias de los grupos
 * de investigación  y los guarda en la base de datos del sistema.
*/
class GetInformacion
{
   /**
   * Porcentaje del calculo del proceso de la importación de la información del
   * gruplac a la base del sistema.
   */
   private $percent = 0;
   /**
    * Constructor
   */
   public function __construct(Container $container)
   {
      $this->container = $container;
      $this->em = $container->get('doctrine.orm.entity_manager');
   }
   /**
    * Función que se encarga obtener toda la información de GrupLAC y
    * guardala información respectivamente en la base de datos.
    *
    * @return Valor booleano que indica el estado de la operación.
    *         True indica que la operación fue completada satisfactoriamente.
   */
   public function scrap()
   {
     $this->initDrop();
     /**
      * Se obtiene los codigos de los grupos de investigacion para luego crear
      * los diferentes scrapers.
     */
    //  $codes = array(   '00000000002325', '00000000008915' ,
    //  '00000000000883', '00000000013666', '00000000000902', '00000000005998',
    //  '00000000000891', '00000000009042', '00000000000877', '00000000013887',
    //  '00000000001394', '00000000006950', '00000000006950', '00000000013573' ,
    //  '00000000000871', '00000000005315', '00000000000879', '00000000006176' ,
    //  '00000000000858', '00000000000888', '00000000006360', '00000000003328');

    $codes = array(   '00000000002325','00000000008915','00000000000883', '00000000013666',);
     $total = count($codes);
     $currentTask = 0;
     foreach( $codes as $code )
     {
      // $this->percent = intval($currentTask/$total * 100)."%";
       $grupoScraper = new PageGrupLACScraper($code);

       /**
        * Registro el grupo de investigación en el sistema
       */
       $grupo  = new Grupo();
       $grupo->setSerial( $code );
       $grupo->setGruplac( $grupoScraper->getURL() );
       $nombreGrupo =  "". $grupoScraper->getNombreGrupo();
       $grupo->setNombre( $nombreGrupo );
       $grupo->setEmail( $grupoScraper->extraerEmail() );
       $grupo->setClasificacion( $grupoScraper->extraerClasificacion() );
       $this->em->persist( $grupo );
       $this->em->flush();

       //Se obtiene el grupo recién generado de la base de datos
       $repositoryGrupo = $this->em->getRepository('UIFIIntegrantesBundle:Grupo');
       $entityGrupo = $repositoryGrupo->find($code);

       $integrantes = $grupoScraper->obtenerIntegrantes();

       /**
        * Se obtiene la información de cada integrante
       */
       foreach( $integrantes as $codeIntegrante => $nombreIntegrante)
       {

          $integranteScraper = new IndividualCVLACScraper( $codeIntegrante );
          /**
           * Se crea al entitidad Integrante y se registra toda la información
           * asociada.
          */
          $integrante = new Integrante();
          /**
           * se debe establecer alguna manera para que el usuario tenga acceso a
           * su usuario y por ende a su plataforma para verificar la
           * información en el sistema.
          */
          //$integrante->setUsuario();
          $cvlacIntegrante = $integranteScraper->getURL();
          $integrante->setGrupo( $entityGrupo );
          $integrante->setCvlac( $cvlacIntegrante );
          $integrante->setNombres( $nombreIntegrante );
          //se setea la demas información posible.
          $this->em->persist( $integrante );
          $this->em->flush();
          //Se obtiene el estudiante recien generado de la base de datos


          $repositoryIntegrante = $this->em->getRepository('UIFIIntegrantesBundle:Integrante');
          $entityIntegrante = $repositoryIntegrante->find($codeIntegrante);
          /**
           *se registran los articulos asociados a un integrante.
           */
          $articulos =  $integranteScraper->procesarArticulos();
          foreach( $articulos as $articulo){
            $article = new Articulo();
            $article->setTitulo($articulo['titulo']);
            $article->setEditorial($articulo['editorial']);
            $article->setISSN($articulo['ISSN']);
            $article->setPalabras($articulo['palabras']);
            $article->addIntegrante($entityIntegrante);

            $this->em->persist($article);
            $this->em->flush();
          }
       }
       $currentTask++;
     }
     return true;
   }
   /**
    * Función que retorna el progreso de processo
    * @return Integer valor del progreso.
   */
   public function progress(){
     $this->percent = $this->percent+1;
     return $this->percent;
   }
   /**
    * Función que se encarga de eliminar todos los registros para inicializar
    * las tablas requeridas en el proceso de automatización.
   */
   public function initDrop(){
     $articuloRepository = $this->em->getRepository('UIFIProductosBundle:Articulo');
     $articuloRepository->deleteAll();
     $integranteRepository = $this->em->getRepository('UIFIIntegrantesBundle:Integrante');
     $integranteRepository->deleteAll();
     $grupoRepository = $this->em->getRepository('UIFIIntegrantesBundle:Grupo');
     $grupoRepository->deleteAll();
   }

}
