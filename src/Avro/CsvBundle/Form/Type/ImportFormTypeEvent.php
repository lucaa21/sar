<?php
namespace Avro\CsvBundle\Form\Type;

use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

/**
 * CSV Import Form Type
 *
 * @author Joris de Wit <joris.w.dewit@gmail.com>
 */
class ImportFormTypeEvent extends AbstractType
{
    /**
     * Build form
     *
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('delimiter', 'choice', array(
                'label' => 'Quel caractère sépare les colonne de votre fichier',
                'choices' => array(
                    ',' => 'Virgule',
                    ';' => 'Point virgule',
                    '|' => 'Barre verticale |',
                    ':' => 'Deux points :'
                )
            ))
            ->add('file', 'file', array(
                'label' => 'Veuillez choisir un fichier à importer',
                'required' => true,
            ))
            ->add('filename', 'hidden', array(
                'required' => false
            ))
            ->add('fields', 'collection', array(
                'label' => 'Fields',
                'required' => false,
                'type' => 'choice',
                'options' => array(
				'choices'=> array(
					'commentaire' => 'Commentaire')),
					'allow_add' => true,               
            ));

        $builder->addEventListener(FormEvents::PRE_BIND, function (FormEvent $event) {
            $data = $event->getData();

            if (!$data || !array_key_exists('file', $data)) {
                return;
            }

            $data['filename'] = $data['file']->getFilename();
            $event->setData($data);
        });
    }

    /**
     * Set default options
     *
     * @param OptionsResolverInterface $resolver The resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'field_choices' => array()
        ));
    }

    /**
     * Get the forms name
     *
     * @return string name
     */
    public function getName()
    {
        return 'avro_csv_import';
    }
}
