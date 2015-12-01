<?php

namespace UIFI\ProductosBundle\Core;

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
  public function getXLS($path,$fileName,$className, $headers,$properties,$entities) {
    $workbook = new Workbook();
    $sheet = new Sheet($workbook);
    $table = new Table();
    $row = array();
    foreach ( $headers as $column) {
      array_push($row, $column);
    }
    $table->setRow($row);
    $reflectionClass = new \ReflectionClass($className);
    foreach( $entities as $entity) {
      $row = array();
      foreach( $properties as $property) {
        $reflectionProperty = $reflectionClass->getProperty($property);
        $reflectionProperty->setAccessible(true);
        $value = $reflectionProperty->getValue($entity);
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
