<?php

namespace Bacloo\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UserType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('prenom')
            ->add('activite')
            ->add('desc_rech')
			->add('actvise')
            ->add('tags')
            ->add('credits')
        ;
    }
 //!!!!!!!!!!!!!!!!!!!!!!!!!!!! Les modifs se font dans ProfileFormType  !!!!!!!!!!!!!!!!!!!!!!!!!
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Bacloo\UserBundle\Entity\User'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'bacloo_userbundle_user';
    }
}
