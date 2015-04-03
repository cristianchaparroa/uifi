<?php


namespace UIFI\GrupLACScraperBundle\Service;


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
class GetInformacion
{
   const PROCESO_AUTOMATICO = 'AUTOMATICO';
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
         $grupoScraper = new GrupLACScraper($code);
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

         foreach( $integrantes as $codeIntegrante => $result )
         {
            $nombreIntegrante = $result['nombre'];
            $integranteScraper = new CVLACScraper( $codeIntegrante );
            //  //si existe el integrante,significa que pertenece a varios grupos
            $existIntegrante = $repositoryIntegrante->find($codeIntegrante);
            if($existIntegrante){
                $entityIntegrante = $existIntegrante;
            }
            else{

               $integrante = new Integrante();
               $cvlacIntegrante = $integranteScraper->getURL();
               $integrante->addGrupo( $entityGrupo );
               $integrante->setId( $cvlacIntegrante );
               $integrante->setCodigoGruplac( $integranteScraper->getCode()  );
               $integrante->setNombres( strtoupper($nombreIntegrante) );
               //se setea la demas información posible.
               $this->em->persist( $integrante );
               $entityIntegrante = $repositoryIntegrante->find($codeIntegrante);
            }
            $entityGrupo->addIntegrante($entityIntegrante);
            $this->em->persist($entityGrupo);
         }

         //se obtiene los articulos publicados en el grupo
         $articulosGrupo  = $grupoScraper->getArticulos();
         $index = 0;
         foreach($articulosGrupo as $articulo )
         {
           $codeArticulo =  $code ."-". $index;
           $autores  = $articulo['autores'];
           $article = new Articulo();
           $article->setId( $codeArticulo  );
           $article->setTitulo($articulo['titulo']);
           $article->setAnual( $articulo['anual'] );

           $article->setGrupo( $code );
           $this->em->persist( $article );
           $this->em->flush();
           foreach( $autores as $autor )
           {
              $nombres = strtoupper(substr($autor,1));
              $resultIntegrante  = $repositoryIntegrante->findBy( array('nombres' => $nombres) );

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
         $librosGrupo  = $grupoScraper->getLibros();


         foreach($librosGrupo as $libro)
         {

            $autores  = $libro['autores'];
            $ebook = new Libro();
            $ebook->setTitulo($libro['titulo']);
            $ebook->setAnual( $libro['anual'] );
            $ebook->setIsbn( $libro['ISBN'] );
            $ebook->setGrupo( $code );
            $ebook->setPais( $libro['pais'] );
            $this->em->persist( $ebook );
            $this->em->flush();

            foreach( $autores as $autor )
            {
               $nombres = strtoupper(substr($autor,1));
               $resultIntegrante  = $repositoryIntegrante->findBy( array('nombres' => $nombres) );

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
