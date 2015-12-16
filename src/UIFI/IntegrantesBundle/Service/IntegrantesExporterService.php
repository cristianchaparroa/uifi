<?php



namespace UIFI\IntegrantesBundle\Service;

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
class IntegrantesExporterService {

      public function __construct(Container $container)
      {
         $this->container = $container;
         $this->em = $container->get('doctrine.orm.entity_manager');
      }

      /**
       * Obtiene la lista de  integrantes en formato XLS.
       * @param $fileName,  Nombre del achivo con que se genera el XLS.
       * @return Archivo XLS
      */
      public function getAllIntegrantes($fileName) {
        $entities = $this->em->getRepository('UIFIIntegrantesBundle:Integrante')->findAll();
        $path = $this->container->getParameter('kernel.root_dir').'/../web/integrantes';
        $className = 'UIFI\IntegrantesBundle\Entity\Integrante';
        $headers = array( "SERIAL", "GRUPO", "NOMBRES");
        $properties = array('id','nombreGrupo','nombres');
        $excelExporter = new ExcelExporter();
        $file = $excelExporter->getXLS($path,$fileName,$className, $headers,$properties,$entities);
        return $file;
      }
}
