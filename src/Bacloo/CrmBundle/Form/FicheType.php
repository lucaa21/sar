<?php

namespace Bacloo\CrmBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Bacloo\CrmBundle\Entity\Pipeline;
use Bacloo\CrmBundle\Entity\PipelineRepository;

class FicheType extends AbstractType
{
    public function __construct($userid)
    {
    $this->userid = $userid;
    }

        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
	$userid = $this->userid;
        $builder
            ->add('raisonSociale', 'text')
            ->add('adresse1', 'text', array('required' => false))
            ->add('adresse2', 'text', array('required' => false))
            ->add('adresse3', 'text', array('required' => false))
            ->add('cp', 'text', array('required' => false))
            ->add('ville', 'text', array('required' => false))
            ->add('telephone', 'text', array('required' => false))
            ->add('fax', 'text', array('required' => false))
            ->add('siteWeb', 'text', array('required' => false))
            ->add('user', 'text', array('required' => false, 'read_only' => true))
            ->add('tags', 'textarea', array('required' => false))
            ->add('activite', 'text', array('required' => false))
            ->add('useremail', 'text', array('required' => false))
            ->add('descbesoins', 'textarea', array('required' => false))
            ->add('aVendre', 'checkbox', array('required' => false))
            ->add('aVendrec', 'checkbox', array('required' => false))
            ->add('assurance', 'checkbox', array('required' => false))
            ->add('prixsscont', 'text', array('required' => false))
            ->add('prixavcont', 'text', array('required' => false))
            ->add('usersociete', 'text', array('required' => false))
            ->add('potentiel', 'integer', array('required' => false))
            ->add('cperso1', 'text', array('required' => false))
            ->add('cperso2', 'text', array('required' => false))
            ->add('cperso3', 'text', array('required' => false))
            ->add('statutcompte', 'checkbox', array('required' => false))
            ->add('encours', 'number', array('required' => false))
            ->add('soldeimpayes', 'number', array('required' => false))
            ->add('chequeencoffre', 'checkbox', array('required' => false))
            ->add('montantcheque', 'text', array('required' => false))
            ->add('raisonblocage', 'text', array('required' => false))
            ->add('datedepot', 'date', array('widget' => 'single_text',
										'input' => 'string',
										'format' => 'dd/MM/yyyy',
										'required' => false,
										'attr' => array('class' => 'date'),
										))
            ->add('typefiche', 'choice', array(
					'choices'   => array(
						'prospect'   => 'Prospect',
						'client' => 'Client',
						'loueur' => 'Loueur',
						'fournisseur' => 'Fournisseur',
						'corbeille'   => 'Corbeille',
					),
					'multiple'  => false,
				))
            ->add('typeclient', 'choice', array(
					'choices'   => array(
						'france'   => 'France',
						//'ue' => 'UE',
						'export' => 'Etranger',
					),
					'multiple'  => false,
				))
			->add('memo', new MemoType()) // Rajoutez cette ligne		
			->add('bcontacts', 'collection', array(
			'type'         => new BcontactsType(),
			  'allow_add'    => true,
			  'allow_delete' => true,
			  'required'     => false	
		  ))
			->add('event', 'collection', array(
			'type'         => new EventType(),
			  'allow_add'    => true,
			  'allow_delete' => true,
			  'required'     => false	
		  ))
			->add('brappels', 'collection', array(
			'type'         => new BrappelsType(),
			  'allow_add'    => true,
			  'allow_delete' => true,
			  'required'     => false	
		  ))
			->add('alteruser', 'collection', array(
			  'type'         => new AlteruserType(),
			  'allow_add'    => true,
			  'allow_delete' => true,
			  'required'     => false	
		  ))
			->add('grille', 'collection', array(
			  'type'         => new GrilleType(),
			  'allow_add'    => true,
			  'allow_delete' => true,
			  'required'     => false	
		  ))
			->add('grillesl', 'collection', array(
			  'type'         => new GrilleslType(),
			  'allow_add'    => true,
			  'allow_delete' => true,
			  'required'     => false	
		  ))
			->add('commandes', 'collection', array(
			  'type'         => new CommandesType(),
			  'allow_add'    => true,
			  'allow_delete' => true,
			  'required'     => false	
		  ))
            ->add('lastmodif', 'date', array('widget' => 'single_text',
										'input' => 'datetime',
										'format' => 'dd/MM/yyyy',
										'required' => false,
										'read_only' => true,
										'attr' => array('class' => 'lastmodif')
		  ))
            ->add('delaireglement', 'choice', array(
					'choices'   => array(
						1 => 'Comptant',
						2 => '45 jours fdm',
						3 => '30 jours',
					),
					'multiple'  => false,
				))

