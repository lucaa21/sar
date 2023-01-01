<?php

namespace Bacloo\UserBundle\Form;

use Symfony\Component\Form\FormBuilderInterface;
use FOS\UserBundle\Form\Type\RegistrationFormType as BaseType;

class RegistrationFormType extends BaseType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
		parent::buildForm($builder, $options);
        $builder
            ->add('parrain')
            ->add('usersociete')
            ->add('nomrep');
    }
	
    // public function getParent()
    // {
        // return 'fos_user_registration';
    // }	
    
    public function getName()
    {
        return 'bacloo_user_registration';
    }
}
