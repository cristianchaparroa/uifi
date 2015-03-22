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
 *
 * @author Cristian Camilo Chaparro Africano <cristianchaparroa@gmail.com>
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
     $repositoryGruplac = $this->em->getRepository('UIFIGrupLACScraperBundle:Gruplac');
     $codes = $repositoryGruplac->getAllCodes();
     $codes = array_unique($codes);
     $total = count($codes);
     $currentTask = 0;
     $codesIntegrantes = array();
     $repositoryIntegrante = $this->em->getRepository('UIFIIntegrantesBundle:Integrante');
     $repositoryGrupo = $this->em->getRepository('UIFIIntegrantesBundle:Grupo');
     $repositoryArticulo = $this->em->getRepository('UIFIProductosBundle:Articulo');

     foreach( $codes as $code )
     {
       $grupoScraper = new PageGrupLACScraper($code);
       /**
        * Registro el grupo de investigación en el sistema
       */
       $grupo  = new Grupo();
       $grupo->setId( $code );
       $grupo->setGruplac( $grupoScraper->getURL() );
       $nombreGrupo =  "". $grupoScraper->getNombreGrupo();
       $grupo->setNombre( $nombreGrupo );
       $grupo->setEmail( $grupoScraper->extraerEmail() );
       $grupo->setClasificacion( $grupoScraper->extraerClasificacion() );
       $this->em->persist( $grupo );
       //$this->em->flush();

       $entityGrupo = $grupo;
       $integrantes = $grupoScraper->obtenerIntegrantes();
       /**
        * Se obtiene la información de cada integrante
       */
       foreach( $integrantes as $codeIntegrante => $nombreIntegrante)
       {
          $integranteScraper = new IndividualCVLACScraper( $codeIntegrante );
           //si existe el integrante,significa que pertenece a varios grupos
          $existIntegrante = $repositoryIntegrante->find($codeIntegrante);
          if($existIntegrante){
              $entityIntegrante = $existIntegrante;
          }
          else{

             $integrante = new Integrante();
             $cvlacIntegrante = $integranteScraper->getURL();
             $integrante->addGrupo( $entityGrupo );
             $integrante->setId( $cvlacIntegrante );
             $integrante->setNombres( $nombreIntegrante );
             //se setea la demas información posible.
             $this->em->persist( $integrante );
             $this->em->flush();
             $entityIntegrante = $repositoryIntegrante->find($codeIntegrante);
          }

          $entityGrupo->addIntegrante($entityIntegrante);
          $this->em->persist($entityGrupo);
          //$this->em->flush();

          /**
           *se registran los articulos asociados a un integrante.
           */
          $articulos =  $integranteScraper->procesarArticulos();
          $index = 0;
          foreach( $articulos as $articulo){
            $article = new Articulo();
            $codeArticulo = $code ."-". $integranteScraper->getCode() ."-". $index;
            $article->setId($codeArticulo );
            $article->setTitulo($articulo['titulo']);
            $article->setEditorial($articulo['editorial']);
            $article->setISSN($articulo['ISSN']);
            $article->setPalabras($articulo['palabras']);
            $article->addIntegrante($entityIntegrante);
            $anual = str_replace(' ', '', $articulo['anual']);
            $anual = '01/01/'.$anual;
            $fecha = new \DateTime($anual);
            $article->setFecha($fecha);
            $this->em->persist($article);

            $entityIntegrante->addArticulo($article);
            $this->em->persist($article);

            $index++;
          }
       }
       $currentTask++;
     }
     $this->em->flush();
     return true;
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
