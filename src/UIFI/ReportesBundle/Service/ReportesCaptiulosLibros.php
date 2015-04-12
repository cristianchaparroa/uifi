<?php

namespace UIFI\ReportesBundle\Service;

use Symfony\Component\DependencyInjection\Container;
use Ob\HighchartsBundle\Highcharts\Highchart;
use Zend\Json\Expr;

use UIFI\GrupLACScraperBundle\Core\PageGrupLACScraper;

/**
 * Lógica que permite generar la gráfica de reportes Artículos.
 * @author: Cristian Camilo Chaparro Africano <cristianchaparroa@gmail.com>
*/
class ReportesCaptiulosLibros extends Reporte
{
    /**
     * Constructor
    */
    public function __construct(Container $container)
    {
       $this->container = $container;
       $this->em = $container->get('doctrine.orm.entity_manager');
       $this->translator = $container->get('translator');
       $repository = $this->em->getRepository('UIFIProductosBundle:CapitulosLibro');

       $titulos = array(
         'grupo'            =>'Produccion de Capitulos de  Libros por grupos de Investigación',
         'grupoAnual'       =>'Produccion de Capitulos de  Libros por grupos de Investigación discriminados por año',
         'totalFecha'       =>"Producción de Capitulos de Libros en la Facultad por Año",
         'grupoIntegrantes' =>'Produccion de Capitulos de Libros por Integrante en el grupo ',
         'grupoFecha'       => 'Produccion de Capitulos de Libros discriminados por año en el grupo ',
         'entidad'          => 'Capitulos de Libros',
       );
       Reporte::__construct( $titulos, $repository);
    }
}
