<?php

/*
 * This file is part of the FOSUserBundle package.
 *
 * (c) FriendsOfSymfony <http://friendsofsymfony.github.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Bacloo\UserBundle\Controller;

use FOS\UserBundle\Controller\ResettingController as BaseController;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccountStatusException;
use FOS\UserBundle\Model\UserInterface;

/**
 * Controller managing the resetting of the password
 *
 * @author Thibault Duplessis <thibault.duplessis@gmail.com>
 * @author Christophe Coevoet <stof@notk.org>
 */
class ResettingController extends BaseController
{
    /**
     * Request reset user password: show form
     */
    // public function requestAction()
    // {
		// $em = $this->container->get('doctrine')->getManager();

		// include('societe.php');	echo  'RRRRRRRR'.$societe;
		// $query = $em->createQuery(
			// 'SELECT u.textaccueil
			// FROM BaclooUserBundle:User u
			// WHERE u.usersociete = :usersociete
			// AND u.roleuser = :roleuser');
		// $query->setParameter('usersociete', $societe);
		// $query->setParameter('roleuser', 'admin');
		// $text = $query->getSingleScalarResult();	
        // return $this->container->get('templating')->renderResponse('FOSUserBundle:Resetting:request.html.'.$this->getEngine(), array('societe' => $societe, 'text' => $text));
    // }
}
