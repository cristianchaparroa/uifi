<?php

namespace UIFI\ProductosBundle\Core\ExcelExporter;

use ExcelAnt\Adapter\PhpExcel\Workbook\Workbook;
use ExcelAnt\Adapter\PhpExcel\Sheet\Sheet;
use ExcelAnt\Adapter\PhpExcel\Writer\Writer;
use ExcelAnt\Table\Table;
use ExcelAnt\Table\Style;
use ExcelAnt\Coordinate\Coordinate;
use ExcelAnt\Adapter\PhpExcel\Writer\WriterFactory;
use ExcelAnt\Adapter\PhpExcel\Writer\PhpExcelWriter\Excel5;
/**
  *@file
  *
  * clase que se encarga de generar un archivo excel
  *@author: Cristian Camilo Chaparro A.
  */

class ExcelExporter
{
  public function __construct(){

  }
  /**
   * Funcion que se encarga de generar un archivo en excel en el servidor.
   * @param $path, ruta en la que se va a alojar el archivo.
   * @param $fileName, nombre del archivo a generar.
   * @param className, nombre de la clase de la entidad que se va usar para generar
   *    las propiedades.
   * @param $headers, titulos de las columnas de la tabla de excel.
   * @param $porperties, propiedades de la la entidad de las cuales se van a obtener
   *  los valores a mostrar
   * @param $entities, entidades sobre las cuales se extrae la informacion del
   *  reporte en excel.
  */
  public function getXLS($path,$fileName,$className, $headers,$properties,$entities) {
    $workbook = new Workbook();
    $sheet = new Sheet($workbook);
    $table = new Table();
    $row = array();
    foreach ( $headers as $column) {
      array_push($row, $column);
    }
    $table->setRow($row);

    foreach( $entities as $entity) {
      $row = array();
      foreach( $properties as $property) {
        $builderExporter = new BuilderExporter();
        $value =$builderExporter->getValue($className,$entity,$property);
        array_push($row, $value);
      }
      $table->setRow($row);
    }
    $table->setColumn([' ']);
    $sheet->addTable($table, new Coordinate(1, 1));
    $workbook->addSheet($sheet);
    $fileName = $fileName . '.xls';
    $writer = (new WriterFactory())->createWriter(new Excel5($path.'/'.$fileName));
    $phpExcel = $writer->convert($workbook);
    $writer->write($phpExcel);
    return $fileName;
  }
}
