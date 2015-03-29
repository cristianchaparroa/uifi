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
         $codeArticulo =  $code . $index;
         $autores  = $articulo['autores'];
         $article = new Articulo();
         $article->setId($codeArticulo  );
         $article->setTitulo($articulo['titulo']);
         $fecha = new \DateTime( $articulo['anual'] );
         $article->setFecha($fecha);
         $article->setGrupo( $entityGrupo );

         $this->em->persist( $article );
         $this->em->flush();
         foreach( $autores as $autor )
         {
            $nombres = strtoupper(substr($autor,1));
            $resultIntegrante  = $repositoryIntegrante->findBy( array('nombres' => $nombres) );
            if( count(  $resultIntegrante  )>0 ){
                $entityIntegrante =   $resultIntegrante[0];
                $entityArticulo = $repositoryArticulo->find($codeArticulo);
                $entityIntegrante->addArticulo($entityArticulo);
                $this->em->persist($entityIntegrante);
                $this->em->flush();
            }
         }
         $this->em->persist( $article );
         $index++;
       }
       $currentTask++;
     }
     $this->em->flush();
     return true;
   }

   private function contains($text, $word)
   {
        $found = false;
        $spaceArray = explode(' ', $text);

        $nonBreakingSpaceArray = explode(chr(160), $text);

        if (in_array($word, $spaceArray) ||
            in_array($word, $nonBreakingSpaceArray)
           ) {

            $found = true;
        }
        return $found;
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
