<?php



namespace UIFI\ProductosBundle\Service;

use Symfony\Bundle\DoctrineBundle\Registry;
use Symfony\Component\HttpKernel\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\Container;

use UIFI\ProductosBundle\Core\ExcelExporter;


/**
 * Servicio que se encarga de obtener informacion acerca de los productos de
 * Investigacion y generar un archivo de excel a exportar.
 *
 * @author Cristian Chaparro Africano <cristianchaparroa@gmail.com>
*/
class ProductosExporterService
{

      public function __construct(Container $container)
      {
         $this->container = $container;
         $this->em = $container->get('doctrine.orm.entity_manager');
      }

      /**
       * Obtiene la lista de articulos en formato XLS, con la siguiente informacion.
       * ISSN,TITULO
       * @param $fileName,  Nombre del achivo con que se genera el XLS.
       * @return Archivo XLS
      */
      public function getArticulos($fileName) {
        $entities = $this->em->getRepository('UIFIProductosBundle:Articulo')->findAll();
        $path = $this->container->getParameter('kernel.root_dir').'/../web/productos';
        $className = 'UIFI\ProductosBundle\Entity\Articulo';
        $headers = array( "ISSN", "TITULO" );
        $properties = array('ISSN','titulo');
        $excelExporter = new ExcelExporter();
        $file = $excelExporter->getXLS($path,$fileName,$className, $headers,$properties,$entities);
        return $file;
      }

      /**
       * Obtiene la lista de Capitulos de Libro en formato XLS, con la siguiente
       * informacion:
       *  isbn,titulo
       *
       * @param $fileName,  Nombre del achivo con que se genera el XLS.
       * @return Archivo XLS
      */
      public function getCapitulosLibro($fileName) {
        $entities = $this->em->getRepository('UIFIProductosBundle:CapitulosLibro')->findAll();
        $path = $this->container->getParameter('kernel.root_dir').'/../web/productos';
        $className = 'UIFI\ProductosBundle\Entity\CapitulosLibro';
        $headers = array( "ISSN", "TITULO" );
        $properties = array('isbn','titulo');
        $excelExporter = new ExcelExporter();
        $file = $excelExporter->getXLS($path,$fileName,$className, $headers,$properties,$entities);
        return $file;
      }

}
