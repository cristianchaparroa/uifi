<?php

namespace UIFI\ReportesBundle\Repository;

/**
 * Interface que establece los métodos necesario a implementar en los repositorios
 * que van a emplearse en las entidades a generar reportes.
 *
 * @author Cristian Camilo Chaparro Africano <cristianchaparroa@gmail.com>
*/
interface IReportableRepository
{
    /**
    * Cuenta el número de articulos publicados por año en la facultad
    *
    */
    public function getCountAllByYear();
    /**
     * Función que se encarga de contar el número de Libros que tiene publicado
     * un grupo de investigación de acuerdo de las publicaciones realizadas por
     * cada uno de los integrantes del grupo de Investigación.
     *
     *
     * @param $code Id del grupo de investigación.
     * @return Integer con la cuenta de artículos por grupo.
     *
    */
    public function getCountByGrupo( $code );

    /**
     * Función que se encarge de contar el número de Libros que tiene publicado
     * un grupo de investigación de acuerdo a las publicaciones realizadas por los
     * integrantes , discriminado por año.
     *
     * @param $code Código del grupo de investigación.
     * @return Integer con la cuenta de artículos por grupo.
    */
    public function getCountByYear($code);
    /**
     * Se obtienen la cantidad de Libros ppublicados por integrante en un
     * grupo de investigación especificado.
     *
     * @param $code Código del integrante.
     * @param $idGrupo identificador del grupo de investigación.
     * @return Integer: Número de Libros publicados.
    */
    public function getCantidadByIntegrante($code,$idGrupo);
    /**
     * Función que se encarga de contar la cantidad de Libros publicados por año
     * por un integrante especificado , en un grupo especificado
     * @param $code Código del integrante.
     * @param $idGrupo identificador del grupo de investigación.
     * @return  arreglo de arreglos con [cantidad,anual]
    */
    public function getCantidadIntegranteAnual($code,$idGrupo);
}
