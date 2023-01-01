<?php

namespace Bacloo\CrmBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class MissionsType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre')
            ->add('datedebut', 'date', array('widget' => 'single_text',
                                    'input' => 'string',
                                    'format' => 'dd/MM/yyyy',
                                    'required' => false,
                                    'read_only' => false,
                                    'attr' => array('class' => 'echeance'),
                                    ))
            ->add('datefin', 'date', array('widget' => 'single_text',
                                    'input' => 'string',
                                    'format' => 'dd/MM/yyyy',
                                    'required' => false,
                                    'read_only' => false,
                                    'attr' => array('class' => 'echeance'),
                                    ))
            ->add('adresse')
            ->add('codepostal')
            ->add('ville')
            ->add('raisonsociale')
            ->add('description')
            ->add('dresscode')
            ->add('urgent', 'checkbox', array('required' => false))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Bacloo\CrmBundle\Entity\Missions'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'bacloo_crmbundle_missions';
    }
}
