<?php


namespace UIFI\GrupLACScraperBundle\Service;


use Symfony\Bundle\DoctrineBundle\Registry;
use Symfony\Component\HttpKernel\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\Container;


/**
 * Servicio que se encarga de manejar la lógica de las Revistas de indexación.
 *
 * @author Cristian Chaparro Africano <cristianchaparroa@gmail.com>
*/
class RevistaService
{
    public function __construct(Container $container)
    {
       $this->container = $container;
       $this->em = $container->get('doctrine.orm.entity_manager');
    }

    /**
     * Función que se encarga de listar todas las revistas de indexación
     * @return arreglo con las revistas de indexacion
    */
    public function listar(){
      $revistas = array();
      $repostoryRevistas = $this->em->getRepository('UIFIProductosBundle:Revista');
      $lista = $repostoryRevistas->findAll();
      foreach( $listas as $revista ){
        $cateogrias = array();

        $listCategories = $revista->getCategorias();
        //recorro las categorias
        foreach( $listaCategories as  $category ){
          $categorias [] = array(
            'tipo'            => $category->getTipo(),
            'vigenciaInicial' => $category->getVigenciaInicial(),
            'vigenciaFinal'   =>$category->getVigenciaFinal(),
          );
        }
        $journal = array(
          'isbn'       => $revista->getId(),
          'nombre'     => $revista->getNombre(),
          'categorias' => $Categorias,
        );
        $revistas []  = $journal;
      }
      return $revistas;
    }
}
