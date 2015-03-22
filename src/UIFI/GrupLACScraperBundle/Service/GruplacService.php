<?php


namespace UIFI\GrupLACScraperBundle\Service;


use Symfony\Bundle\DoctrineBundle\Registry;
use Symfony\Component\HttpKernel\Log\LoggerInterface;
use UIFI\GrupLACScraperBundle\Core\PageGrupLACScraper;
use UIFI\GrupLACScraperBundle\Core\IndividualCVLACScraper;
use Symfony\Component\DependencyInjection\Container;
use UIFI\GrupLACScraperBundle\Entity\Gruplac;

/**
 * Servicio que se encarga de controlar la lógica de los Configuración de los
 * gruplacs.
 *
 * @author Cristian Chaparro Africano <cristianchaparroa@gmail.com>
*/
class GruplacService
{

    public function __construct(Container $container)
    {
       $this->container = $container;
       $this->em = $container->get('doctrine.orm.entity_manager');
    }

    /**
     * Función que se encarga de crear un gruplac
     * @param Código del gruplac del grupo Investigación
     * @return Estado del proceso {false,true}
    */
    public function newGruplac($code){
      if( !$this->existe($code) ){
        $grupoScraper = new PageGrupLACScraper($code);
        $nombre = $grupoScraper->getNombreGrupo();
        $gruplac = new Gruplac();
        $gruplac->setId($code);
        $gruplac->setNombre($nombre);
        $this->em->persist($gruplac);
        $this->em->flush();
        return true;
      }
      return false;

    }
    /**
    * Función que se encarga de verificar si existe el código de un gruplac en
    * el sistema.
    *
    * @param $code Código del gruplac a crear.
    * @return Verdadero si existe, falso si no existe el código.
    */
    public function existe($code){
      if( strpos( $code,'scienti' ) ){
        $result = explode( '=',$code);
        $code = $result[1];
      }
      $repositoryGruplac = $this->em->getRepository('UIFIGrupLACScraperBundle:Gruplac');
      $entity = $repositoryGruplac->find($code);
      if($entity){
        $success = true;
      }
      $success = false;
      return $success;
    }
}
