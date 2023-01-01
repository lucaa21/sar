<?php

/**
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Avro\CsvBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\HttpFoundation\Session\Session;

use Avro\CsvBundle\Form\Type\ImportFormType;
use Avro\CsvBundle\Form\Type\ImportFormTypeFiche;
use Avro\CsvBundle\Form\Type\ImportFormTypeContact;
use Avro\CsvBundle\Form\Type\ImportFormTypeEvent;
use Avro\CsvBundle\Form\Type\ImportFormTypeGrille;
use Avro\CsvBundle\Form\Type\ImportFormTypeGrillesl;

/**
 * Csv Import controller.
 *
 * @author Joris de Wit <joris.w.dewit@gmail.com>
 */
class ImportController extends ContainerAware
{
    /**
     * Upload a csv.
     *
     * @param string $alias The objects alias
     *
     * @return View
     */
    public function uploadAction($alias, $id)
    {
        $fieldChoices = $this->container->get('avro_csv.field_retriever')->getFields($this->container->getParameter(sprintf('avro_csv.objects.%s.class', $alias)), 'title', true);

		if($alias == 'fiche')
		{		
			$form = $this->container->get('form.factory')->create(new ImportFormTypeFiche(), null, array('field_choices' => $fieldChoices));
		}
		elseif($alias == 'contact')
		{
			$form = $this->container->get('form.factory')->create(new ImportFormTypeContact(), null, array('field_choices' => $fieldChoices));	
		}	
		elseif($alias == 'event')
		{
			$form = $this->container->get('form.factory')->create(new ImportFormTypeEvent(), null, array('field_choices' => $fieldChoices));	
		}	
		elseif($alias == 'grille')
		{
			$form = $this->container->get('form.factory')->create(new ImportFormTypeGrille(), null, array('field_choices' => $fieldChoices));	
		}	
		elseif($alias == 'grillesl')
		{
			$form = $this->container->get('form.factory')->create(new ImportFormTypeGrillesl(), null, array('field_choices' => $fieldChoices));	
		}
        return $this->container->get('templating')->renderResponse('AvroCsvBundle:Import:upload.html.twig', array(
            'form' => $form->createView(),
            'alias' => $alias,
            'id' => $id
        ));

    }
	
	private function convert( $str ) {
		foreach(array_keys($str) as $key){
			$str[$key] = iconv("Windows-1252", "UTF-8", $str[$key]);
		} 
		return $str;
	}
	
