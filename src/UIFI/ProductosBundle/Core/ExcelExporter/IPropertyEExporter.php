<?php

namespace UIFI\ProductosBundle\Core\ExcelExporter;

/**
  *@file
  *
  * clase que se encarga de generar un archivo excel
  *@author: Cristian Camilo Chaparro A.
  */

interface IPropertyEExporter{
    /**
    * Se asigna el siguiente  property exporter en la cadena
    * @param \UIFI\ProductosBundle\Core\ExcelExporter\IPropertyEExporter
    */
    public function setNext(\UIFI\ProductosBundle\Core\ExcelExporter\IPropertyEExporter  $propertyExporter);

    /**
     * Obtiene el siguiente exporter en la cadena.
    */
    public function getNext();
    /**
    * Obtiene el valor de una propiedad especifica que no puede ser procesada
    * como un  simple estring
    */
    public function getValue($className,$entity,$property);
}
