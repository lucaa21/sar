<?php
// src/Acme/DemoBundle/Command/GreetCommand.php
namespace Avro\CsvBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Bacloo\CrmBundle\Entity\Fiche;
use Bacloo\CrmBundle\Entity\Bcontacts;
use Bacloo\CrmBundle\Entity\Event;
use Bacloo\CrmBundle\Entity\Brappels;

use Avro\CsvBundle\Form\Type\ImportFormType;
use Avro\CsvBundle\Form\Type\ImportFormTypeFiche;
use Avro\CsvBundle\Form\Type\ImportFormTypeContact;
use Avro\CsvBundle\Form\Type\ImportFormTypeEvent;
use Avro\CsvBundle\Form\Type\ImportFormTypeRappels;

use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
 
class ImportCommand extends ContainerAwareCommand
{

    protected function configure()
    {
 
        $this
            ->setName('avro:import')
            ->setDescription('Sends our daily newsletter to our registered users')
            // ->addArgument('fields', InputArgument::OPTIONAL, 'Who do you want to fields?')
            ->addArgument('objUser', InputArgument::OPTIONAL, 'Who do you want to greet?')
            ->addArgument('alias', InputArgument::OPTIONAL, 'Who do you want to greet?')
            ->addArgument('filename', InputArgument::OPTIONAL, 'Who do you want to greet?')
            ->addArgument('delimiter', InputArgument::OPTIONAL, 'Who do you want to greet?')
            ->addArgument('class', InputArgument::OPTIONAL, 'Who do you want to greet?')
            // ->addArgument('em', InputArgument::OPTIONAL, 'Who do you want to greet?')
			
            ;
    }
 
    protected function execute(InputInterface $input, OutputInterface $output)
    {
			// $session = $this->getContainer()->get('session');
			// $session = $request->getSession();
			// echo 'tttttt';
			// $entite = $this->getContainer()->get('session')->get('entity');
		// $fields = $input->getArgument('fields');
		$user = $input->getArgument('objUser');
		$alias = $input->getArgument('alias');
		$filename = $input->getArgument('filename');
		$delimiter = $input->getArgument('delimiter');echo 'AAAAAAAAAAAAAAAAAAA'.$delimiter;
		$class = $input->getArgument('class');
		// $entreprise = str_replace('_', ' ', $boite);echo $entreprise;		
		// $cp = $input->getArgument('cp');//echo 'ppppp'.$cp;echo 'nnnnnnn';

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
				
			$form = $this->getContainer()->get('form.factory')->create(new ImportFormTypeFiche(), null, array('field_choices' => $fieldChoices));
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
			$form = $this->getContainer()->get('form.factory')->create(new ImportFormTypeContact(), null, array('field_choices' => $fieldChoices));	
		}	
		elseif($alias == 'event')
		{//echo 'lox';
			$fieldChoices = array('eventDate' => 'Date',
						'eventComment' => 'Commentaire',		
						'entreprise' => 'entreprise',		
						'cp' => 'cp');			
			$form = $this->getContainer()->get('form.factory')->create(new ImportFormTypeEvent(), null, array('field_choices' => $fieldChoices));	
		}	
		elseif($alias == 'rappels')
		{//echo 'lo';
			$fieldChoices = array(
						'date' => 'Date de relance', 
						'rap_texte' => 'Texte',
						'entreprise' => 'Entreprise',
						'tache' => 'Tâche',
						'rdv' => 'RDV',
						'cp' => 'cp');		
			$form = $this->getContainer()->get('form.factory')->create(new ImportFormTypeRappels(), null, array('field_choices' => $fieldChoices));	
		}
		
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
				
			$form = $this->getContainer()->get('form.factory')->create(new ImportFormTypeFiche(), null, array('field_choices' => $fieldChoices));
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
		elseif($alias == 'rappels')
		{//echo 'lo';
			$fields = array(
						'date' => 'date', 
						'rapTexte' => 'rapTexte',
						'entreprise' => 'entreprise',
						'tache' => 'tache',
						'rdv' => 'rdv',
						'cp' => 'cp');
		}		
			
		
		if($alias == 'fiche')
		{
			$url = 'Bacloo\CrmBundle\Entity\Fiche';
			$class = 'Fiche';
		}
		elseif($alias == 'event')
		{
			$url = 'Bacloo\CrmBundle\Entity\Event';
			$class = 'Event';
		}
		elseif($alias == 'contact')
		{
			$url = 'Bacloo\CrmBundle\Entity\Bcontacts';
			$class = 'Bcontacts';
		}
		elseif($alias == 'rappels')
		{
			$url = 'Bacloo\CrmBundle\Entity\Brappels';
			$class = 'Brappels';
		}
		
		$importer = $this->getContainer()->get('avro_csv.importer');
		$importer->import($fields, $user, $alias, $filename, $delimiter, $class);		
		
		//On charge l'encoder
		$encoders = array(new XmlEncoder(), new JsonEncoder());
		$normalizers = array(new GetSetMethodNormalizer());
		$serializer = new Serializer($normalizers, $encoders);
		// echo getcwd() . "\n";		
		// $fichier = fopen("$user.json", "w+");
		// $entite = file_get_contents('/var/www/bacloo/web/'.$user.'.json');//echo 'XXXXXX'.$entite;
		$entite = file_get_contents('C:\EasyPHP-Devserver-17\eds-www\symfony2\web\jmr.json');//echo 'XXXXXX'.$entite;
		$person = $serializer->deserialize($entite, $url, 'json');var_dump($person);
		// $entite2 = file_get_contents('/var/www/bacloo/web/'.$userid.'.json');		//echo 'XXXXXX'.$entite;
		$em = $this->getContainer()->get('doctrine')->getManager();
		$em->persist($person);
		$em->flush($person);

	}
}