<?php
namespace Bacloo\UserBundle\Controller;

use FOS\UserBundle\Controller\SecurityController as BaseController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Httpfoundation\Response;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Validator\Constraints\Email as EmailConstraint;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\HttpFoundation\RedirectResponse;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;

use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\Security\Core\SecurityContext;

class SecurityController extends BaseController
{
    public function loginAction()
	{
        // $response = parent::loginAction();
// echo 'lalalalalal';
        
		$em = $this->container->get('doctrine')->getManager();

		include('societe.php');		
		
		// $query = $em->createQuery(
			// 'SELECT u.credits
			// FROM BaclooUserBundle:User u
			// WHERE u.usersociete = :usersociete
			// AND u.roleuser = :roleuser');
		// $query->setParameter('usersociete', $societe);
		// $query->setParameter('roleuser', 'admin');
		// $credits = $query->getSingleScalarResult();	
		
		$query = $em->createQuery(
			'SELECT u.username
			FROM BaclooUserBundle:User u
			WHERE u.usersociete = :usersociete
			AND u.roleuser = :roleuser');
		$query->setParameter('usersociete', $societe);
		$query->setParameter('roleuser', 'admin');
		$pseudoadmin = $query->getSingleScalarResult();	
		// echo $pseudoadmin;	
		
		$query = $em->createQuery(
			'SELECT u.textaccueil
			FROM BaclooUserBundle:User u
			WHERE u.usersociete = :usersociete
			AND u.roleuser = :roleuser');
		$query->setParameter('usersociete', $societe);
		$query->setParameter('roleuser', 'admin');
		$text = $query->getSingleScalarResult();	
		// echo $pseudoadmin;
		


		// $var = $expm1;
		// $date = str_replace('/', '-', $var);
		// $expm11 = date("Y-m-d", strtotime($date)); 

		// $d1 = new \DateTime("now");
		// $d2 = new \DateTime($expm11);
		
		// $interval = $d2->diff($d1);
		// $diff = $interval->format('%a');
		// echo $diff;

		  // return new RedirectResponse($this->container->get('Router')->generate('bacloocrm_conditions_generales_public'));
		  
        $request = $this->container->get('request');
        /* @var $request \Symfony\Component\HttpFoundation\Request */
        $session = $request->getSession();
        /* @var $session \Symfony\Component\HttpFoundation\Session\Session */

        // get the error if any (works with forward and redirect -- see below)
        if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
        } elseif (null !== $session && $session->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
            $session->remove(SecurityContext::AUTHENTICATION_ERROR);
        } else {
            $error = '';
        }

        if ($error) {
            // TODO: this is a potential security risk (see http://trac.symfony-project.org/ticket/9523)
            $error = $error->getMessage();
        }
        // last username entered by the user
        $lastUsername = (null === $session) ? '' : $session->get(SecurityContext::LAST_USERNAME);

        $csrfToken = $this->container->get('form.csrf_provider')->generateCsrfToken('authenticate');
	
        return $this->renderLogin(array(
            'last_username' => $lastUsername,
            'error'         => $error,
            'csrf_token' => $csrfToken,
            'societe' => $societe,
            'text' => $text,
        ));	
    }
	 
}

