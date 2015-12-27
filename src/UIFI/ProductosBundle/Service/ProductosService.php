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
    public function getDocumentosTrabajo () {
      $entities = $this->em->getRepository('UIFIProductosBundle:DocumentoTrabajo')->findAll();
      return $entities;
    }
    public function getOtrosArticulos() {
      $entities = $this->em->getRepository('UIFIProductosBundle:OtroArticulo')->findAll();
      return $entities;
    }
    public function getOtraPublicacionDivulgativa() {
      $entities = $this->em->getRepository('UIFIProductosBundle:OtraPublicacionDivulgativa')->findAll();
      return $entities;
    }
    public function getConsultoriaCientificaTecnologica() {
      $entities = $this->em->getRepository('UIFIProductosBundle:ConsultoriaCientifica')->findAll();
      return $entities;
    }
    public function getDisenosIndustriales() {
      $entities = $this->em->getRepository('UIFIProductosBundle:DisenoIndustrial')->findAll();
      return $entities;
    }
    public function getInonovacionProcesosProcedimientos() {
      $entities = $this->em->getRepository('UIFIProductosBundle:InnovacionProcesosProcedimientos')->findAll();
      return $entities;
    }
    public function getInnovacionGestionEmpreserial() {
      $entities = $this->em->getRepository('UIFIProductosBundle:InnovacionGestionEmpresarial')->findAll();
      return $entities;
    }
    public function getOtrosProductosTecnologicos() {
      $entities = $this->em->getRepository('UIFIProductosBundle:OtroProductoTecnologico')->findAll();
      return $entities;
    }
    public function getPrototipos() {
      $entities = $this->em->getRepository('UIFIProductosBundle:Prototipo')->findAll();
      return $entities;
    }
    public function getNormasRegulaciones() {
      $entities = $this->em->getRepository('UIFIProductosBundle:NormaRegulacion')->findAll();
      return $entities;
    }
    public function getSignosDistintivos() {
      $entities = $this->em->getRepository('UIFIProductosBundle:SignoDistintivo')->findAll();
      return $entities;
    }
    public function getSponoff() {
      $entities = $this->em->getRepository('UIFIProductosBundle:SpinOff')->findAll();
      return $entities;
    }
    public function getEdiciones() {
      $entities = $this->em->getRepository('UIFIProductosBundle:Edicion')->findAll();
      return $entities;
    }
    public function getInformesInvestigacion() {
      $entities = $this->em->getRepository('UIFIProductosBundle:InformeInvestigacion')->findAll();
      return $entities;
    }
    public function getRedesConocimientoEspecializado() {
      $entities = $this->em->getRepository('UIFIProductosBundle:RedesConocimientoEspecializado')->findAll();
      return $entities;
    }
    public function getGeneracionContenidoImpreso() {
      $entities = $this->em->getRepository('UIFIProductosBundle:ContenidoImpreso')->findAll();
      return $entities;
    }
    public function getGeneracionContenidoVirtual() {
      $entities = $this->em->getRepository('UIFIProductosBundle:ContenidoVirtual')->findAll();
      return $entities;
    }
    public function getCursosCortaDuracionDictados() {
      $entities = $this->em->getRepository('UIFIProductosBundle:CursoCortaDuracionDictado')->findAll();
      return $entities;
    }
    public function getJurados() {
      $entities = $this->em->getRepository('UIFIProductosBundle:Jurado')->findAll();
      return $entities;
    }
    public function getParticipacionComitesEvaluacion() {
      $entities = $this->em->getRepository('UIFIProductosBundle:ComiteEvaluacion')->findAll();
      return $entities;
    }
    public function getDemasTrabajos() {
      $entities = $this->em->getRepository('UIFIProductosBundle:DemasTrabajos')->findAll();
      return $entities;
    }
    public function getProyectos() {
      $entities = $this->em->getRepository('UIFIProductosBundle:Proyecto')->findAll();
      return $entities;
    }
}
