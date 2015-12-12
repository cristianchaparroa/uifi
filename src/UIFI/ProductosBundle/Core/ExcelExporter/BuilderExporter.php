<?php

namespace UIFI\ProductosBundle\Core\ExcelExporter;

use UIFI\ProductosBundle\Core\ExcelExporter\IntegrantesExporter;
use UIFI\ProductosBundle\Core\ExcelExporter\ValueExporter;
/**
  *@file
  *
  * clase que se encarga de generar un archivo excel
  *@author: Cristian Camilo Chaparro A.
  */

class BuilderExporter {

  public function __construct() {

  }
  public function getValue($className,$entity,$property)  {
    $integrantesExporter = new IntegrantesExporter();
    $valueExporter  = new ValueExporter();
    $integrantesExporter->setNext($valueExporter);
    return  $integrantesExporter->getValue($className,$entity,$property);
  }
}
