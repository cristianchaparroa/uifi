<?php

namespace UIFI\ProductosBundle\Core\ExcelExporter;


class ValueExporter implements IPropertyEExporter {

    private $next;

    /**
    * Se asigna el siguiente exporter en la cadena
    * @param  \UIFI\ProductosBundle\Core\ExcelExporter\IEExporterProperty
    */
    public function setNext(\UIFI\ProductosBundle\Core\ExcelExporter\IPropertyEExporter  $propertyExporter) {
      $this->next = $propertyExporter;
    }

    /**
     * Obtiene el siguiente exporter en la cadena.
    */
    public function getNext() {
      return $this->next;
    }
    /**
    * Obtiene el valor de una propiedad especifica que no puede ser procesada
    * como una simple estring
    * @param $entity, entidad sobre la cual se va obtener la propiedad y su
    *     respectivo valor.
    * @param $property propiedad a obtener de la entidad para ser evaludada.
    */
    public function getValue($className,$entity,$property) {
      $reflectionClass = new \ReflectionClass($className);
      $reflectionProperty = $reflectionClass->getProperty($property);
      $reflectionProperty->setAccessible(true);
      $value = $reflectionProperty->getValue($entity);
      return $value;
    }
}
