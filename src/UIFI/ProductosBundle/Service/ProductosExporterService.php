<?php



namespace UIFI\ProductosBundle\Service;

use Symfony\Bundle\DoctrineBundle\Registry;
use Symfony\Component\HttpKernel\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\Container;

use UIFI\ProductosBundle\Core\ExcelExporter\ExcelExporter;


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
        $headers = array( "ISSN", "GRUPO", "TITULO" , "AÑO",  "TIPO", "PAIS" ,"REVISTA","VOLUMEN","FASC","PAGINAS","INTEGRANTES");
        $properties = array('ISSN','nombreGrupo','titulo','anual','tipo','pais','revista','volumen','fasciculo','paginas','integrantes');
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
        $headers = array(   "ISBN", "GRUPO",      "TIPO","TITULO", "PAIS", "AÑO",   "LIBRO",      "VOLUMEN", "PAGINAS", "EDITORIAL", "AUTORES");
        $properties = array('isbn', 'nombreGrupo','tipo','titulo', 'pais', 'anual', 'tituloLibro','volumen', 'paginas', 'editorial', 'integrantes');
        $excelExporter = new ExcelExporter();
        $file = $excelExporter->getXLS($path,$fileName,$className, $headers,$properties,$entities);
        return $file;
      }

      /**
       * Obtiene la lista de Libros en formato XLS, con la siguiente
       * informacion:
       *  isbn,titulo
       *
       * @param $fileName,  Nombre del achivo con que se genera el XLS.
       * @return Archivo XLS
      */
      public function getLibros($fileName) {
        $entities = $this->em->getRepository('UIFIProductosBundle:Libro')->findAll();
        $path = $this->container->getParameter('kernel.root_dir').'/../web/productos';
        $className = 'UIFI\ProductosBundle\Entity\Libro';
        $headers = array( "ISSN", "TITULO", "TIPO","PAIS","AÑO","VOLUMEN","PAGINAS","EDITORIAL" );
        $properties = array('isbn','titulo','tipo','pais','anual','volumen','paginas','editorial');
        $excelExporter = new ExcelExporter();
        $file = $excelExporter->getXLS($path,$fileName,$className, $headers,$properties,$entities);
        return $file;
      }

      /**
       * Obtiene la lista de Libros en formato XLS, con la siguiente
       * informacion:
       *  isbn,titulo
       *
       * @param $fileName,  Nombre del achivo con que se genera el XLS.
       * @return Archivo XLS
      */
      public function getProyectosDirigidos($fileName) {
        $entities = $this->em->getRepository('UIFIProductosBundle:ProyectoDirigido')->findAll();
        $path = $this->container->getParameter('kernel.root_dir').'/../web/productos';
        $className = 'UIFI\ProductosBundle\Entity\ProyectoDirigido';
        $headers = array( "TIPO", "TITULO" );
        $properties = array('tipo','titulo');
        $excelExporter = new ExcelExporter();
        $file = $excelExporter->getXLS($path,$fileName,$className, $headers,$properties,$entities);
        return $file;
      }

      /**
       * Obtiene la lista de Libros en formato XLS, con la siguiente
       * informacion:
       *  isbn,titulo
       *
       * @param $fileName,  Nombre del achivo con que se genera el XLS.
       * @return Archivo XLS
      */
      public function getSoftware($fileName) {
        $entities = $this->em->getRepository('UIFIProductosBundle:Software')->findAll();
        $path = $this->container->getParameter('kernel.root_dir').'/../web/productos';
        $className = 'UIFI\ProductosBundle\Entity\Software';
        $headers = array( "AÑO", "TITULO" );
        $properties = array('anual','titulo');
        $excelExporter = new ExcelExporter();
        $file = $excelExporter->getXLS($path,$fileName,$className, $headers,$properties,$entities);
        return $file;
      }

}
