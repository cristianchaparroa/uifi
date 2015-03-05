<?php

namespace UsersBundle\Entity;


use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * Clase que se encarga de mapear la entidad Usuario en la base
 * de datos.
 *
 * @author Cristian Camilo Chaparro Africano <cristianchaparroa@gmail.com>
 * @package UsersBundle
 *
 * @ORM\Entity
 * @ORM\Table(name="usuario")
 */
class Usuario extends BaseUser
{
    /**
     * Identificador del Usuario.
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    /**
     * Contructor de la clase Usuario.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
    /**
     * @return string
     */
     public function getRolesAsString()
     {
         $roles = array();
         foreach ($this->getRoles() as $role) {
            $role = explode('_', $role);
            array_shift($role);
            $roles[] = ucfirst(strtolower(implode(' ', $role)));
         }

         return implode(', ', $roles);
     }

}
