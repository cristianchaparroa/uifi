<?php

namespace UsersBundle\Service;

use Symfony\Bundle\DoctrineBundle\Registry;
use Symfony\Component\HttpKernel\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\Container;

class UserService
{
  /**
   * Constructor de la clase.
   *
   * @param Container
   *
  */
  public function __construct(Container $container)
  {
     $this->container = $container;
     $this->em = $container->get('doctrine.orm.entity_manager');
  }

  /**
   * Verifica que el email que se pone no este registrado en el sistema.
   * @param $email
   * @return Estado de la validación verdadero si existe, falso de lo contrario
  */
  public function verificarEmail($email){
    $userManager = $this->container->get('fos_user.user_manager');
    $user = $userManager->findUserByEmail($email);
    return ( $user ? true: false );
  }
  /**
   * Crea un usuario en el sistema.
   * Este usa la funcionalidad de FOSUserBundle
   *
  */
  public function crearUsuario( $idIntegrante, $email,$rol){
    $userManager = $this->container->get('fos_user.user_manager');
    $tokenGenerator = $this->container->get('fos_user.util.token_generator');
    $password = substr($tokenGenerator->generateToken(), 0, 8);
    $user = $userManager->createUser();
    $user->setUsername( $email );
    $user->setEmail( $email );
    $user->setPlainPassword( $password );
    $user->setEnabled(true);
    $user->addRole($rol);
    $userManager->updateUser($user);
    $result = array( 'user' => $user, 'password' => $password);
    return $result;
  }
}
