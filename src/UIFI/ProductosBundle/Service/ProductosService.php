<?php



namespace UIFI\ProductosBundle\Service;

use Symfony\Bundle\DoctrineBundle\Registry;
use Symfony\Component\HttpKernel\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\Container;

/**
 * Servicio que se encarga de obtener informacion acerca de los productos de
 * Investigacion.
 * gruplacs.
 *
 * @author Cristian Chaparro Africano <cristianchaparroa@gmail.com>
*/
class ProductosService
{
    public function __construct(Container $container)
    {
       $this->container = $container;
       $this->em = $container->get('doctrine.orm.entity_manager');
    }

    public function getArticulos() {
      $entities = $this->em->getRepository('UIFIProductosBundle:Articulo')->findAll();
      return $entities;
    }

    public function getCapitulosLibro() {
      $entities = $this->em->getRepository('UIFIProductosBundle:CapitulosLibro')->findAll();
      return $entities;
    }

    public function getProyectosDirigidos() {
      $entities = $this->em->getRepository('UIFIProductosBundle:ProyectoDirigido')->findAll();
      return $entities;
    }

    public function getLibros() {
      $entities = $this->em->getRepository('UIFIProductosBundle:Libro')->findAll();
      return $entities;
    }

    public function getSoftware() {
      $entities = $this->em->getRepository('UIFIProductosBundle:Software')->findAll();
      return $entities;
    }
    public function getEventos() {
      $entities = $this->em->getRepository('UIFIProductosBundle:Evento')->findAll();
      return $entities;
    }
    public function getDocumentosTrabajo () {}
    public function getOtrosArticulos() {}
    public function getOraPublicacionDivulgativa() {}
    public function getConsultoriaCientificaTecnologica() {}
    public function getDisenosIndustriales() {}
    public function getInonovacionProcesosProcedimientos() {}
    public function getInnovacionGestionEmpreserial() {}
    public function getOtrosProductosTescnologicos() {}
    public function getPrototipos() {}
    public function getNormasRegulaciones() {}
    public function getSignosDistintivos() {}
    public function getSponoff() {}
    public function getEdiciones() {}
    public function getInformesInvestigacion() {}
    public function getRedesConocimientoEspecializado() {}
    public function getGeneracionContenidoImpreso() {}
    public function getGeneracionContenidoVirtual() {}
    public function getCursosCortaDuracionDictados() {}
    public function getJurados() {}
    public function getParticipacionComitesEvaluacion() {}
    public function getDemasTrabajos() {}
    public function getProyectos() {}
}
