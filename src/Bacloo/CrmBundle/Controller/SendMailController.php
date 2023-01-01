<?php
namespace Bacloo\CrmBundle\SendMailController;

use Symfony\Component\HttpFoundation\Response;

class SenMailController
{
    public function SendEmailMessageAction($body, $fromEmail, $toEmail, $subject)
    {
        $message = \Swift_Message::newInstance()
            ->setSubject($subject)
            ->setFrom($fromEmail)
            ->setTo($toEmail)
            ->setBody($body);

        $this->mailer->send($message);
    }	
	