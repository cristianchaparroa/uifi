<?php

namespace UIFI\GrupLACScraperBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * ArticuloRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class GruplacRepository extends EntityRepository
{
  /**
   * Funcion que se encarga de retornar un arreglo con todos los códigos
   * de los diferentes gruplacs, que hay registrados en el sistema.
  */
  public function getAllCodes(){
    $em = $this->getEntityManager();
    $connection = $em->getConnection();
    $sql = "SELECT   g.id as code FROM gruplac g";
    $statement = $connection->prepare($sql);
    $statement->execute();
    $results = $statement->fetchAll();
    $codigos = array();
    foreach( $results as $result ){
      $codigos[] = $result['code'];
    }
    return $codigos;
  }
}
