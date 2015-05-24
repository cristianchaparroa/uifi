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
     * TODO:
     *  -Actualizar si se importan archivos con la mismo isbn y la misma
     *     fecha inicial y final
     *  -Verificar si el isbn ya existe y las fechas de vigencia son diferentes
     *     crear una nueva categoria para esta revista.
     *
    */
    public function importar(){
      $config = new LexerConfig();
      $config
      ->setDelimiter(";")
        ->setToCharset('UTF-8')
        ->setFromCharset('SJIS-win');

      $lexer = new Lexer($config);
      $interpreter = new Interpreter();
      $interpreter->addObserver(function(array $row) {
          print_r($row);
          echo "</br></br>\n\n";
          $isbn          = $this->process($row[1]);
          $nombreRevista = $this->process($row[2]);
          $category      = $this->process($row[3]);
          $inicial       = $this->process($row[4]);
          $final         = $this->process($row[5]);

          $revista = new Revista();
          $revista->setId($isbn);
          $revista->setNombre($nombreRevista);

          $this->em->persist($revista);
          $this->em->flush();

          $categoria = new categoria();
          $categoria->setTipo($category);

          $fechaInicial = explode('-',$inicial);
          $mesInicial   = $this->getMes($fechaInicial[0]);
          $anualInicial = $fechaInicial[1];


          $fechaFinal = explode('-',$inicial);
          $mesFinal   = $this->getMes($fechaFinal[0]);
          $anualFinal = $fechaFinal[1];

          $strInicial =  $mesInicial . "-01-".$anualInicial;
          $strFinal   =  $mesFinal. "-01-".$anualFinal;

          $categoria->setVigenciaInicial( new \DateTime($strInicial));
          $categoria->setVigenciaFinal( new \DateTime($strFinal));

          $categoria->setRevista($revista);
          $this->em->persist($categoria);
          $this->em->flush();

          $revista->addCategoria($categoria);
          $this->em->persist($revista);
          $this->em->flush();

      });
      $lexer->parse('data.csv', $interpreter);
    }

    public function process($string ){
      $string = preg_replace('/[^A-Za-z0-9\. -]/', '', $string);
      return $string;
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
     * Función que se encarga de eliminar elementos en blanco
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