    /**
     * Move the csv file to a temp dir and get the user to map the fields.
     *
     * @param Request $request The request
     * @param string  $alias   The objects alias
     *
     * @return view
     */
    public function mappingAction(Request $request, $alias, $id)
    {
	// echo '$alias'.$alias;

	if($alias == 'fiche')
	{//echo 'ici';
        $fieldChoices = array(
					'raisonSociale' => 'Raison Sociale', 
					'adresse1' => 'Adresse 1',
					'adresse2' => 'Adresse 2',
					'adresse3' => 'Adresse 3',
					'activite' => 'Activité',
					'cp' => 'Code Postal',
					'ville' => 'Ville',
					'telephone' => 'Téléphone',
					'fax' => 'Fax',
					'siteWeb' => 'Site Web',
					'cperso1' => 'Champ personnalisé 1',
					'cperso2' => 'Champ personnalisé 2',
					'cperso3' => 'Champ personnalisé 3');
				
        $form = $this->container->get('form.factory')->create(new ImportFormTypeFiche(), null, array('field_choices' => $fieldChoices));
	}
	elseif($alias == 'contact')
	{//echo 'la';
        $fieldChoices = array(
					'civilite' => 'Civilité', 
					'nom' => 'Nom',
					'prenom' => 'Prénom',
					'fonction' => 'Fonction',
					'tel1' => 'Tel 1',
					'tel2' => 'Tel 2',
					'email' => 'e-mail',
					'commentaire' => 'Commentaire',
					'entreprise' => 'entreprise',		
					'cp' => 'cp');			
        $form = $this->container->get('form.factory')->create(new ImportFormTypeContact(), null, array('field_choices' => $fieldChoices));	
	}	
	elseif($alias == 'event')
	{//echo 'lo';
        $fieldChoices = array('eventDate' => 'Date',
						'eventComment' => 'Commentaire',		
						'entreprise' => 'entreprise',		
						'cp' => 'cp');	
        $form = $this->container->get('form.factory')->create(new ImportFormTypeEvent(), null, array('field_choices' => $fieldChoices));	
	}	
	elseif($alias == 'grille' or $alias == 'grillesl')
	{//echo 'lo';
// echo $id;
		$fieldChoices = array('codemachineinterne' => 'Code machine',		
						'hauteur' => 'Hauteur',		
						'typemachine' => 'Description',		
						'loyerp1' => 'Loyer 1j',
						'loyerp2' => 'Loyer 2-5j',
						'loyerp3' => 'Loyer 6-15j',
						'loyerp4' => 'Loyer > 15j',
						'loyermensuel' => 'Mois',
						'type' => 'Type',
						'energie' => 'Energie');	
        $form = $this->container->get('form.factory')->create(new ImportFormTypeGrille(), null, array('field_choices' => $fieldChoices));	
	}
        if ('POST' == $request->getMethod()) {
            $form->bind($request);
            if ($form->isValid()) {
                $reader = $this->container->get('avro_csv.reader');

                $file = $form['file']->getData();
                $filename = $file->getFilename();

                $tmpUploadDir = $this->container->getParameter('avro_csv.tmp_upload_dir');

                $file->move($tmpUploadDir);

                $reader->open(sprintf('%s%s', $tmpUploadDir, $filename), $form['delimiter']->getData());

                $headers = $this->container->get('avro_case.converter')->toTitleCase($reader->getHeaders());

                $rows = $this->convert($reader->getRow($this->container->getParameter('avro_csv.sample_count')));
//print_r($rows);
                return $this->container->get('templating')->renderResponse('AvroCsvBundle:Import:mapping.html.twig', array(
                    'form' => $form->createView(),
                    'alias' => $alias,
                    'id' => $id,
                    'headers' => $headers,
                    'headersJson' => json_encode($headers, JSON_FORCE_OBJECT),
                    'rows' => $rows
                ));
            }
        } else {
            return new RedirectResponse($this->container->get('router')->generate($this->container->getParameter(sprintf('avro_csv.objects.%s.redirect_route', $alias))));
        }
    }

