<?php
namespace Bacloo\UserBundle\Controller;

use FOS\UserBundle\Controller\ProfileController as BaseController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Httpfoundation\Response;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Validator\Constraints\Email as EmailConstraint;
use Symfony\Component\Validator\Constraints\DateTime;

use Bacloo\CrmBundle\Entity\Fiche;

use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use FOS\UserBundle\Model\UserInterface;

class ProfileController extends BaseController
{

    /**
     * Show the user
     */
    public function showAction()
    {
        $user = $this->container->get('security.context')->getToken()->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        return $this->container->get('templating')->renderResponse('FOSUserBundle:Profile:show.html.'.$this->container->getParameter('fos_user.template.engine'), array('user' => $user));
    }

    /**
     * Edit the user
     */
    public function editAction()
    {//echo 'daaaaaaaaaaaaaaaaaaa';
        $user = $this->container->get('security.context')->getToken()->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }
		
		$userid = $user->getId();		
		//Ajout de la modif systématique de la fiche client
		$em = $this->container->get('doctrine')->getManager();
		
		$fiche = $em->getRepository('BaclooCrmBundle:Fiche')		
					   ->findOneByNewid($userid);//echo $userid;
		if(empty($fiche))
		{
			$fiche = new Fiche;//echo 'empty fiche';
		}
		
		if(null !== $user->getNom())
		{//echo 'remplissage';
			$fiche->setRaisonSociale($user->getNom());
			$fiche->setPrenom($user->getPrenom());
			$fiche->setUseremail($user->getEmail());
			$fiche->setActivite($user->getActivite());
			$fiche->setTags($user->getTags());
			$fiche->setCp($user->getCp());
			$fiche->setVille($user->getVille());
			$fiche->setAdresse1($user->getAdresse1());
			$fiche->setTelephone($user->getTelephone());
			$fiche->setUSersociete('lead4you');
			$fiche->setTypefiche('client');
			$fiche->setNewid($user->getId());
			
			$em->persist($fiche);
			$em->flush();
		}
		
		//Fin ajout
		
        $form = $this->container->get('fos_user.profile.form');
        $formHandler = $this->container->get('fos_user.profile.form.handler');

        $process = $formHandler->process($user);
        if ($process) {
            $this->setFlash('fos_user_success', 'profile.flash.updated');

            return new RedirectResponse($this->getRedirectionUrl($user));
        }

        return $this->container->get('templating')->renderResponse(
            'FOSUserBundle:Profile:edit.html.'.$this->container->getParameter('fos_user.template.engine'),
            array('form' => $form->createView())
        );
    }

    /**
     * Generate the redirection url when editing is completed.
     *
     * @param \FOS\UserBundle\Model\UserInterface $user
     *
     * @return string
     */
    protected function getRedirectionUrl(UserInterface $user)
    {
        return $this->container->get('router')->generate('fos_user_profile_edit');
    }

    /**
     * @param string $action
     * @param string $value
     */
    protected function setFlash($action, $value)
    {
        $this->container->get('session')->getFlashBag()->set($action, $value);
    }
}
