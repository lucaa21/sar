<?php
namespace Bacloo\UserBundle\Controller;

use FOS\UserBundle\Controller\RegistrationController as BaseController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Httpfoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Validator\Constraints\Email as EmailConstraint;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\Exception\AccountStatusException;
use FOS\UserBundle\Model\UserInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class RegistrationController extends BaseController
{
    public function registerAction()
    {
        // $response = parent::registerAction();
		
		$em = $this->container->get('doctrine')->getManager();

		include('societe.php');
		
        $form = $this->container->get('fos_user.registration.form');
        $formHandler = $this->container->get('fos_user.registration.form.handler');
        $confirmationEnabled = $this->container->getParameter('fos_user.registration.confirmation.enabled');

	
		
        $process = $formHandler->process($confirmationEnabled);
        if ($process) {
            $user = $form->getData();

            $authUser = false;
            if ($confirmationEnabled) {
                $this->container->get('session')->set('fos_user_send_confirmation_email/email', $user->getEmail());
                $route = 'fos_user_registration_check_email';
            } else {
                $authUser = true;
                $route = 'fos_user_registration_confirmed';
            }

// Set your secret key. Remember to switch to your live secret key in production!
// See your keys here: https://dashboard.stripe.com/account/apikeys
// \Stripe\Stripe::setApiKey('sk_test_oDhzluJ0PvfkuonXtNwpyjwh00HguRgRuF');

// $customer = \Stripe\Customer::create();	
// $user->setStripeid($customer->id);
// $em->flush();

            $this->setFlash('fos_user_success', 'registration.flash.user_created');
            $url = $this->container->get('router')->generate($route);
            $response = new RedirectResponse($url);

            if ($authUser) {
                $this->authenticateUser($user, $response);
            }

            return $response;
        }
			$society = $societe;				
			$chaine = preg_replace("#[^a-zA-Z]#", "", $society);
			$tabact = array(' ', ' & ', '\'');
			$societe = str_replace($tabact, '_', $chaine);
			
			return $this->container->get('templating')->renderResponse('FOSUserBundle:Registration:register.html.'.$this->getEngine(), array(
				'form' => $form->createView(),
				'society' => $societe,
				'societe' => $society,
        ));		
		// $query = $em->createQuery(
			// 'SELECT u.credits
			// FROM BaclooUserBundle:User u
			// WHERE u.usersociete = :usersociete
			// AND u.roleuser = :roleuser');
		// $query->setParameter('usersociete', $societe);
		// $query->setParameter('roleuser', 'admin');
		// $credits = $query->getSingleScalarResult();	
		
		// $query = $em->createQuery(
			// 'SELECT u.username
			// FROM BaclooUserBundle:User u
			// WHERE u.usersociete = :usersociete
			// AND u.roleuser = :roleuser');
		// $query->setParameter('usersociete', $societe);
		// $query->setParameter('roleuser', 'admin');
		// $pseudoadmin = $query->getSingleScalarResult();	
		
		// $query = $em->createQuery(
			// 'SELECT m.module1expiration
			// FROM BaclooCrmBundle:Modules m
			// WHERE m.username = :username');
		// $query->setParameter('username', $pseudoadmin);
		// $expm1 = $query->getSingleScalarResult();
		// $time = $expm1;

		// $var = $expm1;
		// $date = str_replace('/', '-', $var);
		// $expm11 = date("Y-m-d", strtotime($date)); 

		// $d1 = new \DateTime("now");
		// $d2 = new \DateTime($expm11);
		
		// $interval = $d2->diff($d1);
		// $diff = $interval->format('%a');
		// echo $diff;
		// echo $duree;
        // ... do custom stuff
         // return new RedirectResponse($this->container->get('Router')->generate('bacloocrm_conditions_generales_public'));
    }

    /**
     * Tell the user his account is now confirmed
     */
    public function confirmedAction()
    {
        $user = $this->container->get('security.context')->getToken()->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }
			include('societe.php');
			
			$em = $this->container->get('doctrine')->getManager();

			$query = $em->createQuery(
				'SELECT u.email
				FROM BaclooUserBundle:User u
				WHERE u.usersociete = :usersociete
				AND u.roleuser = :roleuser');
			$query->setParameter('usersociete', $societe);
			$query->setParameter('roleuser', 'admin');
			$text = $query->getSingleScalarResult();
			
	

        return $this->container->get('templating')->renderResponse('FOSUserBundle:Registration:confirmed.html.'.$this->getEngine(), array(
            'user' => $user,
			'societe' => $societe
        ));
    }
}