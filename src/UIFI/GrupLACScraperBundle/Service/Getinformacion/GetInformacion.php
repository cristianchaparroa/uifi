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


use  UIFI\GrupLACScraperBundle\Service\Getinformacion\CapitulosLibroStore;
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
     $codesIntegrantes = array();
     $repositoryIntegrante = $this->em->getRepository('UIFIIntegrantesBundle:Integrante');
     $repositoryGrupo = $this->em->getRepository('UIFIIntegrantesBundle:Grupo');
     $repositoryArticulo = $this->em->getRepository('UIFIProductosBundle:Articulo');

     foreach( $codes as $code )
     {

       $grupoScraper = new GrupLACScraper($code);
       $grupo  = new Grupo();
       $grupo->setId( $code );
       $grupo->setGruplac( $grupoScraper->getURL() );
       $nombreGrupo =  "". $grupoScraper->getNombreGrupo();
       $grupo->setNombre( $nombreGrupo );
       $grupo->setEmail( $grupoScraper->extraerEmail() );
       $grupo->setClasificacion( $grupoScraper->extraerClasificacion() );
       $this->em->persist( $grupo );
       $this->em->flush();
       $entityGrupo = $grupo;
       //
       $integrantes    = $grupoScraper->obtenerIntegrantes();
       $articulos      = $grupoScraper->getArticulos();
       $libros         = $grupoScraper->getLibros();
       $capituloslibro = $grupoScraper->getCapitulosLibros();

       $stores = array();
       $stores[] = new IntegrantesStore($this->em,$grupo, $integrantes);
       $stores[] = new ArticulosStore($this->em,$grupo, $articulos);
       $stores[] = new LibrosStore($this->em,$grupo, $libros);
       $stores[] = new CapitulosLibroStore($this->em,$grupo,$capituloslibro);

       /*Procesa todos las tiendas de informacion extraidas*/
       foreach( $stores as $store ){
         $store->guardar();
       }
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

     $capitulosLibroRepository = $this->em->getRepository('UIFIProductosBundle:CapitulosLibro');
     $capitulosLibroRepository->deleteAll();

     $grupoRepository = $this->em->getRepository('UIFIIntegrantesBundle:Grupo');
     $grupoRepository->deleteAll();
   }

}