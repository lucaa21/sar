<?php

namespace Bacloo\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ProfileFormType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', 'text', array('required' => true))
            ->add('prenom', 'text', array('required' => true))
            ->add('activite', 'text', array('required' => false))
            ->add('usersociete', 'text', array('required' => true))
            ->add('usernomsociete', 'text', array('required' => true))
            ->add('desc_rech', 'text', array('required' => false))
            ->add('tags', 'textarea', array('required' => true, 'read_only' => true))
            ->add('actvise', 'text', array('required' => false))
            ->add('note', 'text', array('required' => false, 'read_only' => true))
            ->add('actconnexes', 'text', array('required' => false))
            ->add('credits', 'integer', array('required' => false, 'read_only' => true))
            ->add('textaccueil', 'text', array('required' => false))
            ->add('cp', 'text', array('required' => true))
            ->add('cpuser', 'text', array('required' => false))
            ->add('ville', 'text', array('required' => true))
            ->add('adresse1', 'text', array('required' => true))
            ->add('telephone', 'text', array('required' => false))
            ->add('premium', 'integer', array('required' => false))
            ->add('datepremium', 'date', array('widget' => 'single_text',
										'input' => 'string',
										'format' => 'dd/MM/yyyy',
										'required' => false,
										'read_only' => false,
										'attr' => array('class' => 'date')))
            ->add('finpremium', 'date', array('widget' => 'single_text',
										'input' => 'string',
										'format' => 'dd/MM/yyyy',
										'required' => false,
										'read_only' => false,
										'attr' => array('class' => 'date')))
        ;
    }
	
    public function getParent()
    {
        return 'fos_user_profile';
    }	
    
    public function getName()
    {
        return 'bacloo_user_profile';
    }
}
