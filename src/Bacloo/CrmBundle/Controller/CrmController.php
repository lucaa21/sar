<?php
namespace Bacloo\CrmBundle\Controller;
// namespace Symfony\Component\HttpClient;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Httpfoundation\Response;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Validator\Constraints\Email as EmailConstraint;
use Symfony\Component\Form\Extension\Core\ChoiceList\ChoiceList;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Filesystem\Filesystem;

use RecursiveIteratorIterator;
use RecursiveArrayIterator;
use RecursiveDirectoryIterator;

use Symfony\Component\HttpClient\CurlHttpClient;
use Symfony\Component\HttpClient\NativeHttpClient;

use Symfony\Component\Validator\Constraints\NotBlank;

use Bacloo\CrmBundle\Entity\Missions;
use Bacloo\CrmBundle\Entity\MissionsPostule;
use Bacloo\UserBundle\Entity\User;
use Bacloo\CrmBundle\Entity\Document;

use Bacloo\CrmBundle\Form\MissionsType;
use Bacloo\CrmBundle\Form\MissionsPostuleType;

use Symfony\Component\Validator\Constraints\DateTime;
use DateInterval;
use DatePeriod;

class CrmController extends Controller
{		
	public function accueilAction()
	{
		//Récupère le nom d'utilisateur
		$username = $this->get('security.context')->getToken()->getUsername(); if(empty($username) or !isset($username) or $username == 'anon.'){return $this->redirect($this->generateUrl('fos_user_security_login'));}
		
		$em = $this->getDoctrine()->getManager(); //récupérer username de l'utilisateur connecté
		$userdetails  = $em->getRepository('BaclooUserBundle:User')				
		->findOneByUsername($username);	   //Récupérer toutes les variables de l'utilisateur en question
		$roleuser=$userdetails->getRoleuser();	
		
		//Rediriger l'utilisateur vers la boone page après connexion
		if($roleuser=='agence' or $roleuser=='admin')  
		{
			return $this->redirect($this->generateUrl('bacloocrm_agence'));
		}
		else
		{
			return $this->redirect($this->generateUrl('bacloocrm_employe'));
		}
	}

		
	public function agenceAction($onglet, $nom, Request $request)
	{
		//La ligne ci-dessous récupère le pseudo de l'utilisateur connecté
		$username = $this->get('security.context')->getToken()->getUsername(); if(empty($username) or !isset($username) or $username == 'anon.'){return $this->redirect($this->generateUrl('fos_user_security_login'));}//Récupère le nom d'utilisateur
		$em = $this->getDoctrine()->getManager();
		
		//Ci-dessou récupères toutes les données de l'utilisateur connecté dans la table user
		//Nécessaire pour avoir agenceid
		$userdetails  = $em->getRepository('BaclooUserBundle:User')				
					   ->findOneByUsername($username);


		// On crée un objet Mission
		$mission = new Missions;
		//ON crée le formulaire à partir de la structure de l'entité mission
		$form = $this->createForm(new MissionsType(), $mission);		//création du formlaire profil employé non basé sur l'entité user
		//On s'en servira pour hydrater user une fois les données postées
		$defaultData2 = array();

		$form2 = $this->createFormBuilder($defaultData2)
		->add('nom', 'text', array('required' => false))
		->getForm();

		//Traitement des données postées et hydratation de user
		$request = $this->get('request');
		// On vérifie qu'elle est de type POST
		if ($request->getMethod() == 'POST')
		{
			// On fait le lien Requête <-> Formulaire
			// À partir de maintenant, la variable $fiche contient les valeurs entrées dans le formulaire rempli par le visiteur
			
			//if ($form->isValid())
			if(isset($form) and $onglet != 'profils')
			{

				$form->bind($request);
				$mission->setAgenceid($userdetails->getId());
				$mission->setNbaccepte(0);
				$em->persist($mission);
				$em->flush();
				$onglet = 'missions';
				return $this->redirect($this->generateUrl('bacloocrm_agence', array('onglet' => $onglet)));
			}
			
			if(isset($form2) and !empty($form2) and $onglet == 'profils')
			{
				$form2->handleRequest($request);
				$data = $form2->getData();
				$nom = $data['nom'];
				$onglet = 'profils';
			}
		}

		// On récupère tous les users en fonction de l'onglet sélectionné
		if($onglet == 'profils')
		{
			if($nom == '0')
			{
				$query = $em->createQuery(
					'SELECT m
					FROM BaclooUserBundle:User m
					WHERE m.roleuser = :roleuser
					ORDER BY m.nom ASC'
				);
				$query->setParameter('roleuser', 'employe');
				$users = $query->getResult();
			}
			else
			{
				$query = $em->createQuery(
					'SELECT m
					FROM BaclooUserBundle:User m
					WHERE m.roleuser = :roleuser
					AND m.nom LIKE :nom
					ORDER BY m.nom ASC'
				);
				$query->setParameter('roleuser', 'employe');
				$query->setParameter('nom', '%'.$nom.'%');
				$users = $query->getResult();
			}
		}
		else
		{
			$users  = $em->getRepository('BaclooUserBundle:User')
						->findBy(array('roleuser' => 'employe'),array('username'=>'ASC'));	
		}
		
		$documents  = $em->getRepository('BaclooCrmBundle:Document')
		->findAll();

		$missions  = $em->getRepository('BaclooCrmBundle:Missions')
		->findAll();

		$query = $em->createQuery(
			'SELECT m
			FROM BaclooCrmBundle:MissionsPostule m
			WHERE m.datedebut > :today
			ORDER BY m.datedebut ASC'
		);
		$query->setParameter('today', date('Y-m-d'));
		$missionpostule = $query->getResult();

		$query = $em->createQuery(
			'SELECT m
			FROM BaclooCrmBundle:MissionsPostule m
			WHERE m.datedebut > :today
			AND m.accepte = :nul and m.refuse = :nul 
			ORDER BY m.datedebut ASC'
		);
		$query->setParameter('nul', 0);
		$query->setParameter('today', date('Y-m-d'));
		$missionpostule2 = $query->getResult();
		
		//Récupération de la liste des missions urgentes
		$query = $em->createQuery(
			'SELECT m
			FROM BaclooCrmBundle:Missions m
			WHERE m.urgent = :urgent
			AND m.datedebut > :today
			ORDER BY m.datedebut ASC'
		);
		$query->setParameter('urgent', 1);
		$query->setParameter('today', date('Y-m-d'));
		$missions1 = $query->getResult();

		//Récupération de la liste des missions non urgentes
		$query = $em->createQuery(
			'SELECT m
			FROM BaclooCrmBundle:Missions m
			WHERE m.urgent = :urgent
			AND m.datedebut >= :today
			ORDER BY m.datedebut ASC'
		);
		$query->setParameter('urgent', 0);
		$query->setParameter('today', date('Y-m-d'));
		$missions0 = $query->getResult();

		//Appel du template et passage des variables pour appel dans le template
		return $this->render('BaclooCrmBundle:Crm:agence.html.twig', array(
			'form' => $form->createView(),
			'form2' => $form2->createView(),
			'missions1'=> $missions1,
			'missions0'=> $missions0,		
			'missions'=> $missions,		
			'userdetails'=> $userdetails,
			'documents'=> $documents,
			'users' => $users,
			'onglet' => $onglet,
			'missionpostule' => $missionpostule,
			'missionpostule2' => $missionpostule2
		));						
	}


