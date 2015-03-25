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
    * Función que se encarga de obtener todos los gruplacs
    *
    * @return Arreglo con los gruplacs en el sistema.
    */
    public function getGruplacs(){
      $entities = $this->em->getRepository('UIFIGrupLACScraperBundle:Gruplac')->findAll();
      return $entities;
    }

    /**
    * Función que se encarga de obtener todos los gruplacs en formato JSON
    *
    * @return Arreglo con los gruplacs en el sistema.
    */
    public function getGruplacsJSON(){
      $entities = $this->em->getRepository('UIFIGrupLACScraperBundle:Gruplac')->findAll();

      $entidades = array();
      foreach( $entities as $gruplac ){
        $entidades[] = array( 'id'=> $gruplac->getId(), 'nombre'=>$gruplac->getNombre() );
      }
      return $entidades ;
    }
    /**
     * Función que se encarga de crear un gruplac
     * @param Código del gruplac del grupo Investigación
     * @return Estado del proceso {false,true}
    */
    public function newGruplac($code){
        $grupoScraper = new PageGrupLACScraper($code);
        $nombre = $grupoScraper->getNombreGrupo();
        $gruplac = new Gruplac();
        $gruplac->setId($code);
        $gruplac->setNombre($nombre);
        $this->em->persist($gruplac);
        $this->em->flush();
        return true;
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
      else{
        $success = false;
      }
      return $success;
    }

    /**
     * Función que se encarga de eliminar un gruplac del sistema.
     * @param $code Código del gruplac a eliminar.
    */
    public function delete($code){

    }
}