            ->add('pipeline', 'entity', array(
                    'class' => 'BaclooCrmBundle:Pipeline',
                    'query_builder' => function ($repository) use ($userid){return $repository->createQueryBuilder('p')
																->where('p.userid = :userid')
																->setParameter('userid', $userid);},				
                    'property' => 'pipename',
                ))
            ->add('montantrc', 'number', array('required' => false))
            ->add('montanteco', 'number', array('required' => false))
            ->add('uniterc', 'choice', array(
					'choices'   => array(
						'%'=> '%',
						'€' => '€',
					),
					'multiple'  => false,
				))
            ->add('uniteeco', 'choice', array(
					'choices'   => array(
						'%'=> '%',
						'€' => '€',
					),
					'multiple'  => false,
				))
            ->add('basecalculrc', 'choice', array(
					'choices'   => array(
						'1'=> 'Le 1er jour',
						'5' => '5 jrs sur 7',
						'7' => '7 jrs sur 7',
					),
					'multiple'  => false,
				))
            ->add('basecalculeco', 'choice', array(
					'choices'   => array(
						'1'=> 'Le 1er jour',
						'5' => '5 jrs sur 7',
						'7' => '7 jrs sur 7',
					),
					'multiple'  => false,
				))
            ->add('frsrc', 'checkbox', array('required' => false))
            ->add('frseco', 'checkbox', array('required' => false))
            ->add('newid', 'text', array('required' => false))
            ->add('dureemoypaiement', 'integer', array('required' => false))
            ->add('typepaiement', 'choice', array(
					'choices'   => array(
						'vide'   => '',
						'virement'   => 'Virement',
						'cheque' => 'Chèque',
						'lcr' => 'LCR',
						'cb' => 'CB',
						'vad' => 'VAD',
						'traite' => 'Traite',
						'espece' => 'Espèce',
						'bao' => 'BAO',
					),
					'multiple'  => false,
				))
            ->add('typedebien', 'choice', array(
					'choices'   => array(
						'1'   => 'Appartement',
						'2' => 'Maison',
						'3' => 'Immeuble',
						'4'=> 'Terrain',
						'5' => 'Autre',
					),
					'multiple'  => false,
				))
            ->add('debuttravaux', 'choice', array(
					'choices'   => array(
						'1' => 'Urgent',
						'2' => 'Dans les 6 mois',
						'3' => 'Dans l\'année',
						'4' => ' Dans plus d\’un an',
					),
					'multiple'  => false,
				))
            ->add('description', 'textarea', array('required' => true))
            ->add('civilite', 'text', array('required' => false))
            ->add('prenom', 'text', array('required' => true))
            ->add('detail1', 'text', array('required' => true))
            ->add('typepersonne', 'choice', array(
					'choices'   => array(
						'1' => 'Particulier',
						'2' => 'Professionnel',
						'3' => 'Syndicat de co-propriété',
						'4' => 'Autre',
					),
					'multiple'  => false,
				))
            ->add('cleapi', 'text', array('required' => false))
            ->add('categorieid', 'integer', array('required' => true))
            ->add('typedemandeur', 'choice', array(
					'choices'   => array(
						'1' => 'Propriétaire / Futur propriétaire',
						'2' => 'Locataire / Futur locataire',
						'3' => 'Administrateur',
						'4' => 'Autre',
					),
					'multiple'  => false,
				))
            ->add('exclusif', 'number', array('required' => false))
            ->add('nbacheteur', 'integer', array('required' => false))
            ->add('nbacheteurexclusif', 'integer', array('required' => false))
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
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Bacloo\CrmBundle\Entity\Fiche'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'bacloo_crmbundle_fiche';
    }
}
