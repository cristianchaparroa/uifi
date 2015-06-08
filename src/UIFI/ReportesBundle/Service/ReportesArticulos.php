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
class ReportesArticulos extends Reporte
{
    /**
     * Constructor
    */
    public function __construct(Container $container)
    {
       $this->container = $container;
       $this->em = $container->get('doctrine.orm.entity_manager');
       $this->translator = $container->get('translator');
       $repository = $this->em->getRepository('UIFIProductosBundle:Articulo');
       $titulos = array(
         'grupo'            =>'Producción de  Artículos por grupos de Investigación',
         'grupoAnual'       =>'Producción de  Artículos por grupos de Investigación discriminados por año',
         'totalFecha'       =>"Producción de Artículos en la Facultad por Año",
         'grupoIntegrantes' =>'Producción de artículos por Integrante en el grupo ',
         'grupoFecha'       => 'Produccion de artículos discriminados por año en el grupo ',
         'entidad'          => 'Articulos',
       );
       Reporte::__construct( $titulos, $repository);
    }
}
