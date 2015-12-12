<?php

namespace UIFI\ProductosBundle\Core\ExcelExporter;


/**
  *@file
  *
  * clase que se encarga de generar un archivo excel
  *@author: Cristian Camilo Chaparro A.
  */

class IntegrantesExporter {

      private $next;

      public function __construct() {

      }

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
      */
      public function getValue($className,$entity,$property) {
        if ( $property === 'integrantes') {
          $nombresIntegrantes =  "";
          $reflectionClass = new \ReflectionClass($className);
          $reflectionProperty = $reflectionClass->getProperty($property);
          $reflectionProperty->setAccessible(true);
          $integrantes = $reflectionProperty->getValue($entity);
          foreach ( $integrantes as $integrante) {
             $nombreIntegrante = $integrante->getNombres();
             $nombresIntegrantes  .= $nombreIntegrante . ", ";
          }
          return $nombresIntegrantes;
        }else {
          return $this->next->getValue($className,$entity, $property);
        }
      }
}
