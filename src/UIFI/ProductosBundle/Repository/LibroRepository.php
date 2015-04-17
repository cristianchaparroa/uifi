<?php

namespace UIFI\ProductosBundle\Repository;

use Doctrine\ORM\EntityRepository;
use UIFI\ReportesBundle\Repository\IReportableRepository;
/**
 * ArticuloRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class LibroRepository extends EntityRepository implements IReportableRepository
{
    /**
    * Cuenta el número de articulos publicados por año en la facultad
    *
    */
    public function getCountAllByYear(){
      $em = $this->getEntityManager();
      $connection = $em->getConnection();
      $sql = 'SELECT COUNT(l.anual) AS cantidad, l.anual AS fecha FROM  libro l
              GROUP BY l.anual';
      $em = $this->getEntityManager();
      $statement = $connection->prepare($sql);
      $statement->execute();
      $results = $statement->fetchAll();
      return $results;
    }
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
    public function getCountByGrupo( $code ){
      $em = $this->getEntityManager();
      $connection = $em->getConnection();
      $sql = 'SELECT COUNT(DISTINCT(l.id)) as cantidad, g.nombre, l.anual  FROM grupo g, integrante i,grupo_integrante gi,libro l, integrantes_libros il
              WHERE g.id = :code
              AND gi.grupo_id = g.id
              AND gi.integrante_id = i.id
              AND l.grupo = g.id
              AND il.integrante_id = i.id
              AND il.libro_id = l.id';

      $statement = $connection->prepare($sql);
      $statement->bindValue('code', $code);
      $statement->execute();
      $results = $statement->fetchAll();
      if( count($results)>0){
          $value = $results[0];
          $value = intval($value['cantidad']);
          return $value;
      }
      return 0;
    }

    /**
     * Función que se encarge de contar el número de Libros que tiene publicado
     * un grupo de investigación de acuerdo a las publicaciones realizadas por los
     * integrantes , discriminado por año.
     *
     * @param $code Código del grupo de investigación.
     * @return Integer con la cuenta de artículos por grupo.
    */
    public function getCountByYear($code){
      $em = $this->getEntityManager();
      $connection = $em->getConnection();
      $sql = 'SELECT COUNT(DISTINCT(l.id)) as cantidad, g.nombre, l.anual  FROM grupo g, integrante i,grupo_integrante gi,libro l, integrantes_libros il
              WHERE g.id = :code
              AND gi.grupo_id = g.id
              AND gi.integrante_id = i.id
              AND l.grupo = g.id
              AND il.integrante_id = i.id
              AND il.libro_id = l.id
              GROUP BY g.id,l.anual ORDER BY l.anual,g.nombre';
      $statement = $connection->prepare($sql);
      $statement->bindValue('code', $code);
      $statement->execute();
      $results = $statement->fetchAll();
      return $results;
    }
    /**
     * Se obtienen la cantidad de Libros ppublicados por integrante en un
     * grupo de investigación especificado.
     *
     * @param $code Código del integrante.
     * @param $idGrupo identificador del grupo de investigación.
     * @return Integer: Número de Libros publicados.
    */
    public function getCantidadByIntegrante($code,$idGrupo){
      $em = $this->getEntityManager();
      $connection = $em->getConnection();
      $query = "SELECT  count(*) as numero
        FROM integrante i , grupo g, grupo_integrante gi, libro l, integrantes_libros il
        WHERE i.id= :code AND gi.grupo_id = g.id AND g.id = :idGrupo AND gi.integrante_id = i.id
        AND il.integrante_id = i.id  AND il.libro_id = l.id";
        $statement = $connection->prepare($query);
        $statement->bindValue('code', $code);
        $statement->bindValue('idGrupo', $idGrupo);
        $statement->execute();
        $results = $statement->fetchAll();
        if( count($results)>0){
          $numeroArticulos = $results[0];
          $numeroArticulos = intval($numeroArticulos['numero']);
          return $numeroArticulos;
        }
        return 0;
    }
    /**
     * Función que se encarga de contar la cantidad de Libros publicados por año
     * por un integrante especificado , en un grupo especificado
     * @param $code Código del integrante.
     * @param $idGrupo identificador del grupo de investigación.
     * @return  arreglo de arreglos con [cantidad,anual]
    */
    public function getCantidadIntegranteAnual($code,$idGrupo){
      $em = $this->getEntityManager();
      $connection = $em->getConnection();
      $query = 'SELECT COUNT(*) as cantidad, l.anual
          FROM grupo g, integrante i , grupo_integrante gi, libro l, integrantes_libros il
          WHERE g.id= :idGrupo AND i.id= :code AND gi.grupo_id = g.id  AND gi.integrante_id = i.id
            AND il.integrante_id = i.id AND il.libro_id = l.id
            AND l.grupo = g.id
          GROUP BY l.anual';
      $statement = $connection->prepare($query);
      $statement->bindValue('code', $code);
      $statement->bindValue('idGrupo', $idGrupo);
      $statement->execute();
      $results = $statement->fetchAll();
      return $results;
    }
}