	public function employeAction(Request $request)
	{
		//La ligne ci-dessous récupère le pseudo de l'utilisateur connecté
		$username = $this->get('security.context')->getToken()->getUsername(); if(empty($username) or !isset($username) or $username == 'anon.'){return $this->redirect($this->generateUrl('fos_user_security_login'));}//Récupère le nom d'utilisateur
		$em = $this->getDoctrine()->getManager();
		
		//Ci-dessou récupères toutes les données de l'utilisateur connecté dans la table user
		//Nécessaire pour avoir agenceid
		$userdetails  = $em->getRepository('BaclooUserBundle:User')				
					   ->findOneByUsername($username);
		$userID=$userdetails->getID();	
		//Récupération de la liste des missions
		//$missions1  = $em->getRepository('BaclooCrmBundle:Missions')				
		//			   ->findby(array('urgent' => 1),array('datedebut' => 'asc'));
		//$missions0  = $em->getRepository('BaclooCrmBundle:Missions')				
		//			   ->findby(array('urgent' => 0),array('datedebut' => 'asc'));
		
		$query = $em->createQuery(
			'SELECT m
			FROM BaclooCrmBundle:Missions m
			WHERE m.urgent = :urgent
			AND m.datedebut >= :today
			ORDER BY m.datedebut ASC'
			);
		$query->setParameter('urgent', 0);
		$query->setParameter('today', date('Y-m-d'));
		$missions0 = $query->getResult();
		
		$query = $em->createQuery(
			'SELECT m
			FROM BaclooCrmBundle:Missions m
			WHERE m.urgent = :urgent
			AND m.datedebut > :today
			ORDER BY m.datedebut ASC'
		);
		$query->setParameter('urgent', 1);
		$query->setParameter('today', date('Y-m-d'));
		$missions1 = $query->getResult();

		
		// Récupération des missions passées d'un employé, de ses missions du jour et futures.
		$query = $em->createQuery(
			'SELECT m
			FROM BaclooCrmBundle:MissionsPostule m
			WHERE  m.profilid = :profilid
			AND m.datefin < :today
			ORDER BY m.datedebut ASC'
		);
		$query->setParameter('profilid', $userID);
		$query->setParameter('today', date('Y-m-d'));
		$missionpasse = $query->getResult();

		$query = $em->createQuery(
			'SELECT m
			FROM BaclooCrmBundle:MissionsPostule m
			WHERE  m.profilid = :profilid
			AND m.datefin = :today
			AND m.accepte = :accepte
			ORDER BY m.datedebut ASC'
		);
		$query->setParameter('profilid', $userID);
		$query->setParameter('accepte', 1);
		$query->setParameter('today', date('Y-m-d'));
		$missionjour = $query->getResult();


		$query = $em->createQuery(
			'SELECT m
			FROM BaclooCrmBundle:MissionsPostule m
			WHERE m.profilid = :profilid
			AND m.datedebut > :today
			AND m.accepte = :accepte
			ORDER BY m.datedebut ASC'
		);
		$query->setParameter('profilid', $userID);
		$query->setParameter('accepte', 1);
		$query->setParameter('today', date('Y-m-d'));
		$missionfutur = $query->getResult();

		//création du formlaire profil employé non basé sur l'entité user
		//On s'en servira pour hydrater user une fois les données postées
		$defaultData2 = array();

		$form = $this->createFormBuilder($defaultData2)
		->add('nom', 'text', array('required' => false))
		->add('prenom', 'text', array('required' => false))
		->add('email', 'text', array('required' => false))
		->add('tel', 'text', array('required' => false))
		->add('adresse', 'text', array('required' => false))	
		->add('rib', 'text', array('required' => false))	
		->add('photo', 'text', array('required' => false))
		->add('datenaissance', 'date', array('widget' => 'single_text',
									'input' => 'string',
									'format' => 'dd/MM/yyyy',
									'required' => false,
									'read_only' => false,
									'attr' => array('class' => 'echeance'),
									))
		->getForm();

		//Traitement des données postées et hydratation de user
		if($request->getMethod() == 'POST')
		{
			$form->handleRequest($request);
			$data = $form->getData();
			$nom = $data['nom'];
			$prenom = $data['prenom'];
			$email = $data['email'];
			$tel = $data['tel'];
			$adresse = $data['adresse'];
			$rib = $data['rib'];
			$photo = $data['photo'];
			$datenaissance = $data['datenaissance'];

			//Récupération de user
			$profil = $em->getRepository('BaclooUserBundle:User')
							->findOneById($userdetails->getId());
			//Hydratationde user
			$profil->setNom($nom);
			$profil->setPrenom($prenom);
			$profil->setEmail($email);
			$profil->setTel($tel);
			$profil->setAdresse($adresse);
			$profil->setRib($rib);
			$profil->setPhoto($photo);
			$profil->setDatenaissance($datenaissance);
			$em->persist($profil);
			$em->flush();

			return $this->redirect($this->generateUrl('bacloocrm_employe'));
		}

		//Récupération demissionpostule pour savoir à quelle mission on a postulé			   
		$missionpostule  = $em->getRepository('BaclooCrmBundle:MissionsPostule')
						->findByProfilid($userdetails->getId());

		$documents  = $em->getRepository('BaclooCrmBundle:Document')
						->findByCodedocument($userdetails->getId());
		//Appel du template et passage des variables pour appel dans le template
		return $this->render('BaclooCrmBundle:Crm:employe.html.twig', array(
			'form' => $form->createView(),
			'missions1'=> $missions1,
			'missions0'=> $missions0,		
			'documents'=> $documents,		
			'userdetails'=> $userdetails,		
			'missionpostule'=> $missionpostule,
			'missionpasse' => $missionpasse,
			'missionjour' => $missionjour,
			'missionfutur' => $missionfutur
		));						
	}



