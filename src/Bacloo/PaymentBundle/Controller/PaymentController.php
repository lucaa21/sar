<?php
// src/Bacloo/PaymentBundle/Controller/PaymentController.php

namespace Bacloo\PaymentBundle\Controller;

use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Payum\Core\Request\GetHumanStatus;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Payum\Core\Model\Payment;
use Payum\Core\Reply\HttpRedirect;
use Payum\Core\Reply\HttpResponse;
use Payum\Core\Request\Capture;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Bacloo\PaymentBundle\Model\PaymentDetails;;
use Payum\Core\Security\SensitiveValue;

use Payum\Core\Security\GenericTokenFactoryInterface;
use Payum\Paypal\ExpressCheckout\Nvp\Api;
use Payum\Core\Registry\RegistryInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration as Extra;
use Symfony\Component\Validator\Constraints\Range;
use Payum\Core\Request\GetCurrency;

use Payum\Core\Security\HttpRequestVerifierInterface;

use Bacloo\UserBundle\Entity\User;

class PaymentController extends Controller 
{


	 /**
	 * @return \Symfony\Component\Form\Form
	 */
	protected function createPurchaseForm()
	{
		 return $this->createFormBuilder()
		->add('amount', null, array(
		'data' => 1,
		'constraints' => array(new Range(array('max' => 2)))
		))
		->add('currency', null, array('data' => 'EUR'))
		->getForm()
		;
	}

	 /**
	* @return RegistryInterface
	*/
	protected function getPayum()
	{
	return $this->get('payum');
	}
	/**
	* @return GenericTokenFactoryInterface
	*/
	protected function getTokenFactory()
	{
	return $this->get('payum.security.token_factory');
	}	

    public function prepareStripeJsPaymentAction($prix, $description, Request $request)
    {
		$session = new Session();
		$date = new \DateTime("now");	
		$user = $this->get('security.context')->getToken()->getUsername();		

		$em = $this->getDoctrine()->getManager();

		$query = $em->createQuery(
			'SELECT u
			FROM BaclooUserBundle:User u
			WHERE u.username = :username'
		)->setParameter('username', $user);
		$u = $query->getSingleResult();
		
		$gatewayName = 'stripe_bacloo';

		$storage = $this->get('payum')->getStorage('Bacloo\PaymentBundle\Entity\Payment');

        /** @var PaymentDetails $details */
        // $details = $storage->create();
        // $details["amount"] = 100;
        // $details["currency"] = 'EUR';
        // $details["description"] = 'a description';
        // $storage->update($details);
		
        /** @var \Bacloo\PaymentBundle\Entity\PaymentDetails $payment */
        $payment = $storage->create();
        $payment->setNumber(uniqid());
        $payment->setCurrencyCode('EUR');
        $payment->setTotalAmount($prix); // 1.23 EUR
        $payment->setDescription($description);
        $payment->setClientId($u->getId());
        $payment->setClientEmail($u->getEmail());
		$payment->setUser($user);
		$payment->setDate($date);
        $storage->update($payment);
        
        $captureToken = $this->get('payum.security.token_factory')->getTokenFactory()->createCaptureToken(
            $gatewayName,
            $details,
            'bacloocrm_paiement' // the route to redirect after capture;
        );

        return $this->redirect($captureToken->getTargetUrl());
    }
	public function preparePaypalExpressCheckoutPaymentAction($prix, $description)
	{
		$session = new Session();
		$date = new \DateTime("now");	
		$user = $this->get('security.context')->getToken()->getUsername();		

		$em = $this->getDoctrine()->getManager();

		$query = $em->createQuery(
			'SELECT u
			FROM BaclooUserBundle:User u
			WHERE u.username = :username'
		)->setParameter('username', $user);
		$u = $query->getSingleResult();
		
		$gatewayName = 'paypal_express_checkout_and_doctrine_orm';

		$storage = $this->get('payum')->getStorage('Bacloo\PaymentBundle\Entity\Payment');

        /** @var \Bacloo\PaymentBundle\Entity\PaymentDetails $payment */
        $payment = $storage->create();
        $payment->setNumber(uniqid());
        $payment->setCurrencyCode('EUR');
        $payment->setTotalAmount($prix); // 1.23 EUR
        $payment->setDescription($description);
        $payment->setClientId($u->getId());
        $payment->setClientEmail($u->getEmail());
		$payment->setUser($user);
		$payment->setDate($date);
        $storage->update($payment);

        $captureToken = $this->get('payum.security.token_factory')->createCaptureToken(
            $gatewayName,
            $payment,
            'bacloocrm_paiement' // the route to redirect after capture;
        );
		
		// Set a session value
		$session->set('number', $payment->getNumber(uniqid()));
        return $this->redirect($captureToken->getTargetUrl());
	}

	public function doneAction(Request $request)
    {
		$user = $this->get('security.context')->getToken()->getUsername();		

        $token = $this->get('payum.security.http_request_verifier')->verify($request);

        $gateway = $this->get('payum')->getGateway($token->getGatewayName());

        // you can invalidate the token. The url could not be requested any more.
        // $this->get('payum.security.http_request_verifier')->invalidate($token);

        // Once you have token you can get the model from the storage directly. 
        //$identity = $token->getDetails();
        //$payment = $payum->getStorage($identity->getClass())->find($identity);

        // or Payum can fetch the model for you while executing a request (Preferred).
        $gateway->execute($status = new GetHumanStatus($token));
        $payment = $status->getFirstModel();
        $statut = $status->getValue();
        $montant = $payment->getTotalAmount();

		$session = new Session();
		$number = $session->get('number');
		$em = $this->getDoctrine()->getManager();
		$number0 = $em->getRepository('PaymentBundle:Payment')
					 ->findOneBy(array('number' => $number, 'statut' => $statut));
		$creditspack = $em->getRepository('PaymentBundle:Payment')
					 ->findOneByNumber($number);			
		if(!isset($number0) && $statut == 'captured')
		{
			$em = $this->getDoctrine()->getManager();
			
			//On récupère les crédits de l'utilisateur connecté
			$query = $em->createQuery(
				'SELECT u.credits
				FROM BaclooUserBundle:User u
				WHERE u.username LIKE :username'
			);
			$query->setParameter('username', $user);				
			$credits = $query->getSingleScalarResult();	

			if($creditspack->getTotalAmount() == 5)
			{
				$creditsht = 30;
			}
			elseif($creditspack->getTotalAmount() == 15)
			{
				$creditsht = 110;
			}
			else
			{
				$creditsht = 550;
			}
			$creditsfinal = $credits + $creditsht;

			$payment = $em->getRepository('PaymentBundle:Payment')
					 ->findOneByNumber($number);
			
			$query = $em->createQuery(
				'SELECT u
				FROM BaclooUserBundle:User u
				WHERE u.username LIKE :username'
			);
			$query->setParameter('username', $user);				
			$acheteur = $query->getSingleResult();	
			$acheteur->setCredits($creditsfinal);
			$payment->setStatut($statut);
			$em->persist($acheteur);
			$em->flush();
		}
			$em = $this->getDoctrine()->getManager();	
			$query = $em->createQuery(
				'SELECT u.credits
				FROM BaclooUserBundle:User u
				WHERE u.username LIKE :username'
			);
			$query->setParameter('username', $user);				
			$creditbase = $query->getSingleScalarResult();			
		
		return $this->render('BaclooCrmBundle:Crm:paiement.html.twig', array('montant' => $montant,
																			 'credits' => $creditbase,
																			  'statut' => $statut));
    }

}