<?php

namespace Bacloo\UserBundle\Listener;

use FOS\UserBundle\Model\UserManagerInterface;
use FOS\UserBundle\Model\UserInterface;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\DependencyInjection\ContainerAware;


class BaclooLoginListener
{
private $userManager;

    public function __construct(UserManagerInterface $userManager)
    {
        $this->userManager = $userManager;
    }

    public function onSecurityInteractiveLogin(InteractiveLoginEvent $event)
    {   
        $user = $event->getAuthenticationToken()->getUser();
		$request = $event->getRequest();
        $sessionId = $request->getSession()->getId();

		$user->setLogged($sessionId);
		$this->userManager->updateUser($user);  
    }
}