	public function removeMissionAction($id, $check)
	{
		$em = $this->getDoctrine()->getManager();
		$previous = $this->get('request')->server->get('HTTP_REFERER');

		
		//Souhaitez-vous vraiment supprimer la mission ?
		if($check == '0') // Tant que l'utilisateur ne confirme pas la suppression
		{
			return $this->render('BaclooCrmBundle:Crm:removeMission.html.twig', array('id' => $id,
																					'previous' => $previous,
																					'check' => 1));
		}
		elseif($check == 'ok') // L'utilisateur a confirmé la suppression => On supprime
		{
				$mission  = $em->getRepository('BaclooCrmBundle:Missions')
							   ->findOneByid($id);
				$em->remove($mission);
			$em->flush();
			return $this->render('BaclooCrmBundle:Crm:removeMission.html.twig', array('check' => $check));
		}
	}

	public function postulerMissionAction($id, $check)  //Penser à set le profilID
	{
		$em = $this->getDoctrine()->getManager();
		$previous = $this->get('request')->server->get('HTTP_REFERER');
		
		//Souhaitez-vous vraiment postuler à la mission ?
		if($check == '0') // Tant que l'utilisateur ne confirme pas
		{
			return $this->render('BaclooCrmBundle:Crm:postulerMission.html.twig', array('id' => $id,
																					'previous' => $previous,
																					'check' => 1));
		}
		elseif($check == 'ok') // L'utilisateur a confirmé qu'il postule
		{
			//1. On récupère la mission
			$mission  = $em->getRepository('BaclooCrmBundle:Missions')
			->findOneByid($id);

			//2. On récupère le profil connecté
				//Récupère le nom d'utilisateur
				$username = $this->get('security.context')->getToken()->getUsername(); 
					if(empty($username) or !isset($username) or $username == 'anon.')
					{return $this->redirect($this->generateUrl('fos_user_security_login'));}		
				$em = $this->getDoctrine()->getManager(); 
				//récupérer username de l'utilisateur connecté
				$userdetails  = $em->getRepository('BaclooUserBundle:User')			
				//Récupérer ID l'utilisateur en question	
				->findOneByUsername($username);	   
				$userID=$userdetails->getID();	
			//2. On clone la mission
			$missionpostule = new MissionsPostule;
			//3. On set la valeur postule à 1
			$missionpostule->setPostule(1);
			//On copie les données de la Mission dans MissionPostule
			$missionpostule->setMissionid($mission->getId());
			$missionpostule->setTitre($mission->getTitre());
			$missionpostule->setDatedebut($mission->getDatedebut());
			$missionpostule->setDatefin($mission->getDatefin());
			$missionpostule->setAdresse($mission->getAdresse());
			$missionpostule->setCodepostal($mission->getCodepostal());
			$missionpostule->setVille($mission->getVille());
			$missionpostule->setRaisonsociale($mission->getRaisonsociale());
			$missionpostule->setDescription($mission->getDescription());
			$missionpostule->setDresscode($mission->getDresscode());
			$missionpostule->setAgenceid($mission->getAgenceid());
			$missionpostule->setUrgent($mission->getUrgent());
			$missionpostule->setProfilid($userID);  //On récupère l'id du profil qui postule

			//On set la valeur de accepte et refuse à 0
			$missionpostule->setAccepte(0);
			$missionpostule->setRefuse(0);

			$em->persist($missionpostule);
			$em->flush();
			return $this->render('BaclooCrmBundle:Crm:postulerMission.html.twig', array('check' => $check));
		}
	}

