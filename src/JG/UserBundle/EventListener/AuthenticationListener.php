<?php
/**
 * Created by PhpStorm.
 * User: Justine GAMBIER
 * Date: 12/12/2016
 * Time: 21:38
 */

namespace JG\UserBundle\EventListener;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Router;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;

class AuthenticationListener implements AuthenticationSuccessHandlerInterface
{
    protected $router, $security;

    public function __construct(Router $router, AuthorizationChecker $security)
    {
        $this->router = $router;
        $this->security = $security;
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token)
    {
        $url = 'home_page';

        if (false === $this->security->isGranted('ROLE_ADMIN')) {
            $url = 'account_home_page';
        } else {
            $url = 'admin_home_page';
        }

        $response = new RedirectResponse($this->router->generate($url));

        return $response;


    }

}