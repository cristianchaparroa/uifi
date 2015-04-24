<?php


namespace UIFI\GrupLACScraperBundle\Service;


use Symfony\Bundle\DoctrineBundle\Registry;
use Symfony\Component\HttpKernel\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\Container;
use Goodby\CSV\Import\Standard\Lexer;
use Goodby\CSV\Import\Standard\Interpreter;
use Goodby\CSV\Import\Standard\LexerConfig;

use UIFI\ProductosBundle\Entity\Revista;
use UIFI\ProductosBundle\Entity\Categoria;

/**
 * Servicio que se encarga de importar la información  de las revistas de
 * indexación desde un archivo csv.
 *
 *
 * @author Cristian Chaparro Africano <cristianchaparroa@gmail.com>
*/
class ImportarRevistasService
{
    public function __construct(Container $container)
    {
       $this->container = $container;
       $this->em = $container->get('doctrine.orm.entity_manager');
    }
    /**
     * Función que se encarga de importar y procesar la información de las
     * revistas de indexación desde un archivo csv.
     *
    */
    public function importar(){
      $config = new LexerConfig();
      $lexer = new Lexer($config);
      $interpreter = new Interpreter();
      $interpreter->addObserver(function(array $row) {
          $revista = new Revista();
          $revista->setId($row[0]);
          $revista->setNombre($row[1]);
          $this->em->persist($revista);
          $categoria = new Categoria();
          $categoria->setTipo( $row[2]);
          $fechas = explode( '-',$row[3]);
          $fechaInicial = $fechas[0];
          $fechaInicials = explode( ' ',$fechaInicial);
          //elimino los items con espacio blanco
          $fechaInicials = $this->removeEmpty($fechaInicials) ;
          $fechaInicialMes = $fechaInicials[0];
          $fechaInicialMes = $this->getMes( $fechaInicialMes );
          $fechaInicialAnual = $fechaInicials[1];
          $fechaFinal = $fechas[1];
          $fechaFinals = explode( ' ',$fechaFinal );
          $fechaFinals = $this->removeEmpty($fechaFinals);
          $fechaFinalMes = $fechaFinals[0];
          $fechaFinalMes = $this->getMes($fechaFinalMes);
          $fechaFinalAnual = $fechaFinals[1];
          $stringInicial  = $fechaInicialAnual . "/".  $fechaInicialMes ."/01";
          $vigenciaInicial = new \DateTime( $stringInicial );
          $stringFinal = $fechaFinalAnual ."/".$fechaFinalMes."/01" ;
          $vigenciaFinal = new \DateTime(  $stringFinal );
          $categoria->setVigenciaInicial($vigenciaInicial);
          $categoria->setVigenciaFinal($vigenciaFinal);
          $categoria->setRevista($revista);
          $this->em->persist($categoria);
          $revista->addCategoria($categoria);
          $this->em->persist($revista);
          $this->em->flush();
      });
      $lexer->parse('data.csv', $interpreter);
    }
    /**
     * Obtiene el número de un mes, basado en el nombre
     *
     * @param Nombre del mes.
     * @return Número de mes.
    */
    private function  getMes($nombreMes){
        $nombreMes = strtolower($nombreMes);
        $meses = array(
          'ene' => '1',
          'feb' => '2',
          'mar' => '3',
          'abr' => '4',
          'may' => '5',
          'jun' => '6',
          'jul' => '7',
          'ago' => '8',
          'sep' => '9',
          'oct' => '10',
          'nov' => '11',
          'dic' => '12',
        );

        if( array_key_exists( $nombreMes, $meses ) ){
          return $meses[$nombreMes];
        }
        return FALSE;
    }

    /**
     * Funcioón que se encarga de eliminar elementos en blanco
     * de un arreglo.
     *
     * @param $array Arreglo a procesar
     * @return arreglo sin elementos con espacios en blanco.
    */
    private function removeEmpty($array){
      $arr = array();
      foreach($array as $item){
        if( $item != '' ){
          $arr[] = $item;
        }
      }
      return $arr;
    }
}