    /**
     * Previews the uploaded csv and allows the user to map the fields.
     *
     * @param Request $request The request
     * @param string  $alias   The objects alias
     *
     * @return view
     */
    public function processAction(Request $request, $alias, $id)
    {
		if($alias == 'fiche')
		{//echo 'ici';
			$fieldChoices = array(
						'raisonSociale' => 'Raison Sociale', 
						'adresse1' => 'Adresse 1',
						'adresse2' => 'Adresse 2',
						'adresse3' => 'Adresse 3',
						'activite' => 'Activité',
						'cp' => 'Code Postal',
						'ville' => 'Ville',
						'telephone' => 'Téléphone',
						'fax' => 'Fax',
						'siteWeb' => 'Site Web',
						'cperso1' => 'Champ personnalisé 1',
						'cperso2' => 'Champ personnalisé 2',
						'cperso3' => 'Champ personnalisé 3');
				
			$form = $this->container->get('form.factory')->create(new ImportFormTypeFiche(), null, array('field_choices' => $fieldChoices));
		}
		elseif($alias == 'contact')
		{//echo 'la';
			$fieldChoices = array(
						'civilite' => 'Civilité', 
						'nom' => 'Nom',
						'prenom' => 'Prénom',
						'fonction' => 'Fonction',
						'tel1' => 'Tel 1',
						'tel2' => 'Tel 2',
						'email' => 'e-mail',
						'commentaire' => 'Commentaire',
						'entreprise' => 'entreprise',		
						'cp' => 'cp');			
			$form = $this->container->get('form.factory')->create(new ImportFormTypeContact(), null, array('field_choices' => $fieldChoices));	
		}	
		elseif($alias == 'event')
		{//echo 'lox';
			$fieldChoices = array('eventDate' => 'Date',
						'eventComment' => 'Commentaire',		
						'entreprise' => 'entreprise',		
						'cp' => 'cp');			
			$form = $this->container->get('form.factory')->create(new ImportFormTypeEvent(), null, array('field_choices' => $fieldChoices));	
		}	
		elseif($alias == 'grille' or $alias == 'grillesl')
		{//echo 'lox';
// echo $id;		
			$fieldChoices = array('codemachineinterne' => 'Code machine',		
							'hauteur' => 'Hauteur',			
							'typemachine' => 'Description',		
							'loyerp1' => 'Loyer 1j',
							'loyerp2' => 'Loyer 2-5j',
							'loyerp3' => 'Loyer 6-15j',
							'loyerp4' => 'Loyer > 15j',
							'loyermensuel' => 'Mois',
							'type' => 'Type',
							'energie' => 'Energie');			
			$form = $this->container->get('form.factory')->create(new ImportFormTypeGrille(), null, array('field_choices' => $fieldChoices));	
		}

		$user = $this->container->get('security.context')->getToken()->getUser();
// echo '001';

			if ('POST' == $request->getMethod()) 
			{
				$form->bind($request);
	// echo '02';
				if ($form->isValid()) {
					$importer = $this->container->get('avro_csv.importer');
	// echo '3';
					$importer->init(
						sprintf(
							'%s%s', 
							$this->container->getParameter('avro_csv.tmp_upload_dir'),
							$form['filename']->getData()
						),
						$this->container->getParameter(sprintf('avro_csv.objects.%s.class', $alias)), 
						$form['delimiter']->getData()
					);
	// echo '4';
					if($alias == 'fiche')
					{//echo 'ici';
						$fields = array(
									'raisonSociale' => 'raisonSociale', 
									'adresse1' => 'adresse1',
									'adresse2' => 'adresse2',
									'adresse3' => 'adresse3',
									'activite' => 'activite',
									'cp' => 'cp',
									'ville' => 'ville',
									'telephone' => 'telephone',
									'fax' => 'fax',
									'siteWeb' => 'Site Web',
									'cperso1' => 'cperso1',
									'cperso2' => 'cperso2',
									'cperso3' => 'cperso3');
							
						$form = $this->container->get('form.factory')->create(new ImportFormTypeFiche(), null, array('field_choices' => $fieldChoices));
					}
					elseif($alias == 'contact')
					{//echo 'la';
						$fields = array(
									'civilite' => 'civilite', 
									'nom' => 'nom',
									'prenom' => 'prenom',
									'fonction' => 'fonction',
									'tel1' => 'tel1',
									'tel2' => 'tel2',
									'email' => 'email',
									'commentaire' => 'Commentaire',
									'entreprise' => 'entreprise',		
									'cp' => 'cp');	
					}	
					elseif($alias == 'event')
					{//echo 'lo';
						$fields = array('eventDate' => 'eventDate',
						'eventComment' => 'eventComment',		
						'entreprise' => 'entreprise',		
						'cp' => 'cp');
					}	
					elseif($alias == 'grille' or $alias == 'grillesl')
					{echo 'grille';
						$fields = array(
									'codemachineinterne' => 'codemachineinterne',		
									'hauteur' => 'hauteur',			
									'typemachine' => 'typemachine',		
									'loyerp1' => 'loyerp1',
									'loyerp2' => 'loyerp2',
									'loyerp3' => 'loyerp3',
									'loyerp4' => 'loyerp4',
									'loyermensuel' => 'loyermensuel',
									'type' => 'type',
									'energie' => 'energie');	
					}
// echo $id;		
					$importer->import($fields, $user, $alias, $id, $request);
					$session = $request->getSession();
					$pi= $session->get('pi');//echo '$pipooooo'.$pi;
					
					if($pi == 'pok' && isset($pi))
					{//echo 'pokemon';
						$this->container->get('session')->getFlashBag()->add(
										'Erreur', '!!! ERREUR !!! Aucune donnée importée !
										Le séparateur de colonne sélectionné n\'est pas le bon. Veuillez en sélectionner un autre.');
						$session->set('pi', 'o');
						return new RedirectResponse($this->container->get('router')->generate($this->container->getParameter(sprintf('avro_csv.objects.%s.redirect_route', $alias))));
					}							
							 $this->container->get('session')->getFlashBag()->add(
									'BRAVO',
									$importer->getImportCount()
								);
							// $this->container->get('session')->getFlashBag()->set('', $importer->getImportCount().' items imported.');
			// echo '3';
				} 
				else 
				{
					$this->container->get('session')->getFlashBag()->set('Erreur', 'Import failed. Please try again.');
				}
			}

		return new RedirectResponse($this->container->get('router')->generate($this->container->getParameter(sprintf('avro_csv.objects.%s.redirect_route', $alias))));

    }
}
