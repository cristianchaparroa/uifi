<?php

namespace UIFI\ReportesBundle\Service;

use Symfony\Component\DependencyInjection\Container;
use Ob\HighchartsBundle\Highcharts\Highchart;
use Zend\Json\Expr;

use UIFI\GrupLACScraperBundle\Core\PageGrupLACScraper;

/**
 * Lógica que permite generar la gráfica de reportes de Software.
 * @author: Cristian Camilo Chaparro Africano <cristianchaparroa@gmail.com>
*/
class ReportesProyectosDirigidos extends Reporte
{
    /**
     * Constructor
    */
    public function __construct(Container $container)
    {
       $this->container = $container;
       $this->em = $container->get('doctrine.orm.entity_manager');
       $this->translator = $container->get('translator');
       $repository = $this->em->getRepository('UIFIProductosBundle:ProyectoDirigido');
       $titulos = array(
         'grupo'            =>'Producción de Proyectos dirigidos por grupos de Investigación',
         'grupoAnual'       =>'Producción de Proyectos dirigidos  por grupos de Investigación discriminados por año',
         'totalFecha'       =>"Producción de Proyectos en la Facultad por Año",
         'grupoIntegrantes' =>'Producción de Proyectos por Integrante en el grupo ',
         'grupoFecha'       =>'Producción de Proyectos discriminados por año en el grupo ',
         'entidad'          =>'Libros',
       );
       Reporte::__construct( $titulos, $repository);
    }
}