	public function AccepterCandidatureAction($id, $check)
	{
		$em = $this->getDoctrine()->getManager();
		$previous = $this->get('request')->server->get('HTTP_REFERER');

		
		//Souhaitez-vous vraiment supprimer la mission ?
		$missionpostule  = $em->getRepository('BaclooCrmBundle:MissionsPostule')
						->findOneByid($id);
		$missionpostule->setAccepte(1);
		$em->persist($missionpostule);

		//Incrémentation de nbaccepte dans Missions
		$missions = $em->getRepository('BaclooCrmBundle:Missions')
						->findOneByid($missionpostule->getMissionid());
		$missions->setNbaccepte($missions->getNbaccepte()+1);
		$em->persist($missions);				
		$em->flush();
		return $this->redirect($this->generateUrl('bacloocrm_agence'));
	}

	public function RefuserCandidatureAction($id, $check)
	{
		$em = $this->getDoctrine()->getManager();
		$previous = $this->get('request')->server->get('HTTP_REFERER');

		
		//Souhaitez-vous vraiment supprimer la mission ?
		$missionpostule  = $em->getRepository('BaclooCrmBundle:MissionsPostule')
						->findOneByid($id);
		$missionpostule->setRefuse(1);
		$em->flush();
		return $this->redirect($this->generateUrl('bacloocrm_agence'));
	}



