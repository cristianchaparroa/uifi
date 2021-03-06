<?php

namespace UIFI\IntegrantesBundle\Repository;

use Doctrine\ORM\EntityRepository;
use UIFI\IntegrantesBundle\Entity\Integrante;

/**
 * IntegranteRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class IntegranteRepository extends EntityRepository
{

  /**
   * Funcion que se encarga de eliminar todos los registros
   * de la entidad
  */
  public function deleteAll(){
    $em = $this->getEntityManager();
    return $em->createQuery('DELETE FROM UIFIIntegrantesBundle:Integrante')->execute();
  }

  /**
   * Se redefine el método de buscar todos de tal manera que se obtienen las
   * entidades ordenadas por orden Alfabetico segun los nombres.
  */
  public function findAll(){
    return $this->findBy(array(), array('nombres' => 'ASC'));
  }

  public function findIntegrantesSinUsuario(){
    $sql = 'SELECT * FROM integrante WHERE usuario_id is null';
    $stmt = $this->getEntityManager()->getConnection()->prepare($sql);
    $stmt->execute();
    $integrantes = $stmt->fetchAll();
    return $integrantes;
  }
}
