<?php

namespace Bacloo\UserBundle\Listener;

use FOS\UserBundle\Model\UserManagerInterface;
use FOS\UserBundle\Model\UserInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Logout\LogoutHandlerInterface;

class BaclooLogoutHandler implements LogoutHandlerInterface
{
    private $userManager;

    public function __construct(UserManagerInterface $userManager)
    {
        $this->userManager = $userManager;
    }

    public function logout(Request $request, Response $response, TokenInterface $token){
        $user = $token->getUser();
        if($user->getLogged()){
            $user->setLogged(false);
            $this->userManager->updateUser($user);
        }
    }
}