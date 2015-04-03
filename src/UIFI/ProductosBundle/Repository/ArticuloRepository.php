<?php

namespace UIFI\ProductosBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * ArticuloRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ArticuloRepository extends EntityRepository
{
  /**
   * Funcion que se encarga de eliminar todos los registros
   * de la entidad
  */
  public function deleteAll(){
    $em = $this->getEntityManager();
    return $em->createQuery('DELETE FROM UIFIProductosBundle:Articulo')->execute();
  }

  /**
  * Cuenta el número de articulos publicados por año en la facultad
  *
  */
  public function getCountAllByYear(){
    $em = $this->getEntityManager();
    $connection = $em->getConnection();
    $sql = 'SELECT COUNT(a.anual) AS cantidad, a.anual AS fecha FROM  articulo a
            GROUP BY a.anual';
    $em = $this->getEntityManager();
    $statement = $connection->prepare($sql);
    $statement->execute();
    $results = $statement->fetchAll();
    return $results;
  }


  /**
   * Función que se encarga de contar el número de artículos que tiene publicado
   * un grupo de investigación de acuerdo de las publicaciones realizadas por
   * cada uno de los integrantes del grupo de Investigación.
   *
   * @param $code Id del grupo de investigación.
   * @return Integer con la cuenta de artículos por grupo.
   *
  */
  public function getCountByGrupo( $code ){
    $em = $this->getEntityManager();
    $connection = $em->getConnection();
    $sql = "SELECT count(DISTINCT a.id) as cantidad
      FROM  grupo g, integrante i,grupo_integrante gi, articulo a,integrantes_articulos ia
      WHERE g.id = :code AND gi.grupo_id = g.id AND gi.integrante_id = i.id AND a.grupo = g.id
        AND ia.integrante_id = i.id AND ia.articulo_id  = a.id";

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
   * Función que se encarge de contar el número de artículos que tiene publicado
   * un grupo de investigación de acuerdo a las publicaciones realizadas por los
   * integrantes , discriminado por año.
   *
   * @param $code Código del grupo de investigación.
   * @return Integer con la cuenta de artículos por grupo.
  */
  public function getCountByYear($code){
    $em = $this->getEntityManager();
    $connection = $em->getConnection();
    $sql = 'SELECT  COUNT(DISTINCT (a.id)) as cantidad, g.nombre, a.anual
          FROM  articulo a, integrantes_articulos  ia, integrante i,
            grupo g, grupo_integrante gi
          WHERE  g.id = :code  AND ia.articulo_id = a.id AND ia.integrante_id = i.id
            AND gi.grupo_id = g.id AND gi.integrante_id = i.id
          GROUP BY g.id,a.anual ORDER BY a.anual,g.nombre';
    $statement = $connection->prepare($sql);
    $statement->bindValue('code', $code);
    $statement->execute();
    $results = $statement->fetchAll();
    return $results;
  }

  /**
   * Se obtienen la cantidad de artículos ppublicados por integrante en un
   * grupo de investigación especificado.
   *
   * @param $code Código del integrante.
   * @param $idGrupo identificador del grupo de investigación.
   * @return Integer: Número de artículos publicados.
  */
  public function getCantidadByIntegrante($code,$idGrupo){
      $em = $this->getEntityManager();
      $connection = $em->getConnection();
      $query = "SELECT  count(*) as numeroArticulos
        FROM integrante i , grupo g, grupo_integrante gi, articulo a, integrantes_articulos ia
        WHERE i.id= :code AND gi.grupo_id = g.id AND g.id = :idGrupo AND gi.integrante_id = i.id
        AND ia.integrante_id = i.id  AND ia.articulo_id = a.id";
        $statement = $connection->prepare($query);
        $statement->bindValue('code', $code);
        $statement->bindValue('idGrupo', $idGrupo);
        $statement->execute();
        $results = $statement->fetchAll();
        if( count($results)>0){
          $numeroArticulos = $results[0];
          $numeroArticulos = intval($numeroArticulos['numeroArticulos']);
          return $numeroArticulos;
        }
        return 0;
   }
   /**
    * Función que se encarga de contar la cantidad de artículos publicados por año
    * por un integrante especificado , en un grupo especificado
    * @param $code Código del integrante.
    * @param $idGrupo identificador del grupo de investigación.
    * @return  arreglo de arreglos con [cantidad,anual]
   */
   public function getCantidadIntegranteAnual($code,$idGrupo){
     $em = $this->getEntityManager();
     $connection = $em->getConnection();
     $query = 'SELECT COUNT(*) as cantidad, a.anual
         FROM grupo g, integrante i , grupo_integrante gi, articulo a, integrantes_articulos ia
         WHERE g.id= :idGrupo AND i.id= :code AND gi.grupo_id = g.id  AND gi.integrante_id = i.id
           AND ia.integrante_id = i.id AND ia.articulo_id = a.id
         GROUP BY a.anual';
     $statement = $connection->prepare($query);
     $statement->bindValue('code', $code);
     $statement->bindValue('idGrupo', $idGrupo);
     $statement->execute();
     $results = $statement->fetchAll();
     return $results;
   }
}
