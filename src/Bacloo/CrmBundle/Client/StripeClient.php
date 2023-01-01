<?php
 
namespace Bacloo\CrmBundle\Client;
 
use Bacloo\UserBundle\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Bacloo\CrmBundle\Stripe\lib\Charge;
use Bacloo\CrmBundle\Stripe\lib\Stripe;
// use Stripe\Error\Base;
 
class StripeClient
{
  private $config;
  private $em;
  private $logger;
 
  public function __construct($secretKey, array $config, EntityManagerInterface $em, LoggerInterface $logger)
  {
    \Stripe\Stripe::setApiKey($secretKey);
    $this->config = $config;
    $this->em = $em;
    $this->logger = $logger;
  }
 
  public function createPremiumCharge(User $user, $token, $montant)
  {
	// $session = new Session();
	// $session = $request->getSession();
	$session = \Stripe\Checkout\Session::create([
	  'payment_method_types' => ['card'],
	  'line_items' => [[
		'name' => 'T-shirt',
		'description' => 'Comfortable cotton t-shirt',
		'images' => ['https://example.com/t-shirt.png'],
		'amount' => 500,
		'currency' => 'eur',
		'quantity' => 1,
	  ]],
	  'success_url' => 'https://example.com/success?session_id={CHECKOUT_SESSION_ID}',
	  'cancel_url' => 'https://example.com/cancel',
	]);
	// $session->set('transaction', $transaction);
    // try {
      // $charge = \Stripe\Charge::create([
        // 'amount' => $this->config['decimal'] ? $montant * 100 : $this->config['premium_amount'],
        // 'currency' => $this->config['currency'],
        // 'description' => 'Premium blog access',
        // 'source' => $token,
        // 'receipt_email' => $user->getEmail(),
      // ]);
    // } catch (\Stripe\Error\Base $e) {
      // $this->logger->error(sprintf('%s exception encountered when creating a premium payment: "%s"', get_class($e), $e->getMessage()), ['exception' => $e]);
 
      // throw $e;
    // }
 
    // $user->setChargeId($charge->id);
    // $user->setPremium($charge->paid);
    // $this->em->flush();
  }
}