	public function profilsagenceAction(Request $request)
	{

	}


	public function societeAction()
	{
		include('societe.php');
		return $this->render('BaclooCrmBundle:Crm:societe.html.twig', array(
									'societe'    => $societe
									));	
	}

	public function conditionsAction()
	{
			return $this->render('BaclooCrmBundle:Crm:conditions_generales.html.twig');
	}

	public function conditionspubAction()
	{
			return $this->render('BaclooCrmBundle:Crm:conditions_generales_public.html.twig');
	}

	public function dropzoneAction($codedocument, $type, Request $request)
    {
		 $output = array('uploaded' => false);
		 // get the file from the request object
		 $file = $request->files->get('file');
		 // generate a new filename (safer, better approach)
		 // To use original filename, $fileName = $this->file->getClientOriginalName();
		 $fileName = $file->getClientOriginalName();
		 // Note: While using $file->guessExtension(), sometimes the MIME-guesser may fail silently for improperly encoded files. It is recommended to use a fallback for such cases if you know what file extensions are expected. (You can loop-over the allowed file extensions or even hard-code it if you expect only a particular type of file extension.)

		 // set your uploads directory
		 $uploadDir = $this->get('kernel')->getRootDir() . '/../web/uploads/'.$type.'/'.$codedocument.'/';
		 if (!file_exists($uploadDir) && !is_dir($uploadDir)) {
			 mkdir($uploadDir, 0775, true);
		 }
		 if ($file->move($uploadDir, $fileName)) {
		         // get entity manager
			$em = $this->getDoctrine()->getManager();

			// create and set this mediaEntity
			$document = new Document();
			$document->setNom($fileName);
			$document->setCodedocument($codedocument);
			$document->setType($type);

			// save the uploaded filename to database
			$em->persist($document);
			$em->flush();
			$output['uploaded'] = true;
			$output['fileName'] = $fileName;
		 }
		 // return new JsonResponse($output);
		 if($type == 'employe')
		 {
			return $this->redirect($this->generateUrl('bacloocrm_employe'));
		 }
	}

	public function removedocumentAction($iddoc, $codedocument, $type, Request $request)
	{//$id = id ligne partenaire
		$em = $this->getDoctrine()->getManager();
		$previous = $this->get('request')->server->get('HTTP_REFERER');
// echo 'iddoc'.$iddoc;echo 'type'.$type;echo 'codedocument'.$codedocument;
			$document  = $em->getRepository('BaclooCrmBundle:Document')
						   ->findOneBy(array('id' => $iddoc, 'type' => $type));

			$nomfichier = $document->getNom();
			$fs = new Filesystem();

		 if($type == 'employe')
		 {
			$fs->remove($this->get('kernel')->getRootDir().'/../web/uploads/employe/'.$codedocument.'/'.$nomfichier);
			$em->remove($document);
			$em->flush();
			return $this->redirect($this->generateUrl('bacloocrm_employe'));
		 }
	}

	
}