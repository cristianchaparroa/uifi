<?php

namespace UsersBundle\Service;

use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Router;

class LoginSuccessHandler implements AuthenticationSuccessHandlerInterface
{
    protected $router;
    protected $security;

    public function __construct(Router $router, SecurityContext $security)
    {
        $this->router   = $router;
        $this->security = $security;
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token)
    {
        $user = $this->security->getToken()->getUser();

        if ($this->security->isGranted('ROLE_ADMIN')) {
            $response = new RedirectResponse($this->router->generate('sonata_admin_dashboard'));
        }
        elseif ($this->security->isGranted('ROLE_DIRECTOR'))
        {
            $response = new RedirectResponse($this->router->generate('director_home'));
        }
        elseif ($this->security->isGranted('ROLE_INTEGRANTE'))
        {
            $response = new RedirectResponse($this->router->generate('integrantes_home'));
        }
        else{
            $response = new RedirectResponse($this->router->generate('login'));
        }
        return $response;
    }
}
