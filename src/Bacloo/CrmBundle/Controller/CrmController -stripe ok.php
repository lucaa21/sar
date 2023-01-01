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

use Bacloo\CrmBundle\Entity\Fiche;
use Bacloo\CrmBundle\Entity\Memo;
use Bacloo\CrmBundle\Entity\Bcontacts;
use Bacloo\CrmBundle\Entity\Brappels;
use Bacloo\CrmBundle\Entity\Event;
use Bacloo\CrmBundle\Entity\Search;
use Bacloo\CrmBundle\Entity\Rapsearch;
use Bacloo\CrmBundle\Entity\Prospot;
use Bacloo\CrmBundle\Entity\Prospects;
use Bacloo\CrmBundle\Entity\interresses;
use Bacloo\CrmBundle\Entity\Messages;
use Bacloo\CrmBundle\Entity\Fichesvendables;
use Bacloo\CrmBundle\Entity\Transaction;
use Bacloo\CrmBundle\Entity\Transac;
use Bacloo\CrmBundle\Entity\Prospectsbacloo;
use Bacloo\CrmBundle\Entity\Prospotbacloo;
use Bacloo\CrmBundle\Entity\Searchuser;
use Bacloo\CrmBundle\Entity\Userfav;
use Bacloo\CrmBundle\Entity\Favoris;
use Bacloo\CrmBundle\Entity\Alteruser;
use Bacloo\CrmBundle\Entity\Donemail;
use Bacloo\CrmBundle\Entity\Commandes;
use Bacloo\CrmBundle\Entity\Partenaires;
use Bacloo\CrmBundle\Entity\Articles;
use Bacloo\CrmBundle\Entity\Blog;
use Bacloo\CrmBundle\Entity\Modules;
use Bacloo\CrmBundle\Entity\Moda;
use Bacloo\UserBundle\Entity\User;
use Bacloo\CrmBundle\Entity\Pipeline;
use Bacloo\CrmBundle\Entity\Userpipe;
use Bacloo\CrmBundle\Entity\Ca;
use Bacloo\CrmBundle\Entity\Locata;
use Bacloo\CrmBundle\Entity\Locations;
use Bacloo\CrmBundle\Entity\Locataclone;
use Bacloo\CrmBundle\Entity\Locationsclone;
use Bacloo\CrmBundle\Entity\Locatasl;
use Bacloo\CrmBundle\Entity\Locationssl;
use Bacloo\CrmBundle\Entity\Locatafrs;
use Bacloo\CrmBundle\Entity\Locationsfrs;
use Bacloo\CrmBundle\Entity\Locationsslclone;
use Bacloo\CrmBundle\Entity\Locatafrsclone;
use Bacloo\CrmBundle\Entity\Locationsfrsclone;
use Bacloo\CrmBundle\Entity\Chantier;
use Bacloo\CrmBundle\Entity\Machines;
use Bacloo\CrmBundle\Entity\Machinessl;
use Bacloo\CrmBundle\Entity\Eventsite;
use Bacloo\CrmBundle\Entity\Eventparc;
use Bacloo\CrmBundle\Entity\Logis;
use Bacloo\CrmBundle\Entity\Logistique;
use Bacloo\CrmBundle\Entity\Logisrep;
use Bacloo\CrmBundle\Entity\Logistiquerep;
use Bacloo\CrmBundle\Entity\Grille;
use Bacloo\CrmBundle\Entity\Grillesl;
use Bacloo\CrmBundle\Entity\Afacturer;
// use Bacloo\CrmBundle\Entity\Facta;
use Bacloo\CrmBundle\Entity\Factures;
use Bacloo\CrmBundle\Entity\Echanges;
use Bacloo\CrmBundle\Entity\Venda;
use Bacloo\CrmBundle\Entity\Ventes;
use Bacloo\CrmBundle\Entity\Transferts;
use Bacloo\CrmBundle\Entity\Locataventes;
use Bacloo\CrmBundle\Entity\Intervenantschantier;
use Bacloo\CrmBundle\Entity\Articlesenvente;
use Bacloo\CrmBundle\Entity\Arta;
use Bacloo\CrmBundle\Entity\Cata;
use Bacloo\CrmBundle\Entity\Categorie;
use Bacloo\CrmBundle\Entity\Reponsevite1devis;
// use Bacloo\CrmBundle\Client\StripeClient;
// use Bacloo\CrmBundle\Stripe\lib\Charge;
// use Bacloo\CrmBundle\Stripe\lib\Stripe;
use Bacloo\PaymentBundle\Entity\Payment;

use Bacloo\CrmBundle\Form\FicheType;
use Bacloo\CrmBundle\Form\MemoType;
use Bacloo\CrmBundle\Form\BcontactsType;
use Bacloo\CrmBundle\Form\BrappelsType;
use Bacloo\CrmBundle\Form\EventType;
use Bacloo\CrmBundle\Form\SearchType;
use Bacloo\CrmBundle\Form\RapsearchType;
use Bacloo\CrmBundle\Form\ProspotType;
use Bacloo\CrmBundle\Form\ProspectsType;
use Bacloo\CrmBundle\Form\MessagesType;
use Bacloo\CrmBundle\Form\TransactionType;
use Bacloo\CrmBundle\Form\TransacType;
use Bacloo\CrmBundle\Form\ProspectsbaclooType;
use Bacloo\CrmBundle\Form\ProspotbaclooType;
use Bacloo\CrmBundle\Form\SearchuserType;
use Bacloo\CrmBundle\Form\UserfavType;
use Bacloo\CrmBundle\Form\FavorisType;
use Bacloo\CrmBundle\Form\AlteruserType;
use Bacloo\CrmBundle\Form\CommandesType;
use Bacloo\CrmBundle\Form\DonemailType;
use Bacloo\CrmBundle\Form\ArticlesType;
use Bacloo\CrmBundle\Form\ModulesType;
use Bacloo\CrmBundle\Form\ModaType;
use Bacloo\CrmBundle\Form\PipelineType;
use Bacloo\CrmBundle\Form\UserpipeType;
use Bacloo\CrmBundle\Form\LocataType;
use Bacloo\CrmBundle\Form\LocatacloneType;
use Bacloo\CrmBundle\Form\LocationscloneType;
use Bacloo\CrmBundle\Form\LocationsslcloneType;
use Bacloo\CrmBundle\Form\LocataventescloneType;
use Bacloo\CrmBundle\Form\LocationsType;
use Bacloo\CrmBundle\Form\MachinesType;
use Bacloo\CrmBundle\Form\LocataslType;
use Bacloo\CrmBundle\Form\LocationsslType;
use Bacloo\CrmBundle\Form\LocatafrsType;
use Bacloo\CrmBundle\Form\LocatafrscloneType;
use Bacloo\CrmBundle\Form\LocationsfrsType;
use Bacloo\CrmBundle\Form\LocationsfrscloneType;
use Bacloo\CrmBundle\Form\MachinesslType;
use Bacloo\CrmBundle\Form\EventparcType;
use Bacloo\CrmBundle\Form\EventsiteType;
use Bacloo\CrmBundle\Form\LogisType;
use Bacloo\CrmBundle\Form\LogisrepType;
use Bacloo\CrmBundle\Form\LogistiqueType;
use Bacloo\CrmBundle\Form\LogistiquerepType;
use Bacloo\CrmBundle\Form\GrilleType;
use Bacloo\CrmBundle\Form\GrilleslType;
// use Bacloo\CrmBundle\Form\FactaType;
use Bacloo\CrmBundle\Form\FacturesType;
use Bacloo\CrmBundle\Form\VendaType;
use Bacloo\CrmBundle\Form\VentesType;
use Bacloo\CrmBundle\Form\LocataventesType;
use Bacloo\CrmBundle\Form\ChantierType;
use Bacloo\CrmBundle\Form\IntervenantschantierType;
use Bacloo\CrmBundle\Form\ArticlesenventeType;
use Bacloo\CrmBundle\Form\ArtaType;
use Bacloo\CrmBundle\Form\CataType;
use Bacloo\CrmBundle\Form\CategorieType;
use Bacloo\UserBundle\Entity\UserRepository;
use Bacloo\PaymentBundle\Entity\PaymentRepository;

use Symfony\Component\Validator\Constraints\DateTime;
use DateInterval;
use DatePeriod;



class CrmController extends Controller
{	
	public function ajouterAction($mode, $messagex, $id)
	{
		//echo 'MESSAGEX'.$messagex;
		$objUser = $this->get('security.context')->getToken()->getUsername(); 
		$em = $this->getDoctrine()->getManager();
		$userdetails  = $em->getRepository('BaclooUserBundle:User')		
					   ->findOneByUsername($objUser);			
			
		if(!isset($userdetails)){$userid = 0;}else{$userid = $userdetails->getId();}
		$query = $em->createQuery(
			'SELECT b.compteurfiche
			FROM BaclooCrmBundle:Fiche b
			ORDER BY b.id DESC'
		)->setMaxResults(1);
		$lastnumfiche = $query->getOneOrNullResult();//print_r($lastnumfiche);
		if(empty($lastnumfiche) or !isset($lastnumfiche) or $lastnumfiche == null)
		{//echo 'vide';
			$lastnumfiche = 'AAAAAA';//echo 'vide';
		}
		else
		{//echo 'pas vide';
			$lastnumfiche = $query->getSingleScalarResult();
		}				
		//echo '>>>';echo $lastnumfiche;	echo '<<<';	//echo '***'.$lastnumfiche++.'*****';	

		// On crée un objet Fiche
		$fiche = new Fiche;
		// $userid = $this->get('security.context')->getToken()->GetUser()->getId(); 
		$form = $this->createForm(new FicheType($userid), $fiche);

		$today = date('d/m/Y');
		include('societe.php');
		// On récupère la requête
		$request = $this->get('request');
		// On vérifie qu'elle est de type POST
		if ($request->getMethod() == 'POST') 
		{//echo 'ok post';
			// On fait le lien Requête <-> Formulaire
			// À partir de maintenant, la variable $fiche contient les valeurs entrées dans le formulaire rempli par le visiteur
			$form->bind($request);
			// On vérifie que les valeurs entrées sont correctes

			if ($form->isValid()){echo 'VALIDE';
				$data = $form->getData();
				$detail1 = $form->get('detail1')->getData();echo 'les tags'.$detail1;
				
				$cat = $em->getRepository('BaclooCrmBundle:Categorielead')
							 ->findOneByformname($detail1);
				$prix1 = $cat->getPrixprimaire()*1.3;
				$prix2 = $cat->getPrixprimaire()*3;
				
				$fiche->setTags($detail1);
				$fiche->setUSer('Mike');
				$fiche->setTypefiche('prospect');
				$fiche->setCleapi('15875829415ea097dd53c915ea097dd53cd0');
				$fiche->setAvendre(1);
				$fiche->setAvendrec(1);
				$fiche->setPrixsscont($prix1);
				$fiche->setPrixavcont($prix2);
				echo 'FIIIICHE'.$fiche->getId();
				
				$query = $em->createQuery(
					'SELECT u.id 
					FROM BaclooCrmBundle:Categorielead u
					WHERE u.formname = :tags
					ORDER By u.id'
				);
				$query->setParameter('tags', $detail1);
				$catid = $query->getSingleScalarResult();echo '111';
				
				$query = $em->createQuery(
					'SELECT u.nomartisan 
					FROM BaclooCrmBundle:Categorielead u
					WHERE u.formname = :tags
					ORDER By u.id'
				);
				$query->setParameter('tags', $detail1);
				$tags = $query->getSingleScalarResult();
				$fiche->setNomartisan($tags);
				$em->persist($fiche);	
				$em->flush();
				
				$query = $em->createQuery(
					'SELECT u 
					FROM BaclooUserBundle:User u
					WHERE u.tags like :tags
					ORDER By u.id'
				);
				$query->setParameter('tags', '%'.$tags.'%');
				$list_fichespot = $query->getResult();
				echo 'laaaaaaaaaaaaaa';
				if($fiche->getDebuttravaux() == 1)
				{
					$debuttravaux = 'Urgent';
				}
				elseif($fiche->getDebuttravaux() == 2)
				{
					$debuttravaux = 'Dans les 6 mois';
				}
				elseif($fiche->getDebuttravaux() == 3)
				{
					$debuttravaux = 'Dans l année';
				}
				elseif($fiche->getDebuttravaux() == 4)
				{
					$debuttravaux = 'Dans plus d un an';
				}
				$nbdestinataires = 0;
				foreach($list_fichespot as $user)
				{echo 'go foreach';
					$fichecp = substr($fiche->getCp(), 0, 2);echo 'FICHECP'.$fichecp;
					$query = $em->createQuery(
						'SELECT u.cp
						FROM BaclooUserBundle:User u
						WHERE u.username = :username
						AND u.cp LIKE :cp'
					);
					$query->setParameter('username', $user->GetUsername());				
					$query->setParameter('cp', $fichecp);				
					$cpcheck = $query->getResult();		
					if(isset($cpcheck))
					{
						$destinataire  = $user;					
						$diff = '1';
						// Partie envoi du mail
						// Récupération du service
						$mailer = $this->get('mailer');				
						
							$message = \Swift_Message::newInstance()
								->setSubject('Bacloo : Nouveau prospect détecté')
								->setFrom(array('bacloo@bacloo.fr' => 'Bacloo CRM'))
								->setTo($destinataire->getEmail())
								->setBody($this->renderView('BaclooCrmBundle:Crm:new_opp.html.twig', array('dest_prenom'	=> $destinataire->getPrenom(),
																										 'besoin'	=> $fiche->getTags(),
																										 'cp'	=> $fiche->getCp(),
																										 'ville'	=> $fiche->getVille(),
																										 'diff'	=> $diff,
																										 'date' => $debuttravaux
																										  )))
							;
							$mailer->send($message);
							
						$mailer = $this->get('mailer');				
						
							$message = \Swift_Message::newInstance()
								->setSubject('Bacloo : Nouveau prospect détecté1')
								->setFrom(array('bacloo@bacloo.fr' => 'Bacloo CRM'))
								->setTo('ringuetjm@gmail.com')
								->setBody($this->renderView('BaclooCrmBundle:Crm:new_opp.html.twig', array('dest_prenom'	=> $destinataire->getPrenom(),
																										 'besoin'	=> $fiche->getTags(),
																										 'cp'	=> $fiche->getCp(),
																										 'ville'	=> $fiche->getVille(),
																										 'diff'	=> $diff,
																										 'date' => $debuttravaux
																										  )))
							;
							$mailer->send($message);
						$nbdestinataires++;

						//Ajout dans la table intéressés
						$interresses = new interresses();
						$interresses->setFicheid($fiche->getId());
						$interresses->setNom($user->GetNom());
						$interresses->setPrenom($user->GetPrenom());
						$interresses->setUsername($user->GetUsername());
						$interresses->setActivite($user->GetActivite());
						$interresses->setDescRech($user->GetDescRech());
						$interresses->setTags($user->GetTags());	
						$interresses->setActvise($user->GetActvise());	
						$interresses->setDatedeclar($today);
						$interresses->setProprio('Mike');	
						$em->persist($interresses);				
						$em->flush();
				
				
						$em = $this->getDoctrine()->getManager();
						$prospects = new Prospects();
						$prospects->setUserid($user->GetId());
						$em->persist($prospects);				
						$em->flush();
						
						$prospot = new Prospot();
						$prospot->setRaisonSociale($fiche->GetRaisonSociale());
						$prospot->setActivite($fiche->GetActivite());
						$prospot->setBesoins($tags);
						$prospot->setCp(substr($fiche->GetCp(), 0, 2));
						$prospot->setVille($fiche->GetVille());
						$prospot->setVendeur($fiche->GetUser());
						$prospot->setDescbesoins($fiche->GetDescription());
						$prospot->setVemail($fiche->GetUseremail());										
						$prospot->setFicheid($fiche->GetId());	
						$prospot->setAVendre($fiche->GetAVendre());	
						$prospot->setAVendrec($fiche->GetAVendrec());	
						$prospot->setPrixavcont($fiche->GetPrixavcont());	
						$prospot->setPrixsscont($fiche->GetPrixsscont());	
						$prospot->setUser($user->GetUsername());	
						$prospot->setLastmodif($fiche->GetLastmodif());	
						$prospot->setDebuttravaux($fiche->GetDebuttravaux());	
						$prospot->setTypepersonne($fiche->GetTypepersonne());	
						$prospot->setTypedebien($fiche->GetTypedebien());	
						$prospot->setTypedemandeur($fiche->GetTypedemandeur());	
						$prospot->setVoir(false);
						$prospot->setMasquer(0);
						$prospot->addProspect($prospects);
						$prospects->addProspot($prospot);
							
						$em->persist($prospot);	
						$em->flush();
					}					
				}
				//Envoie du mail réception lead aux admins
				$mailer = $this->get('mailer');				
			
				$message = \Swift_Message::newInstance()
					->setSubject('Bacloo : Nouveau lead enregistré')
					->setFrom(array('bacloo@bacloo.fr' => 'Bacloo'))
					// ->setTo('mikemultiservices.pro@gmail.com')
					->setTo('ringuetjm@gmail.com')
					->setBody($this->renderView('BaclooCrmBundle:Crm:new_lead.html.twig', array('dest_prenom'	=> 'Mickael',
																							 'nom'	=> $fiche->getRaisonSociale(),
																							 'besoin'	=> $fiche->getTags(),
																							 'cp'	=> $fiche->getCp(),
																							 'nbdestinataires' => $nbdestinataires,
																							 'date' => $debuttravaux
																							  )))
				;
				$mailer->send($message);
				
				$mailer = $this->get('mailer');				
			
				$message = \Swift_Message::newInstance()
					->setSubject('Bacloo : Nouveau lead enregistré')
					->setFrom(array('bacloo@bacloo.fr' => 'Bacloo'))
					->setTo('ringuetjm@gmail.com')
					->setBody($this->renderView('BaclooCrmBundle:Crm:new_lead.html.twig', array('dest_prenom'	=> 'Jean-Marc',
																							 'nom'	=> $fiche->getRaisonSociale(),
																							 'besoin'	=> $fiche->getTags(),
																							 'cp'	=> $fiche->getCp(),
																							 'nbdestinataires' => $nbdestinataires,
																							 'date' => $debuttravaux
																							  )))
				;
				$mailer->send($message);
				//Fin envoi mail aux admins
				
				
				//Maintenant on interroge viteundevis pour savoir si on peut envoyer le lead
				$cle = '15875829415ea097dd53c915ea097dd53cd0';
				$cp = $fiche->getCp();
				$url = 'https://www.viteundevis.com/api/ping.php?token=15875829415ea097dd53c915ea097dd53cd0&cat_id='.$catid.'&code_postal='.$cp.'&pays=fr';
				$content=file_get_contents($url);
				$character = json_decode($content);
				echo '&&&&&&'.$character->accept;
				echo '*********'.$character->recommande;

				//Fin interrogation viteundevis
				$messagex = 'ok';
				$em->flush();
				
				if($character->recommande == 1)
				{
					//On envoie
					// Définition de l'url à appeler avec CURL
					$url = 'http://www.viteundevis.com/api/get.php?test=1';//url de test
					// $url = 'http://www.viteundevis.com/api/get.php';//url de prod
					// Ou cette url si vous voulez tester votre intégration ajouter ?test=1
					// Définition des paramètres envoyés en POST
					$post = array(
					'nom' => $fiche->getRaisonSociale(),
					'prenom' => $fiche->getPrenom(),
					'adresse1' => $fiche->getAdresse1(),
					'adresse2' => '',
					'cp' => $fiche->getCp(),
					'ville' => $fiche->getVille(),
					'email' => $fiche->getUseremail(),
					'tel' => $fiche->getUseremail(),
					'mobile' => '',
					'societe' => '',
					'budget' => '',
					'surface' => '',
					'cp_projet' => $fiche->getCp(),
					'cat_id' => $fiche->getCategorieid(),
					'ville_projet' => $fiche->getVille(),
					'permis' => '', 'terrain' => '', 'tp' => $fiche->getTypepersonne(), 'type_bien' => $fiche->getTypedebien(), 'matin' => 0, 'midi' => 0, 'soir' => 0, 'we' => 0, 'delais' => $fiche->getDebuttravaux(),
					'situation' => 1,
					'description' => $fiche->getDescription(),
					'site_name' => 'lead4you', 'callback' => 'http://www.bacloo.fr/web/b/lead4you/web/app_dev.php/callbackviteundevis', 'key' => '15875829415ea097dd53c915ea097dd53cd0' );

					// Préparation du CURL
					$curl = curl_init();
// uses native PHP streams
// $curl = new NativeHttpClient();

// uses the cURL PHP extension
// $curl = new CurlHttpClient();
					curl_setopt($curl, CURLOPT_URL, $url);
					curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
					curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/5.0 (Macintosh; Intel
					Mac OS X 10.6; rv:5.0) Gecko/20100101 Firefox/5.0");
					curl_setopt($curl, CURLOPT_POST, 1);
					curl_setopt($curl, CURLOPT_POSTFIELDS, $post);
					$retour = curl_exec($curl);
					curl_close($curl);
					// Vérificarion des données renvoyées par l'API
					$devis_data = unserialize($retour);
					if($devis_data["code_retour"][0]["code"] == "200")
					{
						// le devis est bien valide
						echo "Devis accepté";
						$fiche->setCperso1('Lead accepté');
						// Vous pouvez garder dans votre BDD l'ID du devis pour un suivi
						//avec l'URL de callback
						$devis_id = $devis_data["devis_data"]["devis_id"];echo $devis_id;		

						//Ajout dans la table intéressés nbachat vite1devis
						$interresses = new interresses();
						$interresses->setFicheid($fiche->getId());
						$interresses->setNom('Vite1devis');
						$interresses->setPrenom('Vite1devis');
						$interresses->setUsername('Vite1devis');
						$interresses->setActivite('Achat tous leads');
						$interresses->setDescRech('tous ypesd e leads');
						$interresses->setTags('');	
						$interresses->setActvise('');	
						$interresses->setDatedeclar(date('Y-m-d'));
						$interresses->setProprio('Mike');	
						$em->persist($interresses);	
						
						//Maj table prospot vite1devis
						$prospects = new Prospects();
						$prospects->setUserid($user->GetId());
						$em->persist($prospects);				
						$em->flush();
						
						$prospot = new Prospot();
						$prospot->setRaisonSociale($fiche->GetRaisonSociale());
						$prospot->setActivite($fiche->GetActivite());
						$prospot->setBesoins($tags);
						$prospot->setCp(substr($fiche->GetCp(), 0, 2));
						$prospot->setVille($fiche->GetVille());
						$prospot->setVendeur($fiche->GetUser());
						$prospot->setDescbesoins($fiche->GetDescription());
						$prospot->setVemail($fiche->GetUseremail());										
						$prospot->setFicheid($fiche->GetId());	
						$prospot->setAVendre($fiche->GetAVendre());	
						$prospot->setAVendrec($fiche->GetAVendrec());	
						$prospot->setPrixavcont($fiche->GetPrixavcont());	
						$prospot->setPrixsscont($fiche->GetPrixsscont());	
						$prospot->setUser('Vite1devis');	
						$prospot->setLastmodif($fiche->GetLastmodif());	
						$prospot->setDebuttravaux($fiche->GetDebuttravaux());	
						$prospot->setTypepersonne($fiche->GetTypepersonne());	
						$prospot->setTypedebien($fiche->GetTypedebien());	
						$prospot->setTypedemandeur($fiche->GetTypedemandeur());	
						$prospot->setVoir(false);
						$prospot->setMasquer(0);
						$prospot->addProspect($prospects);
						$prospects->addProspot($prospot);
							
						$em->persist($prospot);					
						$em->flush();
						
					}
					else
					{
						// Il y a des erreurs
						foreach($devis_data["code_retour"] as $key => $value)
						{
						echo "Erreur ".$value["code"]." -> ".$value["code_texte"]."\n";
						}
						$fiche->setCperso1('Lead accepté'.$value["code"].' -> '.$value["code_texte"].'\n');
					}
					$em->persist($fiche);
					$em->flush();					
				}
				// echo 'zemessagex'.$messagex;echo 'mod'.$mode;				
				// On redirige vers la page de visualisation de la fiche nouvellement créée
				if($mode == 'adminxyz20')
				{
					return $this->redirect($this->generateUrl('bacloocrm_voir', array('id' => $fiche->getId())));					
				}
				else
				{
					return $this->redirect($this->generateUrl('bacloocrm_ajouterext', array('messagex' => 'ok')));
				}
			}
		}//echo 'moooode'.$mode;
		if($mode ==='ext')
		{	//echo 'messlast'.$messagex;		
			return $this->render('BaclooCrmBundle:Crm:formulaireext.html.twig', array('form' => $form->createView(),
																				'date' => $today,
																				'mode' => $mode,
																				'id' => $id,
																				'usersociete' => $societe,
																				'messagex' => $messagex,
																				'user' => $objUser));
		}
		elseif($mode == '0')
		{	//echo 'ajouter';	
			return $this->render('BaclooCrmBundle:Crm:ajouter.html.twig', array('form' => $form->createView(),
																				'date' => $today,
																				'mode' => $mode,
																				'id' => $id,
																				'usersociete' => $societe,
																				'messagex' => $messagex,
																				'user' => $objUser));
		}	
	}
	
  public function voirAction($id, $raison, Request $request)
  {
	$objUser = $this->get('security.context')->getToken()->getUsername();
//echo 'idddd'.$id;
	$em = $this->getDoctrine()->getManager();
	$userdetails  = $em->getRepository('BaclooUserBundle:User')		
				   ->findOneByUsername($objUser);			
	$userid = $userdetails->getId();
	$modules  = $em->getRepository('BaclooCrmBundle:Modules')		
				   ->findOneByUsername($objUser);
	$module9activation = $modules->getModule9activation();

	// $idok  = $em->getRepository('BaclooUserBundle:Fiche')		
				   // ->findOneByid($id);
			   
	if($id == 0)
	{
		$idok = $em->getRepository('BaclooCrmBundle:Fiche')		
					   ->findOneById($id);	
		$id = $idok->getId();
	}
	//Gestion de l'encours
	$encoursfac  = $em->getRepository('BaclooCrmBundle:Factures')		
				   ->findBy(array('reglement' => 0, 'clientid' => $id));	
	// print_r($encoursfac);
	$totalencoursfac = 0;
	foreach($encoursfac as $ef)
	{//echo $ef->getTotalttc();echo '<br>';
		if($ef->getTypedoc() == 'facture')
		{
			$totalencoursfac += $ef->getTotalttc()-$ef->getMontantdejareg();
		}
		elseif($ef->getTypedoc() == 'avoir')
		{
			$totalencoursfac = $totalencoursfac - $ef->getTotalttc();
		}
	}
// echo 'fac ='.$totalencoursfac;
	$encoursloc  = $em->getRepository('BaclooCrmBundle:Locations')		
				   ->findBy(array('etatloc' => 'En location', 'codeclient' => $id));	
	$totalencoursloc = 0;
	foreach($encoursloc as $el)
	{
		$totalencoursloc += $el->getMontantloc();
	}
// echo 'loc ='.$totalencoursloc;	
	$encourssl = $em->getRepository('BaclooCrmBundle:Locationssl')		
				   ->findBy(array('etatloc' => 'En location', 'codeclient' => $id));	
	$totalencourssl  = 0;
	foreach($encourssl  as $esl)
	{
		$totalencourssl += $esl->getMontantloc();
	}
// echo 'sl ='.$totalencourssl;
	$debutmois = date('Y-m-01');
	$jodla = date('Y-m-d');				   
	$encoursvente  = $em->getRepository('BaclooCrmBundle:Venda')		
				   ->encoursvente($debutmois, $jodla, $id);	
	$totalencoursvente  = 0;
	foreach($encoursvente  as $ev)
	{
		$totalencoursvente += $ev->getMontantvente();
	}
// echo 'vente ='.$totalencoursvente;	
	// $encours = $totalencoursfac + $totalencoursloc + $totalencourssl + $totalencoursvente;
	$encours = $totalencoursloc + $totalencourssl + $totalencoursvente;
	if(!isset($encours)){$encours = 0;}
	$soldeimpay = $totalencoursfac;
	$soldeimpaye = round($soldeimpay, 2);

	$fiche = $em->getRepository('BaclooCrmBundle:Fiche')		
				   ->findOneById($id);		
	$fiche->setSoldeimpayes($soldeimpaye);	
	$fiche->setEncours($encours);	
	$em->persist($fiche);							
	$em->flush();
	// $soldeimpaye = number_format($soldeimpaya, 2, ',', ' ');echo $soldeimpaye;
	//Fin gestion de l'encours
// echo 'SOLDIMPAYE'; echo $soldeimpaye;		
	if(empty($objUser) or !isset($objUser) or $objUser == 'anon.')
	{
		return $this->redirect($this->generateUrl('fos_user_security_login'));
	}	

			$session = new Session();
			$session = $request->getSession();

			// définit et récupère des attributs de session
			$session->set('idfiche', $id);
			$session->set('init', '1');//on est en recherche
// echo 'view session'.$session->get('view');			
			$vue = $session->get('vue');
			$pid = $session->get('idsearch');
			$idsearchrap = $session->get('idsearchrap');
			if($session->get('page') > 0)
			{
				$page = $session->get('page');
			}
			else
			{
				$page = 1;
			}
			$view = $session->get('view');
			$init = $session->get('init');	
	include('societe.php');
			
			$fiche_sel  = $em->getRepository('BaclooCrmBundle:Fiche')		
						   ->find($id);

//CLONAGE SI Bacloo

	$fiche = $fiche_sel;

//echo '444';
	$ficheuser = $em->getRepository('BaclooCrmBundle:Fiche')		
			->findOneBy(array('user'=> $objUser, 'usersociete'=> $societe));
//if(empty($ficheuser)){echo 'vide';}else{echo 'pas vide';}
	$userdetails  = $em->getRepository('BaclooUserBundle:User')		
				   ->findOneByUsername($objUser);			
	$email = $userdetails->getEmail();
// echo $objUser;
	// echo 'modac='.$module9activation;
// echo 'fg='.$fiche->getUser();	
	if($module9activation == 1 && $fiche->getUser() == 'Bacloo' && empty($ficheuser))
	{ //echo 'clone';
			//On clone la fiche en remplaçant le pseudo du user
			$copyfiche = clone $fiche;
			$Memo = $copyfiche->getMemo();//echo 'lememo'.$Memo;
			if(isset($Memo)){$em->detach($Memo);}
			$copyfiche->setCopyof($fiche->getId());		
			$copyfiche->setUser($objUser);
			$copyfiche->setTypefiche('prospect');

			$copyfiche->setUseremail($email);
			
		// echo 'cash';
			$em->persist($copyfiche);	
// echo '3333333333333';						
			$em->flush();			

	}
	else
	{//echo 'la';
		$ficheca = $em->getRepository('BaclooCrmBundle:Fiche')		
							 ->find($id);
		$pipeid = $ficheca->getPipeline();//On recup le n° de pipeline de la fiche
		if(isset($pipeid) && $ficheca->getPotentiel() != NULL) //Si n° pipeline ok et capot ok
		{
			$pipestate = $em->getRepository('BaclooCrmBundle:Pipeline')		
								 ->find($pipeid);// on  recup les données du pipeline
			//On créé le svariable des différents états du pipe
			$perdu = $pipestate->getPerdu();//echo 'perdu'.$perdu;
			$exclusion = $pipestate->getExclusion();//echo 'exclusion'.$exclusion;
			$realise = $pipestate->getRealise();//echo 'realise'.$realise;
// echo '444444444';			
			$today = date('Y-m-d');
			//On  récup le dernier ca dans la table ca
			$ca = $em->getRepository('BaclooCrmBundle:Ca')		
								 ->findOneBy(array('userid'=> $userid, 'ficheid'=> $id), array('id' => 'DESC'));
								 
			$catoday = $em->getRepository('BaclooCrmBundle:Ca')		
								 ->findOneBy(array('userid'=> $userid, 'ficheid'=> $id, 'date'=> $today));							 

			if(empty($ca)){$ca = new Ca;}//Si pas de CA on créée un objet vierge					 
			if(empty($catoday)){$catoday = new Ca;}//Si pas de CA du jour on créée un objet vierge					 

			if($perdu != 1 AND $exclusion != 1 AND $realise != 1)//Il s'agit d'un devis fait donc d'un capot
			{//echo 'capot';
				if($ca->getCapot() != $ficheca->getPotentiel() && $ca->getDate() != $catoday->getDate())
				{//echo 'capotaaaaaaaaaaa';
					$catoday->setUserid($userid);
					$catoday->setUsername($objUser);
					$catoday->setCapot($ficheca->getPotentiel());
					$catoday->setCareal(0);
					$catoday->setCaperdu(0);
					$catoday->setDate($today);
					$catoday->setFicheid($ficheca->getId());
					$catoday->setRaisonsociale($ficheca->getRaisonSociale());
					$em->persist($catoday);
					$em->flush();					
				}
			}
			elseif($realise == 1)//Ca réalisé
			{//echo 'realise';
				if($ca->getCareal() != $ficheca->getPotentiel() && $ca->getDate() != $catoday->getDate())
				{			
					$catoday->setUserid($userid);
					$catoday->setUsername($objUser);
					$catoday->setCapot($ficheca->getPotentiel());
					$catoday->setCareal($ficheca->getPotentiel());
					$catoday->setCaperdu(0);
					$catoday->setDate($today);
					$catoday->setFicheid($ficheca->getId());
					$catoday->setRaisonsociale($ficheca->getRaisonSociale());	
					$em->persist($catoday);
					$em->flush();					
				}
			}
			elseif($perdu == 1)//Ca perdu
			{//echo 'perdu1';
				if($ca->getCaperdu() != $ficheca->getPotentiel() && $ca->getDate() != $catoday->getDate())
				{			
					$catoday->setUserid($userid);
					$catoday->setUsername($objUser);
					$catoday->setCapot(0);
					$catoday->setCareal(0);
					$catoday->setCaperdu($ficheca->getPotentiel());
					$catoday->setDate($today);
					$catoday->setFicheid($ficheca->getId());
					$catoday->setRaisonsociale($ficheca->getRaisonSociale());
					$em->persist($catoday);
					$em->flush();					
				}
			}

		}
	}
//echo $objUser;	echo $fiche->getRaisonSociale();
$fiche_sel = $em->getRepository('BaclooCrmBundle:Fiche')		
			->findOneBy(array('user'=> $objUser, 'raisonSociale'=> $fiche->getRaisonSociale(), 'cp'=> $fiche->getCp()));
// FIN CLONAGE SI BACLOO



			
// echo '  décollage';
	// On récupère l'EntityManager
	$em = $this->getDoctrine()
			   ->getManager();
				
				$today = date('d/m/Y');	
					$listeBr = array();
					foreach ($fiche->getBrappels() as $br) {
					  $listeBr[] = $br;
					}
					
					$listeBe = array();
					foreach ($fiche->getEvent() as $be) {
					  $listeBe[] = $be;
					}	

					$listeBc = array();
					foreach ($fiche->getBcontacts() as $bc) {
					  $listeBc[] = $bc;
					}
					
					$listeBa = array();
					foreach ($fiche->getAlteruser() as $ba) {
					  $listeBa[] = $ba;
					}
					
					$listeBco = array();
					foreach ($fiche->getCommandes() as $bco) {
					  $listeBco[] = $bco;
					}

    // On créé le formulaire
	$em = $this->getDoctrine()->getManager();
	$userdetails  = $em->getRepository('BaclooUserBundle:User')		
		   ->findOneBy(array('roleuser'=> 'admin', 'usersociete' => $societe));
	$userid = $userdetails->getId();	
	$form = $this->createForm(new FicheType($userid), $fiche);
    $request = $this->getRequest();
    if ($request->getMethod() == 'POST') {
// echo 'pos';
		$form->bind($request);
		if ($form->isValid()) {
 echo 'SOLDIMPAYE'.$soldeimpaye;		  
	    $em = $this->getDoctrine()->getManager();
		$fiche->setUsersociete($societe);	
        $em->persist($fiche);							
        $em->flush();

		//Ajout Relance encours
		$z=0;
		$daterelance = date('Y-m-d', strtotime($fiche->getDatedepot() . '+11 months'));
		$texte = 'ATTENTION !!! Son chèque de caution expire dans 1 mois';
		$relancecontrole  = $em->getRepository('BaclooCrmBundle:Brappels')		
							   ->findOneBy(array('date' => $daterelance, 'rapTexte' => $texte));
// print_r($relancecontrole);
// echo $form->get('datedepot')->getData();						   
		if(empty($relancecontrole) && $form->get('chequeencoffre')->getData() == 1 && null !== $form->get('datedepot')->getData())
		{echo 'laaaaaaa';
			$relance = new Brappels;
			$relance->setDate($daterelance);
			$relance->setRapTexte($texte);
			$relance->setUser($objUser);
			$relance->setEntreprise($fiche->getRaisonSociale());
			$relance->setAfaire(0);
			$relance->setRdv(0);
			$relance->setCp($fiche->getCp());
			$relance->addFiche($fiche);
			$fiche->addBrappel($relance);
			$em->persist($relance);
			$em->flush();
		}
		else{echo 'pas empty';}
		//Fin ajout relance encours
		
		//ON vire les éléments vides
		foreach ($fiche->getBrappels() as $br) {
		  if(empty($br->getRapTexte())){$em->remove($br);}
		}
		
		$listeBe = array();
		foreach ($fiche->getEvent() as $be) {
		  if(empty($be->getEventComment())){$em->remove($be);}
		}	

		$listeBc = array();
		foreach ($fiche->getBcontacts() as $bc) {
		  if(empty($bc->getNom()) and empty($bc->getPrenom()) and empty($bc->getFonction()) and empty($bc->getTel1()) and empty($bc->getEmail())){$em->remove($bc);}
		}
		
		$listeBco = array();
		foreach ($fiche->getCommandes() as $bco) {
		  if(empty($bco->getDesignation())){$em->remove($bco);}
		}
		$em->flush();
		
		$modules  = $em->getRepository('BaclooCrmBundle:Modules')		
					   ->findOneByUsername($objUser);       
      }
		return $this->redirect($this->generateUrl('bacloocrm_voir', array('id' => $fiche->getId())));	  
	 } 


		$query = $em->createQuery(
			'SELECT u 
			FROM BaclooUserBundle:User u
			WHERE u.username != :username
			Group By u.id'
		);
		$query->setParameter('username', $objUser);
		$list_fichespot = $query->getResult();					

	$i = 0;
						



			//Fin partie liste
			
			//Partie liste activite

			//Fin partie liste	
	


//créer table ca avec cols : userid, username, capot, cares, caperdu, date, ficheid				
	if($module9activation != 1) // si annuaire pas activé
	{
		$ficheca = $em->getRepository('BaclooCrmBundle:Fiche')		
							 ->find($id);
		$pipeid = $ficheca->getPipeline();
		if(isset($pipeid) && $ficheca->getPotentiel() != NULL)
		{
			$pipestate = $em->getRepository('BaclooCrmBundle:Pipeline')		
								 ->find($pipeid);
			$perdu = $pipestate->getPerdu();//echo 'perdu'.$perdu;
			$exclusion = $pipestate->getExclusion();//echo 'exclusion'.$exclusion;
			$realise = $pipestate->getRealise();//echo 'realise'.$realise;
			
			$today = date('Y-m-d');
			$ca = $em->getRepository('BaclooCrmBundle:Ca')		
								 ->findOneBy(array('userid'=> $userid, 'ficheid'=> $id), array('id' => 'DESC'));							 

			if(empty($ca)){$ca = new Ca;}					 

			if($perdu != 1 AND $exclusion != 1 AND $realise != 1 AND $realise != 1)
			{//echo 'capot';
				if($ca->getCapot() != $ficheca->getPotentiel())
				{
					$ca->setUserid($userid);
					$ca->setUsername($objUser);
					$ca->setCapot($ficheca->getPotentiel());
					$ca->setCareal(0);
					$ca->setCaperdu(0);
					$ca->setDate($today);
					$ca->setFicheid($ficheca->getId());
					$ca->setRaisonsociale($ficheca->getRaisonSociale());
					$em->persist($ca);
					$em->flush();
				}
			}
			elseif($realise == 1)
			{//echo 'realise';
				if($ca->getCareal() != $ficheca->getPotentiel())
				{			
					$ca->setUserid($userid);
					$ca->setUsername($objUser);
					$ca->setCapot($ficheca->getPotentiel());
					$ca->setCareal($ficheca->getPotentiel());
					$ca->setCaperdu(0);
					$ca->setDate($today);
					$ca->setFicheid($ficheca->getId());
					$ca->setRaisonsociale($ficheca->getRaisonSociale());
					$em->persist($ca);
					$em->flush();	
				}
			}
			elseif($perdu == 1)
			{//echo 'perdu';
				if($ca->getCaperdu() != $ficheca->getPotentiel())
				{//echo 'set ca perdu';			
					$ca->setUserid($userid);
					$ca->setUsername($objUser);
					$ca->setCapot(0);
					$ca->setCareal(0);
					$ca->setCaperdu($ficheca->getPotentiel());
					$ca->setDate($today);
					$ca->setFicheid($ficheca->getId());
					$ca->setRaisonsociale($ficheca->getRaisonSociale());
					$em->persist($ca);
					$em->flush();					
				}
			}
		}
	}
		
		$modules  = $em->getRepository('BaclooCrmBundle:Modules')		
					   ->findOneByUsername($objUser);
					   
		$devis  = $em->getRepository('BaclooCrmBundle:Locata')		
					   ->findBy(array('clientid' => $id, 'offreencours' => 1, 'contrat' => 0),array('id' => 'DESC'));
					     
		$bdcfrs  = $em->getRepository('BaclooCrmBundle:Locatafrs')		
					   ->findBy(array('fournisseurid' => $id));
// echo $id;				   
		$contrats  = $em->getRepository('BaclooCrmBundle:Locata')		
					   ->findBy(array('clientid' => $id, 'contrat' => 1),array('id' => 'DESC'));
					   
		$devisventes = $em->getRepository('BaclooCrmBundle:Venda')		
					   ->findBy(array('clientid' => $id, 'bdcrecu' => 0));
					   
		$ventes = $em->getRepository('BaclooCrmBundle:Venda')		
					   ->findBy(array('clientid' => $id, 'bdcrecu' => 1));
					   
		$contratssl  = $em->getRepository('BaclooCrmBundle:Locatasl')		
					   ->findBy(array('clientid' => $id, 'contrat' => 1));	
					   
		$transferts  = $em->getRepository('BaclooCrmBundle:Transferts')		
					   ->findBy(array('clientid' => $id));	
					   
		$echanges  = $em->getRepository('BaclooCrmBundle:Echanges')		
					   ->findBy(array('clientid' => $id));	
					   
		$factures  = $em->getRepository('BaclooCrmBundle:Factures')		
					   ->findBy(array('clientid' => $id, 'typedoc' => 'facture'));		
					   
		$avoirs  = $em->getRepository('BaclooCrmBundle:Factures')		
					   ->findBy(array('clientid' => $id, 'typedoc' => 'avoir'));	
					   
		$interresses  = $em->getRepository('BaclooCrmBundle:interresses')		
					   ->findByFicheid($id);	
					   
		$prospotuser  = $em->getRepository('BaclooCrmBundle:Prospot')		
					   ->findByUser($objUser);	
					   
		$paymentuser  = $em->getRepository('PaymentBundle:Payment')		
					   ->findByUser($objUser);		
// echo 'looooo';
	$string = str_replace(' ', '+', $fiche->getRaisonSociale());
	$urlg = 'http://www.google.com/search?q='.$string;//echo $urlg;
	$pagesr = $session->get('pagesr');				   
	$userdetails  = $em->getRepository('BaclooUserBundle:User')		
				   ->findOneByUsername($objUser);
				   		
		$factures2  = $em->getRepository('BaclooCrmBundle:Factures')		
	   ->findBy(array('reglement' => 1, 'clientid' => $fiche->getId(), 'typedoc' => 'facture'));//print_r($factures);
	   $diff = 0;
	   $i = 0;
	   foreach($factures2 as $facture)
	   {
		   if(!empty($facture->getDatepaiement()))
		   {
				//Calcul du nmbre de jours d'écarts entre la date d'échéance et la date de règlement
				$difference = strtotime($facture->getDatepaiement()) - strtotime($facture->getEcheance());//echo 'datepaiemen'.$facture->getDatepaiement();echo ' vs ';echo 'echeance'.$facture->getEcheance();
				$diff += $difference/86400;//echo '>>>>'.$facture->getNumfacture().'=='.$difference/86400;
				$i++;	
		   }			
	   }//echo '$dif'.$diff;echo 'iiii'.$i;
	   if($i > 0){$delaiMoyPaiement = $diff/$i;}else{$delaiMoyPaiement = 0;}
	   $fiche->setDureemoypaiement($delaiMoyPaiement);
	   $em->persist($fiche);
	   $em->flush();
						   
		$documents  = $em->getRepository('BaclooCrmBundle:Document')		
					   ->findBy(array('codecontrat' => $fiche->getId(), 'type' => 'fiche'));			   
    return $this->render('BaclooCrmBundle:Crm:voir.html.twig', array(
														  'form'    => $form->createView(),
														  //'countinter' => $countinter,
														  // 'list_tags' => $list_tags,
														  'id' => $fiche->getId(),
														  'societe' => $fiche->getRaisonSociale(),
														  'cp' => $fiche->getCp(),
														  'usersociete' => $societe,
														  'soldeimpaye' => $soldeimpaye,
														  'useracc' => $objUser,
														  'userdetails' => $userdetails,
														  'fiche' => $fiche,
														  'vue' => $vue,
														  'page' => $page,
														  'pagesr' => $pagesr,
														  'pid'	=> $pid,
														  'idsearchrap'	=> $idsearchrap,
														  'view' => $view,
														  'init' => $init,
														  'date' => $today,	  
														  'roleuser' => $userdetails->getRoleuser(),
														  'module3activation' => $modules->getModule3activation(),
														  'module5activation' => $modules->getModule5activation(),
														  'module7activation' => $modules->getModule7activation(),
														  'module8activation' => $modules->getModule8activation(),
														  'module11activation' => $modules->getModule11activation(),
														  'user' => $objUser,
														  'modules' => $modules,	  
														  'contrats' => $contrats,	  
														  'contratssl' => $contratssl,	  
														  'devis' => $devis,	  
														  'devisventes' => $devisventes,	  
														  'ventes' => $ventes,	  
														  'transferts' => $transferts,	  
														  'echanges' => $echanges,	  
														  'bdcfrs' => $bdcfrs,	  
														  'roleuser' => $userdetails->getRoleuser(),	  
														  'factures' => $factures,	  
														  'avoirs' => $avoirs,  
														  'encours' => $encours,
														  'documents' => $documents,  
														  'prospotuser' => $prospotuser,  
														  'paymentuser' => $paymentuser,  
														  'interresses' => $interresses,  
														  'urlg' => $urlg	  
														));
  }
 
 	public function searchAction($page, $view, $init, $vue, $speed, Request $request)
		{//echo 'view init'.$view;
				$session = $request->getSession();
				if(!isset($page)){
					$page=1;
				}
				else{
					$page = $session->get('page');
				}
				// echo 'YYYYYYY'.$view;echo 'VVVVVVV'.$session->get('view');
				if($view != $session->get('view') && $view != 'def')
				{
					$session->set('view', $view);
					$page=1;
				}
				else
				{
					$session->set('view', 'client');
					$page=1;
				}
				$nbparpage = 20;
				set_time_limit(600);
				if(!isset($page) || $page == 0){$page =1;}
				include('societe.php');
				$usersess = $this->get('security.context')->getToken()->getUsername(); if(empty($usersess) or !isset($usersess) or $usersess == 'anon.'){return $this->redirect($this->generateUrl('fos_user_security_login'));}//Récupère le nom d'utilisateur
				$em = $this->getDoctrine()->getManager();//echo'usersess'.$usersess;
		// echo 'vue_envoyée'.$vue;
							   
				$session = $request->getSession();
		// echo 'id   ds sess'.$session->get('id');echo 'init'.$init;
				$vue2 = $session->get('vue');	
				// echo 'vue session'.$vue2;
				// echo 'view session'.$session->get('view');
				$pagesr = $session->get('pagesr');//echo 'ooo'.$pagesr;
				$id = $session->get('idsearch');//echo 'ooo'.$id;
				$idsearchrap = $session->get('idsearchrap');//echo 'ooo'.$id;
				if(empty($idsearchrap))
				{
					$idsearchrap = 0;
				}
				//echo $idsearchrap;
				if($id)
				{//echo 'yyOOOOOOy';
					$id = $session->get('idsearch');
				}
				else
				{//echo 'zzz';
					$id = 0;
				}
				if($speed == 3)
				{
					$id = 0;
					$session->set('id', 0);
					$session->set('idsearch', 0);
					$session->set('besoinfilter', 'contient');
					$session->set('rsfilter', 'contient');
					$session->set('nomfilter', 'contient');
					$session->set('activitefilter', 'contient');
					$session->set('cpfilter', 'contient');
					$session->set('villefilter', 'contient');
					$session->set('cperso1filter', 'contient');
					$session->set('cperso2filter', 'contient');
					$session->set('cperso3filter', 'contient');
					$session->set('memofilter', 'contient');
					$session->set('histofilter', 'contient');
					$session->set('fonctionfilter', 'contient');
				}
		//echo 'xxx'.$session->get('idsearch');
				if(isset($vue) && $vue != 'def')
				{
				$session = new Session();//echo 'daaaaaa';
				$session->set('page', $page);
				$session->set('vue', $vue);
				}
				else
				{
				$session = new Session();//echo 'new vue sess';
				$session->set('page', $page);
				$session->set('vue', $vue2);				
				}

				//On récupère les favoris niveau ALL
				$em = $this->getDoctrine()->getManager();
				$query = $em->createQuery(
						'SELECT f.favusername
						FROM BaclooCrmBundle:Favoris f
						WHERE f.favusername = :favusername
						AND f.toutpart = :toutpart'
					)->setParameter('favusername', $usersess);
					$query->setParameter('toutpart', 1);
					$favoriall = $query->getResult();
					//echo 'cbien2 favoriall'.count($favoriall);

				//On créée un tableau sous le modèle 'user'=>$xxxx pour le repository
				if(isset($favoriall) && !empty($favoriall))
				{//echo 'liiiiiii';
					$i = 1;
					foreach($favoriall as $favo)
					{
						foreach($favo as $fav)
						{
						////echo 'favo'.$fav;
							$favor  = $em->getRepository('BaclooCrmBundle:Favoris')		
										   ->findOneByFavusername($usersess);						
							${'choix'.$i++} = $favor->getUsername();
						}
					}
					//echo 'choix1'.$choix1;
					$critere = array($usersess);
					
					for($j=1;$j<$i;$j++)
					{
						${'critere'.$j} = array(${"choix".$j});
						$critere = array_merge(${'critere'.$j},$critere);
					}
					
				}
				else
				{
					$critere = array($usersess);
				}
// $critere = array('jmr', 'toto');



//$critere = array('jmr', 'toto');
		// On déplace la vérification du numéro de page dans cette méthode

	
							   
		// echo 'vue33333'.$vue;		
		$user  = $em->getRepository('BaclooUserBundle:User')		
					   ->findOneByUsername($usersess);
		$roleuser = $user->getRoleuser();
				//Protect double connexion
				$session = $request->getSession();
				$sessionId = $session->getId();
				// echo $sessionId;
				// echo 'xxxxx'.$user->getLogged();
				// echo '  '.$user->getUsername();
				if($user->getLogged() != $sessionId)
				{
					return $this->redirect($this->generateUrl('fos_user_security_logout'));
				}
				//Fin protect double connexion
			if($view != 'chantier')
			{				
				$query = $em->createQuery(
					'SELECT f
					FROM BaclooCrmBundle:Fiche f
					WHERE f.useremail = :useremail
					AND f.user = :user'
				)->setParameter('useremail', $user->getEmail())
				->setParameter('user', 'x');
				$fichetempuser = $query->getResult();

				if(isset($fichetempuser))
				{
					foreach($fichetempuser as $fichetemp)
					{
						$fichetemp->setUser($usersess);
						$em->flush();		
					}
				}
			}
				if($view != 'search')
				{
					$mesfichestot = $em->getRepository('BaclooCrmBundle:Fiche')
								->searchfiche_init($nbparpage, $page, $critere, $user->getUsername(), $roleuser);
				}			
				$session = $request->getSession();
				//echo '$session->get(view)'.$session->get('view');
				$v = $session->get('view');//echo 'lavue'.$view;
			if($view != 'def' && isset($v) && $v != 1)
			{//echo 'ICI'.$v;
				if($v != $view)
				{//echo '$v != $view'.$view;
					$view = $view;
					$session = new Session();
					$session = $request->getSession();
					$session->set('page', $page);
					$session->set('view', $view);					
				}
				else
				{//echo $v.'$v = $view';
					$view = $v;
				}
				if($view == 'client')
				{//echo ' on est client';
					$typefiche = $view;
					include('searchprospects.php');
					
					if(!isset($mesfiches)){$mesfiches = 'nok';$session->set('id', '0');}
					
				}
				elseif($view == 'prospect')
				{//echo ' on est prospect'.$session->get('idsearch');
					$typefiche = $view;
					include('searchprospects.php');
				
					if(!isset($mesfiches)){$mesfiches = 'nok';$session->set('id', '0');}
					if($session->get('id') > 0)
					{
						return $this->redirect($this->generateUrl('bacloocrm_find', array('id' => $id, 'page' => $session->get('page'), 'view' => $session->get('view') )));
					}					
				}
				elseif($view == 'annuaire')
				{//echo ' on est prospect';
					$typefiche = 'prospect';
					include('searchprospects.php');
				
					if(!isset($mesfiches)){$mesfiches = 'nok';$session->set('id', '0');}
					if($session->get('id') > 0)
					{
						return $this->redirect($this->generateUrl('bacloocrm_find', array('id' => $id, 'page' => $session->get('page'), 'view' => $session->get('view') )));
					}					
				}
				elseif($view == 'fournisseur')
				{
					$mesfiches = $em->getRepository('BaclooCrmBundle:Fiche')
								->searchfiche_init_fournisseur($nbparpage, $page, $societe);
					if(!isset($mesfiches)){$mesfiches = 'nok';$session->set('id', '0');}
					$lesfichesss = $mesfiches;
					
				}
				elseif($view == 'corbeille')
				{
					$mesfiches = $em->getRepository('BaclooCrmBundle:Fiche')
								->searchfiche_init_corbeille($nbparpage, $page, $societe);
					if(!isset($mesfiches)){$mesfiches = 'nok';$session->set('id', '0');}
					
					$lesfichesss = $mesfiches;
				}	
				elseif($view == 'shared')
				{//echo 'ocooooooooooooooo';
					$mesfiches = $em->getRepository('BaclooCrmBundle:Fiche')
								->searchfiche_init_shared($nbparpage, $page, $societe);
					if(!isset($mesfiches)){$mesfiches = 'nok';$session->set('id', '0');}
					
					$lesfichesss = $mesfiches;
				}
				if($view == 'chantier')
				{//echo ' on est client';
					$typefiche = $view;
					include('searchchantiers.php');
					
					if(!isset($mesfiches)){$mesfiches = 'nok';$session->set('id', '0');}
					
				}
			}
			elseif($view = 'def' && isset($v) && $v != 1 && !empty($v))
			{
//echo $view.'<<<';
				$view = $v;//echo'ppppppp'.$v.'tt';

				if($view == 'client')
				{//echo ' on est client';
					//print_r($critere);
					$typefiche = $view;
					include('searchprospects.php');
					
					if(!isset($mesfiches)){$mesfiches = 'nok';}
					if($id > 0)
					{
						return $this->redirect($this->generateUrl('bacloocrm_find', array('id' => $id, 'page' =>$session->get('page'), 'view' => $session->get('view') )));
					}
					else
					{
						$session->set('id', '0');
					}
				}
				elseif($view == 'prospect')
				{//echo 'iccccci'.$id;
					$typefiche = $view;
					include('searchprospects.php');
					
					if(!isset($mesfiches)){$mesfiches = 'nok';}
					if($id > 0)
					{//echo 'ghj';
						return $this->redirect($this->generateUrl('bacloocrm_find', array('id' => $id, 'page' => $session->get('page'), 'view' => $session->get('view') )));
					}
					else
					{//echo 'codiiiiiii';
						$session->set('id', '0');
					}
				}
				elseif($view == 'annuaire')
				{//echo 'iiiiiiiiiii';
					$typefiche = 'prospect';
					include('searchprospects.php');
					
					if(!isset($mesfiches)){$mesfiches = 'nok';}
					if($id > 0)
					{
						return $this->redirect($this->generateUrl('bacloocrm_find', array('id' => $id, 'page' => $session->get('page'), 'view' => $session->get('view') )));
					}
					else
					{//echo 'codiiiiiii';
						$session->set('id', '0');
					}
				}
				elseif($view == 'fournisseur')
				{
					$mesfiches = $em->getRepository('BaclooCrmBundle:Fiche')
								->searchfiche_init_fournisseur(20, $page, $societe);
					if(!isset($mesfiches)){$mesfiches = 'nok';}
					if($id > 0)
					{
						return $this->redirect($this->generateUrl('bacloocrm_find', array('id' => $id, 'page' => $session->get('page'), 'view' => $session->get('view') )));
					}
					else
					{
						$session->set('id', '0');
						$lesfichesss = $mesfiches;
					}
				}
				elseif($view == 'corbeille')
				{
					$mesfiches = $em->getRepository('BaclooCrmBundle:Fiche')
								->searchfiche_init_corbeille($nbparpage, $page, $usersess, $societe);
					if(!isset($mesfiches)){$mesfiches = 'nok';}
					if($id > 0)
					{
						return $this->redirect($this->generateUrl('bacloocrm_find', array('id' => $id, 'page' => $session->get('page'), 'view' => $session->get('view') )));
					}
					else
					{
						$session->set('id', '0');
						$lesfichesss = $mesfiches;
					}					
				}
				elseif($view == 'shared')
				{//echo 'iciiiiiiii';
					$mesfiches = $em->getRepository('BaclooCrmBundle:Fiche')
								->searchfiche_init_shared($nbparpage, $page, $usersess, $societe);
					if(!isset($mesfiches)){$mesfiches = 'nok';}
					if($id > 0)
					{
						return $this->redirect($this->generateUrl('bacloocrm_find', array('id' => $id, 'page' => $session->get('page'), 'view' => $session->get('view') )));
					}
					else
					{
						$session->set('id', '0');
						$lesfichesss = $mesfiches;
					}					
				}
				elseif($view == 'chantier')
				{//echo 'iccccci'.$id;
					include('searchchantiers.php');
					
					if(!isset($mesfiches)){$mesfiches = 'nok';}
					if($id > 0)
					{//echo 'ghj';
						return $this->redirect($this->generateUrl('bacloocrm_find', array('id' => $id, 'page' => $session->get('page'), 'view' => $session->get('view') )));
					}
					else
					{//echo 'codiiiiiii';
						$session->set('id', '0');
					}
				}
				elseif($view == 'search')
				{//echo ' init '.$init;
					$session = $request->getSession();
					$inot = $session->get('init');//echo ' inot '.$inot;
					if(isset($init) && !isset($inot))
						{//echo 'pass session';
							if($init == '2')//2 = on est pas en recherche
							{
								$id = $session->get('id');								
								//return $this->redirect($this->generateUrl('bacloocrm_find', array('id' => $id)));
							}
							else
							{
								$id = '0';
								$session = new Session();
								$session = $request->getSession();
								$session->clear();
								$session->set('init', '1');	
								// return $this->redirect($this->generateUrl('bacloocrm_find', array('id' => $id, 'page' => $page, 'view' => $view)));					
							}
						}
					elseif(isset($inot))
						{//echo 'session';
							$init = $inot;
							if($init == '2')//2 = on est pas en recherche
							{//echo ' la ?';
								$id = $session->get('id');								
								// return $this->redirect($this->generateUrl('bacloocrm_search'));	
							}
							else
							{//echo 'idddd';
								$id = '0';
								$session = new Session();
								$session = $request->getSession();
								$session->remove('init');
								$page = $session->get('page');
								$id = $session->get('id');
								if(!isset($id)){$id = '0';}
								$session->set('init', '1');	//echo 'idff'.$id; echo 'page'.$page;
								return $this->redirect($this->generateUrl('bacloocrm_find', array('id' => $id, 'page' => $page)));					
							}							
						}
				}
				else
				{//echo 'olololo';
					$mesfiches = 'nok';
				}
			}
			else
			{
				$view = 'client';//Détermine la vue par défaut
				//echo ' on est client'.$view;
					$typefiche = $view;
					include('searchprospects.php');
					
					if(!isset($mesfiches)){$mesfiches = 'nok';}
					//$session->set('id', '0');
			}
				//On passe tout en session pour les retours
					$session = new Session();
					$session = $request->getSession();
					$session->set('page', $page);
					$session->set('view', $view);

		// Pour récupérer le service UserManager du bundle
		$objUser = $this->get('security.context')->getToken()->getUsername(); if(empty($objUser) or !isset($objUser) or $objUser == 'anon.'){return $this->redirect($this->generateUrl('fos_user_security_login'));}

		$em = $this->getDoctrine()->getManager();		
		$query = $em->createQuery(
			'SELECT u
			FROM BaclooUserBundle:User u
			WHERE u.username = :username'
		)->setParameter('username', $objUser);
		$userdetail = $query->getSingleResult();	
		$tags= $userdetail->getTags();
		$actvise= $userdetail->getActvise();
		$activite= $userdetail->getActivite();
		$plein= $userdetail->getPlein();
		if($plein != 1)
		{
			if(empty($tags) OR empty($actvise) OR empty($activite))
			{
				$userdetail->setPlein(0);
				$em->flush();
			}
			elseif(isset($tags) AND isset($actvise) AND isset($activite))
			{
				$userdetail->setPlein(1);
				if($userdetail->getPoint() != 2)
				{
					$userdetail->setPoint(2);					
				}
				$em->flush();				
			}
		}
		
		// On crée un objet Search
		$search = new Search;//echo 'eeeeeeeeeeeeeeee';
		$form = $this->createForm(new SearchType(), $search);
		$request = $this->getRequest();
			if ($request->getMethod() == 'POST') {
			  $form->bind($request);
				  if ($form->isValid()) {
					// On Flush la recherche
					$data = $form->getData();
					$besoinfilter = $form->get('besoinfilter')->getData();
					$rsfilter = $form->get('rsfilter')->getData();
					$nomfilter = $form->get('nomfilter')->getData();
					$activitefilter = $form->get('activitefilter')->getData();
					$cpfilter = $form->get('cpfilter')->getData();
					$villefilter = $form->get('villefilter')->getData();
					$cperso1filter = $form->get('cperso1filter')->getData();
					$cperso2filter = $form->get('cperso2filter')->getData();
					$cperso3filter = $form->get('cperso3filter')->getData();
					$memofilter = $form->get('memofilter')->getData();
					$histofilter = $form->get('histofilter')->getData();
					$fonctionfilter = $form->get('fonctionfilter')->getData();
					$em = $this->getDoctrine()->getManager();
					$em->persist($search);		
					// on flush le tout
					$em->flush();						
					$session = new Session();
					$session = $request->getSession();
					$session->set('page', $page);
					$session->set('view', $view);
					$session->set('besoinfilter', $besoinfilter);
					$session->set('rsfilter', $rsfilter);
					$session->set('nomfilter', $nomfilter);
					$session->set('activitefilter', $activitefilter);
					$session->set('cpfilter', $cpfilter);
					$session->set('villefilter', $villefilter);
					$session->set('cperso1filter', $cperso1filter);
					$session->set('cperso2filter', $cperso2filter);
					$session->set('cperso3filter', $cperso3filter);
					$session->set('memofilter', $memofilter);
					$session->set('histofilter', $histofilter);
					$session->set('fonctionfilter', $fonctionfilter);
					
					// On redirige vers la page de visualisation de recherche
					//ici l'array doit se constituer en fonction des champs de formulaire remplis
					$idsearch = $search->getId();
					$session->set('idsearch', $idsearch);
					return $this->redirect($this->generateUrl('bacloocrm_find', array('id' => $idsearch, 'view' => $view )
					));
				}
			}
		// echo count($lesfiches);
		// echo '  '.ceil(count($lesfiches)/$nbparpage);
		 //echo 'view==='.$view;
					
		$modules  = $em->getRepository('BaclooCrmBundle:Modules')		
					   ->findOneByUsername($usersess);
		 
		$besoinfilter = $session->get('besoinfilter');
		if($besoinfilter == null)
		{
			$besoinfilter = 'contient';
		}		 
		$rsfilter = $session->get('rsfilter');
		if($rsfilter == null)
		{
			$rsfilter = 'contient';
		}		 
		$nomfilter = $session->get('nomfilter');
		if($nomfilter == null)
		{
			$nomfilter = 'contient';
		}		 
		$activitefilter = $session->get('activitefilter');
		if($activitefilter == null)
		{
			$activitefilter = 'contient';
		}		 
		$cpfilter = $session->get('cpfilter');
		if($cpfilter == null)
		{
			$cpfilter = 'contient';
		}		 
		$villefilter = $session->get('villefilter');
		if($villefilter == null)
		{
			$villefilter = 'contient';
		}		 
		$cperso1filter = $session->get('cperso1filter');
		if($cperso1filter == null)
		{
			$cperso1filter = 'contient';
		}		 
		$cperso2filter = $session->get('cperso2filter');
		if($cperso2filter == null)
		{
			$cperso2filter = 'contient';
		}		 
		$cperso3filter = $session->get('cperso3filter');
		if($cperso3filter == null)
		{
			$cperso3filter = 'contient';
		}		 
		$memofilter = $session->get('memofilter');
		if($memofilter == null)
		{
			$memofilter = 'contient';
		}		 
		$histofilter = $session->get('histofilter');
		if($histofilter == null)
		{
			$histofilter = 'contient';
		}		 
		$fonctionfilter = $session->get('fonctionfilter');
		if($fonctionfilter == null)
		{
			$fonctionfilter = 'contient';
		}
			if($speed == 1)
			{
				return $this->render('BaclooCrmBundle:Crm:search3.html.twig', array('mesfiches' => $mesfiches,
																					'page' => $page,
																					'pagesr' => $pagesr,
																					'user' => $usersess,
																					'modules' => $modules,
																					'mesfichestot' => $mesfichestot,
																					'view' => $view,
																					'vue' => $vue,
																					'speed' => $speed,
																					'init' => $init,
																					'id' => $id,
																					'tab' => 'tab1',
																					'lesfichesss' => count($lesfichesss),
																					'nombrePage' => ceil(count($lesfichesss)/$nbparpage),
																					'actvise' => $actvise,
																					'activite' => $activite,
																					'tags' => $tags,
																					'besoinfilter' => $besoinfilter,
																					'rsfilter' => $rsfilter,
																					'nomfilter' => $nomfilter,
																					'activitefilter' => $activitefilter,
																					'cpfilter' => $cpfilter,
																					'villefilter' => $villefilter,
																					'cperso1filter' => $cperso1filter,
																					'cperso2filter' => $cperso2filter,
																					'cperso3filter' => $cperso3filter,
																					'memofilter' => $memofilter,
																					'histofilter' => $histofilter,
																					'fonctionfilter' => $fonctionfilter,
																					'form' => $form->createView()));
			}
			else
			{
			if(!isset($lesfichesss)){$lesfichesss = 0;}//echo 'uiuiuiii';echo $id;
				return $this->render('BaclooCrmBundle:Crm:search.html.twig', array('mesfiches' => $mesfiches,
																					'page' => $page,
																					'pagesr' => $pagesr,
																					'user' => $usersess,
																					'modules' => $modules,
																					'mesfichestot' => $mesfichestot,
																					'view' => $view,
																					'vue' => $vue,
																					'idsearchrap' => $idsearchrap,
																					'speed' => $speed,
																					'tab' => 'tab1',
																					'lesfichesss' => count($lesfichesss),
																					'nombrePage' => ceil(count($lesfichesss)/$nbparpage),
																					'actvise' => $actvise,
																					'activite' => $activite,
																					'tags' => $tags,
																					'besoinfilter' => $besoinfilter,
																					'rsfilter' => $rsfilter,
																					'nomfilter' => $nomfilter,
																					'activitefilter' => $activitefilter,
																					'cpfilter' => $cpfilter,
																					'villefilter' => $villefilter,
																					'cperso1filter' => $cperso1filter,
																					'cperso2filter' => $cperso2filter,
																					'cperso3filter' => $cperso3filter,
																					'memofilter' => $memofilter,
																					'histofilter' => $histofilter,
																					'fonctionfilter' => $fonctionfilter,
																					'form' => $form->createView()));
			}
		} 	
	
	public function search2Action($page, $vue, $speed, $useracc, Request $request)
	{if(!isset($page)){$page =1;}
		$nbparpage = 20;
		include('societe.php');		
		$usersess = $this->get('security.context')->getToken()->getUsername(); if(empty($usersess) or !isset($usersess) or $usersess == 'anon.'){return $this->redirect($this->generateUrl('fos_user_security_login'));}//Récupère le nom d'utilisateur
		$em = $this->getDoctrine()->getManager();
		$userdetails  = $em->getRepository('BaclooUserBundle:User')		
					   ->findOneByUsername($usersess);
					   
		$user = $userdetails;
		
		$mesfichestot = $em->getRepository('BaclooCrmBundle:Fiche')
					->searchfiche_init($nbparpage, $page, $usersess, $userdetails->getRoleuser());		

		$session = $request->getSession();
		$view = $session->get('view');
		//echo 'lavue'.$view;

		//On récupère les favoris niveau ALL
		$em = $this->getDoctrine()->getManager();
		$query = $em->createQuery(
				'SELECT f.favusername
				FROM BaclooCrmBundle:Favoris f
				WHERE f.username = :username
				AND f.toutpart = :toutpart'
			)->setParameter('username', $usersess);
			$query->setParameter('toutpart', 1);
			$favoriall = $query->getResult();
			// echo 'cbien1 favoriall'.count($favoriall);

		//On créée un tableau sous le modèle 'user'=>$xxxx pour le repository
		if(isset($favoriall) && !empty($favoriall) && count($favoriall)>1)
		{//echo 'li';
			$i = 0;
			foreach($favoriall as $favo)
			{
				$favor  = $em->getRepository('BaclooCrmBundle:Favoris')		
							   ->findOneByFavusername($favo);						
				// $choix[$i++] = $favor->getFavusername();
			}
			
			$critere = "array(".$usersess;
			
			for($j=1;$j<$i;$j++)
			{
				$critere .= ", ".$choix[$j];					
			}
			$critere .= ')';
		}
		else
		{
			$critere = array($usersess);
		}
		
		if($view == 'client')
		{
			$typefiche = $view;
			include('searchprospects.php');
			
			if(!isset($mesfiches)){$mesfiches = 'nok';}
		}
		elseif($view == 'prospect')
		{
			$typefiche = $view;
			include('searchprospects.php');
			
			if(!isset($mesfiches)){$mesfiches = 'nok';}
		}
		elseif($view == 'fournisseur')
		{
			$mesfiches = $em->getRepository('BaclooCrmBundle:Fiche')
						->searchfiche_init_fournisseur($nbparpage, $page, $societe);
			if(!isset($mesfiches)){$mesfiches = 'nok';}
			$lesfichesss = $mesfiches;
		}
		elseif($view == 'corbeille')
		{
			$mesfiches = $em->getRepository('BaclooCrmBundle:Fiche')
						->searchfiche_init_corbeille($nbparpage, $page, $usersess, $societe);
			if(!isset($mesfiches)){$mesfiches = 'nok';}
			$lesfichesss = $mesfiches;
		}	
		elseif($view == 'shared')
		{
			$mesfiches = $em->getRepository('BaclooCrmBundle:Fiche')
						->searchfiche_init_shared($nbparpage, $page, $usersess, $societe);
			if(!isset($mesfiches)){$mesfiches = 'nok';}
			$session->set('id', '0');
			$lesfichesss = $mesfiches;
		}
		else
		{
			$typefiche = 'client';
			include('searchprospects.php');
			
			if(!isset($mesfiches)){$mesfiches = 'nok';}
		}
		if($view == 'chantier')
		{//echo ' on est client';
			$typefiche = $view;
			include('searchchantiers.php');			
			if(!isset($mesfiches)){$mesfiches = 'nok';$session->set('id', '0');}
			$lesfichesss = $mesfiches;
			
		}
		// On crée un objet Search
		$search = new Search;//echo 'ffffffffffffffff';
		$form = $this->createForm(new SearchType(), $search);
		$request = $this->getRequest();
			if ($request->getMethod() == 'POST') {//echo 'persistseach';
			  $form->bind($request);
				  if ($form->isValid()) {
					// On Flush la recherche
					$data = $form->getData();
					$besoinfilter = $form->get('besoinfilter')->getData();
					$rsfilter = $form->get('rsfilter')->getData();
					$nomfilter = $form->get('nomfilter')->getData();
					$activitefilter = $form->get('activitefilter')->getData();
					$cpfilter = $form->get('cpfilter')->getData();
					$villefilter = $form->get('villefilter')->getData();
					$cperso1filter = $form->get('cperso1filter')->getData();
					$cperso2filter = $form->get('cperso2filter')->getData();
					$cperso3filter = $form->get('cperso3filter')->getData();
					$memofilter = $form->get('memofilter')->getData();
					$histofilter = $form->get('histofilter')->getData();
					$fonctionfilter = $form->get('fonctionfilter')->getData();	
					$em = $this->getDoctrine()->getManager();
					$em->persist($search);		
					// on flush le tout
					$em->flush();
					$session = new Session();
					$session = $request->getSession();
					$session->set('page', $page);
					$session->set('view', $view);
					$session->set('besoinfilter', $besoinfilter);
					$session->set('rsfilter', $rsfilter);
					$session->set('nomfilter', $nomfilter);
					$session->set('activitefilter', $activitefilter);
					$session->set('cpfilter', $cpfilter);
					$session->set('villefilter', $villefilter);
					$session->set('cperso1filter', $cperso1filter);
					$session->set('cperso2filter', $cperso2filter);
					$session->set('cperso3filter', $cperso3filter);
					$session->set('memofilter', $memofilter);
					$session->set('histofilter', $histofilter);
					$session->set('fonctionfilter', $fonctionfilter);						
							
					// On redirige vers la page de visualisation de recherche
					//ici l'array doit se constituer en fonction des champs de formulaire remplis
					$id = $search->getid();
					return $this->redirect($this->generateUrl('bacloocrm_find', array('id' => $id, 
																					  'page' => $page,
																					  'view' => $view)
					));
				}
			}
		$session = $request->getSession();
		$vue = $session->get('vue');
		$modules  = $em->getRepository('BaclooCrmBundle:Modules')		
					   ->findOneByUsername($usersess);
							   
				$besoinfilter = $session->get('besoinfilter');
				if($besoinfilter == null)
				{
					$besoinfilter = 'contient';
				}		 
				$rsfilter = $session->get('rsfilter');
				if($rsfilter == null)
				{
					$rsfilter = 'contient';
				}		 
				$nomfilter = $session->get('nomfilter');
				if($nomfilter == null)
				{
					$nomfilter = 'contient';
				}		 
				$activitefilter = $session->get('activitefilter');
				if($activitefilter == null)
				{
					$activitefilter = 'contient';
				}		 
				$cpfilter = $session->get('cpfilter');
				if($cpfilter == null)
				{
					$cpfilter = 'contient';
				}		 
				$villefilter = $session->get('villefilter');
				if($villefilter == null)
				{
					$villefilter = 'contient';
				}		 
				$cperso1filter = $session->get('cperso1filter');
				if($cperso1filter == null)
				{
					$cperso1filter = 'contient';
				}		 
				$cperso2filter = $session->get('cperso2filter');
				if($cperso2filter == null)
				{
					$cperso2filter = 'contient';
				}		 
				$cperso3filter = $session->get('cperso3filter');
				if($cperso3filter == null)
				{
					$cperso3filter = 'contient';
				}		 
				$memofilter = $session->get('memofilter');
				if($memofilter == null)
				{
					$memofilter = 'contient';
				}		 
				$histofilter = $session->get('histofilter');
				if($histofilter == null)
				{
					$histofilter = 'contient';
				}		 
				$fonctionfilter = $session->get('fonctionfilter');
				if($fonctionfilter == null)
				{
					$fonctionfilter = 'contient';
				}	
				
			if($speed == 1)
			{
				return $this->render('BaclooCrmBundle:Crm:searchfiche2.html.twig', array('mesfiches' => $mesfiches,
																						'page' => $page,
																						'mesfichestot' => $mesfichestot,
																						'view' => $view,
																						'modules' => $modules,
																						'vue' => $vue,
																						'lesfichesss' => count($lesfichesss),
																						'nombrePage' => ceil(count($lesfichesss)/$nbparpage),
																						'besoinfilter' => $besoinfilter,
																						'rsfilter' => $rsfilter,
																						'nomfilter' => $nomfilter,
																						'activitefilter' => $activitefilter,
																						'cpfilter' => $cpfilter,
																						'villefilter' => $villefilter,
																						'cperso1filter' => $cperso1filter,
																						'cperso2filter' => $cperso2filter,
																						'cperso3filter' => $cperso3filter,
																						'memofilter' => $memofilter,
																						'histofilter' => $histofilter,
																						'fonctionfilter' => $fonctionfilter,			
																						'form' => $form->createView()));
			}
			else
			{
				return $this->render('BaclooCrmBundle:Crm:searchfiche.html.twig', array('mesfiches' => $mesfiches,
																						'page' => $page,
																						'mesfichestot' => $mesfichestot,
																						'view' => $view,
																						'modules' => $modules,
																						'vue' => $vue,
																						'lesfichesss' => count($lesfichesss),
																						'nombrePage' => ceil(count($lesfichesss)/$nbparpage),
																						'besoinfilter' => $besoinfilter,
																						'rsfilter' => $rsfilter,
																						'nomfilter' => $nomfilter,
																						'activitefilter' => $activitefilter,
																						'cpfilter' => $cpfilter,
																						'villefilter' => $villefilter,
																						'cperso1filter' => $cperso1filter,
																						'cperso2filter' => $cperso2filter,
																						'cperso3filter' => $cperso3filter,
																						'memofilter' => $memofilter,
																						'histofilter' => $histofilter,
																						'fonctionfilter' => $fonctionfilter,			
																						'form' => $form->createView()));			
			}
		}	

// le paramètre de l'action doit se remplir en fonction des critères de recherche		
 	public function findAction($id, $page, $view, $speed, Request $request)
		{//echo 'page1'.$page;
		// echo 'lavue1'.$view;
		//echo $id;
				$session = $request->getSession();
		$nbparpage = 15;
		include('societe.php');	
		$usersess = $this->get('security.context')->getToken()->getUsername(); if(empty($usersess) or !isset($usersess) or $usersess == 'anon.'){return $this->redirect($this->generateUrl('fos_user_security_login'));}
			// On récupère l'EntityManager
			$em = $this->getDoctrine()
					   ->getManager();
			
					$query = $em->createQuery(
						'SELECT u
						FROM BaclooUserBundle:User u
						WHERE u.username = :username'
					)->setParameter('username', $usersess);
					$userdetail = $query->getSingleResult();	
					$tags= $userdetail->getTags();
					$actvise= $userdetail->getActvise();
					$activite= $userdetail->getActivite();
					if(empty($tags) OR empty($actvise) OR empty($activite))
					{
						$userdetail->setPlein(0);
						$em->flush();
					}
					elseif(isset($tags) AND isset($actvise) AND isset($activite))
					{
						$userdetail->setPlein(1);
						if($userdetail->getPoint() != 2)
						{
							$userdetail->setPoint(2);					
						}
						$em->flush();					
					}

				if($id != 0)
				{
				
					//On récupère les favoris niveau ALL
					$em = $this->getDoctrine()->getManager();
					$query = $em->createQuery(
							'SELECT f.favusername
							FROM BaclooCrmBundle:Favoris f
							WHERE f.favusername = :favusername
							AND f.toutpart = :toutpart'
						)->setParameter('favusername', $usersess);
						$query->setParameter('toutpart', 1);
						$favoriall = $query->getResult();
						//echo 'cbien2 favoriall'.count($favoriall);

					//On créée un tableau sous le modèle 'user'=>$xxxx pour le repository
					if(isset($favoriall) && !empty($favoriall))
					{//echo 'liiiiiii';
						$i = 1;
						foreach($favoriall as $favo)
						{
							foreach($favo as $fav)
							{
							////echo 'favo'.$fav;
			//BIZARD				
								$favor  = $em->getRepository('BaclooCrmBundle:Favoris')		
											   ->findOneByFavusername($usersess);						
								${'choix'.$i++} = $favor->getUsername();
							}
						}
						//echo 'choix1'.$choix1;
						$critere = array($usersess);
						
						for($j=1;$j<$i;$j++)
						{
							${'critere'.$j} = array(${"choix".$j});
							$critere = array_merge(${'critere'.$j},$critere);
						}
						
					}
					else
					{
						$critere = array($usersess);
					}				
					$search = $em->getRepository('BaclooCrmBundle:Search')->find($id);
					$ficheid = $search->getFicheid();
					$raisonSociale = $search->getRaisonSociale();
					$nom = $search->getNom();
					$besoin = $search->getBesoins();
					$activite = $search->getActivite();
					$cp = $search->getCp();
					$ville = $search->getVille();
					$cperso1 = $search->getCperso1();
					$cperso2 = $search->getCperso2();
					$cperso3 = $search->getCperso3();
					$memo = $search->getMemo();
					$histo = $search->getHisto();
					$fonction = $search->getFonction();
					$searchsess = $search;
					$besoinfilter = $session->get('besoinfilter');
					$rsfilter = $session->get('rsfilter');
					$nomfilter = $session->get('nomfilter');
					$activitefilter = $session->get('activitefilter');					
					$cpfilter = $session->get('cpfilter');					
					$villefilter = $session->get('villefilter');
					$cperso1filter = $session->get('cperso1filter');
					$cperso2filter = $session->get('cperso2filter');
					$cperso3filter = $session->get('cperso3filter');
					$memofilter = $session->get('memofilter');
					$histofilter = $session->get('histofilter');
					$fonctionfilter = $session->get('fonctionfilter');
					$fiche = new Fiche;
					$em = $this->getDoctrine()->getManager();
					if($view == 'chantier')
					{
						$resultats = $em->getRepository('BaclooCrmBundle:Chantier')
									->searchfiche($raisonSociale, $view, $nom, $activite, $besoin, $nbparpage, $page, $societe, $cp, $ville, $cperso1, $cperso2, $cperso3, $memo, $histo, $fonction,
												   $besoinfilter, $rsfilter, $nomfilter, $activitefilter, $cpfilter, $villefilter, $cperso1filter, $cperso2filter, $cperso3filter, $memofilter, $histofilter, $fonctionfilter);
						// echo 'résultat'.count($resultats);
					}
					else
					{
						$resultats = $em->getRepository('BaclooCrmBundle:Fiche')
									->searchfiche($raisonSociale, $view, $nom, $activite, $besoin, $nbparpage, $page, $societe, $cp, $ville, $cperso1, $cperso2, $cperso3, $memo, $histo, $fonction,
												   $besoinfilter, $rsfilter, $nomfilter, $activitefilter, $cpfilter, $villefilter, $cperso1filter, $cperso2filter, $cperso3filter, $memofilter, $histofilter, $fonctionfilter, $userdetail->getUsername(), $userdetail->getRoleuser());
						// echo count($resultats);
					}
					if(isset($resultats))
					{//echo 'set'.$id;
						$session = new Session();
						$session = $request->getSession();
						// $session->remove('idsearch');
						$session->set('page', $page);
						$session->set('view', $view);
						//c'est icic que se décide la sessionde ID
						
						//$idsearch = $session->get('idsearch');
						// $session->set('id', $idsearch);
						//echo 'id2'.$idsearch.'<<';								
					}else
					{//echo 'pas de résultat';
					// $session = new Session();
					// $session = $request->getSession();
					// $session->set('page', $page);
					// $session->set('view', $view);
					// $session->set('id', 0);												
					}
					$lesfichesss = $resultats;
					 // echo 'id pas 0';echo $view;
				}
				elseif($id == 'xxx')
				{
					$offresdumois = $em->getRepository('BaclooCrmBundle:Locata')		
					   ->offresdumoisgroupe($page);
					$resultats = array();
					foreach($offresdumois as $of)
					{
						$resultats[] = $em->getRepository('BaclooCrmBundle:Fiche')		
						   ->findOneByRaisonSociale($of->getClient());
						$lesfichesss = $resultats;
						// echo '**'.$of->getClient().'**';					
					}
				}
				else
				{
					$idsearch = 0;
					$session = new Session();
					$session = $request->getSession();
					$session->set('page', $page);
					$session->set('view', $view);
					// $session->set('id', $id);					
					//On récupère les favoris niveau ALL
					$em = $this->getDoctrine()->getManager();
					$query = $em->createQuery(
							'SELECT f.favusername
							FROM BaclooCrmBundle:Favoris f
							WHERE f.favusername = :favusername
							AND f.toutpart = :toutpart'
						)->setParameter('favusername', $usersess);
						$query->setParameter('toutpart', 1);
						$favoriall = $query->getResult();
						//echo 'cbien2 favoriall'.count($favoriall);

					//On créée un tableau sous le modèle 'user'=>$xxxx pour le repository
					if(isset($favoriall) && !empty($favoriall))
					{//echo 'liiiiiii';
						$i = 1;
						foreach($favoriall as $favo)
						{
							foreach($favo as $fav)
							{
							////echo 'favo'.$fav;
								$favor  = $em->getRepository('BaclooCrmBundle:Favoris')		
											   ->findOneByFavusername($usersess);						
								${'choix'.$i++} = $favor->getUsername();
							}
						}
						//echo 'choix1'.$choix1;
						$critere = array($usersess);
						
						for($j=1;$j<$i;$j++)
						{
							${'critere'.$j} = array(${"choix".$j});
							$critere = array_merge(${'critere'.$j},$critere);
						}
						
					}
					else
					{
						$critere = array($usersess);
					}				
					// echo 'ici'.$view;
						if($view == 'client')
						{//echo ' on est client';
							$typefiche = $view;
							include('searchprospects.php');
							
							if(!isset($mesfiches)){$mesfiches = 'nok';}
						}
						elseif($view == 'prospect')
						{//echo ' on est prospectooo';
							$typefiche = $view;
							include('searchprospects.php');
							
							if(!isset($mesfiches)){$mesfiches = 'nok';}
						}
						elseif($view == 'fournisseur')
						{//echo ' on est prospectooo';
							$typefiche = $view;
							include('searchprospects.php');
							
							if(!isset($mesfiches)){$mesfiches = 'nok';}
						}
						elseif($view == 'annuaire')
						{//echo ' on est annuaire';
							$typefiche = 'prospect';
							include('searchprospects.php');
							
							if(!isset($mesfiches)){$mesfiches = 'nok';}
						}
						elseif($view == 'chantier')
						{//echo ' on est chantier';
							$typefiche = 'chantier';
							include('searchchantiers.php');
							
							if(!isset($mesfiches)){$mesfiches = 'nok';}
						}
						elseif($view == 'corbeille')
						{//echo ' on est corbeille';
							$mesfiches = $em->getRepository('BaclooCrmBundle:Fiche')
										->searchfiche_init_corbeille($nbparpage, $page, $usersess);
							if(!isset($mesfiches)){$mesfiches = 'nok';}
							$lesfiches = $mesfiches;
							$lesfichesss = $mesfiches;
						}
						elseif($view == 'search')
						{//echo ' on est search';
							$mesfiches = 'nok';
							$lesfiches = $mesfiches;
						}//echo 'la vue'.$view;
						$resultats = $mesfiches;

				}
				$besoinfilter = $session->get('besoinfilter');
				if($besoinfilter == null)
				{
					$besoinfilter = 'contient';
				}		 
				$rsfilter = $session->get('rsfilter');
				if($rsfilter == null)
				{
					$rsfilter = 'contient';
				}		 
				$nomfilter = $session->get('nomfilter');
				if($nomfilter == null)
				{
					$nomfilter = 'contient';
				}		 
				$activitefilter = $session->get('activitefilter');
				if($activitefilter == null)
				{
					$activitefilter = 'contient';
				}		 
				$cpfilter = $session->get('cpfilter');
				if($cpfilter == null)
				{
					$cpfilter = 'contient';
				}		 
				$villefilter = $session->get('villefilter');
				if($villefilter == null)
				{
					$villefilter = 'contient';
				}		 
				$cperso1filter = $session->get('cperso1filter');
				if($cperso1filter == null)
				{
					$cperso1filter = 'contient';
				}		 
				$cperso2filter = $session->get('cperso2filter');
				if($cperso2filter == null)
				{
					$cperso2filter = 'contient';
				}		 
				$cperso3filter = $session->get('cperso3filter');
				if($cperso3filter == null)
				{
					$cperso3filter = 'contient';
				}		 
				$memofilter = $session->get('memofilter');
				if($memofilter == null)
				{
					$memofilter = 'contient';
				}		 
				$histofilter = $session->get('histofilter');
				if($histofilter == null)
				{
					$histofilter = 'contient';
				}		 
				$fonctionfilter = $session->get('fonctionfilter');
				if($fonctionfilter == null)
				{
					$fonctionfilter = 'contient';
				}				
				if(!empty($resultats) && isset($resultats) && $resultats != 'nok')
				{//echo ' esttttttttttttttt ';echo $view;echo count($lesfiches);
					// On crée un objet Search
				
				$session = $request->getSession();
				$init = $session->get('init');//echo 'init sess'.$init;
					$searchf = new Search;
					//echo 'ggggggggggggggggg';echo $request->getMethod();
					$form = $this->createForm(new SearchType(), $searchf);
					$request = $this->getRequest();
						if ($request->getMethod() == 'POST') {
						  $form->bind($request);
							  if ($form->isValid()) {
								// On Flush la recherche
								$em = $this->getDoctrine()->getManager();
								$em->persist($searchf);		
								// on flush le tout
								$em->flush();		
								// echo 'lavue3'.$view;
								// On redirige vers la page de visualisation de recherche
								return $this->redirect($this->generateUrl('bacloocrm_find', array('id' => $idsearch, 'view' => $view)));//getID ?? non ?
							}
						}
				//echo 'la'.$page;
				//echo 'lavue2'.$view;
				$session = $request->getSession();
				//$id = $session->get('id');//echo 'iiddddd'.$session->get('id');
				$page = $session->get('page');
				$view = $session->get('view');
				$modules  = $em->getRepository('BaclooCrmBundle:Modules')		
							   ->findOneByUsername($usersess);
				// echo $view;echo count($lesfiches);
					if($speed == 1)
					{//echo 'balbalbal';
						return $this->render('BaclooCrmBundle:Crm:search3.html.twig', array(
								'page' => $page,
								'user' => $usersess,
								'modules' => $modules,
								'view' => $view,
								'speed' => $speed,
								'init' => $init,
								'id' => $id,
								'lesfichesss' => count($lesfichesss),
								'nombrePage' => ceil(count($lesfichesss)/$nbparpage),
								'resultats' => $resultats, 
								'actvise' => $actvise,
								'activite' => $activite,
								'tags' => $tags,
								'rsfilter' => $rsfilter,
								'nomfilter' => $nomfilter,
								'activitefilter' => $activitefilter,
								'cpfilter' => $cpfilter,
								'villefilter' => $villefilter,
								'cperso1filter' => $cperso1filter,
								'cperso2filter' => $cperso2filter,
								'cperso3filter' => $cperso3filter,
								'memofilter' => $memofilter,
								'histofilter' => $histofilter,
								'fonctionfilter' => $fonctionfilter,
								'form' => $form->createView()));
					}
					else
					{
						if($id == 0){
						// $search = $em->getRepository('BaclooCrmBundle:Search')->find($id);
						$search = $resultats;
						}
						elseif($id ='xxx')
						{
							$search = $resultats;
						}
// echo $view;					
						// foreach($resultats as $res){echo '>'.$res->getRaisonSociale().'<';}
						// echo 'ooo'.$id.'lllllll'.$search->getId();		
						return $this->render('BaclooCrmBundle:Crm:search.html.twig', array(
								'id' => $id,
								'idsearchrap' => 0,
								'search' => $search,
								'page' => $page,
								'pagesr' => 1,
								'user' => $usersess,
								'modules' => $modules,
								'view' => $view,
								'lesfichesss' => count($lesfichesss),
								'vue' => 'rappels',
								'nombrePage' => ceil(count($lesfichesss)/$nbparpage),
								'resultats' => $resultats, // C'est ici tout l'intérêt : le contrôleur passe les variables nécessaires au template !
								'tags' => $tags,
								'actvise' => $actvise,
								'activite' => $activite,
								'besoinfilter' => $besoinfilter,
								'rsfilter' => $rsfilter,
								'nomfilter' => $nomfilter,
								'activitefilter' => $activitefilter,
								'cpfilter' => $cpfilter,
								'villefilter' => $villefilter,
								'cperso1filter' => $cperso1filter,
								'cperso2filter' => $cperso2filter,
								'cperso3filter' => $cperso3filter,
								'memofilter' => $memofilter,
								'histofilter' => $histofilter,
								'fonctionfilter' => $fonctionfilter,
								'form' => $form->createView()
						));
					}
					
				}
				else{//echo ' onnnnnnnnnnnnnn ';
					// On crée un objet Search
					$searchf = new Search;
					$form = $this->createForm(new SearchType(), $searchf);
					$request = $this->getRequest();
						if ($request->getMethod() == 'POST') {
						  $form->bind($request);
							  if ($form->isValid()) {
								// On Flush la recherche
								$em = $this->getDoctrine()->getManager();
								$em->persist($searchf);		
								// on flush le tout
								$em->flush();
								
								//echo 'lavue4'.$view;
								// On redirige vers la page de visualisation de recherche
								// return $this->redirect($this->generateUrl('bacloocrm_find', array('id' => $search->getFicheid(), 'view' => $view)));
							}
						}
						
					$modules  = $em->getRepository('BaclooCrmBundle:Modules')		
								   ->findOneByUsername($usersess);
					return $this->render('BaclooCrmBundle:Crm:search.html.twig', array('idsearchrap' => 0, 
																					   'pagesr' => 1,
																					   'form' => $form->createView(),
																					   'tags' => $tags,'actvise' => $actvise,
																					   'activite' => $activite, 
																					   'user' => $usersess, 
																					   'modules' => $modules, 
																					   'view' => $view,
																						'besoinfilter' => $besoinfilter,
																						'rsfilter' => $rsfilter,
																						'nomfilter' => $nomfilter,
																						'activitefilter' => $activitefilter,
																						'cpfilter' => $cpfilter,
																						'villefilter' => $villefilter,
																						'cperso1filter' => $cperso1filter,
																						'cperso2filter' => $cperso2filter,
																						'cperso3filter' => $cperso3filter,
																						'memofilter' => $memofilter,
																						'histofilter' => $histofilter,
																						'fonctionfilter' => $fonctionfilter));			
				}
			
		}

		public function searchrappelsAction($idsearchrap, $page, $vue, $speed, $mode, Request $request){
		$user= $this->get('security.context')->getToken()->getUsername(); if(empty($user) or !isset($user) or $user == 'anon.'){return $this->redirect($this->generateUrl('fos_user_security_login'));}	
		// Avant de lancer une recherche on vide la table rapsearch
		$em = $this->getDoctrine()->getManager();
		// echo 'YYYYYY'.$page;
		if(!isset($idsearchrap)){$idsearchrap = 0;}		
		$id = $idsearchrap;//echo 'iddd'.$id;
		
		$session = $request->getSession();
			if($id != 'xxx' || $id == 0)
			{
				$du = $session->get('du');
				$au = $session->get('au');//print_r($au);
			}
			elseif($id == 'xxx')
			{//echo 'mmmmmmmm';echo $id;
				$session->set('pagesr',1);
				$du = '2013-01-01';
				$au = date('Y-m-d');
				$session->set('du', $du);
				$session->set('au', $au);				
			}
			
			$vue = $session->get('vue');//echo 'session vue'.$vue;
			$viewb = $session->get('view');//echo 'viewb'.$viewb;
			$page = $session->get('pagesr');//echo 'XXXXXXX'.$page;
			
		if(!isset($du) && !isset($au))
		{
			$du = '2013-01-01';
			$au = date('Y-m-d');
		}
		
		if(!isset($vue))
		{
			$vue = 'rappels';
		}
		
		if(!isset($page))
		{
			$page = 1;
		}
		
		if(!isset($idsearchrap))
		{
			$id = 0;
		}

	if($vue == 'rappels')
	{	
		if($mode == 'chantier')
		{
			//$fiche = new Fiche;	
			$fiche = $em->getRepository('BaclooCrmBundle:Chantier')
			->searchrap($du, $au, 10, $page, $user);
			//$id = 0;
			$session->set('vue', $vue);
		}
		else	
		{
			//$fiche = new Fiche;	
			$fiche = $em->getRepository('BaclooCrmBundle:Fiche')
			->searchrap($du, $au, 10, $page, $user);
			//$id = 0;
			$session->set('vue', $vue);	
		}			
	}
	elseif($vue == 'a_faire')
	{
		if($mode == 'chantier')
		{
			$fiche = $em->getRepository('BaclooCrmBundle:Chantier')
			->searcha_faire($du, $au, 10, $page, $user);
			//$id = 0;
			$session = new Session();
			$session->set('vue', $vue);
		}
		else	
		{		
			$fiche = $em->getRepository('BaclooCrmBundle:Fiche')
			->searcha_faire($du, $au, 10, $page, $user);
			//$id = 0;
			$session = new Session();
			$session->set('vue', $vue);	
		}	
	}
	elseif($vue == 'rdv')
	{
		if($mode == 'chantier')
		{
			$fiche = $em->getRepository('BaclooCrmBundle:Chantier')
			->searchrdv($du, $au, 10, $page, $user);
			//$id = 0;
			$session->set('vue', $vue);	
		}
		else	
		{		
			$fiche = $em->getRepository('BaclooCrmBundle:Fiche')
			->searchrdv($du, $au, 10, $page, $user);
			//$id = 0;
			$session->set('vue', $vue);		
		}		
	}
	elseif($vue == 'all')
	{
		if($mode == 'chantier')
		{
			$fiche = $em->getRepository('BaclooCrmBundle:Chantier')
			->searchallrap($du, $au, 10, $page, $user);
			//$id = 0;
			$session->set('vue', $vue);
		}
		else	
		{			
			$fiche = $em->getRepository('BaclooCrmBundle:Fiche')
			->searchallrap($du, $au, 10, $page, $user);
			//$id = 0;
			$session->set('vue', $vue);		
		}		
	}
	else
	{	
		if($mode == 'chantier')
		{
			//$fiche = new Fiche;	
			$fiche = $em->getRepository('BaclooCrmBundle:Chantier')
			->searchrap($du, $au, 10, $page1, $user);
			// $id = 0;
			$session->set('vue', $vue);
		}
		else	
		{			
			//$fiche = new Fiche;	
			$fiche = $em->getRepository('BaclooCrmBundle:Fiche')
			->searchrap($du, $au, 10, $page1, $user);
			// $id = 0;
			$session->set('vue', $vue);	
		}			
	}//echo 'session vue2'.$vue;
	
		$rapsearch = new Rapsearch;//echo 'rapsearch';
			$form = $this->createForm(new RapsearchType(), $rapsearch);
			$request = $this->getRequest();
				if ($request->getMethod() == 'POST') {//echo 'postrap';
				  $form->bind($request);
					if ($form->isValid())
					{
					// On Flush la recherche
					$em = $this->getDoctrine()->getManager();
					$em->persist($rapsearch);		
					// on flush le tout
					$em->flush();						
					$session->set('vue', $vue);			
					$session->set('du', $du);			
					$session->set('au', $au);			
					// On redirige vers la page de visualisation de recherche

							return $this->redirect($this->generateUrl('bacloocrm_showrappels', array('id' => $id, 'vue'=> $vue, 'mode'=> $mode)
																							  ));
					}
				}				
					// echo 'rap pas post   ';	echo $request->getMethod();

					$modules  = $em->getRepository('BaclooCrmBundle:Modules')		
								   ->findOneByUsername($user);					

				if($speed == 1)
				{
					return $this->render('BaclooCrmBundle:Crm:searchdate2.html.twig', array('id' => $id,
																							'page' => $page,
																							'nombrePage' => ceil(count($fiche)/10),					
																							'fiche' => $fiche, // C'est ici tout l'intérêt : le contrôleur passe les variables nécessaires au template !
																							'du' => $du,
																							'modules' => $modules,
																							'au'=> $au,
																							'vue'=> $vue,
																							'p'=> '1',
																							'user' => $user,
																							'form' => $form->createView()
																							));	
				}
				else
				{
					return $this->render('BaclooCrmBundle:Crm:searchdate.html.twig', array('id' => $id,
																							'page' => $page,
																							'nombrePage' => ceil(count($fiche)/10),					
																							'fiche' => $fiche, // C'est ici tout l'intérêt : le contrôleur passe les variables nécessaires au template !
																							'du' => $du,
																							'modules' => $modules,
																							'au'=> $au,
																							'vue'=> $vue,
																							'mode'=> $mode,
																							'p'=> '1',
																							'user' => $user,
																							'useracc' => $user,
																							'form' => $form->createView()
																							));				
				}
				
		}
			
		public function showrappelsAction($page, $pagesr, $id, $vue, $mode, Request $request)
		{//echo 'showrap';
			if(!isset($page) || $page == 0){$page =1;}//echo $page;
			$user= $this->get('security.context')->getToken()->getUsername(); if(empty($user) or !isset($user) or $user == 'anon.'){return $this->redirect($this->generateUrl('fos_user_security_login'));}	
			$em = $this->getDoctrine()->getManager();
			$useracc = $user;
// echo 'page'.$pagesr;
			$session = $request->getSession();
			if($id != 'xxx')
			{//echo 'ici';
				$du = $session->get('du');
				$au = $session->get('au');//print_r($au);
				$session->set('pagesr', $pagesr);
			}
			elseif($id == 'xxx')
			{
				$session->set('pagesr',1);
				$du = '2013-01-01';
				$au = date('Y-m-d');
				$session->set('du', $du);
				$session->set('au', $au);				
			}
				$vue = $session->get('vue');//echo 'session vue'.$vue;
				$viewb = $session->get('view');//echo 'viewb'.$viewb;
				$pagesr = $session->get('pagesr');
			if(isset($viewb))
			{
				$view = $viewb;
			}

			if(!isset($id))
			{
				$id = 0;
			}
			
			if(!isset($du) && !isset($au))
			{
				$du = '2013-01-01';
				$au = date('Y-m-d');
			}
			
			if(!isset($vue))
			{
				$vue = 'rappels';
			}

			if($vue == 'rappels')
			{
				if($id == 0){//echo 'pas de rech';
						$em = $this->getDoctrine()->getManager();
						$rapsearch = new Rapsearch;
						$du = '2013-01-01';
						$au = date('Y-m-d');
						$fiche = new Fiche;				
						$resultrap = $em->getRepository('BaclooCrmBundle:Fiche')
									->searchrap($du, $au, 10, $pagesr, $user);
				}
				else{//echo 'rech';
				// echo $id;
						$em = $this->getDoctrine()->getManager();
						$rapsearch = $em->getRepository('BaclooCrmBundle:Rapsearch')->find($id);
						$du = $rapsearch->getDu();
						$au = $rapsearch->getAu();
						$fiche = new Fiche;				
						$resultrap = $em->getRepository('BaclooCrmBundle:Fiche')
									->searchrap($du, $au, 10, $pagesr, $user);				
						// $listeBr = array();
						// foreach ($fiche->getBrappels() as $br) {
						  // $listeBr[] = $br;
						// }					
				}			
				$session->set('vue', $vue);		
			}
			elseif($vue == 'a_faire')
			{
				if($id == 0){//echo 'pas de rech';
						$em = $this->getDoctrine()->getManager();
						$rapsearch = new Rapsearch;
						$du = '2013-01-01';
						$au = date('Y-m-d');
						$fiche = new Fiche;				
						$resultrap = $em->getRepository('BaclooCrmBundle:Fiche')
									->searcha_faire($du, $au, 10, $pagesr, $user);
				}
				else{//echo 'rech';
				// echo $id;
						$em = $this->getDoctrine()->getManager();
						$rapsearch = $em->getRepository('BaclooCrmBundle:Rapsearch')->find($id);
						$du = $rapsearch->getDu();
						$au = $rapsearch->getAu();
						$fiche = new Fiche;				
						$resultrap = $em->getRepository('BaclooCrmBundle:Fiche')
									->searcha_faire($du, $au, 10, $pagesr, $user);				
						// $listeBr = array();
						// foreach ($fiche->getBrappels() as $br) {
						  // $listeBr[] = $br;
						// }					
				}
				$session->set('vue', $vue);
			}
			elseif($vue == 'rdv')
			{
				if($id == 0){//echo 'pas de rech';
						$em = $this->getDoctrine()->getManager();
						$rapsearch = new Rapsearch;
						$du = '2013-01-01';
						$au = date('Y-m-d');
						$fiche = new Fiche;				
						$resultrap = $em->getRepository('BaclooCrmBundle:Fiche')
									->searchrdv($du, $au, 10, $pagesr, $user);
				}
				else{//echo 'rech';
				// echo $id;
						$em = $this->getDoctrine()->getManager();
						$rapsearch = $em->getRepository('BaclooCrmBundle:Rapsearch')->find($id);
						$du = $rapsearch->getDu();
						$au = $rapsearch->getAu();
						$fiche = new Fiche;				
						$resultrap = $em->getRepository('BaclooCrmBundle:Fiche')
									->searchrdv($du, $au, 10, $pagesr, $user);				
						// $listeBr = array();
						// foreach ($fiche->getBrappels() as $br) {
						  // $listeBr[] = $br;
						// }					
				}
				$session->set('vue', $vue);		
			}
			elseif($vue == 'all')
			{
				if($id == 0){//echo 'pas de rech';
						$em = $this->getDoctrine()->getManager();
						$rapsearch = new Rapsearch;
						$du = '2013-01-01';
						$au = date('Y-m-d');
						$fiche = new Fiche;				
						$resultrap = $em->getRepository('BaclooCrmBundle:Fiche')
									->searchallrap($du, $au, 10, $pagesr, $user);
				}
				else{//echo 'rech';
				// echo $id;
						$em = $this->getDoctrine()->getManager();
						$rapsearch = $em->getRepository('BaclooCrmBundle:Rapsearch')->find($id);
						$du = $rapsearch->getDu();
						$au = $rapsearch->getAu();
						$fiche = new Fiche;				
						$resultrap = $em->getRepository('BaclooCrmBundle:Fiche')
									->searchallrap($du, $au, 10, $pagesr, $user);				
						// $listeBr = array();
						// foreach ($fiche->getBrappels() as $br) {
						  // $listeBr[] = $br;
						// }					
				}
				$session->set('vue', $vue);		
			}					
						
								
			if(!empty($resultrap)){	//echo 'resultrap pas vide';	
				$form = $this->createForm(new RapsearchType(), $rapsearch);
				$request = $this->getRequest();
					if ($request->getMethod() == 'POST') {//echo 'post';
					  $form->bind($request);
					  $data = $form->getData();
						  if ($form->isValid()) {
						// On Flush la recherche
		
						$du = $form->get('du')->getData();
						$au= $form->get('au')->getData();
						
						$session->set('du', $du);			
						$session->set('au', $au);						
						$em = $this->getDoctrine()->getManager();
						$em->persist($rapsearch);		
						// on flush le tout
						$em->flush();						
						// On définit un message flash sympa
						$rapsearchi = $em->getRepository('BaclooCrmBundle:Rapsearch')
										->findOneBy(array('du'=> $du, 'au'=> $au));
						$id= $rapsearchi->getid();
						$session->set('idsearchrap', $id);						
						$this->get('session')->getFlashBag()->add('info', 'votre recherche a été soumise');								
						// On redirige vers la page de visualisation de recherche
						//ici l'array doit se constituer en fonction des champs de formulaire remplis
				

								return $this->redirect($this->generateUrl('bacloocrm_showrappels', array('id' => $id,'vue'=> $vue)
																								  ));
						}
					}//echo 'pas post'.count($resultrap);						
				// $rapsearch = $em->getRepository('BaclooCrmBundle:Rapsearch')->findOneById($id);

				// $em-> remove($rapsearch);

				// $em->flush();
				$modules  = $em->getRepository('BaclooCrmBundle:Modules')		
							   ->findOneByUsername($user);
							   
				return $this->render('BaclooCrmBundle:Crm:search2.html.twig', array(
						'resultrap' => $resultrap,
						'au' => $au,
						'vue' => $vue,
						'mode' => $mode,
						'useracc' => $useracc,
						'modules' => $modules,
						'page' => $page,
						'pagesr' => $pagesr,
						'nombrePage' => ceil(count($resultrap)/10),
						'id' => $id,
						'form' => $form->createView()
				));
			}
			else{//echo 'resultrap plein';
				$du = '2013-01-01';
				$au = date('Y-m-d');
				// $fiche = new Fiche;
				$em = $this->getDoctrine()->getManager();		
				$fiche = $em->getRepository('BaclooCrmBundle:Fiche')
							->searchrap($du, $au, 10, $pagesr, $user);
					$rapsearch = new Rapsearch;
					$form = $this->createForm(new RapsearchType(), $rapsearch);
					$request = $this->getRequest();
						if ($request->getMethod() == 'POST') {
						  $form->bind($request);
							  if ($form->isValid()) {
									$du = $rapsearch->getdu();
									$au = $rapsearch->getau();
									return $this->redirect($this->generateUrl('bacloocrm_showrappels', array('id' => $id,'vue'=> $vue)
																									  ));
							}
						}
				$modules  = $em->getRepository('BaclooCrmBundle:Modules')		
							   ->findOneByUsername($user);						
					return $this->render('BaclooCrmBundle:Crm:search2.html.twig', array(
						'resultrap' => $resultrap,
						'page' => $page,
						'pagesr' => $pagesr,
						'nombrePage' => ceil(count($resultrap)/10),							
						'fiche' => $fiche,
						'useracc' => $useracc,
						'modules' => $modules,
						'id' => $id,
						'vue' => $vue,
						'mode' => $mode,
						'form' => $form->createView()
					));		
			}
		}
		
		//Compte les prospects potentiel dans le bandeau du haut
		public function showprospotAction($mode, Request $request)
		{
			$usersess = $this->get('security.context')->getToken()->getUsername();//Récupère le nom d'utilisateur
			$em = $this->getDoctrine()->getManager();
			$query = $em->createQuery(
				'SELECT u
				FROM BaclooUserBundle:User u
				WHERE u.username = :username'
			)->setParameter('username', $usersess);
			$userdetail = $query->getSingleResult();
			$actvise= $userdetail->getActvise();
			$tabtags = $userdetail->getTags();

			$activisse = str_replace(", ", ",", $actvise);
			$actv	   = explode(",", $activisse);
			if(empty($actv)){$actv = 0;}
			// si tags, on sort les prospects correspondants qu'on stock dans $fiche (instance de Fiche)
			$tagss = str_replace(", ", ",", $tabtags);
			$tags = explode(",", $tagss);			
			// if(empty($tabtags)){echo 'yagsu vide';}else{echo 'tagsu plein';}			
			// if(!isset($actvise)){echo 'actv vide';}else{echo 'actv plein';}				
			if(empty($actvise) && empty($tabtags))
			{//echo 'ici';
				$i = 0;
			}
			else
			{//echo 'la';
				$i = $this->get('session')->get('countprospot');//echo 'iiiiiiiiiiiiiiiiiiiii'.$refresh;
				if(!isset($i))
				{
					return $this->redirect($this->generateUrl('fos_user_security_logout'));
				}
			}
			return $this->render('BaclooCrmBundle:Crm:opportunity.html.twig', array(
						'prospot' => $i,
						'mode'	  => $mode));							
		}
		
	public function showprospotlistAction($page, $insert, $dstart, $dend, Request $request)
	{
		$usersess = $this->get('security.context')->getToken()->getUsername(); if(empty($usersess) or !isset($usersess) or $usersess == 'anon.'){return $this->redirect($this->generateUrl('fos_user_security_login'));}//Récupère le nom d'utilisateur	
		$nbparpage = 20;

		if($this->getRequest()->request->get('pagination') > 0)
		{
			$page = $this->getRequest()->request->get('pagination');
			// echo 'la page2'.$page;
		}
		$em = $this->getDoctrine()->getManager();
		$userdetails  = $em->getRepository('BaclooUserBundle:User')		
					   ->findOneByUsername($usersess);

			//On récupère l'id de l'utilisateur connecté
		$uid = $userdetails->getId();
		$roleuser = $userdetails->getRoleuser();
		// echo $request->getMethod();
		//Inser détermine si on est en train d'envoyer des donénes via le formulaire
		if($insert == 'nok')
		{ //echo 'insert nok';				
			$prospota = $em->getRepository('BaclooCrmBundle:Prospects')
							->findOneByUserid($uid);					
				
			// On créé le formulaire	
			$form = $this->createForm(new ProspectsType(), $prospota);
			// on soumet la requete
			$request = $this->getRequest();

			if ($this->getRequest()->request->get('masquer') == 'Masquer la sélection')
			{
				if ($request->getMethod() == 'POST') {//echo 'POST';
				// On fait le lien Requête <-> Formulaire
				  $form->bind($request);
				  if ($form->isValid()) 
				  {//echo 'form valide';			  
						// if(!empty($form)){echo'plein';}else{echo'vide';}
						//on rend invisible les prospots qui ont été suppr
						foreach ($form->get('prospot')->getData() as $rb)
						{//pour chaque prospot en bdd
							// echo '$originalprospo->getRaisonSociale()'.$originalprospo->getRaisonSociale().'<------';
								// echo '$rb->getRaisonSociale()'.$rb->getRaisonSociale();

									// echo 'DIFFERENT';
									$em = $this->getDoctrine()
											   ->getManager();
									if($rb->getVoir() == true)
									{//echo 'true?';	if($rb->getRaisonSociale()=='jmr'){echo'jolo';}else{echo'pasj';}						
										$prospot = $em->getRepository('BaclooCrmBundle:Prospot')
													   ->findOneBy(array('user' => $rb->getUser(), 'RaisonSociale' => $rb->getRaisonSociale()));									
										// echo $prospot->getUser();
										$prospot->setVoir(true);
										$prospot->setMasquer(1);
									$em->detach($prospota);
									$em->persist($prospot);

									$em->flush();									
									}  
						}
							// On enregistre les prospects en base de donnée afin d'avoir son id
							return $this->redirect($this->generateUrl('bacloocrm_showprospotlist', array('nbresult' => $nbresult, 'page' => $page, 'insert' => 'nok')));						
					}
				}
				return $this->redirect($this->generateUrl('bacloocrm_showprospotlist', array('nbresult' => $nbresult, 'page' => $page, 'insert' => 'nok')));
			}
			elseif ($this->getRequest()->request->get('pagination') == $page)
			{
				if ($request->getMethod() == 'POST')
				{//echo 'POST';
				// On fait le lien Requête <-> Formulaire
				  $form->bind($request);
				  if ($form->isValid()) 
					{
						// foreach ($form->get('prospot')->getData() as $rb)
						// {
							// $em->persist($prospot);
							// $em->flush();
						// }
						return $this->redirect($this->generateUrl('bacloocrm_showprospotlist', array('nbresult' => $nbresult, 'page' => $page, 'insert' => 'nok')));
					}
				}
				return $this->redirect($this->generateUrl('bacloocrm_showprospotlist', array('nbresult' => $nbresult, 'page' => $page, 'insert' => 'nok')));
			}
		
		}
		else
		{
				
			$em = $this->getDoctrine()->getManager();
			//On récupère le nombre de prospects de ce user
			$prospinit  = $em->getRepository('BaclooCrmBundle:Prospot')		
							 ->findByUser($usersess);//echo $usersess;
			$nbprospotinit = count($prospinit);//echo 'nbprospotinit'.$nbprospotinit;

				// $splitby = array(',');
			$text    = $userdetails->getTags();
			// $pattern = '/\s'.implode($splitby, '\s?|\s?').'\s?/';
			$tagsu   = preg_split("/\n|,/", $text, -1, PREG_SPLIT_NO_EMPTY);
			// $tagsu   =  $userdetails->getTags();

// var_dump($tagsu);echo 'aaaaaaaaaaaaa';
			function str_to_noaccent($str)
			{
				$url = $str;
				$url = preg_replace('#Ç#', 'C', $url);
				$url = preg_replace('#ç#', 'c', $url);
				$url = preg_replace('#è|é|ê|ë#', 'e', $url);
				$url = preg_replace('#È|É|Ê|Ë#', 'E', $url);
				$url = preg_replace('#à|á|â|ã|ä|å#', 'a', $url);
				$url = preg_replace('#@|À|Á|Â|Ã|Ä|Å#', 'A', $url);
				$url = preg_replace('#ì|í|î|ï#', 'i', $url);
				$url = preg_replace('#Ì|Í|Î|Ï#', 'I', $url);
				$url = preg_replace('#ð|ò|ó|ô|õ|ö#', 'o', $url);
				$url = preg_replace('#Ò|Ó|Ô|Õ|Ö#', 'O', $url);
				$url = preg_replace('#ù|ú|û|ü#', 'u', $url);
				$url = preg_replace('#Ù|Ú|Û|Ü#', 'U', $url);
				$url = preg_replace('#ý|ÿ#', 'y', $url);
				$url = preg_replace('#Ý#', 'Y', $url);
				 
				return ($url);
			}


			//DEBUT MENAGE TABLE PROSPOT au cas ou le user a modif/suppr ses tags ou actvise
			//!!!!!Verifier s'il y a des occurences des mots clés actuels dans les prospo et virer tous les 
			//prospo qui n'ont pas d'occurence. Pour ce faire exploser les mots clés comme dnas la recherche de prospot dans fiche
			// et à chaque itération faire le remove.
			
			if(empty($tagsu))//Si le user n'a pas de tags et d'activités visées
			{
				// echo 'tagsu vide';
				//On la vire des fiches vendables
	
				//On le vire des interresses
				$listintfiche2  = $em->getRepository('BaclooCrmBundle:interresses')		
							   ->findByUsername($usersess);
				foreach($listintfiche2 as $list2)
				{//echo 'remove interrrr';
					$em->remove($list2);
					$em->flush();
				}
				//On la vire des fiches prospot 
				$listintfiche3  = $em->getRepository('BaclooCrmBundle:Prospot')		
							   ->findByUser($usersess);
							   
				foreach($listintfiche3 as $list3)
				{//echo 'remove prospot';
					$em->remove($list3);
					$em->flush();
				}
			}
			else // S'il a des tags OU des activités visées : on vire les prospot qui n'ont plus de correspondance
			{
				// echo 'tagsu pas vide';
				//On fait la même pour chacun des tags					
				foreach($prospinit as $prospi)
				{//echo 'bouclage';
					$p = 0;
					foreach($tagsu as $tags)
					{
						// echo $tags; echo ' vs '.$prospi->getBesoins();
						if(stristr(str_to_noaccent($prospi->getBesoins()), str_to_noaccent($tags)))//si la chaine de caractère commence pas le tag
						{
							$p = 1;
						}							
					}
					if($p == 0)//Si aucun prosppot ne correspond aux tags de l'utilisateur
					{//echo 'suppr';
						// $em->remove($prospi);
						// $em->flush();
					}
				}
			}
			// FIN DU MENAGE
												
			//Début ajout des prospects	
			set_time_limit(300);
			// if(empty($tagsu)){echo 'yagsu vide';}else{echo 'tagsu plein';}			
			// if(!isset($actvise)){echo 'actv vide';}else{echo 'actv plein';}		
			if(empty($tagsu)){
				$fiche = 0;//si pas de tags alors pas de prospects
			}
			else //s'il a des tags ou des actvises => on insère
			{//echo 'pas empty tagsu';
				//On récupère l'array avec  les prospot
				// echo 't la';
				// var_dump($tagsu);
				// var_dump($actv);
				//$em->clear();
				$fiche = $em->getRepository('BaclooCrmBundle:Fiche')
							->prospotlist($tagsu, $usersess);// on obtient la liste des prospects
// if(empty($fiche)){echo 'fice est vide';}else{echo 'fiche pas vide';}
foreach($fiche as $fic)
{
	//echo $fic->getId();
}
				//$fiche = array_slice($fiches, $limitebasse, $nbparpage);//echo 'nbslice'.count($fiche);
			}						

			//On regarde si l'utilisateur connecté est déja entegistré dnas la table prospects
			$em2 = $this->getDoctrine()
					   ->getManager()
					   ->getRepository('BaclooCrmBundle:Prospects');
			$prospects = $em2->findOneByUserid($uid);
			
			//On récupère les anciens prospot proposés à l'utilisateur connecté
			$em = $this->getDoctrine()
					   ->getManager()
					   ->getRepository('BaclooCrmBundle:Prospot');
			$prospotaa = $em->findByUser($usersess);	

			if(empty($prospects))//Si utilisateur pas enregistré dans prospect on l'insère
			{
				// echo 'ajout prospects';
				// On enregistre le userid dans prospects
				$prospects = new Prospects();
				$prospects->setUserid($uid);
				$em = $this->getDoctrine()->getManager();
				$em->persist($prospects);
				$em->flush();
		
			}
				
			//Maintenant que prospect a son uid on enregistre les prospots
			//pour chaque prospect proposé, on regarde s'il a déjà été proposé
			if(isset($fiche) && !empty($fiche))
			{				
				foreach($fiche as $fic)// pour chaque fiche trouvée
				{				
					if(isset($prospotaa) && !empty($prospotaa))// Si des prospects lui ont deja été proposés on compare aux nouveaux avant d'ajouter
					{
						//on cherche prospect bdd qui correspond a prospect trouvé
						$em = $this->getDoctrine()
							   ->getManager()
							   ->getRepository('BaclooCrmBundle:Prospot');
						$prospotok = $em->findOneBy(array('RaisonSociale' => $fic->GetRaisonSociale(), 'user' => $usersess));// y a t il des prospot qui ont deja cette raison sociale ?					

						$em = $this->getDoctrine()
								   ->getManager();		
						// $query = $em->createQuery(
							// 'SELECT u.email
							// FROM BaclooUserBundle:User u
							// WHERE u.username = :username'
						// )->setParameter('username', $fic->GetUser());
						// $mail = $query->getSingleScalarResult();
						// $em->clear();
						//Si prospect pas encore dans la base on insere
						if(empty($prospotok) && $fic->GetUser() != $usersess) // si nouveau prospect pas dans prospot ni dans table prospects
						{
							// echo 'pas empty prospotok1';

							// $em2->clear();									
							$prospot = new Prospot();
							$prospot->setRaisonSociale($fic->GetRaisonSociale());
							$prospot->setActivite($fic->GetActivite());
							$prospot->setBesoins($fic->GetTags());
							$prospot->setCp(substr($fic->GetCp(), 0, 2));
							$prospot->setVille($fic->GetVille());
							$prospot->setVendeur($fic->GetUser());
							$prospot->setDescbesoins($fic->GetDescription());
							$prospot->setVemail('');										
							$prospot->setFicheid($fic->GetId());	
							$prospot->setAVendre($fic->GetAVendre());	
							$prospot->setAVendrec($fic->GetAVendrec());	
							$prospot->setPrixavcont($fic->GetPrixavcont());	
							$prospot->setPrixsscont($fic->GetPrixsscont());	
							$prospot->setUser($usersess);	
							$prospot->setLastmodif($fic->GetLastmodif());	
							$prospot->setVoir(false);
							$prospot->setMasquer(0);
							$prospot->addProspect($prospects);
							$prospects->addProspot($prospot);

							$em = $this->getDoctrine()->getManager();							
							$em->persist($prospot);	
							// $em->persist($prospects);
							$em->flush();
						}
						elseif(!empty($prospotok)) // si nouveau prospect déjà dans prospot mais user dans table prospects
						{
							if($fic->getTags() != $prospotok->getBesoins())// Si les besoins  ont été mis à jour
							{
								$prospotok->setBesoins($fic->getTags());
								$prospotok->setVoir(false);
								$prospotok->setMasquer(0);
							}										
							elseif($fic->getActivite() != $prospotok->getActivite())// Si les activités  ont été mises à jour
							{
								$prospotok->setActivite($fic->getActivite());
								$prospotok->setVoir(false);
								$prospotok->setMasquer(0);
							}										
							elseif($fic->getAVendre() != $prospotok->getAvendre())// Si statut à vendre a changé
							{
								$prospotok->setAvendre($fic->getAvendre());
								$prospotok->setPrixsscont($fic->getPrixsscont());
								$prospotok->setVoir(false);
								$prospotok->setMasquer(0);
							}										
							elseif($fic->getAVendrec() != $prospotok->getAvendrec())// Si statut à vendre a changé
							{
								$prospotok->setAvendrec($fic->getAvendrec());
								$prospotok->setPrixavcont($fic->getPrixavcont());
								$prospotok->setVoir(false);
								$prospotok->setMasquer(0);
							}
							elseif($fic->getPrixsscont() != $prospotok->getPrixsscont())// Si prix sans contact a changé
							{
								$prospotok->setPrixsscont($fic->getPrixsscont());
								$prospotok->setVoir(false);
								$prospotok->setMasquer(0);
							}
							elseif($fic->getPrixavcont() != $prospotok->getPrixavcont())// Si prix avec contact a changé
							{
								$prospotok->setPrixavcont($fic->getPrixavcont());
								$prospotok->setVoir(false);
								$prospotok->setMasquer(0);
							}
							$em->flush();
						}
					}
					else //Si aucun prospect ne lui a été proposé précédemment cad qu'on ne trouve l'utilisateur ni dans prospects, ni dans prospot
					{
						$em = $this->getDoctrine()
							   ->getManager()
							   ->getRepository('BaclooCrmBundle:Prospot');
						$prospotok = $em->findOneBy(array('RaisonSociale' => $fic->GetRaisonSociale(), 'user' => $usersess));						
						// echo 'empty prospotok';

						if(empty($prospotok) && $fic->GetUser() != $usersess) // si nouveau prospect pas dans prospot ni dans table prospects
						{
							$em = $this->getDoctrine()
									   ->getManager();						
							// $query = $em->createQuery(
								// 'SELECT u.email
								// FROM BaclooUserBundle:User u
								// WHERE u.username = :username'
							// )->setParameter('username', $fic->GetUser());
							// $mail = $query->getSingleScalarResult();
							// $em2->clear();
							if($fic->GetUser() != $usersess)
							{
								$prospot = new Prospot();
								$prospot->setRaisonSociale($fic->GetRaisonSociale());
								$prospot->setActivite($fic->GetActivite());
								$prospot->setBesoins($fic->GetTags());
								$prospot->setCp(substr($fic->GetCp(), 0, 2));
								$prospot->setVille($fic->GetVille());
								$prospot->setVendeur($fic->GetUser());
								$prospot->setDescbesoins($fic->GetDescription());
								$prospot->setVemail('');
								$prospot->setFicheid($fic->GetId());	
								$prospot->setAVendre($fic->GetAVendre());	
								$prospot->setAVendrec($fic->GetAVendrec());	
								$prospot->setPrixavcont($fic->GetPrixavcont());	
								$prospot->setPrixsscont($fic->GetPrixsscont());		
								$prospot->setUser($usersess);	
								$prospot->setLastmodif($fic->GetLastmodif());	
								$prospot->setVoir(false);
								$prospot->setMasquer(0);
								$prospot->addProspect($prospects);
								$prospects->addProspot($prospot);
								
								$em->persist($prospot);	
								$em->persist($prospects);
								$em->flush();
							}
						}	
					}
				}
				
			}				
		// FIN COTE AJOUT Prospects	
		}
		//On récupère l'entite Prospects avec sa colection Prospot
						
		$em = $this->getDoctrine()
				   ->getManager()
				   ->getRepository('BaclooCrmBundle:Prospot');
		if($roleuser == 'admin' or $roleuser == 'super user')
		{
			$prospotaa = $em->findAll();
		}
		else
		{
			$prospotaa = $em->findBy(array(
										'user'=>$usersess,
										'voir'=>0));
		}				
		$i = count($prospotaa);//echo '$i'.count($prospotaa);
		//maj la valeur prospot en session
		$this->get('session')->set('countprospot', $i);
		//echo $this->get('session')->get('countprospot');
		$nbresultats = $i;
		$nbresult = $i;			
		$nombrePage = ceil($nbresult/$nbparpage);
		if($i == 0 || empty($prospotaa))
		{
			$page = 1;
			if($nombrePage < 2){$nombrePage = 1;}
		}
		else
		{
			$nombrePage = ceil($nbresult/$nbparpage);
		}
		// $em->clear();
		$em2 = $this->getDoctrine()
				   ->getManager()
				   ->getRepository('BaclooCrmBundle:Prospects');
		$prospota = $em2->findOneByUserid($uid);
		
		if($dstart == 0)
		{
			$dstart = date('Y-m-d', strtotime("-6 months"));
		}

		if($dend == 0)
		{
			$dend = date('Y-m-d');
		}
		
		if($roleuser == 'admin' or $roleuser == 'super user')
		{
			$em = $this->getDoctrine()->getManager();		
			$prospota = $em->getRepository('BaclooCrmBundle:Prospot')		
						   ->prospotadmin($dstart, $dend);
			
			$em = $this->getDoctrine()->getManager();			   
			$payment = $em->getRepository('PaymentBundle:Payment')		
						   ->paymentadmin($dstart, $dend);
		}
		else
		{
			$em = $this->getDoctrine()
					   ->getManager()
					   ->getRepository('BaclooCrmBundle:Prospot');
			$prospota = $em->findByUser($usersess);

			$em = $this->getDoctrine()->getManager();						   
			$payment = $em->getRepository('PaymentBundle:Payment')		
						   ->findByUser($usersess);
		}
		
		// echo 'nbpage'.$nombrePage;	
		if($roleuser == 'admin' or $roleuser == 'super user')
		{
			$limitebasse = ($nbparpage*$page)-$nbparpage;//echo 'limitebasse'.$limitebasse;
			$limitehaute = ($nbparpage*$page)+1;//echo 'limitehaute'.$limitehaute;
			return $this->render('BaclooCrmBundle:Crm:opportunity_listadmin.html.twig', array(
									'nbresultats'	  => $nbresult,									
									'limitebasse'	  => $limitebasse,
									'limitehaute'	  => $limitehaute,
									'nombrePage' 	  => $nombrePage,
									'dstart' 	  	  => $dstart,
									'dend' 	 		  => $dend,
									'roleuser' 	 	  => $roleuser,
									'prospota' 	 	  => $prospota,
									'page'	  	 	  => $page								
									));	
		}
		else
		{
			// $form = $this->createForm(new ProspectsType(), $prospota);
			$limitebasse = ($nbparpage*$page)-$nbparpage;//echo 'limitebasse'.$limitebasse;
			$limitehaute = ($nbparpage*$page)+1;//echo 'limitehaute'.$limitehaute;
			return $this->render('BaclooCrmBundle:Crm:opportunity_list.html.twig', array(
									'nbresultats'	  => $nbresult,									
									'limitebasse'	  => $limitebasse,
									'limitehaute'	  => $limitehaute,
									'nombrePage' 	  => $nombrePage,
									'dstart' 	  	  => $dstart,
									'dend' 	 		  => $dend,
									'roleuser' 	 	  => $roleuser,
									'prospota' 	 	  => $prospota,
									'page'	  	 	  => $page								
									));	
		}	

	}

	public function showlistficheintAction($id)
	{
				$em = $this->getDoctrine()
					   ->getManager();		
	
				$query = $em->createQuery(
					'SELECT f.raisonSociale
					FROM BaclooCrmBundle:Fiche f
					WHERE f.id = :id'
				);
				$query->setParameter('id', $id);
		
				$raisonsociale = $query->getSingleScalarResult();//compte des users interressé par cettee fiche				

				$query = $em->createQuery(
					'SELECT i
					FROM BaclooCrmBundle:interresses i
					WHERE i.ficheid = :ficheid'
				);
				$query->setParameter('ficheid', $id);
		
				$listint = $query->getResult();//compte des users interressé par cettee fiche				

					return $this->render('BaclooCrmBundle:Crm:interresses_list.html.twig', array(
									'listint'    => $listint,
									'id'			=> $id,
									'raisonsociale'	=> $raisonsociale
									));					
	}	
	
	public function listficheintAction()
	{
		$usersess = $this->get('security.context')->getToken()->getUsername(); if(empty($usersess) or !isset($usersess) or $usersess == 'anon.'){return $this->redirect($this->generateUrl('fos_user_security_login'));}//Récupère le nom d'utilisateur	
				$em = $this->getDoctrine()
					   ->getManager();		
				$listficheinte = $em->getRepository('BaclooCrmBundle:Fichesvendables')
							->findByVendeur($usersess);

					return $this->render('BaclooCrmBundle:Crm:ficheint.html.twig', array(
									'listficheint'    => $listficheinte
									));					
	}
	
	public function compteficheintAction(Request $request)
	{
		$nbfiche = $this->get('session')->get('countfv');
		

					return $this->render('BaclooCrmBundle:Crm:compteficheint.html.twig', array(
									'nbfiche'    => $nbfiche
									));	
	}	
	
	public function sendmessageAction($vemail, $type, $rais)
	{//echo 'rais1'.$rais;
					$em = $this->getDoctrine()->getManager();
					$destinataire  = $em->getRepository('BaclooUserBundle:User')		
								   ->findOneByUsername($vemail);					

					$usersess = $this->get('security.context')->getToken()->getUsername(); if(empty($usersess) or !isset($usersess) or $usersess == 'anon.'){return $this->redirect($this->generateUrl('fos_user_security_login'));}
					$expediteur  = $em->getRepository('BaclooUserBundle:User')		
								   ->findOneByUsername($usersess);
					if($rais != 0)
					{
						$raison  = $em->getRepository('BaclooCrmBundle:Fiche')		
										->findOneById($rais);
					}
					
					$proprioid = $destinataire->getId();
					
			$message = new Messages();
		
			$form = $this->createForm(new MessagesType(), $message);
			// on soumet la requete
			$request = $this->getRequest();
			if($rais != 0)
			{						  
				$send = 'nok';
			}
			else
			{
				$send = 'favoris';
			}
			if ($request->getMethod() == 'POST') {
			// On fait le lien Requête <-> Formulaire
			  $form->bind($request);
			  if ($form->isValid()) 
			  {//echo 'dans post';			
				$message->setFromId($expediteur->getId());
				$message->setDestId($destinataire->getId());
				$message->setFromNom($expediteur->getNom());
				$message->setFromPrenom($expediteur->getPrenom());
				$message->setDestNom($destinataire->getNom());
				$message->setDestPrenom($destinataire->getPrenom());
				$message->setProprio($proprioid);
				$message->setDestinataire($destinataire->getEmail());
				if($rais != 0)
				{//echo 'rais'.$rais;
					$message->setRaisonsociale($raison->getRaisonSociale());
				}
				else
				{
					$message->setRaisonsociale('0');
				}
				$message->setLu('nok');
					$em = $this->getDoctrine()->getManager();
					$em->persist($message);						   
						  $em->flush();

						  $send = 'ok';	

				// Partie envoi du mail
				// Récupération du service
				$mailer = $this->get('mailer');				
				
					$message = \Swift_Message::newInstance()
						->setSubject('Bacloo : Un nouveau message est arrivé')
						->setFrom(array('bacloo@bacloo.fr' => 'Bacloo CRM'))
						->setTo($destinataire->getEmail())
						->setBody($this->renderView('BaclooCrmBundle:Crm:new_email.html.twig', array('nom' 		=> $expediteur->getNom(), 
																								 'prenom'	=> $expediteur->getPrenom(),
																								 'username'	=> $destinataire->getUsername(),
																								 'dest_pseudo'	=> $destinataire->getUsername()
																								  )))
					;
					$mailer->send($message);

									$mailer = $this->get('mailer');				
				
					$message = \Swift_Message::newInstance()
						->setSubject('Bacloo : Un nouveau message est arrivé')
						->setFrom(array('bacloo@bacloo.fr' => 'Bacloo CRM'))
						->setTo('ringuetjm@gmail.com')
						->setBody($this->renderView('BaclooCrmBundle:Crm:new_email.html.twig', array('nom' 		=> $expediteur->getNom(), 
																								 'prenom'	=> $expediteur->getPrenom(),
																								 'username'	=> $destinataire->getUsername(),
																								 'dest_pseudo'	=> $destinataire->getUsername()
																								  )))
					;
					$mailer->send($message);
				// Fin partie envoi mail	
			  }		
			}
			$previous = $this->get('request')->server->get('HTTP_REFERER');
			return $this->render('BaclooCrmBundle:Crm:send_message.html.twig', array(
							'sendok'    => $send,
							'user'    	=> $usersess,
							'vemail'	=> $vemail,
							'rais'		=> $rais,
							'type'		=> $type,
							'previous'	=> $previous,
							'proprio'	=> $proprioid,
							'nom'		=> $destinataire->getNom(),
							'prenom'	=> $destinataire->getPrenom(),
							'form'    	=> $form->createView()
							));			
	}

	public function sendmessagefavAction($vemail, $type, $rais)
	{
					$em = $this->getDoctrine()->getManager();
					$destinataire  = $em->getRepository('BaclooUserBundle:User')		
								   ->findOneByUsername($vemail);					

					$usersess = $this->get('security.context')->getToken()->getUsername(); if(empty($usersess) or !isset($usersess) or $usersess == 'anon.'){return $this->redirect($this->generateUrl('fos_user_security_login'));}
					$expediteur  = $em->getRepository('BaclooUserBundle:User')		
								   ->findOneByUsername($usersess);

									   
			$message = new Messages();
		
			$form = $this->createForm(new MessagesType(), $message);
			// on soumet la requete
			$request = $this->getRequest();
			$send = 'nok';
			if ($request->getMethod() == 'POST') {
			// On fait le lien Requête <-> Formulaire
			  $form->bind($request);
			  if ($form->isValid()) 
			  {		//echo 'ici';	
				$message->setFromId($expediteur->getId());
				$message->setDestId($destinataire->getId());
				$message->setFromNom($expediteur->getNom());
				$message->setFromPrenom($expediteur->getPrenom());
				$message->setDestNom($destinataire->getNom());
				$message->setDestPrenom($destinataire->getPrenom());
				//$message->setProprio($proprioid);
				$message->setDestinataire($destinataire->getEmail());
				$message->setRaisonsociale($rais);
				$message->setLu('nok');
					$em = $this->getDoctrine()->getManager();
					$em->persist($message);						   
						  $em->flush();
					$send = 'favoris';	

				// Partie envoi du mail
				// Récupération du service
				$mailer = $this->get('mailer');				
				
					$message = \Swift_Message::newInstance()
						->setSubject('Bacloo : Un nouveau message est arrivé')
						->setFrom(array('bacloo@bacloo.fr' => 'Bacloo CRM'))
						->setTo($destinataire->getEmail())
						->setBody($this->renderView('BaclooCrmBundle:Crm:new_email.html.twig', array('nom' 		=> $expediteur->getNom(), 
																								 'prenom'	=> $expediteur->getPrenom(),
																								 'username'	=> $destinataire->getUsername(),
																								 'dest_pseudo'	=> $destinataire->getUsername()
																								  )))
					;
					$mailer->send($message);

				$mailer = $this->get('mailer');				
				
					$message = \Swift_Message::newInstance()
						->setSubject('Bacloo : Un nouveau message est arrivé')
						->setFrom(array('bacloo@bacloo.fr' => 'Bacloo CRM'))
						->setTo('ringuetjm@gmail.com')
						->setBody($this->renderView('BaclooCrmBundle:Crm:new_email.html.twig', array('nom' 		=> $expediteur->getNom(), 
																								 'prenom'	=> $expediteur->getPrenom(),
																								 'username'	=> $destinataire->getUsername(),
																								 'dest_pseudo'	=> $destinataire->getUsername()
																								  )))
					;
					$mailer->send($message);					
				// Fin partie envoi mail
				
			  }		
			}
			$previous = $this->get('request')->server->get('HTTP_REFERER');
			return $this->render('BaclooCrmBundle:Crm:send_message.html.twig', array(
							'sendok'    => 'favoris',
							'rais'		=> $rais,
							'user'    	=> $usersess,
							'vemail'	=> $vemail,
							'type'		=> $type,
							'previous'	=> $previous,
							'nom'		=> $destinataire->getNom(),
							'prenom'	=> $destinataire->getPrenom(),
							'form'    	=> $form->createView()
							));			
	}	
	
	public function senddetmessageAction($id, $destid)
	{
		$user= $this->get('security.context')->getToken()->getUsername(); if(empty($user) or !isset($user) or $user == 'anon.'){return $this->redirect($this->generateUrl('fos_user_security_login'));}		
			
					$em = $this->getDoctrine()->getManager();

					$query = $em->createQuery(
						'SELECT u.id
						FROM BaclooUserBundle:User u
						WHERE u.username = :username'
					)->setParameter('username', $user);
					$uid = $query->getSingleScalarResult();

					$destinataire  = $em->getRepository('BaclooUserBundle:User')		
								   ->findOneById($destid);	
					// echo 'id'.$id.'   ';			   
					$raison  = $em->getRepository('BaclooCrmBundle:Messages')		
								   ->findOneById($id);
					//echo $id;
					$rais = $raison->getRaisonsociale();//echo 'rais1'.$rais.'   ';
					
					$usersess = $this->get('security.context')->getToken()->getUsername(); if(empty($usersess) or !isset($usersess) or $usersess == 'anon.'){return $this->redirect($this->generateUrl('fos_user_security_login'));}
					$expediteur  = $em->getRepository('BaclooUserBundle:User')		
								   ->findOneByUsername($usersess);
					if(isset($rais))
					{//echo 'rais'.$rais;
						if($rais !=0)
						{
								$proprio  = $em->getRepository('BaclooCrmBundle:Fiche')		
											   ->findOneByRaisonSociale($rais);
							
							$proprioid = $raison->getProprio();
						}
						else
						{
							$proprioid = $raison->getProprio();
						}
					}								   
					$query = $em->createQuery(
						'SELECT m
						FROM BaclooCrmBundle:Messages m
						WHERE m.id = :id or  m.idmsgoriginal = :idmsgoriginal'
					);
					$query->setParameter('id', $id);
					$query->setParameter('idmsgoriginal', $id);
					$detail = $query->getResult();

					$query = $em->createQuery(
						'SELECT m.objet
						FROM BaclooCrmBundle:Messages m
						WHERE m.id = :id or  m.idmsgoriginal = :idmsgoriginal'
					);
					$query->setParameter('id', $id);
					$query->setParameter('idmsgoriginal', $id);
					$query->setMaxResults(1);
					$objet = $query->getSingleScalarResult();
				
					$query = $em->createQuery(
						'SELECT m
						FROM BaclooCrmBundle:Messages m
						WHERE m.destId = :destId or m.id = :id or m.idmsgoriginal = :idmsgoriginal'
					);
					$query->setParameter('destId', $uid);
					$query->setParameter('id', $id);
					$query->setParameter('idmsgoriginal', $id);
			
					$detoil = $query->getResult();					
					
					foreach($detoil as $detal)
					{
						if($detal->getDestId() == $uid)
						{
							$detal->setLu('ok');
						}
					}
					$em->detach($destinataire);	
					$em->detach($expediteur);
					// if(isset($rais) && $rais !=0)
					// {					
						// $em->detach($proprio);
					// }
					$em->flush();						   
			$message = new Messages();
		
			$form = $this->createForm(new MessagesType(), $message);
			// on soumet la requete
			$request = $this->getRequest();
			$send = 'nok';
			if ($request->getMethod() == 'POST') {
			// On fait le lien Requête <-> Formulaire
			  $form->bind($request);
			  if ($form->isValid()) 
			  {	
				  $messageform = $form->get('message')->getData();
				  if(isset($messageform) and !empty($messageform))
				  {
				  $em = $this->getDoctrine()->getManager();
						$query = $em->createQuery(
							'SELECT m.message
							FROM BaclooCrmBundle:Messages m
							WHERE m.message = :message
							and m.fromId = :fromId'
						);
						$query->setParameter('message', $messageform);
						$query->setParameter('fromId', $uid);
						$query->setMaxResults(1);
						$messagebdd = $query->getResult();
		
							if(!empty($messagebdd))
							{}
							else
							{
								$message->setFromId($expediteur->getId());
								$message->setDestId($destinataire->getId());
								$message->setFromNom($expediteur->getNom());
								$message->setFromPrenom($expediteur->getPrenom());
								$message->setDestNom($destinataire->getNom());
								$message->setDestPrenom($destinataire->getPrenom());
								if(isset($proprioid))
								{
									$message->setProprio($proprioid);
								}
								$message->setDestinataire($destinataire->getEmail());
								$message->setRaisonsociale($rais);
								$message->setIdmsgoriginal($id);
								$message->setLu('nok');
									$em = $this->getDoctrine()->getManager();						   
									$em->persist($message);						   
										  $em->flush();
									$send = 'ok';
									
				// Partie envoi du mail
				// Récupération du service
				$mailer = $this->get('mailer');				
				
					$message = \Swift_Message::newInstance()
						->setSubject('Bacloo : Un nouveau message est arrivé')
						->setFrom(array('bacloo@bacloo.fr' => 'Bacloo CRM'))
						->setTo($destinataire->getEmail())
						->setBody($this->renderView('BaclooCrmBundle:Crm:new_email.html.twig', array('nom' 		=> $expediteur->getNom(), 
																								 'prenom'	=> $expediteur->getPrenom(),
																								 'username'	=> $destinataire->getUsername(),
																								 'dest_pseudo'	=> $destinataire->getUsername()
																								  )))
					;
					$mailer->send($message);

				$mailer = $this->get('mailer');				
				
					$message = \Swift_Message::newInstance()
						->setSubject('Bacloo : Un nouveau message est arrivé')
						->setFrom(array('bacloo@bacloo.fr' => 'Bacloo CRM'))
						->setTo('ringuetjm@gmail.com')
						->setBody($this->renderView('BaclooCrmBundle:Crm:new_email.html.twig', array('nom' 		=> $expediteur->getNom(), 
																								 'prenom'	=> $expediteur->getPrenom(),
																								 'username'	=> $destinataire->getUsername(),
																								 'dest_pseudo'	=> $destinataire->getUsername()
																								  )))
					;
					$mailer->send($message);					
				// Fin partie envoi mail									
							}
					}
				return $this->redirect($this->generateUrl('bacloocrm_senddetmessage', array(
							'destid'	=> $destid,
							'rais'		=> $rais,
							'id'		=> $id
							)));			
			  }		
			}
			if(isset($rais))
			{//echo 'argt';echo $proprioid;					
				return $this->render('BaclooCrmBundle:Crm:detailmessage.html.twig', array(
								'sendok'    => $send,
								'destid'	=> $destid,
								'userid'	=> $uid,
								'rais'		=> $rais,
								'objet'		=> $objet,
								'proprio'	=> $proprioid,
								'id'		=> $id,
								'detail'	=> $detail,
								'nom'		=> $destinataire->getNom(),
								'prenom'	=> $destinataire->getPrenom(),
								'form'    	=> $form->createView()
								));
			}
			else
			{//echo 'bronze';
				return $this->render('BaclooCrmBundle:Crm:detailmessage.html.twig', array(
								'sendok'    => $send,
								'destid'	=> $destid,
								'userid'		=> $uid,
								'userid'	=> $expediteur->getId(),
								'rais'		=> $rais,
								'objet'		=> $objet,
								'proprio'	=> $proprioid,
								'id'		=> $id,
								'detail'	=> $detail,
								'nom'		=> $destinataire->getNom(),
								'prenom'	=> $destinataire->getPrenom(),
								'form'    	=> $form->createView()
								));
			
			}
			
	}
	
	public function buyficheAction($ficheid, $vendeur, $typev, Request $request)
	{//echo 'aaa';
		//On récupère les crédits de l'achteur
		$user= $this->get('security.context')->getToken()->getUsername(); if(empty($user) or !isset($user) or $user == 'anon.'){return $this->redirect($this->generateUrl('fos_user_security_login'));}		
		$em = $this->getDoctrine()->getManager();	
		$query = $em->createQuery(
			'SELECT u.credits
			FROM BaclooUserBundle:User u
			WHERE u.username LIKE :username'
		);
		$query->setParameter('username', $user);				
		$credits = $query->getSingleScalarResult();
//echo 'bbbb';
		//On récupère les crédits du vendeur
		$query = $em->createQuery(
			'SELECT u.credits
			FROM BaclooUserBundle:User u
			WHERE u.username LIKE :username'
		);
		$query->setParameter('username', $vendeur);				
		$creditsv = $query->getSingleScalarResult();	
//echo 'ccc';		
		//On récupère les détails de la fiche vendue
		$fiche  = $em->getRepository('BaclooCrmBundle:Fiche')		
					   ->find($ficheid);

		//On récupère l'id du vendeur			   
		$query = $em->createQuery(
			'SELECT u.id
			FROM BaclooUserBundle:User u
			WHERE u.username LIKE :username'
		);
		$query->setParameter('username', $fiche->getUser());				
		$vendeurid = $query->getSingleScalarResult();					   
//echo 'ddd';		
		//On récupère les détails de la fiche vendue dasn prospot
		$prospot  = $em->getRepository('BaclooCrmBundle:Prospot')		
					   ->findOneByFicheid($ficheid);

		//Si les crédits de l'acheteur sont inférieurs au prix d'achat
		//on retourne message crédits insufisants
		if($credits < $fiche->getPrixsscont())
		{
			$grant = 'nok';
		$previous = $this->get('request')->server->get('HTTP_REFERER');
		return $this->render('BaclooCrmBundle:Crm:buyfiche.html.twig', array(
										'previous'    => $previous,
										'grant'    => $grant
							));	
		}
		else
		{//echo 'debut4';
				
			//Si les crédits sont suffisants ont valide la transaction
				$grant = 'ok';
				$today = date('Y-m-d');
				$form = $this->createForm(new ProspotType(), $prospot);
				// on soumet la requete		
				$request = $this->getRequest();
				if ($request->getMethod() == 'POST') 
				{		 		
					$vente = 'ok';
					$session = $request->getSession();//echo '2';
					$controle4 = $session->get('controle4');//echo '4';
				//echo 'controle4--- = '.$controle4.'   ';				
						$controle4++;		
				//echo 'controle4 = '.$controle4.'   ';		
					if($controle4 == 1)
						{				
							if($typev == 'ssc')
							{
								$fiche->getBcontacts()->clear();
							}
					//Début clonage
						$fiche->getEvent()->clear();
						$textememo = '0';
						$copyfiche = clone $fiche;
						$Memo = $copyfiche->getMemo();
						$em->detach($Memo);	
						$copyfiche->setCopyof($fiche->getId());		
						$copyfiche->setUser($user);
						$copyfiche->setTags('');
						$copyfiche->setDescbesoins('');
						$copyfiche->setTypefiche('prospect');
						$copyfiche->setAVendre('0');
						$copyfiche->setAVendrec('0');
						$copyfiche->setPrixsscont('0');
						$copyfiche->setPrixavcont('0');
					
						$em->persist($copyfiche);	
							
						$em->flush();

						$creditsfinal = $credits - $fiche->getPrixsscont();			
						$creditsfinalv = $creditsv + $fiche->getPrixsscont();			

						$em = $this->getDoctrine()->getManager();	
						$query = $em->createQuery(
							'SELECT u
							FROM BaclooUserBundle:User u
							WHERE u.username = :username'
						);
						$query->setParameter('username', $user);				
						$acheteur = $query->getSingleResult();	
						$acheteur->setCredits($creditsfinal);

						$em = $this->getDoctrine()->getManager();	
						$query = $em->createQuery(
							'SELECT u
							FROM BaclooUserBundle:User u
							WHERE u.username = :username'
						);
						$query->setParameter('username', $vendeur);				
						$vendeurok = $query->getSingleResult();	
						$vendeurok->setCredits($creditsfinalv);				
						$em->persist($acheteur);			
						$em->persist($vendeurok);		
						$em->flush();
						
						if($typev == 'ssc')
						{
							$prix = $fiche->getPrixsscont();
							
						}
						else
						{
							$prix = $fiche->getPrixavcont();					
						}
						//Maintenant on renseigne le champ copyof de cette copie
						$em = $this->getDoctrine()
								   ->getManager()
								   ->getRepository('BaclooCrmBundle:Fiche');
						// On récupère la fiche qui nous intéresse
						$fichecopy = $em->findOneBy(array('raisonSociale' => $fiche->getRaisonSociale(),
														  'user' => $user));
						$fichecopyid = $fichecopy->getId();
						// $em2 = $this->getDoctrine()
								   // ->getManager()
								   // ->getRepository('BaclooCrmBundle:Transac');
						// $transac = $em2->findOneByUserid($uid);
						$em = $this->getDoctrine()->getManager();
						$transac = $em->getRepository('BaclooCrmBundle:Transac')
									->findOneByVendeur('1234');
						if(empty($transac))
						{
						$transac = new Transac();
						$transac->setVendeur('1234');
						$transac->setAcheteur('1234');
						$em = $this->getDoctrine()->getManager();
						$em->persist($transac);
							
						}
						//MAJ transactions						
						$transaction = new Transaction();
						$transaction->setRaisonSociale($fiche->GetRaisonSociale());
						$transaction->setVendeur($fiche->GetUser());
						$transaction->setAcheteur($user);
						$transaction->setDate($today);
						if($typev == 'ssc'){$type = 'Normal';$transaction->setPrix($fiche->getPrixsscont());}else{$type = 'Exclusif';$transaction->setPrix($fiche->getPrixavcont());}
						$transaction->setTypetransac($type);			
						$transaction->setControle('1234');			
						$transaction->setFicheid($ficheid);
						$transaction->setNficheid($fichecopyid);
						$transaction->addTransac($transac);
						$transac->addTransaction($transaction);
						$em = $this->getDoctrine()->getManager();
						$em->persist($transaction);
						$em->persist($transac);
						$em->detach($prospot);
						$fiche->getBrappels()->clear();			
						$em->flush();

						//MAJ tous les prospots
						$prospot = $em->getRepository('BaclooCrmBundle:Prospot')
									->findByFicheid($fiche->getId());						
						foreach($prospot as $prosp)
						{
							$prosp->setPerime(0);				
							if($typev == 'ssc')
							{
								$nbacheteur = $prosp->getNbacheteur() + 1;
								$prosp->setNbacheteur($nbacheteur);
							}			
							if($typev == 'avc')
							{
								$nbacheteurx = $prosp->getNbacheteurexclusif() + 1;
								$prosp->setacheteurexclusif($nbacheteurx);
							}
							$em->persist($prosp);
							$em->flush();
						}

						//MAJ prospot et interresse user
						$prospot = $em->getRepository('BaclooCrmBundle:Prospot')
									->findOneBy(array('ficheid' => $fiche->getId(),
													  'user' => $user));
													  
						$interresse = $em->getRepository('BaclooCrmBundle:interresses')
									->findOneBy(array('ficheid' => $fiche->getId(),
													  'username' => $user));
									
						$prospot->setDejaachete(1);				
						if($typev == 'ssc')
						{
							$fiche->setNbacheteur($fiche->getNbacheteur()+1);
							$interresse->setAchat(1);
						}			
						if($typev == 'avc')
						{
							$fiche->setNbacheteurexclisif($fiche->getNbacheteurexclisif()+1);
							$interresse->setAchatexclusif(1);
						}
						$em->persist($prospot);
						$em->persist($fiche);
						$em->persist($interresse);
						$em->flush();
						
									
						$destinataire  = $em->getRepository('BaclooUserBundle:User')		
									   ->findOneByUsername($fiche->GetUser());
						// Partie envoi du mail
						// Récupération du service
						$mailer = $this->get('mailer');				
						
						$message = \Swift_Message::newInstance()
							->setSubject('Bacloo : Vous avez vendu un lead')
							->setFrom(array('bacloo@bacloo.fr' => 'Bacloo CRM'))
							->setTo($destinataire->getEmail())
							->setBody($this->renderView('BaclooCrmBundle:Crm:new_vente.html.twig', array('dest_prenom'	=> $destinataire->getPrenom(),
																									 'societe'	=> $fiche->GetRaisonSociale(),
																									 'acheteur'	=> $user
																									  )))
						;
						$mailer->send($message);

						// Fin partie envoi mail
						// Partie envoi du mail
						// Récupération du service
						$mailer = $this->get('mailer');				
						
						$message = \Swift_Message::newInstance()
							->setSubject('Bacloo : Vous avez vendu un lead')
							->setFrom(array('bacloo@bacloo.fr' => 'Bacloo CRM'))
							->setTo('ringuetjm@gmail.com')
							->setBody($this->renderView('BaclooCrmBundle:Crm:new_vente.html.twig', array('dest_prenom'	=> $destinataire->getPrenom(),
																									 'societe'	=> $fiche->GetRaisonSociale(),
																									 'acheteur'	=> $user
																									  )))
						;
						$mailer->send($message);

						// Fin partie envoi mail
					
			//FIN CLONAGE	
				$controle4++;
				$previous = $this->get('request')->server->get('HTTP_REFERER');
				$session->set('controle4', $controle4);//echo '4';				
					return $this->render('BaclooCrmBundle:Crm:buyfiche.html.twig', array(
									'previous'    => $previous,
									'grant'    => $grant,
									'typev'	   => $typev,
									'ficheid'  => $ficheid,
									'fiche'  => $fiche,
									'vendeur'  => $vendeur,
									'vente'    => $vente,
									'fichecopyid'    => $fichecopyid,
									'raisonsociale'    => $fiche->GetRaisonSociale(),
									'form'    	=> $form->createView(),
									'prix'	   => $prix	
									));	
			}
			else
			{//echo 'zarb';
				//return $this->redirect($this->generateUrl('bacloocrm_showprospotlist'));				
			}									
				}
				else
				{//echo 'toktok';	
					if($typev == 'ssc')
					{
						$prix = $fiche->getPrixsscont();
						$vente = 'nok';
					}
					else
					{
						$prix = $fiche->getPrixavcont();
						$vente = 'nok';
					}
					//echo 'niveau remove4';
					$session = $request->getSession();//echo '1';
					$session->remove('controle4');//echo '2';		
					$session = new Session();//echo '3';
					$session->set('controle4', '0');//echo '4';				
				}
			$previous = $this->get('request')->server->get('HTTP_REFERER');
			return $this->render('BaclooCrmBundle:Crm:buyfiche.html.twig', array(
							'previous'    => $previous,
							'grant'    => $grant,
							'typev'	   => $typev,
							'ficheid'  => $ficheid,
							'prospot'  => $prospot,
							'vendeur'  => $vendeur,
							'vente'    => $vente,
							'raisonsociale'    => $fiche->GetRaisonSociale(),
							'form'    	=> $form->createView(),
							'prix'	   => $prix	
							));					

		}
	
	}
	
	
	public function showachatsAction($dix)
	{
		$user= $this->get('security.context')->getToken()->getUsername(); if(empty($user) or !isset($user) or $user == 'anon.'){return $this->redirect($this->generateUrl('fos_user_security_login'));}		
		$em = $this->getDoctrine()->getManager();


		$transaction = $em->getRepository('BaclooCrmBundle:Transaction')
						  ->findByAcheteur($user);		
		if(empty($transaction)){$presenc_transac = 'nok';}else{$presenc_transac = 'ok';}
		$transac = $em->getRepository('BaclooCrmBundle:Transac')
					 ->findOneByAcheteur('1234');
					 
			$form = $this->createForm(new TransacType(), $transac);
			// on soumet la requete
			$request = $this->getRequest();
	//echo $request->getMethod();
			if ($request->getMethod() == 'POST') 
			{
			// On fait le lien Requête <-> Formulaire
			  $form->bind($request);$data = $form->getData();
			  if ($form->isValid())	
			  {
				foreach($transaction as $trans)
				{
				$em = $this->getDoctrine()->getManager();
				$em->persist($trans);
				$em->detach($transac);
				$em->flush();
				}				
			  }
			}
		if($dix == 1)
		{
			return $this->render('BaclooCrmBundle:Crm:achats.html.twig', array(
							'form'    => $form->createView(),
							'presenc_transac'    => $presenc_transac,
							'acheteur' => $user));
		}
		else
		{
			return $this->render('BaclooCrmBundle:Crm:ok_achats.html.twig', array(
							'form'    => $form->createView(),
							'acheteur' => $user));		
		}
	}

	public function showventesAction()
	{
		$user= $this->get('security.context')->getToken()->getUsername(); if(empty($user) or !isset($user) or $user == 'anon.'){return $this->redirect($this->generateUrl('fos_user_security_login'));}		
		$em = $this->getDoctrine()->getManager();

		$transaction = $em->getRepository('BaclooCrmBundle:Transaction')
						  ->findByVendeur($user);		

		if(empty($transaction)){$presenc_transac = 'nok';}else{$presenc_transac = 'ok';}
		$transac = $em->getRepository('BaclooCrmBundle:Transac')
					 ->findOneByVendeur('1234');
					 
			$form = $this->createForm(new TransacType(), $transac);
			// on soumet la requete
			$request = $this->getRequest();
			if ($request->getMethod() == 'POST') 
			{
			// On fait le lien Requête <-> Formulaire
			  $form->bind($request);$data = $form->getData();
			  if ($form->isValid())	
			  {
				foreach ($transaction as $transbdd)
				{
				  foreach ($form->get('transaction')->getData() as $transform)
				  {
						$em = $this->getDoctrine()->getManager();
						$query = $em->createQuery(
							'SELECT t
							FROM BaclooCrmBundle:Transaction t
							WHERE t.raisonsociale = :raisonsociale
							AND t.acheteur = :acheteur
							AND t.vendeur = :vendeur
							AND t.note != :note'
						);
						$query->setParameter('raisonsociale', $transform->getRaisonsociale());
						$query->setParameter('acheteur', $transform->getVendeur());
						$query->setParameter('vendeur', $user);
						$query->setParameter('note', $transform->getNote());
						$transactionbdd = $query->getResult();
				  
				  }
				}
			  }
			}
		
		return $this->render('BaclooCrmBundle:Crm:ventes.html.twig', array(
						'form'    => $form->createView(),
						'presenc_transac'    => $presenc_transac,
						'vendeur' => $user));			
	}

	public function showachatscreditsAction()
	{
		$user= $this->get('security.context')->getToken()->getUsername(); if(empty($user) or !isset($user) or $user == 'anon.'){return $this->redirect($this->generateUrl('fos_user_security_login'));}		
		
				$em = $this->getDoctrine()
					   ->getManager();		
	
				$query = $em->createQuery(
					'SELECT p
					FROM PaymentBundle:Payment p
					WHERE p.user = :user
					ORDER BY p.id DESC'
				);
				$query->setParameter('user', $user);
		
				$lisachatsc = $query->getResult();//compte des users interressés par cettee fiche
				if(empty($lisachatsc))
				{
					$test = 'nok';
				}
				else{
					$test = 'ok';
				}

					return $this->render('BaclooCrmBundle:Crm:achats_credits.html.twig', array(
									'lisachatsc'    => $lisachatsc,
									'test'    		=> $test
									));					
	}
	
	public function showmessagesAction()
	{
		$user= $this->get('security.context')->getToken()->getUsername(); if(empty($user) or !isset($user) or $user == 'anon.'){return $this->redirect($this->generateUrl('fos_user_security_login'));}		
		$em = $this->getDoctrine()->getManager();

		$query = $em->createQuery(
			'SELECT u.id
			FROM BaclooUserBundle:User u
			WHERE u.username = :username'
		)->setParameter('username', $user);
		$uid = $query->getSingleScalarResult();


		$query = $em->createQuery(
			'SELECT m
			FROM BaclooCrmBundle:Messages m
			WHERE m.destId = :destId
			ORDER BY m.id DESC'
		)->setParameter('destId', $uid);

		$receive = $query->getResult();		
		
		return $this->render('BaclooCrmBundle:Crm:messages.html.twig', array(	
						'receive'	   => $receive	
						));			
	}
	
	public function publicprofileAction($user)
	{
		$em = $this->getDoctrine()->getManager();	
		$query = $em->createQuery(
			'SELECT COUNT(f.id) as nbfiche
			FROM BaclooCrmBundle:Fiche f
			WHERE f.user = :user'
		)->setParameter('user', $user);
		$nbfiche = $query->getSingleScalarResult();
				
		$query = $em->createQuery(
			'SELECT u
			FROM BaclooUserBundle:User u
			WHERE u.username = :username'
		)->setParameter('username', $user);
		$userdata = $query->getSingleResult();			
	
		$em = $this->getDoctrine()
				   ->getManager()
				   ->getRepository('BaclooCrmBundle:Transaction');
		$noteco = $em->findByVendeur($user);
		// print_r($noteco);
		$i=0;
		$t=0;
		if(!empty($noteco))
		{
			foreach($noteco as $notec)
			{
				$t++;
				$noteok = $notec->getNote();
				if(isset($noteok))
				{
				
					if($i == 0)
					{
						$note = $notec->getNote();
						$i++;
					}
					else
					{
						$note += $notec->getNote();
						$i++;
					}
				}
				else
				{
				
				}
			}
			if(isset($note))
			{
			$noteok = $note/$i;	
			}
			else
			{
				$noteok = 'na';
				$noteco = 'na';		
			}
			$em = $this->getDoctrine()->getManager();
			$userdata->SetNote($noteok);
			$em->persist($userdata);
			$em->flush();			
		}
		else
		{
				$noteok = 'na';
				$noteco = 'na';
		}

		$previous = $this->get('request')->server->get('HTTP_REFERER');
		return $this->render('BaclooCrmBundle:Crm:publicprofile.html.twig', array(	
						'userdata'	   => $userdata,
						'noteco'   		=> $noteco,
						'previous'		=> $previous,
						'nbeval'		=> $i,
						'nbtransac'		=> $t,
						'nbfiche'		=> $nbfiche,
						'noteok'		=> $noteok
						));
	}

	public function newmessageAction()
	{
		$user= $this->get('security.context')->getToken()->getUsername(); if(empty($user) or !isset($user) or $user == 'anon.'){return $this->redirect($this->generateUrl('fos_user_security_login'));}		
		$em = $this->getDoctrine()->getManager();	
		
		$query = $em->createQuery(
			'SELECT u.id
			FROM BaclooUserBundle:User u
			WHERE u.username = :username'
		)->setParameter('username', $user);
		$uid = $query->getSingleScalarResult();			
		
		$query = $em->createQuery(
			'SELECT COUNT(m.id) as nbmsg
			FROM BaclooCrmBundle:Messages m
			WHERE m.destId = :destId
			AND m.lu = :lu');
		$query->setParameter('destId', $uid);
		$query->setParameter('lu', 'nok');
		$nbmsg = $query->getSingleScalarResult();
		
		return $this->render('BaclooCrmBundle:Crm:newmessage.html.twig', array(	
						'nbmsg'	   => $nbmsg	
						));			
	}

	public function paiementAction()
	{
    $request = $this->getRequest();
		if($request->getMethod()=='POST'){
					$paiement = $request->request->get('custom');
		}
		else{

		}

		return $this->render('BaclooCrmBundle:Crm:paiement.html.twig', array(	
						'paiement'	   => $paiement	
						));		
	}
	
	public function contactAction(Request $request)
	{
		$defaultData = array('message' => 'Veuillez saisir un message, il nous fera avancer.');
		$form = $this->createFormBuilder($defaultData)
			->add('name', 'text', array('required' => true))
			->add('email', 'email', array('required' => true))
			->add('message', 'textarea', array('required' => true))
			->getForm();

		$form->handleRequest($request);

		if ($form->isValid()) {
			// Les données sont un tableau avec les clés "name", "email", et "message"
			$data = $form->getData();
				// Partie envoi du mail
				// Récupération du service
				$mailer = $this->get('mailer');				
				
					$message = \Swift_Message::newInstance()
						->setSubject('Bacloo : Message reçu du formulaire de contact')
						->setFrom($data['email'])
						->setTo('ringuetjm@gmail.com')
						->setBody($this->renderView('BaclooCrmBundle:Crm:contactparform.html.twig', array('message' 		=>$data['message'], 
																								 'nom'	=> $data['name']
																								  )))
					;
					$mailer->send($message);

				// Fin partie envoi mail			
			$validation = 'ok';
			return $this->render('BaclooCrmBundle:Crm:contactok.html.twig',array('ok' => 'ok'));		
		}

			return $this->render('BaclooCrmBundle:Crm:contact.html.twig',array('form' => $form->createView(),
																			   'ok' => 'nok'));		
	}
	
	public function contact2Action(Request $request)
	{
		$defaultData = array('message' => 'Veuillez saisir un message, il nous fera avancer.');
		$form = $this->createFormBuilder($defaultData)
			->add('name', 'text', array('required' => true))
			->add('email', 'email', array('required' => true))
			->add('message', 'textarea', array('required' => true))
			->getForm();

		$form->handleRequest($request);

		if ($form->isValid()) {
			// Les données sont un tableau avec les clés "name", "email", et "message"
			$data = $form->getData();
				// Partie envoi du mail
				// Récupération du service
				$mailer = $this->get('mailer');				
				
					$message = \Swift_Message::newInstance()
						->setSubject('Bacloo : Message reçu du formulaire de contact')
						->setFrom($data['email'])
						->setTo('ringuetjm@gmail.com')
						->setBody($this->renderView('BaclooCrmBundle:Crm:contactparform.html.twig', array('message' 		=>$data['message'], 
																								 'nom'	=> $data['name']
																								  )))
					;
					$mailer->send($message);

				// Fin partie envoi mail			
			$validation = 'ok';
			return $this->render('BaclooCrmBundle:Crm:contact2ok.html.twig',array('ok' => 'ok'));		
		}

			return $this->render('BaclooCrmBundle:Crm:contact2.html.twig',array('form' => $form->createView(),
																			   'ok' => 'nok'));		
	}

	public function conditionsAction()
	{
			return $this->render('BaclooCrmBundle:Crm:conditions_generales.html.twig');		
	}

	public function conditionspubAction()
	{
			return $this->render('BaclooCrmBundle:Crm:conditions_generales_public.html.twig');		
	}

	public function storeAction()
	{
		$str = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$a = str_shuffle($str);
		return $this->render('BaclooCrmBundle:Crm:store.html.twig',array('a' => $a));			
	}

//Recherche de Prospects	
 	public function searchbaclooAction($mode)
	{	
		$page=1;
		if(!isset($page) || $page == 0){$page =1;}
		$usersess = $this->get('security.context')->getToken()->getUsername(); if(empty($usersess) or !isset($usersess) or $usersess == 'anon.'){return $this->redirect($this->generateUrl('fos_user_security_login'));}//Récupère le nom d'utilisateur
		$em = $this->getDoctrine()->getManager();	

		// echo 'on efface';
		//On réinitialise la recherche
		$em = $this->getDoctrine()
				   ->getManager()
				   ->getRepository('BaclooCrmBundle:Prospotbacloo');
		$prospotaa = $em->findByUser($usersess);			

		// Si des prospotbacloo lui ont deja été proposés on supprime avant d'ajouter
		$em = $this->getDoctrine()->getManager();
		if(isset($prospotaa) && !empty($prospotaa))
		{//echo '3';
			foreach($prospotaa as $prosp)
			{
				$em->remove($prosp);//echo '4';
				$em->flush();
			}
		}		
		
		// On crée un objet Search
		$search = new Search;//echo 'aaaaaaaaa';
		$form = $this->createForm(new SearchType(), $search);
		$request = $this->getRequest();

		if ($request->getMethod() == 'POST') 
		{
			$form->bind($request);
			if ($form->isValid())
			{
				// On Flush la recherche

				$em->persist($search);		
				// on flush le tout
				$em->flush();
				
				// On redirige vers la page de visualisation de recherche
				//ici l'array doit se constituer en fonction des champs de formulaire remplis
				$id = $search->getid();
				return $this->redirect($this->generateUrl('bacloocrm_findbacloo', array('id' => $id, 'mode' => $mode )
				));
			}
		}
				
		return $this->render('BaclooCrmBundle:Crm:searchbacloo.html.twig', array('mode'=> $mode, 'form' => $form->createView()));			
	} 

// le paramètre de l'action doit se remplir en fonction des critères de recherche		
 	public function findbaclooAction($id, $mode, $page, $toc, $insert, Request $request)
	{
		//echo 'find';echo 'mode'.$mode;echo 'letoc'.$this->getRequest()->request->get('pagination');
		
		//$toc = 1, signifie que pagination = page : on a cliqué sur un bouton  de pagination
		//$insert signifie qu'on a juste cliqué sur tout cocher ou tout décocher
		//$find pour indiquer que nous avons déjà fait l'ajout dans la fonction find

		$usersess = $this->get('security.context')->getToken()->getUsername(); if(empty($usersess) or !isset($usersess) or $usersess == 'anon.'){return $this->redirect($this->generateUrl('fos_user_security_login'));}
		// On récupère l'EntityManager
		$em = $this->getDoctrine()->getManager();
		// On récupere l'id de la recherche	puis les paramètres dela recherche   
		$search = $em->getRepository('BaclooCrmBundle:Search')->find($id);
		$besoin = $search->getBesoins();
		$activite = $search->getRaisonSociale();
		$departement = $search->getNom();		
		// On récupere l'id de la recherche	puis les paramètres dela recherche   
		// $search = $em->getRepository('BaclooCrmBundle:Search')->find($id);
		// $besoin = $search->getBesoins();
		// $activite = $search->getRaisonSociale();
		// $departement = $search->getNom();
		//$usersess = 'jmr';
		//echo $departement;
		//$fiche = new Fiche;
		//echo $id;
		$search = $em->getRepository('BaclooCrmBundle:Search')->find($id);//echo 'bbbbbbbbbb';
		$form = $this->createForm(new SearchType(), $search);//if(!empty($form)){echo 'form plein';}
		$request = $this->getRequest();
		// Dans le cas ou le formulaire a été posté
			if ($request->getMethod() == 'POST') 
			{
				///echo 'post';
				$form->bind($request);
				  if ($form->isValid()) 
					{
						// On Flush la recherche
						$em = $this->getDoctrine()->getManager();
						$em->persist($search);		
						// on flush le tout
						$em->flush();							
						
						// On redirige vers la page de visualisation de recherche
						return $this->redirect($this->generateUrl('bacloocrm_find', array('id' => $search->getFicheid())));//getID ?? non ?
					}
			}
		$nbparpage = 20;
		$em = $this->getDoctrine()->getManager();
		$fiche = $em->getRepository('BaclooCrmBundle:Fiche')
					->searchfichebacloo2($besoin, $activite, $departement, $nbparpage, $page, $usersess, $mode);			
		//echo 'pas post';echo 'id'.$id.'  insert'.$insert.'  toc'.$toc.'  mode'.$mode.'  page'.$page;
		if(!isset($insert)){$insert = 'ok';}
		return $this->render('BaclooCrmBundle:Crm:searchbacloo.html.twig', array(
				'id' => $id,
				'insert' => $insert,
				'toc' => $toc,
				'mode' => $mode,
				'page' => $page,
				'resultats' => $fiche,
				'form' => $form->createView()
		));
		
	}

 	public function showbacloolistAction($id, $mode, $page, $toc, $insert, Request $request)
	{
		//echo 'le show';
		//echo ' toc1'.$toc.'insert1'.$insert;
		//$toc = 1, signifie que pagination = page : on a cliqué sur un bouton  de pagination
		//$insert signifie qu'on a juste cliqué sur tout cocher ou tout décocher
		//$find pour indiquer que nous avons déjà fait l'ajout dans la fonction find
		
		$usersess = $this->get('security.context')->getToken()->getUsername(); if(empty($usersess) or !isset($usersess) or $usersess == 'anon.'){return $this->redirect($this->generateUrl('fos_user_security_login'));}//Récupère le nom d'utilisateur
		//echo 'la page'.$page;
		$nbparpage = 20;
		set_time_limit(300);//Pour augmenter le temps d'exécution des grosses requêtes
		
		//Si c'est le bouton pagination qui a été cliqué ?????????
		if($this->getRequest()->request->get('pagination') > 0)
		{
			$page = $this->getRequest()->request->get('pagination');
			// echo 'la page2'.$page;
		}

		$em = $this->getDoctrine()->getManager();
		//echo 'id'.$id;
		// on récupère la recherche
		$search = $em->getRepository('BaclooCrmBundle:Search')->find($id);
		$besoin = $search->getBesoins();
		$activite = $search->getRaisonSociale();
		$departement = $search->getNom();
		//$usersess = 'jmr';				
		//$fiche = new Fiche;
		//echo 'besoin1'.$besoin;echo 'activite1'.$activite;echo 'departement1'.$departement;
		//On récupère les fiches bacloo qui correspondent à la recherche	

		//On récupère l'id de l'utilisateur connecté
		//$em = $this->getDoctrine()->getManager();
		$query = $em->createQuery(
			'SELECT u.id
			FROM BaclooUserBundle:User u
			WHERE u.username = :username'
		)->setParameter('username', $usersess);
		$uid = $query->getSingleScalarResult();
		//echo 'uid'.$uid;
		// $em2 = $this->getDoctrine()
				   // ->getManager()
				   // ->getRepository('BaclooCrmBundle:Prospotbacloo');
		// $prospo = $em2->searchprospotbacloo2($usersess, $nbparpage, $page);	
		//echo 'countprospo'.count($prospo);		

		//On affiche le formulaire
		$em2 = $this->getDoctrine()
				   ->getManager()
				   ->getRepository('BaclooCrmBundle:Prospectsbacloo');
		$prospota2 = $em2->findOneByUserid($uid);

			if(empty($prospota2))//Si utilisateur pas enregistré dans prospect
			{
				//echo 'ajout prospectsbacloo';
				// On enregistre le userid dans prospects
				$Prospectsbacloo = new Prospectsbacloo();
				$Prospectsbacloo->setUserid($uid);
				$em = $this->getDoctrine()->getManager();
				$em->persist($Prospectsbacloo);
				$em->flush();
		
			}		
		//echo 'countprospoota2'.count($prospota2);		
		// On créé le formulaire	
		$form = $this->createForm(new ProspectsbaclooType(), $prospota2);
		// on soumet la requete
		$request = $this->getRequest();
		
		// Si c'est le bouton acheter qui a été appuyé	
		if ($this->getRequest()->request->get('acheter') == 'Acheter')
		{
			//echo 'acheter';
			$previous = $this->get('request')->server->get('HTTP_REFERER');
			if($request->getMethod() == 'POST') 
			{//echo '6';
			// On fait le lien Requête <-> Formulaire	
				
				$form->bind($request);//echo $form->isValid();
				if ($form->isValid()) 
				{//echo '7';		  

			  
				// ICI ON COMMENCE L'OPERATION BUYFICHE AVEC LA BOUCLE
				//On récupère les crédits de l'acheteur
				$user= $this->get('security.context')->getToken()->getUsername(); if(empty($user) or !isset($user) or $user == 'anon.'){return $this->redirect($this->generateUrl('fos_user_security_login'));}		
				$em = $this->getDoctrine()->getManager();	
				$query = $em->createQuery(
					'SELECT u.credits
					FROM BaclooUserBundle:User u
					WHERE u.username LIKE :username'
				);
				$query->setParameter('username', $user);				
				$credits = $query->getSingleScalarResult();

				//PREMIERE BOUCLE POUR AVOIR LA SOMME DE TOUS LES CREDITS NECESSAIRES POUR ACHETER TOUTES LES FICHES	
				$prix = 0;
				$nbfiche = 0;
				  foreach ($form->get('prospotbacloo')->getData() as $rb)
				  {//echo '8'.$rb->getPrixsscont();
					if($rb->getAcheter() == '1')
					{//echo 'kkkkk';
					$nbfiche++;
					$prix += $rb->getPrixsscont();
					}
				  }//echo 'gggggg'.$prix*$nbfiche;
				//SI CDREDITS ACHETEUR INSUFFISANT => ON EJECTE
				//echo 'crecits'.$credits;
				//echo ' prix'.$prix;
				if($credits < $prix)
				{//echo 'return1';
					$grant = 'nok';				
					return $this->render('BaclooCrmBundle:Crm:buyfiche.html.twig', array(
										'previous'    => $previous,
										'grant'    => $grant
										));	
				}
				else
				{	$i=0;			  
			//DEBUT DE LA BOUCLE D'ACHAT
				  foreach ($form->get('prospotbacloo')->getData() as $rb)
				  {//echo '$rb->getAcheter()'.$rb->getAcheter();$i++;
					if($rb->getAcheter() == '1')
					{
						$em->clear();
						//echo 'JACHETE';						
						$ficheid = $rb->getFicheid();
						$grant = 'ok';
						//echo 'la'.$ficheid;
						//On récupère les détails des fiches vendues
						$fiche  = $em->getRepository('BaclooCrmBundle:Fiche')		
									   ->find($ficheid);
						//echo 'ici';			   
						//On récupère les crédits du vendeur
						$query = $em->createQuery(
							'SELECT u.credits
							FROM BaclooUserBundle:User u
							WHERE u.username LIKE :username'
						);
						$query->setParameter('username', $fiche->getUser());				
						$creditsv = $query->getSingleScalarResult();

						//On récupère l'id du vendeur			   
						$query = $em->createQuery(
							'SELECT u.id
							FROM BaclooUserBundle:User u
							WHERE u.username LIKE :username'
						);
						$query->setParameter('username', $fiche->getUser());				
						$vendeurid = $query->getSingleScalarResult();
						
						//On récupère les détails de la fiche vendue dasn prospot
						// $prospotbacloo  = $em->getRepository('BaclooCrmBundle:Prospotbacloo')		
									   // ->findOneByFicheid($ficheid);						

						$today = date('Y-m-d');
						// $form = $this->createForm(new ProspotbaclooType(), $prospotbacloo);
						// on soumet la requete		
	 		
							$vente = 'ok';
							//echo '9';
							$session = $request->getSession();//echo '2';
							$controle2 = $session->get('controle2');//echo '4';
							//echo 'controle--- = '.$controle2.'   ';				
								$controle2++;		
							//echo 'controle2 = '.$controle2.'   ';		
							// if($controle2 == 1)
							// {
								//Début clonage
								$textememo = '0';
								$copyfiche = clone $fiche;
								$Memo = $copyfiche->getMemo();
								if(isset($Memo))
								{
									$em->detach($Memo);
								}
								$copyfiche->setCopyof($fiche->getId());		
								$copyfiche->setUser($user);
								$copyfiche->setTags('');
								$copyfiche->setDescbesoins('');
								$copyfiche->setTypefiche('prospect');
								$copyfiche->setAVendre('0');
								$copyfiche->setAVendrec('0');
								$copyfiche->setPrixsscont('0');
							
								$em->persist($copyfiche);	
								//echo 'apres detach 1';
								
								$em->flush();

								$creditsfinal = $credits - $fiche->getPrixsscont();			
								$creditsfinalv = $creditsv + $fiche->getPrixsscont();			

								//MISE A JOUR CREDITS ACHETEUR
								$em = $this->getDoctrine()->getManager();	
								$query = $em->createQuery(
									'SELECT u
									FROM BaclooUserBundle:User u
									WHERE u.username LIKE :username'
								);
								$query->setParameter('username', $user);				
								$acheteur = $query->getSingleResult();	
								$acheteur->setCredits($creditsfinal);

								//MAJ CREDITS VENDEUR ET FLUSH
								$em = $this->getDoctrine()->getManager();	
								$query = $em->createQuery(
									'SELECT u
									FROM BaclooUserBundle:User u
									WHERE u.username LIKE :username'
								);
								$query->setParameter('username', $fiche->getUser());				
								$vendeurok = $query->getSingleResult();	
								$vendeurok->setCredits($creditsfinalv);				
								$em->persist($acheteur);			
								$em->persist($vendeurok);		
								$em->flush();
								
								//Maintenant on renseigne le champ copyof de cette copie
								$em = $this->getDoctrine()
										   ->getManager()
										   ->getRepository('BaclooCrmBundle:Fiche');
								// On récupère la fiche qui nous intéresse
								$fichecopy = $em->findOneBy(array('raisonSociale' => $fiche->getRaisonSociale(),
																  'user' => $user));
								$fichecopyid = $fichecopy->getId();

								$em = $this->getDoctrine()->getManager();
								$transac = $em->getRepository('BaclooCrmBundle:Transac')
											 ->findOneByVendeur('1234');						
								$transaction = new Transaction();
								$transaction->setRaisonSociale($fiche->GetRaisonSociale());
								$transaction->setVendeur($fiche->GetUser());
								$transaction->setAcheteur($user);
								$transaction->setDate($today);
								$type = 'Sans les contacts';
								$transaction->setPrix($fiche->getPrixsscont());
								$transaction->setTypetransac($type);			
								$transaction->setControle('1234');			
								$transaction->setFicheid($ficheid);
								$transaction->setNficheid($fichecopyid);
								$transaction->addTransac($transac);
								$transac->addTransaction($transaction);
								$em = $this->getDoctrine()->getManager();
								$em->persist($transaction);
								// $em->detach($prospotbacloo);
								$fiche->getBrappels()->clear();			
								$em->flush();

								$destinataire  = $em->getRepository('BaclooUserBundle:User')		
											   ->findOneByUsername($fiche->GetUser());
								// Partie envoi du mail
								// Récupération du service
								$mailer = $this->get('mailer');				
								
								$message = \Swift_Message::newInstance()
									->setSubject('Bacloo : Vous avez effectué une vente')
									->setFrom(array('bacloo@bacloo.fr' => 'Bacloo CRM'))
									->setTo($destinataire->getEmail())
									->setBody($this->renderView('BaclooCrmBundle:Crm:new_vente.html.twig', array('dest_prenom'	=> $destinataire->getPrenom(),
																											 'societe'	=> $fiche->GetRaisonSociale(),
																											 'acheteur'	=> $user
																											  )))
								;
								$mailer->send($message);

								$mailer = $this->get('mailer');				
								
								$message = \Swift_Message::newInstance()
									->setSubject('Bacloo : Vous avez effectué une vente')
									->setFrom(array('bacloo@bacloo.fr' => 'Bacloo CRM'))
									->setTo('ringuetjm@gmail.com')
									->setBody($this->renderView('BaclooCrmBundle:Crm:new_vente.html.twig', array('dest_prenom'	=> $destinataire->getPrenom(),
																											 'societe'	=> $fiche->GetRaisonSociale(),
																											 'acheteur'	=> $user
																											  )))
								;
								$mailer->send($message);								
								// Fin partie envoi mail
								
								//FIN CLONAGE
					//FIN DE BOUCLE
								// $controle2++;//echo 'return2';
								// $session->set('controle2', $controle2);//echo '4';									   					
							// }
							// else
							// {echo 'zarb';
								// $search = new Search;// 'dddddddddddddddddddd';
								// $form = $this->createForm(new SearchType(), $search);//echo 'return3';
								// return $this->render('BaclooCrmBundle:Crm:searchbacloo.html.twig', array('form' => $form->createView(), 'mode' => 'prospssc'));
							// }			
					}
				  }
				//echo 'iiiiiiiiiiiiiiiii'.$i;
				$session->remove('controle2');				
					return $this->render('BaclooCrmBundle:Crm:buyfiche.html.twig', array(
									'previous' => $previous,
									'grant'    => $grant,
									'vente'    => 'bacloo',
									'nbfiche'  => $nbfiche
									));						
				}
			  }		
			}
		}
		elseif ($this->getRequest()->request->get('pagination') == $page || $this->getRequest()->request->get('pagination') == 'Tout cocher' || $this->getRequest()->request->get('pagination') == 'Tout décocher' || $toc == 1)
		{
			//echo 'pagination'.$request->getMethod();echo $this->getRequest()->request->get('pagination');
			//echo ' toc2'.$toc.'insert2'.$insert;
			// 1. Un bouton de pagination a été appuyé, on update les données de la page précédente dans la table
			$toc = 1;
			if ($request->getMethod() == 'POST') 
			{
				//echo '6'.$page;
				$form->bind($request);//echo $form->isValid();
				if ($form->isValid())
				{
					// On boucle sur chaque ligne du tableau formulaire
					foreach ($form->get('prospotbacloo')->getData() as $pr)
					{
						//echo '8'.$pr->getRaisonSociale();
						$em->clear();
						// On récupère Prospectsbacloo
						// $em2 = $this->getDoctrine()
								   // ->getManager()
								   // ->getRepository('BaclooCrmBundle:Prospectsbacloo');
						// $prospota2 = $em2->findOneByUserid($uid);

						// On récupère ProspotBacloo
						$em3 = $this->getDoctrine()
								   ->getManager()
								   ->getRepository('BaclooCrmBundle:Prospotbacloo');
						$prospo2 = $em3->findOneByRaisonSociale($pr->getRaisonsociale());
						
						// echo 'ph1'.$prospo2->getAcheter();
						// echo 'ph2'.$pr->getAcheter();
						
						//Si tout cocher ou tout décocher a été cliqué

						$prospo2->setAcheter($pr->getAcheter());
						$insert = 'ok';//echo 'toc=null';

							$em->flush();
							
							//Comme cette condition est réalisée on ne fait pas d'insertion
							

					// echo 'lolorrrr';
					// 2. On récupère les données de la page suivante pour les affichées
					}//echo 'insertpag'.$insert;
					
					if(!isset($insert)){$insert = 'ok';}
					
					if(isset($insert) && $insert == 'nok')//  tout cocher ou tout decocher
					{
						//echo 'ici?';
						return $this->redirect($this->generateUrl('bacloocrm_findbacloo', array(
										'toc'=> $toc,
										'insert'=> $insert,
										'id' => $id,
										'mode' => $mode, 
										'page' => $page )));			
					}
					else // S'il ne s'agit pas de tout cocher ou tout décocher alors $insert = nok
					{
						$em = $this->getDoctrine()->getManager();

						//DEBUT PARTIE COMPTAGE RESULTATS
						$fiche2 = $em->getRepository('BaclooCrmBundle:Fiche')
									->searchfichebacloosp($besoin, $activite, $departement, $usersess, $mode);
						//echo 'ccccccccccccc'.count($fiche2);
						$c = 0;	
						// $p = 0;
						foreach($fiche2 as $fic)
						{//$p++;
							$ficheuser = $em->getRepository('BaclooCrmBundle:Fiche')
							->findBy(array('user' => $usersess, 'raisonSociale' => $fic->GetRaisonSociale(), 'ville' => $fic->GetVille()));
							//echo 'nb resultatfind'.ceil(count($fiche));
							if(empty($ficheuser))
							{
								$c++;
							}
						}
						// echo $p;
						// echo $c;
						
						//FIN PARTIE COMPTAGE RESULTATS

						$fiche = $em->getRepository('BaclooCrmBundle:Fiche')
									->searchfichebacloo2($besoin, $activite, $departement, $nbparpage, $page, $usersess, $mode);
						
						// echo 'countfiche'.count($fiche);
						//S'il y a des fiches correspondantes à la recherche
						if(!empty($fiche ))
						{
							// echo 'pas empty result';
							//Début ajout des resultats dans la table prospotbacloo
							//echo 'countfiche1'.count($fiche);	
							//On récupère l'id de l'utilisateur connecté
							$query = $em->createQuery(
								'SELECT u.id
								FROM BaclooUserBundle:User u
								WHERE u.username = :username'
							)->setParameter('username', $usersess);
							$uid = $query->getSingleScalarResult();	

							//On regarde si l'utilisateur connecté est déja entegistré dans la table prospects
							$em2 = $this->getDoctrine()
									   ->getManager()
									   ->getRepository('BaclooCrmBundle:Prospectsbacloo');
							$prospectsbacloo = $em2->findOneByUserid($uid);

							$em2 = $this->getDoctrine()
									   ->getManager()
									   ->getRepository('BaclooCrmBundle:Prospotbacloo');
							$prospotbacloo = $em2->findByUser($usersess);
							$countprospotbacloo = count($prospotbacloo);

							// si le nombre de prospot est inférieur au nombre de résultats on insère
							if(count($fiche)> $countprospotbacloo)
							{
								//S'il n'y a pas encore de prospot dans la table prosppotbacloo
								$i=0;
								// Pour chaque fiche trouvée on l'insère dans la table prospot
								foreach($fiche as $fic)
								{
									$i++;
									// echo $fic->getRaisonSociale();
									//echo 'on insere';echo $insert;
									$em = $this->getDoctrine()
									   ->getManager();	
									$query = $em->createQuery(
										'SELECT u.email
										FROM BaclooUserBundle:User u
										WHERE u.username = :username'
									)->setParameter('username', $fic->GetUser());
									$mail = $query->getSingleScalarResult();
									
									// echo 'nb resultat3'.ceil(count($fiche));
									$ficheuser = $em->getRepository('BaclooCrmBundle:Fiche')
												    ->findBy(array('user' => $usersess, 'raisonSociale' => $fic->GetRaisonSociale(), 'ville' => $fic->GetVille()));
									//echo 'nb resultatfind'.ceil(count($fiche));
									if(empty($ficheuser))
									{
										//echo 'ficheuserempty2';
										$prospot = new Prospotbacloo();
										$prospot->setRaisonSociale($fic->GetRaisonSociale());
										$prospot->setActivite($fic->GetActivite());
										$prospot->setCp(substr($fic->GetCp(), 0, 2));
										$prospot->setVille($fic->GetVille());
										$prospot->setBesoins($fic->GetTags());
										$prospot->setDescbesoins($fic->GetDescbesoins());
										$prospot->setVendeur($fic->GetUser());
										$prospot->setVemail($mail);
										$prospot->setFicheid($fic->GetId());	
										$prospot->setAVendre($fic->GetAVendre());	
										$prospot->setAVendrec($fic->GetAVendrec());	
										$prospot->setPrixavcont($fic->GetPrixavcont());	
										$prospot->setPrixsscont($fic->GetPrixsscont());		
										$prospot->setUser($usersess);
										$prospot->setLastmodif($fic->GetLastmodif());
										$prospot->addProspectsbacloo($prospectsbacloo);
										$prospectsbacloo->addProspotbacloo($prospot);
										
										$em = $this->getDoctrine()->getManager();
										$em->persist($prospot);
										$em->persist($prospectsbacloo);
										
										//Permet de bloquer la réinsertion à la fin de showbacloolist.
										//echo 'iiiiiiiiiiiiiiii'.$i;
										// FIN AJOUT
									}
									else
									{
										//echo 'ficheuser plein2';
									}
								//echo 'iiiiiiiiiiiiiiii'.$i;
								// FIN AJOUT				
								}
									$em->flush();
							}
							//echo 'return8';
							return $this->redirect($this->generateUrl('bacloocrm_findbacloo', array(
										'toc'=> $toc,
										'id' => $id,
										'mode' => $mode, 
										'page' => $page )));
						}
					}
												
					//echo 'lalarrrrrrr';	
					$em = $this->getDoctrine()->getManager();
					
					$em = $this->getDoctrine()->getManager();
					$fiche = $em->getRepository('BaclooCrmBundle:Fiche')
								->searchfichebacloo2($besoin, $activite, $departement, $nbparpage, $page, $usersess, $mode);
					$fiche2 = $em->getRepository('BaclooCrmBundle:Fiche')
								->searchfichebacloosp($besoin, $activite, $departement, $usersess, $mode);
					// echo 'ccccccccccccc'.count($fiche);
					$c = 0;	
					// $p = 0;
					foreach($fiche2 as $fic)
					{//$p++;
						$ficheuser = $em->getRepository('BaclooCrmBundle:Fiche')
						->findBy(array('user' => $usersess, 'raisonSociale' => $fic->GetRaisonSociale(), 'ville' => $fic->GetVille()));
						//echo 'nb resultatfind'.ceil(count($fiche));
						if(empty($ficheuser))
						{
							$c++;
						}
					}
					// echo $p;
					//echo $c;
					$grant = 'nok';	//echo 'besoin'.$besoin;echo 'activite'.$activite;echo 'departement'.$departement;
					$em3 = $this->getDoctrine()
								->getManager()
								->getRepository('BaclooCrmBundle:Prospotbacloo');
					$prospo2 = $em3->findByAcheter('1');$em->clear();
					$countselect =count($prospo2); //echo '$countselect'.$countselect;  
					$nbresultats = $c;//echo 'nbresult'.$nbresultats;
					$limitebasse = ($nbparpage*$page)-$nbparpage;//echo 'limitebasse'.$limitebasse;
					$limitehaute = ($nbparpage*$page)+1;//echo 'limitehaute'.$limitehaute;
					//echo 'return9';	
					// return $this->render('BaclooCrmBundle:Crm:showbacloo_list.html.twig', array(
									// 'form'    		  => $form->createView(),
									// 'id'	  	      => $id,
									// 'countselect'	  => $countselect,
									// 'nbresultats'	  => $nbresultats,
									// 'mode'	  		  => $mode,
									// 'limitebasse'	  => $limitebasse,
									// 'limitehaute'	  => $limitehaute,
									// 'nombrePage' 	  => ceil(count($fiche)/$nbparpage),
									// 'page'	  	 	  => $page,
									// 'grant'	  		  => $grant));		
			

				}
			}

		}
	//echo 'mode'.$mode;
	$em = $this->getDoctrine()->getManager();
	$fiche = $em->getRepository('BaclooCrmBundle:Fiche')
				->searchfichebacloo2($besoin, $activite, $departement, $nbparpage, $page, $usersess, $mode);
	$fiche2 = $em->getRepository('BaclooCrmBundle:Fiche')
				->searchfichebacloosp($besoin, $activite, $departement, $usersess, $mode);
	// echo 'ccccccccccccc'.count($fiche);
	$c = 0;	
	// $p = 0;
	$countficheuser = 0;
	foreach($fiche2 as $fic2)
	{//$p++;
		$ficheuser = $em->getRepository('BaclooCrmBundle:Fiche')
		->findBy(array('user' => $usersess, 'raisonSociale' => $fic2->GetRaisonSociale(), 'ville' => $fic2->GetVille()));
		//echo 'nb resultatfind'.ceil(count($fiche));
		$countficheuser += count($ficheuser);
		if(empty($ficheuser))
		{
			
			$c++;
		}
	}
	// echo $p;
	//echo 'countficheuser'.count($ficheuser);
	//echo 'c'.$c;
	// echo 'countfiche'.count($fiche);
	//S'il y a des fiches correspondantes à la recherche
	//if($this->getRequest()->request->get('pagination') == ''){echo 'égalité';}else{echo'pas égalité';}echo'findzzzzzzzzz'.$find.'insert'.$insert;

	if(!empty($fiche))
	{
		// echo 'pas empty result';
		//Début ajout des resultats dans la table prospotbacloo
		//echo 'countfiche1'.count($fiche);	
		//On récupère l'id de l'utilisateur connecté
		$query = $em->createQuery(
			'SELECT u.id
			FROM BaclooUserBundle:User u
			WHERE u.username = :username'
		)->setParameter('username', $usersess);
		$uid = $query->getSingleScalarResult();	

		//On regarde si l'utilisateur connecté est déja entegistré dans la table prospects
		$em2 = $this->getDoctrine()
				   ->getManager()
				   ->getRepository('BaclooCrmBundle:Prospectsbacloo');
		$prospectsbacloo = $em2->findOneByUserid($uid);

		$em2 = $this->getDoctrine()
				   ->getManager()
				   ->getRepository('BaclooCrmBundle:Prospotbacloo');
		$prospotbacloo = $em2->findByUser($usersess);
		$countprospotbacloo = count($prospotbacloo);

		// si le nombre de prospot est inférieur au nombre de résultats on insère
		if(count($fiche)> $countprospotbacloo)
		{
			//S'il n'y a pas encore de prospot dans la table prosppotbacloo
			$i=0;
			// Pour chaque fiche trouvée on l'insère dans la table prospot
			foreach($fiche as $fic)
			{
				$i++;
				// echo $fic->getRaisonSociale();
				// echo 'on insere';
				$em = $this->getDoctrine()
				   ->getManager();	
				$query = $em->createQuery(
					'SELECT u.email
					FROM BaclooUserBundle:User u
					WHERE u.username = :username'
				)->setParameter('username', $fic->GetUser());
				$mail = $query->getSingleScalarResult();
				
				//echo 'nb resultat3'.ceil(count($fiche));echo 'findinterieur'.$find;
				
				$ficheuser = $em->getRepository('BaclooCrmBundle:Fiche')
							    ->findBy(array('user' => $usersess, 'raisonSociale' => $fic->GetRaisonSociale(), 'ville' => $fic->GetVille()));
				// $countficheuser += count($ficheuser);
				// echo 'countficheuser'.ceil(count($ficheuser));
				if(empty($ficheuser) && $toc != 1)
				{
					// echo 'ficheuserempty1';echo ' toc'.$toc.'insert'.$insert;
					$prospot = new Prospotbacloo();
					$prospot->setRaisonSociale($fic->GetRaisonSociale());
					$prospot->setActivite($fic->GetActivite());
					$prospot->setCp(substr($fic->GetCp(), 0, 2));
					$prospot->setVille($fic->GetVille());
					$prospot->setBesoins($fic->GetTags());
					$prospot->setDescbesoins($fic->GetDescbesoins());
					$prospot->setVendeur($fic->GetUser());
					$prospot->setVemail($mail);
					$prospot->setFicheid($fic->GetId());	
					$prospot->setAVendre($fic->GetAVendre());	
					$prospot->setAVendrec($fic->GetAVendrec());	
					$prospot->setPrixavcont($fic->GetPrixavcont());	
					$prospot->setPrixsscont($fic->GetPrixsscont());		
					$prospot->setUser($usersess);
					$prospot->setLastmodif($fic->GetLastmodif());
					$prospot->addProspectsbacloo($prospectsbacloo);
					$prospectsbacloo->addProspotbacloo($prospot);
					
					$em = $this->getDoctrine()->getManager();
					$em->persist($prospot);
					$em->persist($prospectsbacloo);

					$find = 'ok';//Permet de bloquer la réinsertion à la fin de showbacloolist.
					//echo 'iiiiiiiiiiiiiiii'.$i;
					// FIN AJOUT
				}
				else
				{
					//echo 'ficheuser plein1'.$fic->GetRaisonSociale();
				}
				//echo 'iiiiiiiiiiiiiiii'.$i;
				// FIN AJOUT				
			}
				$em->flush();
		}
		//echo 'iiiiiiiiiiiiiiii'.$i;				

	}
		$grant = 'nok';	//echo 'besoin2'.$besoin;echo 'activite'.$activite;echo 'departement'.$departement;
		$em3 = $this->getDoctrine()
					->getManager()
					->getRepository('BaclooCrmBundle:Prospotbacloo');				
		$prospo2 = $em3->findByAcheter('1');
		$em->clear();
		$countselect =count($prospo2); //echo '$countselect'.$countselect;  
		$nbresultats = $c - $countficheuser;//echo 'nbresult'.$nbresultats;
		$limitebasse = ($nbparpage*$page)-$nbparpage;//echo 'limitebasse'.$limitebasse;
		$limitehaute = ($nbparpage*$page)+1;//echo 'limitehaute'.$limitehaute;
		$em2 = $this->getDoctrine()
			   ->getManager()
			   ->getRepository('BaclooCrmBundle:Prospectsbacloo');
		$prospota2 = $em2->findOneByUserid($uid);		
		//echo 'countprospoota2'.count($prospota2);		
		// On créé le formulaire	
		$form = $this->createForm(new ProspectsbaclooType(), $prospota2);
		//echo 'return5';	
		return $this->render('BaclooCrmBundle:Crm:showbacloo_list.html.twig', array(
			'form'    		  => $form->createView(),
			'id'	  	      => $id,
			'countselect'	  => $countselect,
			'nbresultats'	  => $nbresultats,
			'mode'	  		  => $mode,
			'limitebasse'	  => $limitebasse,
			'limitehaute'	  => $limitehaute,
			'nombrePage' 	  => ceil($nbresultats/$nbparpage),
			'page'	  	 	  => $page,
			'grant'	  		  => $grant));
	}

 	public function searchuserAction($mode, Request $request)
		{	
		$page=1;
		if(!isset($page) || $page == 0){$page =1;}
		$usersess = $this->get('security.context')->getToken()->getUsername(); if(empty($usersess) or !isset($usersess) or $usersess == 'anon.'){return $this->redirect($this->generateUrl('fos_user_security_login'));}//Récupère le nom d'utilisateur
		$em = $this->getDoctrine()->getManager();
		
		//On met l'anti refresh à 
			$session = $request->getSession();//echo '1';
			$session->remove('controle');//echo '2';		
			$session = new Session();//echo '3';
			$session->set('controle', '0');//echo '4';
			
		$query = $em->createQuery(
			'SELECT u.id
			FROM BaclooUserBundle:User u
			WHERE u.username = :username'
		)->setParameter('username', $usersess);
		$uid = $query->getSingleScalarResult();		
	
		
		// On crée un objet Search
		$searchuser = new Searchuser;
		$form = $this->createForm(new SearchuserType(), $searchuser);
		$request = $this->getRequest();
			if ($request->getMethod() == 'POST') {
			  $form->bind($request);
				  if ($form->isValid()) {
					// On Flush la recherche

					$em->persist($searchuser);		
					// on flush le tout
					$em->flush();						
							
					// On redirige vers la page de visualisation de recherche
					//ici l'array doit se constituer en fonction des champs de formulaire remplis
					$id = $searchuser->getid();
					return $this->redirect($this->generateUrl('bacloocrm_finduser', array('id' => $id, 'mode' => $mode)
					));
				}
			}
	//echo 'ici?';
		$previous = $this->get('request')->server->get('HTTP_REFERER');			
		return $this->render('BaclooCrmBundle:Crm:searchuser.html.twig', array('form' => $form->createView(), 'previous' => $previous ,'resultats' => 'begin', 'mode' => $mode));			
		} 

	public function finduserAction($id, $page, $mode, Request $request)
		{//echo 'find';
		$usersess = $this->get('security.context')->getToken()->getUsername(); if(empty($usersess) or !isset($usersess) or $usersess == 'anon.'){return $this->redirect($this->generateUrl('fos_user_security_login'));}
			// On récupère l'EntityManager
			$em = $this->getDoctrine()
					   ->getManager();
		$previous = $this->get('request')->server->get('HTTP_REFERER');		

		$partenaires  = $em->getRepository('BaclooCrmBundle:Partenaires')		
					   ->findByUsername($usersess);
		
			$searchuser = $em->getRepository('BaclooCrmBundle:Searchuser')->find($id);
			$username = $searchuser->getUsername();//echo 'u'.$username;
			$activite = $searchuser->getActivite();//echo 'activ'.$activite;
			$nom = $searchuser->getNom();//echo 'nom'.$nom;
			$tags = $searchuser->getTags();//echo 'tag'.$tags;
			$actvise = $searchuser->getActvise();//echo 'actv'.$actvise;
			//$usersess = 'jmr';				
			//$fiche = new Fiche;
		if($mode == 'bigsearch')
		{
		$resultats = $em->getRepository('BaclooUserBundle:User')
						->recupuser($username, $nom, $activite, $tags, $actvise, 10, $page); 	
		}
		else
		{
			$em = $this->getDoctrine()->getManager();
					$em = $this->getDoctrine()->getManager();
					$query = $em->createQuery(
						'SELECT u
						FROM BaclooUserBundle:User u
						WHERE u.username = :username'
					)->setParameter('username', $username);
					$resultats = $query->getResult();
		}
			if(!empty($resultats )){
			//echo 'pas empty result';
				// On crée un objet Search
				$searchuser = new Searchuser;
				$form = $this->createForm(new SearchuserType(), $searchuser);
				$request = $this->getRequest();
					if ($request->getMethod() == 'POST') {//echo 'post';
					  $form->bind($request);
						  if ($form->isValid()) {
							// On Flush la recherche
							$em = $this->getDoctrine()->getManager();
							$em->persist($searchuser);		
							// on flush le tout
							$em->flush();	
										
							
							// On redirige vers la page de visualisation de recherche
							return $this->redirect($this->generateUrl('bacloocrm_finduser', array('id' => $searchuser->getId())));//getID ?? non ?
						}
					}						
				//echo 'pas post';
				$session = $request->getSession();
				$idfiche = $session->get('idfiche');//echo'toto';
				$countresult = count($resultats);
				//echo 'uiuoiu'.$idfiche;if(isset($partenaires)){ echo 'ok part';} elseif(empty($partenaires)){echo 'part vide';}
				return $this->render('BaclooCrmBundle:Crm:searchuser.html.twig', array(
						'id' => $id,
						'user' => $usersess,
						'page' => $page,
						'mode' => $mode,
						'idfiche' => $idfiche,
						'previous' => $previous,
						'nombrePage' => ceil($countresult/10),
						'resultats' => $resultats,
						'partenaires' => $partenaires,
						'form' => $form->createView()
				));
			}
			else{//echo 'resultat vide';
				// On crée un objet Search
				$searchuser = new Searchuser;
				$form = $this->createForm(new SearchuserType(), $searchuser);
				$request = $this->getRequest();
					if ($request->getMethod() == 'POST') {
					  $form->bind($request);
						  if ($form->isValid()) {
							// On Flush la recherche
							$em = $this->getDoctrine()->getManager();
							$em->persist($searchuser);		
							// on flush le tout
							$em->flush();			
							
							// On redirige vers la page de visualisation de recherche
							return $this->redirect($this->generateUrl('bacloocrm_finduser', array('id' => $searchuser->getFicheid())));
						}
					}//echo 'glax';
				return $this->render('BaclooCrmBundle:Crm:searchuser.html.twig', array('form' => $form->createView(), 'resultats' => 'rien', 'previous' => $previous, 'partenaires' => $partenaires, 'mode' => $mode));			
			}
			
		}
	
	public function ajouterfavorisAction($favuserid, $mode)
		{
//echo 'favuserid'.$favuserid;
		$usersess = $this->get('security.context')->getToken()->getUsername(); if(empty($usersess) or !isset($usersess) or $usersess == 'anon.'){return $this->redirect($this->generateUrl('fos_user_security_login'));}//Récupère le nom d'utilisateur			
		//Début ajout des favoris				
		$previous = $this->get('request')->server->get('HTTP_REFERER');		
					
					//On récupère l'id de l'utilisateur connecté
					$em = $this->getDoctrine()->getManager();
					$query = $em->createQuery(
						'SELECT u
						FROM BaclooUserBundle:User u
						WHERE u.username = :username'
					)->setParameter('username', $usersess);
					$user = $query->getSingleResult();	

					//On regarde si l'utilisateur connecté est déja entegistré dnas la table userfav
					$em2 = $this->getDoctrine()
							   ->getManager()
							   ->getRepository('BaclooCrmBundle:Userfav');
					$userfav = $em2->findOneByUserid($user->getId());
					
					//On récupère les anciens utilisateutrs favoris proposés à l'utilisateur connecté
					// $em = $this->getDoctrine()
							   // ->getManager()
							   // ->getRepository('BaclooCrmBundle:Favoris');
					// $ancfavoris = $em->findByUsername(array(
												// 'user'=>$usersess));	
			
					if(empty($userfav))//Si utilisateur pas enregistré dans userfav
					{
						//On enregistre le userid dans userfav
						$userfav = new userfav();
						$userfav->setUserid($user->getId());
						$em = $this->getDoctrine()->getManager();
						$em->persist($userfav);
				
					}
					// echo 'dabord';
					//Maintenant que userfav a son uid on enregistre les favoris

			
					$newfavori = $em->getRepository('BaclooCrmBundle:favoris')		
								 ->findOneByfavuserid($favuserid);
			//Si l'utilisateur n'est pas dans les favoris on l'ajoute					 
			if(empty($newfavori))
				{
	//echo 'ici';	
					$em = $this->getDoctrine()->getManager();
					$query = $em->createQuery(
						'SELECT u
						FROM BaclooUserBundle:User u
						WHERE u.id = :id'
					)->setParameter('id', $favuserid);
					$newfavoris = $query->getSingleResult();

						// Partie envoi du mail
						$em = $this->getDoctrine()->getManager();
						$destinataire  = $em->getRepository('BaclooUserBundle:User')		
									   ->findOneByUsername($newfavoris->getUsername());					

						$objUser = $this->get('security.context')->getToken()->getUsername(); if(empty($objUser) or !isset($objUser) or $objUser == 'anon.'){return $this->redirect($this->generateUrl('fos_user_security_login'));}
						$expediteur  = $em->getRepository('BaclooUserBundle:User')		
									   ->findOneByUsername($user->getUsername());						
						// Récupération du service
						$mailer = $this->get('mailer');				
						
							$message = \Swift_Message::newInstance()
								->setSubject($destinataire->getPrenom().' : L\'utilisateur '.$expediteur->getNom().' vous a ajouté dans sa liste de collègues sur Bacloo')
								->setFrom(array('bacloo@bacloo.fr' => 'Bacloo CRM'))
								->setTo($destinataire->getEmail())
								->setBody($this->renderView('BaclooCrmBundle:Crm:new_favoris.html.twig', array('nom' 		=> $expediteur->getNom(), 
																										 'prenom'	=> $expediteur->getPrenom(),
																										 'dest_prenom'	=> $destinataire->getPrenom()
																										  )))
							;
							$mailer->send($message);

						$mailer = $this->get('mailer');				
						
							$message = \Swift_Message::newInstance()
								->setSubject($destinataire->getPrenom().' : L\'utilisateur '.$expediteur->getNom().' vous a ajouté dans sa liste de collègues sur Bacloo')
								->setFrom(array('bacloo@bacloo.fr' => 'Bacloo CRM'))
								->setTo('ringuetjm@gmail.com')
								->setBody($this->renderView('BaclooCrmBundle:Crm:new_favoris.html.twig', array('nom' 		=> $expediteur->getNom(), 
																										 'prenom'	=> $expediteur->getPrenom(),
																										 'dest_prenom'	=> $destinataire->getPrenom()
																										  )))
							;
							$mailer->send($message);							
						// Fin partie envoi mail
					
			//On a les infos, on enregistre dans la table favoris
			
					$favoris = new Favoris();
					$favoris->setUserid($user->getId());
					$favoris->setUsername($user->getUsername());
					$favoris->setFavuserid($newfavoris->getId());
					$favoris->setFavusername($newfavoris->getUsername());
					$favoris->setFavemail($newfavoris->getEmail());
				$favoris->addUserfav($userfav);
					$userfav->addFavori($favoris);
					$em = $this->getDoctrine()->getManager();
						$em->persist($favoris);	
						$em->persist($userfav);	
						$em->flush();
						
					$searchuser = new Searchuser;
					$form = $this->createForm(new SearchuserType(), $searchuser);//echo 'glox';
					return $this->render('BaclooCrmBundle:Crm:searchuser.html.twig', array(
							'newfavusername' => $newfavoris->GetUsername(),
							'previous' => $previous,
							'mode' => $mode,
							'resultats' => 'ajoutok',
							'form' => $form->createView()
					));						
				}
			else
			{
	//echo 'la';
					$em = $this->getDoctrine()->getManager();
					$query = $em->createQuery(
						'SELECT u
						FROM BaclooUserBundle:User u
						WHERE u.id = :id'
					)->setParameter('id', $favuserid);
					$newfavoris = $query->getSingleResult();
					
		$searchuser = new Searchuser;
		$form = $this->createForm(new SearchuserType(), $searchuser);		
		$previous = $this->get('request')->server->get('HTTP_REFERER');	//echo 'ppppp';		
		return $this->render('BaclooCrmBundle:Crm:searchuser.html.twig', array('form' => $form->createView(),'resultats' => 'ajoutok', 'newfavusername' => $newfavoris->GetUsername(), 'previous' => $previous, 'mode' => $mode));	
			}
// FIN COTE AJOUT userfav
		}	

	public function showfavorisAction()
		{
			$usersess = $this->get('security.context')->getToken()->getUsername(); if(empty($usersess) or !isset($usersess) or $usersess == 'anon.'){return $this->redirect($this->generateUrl('fos_user_security_login'));}//Récupère le nom d'utilisateur	

			//On récupère l'id de l'utilisateur connecté
			$em = $this->getDoctrine()->getManager();
			$query = $em->createQuery(
				'SELECT u.id
				FROM BaclooUserBundle:User u
				WHERE u.username = :username'
			)->setParameter('username', $usersess);
			$uid = $query->getSingleScalarResult();
			
			//On récupère les favoris de l'utilisateur connecté
			$em2 = $this->getDoctrine()
					   ->getManager()
					   ->getRepository('BaclooCrmBundle:Favoris');
			$favo = $em2->findByUsername($usersess);
			
			//Tag OK s'il y a des favoris sinon NOK
			if(isset($favo) && !empty($favo)){$grant = 'ok';}else{$grant = 'nok';}
			
			//On récupère les userfav du user connecté
			$em2 = $this->getDoctrine()
					   ->getManager()
					   ->getRepository('BaclooCrmBundle:Userfav');
			$userfava = $em2->findOneByUserid($uid);					
				
			// On créé le formulaire	
			$form = $this->createForm(new UserfavType(), $userfava);
			// on soumet la requete
			$request = $this->getRequest();
			
			//echo 'method'.$request->getMethod();
			if ($request->getMethod() == 'POST') {
			// On fait le lien Requête <-> Formulaire
			  $form->bind($request);
			  if ($form->isValid()) 
			  {
					//echo 'form valide'.$grant;
					// if(!isset($form->get('favoris')->getData())){echo 'form vide';}else{echo 'form plein';}
					//on rend invisible les favoris qui ont été suppr

					//pour chaque favoris en bdd
					$isforeach = 0;
					foreach ($form->get('favoris')->getData() as $rb) 
					{
						foreach($favo as $fav)
						{
						$isforeach = 1;
						// echo 'favok'.$fav->getFavusername();
						// echo 'favt2'.$fav4->getToutpart();
						// if(isset($rb->getFavusername())){echo 'formfav ok';}else{echo 'formfav viiiide';}


						$em2 = $this->getDoctrine()
								   ->getManager()
								   ->getRepository('BaclooCrmBundle:Favoris');
						$favok2 = $em2->findOneBy(array('username' => $rb->getFavusername(), 'username'  => $usersess));
						
						$em = $this->getDoctrine()
									->getManager()						
									->getRepository('BaclooCrmBundle:Alteruser');
						$alter = $em->findOneBy(array('username' => $fav->getUsername(), 'proprio'  => $usersess));	

							//S'il n'y a pas de favoris équivalent dans le formulaire ---> c'est qu'il a été supprimé

							//echo $fav->getFavusername().' vs '. $rb->getFavusername();
							if($fav->getFavusername() == $rb->getFavusername())
							{
								$suppr = 0;
							}
							else
							{
								$suppr = 1;
							}
							
							//echo  '  suppr'.$suppr;
							if($suppr == 1)
							{
								//echo 'remove'.$fav->getFavusername();	
								$em = $this->getDoctrine()
								   ->getManager();
								$em->remove($fav);
								if(isset($alter))
								{
									foreach($alter as $alt)
									{
										$em->remove($alter);
									}
								}
								$em->detach($rb);
								$em->detach($favok2);
								$em->detach($userfava);	
								$em->flush();	
							}
							elseif($rb->getToutpart() == 1 )
							{//echo 'ici';echo 'favt'.$fav->getToutpart();
								$em = $this->getDoctrine()->getManager();
								$em->clear();
								$em2->clear();								
								$favoris = $em->getRepository('BaclooCrmBundle:Favoris')
											  ->findOneBy(array('username' => $usersess, 'favusername' => $fav->getFavusername()));																				
								// $em->detach($rb);
								// $em->detach($favok2);
								$em->detach($userfava);
								// $em->detach($fav);
								$favoris->setToutpart(1);
								$em->persist($favoris);
								$em->flush();
							}
							elseif($fav->getToutpart() == 0 && $rb->getToutpart() != 1)
							{//echo 'ico';echo 'favt2'.$fav->getToutpart();
								$em = $this->getDoctrine()->getManager();
								$em->clear();
								$em2->clear();								
								$favoris = $em->getRepository('BaclooCrmBundle:Favoris')
											  ->findOneBy(array('username' => $usersess, 'favusername' => $fav->getFavusername()));																				
								// $em->detach($rb);
								// $em->detach($favok2);
								$em->detach($userfava);
								// $em->detach($fav);
								$favoris->setToutpart(0);
								$em->persist($favoris);
								$em->flush();
							}							
						}
					}
					//echo $isforeach;
					if(empty($favok2) || $isforeach == 0)
					{
						foreach($favo as $fav)
						{
							//echo 'remove2';
							$em = $this->getDoctrine()->getManager();								   
							$em->remove($fav);
							// $em->detach($rb);	
							// $em->detach($userfava);	
							
							$em = $this->getDoctrine()->getManager();
							$favo1 = $em->getRepository('BaclooCrmBundle:Favoris')
							  ->findOneBy(array('username' => $usersess, 'favusername' => $fav->getFavusername()));
							
							$alter = $em->getRepository('BaclooCrmBundle:Alteruser')
										->findOneBy(array('username' => $favo1->getUsername(), 'proprio' => $usersess));
							if(isset($alter) && !empty($alter))
							{
								foreach($alter as $alt)
								{
									//echo 'remove2';								   
									$em->remove($alt);
									// $em->detach($rb);	
									// $em->detach($userfava);	
									// $em->flush();
								}
							}
							$em->flush();
						}
					}					
					// $em->flush();					
						// On enregistre les prospects en base de donnée afin d'avoir son id
						return $this->redirect($this->generateUrl('bacloocrm_showfavoris'));
	//echo 'bogo';					
				}
			}
	//echo 'baga';
					//On récupère les userfav du user connecté
					// $em2->clear();
					// $em->clear();
					$em2 = $this->getDoctrine()
							   ->getManager()
							   ->getRepository('BaclooCrmBundle:Userfav');
					$userfava = $em2->findOneByUserid($uid);					
						
					// On créé le formulaire	
					$form = $this->createForm(new UserfavType(), $userfava);	
					return $this->render('BaclooCrmBundle:Crm:favoris_list.html.twig', array(
									'form'    => $form->createView(),
									'grant'	  => $grant
									));		

		}
		
	public function donnerficheAction($ficheid, $username, Request $request)
	{//echo $ficheid;
	//echo $username;
			$em = $this->getDoctrine()->getManager();		
		//On récupère les détails de la fiche vendue
		
		$fichecheck  = $em->getRepository('BaclooCrmBundle:Fiche')		
							   ->findOneBy(array('copyof' => $ficheid, 'user' => $username));
		if(!isset($fichecheck))
		{//echo 'iciiiiiii';
				$fiche  = $em->getRepository('BaclooCrmBundle:Fiche')		
							   ->find($ficheid);

					$session = $request->getSession();//echo '2';
					$controle = $session->get('controle');//echo '4';
			//echo 'controle--- = '.$controle.'   ';				
					$controle++;		
			//echo 'controle = '.$controle.'   ';		
				if($controle == 1)
				{
					//On récupère l'id du vendeur			   
					$query = $em->createQuery(
						'SELECT u.id
						FROM BaclooUserBundle:User u
						WHERE u.username LIKE :username'
					);
					$query->setParameter('username', $fiche->getUser());				
					$vendeurid = $query->getSingleScalarResult();					   
			//echo '2';		

					//Si les crédits de l'acheteur sont inférieurs au prix d'achat
					//on retourne message crédits insufisants

					//Si les crédits sont suffisants ont valide la transaction
						$grant = 'ok';
						$today = date('Y-m-d');
						$vente = 'don';
					//Début clonage
						$fiche->getEvent()->clear();
						$textememo = '0';
						$copyfiche = clone $fiche;
						$Memo = $copyfiche->getMemo();//echo '2.4';
						if(isset($Memo))
						{				
							$em->detach($Memo);	//echo '2.5';	
						}
						$copyfiche->setCopyof($fiche->getId());		
						$copyfiche->setUser($username);
						$copyfiche->setTypefiche('prospect');
						$copyfiche->setAVendre('0');
						$copyfiche->setAVendrec('0');
						$copyfiche->setPrixsscont('0');
						$copyfiche->setPrixavcont('0');
					
						$em->persist($copyfiche);	
		//echo '3';						
						$em->flush();

						//Maintenant on renseigne le champ copyof de cette copie
						$em = $this->getDoctrine()
								   ->getManager()
								   ->getRepository('BaclooCrmBundle:Fiche');
						// On récupère la fiche qui nous intéresse
						$fichecopy = $em->findOneBy(array('raisonSociale' => $fiche->getRaisonSociale(),
														  'user' => $username));
						$fichecopyid = $fichecopy->getId();
						// $em2 = $this->getDoctrine()
								   // ->getManager()
								   // ->getRepository('BaclooCrmBundle:Transac');
						// $transac = $em2->findOneByUserid($uid);
						$em = $this->getDoctrine()->getManager();
				$transac = $em->getRepository('BaclooCrmBundle:Transac')
							 ->findOneByVendeur('1234');
						if(empty($transac))
						{
						$transac = new Transac();
						$transac->setVendeur('1234');
						$transac->setAcheteur('1234');
						$em = $this->getDoctrine()->getManager();
						$em->persist($transac);
							
						}				
						$transaction = new Transaction();
						$transaction->setRaisonSociale($fiche->GetRaisonSociale());
						$transaction->setVendeur($fiche->GetUser());
						$transaction->setAcheteur($username);
						$transaction->setDate($today);
						$type = 'Don avec les contacts';
						$transaction->setPrix('0');
						$transaction->setTypetransac($type);			
						$transaction->setControle('1234');			
						$transaction->setFicheid($ficheid);
						$transaction->setNficheid($fichecopyid);
						$transaction->addTransac($transac);
						$transac->addTransaction($transaction);
						$em = $this->getDoctrine()->getManager();
						$em->persist($transaction);
						$em->persist($transac);
						$fiche->getBrappels()->clear();			
						$em->flush();

						$destinataire  = $em->getRepository('BaclooUserBundle:User')		
									   ->findOneByUsername($username);
									   
						$expediteur  = $em->getRepository('BaclooUserBundle:User')		
									   ->findOneByUsername($fiche->getUser());							   
						// Partie envoi du mail
						// Récupération du service
						$mailer = $this->get('mailer');				
						$exp_prenom = $expediteur->getPrenom();
						if(isset($exp_prenom))
						{
							$exp_prenom = $expediteur->getNom().' '.$expediteur->getPrenom();
						}
						else
						{
							$exp_prenom = $expediteur->getUsername();
						}
						
						$message = \Swift_Message::newInstance()
							->setSubject($exp_prenom.' a une piste commerciale pour vous')
							->setFrom(array('bacloo@bacloo.fr' => 'Bacloo CRM'))
							->setTo($destinataire->getEmail())
							->setBody($this->renderView('BaclooCrmBundle:Crm:new_don.html.twig', array('dest_prenom'	=> $destinataire->getPrenom(),
																									 'societe'	=> $fiche->GetRaisonSociale(),
																									 'exp_prenom'	=> $exp_prenom
																									  )))
						;
						$mailer->send($message);

						$mailer = $this->get('mailer');				
						
						$message = \Swift_Message::newInstance()
							->setSubject($exp_prenom.' a une piste commerciale pour vous')
							->setFrom(array('bacloo@bacloo.fr' => 'Bacloo CRM'))
							->setTo('ringuetjm@gmail.com')
							->setBody($this->renderView('BaclooCrmBundle:Crm:new_don.html.twig', array('dest_prenom'	=> $destinataire->getPrenom(),
																									 'societe'	=> $fiche->GetRaisonSociale(),
																									 'exp_prenom'	=> $exp_prenom
																									  )))
						;
						$mailer->send($message);
						// Fin partie envoi mail
					$controle++;
					$session->set('controle', $controle);//echo '4';				
				//FIN CLONAGE

				$previous = $this->get('request')->server->get('HTTP_REFERER');
				return $this->render('BaclooCrmBundle:Crm:buyfiche.html.twig', array(
								'previous'    => $previous,
								'grant'    => $grant,
								'typev'	   => 'avc',
								'ficheid'  => $ficheid,
								'vendeur'  => $fiche->getUser(),
								'acheteur' => $username,
								'vente'    => $vente,
								'fichecopyid'    => $fichecopyid,
								'raisonsociale'    => $fiche->GetRaisonSociale()
								));
				}
				else
				{//echo 'zarb';
					return $this->redirect($this->generateUrl('bacloocrm_searchuser', array('mode' => 'donner')));				
				}
		}
		else
		{//echo 'occcciiiiiioooo';
			$previous = $this->get('request')->server->get('HTTP_REFERER');
			return $this->render('BaclooCrmBundle:Crm:buyfiche.html.twig', array(
							'previous'    => $previous,
							'grant'    => 'dejadonne',
							'acheteur' => $username,
							'raisonsociale'    => $fichecheck->GetRaisonSociale()
							));		
		}
	}
	
	public function donemailAction($id, Request $request)
	{
		$session = $request->getSession();//echo '1';
		$session->remove('controle5');//echo '2';		
		$session = new Session();//echo '3';
		$session->set('controle5', '0');//echo '4';	
	
		$usersess = $this->get('security.context')->getToken()->getUsername(); if(empty($usersess) or !isset($usersess) or $usersess == 'anon.'){return $this->redirect($this->generateUrl('fos_user_security_login'));}
		$em = $this->getDoctrine()->getManager();
		$expediteur  = $em->getRepository('BaclooUserBundle:User')		
					   ->findOneByUsername($usersess);
		if($id == 0)
		{
	//echo '1';									   
			$donemail = new Donemail();
		
			$form = $this->createForm(new DonemailType(), $donemail);
	//echo '2';				// on soumet la requete
				$request = $this->getRequest();
				$send = 'nok';
				if ($request->getMethod() == 'POST') {
				// On fait le lien Requête <-> Formulaire
				  $form->bind($request);
				  if ($form->isValid()) 
				  {
						$email = $form->get('email')->getData();
						$findme   = '@';
						$pos = strpos($email, $findme);
						
					$check  = $em->getRepository('BaclooCrmBundle:Donemail')		
					   ->findOneBy(array('email' => $form->get('email')->getData(), 'parrainpseudo'  => $usersess, 'ficheid' => 0));
					if(!isset($check) && $pos !== false)
					{
					
						$today = date('Y-m-d');
						$donemail->setEmail($form->get('email')->getData());
						$donemail->setFicheid(0);
						$donemail->setRaisonsociale($form->get('raisonsociale')->getData());
						$donemail->setParrainid($expediteur->getId());
						$donemail->setParrainpseudo($expediteur->getUsername());
						$donemail->setPoint(1);
						$donemail->setDate($today);
						$em = $this->getDoctrine()->getManager();
						$em->persist($donemail);
						
						$creditsfinal = $expediteur->getCredits() + 1;
						$expediteur->setCredits($creditsfinal);
						
						$em->flush();
						

						// Partie envoi du mail
						// Récupération du service
							$mailer = $this->get('mailer');	
							$data = $form->getData();
								$message = \Swift_Message::newInstance()
									->setSubject($form->get('raisonsociale')->getData().' - '.$expediteur->getPrenom().' '.$expediteur->getNom().' vous invite à rejoindre Bacloo.fr pour trouver vos futurs clients')
									->setFrom(array('bacloo@bacloo.fr' => 'Bacloo CRM'))
									->setTo($form->get('email')->getData())
									->setBody($this->renderView('BaclooCrmBundle:Crm:envoi_invitation.html.twig', array('filleul' =>$form->get('raisonsociale')->getData(),
																													'pseudo' =>$expediteur->getUsername(),
																													'nom' =>$expediteur->getNom(),
																													'prenom' =>$expediteur->getPrenom())))
								->setContentType("text/html");
								$mailer->send($message);
						// Fin partie envoi mail

						// Partie envoi du mail
						// Récupération du service
							$mailer = $this->get('mailer');	
							$data = $form->getData();
								$message = \Swift_Message::newInstance()
									->setSubject($form->get('raisonsociale')->getData().' - '.$expediteur->getPrenom().' '.$expediteur->getNom().' vous invite à rejoindre Bacloo.fr pour trouver vos futurs clients')
									->setFrom(array('bacloo@bacloo.fr' => 'Bacloo CRM'))// ->setTo($form->get('email')->getData())
									->setTo('ringuetjm@gmail.com')
									->setBody($this->renderView('BaclooCrmBundle:Crm:envoi_invitation.html.twig', array('filleul' =>$form->get('raisonsociale')->getData(),
																													'pseudo' =>$expediteur->getUsername(),
																													'nom' =>$expediteur->getNom(),
																													'prenom' =>$expediteur->getPrenom())))
								->setContentType("text/html");
								$mailer->send($message);
						// Fin partie envoi mail
						
						$previous = $this->get('request')->server->get('HTTP_REFERER');
						return $this->render('BaclooCrmBundle:Crm:buyfiche.html.twig', array(
										'vente'    => 'invitation',
										'previous' => $previous,
										'societe'  => $form->get('raisonsociale')->getData(),
										'grant'    => 'ok',
										'email'	   => $form->get('email')->getData(),
										'id'	   => $id
										));							  
					}
					elseif($pos === false)
					{
						$previous = $this->get('request')->server->get('HTTP_REFERER');
						return $this->render('BaclooCrmBundle:Crm:buyfiche.html.twig', array(
										'vente'    => 'badmail',
										'previous' => $previous,
										'grant'    => 'ok',
										'email'	   => $form->get('email')->getData(),
										'id'	   => $id
										));						
					}
					else
					{
						$previous = $this->get('request')->server->get('HTTP_REFERER');
						return $this->render('BaclooCrmBundle:Crm:buyfiche.html.twig', array(
										'vente'    => 'deja',
										'previous' => $previous,
										'grant'    => 'ok',
										'email'	   => $form->get('email')->getData(),
										'id'	   => $id
										));						
					}
							
				  }
					
				}//echo '3';
				$previous = $this->get('request')->server->get('HTTP_REFERER');
				return $this->render('BaclooCrmBundle:Crm:donemail.html.twig', array(
								'send'    => $send,
								'nom'    => $expediteur->getNom(),
								'prenom' => $expediteur->getPrenom(),
								'previous'=> $previous,
								'id'	  => 0,
								'form'    => $form->createView()
								));			
		}
		else
		{
			$fiche  = $em->getRepository('BaclooCrmBundle:Fiche')		
						  ->findOneById($id);	
	//echo '1';									   
			$donemail = new Donemail();
		
			$form = $this->createForm(new DonemailType(), $donemail);
	//echo '2';				// on soumet la requete
				$request = $this->getRequest();
				$send = 'nok';
				if ($request->getMethod() == 'POST') {
				// On fait le lien Requête <-> Formulaire
				  $form->bind($request);
				  if ($form->isValid()) 
				  {
					$today = date('Y-m-d');
					$donemail->setDate($today);				  
					$donemail->setEmail($form->get('email')->getData());
					$donemail->setFicheid($id);
					$donemail->setRaisonsociale($fiche->getRaisonSociale());
					$donemail->setParrainid($expediteur->getId());
					$donemail->setParrainpseudo($expediteur->getUsername());
					$em = $this->getDoctrine()->getManager();
					$em->persist($donemail);						   
						  $em->flush();

					// Partie envoi du mail
					// Récupération du service
					// $mailer = $this->get('mailer');				
					
						// $message = \Swift_Message::newInstance()
							// ->setSubject('Bacloo : Un nouveau message est arrivé')
							// ->setFrom(array('bacloo@bacloo.fr' => 'Bacloo CRM'))
							// ->setTo($form->get('email')->getData())
							// ->setBody($this->renderView('BaclooCrmBundle:Crm:new_donemail.html.twig', array('exp_nom' 	=> $expediteur->getNom(), 
																									 // 'exp_prenom'	=> $expediteur->getPrenom(),
																									 // 'email'		=> $form->get('email')->getData()
																									  // )));
						// $mailer->send($message);

					// Fin partie envoi mail

				//DEBUT CLONAGE PROCESS

						$session = $request->getSession();//echo '2';
						$controle5 = $session->get('controle5');//echo '4';
				//echo 'controle5--- = '.$controle5.'   ';				
						$controle5++;		
				//echo 'controle5 = '.$controle5.'   ';		
					if($controle5 == 1)
					{
						//On récupère l'id du vendeur			   
						$query = $em->createQuery(
							'SELECT u.id
							FROM BaclooUserBundle:User u
							WHERE u.username LIKE :username'
						);
						$query->setParameter('username', $usersess);				
						$vendeurid = $query->getSingleScalarResult();					   
				//echo '2';		

						//Si les crédits de l'acheteur sont inférieurs au prix d'achat
						//on retourne message crédits insufisants

						//Si les crédits sont suffisants ont valide la transaction
							$grant = 'ok';
							$today = date('Y-m-d');
							$vente = 'donemail';
						//Début clonage
							$fiche->getEvent()->clear();
							$textememo = '0';
							$copyfiche = clone $fiche;
							$Memo = $copyfiche->getMemo();//echo '2.4';
							if(isset($Memo))
							{				
								$em->detach($Memo);	//echo '2.5';	
							}
							$email = $form->get('email')->getData();
							$copyfiche->setCopyof($fiche->getId());		
							$copyfiche->setUser('x');
							$copyfiche->setTypefiche('prospect');
							$copyfiche->setAVendre('0');
							$copyfiche->setAVendrec('0');
							$copyfiche->setPrixsscont('0');
							$copyfiche->setPrixavcont('0');
							$copyfiche->setUseremail($email);
							
						
							$em->persist($copyfiche);	
			//echo '3';						
							$em->flush();


							$em = $this->getDoctrine()
									   ->getManager()
									   ->getRepository('BaclooCrmBundle:Fiche');
							// On récupère la fiche qui nous intéresse
							$fichecopy = $em->findOneBy(array('raisonSociale' => $fiche->getRaisonSociale(),
															  'useremail' => $email));
							$fichecopyid = $fichecopy->getId();
							// $em2 = $this->getDoctrine()
									   // ->getManager()
									   // ->getRepository('BaclooCrmBundle:Transac');
							// $transac = $em2->findOneByUserid($uid);
							$em = $this->getDoctrine()->getManager();
					$transac = $em->getRepository('BaclooCrmBundle:Transac')
								 ->findOneByVendeur('1234');
							if(empty($transac))
							{
							$transac = new Transac();
							$transac->setVendeur('1234');
							$transac->setAcheteur('1234');
							$em = $this->getDoctrine()->getManager();
							$em->persist($transac);
								
							}				
							$transaction = new Transaction();
							$transaction->setRaisonSociale($fiche->GetRaisonSociale());
							$transaction->setVendeur($fiche->GetUser());
							$transaction->setAcheteur($email);
							$transaction->setDate($today);
							$type = 'Don avec les contacts';
							$transaction->setPrix('0');
							$transaction->setTypetransac($type);			
							$transaction->setControle('1234');			
							$transaction->setFicheid($id);
							$transaction->setNficheid($fichecopyid);
							$transaction->addTransac($transac);
							$transac->addTransaction($transaction);
							$em = $this->getDoctrine()->getManager();
							$em->persist($transaction);
							$em->persist($transac);
							$fiche->getBrappels()->clear();			
							$em->flush();

												   
							$expediteur  = $em->getRepository('BaclooUserBundle:User')		
										   ->findOneByUsername($fiche->getUser());							   
						// Partie envoi du mail
						// Récupération du service
						$mailer = $this->get('mailer');				
						$exp_prenom = $expediteur->getPrenom();
						if(isset($exp_prenom))
						{
							$exp_prenom = $expediteur->getNom().' '.$expediteur->getPrenom();
						}
						else
						{
							$exp_prenom = $expediteur->getUsername();
						}
						
					// Partie envoi du mail
					// Récupération du service
						$mailer = $this->get('mailer');				
						
							$message = \Swift_Message::newInstance()
								->setSubject($exp_prenom.' a une piste commerciale pour vous')
								->setFrom(array($expediteur->getEmail() => $exp_prenom))
								->setTo($email)
								->setBody($this->renderView('BaclooCrmBundle:Crm:new_donemail.html.twig', array('exp_prenom'	=> $exp_prenom,
																										 'email'		=> $email
																										  )));
						$mailer->send($message);

						$mailer = $this->get('mailer');				
						
						$mailer = $this->get('mailer');				
						
							$message = \Swift_Message::newInstance()
								->setSubject($exp_prenom.' a une piste commerciale pour vous')
								->setFrom(array($expediteur->getEmail() => $exp_prenom))
								->setTo('ringuetjm@gmail.com')
								->setBody($this->renderView('BaclooCrmBundle:Crm:new_donemail.html.twig', array('exp_prenom'	=> $exp_prenom,
																										 'email'		=> $email
																										  )));
						$mailer->send($message);
						// Fin partie envoi mail	
				//FIN CLONAGE
						$controle5++;
						$session->set('controle5', $controle5);//echo '4';
						$previous = $this->get('request')->server->get('HTTP_REFERER');
						return $this->render('BaclooCrmBundle:Crm:buyfiche.html.twig', array(
										'vente'    => 'donemail',
										'previous'    => $previous,
										'grant'    => 'ok',
										'societe'	=> $fiche->GetRaisonSociale(),
										'email'	=> $email,
										'id'	   => $id
										));								
						}
						else
						{//echo 'zarb';
							return $this->redirect($this->generateUrl('bacloocrm_donemail'));				
						}
					}
					
				}//echo '3';
				return $this->render('BaclooCrmBundle:Crm:donemail.html.twig', array(
								'send'    => $send,
								'raison'  => $fiche->getRaisonSociale(),
								'id'	  => $fiche->getId(),
								'form'    => $form->createView()
								));
		}
	}

	public function compteclientAction()
	{
		$usersess = $this->get('security.context')->getToken()->getUsername();	
				$em = $this->getDoctrine()
					   ->getManager();	

		$query = $em->createQuery(
				'SELECT f.favusername
				FROM BaclooCrmBundle:Favoris f
				WHERE f.favusername = :favusername
				AND f.toutpart = :toutpart'
			)->setParameter('favusername', $usersess);
			$query->setParameter('toutpart', 1);
			$favoriall = $query->getResult();
			//echo 'cbien2 favoriall'.count($favoriall);

		//On créée un tableau sous le modèle 'user'=>$xxxx pour le repository
		if(isset($favoriall) && !empty($favoriall))
		{//echo 'liiiiiii';
			$i = 1;
			$b = 0;
			foreach($favoriall as $favo)
			{
				foreach($favo as $fav)
				{
				//echo 'favo'.$fav;
					$favor  = $em->getRepository('BaclooCrmBundle:Favoris')		
								   ->findOneByFavusername($usersess);						
					${'choix'.$i++} = $favor->getUsername();
				}
			}
			//echo 'choix1'.$choix1;
			$critere = array($usersess);
			
			for($j=1;$j<$i;$j++)
			{
				${'critere'.$j} = array(${"choix".$j});
				$critere = array_merge(${'critere'.$j},$critere);
			}
			
		}
		else
		{
			$b = 1;
			$critere = $usersess;
		}					   
					   
		$query = $em->createQuery(
		'SELECT f
		FROM BaclooCrmBundle:Fiche f
		WHERE f.user in (:user)
		AND f.typefiche = :typefiche
		ORDER BY f.raisonSociale ASC')
		->setParameter('user', $critere)	
		->setParameter('typefiche', 'client');					
		$fichesclient = $query->getResult();
		
		$nbclient = count($fichesclient);			

		return $this->render('BaclooCrmBundle:Crm:compteclient.html.twig', array(
						'nbclient'    => $nbclient
						));	
	}

	public function compteprospectAction()
	{
		$usersess = $this->get('security.context')->getToken()->getUsername();	
				$em = $this->getDoctrine()
					   ->getManager();	

		$query = $em->createQuery(
				'SELECT f.favusername
				FROM BaclooCrmBundle:Favoris f
				WHERE f.favusername = :favusername
				AND f.toutpart = :toutpart'
			)->setParameter('favusername', $usersess);
			$query->setParameter('toutpart', 1);
			$favoriall = $query->getResult();
			//echo 'cbien2 favoriall'.count($favoriall);

		//On créée un tableau sous le modèle 'user'=>$xxxx pour le repository
		if(isset($favoriall) && !empty($favoriall))
		{//echo 'liiiiiii';
			$i = 1;
			$b = 0;
			foreach($favoriall as $favo)
			{
				foreach($favo as $fav)
				{
				//echo 'favo'.$fav;
					$favor  = $em->getRepository('BaclooCrmBundle:Favoris')		
								   ->findOneByFavusername($usersess);						
					${'choix'.$i++} = $favor->getUsername();
				}
			}
			//echo 'choix1'.$choix1;
			$critere = array($usersess);
			
			for($j=1;$j<$i;$j++)
			{
				${'critere'.$j} = array(${"choix".$j});
				$critere = array_merge(${'critere'.$j},$critere);
			}
			
		}
		else
		{
			$b = 1;
			$critere = $usersess;
		}					   
					   
		$query = $em->createQuery(
		'SELECT f
		FROM BaclooCrmBundle:Fiche f
		WHERE f.user in (:user)
		AND f.typefiche = :typefiche
		ORDER BY f.raisonSociale ASC')
		->setParameter('user', $critere)	
		->setParameter('typefiche', 'prospect');					
		$fichesprospect = $query->getResult();

		$nbprospect = count($fichesprospect);			

			return $this->render('BaclooCrmBundle:Crm:compteprospect.html.twig', array(
							'nbprospect'    => $nbprospect
							));	
	}

	public function comptefournisseurAction()
	{
		$proprio = $this->get('security.context')->getToken()->getUsername();	
				$em = $this->getDoctrine()
					   ->getManager();	
				$query = $em->createQuery(
					'SELECT COUNT(f.id) as nbfournisseur
					FROM BaclooCrmBundle:Fiche f
					WHERE f.user = :user
					AND f.typefiche = :typefiche'
				);
				$query->setParameter('user', $proprio);
				$query->setParameter('typefiche', 'fournisseur');
		
				$nbfournisseur= $query->getSingleScalarResult();			

					return $this->render('BaclooCrmBundle:Crm:comptefournisseur.html.twig', array(
									'nbfournisseur'    => $nbfournisseur
									));	
	}

	public function comptesharedAction()
	{
		$user= $this->get('security.context')->getToken()->getUsername(); //if(empty($user) or !isset($user) or $user == 'anon.'){return $this->redirect($this->generateUrl('fos_user_security_login'));}	
		$em = $this->getDoctrine()->getManager();
		$nbshared = $em->getRepository('BaclooCrmBundle:Fiche')
					->count_shared_fiche($user);			

					return $this->render('BaclooCrmBundle:Crm:compteshared.html.twig', array(
									'nbshared'    => $nbshared
									));	
	}

	public function comptecorbeilleAction()
	{
		$proprio = $this->get('security.context')->getToken()->getUsername();	
				$em = $this->getDoctrine()
					   ->getManager();	
				$query = $em->createQuery(
					'SELECT COUNT(f.id) as nbcorbeille
					FROM BaclooCrmBundle:Fiche f
					WHERE f.user = :user
					AND f.typefiche = :typefiche'
				);
				$query->setParameter('user', $proprio);
				$query->setParameter('typefiche', 'corbeille');
		
				$nbcorbeille = $query->getSingleScalarResult();			

					return $this->render('BaclooCrmBundle:Crm:comptecorbeille.html.twig', array(
									'nbcorbeille'    => $nbcorbeille
									));	
	}
	
	public function compterappelsAction($type, $useracc, $mode, Request $request)
	{
		$user= $this->get('security.context')->getToken()->getUsername(); //if(empty($user) or !isset($user) or $user == 'anon.'){return $this->redirect($this->generateUrl('fos_user_security_login'));}	
		$session = $request->getSession();
		$du = $session->get('du');
		$au = $session->get('au');
		if(!isset($du) && !isset($au))
		{
			$du = '2013-01-01';
			$au = date('Y-m-d');
		}		
		$em = $this->getDoctrine()->getManager();
		if($type == 'accueil')
		{
			$user = $useracc;
		}
		if(is_array($user) == 1)
		{
			if($mode == 'chantier')
			{
				$nbrappels = $em->getRepository('BaclooCrmBundle:Chantier')
							->count_rappelsarray($du, $au, $user);
			}
			else
			{
				$nbrappels = $em->getRepository('BaclooCrmBundle:Fiche')
							->count_rappelsarray($du, $au, $user);
			}
		}
		else
		{
			if($mode == 'chantier')
			{
				$nbrappels = $em->getRepository('BaclooCrmBundle:Chantier')
							->count_rappels($du, $au, $user);	
			}
			else
			{
				$nbrappels = $em->getRepository('BaclooCrmBundle:Fiche')
							->count_rappels($du, $au, $user);	
			}
		}
					return $this->render('BaclooCrmBundle:Crm:compterappels.html.twig', array(
									'nbrappels'    => $nbrappels,
									'type'    => $type
									));	
	}
	
	public function comptea_faireAction($type, $useracc, $mode, Request $request)
	{
		$user= $this->get('security.context')->getToken()->getUsername(); if(empty($user) or !isset($user) or $user == 'anon.'){return $this->redirect($this->generateUrl('fos_user_security_login'));}	
		$session = $request->getSession();
		$du = $session->get('du');
		$au = $session->get('au');
		if(!isset($du) && !isset($au))
		{
			$du = '2013-01-01';
			$au = date('Y-m-d');
		}		
		$em = $this->getDoctrine()->getManager();
		if($type == 'accueil')
		{
			$user = $useracc;
		}
		if(is_array($user) == 1)
		{
			if($mode == 'chantier')
			{
				$nba_faire = $em->getRepository('BaclooCrmBundle:Chantier')
							->count_a_faire_array($du, $au, $user);	
			}
			else
			{
				$nba_faire = $em->getRepository('BaclooCrmBundle:Fiche')
							->count_a_faire_array($du, $au, $user);		
			}		
		}
		else
		{
			if($mode == 'chantier')
			{
				$nba_faire = $em->getRepository('BaclooCrmBundle:Chantier')
							->count_a_faire($du, $au, $user);	
			}
			else
			{
				$nba_faire = $em->getRepository('BaclooCrmBundle:Fiche')
							->count_a_faire($du, $au, $user);	
			}		
		}		


					return $this->render('BaclooCrmBundle:Crm:comptea_faire.html.twig', array(
									'nba_faire'    => $nba_faire,
									'type'    => $type
									));	
	}	
	public function compterdvAction($type, $useracc, $mode, Request $request)
	{
		$user= $this->get('security.context')->getToken()->getUsername(); if(empty($user) or !isset($user) or $user == 'anon.'){return $this->redirect($this->generateUrl('fos_user_security_login'));}	
		$session = $request->getSession();
		$du = $session->get('du');
		$au = $session->get('au');
		if(!isset($du) && !isset($au))
		{
			$du = '2013-01-01';
			$au = date('Y-m-d');
		}		
		$em = $this->getDoctrine()->getManager();
		if($type == 'accueil')
		{
			$user = $useracc;
		}
		if(is_array($user) == 1)
		{
			if($mode == 'chantier')
			{
				$nbrdv = $em->getRepository('BaclooCrmBundle:Chantier')
							->count_rdv_array($du, $au, $user);		
			}
			else
			{
				$nbrdv = $em->getRepository('BaclooCrmBundle:Fiche')
							->count_rdv_array($du, $au, $user);	
			}
		}
		else
		{
			if($mode == 'chantier')
			{
				$nbrdv = $em->getRepository('BaclooCrmBundle:Chantier')
							->count_rdv($du, $au, $user);	
			}
			else
			{
				$nbrdv = $em->getRepository('BaclooCrmBundle:Fiche')
							->count_rdv($du, $au, $user);
			}	
		}			
	

					return $this->render('BaclooCrmBundle:Crm:compterdv.html.twig', array(
									'nbrdv'    => $nbrdv,
									'type'    => $type
									));	
	}

	public function importAction()
	{
			return $this->render('BaclooCrmBundle:Crm:import_donnees.html.twig');		
	}

	public function importergrilleAction($ficheid, $mode)
	{
		$session = new Session();
		if(null !== $session->get('idfiche'))
		{
			$ficheid = $session->get('idfiche');//echo $ficheid;
		}
		return $this->render('BaclooCrmBundle:Crm:importergrille.html.twig',(array('id' => $ficheid, 'mode' => $mode)));		
	}

	public function exportAction()
	{
	$usersess = $this->get('security.context')->getToken()->getUsername(); if(empty($usersess) or !isset($usersess) or $usersess == 'anon.'){return $this->redirect($this->generateUrl('fos_user_security_login'));}//Récupère le nom d'utilisateur

	include('societe.php');	
	$em = $this->getDoctrine()->getManager();
	// si user pas dans modules on créé sa ligne module avec les infos user
	$modules  = $em->getRepository('BaclooCrmBundle:Modules')		
				   ->findOneByUsername($usersess);		
	$userdetails  = $em->getRepository('BaclooUserBundle:User')		
		   ->findOneBy(array('roleuser'=> 'admin', 'usersociete' => $societe));
	$credits = $userdetails->getCredits();
	$pseudoadmin = $userdetails->getUsername();
	
		if($usersess != $pseudoadmin && !empty($modules) && $modules->getBbuseractivation() == 0)
		{
			return $this->redirect($this->generateUrl('bacloocrm_user_restreint'));
		}	
	
			return $this->render('BaclooCrmBundle:Crm:export_donnees.html.twig', array('user' => $usersess));	
	}

Public function partenairesAction($modepart, Request $request)
	{ 
		// echo 'fonctionne';
			$usersess = $this->get('security.context')->getToken()->getUsername(); if(empty($usersess) or !isset($usersess) or $usersess == 'anon.'){return $this->redirect($this->generateUrl('fos_user_security_login'));}		
		// On récupère les activités connexes
			$em = $this->getDoctrine()->getManager();	
			$user  = $em->getRepository('BaclooUserBundle:User')		
						   ->findOneByUsername($usersess);
			$acticouser = $user->getActconnexes();
			$id = $user->getId();

		// Ouverture de la session
			$session = new Session();
			$session = $request->getSession();

		// On affecte l'id utilisateur
			$session->set('iduser', $id);
			//$session->set('init', '1');//on est en recherche	
			
		// On traite la chaine de caractère des activités connexes de manière à les insérer dans un tableau $activites_connexes sans les virgules et autres				   
			$splitby = array(',',', ',' , ',' ,');
			$text = $acticouser;
			$pattern = '/\s'.implode($splitby, '\s?|\s?').'\s?/';
			$listactico = preg_split($pattern, $text, -1, PREG_SPLIT_NO_EMPTY);	
			// print_r($listactico);					   
		
		
			//$listactico = preg_split("/\s|[\s,]+|\s?de\s?|\s?du\s?|\s?avec\s?|\s?dans\s?|\s?pour\s?|\s?des\s?|\s?les\s?/", $acticouser);
			// print_r($listactico);
			
		// Partie liste activités 2 cas de figure :
		// - Activités connexes nulles
		// - Activités connexes Existantes
		
		// Si cet utilisateur n'a pas de listactico on ne fait rien
		// Si la fiche utilisateur a le champs activités connexes renseigné, on récupère les termes dans un tableau et on rempli la table
		// $Partenaires
		
				if(!empty($listactico))
				{
				// On récupère la liste des utilisateurs déjà dans la table $partenaires
					$partenaires  = $em->getRepository('BaclooCrmBundle:Partenaires')		
								   ->findByUserid($id);						
				}
				// Pour chaque activité connexe
				// On sort la liste des utilisateurs ayant dezs activités correspondantes
				
					$i = 0;
					foreach($listactico as $act)
					{				
						$i++;
						$query = $em->createQuery(
							'SELECT u 
							FROM BaclooUserBundle:User u
							WHERE u.activite = :activite
							Group By u.id'
						);
						$query->setParameter('activite', '%'.$act.'%');
						
				//Liste des users ayant les activités connexes qui correspondent
						$list_partspot = $query->getResult();					
						//print_r($list_partspot);
						
				//Si il y a déjà des utilisateurs dans la table $partenaires on les comparent au résultat de la recherche
							if(!empty($partenaires))
							{
							//Pour chaque utilisateur avec les activités connexes de la fiche
								foreach($list_partspot as $lfp)
								{
								// On regarde s'il est présent dans la table $partenaires	
									foreach($partenaires as $lif)
									{
										$fichecheck  = $em->getRepository('BaclooCrmBundle:Partenaires')		
													 ->findOneBy(array('userid'=> $id, 'partpotid' => $lfp->GetId()));									

									// S'il n'est pas présent on l'insère
											if(!isset($fichecheck))
											{					
												$diff = '1';
													$Partenaires = new Partenaires();
													$Partenaires->setUserid($id);
													$Partenaires->setUsername($usersess);	
													$Partenaires->setUseractco($acticouser);	
													$Partenaires->setUsertags($user->getTags());	
													$Partenaires->setUserdescrech($user->getDescrech());
													$Partenaires->setUseractvise($user->getActvise());
													$Partenaires->setPartactvise($lfp->GetActvise());
													$Partenaires->setUseractivite($user->getActivite());
													$Partenaires->setPartpotid($lfp->GetId());
													$Partenaires->setPartpotUsername($lfp->GetUsername());
													$Partenaires->setActipart($lfp->GetActivite());
													$Partenaires->setDescrech($lfp->GetDescRech());
													$Partenaires->setTags($lfp->GetTags());
													$Partenaires->setActicon($lfp->GetActconnexes());
													$Partenaires->setPartenaire(0);

													$em = $this->getDoctrine()->getManager();
													$em->persist($Partenaires);
													$em->flush();																		
											}
									}
										
								}
							}

					//Si il n'y a pas d'utilisateurs dans la table $partenaires on les rajoute d'office		
							else
							{
								foreach($list_partspot as $lfp)
								{	
											$diff = '1';
													$Partenaires = new Partenaires();
													$Partenaires->setUserid($id);
													$Partenaires->setUsername($usersess);	
													$Partenaires->setUseractco($acticouser);	
													$Partenaires->setUsertags($user->getTags());	
													$Partenaires->setUserdescrech($user->getDescrech());
													$Partenaires->setUseractvise($user->getActvise());
													$Partenaires->setPartactvise($lfp->GetActvise());
													$Partenaires->setUseractivite($user->getActivite());
													$Partenaires->setPartpotid($lfp->GetId());
													$Partenaires->setPartpotUsername($lfp->GetUsername());
													$Partenaires->setActipart($lfp->GetActivite());
													$Partenaires->setDescrech($lfp->GetDescRech());
													$Partenaires->setTags($lfp->GetTags());
													$Partenaires->setActicon($lfp->GetActconnexes());
													$Partenaires->setPartenaire(0);

												$em = $this->getDoctrine()->getManager();
												$em->persist($Partenaires);
												$em->flush();
								}
							}
						
					}						
					// Si diff = 1 on envoie un mail disant qu'il y a de nouveaux partenaires potentiels détectés ?
						if(isset($diff) && $diff == 1)
						{
						// Partie envoi du mail
						// Récupération du service
							$mailer = $this->get('mailer');								
								$message = \Swift_Message::newInstance()
									->setSubject('Bacloo : Nouveaux Partenaires Commerciaux détectés')
									->setFrom(array('bacloo@bacloo.fr' => 'Bacloo CRM'))
									->setTo($user->getEmail())
									->setBody($this->renderView('BaclooCrmBundle:Crm:new_part.html.twig', array('dest_prenom'	=> $user->getPrenom(),
																											 'diff'	=> $diff
																											  )))
								;
								$mailer->send($message);
						// Fin partie envoi mail
						}
		if($modepart == 'partpot')
		{//echo 'ici';
			unset($partenaires);
			if(!isset($page)){$page = 1;}
			$partenaires  = $em->getRepository('BaclooCrmBundle:Partenaires')		
			   				   ->showpartenaires($id, $modepart, '0', 20, $page);

			return $this->render('BaclooCrmBundle:Crm:partpot.html.twig', array('partenaires' => $partenaires,
																				'modepart' => $modepart));
		}
		elseif($modepart == 'partenaires')
		{
			if(!isset($page)){$page = 1;}
			unset($partenaires);
			$partenairess  = $em->getRepository('BaclooCrmBundle:Partenaires')		
			   				   ->showpartenaires($id, $modepart, 'ok', 20, $page);	
			unset($partenaires);   
			$partenaires_attente = $em->getRepository('BaclooCrmBundle:Partenaires')
							->findBy(array('partpotid' => $id, 'partenaire' => 1));
			$i = 0;				   
			foreach($partenaires_attente as $parta){$i++;}//echo '$i'.$i;
			return $this->render('BaclooCrmBundle:Crm:partpot.html.twig', array('partenaires' => $partenairess,
																				'partenaires_attente' => $partenaires_attente,
																				'check' => $i,
																				'modepart' => $modepart));		
		}
	}
	
	public function showpartpotAction(Request $request)
	{
		$usersess = $this->get('security.context')->getToken()->getUsername();
	// On récupère les activités connexes
					//Pour count partenaires
					$refreshpart = $this->get('session')->get('countpart');
					if(isset($refreshpart))
					{
						//ne pas faire le refresh
						$i = $refreshpart;
					}
					else
					{
						//Lancer la requête
							$em = $this->getDoctrine()->getManager();

								$user  = $em->getRepository('BaclooUserBundle:User')		
											   ->findOneByUsername($usersess);
								$acticouser = $user->getActconnexes();
									$id = $user->getId();

								// Ouverture de la session
									$session = new Session();
									$session = $request->getSession();

								// On affecte l'id utilisateur
									$session->set('iduser', $id);
									//$session->set('init', '1');//on est en recherche	
									
								// On traite la chaine de caractère des activités connexes de manière à les insérer dans un tableau $activites_connexes sans les virgules et autres				   
									$splitby = array(',',', ',' , ',' ,');
									$text = $acticouser;
									$pattern = '/\s'.implode($splitby, '\s?|\s?').'\s?/';
									$listactico = preg_split($pattern, $text, -1, PREG_SPLIT_NO_EMPTY);	
									//print_r($listactico);					   
								
								
									//$listactico = preg_split("/\s|[\s,]+|\s?de\s?|\s?du\s?|\s?avec\s?|\s?dans\s?|\s?pour\s?|\s?des\s?|\s?les\s?/", $acticouser);
									// print_r($listactico);
									
								// Partie liste activités 2 cas de figure :
								// - Activités connexes nulles
								// - Activités connexes Existantes
								
								// Si cet utilisateur n'a pas de listactico on ne fait rien
								// Si la fiche utilisateur a le champs activités connexes renseigné, on récupère les termes dans un tableau et on rempli la table
								// $Partenaires
								
										if(!empty($listactico))
										{
										// On récupère la liste des utilisateurs déjà dans la table $partenaires
											$partenaires  = $em->getRepository('BaclooCrmBundle:Partenaires')		
														   ->findByUserid($id);						
										}
										// Pour chaque activité connexe
										// On sort la liste des utilisateurs ayant des activités correspondantes
										
											$i = 0;
											foreach($listactico as $act)
											{//echo '   aaa'.$act;				
												$i++;
												$query = $em->createQuery(
													'SELECT u 
													FROM BaclooUserBundle:User u
													WHERE u.activite LIKE :activite
													AND u.id != :id
													Group By u.id'
												);
												$query->setParameter('activite', '%'.$act.'%');
												$query->setParameter('id', $id);
												
										//Liste des users ayant les activités connexes qui correspondent
												$list_partspot = $query->getResult();					
												//print_r($list_partspot);
												
										//Si il y a déjà des utilisateurs dans la table $partenaires on les comparent au résultat de la recherche
													if(!empty($partenaires))
													{
													//Pour chaque utilisateur avec les activités connexes de la fiche
														foreach($list_partspot as $lfp)
														{//echo 'xxxxxxxxxxxxxxxx';
														// On regarde s'il est présent dans la table $partenaires	
															foreach($partenaires as $lif)
															{
																$fichecheck  = $em->getRepository('BaclooCrmBundle:Partenaires')		
																			 ->findOneBy(array('userid'=> $id, 'partpotid' => $lfp->GetId()));									

															// S'il n'est pas présent on l'insère
																	if(!isset($fichecheck))
																	{	//echo 'AAAAAA';				
																		$diff = '1';
																			$Partenaires = new Partenaires();
																			$Partenaires->setUserid($id);
																			$Partenaires->setUsername($usersess);	
																			$Partenaires->setUseractco($acticouser);	
																			$Partenaires->setUsertags($user->getTags());	
																			$Partenaires->setUserdescrech($user->getDescrech());
																			$Partenaires->setUseractvise($user->getActvise());
																			$Partenaires->setPartactvise($lfp->GetActvise());
																			$Partenaires->setUseractivite($user->getActivite());
																			$Partenaires->setPartpotid($lfp->GetId());
																			$Partenaires->setPartpotUsername($lfp->GetUsername());
																			$Partenaires->setActipart($lfp->GetActivite());
																			$Partenaires->setDescrech($lfp->GetDescRech());
																			$Partenaires->setTags($lfp->GetTags());
																			$Partenaires->setActicon($lfp->GetActconnexes());
																			$Partenaires->setPartenaire(0);

																			$em = $this->getDoctrine()->getManager();
																			$em->persist($Partenaires);
																			$em->flush();																		
																	}
															}
																
														}
													}

											//Si il n'y a pas d'utilisateurs dans la table $partenaires on les rajoute d'office		
													else
													{
														foreach($list_partspot as $lfp)
														{	//echo'kkkkkkkkkkkkkkkkkkk';
																	$diff = '1';
																			$Partenaires = new Partenaires();
																			$Partenaires->setUserid($id);
																			$Partenaires->setUsername($usersess);	
																			$Partenaires->setUseractco($acticouser);	
																			$Partenaires->setUsertags($user->getTags());	
																			$Partenaires->setUserdescrech($user->getDescrech());
																			$Partenaires->setUseractvise($user->getActvise());
																			$Partenaires->setPartactvise($lfp->GetActvise());
																			$Partenaires->setUseractivite($user->getActivite());
																			$Partenaires->setPartpotid($lfp->GetId());
																			$Partenaires->setPartpotUsername($lfp->GetUsername());
																			$Partenaires->setActipart($lfp->GetActivite());
																			$Partenaires->setDescrech($lfp->GetDescRech());
																			$Partenaires->setTags($lfp->GetTags());
																			$Partenaires->setActicon($lfp->GetActconnexes());
																			$Partenaires->setPartenaire(0);

																		$em = $this->getDoctrine()->getManager();
																		$em->persist($Partenaires);
																		$em->flush();
														}
													}
												
											}						
											// Si diff = 1 on envoie un mail disant qu'il y a de nouveaux partenaires potentiels détectés ?
												if(isset($diff) && $diff == 1)
												{
												// Partie envoi du mail
												// Récupération du service
													$mailer = $this->get('mailer');								
														$message = \Swift_Message::newInstance()
															->setSubject('Bacloo : Nouveaux Partenaires Commerciaux détectés')
															->setFrom(array('bacloo@bacloo.fr' => 'Bacloo CRM'))
															->setTo($user->getEmail())
															->setBody($this->renderView('BaclooCrmBundle:Crm:new_part.html.twig', array('dest_prenom'	=> $user->getPrenom(),
																																	 'diff'	=> $diff
																																	  )))
														;
														$mailer->send($message);
												// Fin partie envoi mail
												}
							unset($partenaires);//echo 'idid'.$id;
							$partpotlist = $em->getRepository('BaclooCrmBundle:Partenaires')
												->showpartpot($id);
								if(isset($partpotlist))
								{//echo 'iciciciii';
									$i = 0;

										foreach($partpotlist as $pl)
										{//echo 'x'.$pl->getId();
												$i++;
										}
								}
								else
								{//echo'lalalaal';
								$i = 0;
								}
						//maj la valeur fichesvendables en session
						$this->get('session')->set('countpart', $i);
					}//echo 'iiiiiiiiiiiiiiiiiiiiii'.$i;
					return $this->render('BaclooCrmBundle:Crm:boutonpartpot.html.twig', array(
								'partpot' => $i
					));
					
	}

	public function showpartatAction(Request $request)
	{
		$session = $request->getSession();
		$id = $session->get('iduser');
		
		$em = $this->getDoctrine()->getManager();	
		$partat = $em->getRepository('BaclooCrmBundle:Partenaires')
							->findBy(array('partpotid' => $id, 'partenaire' => 1));
			if(isset($partat))
			{//echo 'iciciciii';
				$i = 0;

					foreach($partat as $pl)
					{//echo 'x'.$pl->getId();
							$i++;
					}
			}
			else
			{//echo'lalalaal';
			$i = 0;
			}//echo 'iiiiiiiiiiiiiiiiiiiiii'.$i;
					return $this->render('BaclooCrmBundle:Crm:boutonpartat.html.twig', array(
								'partat' => $i,
								'vuestyle' => 'accueil'
					));	
	}
	public function removepartAction($id, Request $request)
	{//$id = id ligne partenaire
		$session = $request->getSession();
		$uid = $session->get('iduser');
		
		$em = $this->getDoctrine()->getManager();
		//On la vire des fiches vendables
		$partenaires1  = $em->getRepository('BaclooCrmBundle:Partenaires')		
					   ->findOneByid($id);
		//echo $id;
		
		$idpartenaires2  = $em->getRepository('BaclooCrmBundle:Partenaires')		
					   ->trouvepart2($partenaires1->GetPartpotid(), $partenaires1->GetUserid());

		$partenaires2  = $em->getRepository('BaclooCrmBundle:Partenaires')		
					   ->findOneByid($idpartenaires2);

			if(isset($partenaires1))
			{//echo 'ici';
				$em->remove($partenaires1);
			}

		// $remid = $partenaires2->getId();echo 'trrr'.$remid;							  
					   
			if(isset($partenaires2))
			{//echo 'la';
				$em->remove($partenaires2);
			}
			$em->flush();	
			$page = 1;	
			$partenaires  = $em->getRepository('BaclooCrmBundle:Partenaires')		
							   ->showpartenaires($uid, 'partenaires', 'ok', 20, $page);

			return $this->redirect($this->generateUrl('bacloocrm_showpartlist', array('modepart' => 'partenaires')));		
					
	}
	
	public function nofollowpartAction($id, Request $request)
	{//$id = id ligne partenaire
		$session = $request->getSession();
		$uid = $session->get('iduser');
		
		$em = $this->getDoctrine()->getManager();
		//On la vire des fiches vendables
		$partenaires1  = $em->getRepository('BaclooCrmBundle:Partenaires')		
					   ->findOneByid($id);

			if(isset($partenaires1))
			{
				$partenaires1->setPartenaire('nok');
				$em->flush();	
			}
			$page = 1;	
			$partenaires  = $em->getRepository('BaclooCrmBundle:Partenaires')		
							   ->showpartenaires($uid, 'partenaires', 'ok', 20, $page);

			return $this->render('BaclooCrmBundle:Crm:partpot.html.twig', array('partenaires' => $partenaires,
																				'modepart' => 'partpot'));		
					
	}
	
	public function followpartAction($id, Request $request)
	{//$id = id ligne partenaire
	
		$em = $this->getDoctrine()->getManager();
		//On la vire des fiches vendables
		$partenaires1  = $em->getRepository('BaclooCrmBundle:Partenaires')		
					   ->findOneByid($id);

			if(isset($partenaires1))
			{
				$partenaires1->setPartenaire('ok');
				$Partenaires = new Partenaires();
				$Partenaires->setUserid($partenaires1->GetPartpotid());
				$Partenaires->setUsername($partenaires1->GetPartpotUsername());	
				$Partenaires->setUseractco($partenaires1->GetActicon());	
				$Partenaires->setUsertags($partenaires1->GetTags());	
				$Partenaires->setUserdescrech($partenaires1->GetDescrech());
				$Partenaires->setUseractvise($partenaires1->GetPartactvise());
				$Partenaires->setPartactvise($partenaires1->GetUseractvise());
				$Partenaires->setUseractivite($partenaires1->GetActipart());
				$Partenaires->setPartpotid($partenaires1->GetUserid());
				$Partenaires->setPartpotUsername($partenaires1->GetUsername());
				$Partenaires->setActipart($partenaires1->GetUseractivite());
				$Partenaires->setDescrech($partenaires1->GetDescRech());
				$Partenaires->setTags($partenaires1->GetUsertags());
				$Partenaires->setActicon($partenaires1->GetUseractco());
				$Partenaires->setPartenaire('ok');

				$em = $this->getDoctrine()->getManager();
				$em->persist($Partenaires);
				$em->flush();	
			}
			$page = 1;	
			$partenaires  = $em->getRepository('BaclooCrmBundle:Partenaires')		
							   ->showpartenaires($partenaires1->GetPartpotid(), 'partenaires', 'ok', 20, $page);
  
			$partenaires_attente = $em->getRepository('BaclooCrmBundle:Partenaires')
							->findBy(array('partpotid' => $partenaires1->GetPartpotid(), 'partenaire' => 1));
			$i = 0;				   
			foreach($partenaires_attente as $parta){$i++;}//echo '$i'.$i;
			return $this->render('BaclooCrmBundle:Crm:partpot.html.twig', array('partenaires' => $partenaires,
																				'partenaires_attente' => $partenaires_attente,
																				'check' => $i,
																				'modepart' => 'partenaires'));		
					
	}
	
	public function askpartAction($id, $partpotid, $modepart, Request $request)
	{//$id = id ligne partenaire
		$session = $request->getSession();
		$uid = $session->get('iduser');
		
		$em = $this->getDoctrine()->getManager();
		//On la vire des fiches vendables
		if($modepart == 'partpot')
		{
			$partenaires1  = $em->getRepository('BaclooCrmBundle:Partenaires')		
						   ->findOneByid($id);

				if(isset($partenaires1))
				{
					$partenaires1->setPartenaire('1');
					$em->flush();	
				}
			$page = 1;	
			$partenaires  = $em->getRepository('BaclooCrmBundle:Partenaires')		
							   ->showpartenaires($uid, 'partpot', '0', 20, $page);

			// return $this->render('BaclooCrmBundle:Crm:partpot.html.twig', array('partenaires' => $partenaires,
																				// 'modepart' => 'partpot'));				
		}
		elseif($modepart == 'bigsearch')
		{
		//id = id de du partpot
		//$uid = id user connecté
			$partpot  = $em->getRepository('BaclooUserBundle:User')		
						   ->findOneByid($id);
						   
			$user  = $em->getRepository('BaclooUserBundle:User')		
						   ->findOneByid($uid);

			$Partenaires = new Partenaires();
			$Partenaires->setUserid($uid);
			$Partenaires->setUsername($user->GetUsername());	
			$Partenaires->setUseractco($user->GetActconnexes());	
			$Partenaires->setUsertags($user->getTags());	
			$Partenaires->setUserdescrech($user->getDescrech());
			$Partenaires->setUseractvise($user->getActvise());
			$Partenaires->setPartactvise($partpot->GetActvise());
			$Partenaires->setUseractivite($user->getActivite());
			$Partenaires->setPartpotid($partpot->GetId());
			$Partenaires->setPartpotUsername($partpot->GetUsername());
			$Partenaires->setActipart($partpot->GetActivite());
			$Partenaires->setDescrech($partpot->GetDescRech());
			$Partenaires->setTags($partpot->GetTags());
			$Partenaires->setActicon($partpot->GetActconnexes());
			$Partenaires->setPartenaire(1);

			$em->persist($Partenaires);
			$em->flush();	
			$page = 1;	
			$partenaires  = $em->getRepository('BaclooCrmBundle:Partenaires')		
							   ->showpartenaires($uid, 'partpot', '0', 20, $page);

			return $this->redirect($this->generateUrl('bacloocrm_finduser', array('id' => $partpotid, 'mode' => 'bigsearch')));						
		}
		
					
	}

	public function publisharticleAction($artvue, Request $request)
	{
		$usersess = $this->get('security.context')->getToken()->getUsername(); if(empty($usersess) or !isset($usersess) or $usersess == 'anon.'){return $this->redirect($this->generateUrl('fos_user_security_login'));}//Récupère le nom d'utilisateur

		// On crée un objet Articles
		$articles = new Articles;
		$today = date('Y-m-d');//echo $today;
		$form = $this->createForm(new ArticlesType(), $articles);
		$request = $this->getRequest();
			if ($request->getMethod() == 'POST') {
			  $form->bind($request);
				if ($form->isValid()) {
					// On Flush la recherche
					$em = $this->getDoctrine()->getManager();
					$articles->setDate($today);
					$em->persist($articles);		
					// on flush le tout
					$em->flush();
							// Partie envoi du mail
							// Récupération du service
								$mailer = $this->get('mailer');	
								$data = $form->getData();
									$message = \Swift_Message::newInstance()
										->setSubject('Bacloo : Un message a été publié sur la timeline')
										->setFrom(array('bacloo@bacloo.fr' => 'Bacloo CRM'))
										->setTo('ringuetjm@gmail.com')
										->setBody($this->renderView('BaclooCrmBundle:Crm:alertmessage.html.twig', array('message' =>$data->GetTexte(),
																														'auteur' =>$data->GetAuteur(),
																														'titre' =>$data->GetTitre())))
									;
									$mailer->send($message);
							// Fin partie envoi mail
					
						if($artvue == 'accueil')
						{
							return $this->redirect($this->generateUrl('bacloocrm_communication')); 
						}
						else
						{
							return $this->redirect($this->generateUrl('bacloocrm_articles')); 
						}
					// si on est sur la page d'accueil on redirige vers celle-ci sinon vers la page des articles 
				}
			}

		if($artvue == 'accueil')
		{//echo 'accueil';
			return $this->render('BaclooCrmBundle:Crm:publisharticle.html.twig', array('artvue' => 'accueil',
																					   'date' => $today,
																					   'auteur' => $usersess,
																					   'form' => $form->createView()
																					));
		}
		elseif($artvue == 'articles')
		{//echo 'articles';
			return $this->render('BaclooCrmBundle:Crm:articles.html.twig',  array('artvue' => 'articles',
																				  'date' => $date,
																				  'auteur' => $usersess,
																				  'form' => $form->createView()
																					));
		}							
	}
	
	public function showarticlesAction()
	{
		$user= $this->get('security.context')->getToken()->getUsername(); if(empty($user) or !isset($user) or $user == 'anon.'){return $this->redirect($this->generateUrl('fos_user_security_login'));}		
		$em = $this->getDoctrine()->getManager();
		
		$query = $em->createQuery(
			'SELECT u.id
			FROM BaclooUserBundle:User u
			WHERE u.username = :username'
		)->setParameter('username', $user);
		$uid = $query->getSingleScalarResult();

		$query = $em->createQuery(
			'SELECT p
			FROM BaclooCrmBundle:Partenaires p
			WHERE p.username = :username'
		)->setParameter('username', $user);
		$partenaires = $query->getResult();		
		$articles = $em->getRepository('BaclooCrmBundle:Articles')
						  ->showarticle($partenaires, $user);
		

			return $this->render('BaclooCrmBundle:Crm:showarticles.html.twig', array(
							'articles'    => $articles,
							'user'    	  => $user
							));					
	}

	public function editarticleAction($id)
	{
		$usersess = $this->get('security.context')->getToken()->getUsername(); if(empty($usersess) or !isset($usersess) or $usersess == 'anon.'){return $this->redirect($this->generateUrl('fos_user_security_login'));}//Récupère le nom d'utilisateur
		$previous = $this->get('request')->server->get('HTTP_REFERER');
		// On crée un objet Articles
		$em = $this->getDoctrine()->getManager();
		$articles = $em->getRepository('BaclooCrmBundle:Articles')		
					 ->findOneById($id);
		$form = $this->createForm(new ArticlesType(), $articles);
		$request = $this->getRequest();
			if ($request->getMethod() == 'POST') {
			  $form->bind($request);
				if ($form->isValid()) {
					// On Flush la recherche
		
					$em->persist($articles);		
					// on flush le tout
					$em->flush();
					// si on est sur la page d'accueil on redirige vers celle-ci sinon vers la page des articles 

				return $this->render('BaclooCrmBundle:Crm:editarticle.html.twig', array('edit' => 'ok',
																						   'auteur' => $usersess,
																						   'id' => $id,
																						   'previous' => $previous,
																						   'form' => $form->createView()
																						));					
				}
			}

			return $this->render('BaclooCrmBundle:Crm:editarticle.html.twig', array('auteur' => $usersess,
																					   'previous' => $previous,
																					   'id' => $id,
																					   'form' => $form->createView()
																					));
						
	}
	
	public function shareAction($id)
	{
		$usersess = $this->get('security.context')->getToken()->getUsername(); if(empty($usersess) or !isset($usersess) or $usersess == 'anon.'){return $this->redirect($this->generateUrl('fos_user_security_login'));}//Récupère le nom d'utilisateur
		$previous = $this->get('request')->server->get('HTTP_REFERER');
		$today = date('Y-m-d');//echo $today;
		// On crée un objet Articles
		$em = $this->getDoctrine()->getManager();
		$article = $em->getRepository('BaclooCrmBundle:Articles')		
					 ->findOneById($id);

					$articles = new articles();
					$articles->setDate($today);
					$articles->setTexte($article->getTexte());
					$articles->setAuteur($article->getAuteur());
					$articles->setSharepartenaire('1');
					$articles->setTitre($article->getTitre());
					$articles->setCategorie($article->getCategorie());
					$articles->setShare('1');
					$articles->setTransfereur($usersess);
					$em->persist($articles);		
					// on flush le tout
					$em->flush();
					// si on est sur la page d'accueil on redirige vers celle-ci sinon vers la page des articles 

				return $this->render('BaclooCrmBundle:Crm:sharearticle.html.twig', array('previous' => $previous
																						));
	}

	public function removeartAction($id)
	{//$id = id ligne partenaire
		$em = $this->getDoctrine()->getManager();
		
		$article  = $em->getRepository('BaclooCrmBundle:Articles')		
					   ->findOneByid($id);

		if(isset($article))
		{//echo 'ici';
			$em->remove($article);
		}

			$em->flush();	
		return $this->render('BaclooCrmBundle:Crm:removearticle.html.twig');		
					
	}

	public function showblogAction()
	{
	
		$em = $this->getDoctrine()->getManager();

		$query = $em->createQuery(
			'SELECT b
			FROM BaclooCrmBundle:Blog b
			ORDER BY b.id DESC'
		)->setMaxResults(5);
		$blog = $query->getResult();

			return $this->render('BaclooCrmBundle:Crm:showblogarticles.html.twig', array(
							'blog'    => $blog
							));					
	}

	public function replyartAction($id)
	{
		$usersess = $this->get('security.context')->getToken()->getUsername(); if(empty($usersess) or !isset($usersess) or $usersess == 'anon.'){return $this->redirect($this->generateUrl('fos_user_security_login'));}//Récupère le nom d'utilisateur
		$previous = $this->get('request')->server->get('HTTP_REFERER');
		$today = date('Y-m-d');//echo $today;
		// On crée un objet Articles
		$em = $this->getDoctrine()->getManager();
		$articlo = $em->getRepository('BaclooCrmBundle:Articles')		
					 ->findOneById($id);		
		$request = $this->getRequest();
			if ($request->getMethod() == 'POST') {
			$articles = new Articles;
			$form = $this->createForm(new ArticlesType(), $articles);				
			  $form->bind($request);
				if ($form->isValid()) {
					// On Flush la recherche
					$articles->setDate($today);
					$articles->setCategorie($articlo->getCategorie());
					$em->persist($articles);		
					// on flush le tout
					$em->flush();
					// si on est sur la page d'accueil on redirige vers celle-ci sinon vers la page des articles 

				return $this->render('BaclooCrmBundle:Crm:communication.html.twig');					
				}
			}

		$articles = new Articles;
		$form = $this->createForm(new ArticlesType(), $articles);

			return $this->render('BaclooCrmBundle:Crm:replyarticle.html.twig', array('user' => $usersess,
																					   'previous' => $previous,
																					   'article' => $articlo,
																					   'today' => $today,
																					   'id' => $id,
																					   'form' => $form->createView()
																					));
						
	}
	
	public function removeficheAction($id, $check)
	{//$id = id ligne partenaire
		$em = $this->getDoctrine()->getManager();
		$previous = $this->get('request')->server->get('HTTP_REFERER');

		if($check == '0')
		{
			return $this->render('BaclooCrmBundle:Crm:removefiche.html.twig', array('id' => $id,
																					'previous' => $previous,
																					'check' => 1));	
		}
		elseif($check == 'ok')
		{
				$fiche  = $em->getRepository('BaclooCrmBundle:Fiche')		
							   ->findOneByid($id);			
				$em->remove($fiche);	
			$em->flush();	
			return $this->render('BaclooCrmBundle:Crm:removefiche.html.twig', array('check' => $check));				
		}				
	}

	public function showlistinvitationsAction($page)
	{
		$usersess = $this->get('security.context')->getToken()->getUsername(); if(empty($usersess) or !isset($usersess) or $usersess == 'anon.'){return $this->redirect($this->generateUrl('fos_user_security_login'));}//Récupère le nom d'utilisateur
			
		$em = $this->getDoctrine()->getManager();

		$invitations = $em->getRepository('BaclooCrmBundle:Donemail')		
							   ->showinvitations(20, $page, $usersess);

		return $this->render('BaclooCrmBundle:Crm:showinvitations.html.twig', array(
							'invitations' => $invitations,
							'nbinvit'     => count($invitations),
							'nombrePage'  => ceil(count($invitations)/20),
							'page'        => $page
							));					
	}
	
	public function showlistfilleulsAction($page)
	{
		$usersess = $this->get('security.context')->getToken()->getUsername(); if(empty($usersess) or !isset($usersess) or $usersess == 'anon.'){return $this->redirect($this->generateUrl('fos_user_security_login'));}//Récupère le nom d'utilisateur
			
		$em = $this->getDoctrine()->getManager();

		$filleuls = $em->getRepository('BaclooUserBundle:User')		
							   ->recupfilleuls($usersess, 20, $page);

		return $this->render('BaclooCrmBundle:Crm:showfilleuls.html.twig', array(
							'filleuls'    => $filleuls,
							'nbfilleuls'     => count($filleuls),
							'nombrePage'  => ceil(count($filleuls)/20),
							'page'        => $page
							));						
	}
	
	public function speedpartageAction($id, Request $request)
	{
		$usersess = $this->get('security.context')->getToken()->getUsername(); if(empty($usersess) or !isset($usersess) or $usersess == 'anon.'){return $this->redirect($this->generateUrl('fos_user_security_login'));}//Récupère le nom d'utilisateur
		$previous = $this->get('request')->server->get('HTTP_REFERER');	
		$defaultData = array();
		$form = $this->createFormBuilder($defaultData)
			->add('pseudo', 'text', array('required' => false))
			->getForm();

		$form->handleRequest($request);

		if ($form->isValid()) {
				// echo 'XXXXXXXXXXXXXXXX';		
				// Les données sont un tableau avec les clés "name", "email", et "message"
				$data = $form->getData();
					// Partie envoi du mail
					// Récupération du service
			$user = $data['pseudo']; //echo 'uuuu'.$user;
			//Si le user est l'admin		
			$em = $this->getDoctrine()->getManager();
			$userdetails  = $em->getRepository('BaclooCrmBundle:Favoris')		
						   ->findOneByfavusername($user);
			if(empty($userdetails))
			{
				$partager = 'pok';
			}
			else
			{
				$query = $em->createQuery(
					'SELECT a 
					FROM BaclooCrmBundle:Alteruser a
					WHERE a.username = :username
					AND a.ficheid = :ficheid'
				);
				$query->setParameter('username', $user);
				$query->setParameter('ficheid', $id);
				$alter = $query->getResult();

				if(empty($alter))
				{
					$fiche  = $em->getRepository('BaclooCrmBundle:Fiche')		
							   ->findOneById($id);
					$alteruser = new alteruser();
					$alteruser->setUsername($user);
					$alteruser->setFicheid($id);
					$fiche->addAlteruser($alteruser);
					$em->persist($alteruser);
					$em->flush();
					$partager = 'ok';
				}
				else
				{
					$partager = 'nok';
				}
			}
// echo 'partager=='.$partager;
			return $this->render('BaclooCrmBundle:Crm:speedpartage.html.twig', array(
								'partager'    => $partager,
								'previous'    => $previous,
								'user'       => $user
								));
	
		}
		return $this->render('BaclooCrmBundle:Crm:speedpartageform.html.twig', array(
							'form' 		  => $form->createView(),
							'previous'    => $previous,
							'id'    	  => $id,
							'partager'    => 'pok'
							));						
	}
	
	public function modulesAction(Request $request)
	{
		$usersess = $this->get('security.context')->getToken()->getUsername(); if(empty($usersess) or !isset($usersess) or $usersess == 'anon.'){return $this->redirect($this->generateUrl('fos_user_security_login'));}//Récupère le nom d'utilisateur
		$previous = $this->get('request')->server->get('HTTP_REFERER');
		
		$prixmodule1 = 0;
		$prixmodule2 = 0;
		$prixmodule3 = 0;
		$prixmodule4 = 0;
		$prixmodule5 = 0;
		$prixmodule6 = 0;
		$prixmodule7 = 0;
		$prixmodule8 = 0;
		$prixmodule9 = 45;
		$prixmodule10 = 0;
		$prixmodule11 = 0;
		$prixmodule12 = 0;
		
		$em = $this->getDoctrine()->getManager();
		
		$userdetails  = $em->getRepository('BaclooUserBundle:User')		
						   ->findOneByUsername($usersess);
		
		// $societe = $userdetails->getUsersociete();//echo 'jkjjk'.$societe;
		
		// $admin = $em->getRepository('BaclooUserBundle:User')
					  // ->findOneBy(array('usersociete'=>$societe, 'roleuser'=>'admin'));
										// $query = $em->createQuery(
											// 'SELECT u.credits
											// FROM BaclooUserBundle:User u
											// WHERE u.usersociete = :usersociete
											// AND u.roleuser = :roleuser');
										// $query->setParameter('usersociete', $societe);
										// $query->setParameter('roleuser', 'admin');
										// $admin = $query->getSingleScalarResult();
											
		$credits = $userdetails->getCredits();
		
		$modules  = $em->getRepository('BaclooCrmBundle:Modules')		
					   ->findOneByUsername($usersess);
		//Si le user n'est pas encore présent dans la table modules on en créée un nouveau
		// echo 'fggsfdgsg';
		if(empty($modules))
		{
			$table_module = 0;
			// echo'module vide';
			$modules = new Modules();
			$form = $this->createForm(new ModulesType(), $modules);
			$request = $this->getRequest();
			$form->bind($request);			
			if ($request->getMethod() == 'POST')
			{
				if ($form->isValid()) 
				{
					$prix = 0;
					$module1activation = $form->get('module1activation')->getData();
					if($module1activation == 1){$prix += $prixmodule1;}
					$module2activation = $form->get('module2activation')->getData();
					if($module2activation == 1){$prix += $prixmodule2;}
					$module3activation = $form->get('module3activation')->getData();
					if($module3activation == 1){$prix += $prixmodule3;}
					$module4activation = $form->get('module4activation')->getData();
					if($module4activation == 1){$prix += $prixmodule4;}
					$module5activation = $form->get('module5activation')->getData();
					if($module5activation == 1){$prix += $prixmodule5;}
					$module6activation = $form->get('module6activation')->getData();
					if($module6activation == 1){$prix += $prixmodule6;}
					$module7activation = $form->get('module7activation')->getData();
					if($module7activation == 1){$prix += $prixmodule7;}
					$module8activation = $form->get('module8activation')->getData();
					if($module8activation == 1){$prix += $prixmodule8;}
					$module9activation = $form->get('module9activation')->getData();
					if($module9activation == 1){$prix += $prixmodule9;}
					$module10activation = $form->get('module10activation')->getData();
					if($module10activation == 1){$prix += $prixmodule10;}
					$module11activation = $form->get('module11activation')->getData();
					if($module11activation == 1){$prix += $prixmodule11;}
					$module11activation = $form->get('module11activation')->getData();
					if($module11activation == 1){$prix += $prixmodule12;}

					//Si pas suffisament de crédits on renvoie vers la fenêtre d'alerte
					if($credits < $prix)
					{//echo 'return1';
						$grant = 'nok';				
						return $this->render('BaclooCrmBundle:Crm:buyfiche.html.twig', array(
											'previous'    => $previous,
											'credits'    => $credits,
											'prix'    => $prix,
											'grant'    => $grant
											));	
					}
					else
					{
						$expiration = date('d/m/Y', strtotime("+30 days"));//echo $expiration;
						$soldepoints = $credits - $prix;
						$userdetails->setCredits($soldepoints);
						if($module1activation == 1){$modules->setModule1debut(date('d/m/Y'));$modules->setModule1expiration($expiration);}
						if($module2activation == 1){$modules->setModule2debut(date('d/m/Y'));$modules->setModule2expiration($expiration);}
						if($module3activation == 1){$modules->setModule3debut(date('d/m/Y'));$modules->setModule3expiration($expiration);}
						if($module4activation == 1){$modules->setModule4debut(date('d/m/Y'));$modules->setModule4expiration($expiration);}
						if($module5activation == 1){$modules->setModule5debut(date('d/m/Y'));$modules->setModule5expiration($expiration);}
						if($module6activation == 1){$modules->setModule6debut(date('d/m/Y'));$modules->setModule6expiration($expiration);}
						if($module7activation == 1){$modules->setModule7debut(date('d/m/Y'));$modules->setModule7expiration($expiration);}
						if($module8activation == 1){$modules->setModule8debut(date('d/m/Y'));$modules->setModule8expiration($expiration);}
						if($module9activation == 1){$modules->setModule9debut(date('d/m/Y'));$modules->setModule9expiration($expiration);}
						if($module10activation == 1){$modules->setModule10debut(date('d/m/Y'));$modules->setModule10expiration($expiration);}
						if($module11activation == 1){$modules->setModule11debut(date('d/m/Y'));$modules->setModule11expiration($expiration);}
						if($module12activation == 1){$modules->setModule12debut(date('d/m/Y'));$modules->setModule12expiration($expiration);}
						$em->persist($modules);
						$em->flush();						
					}

					return $this->redirect($this->generateUrl('bacloocrm_modules'));
			
				}
			}			
		}
		else
		{
			$table_module = 1;
			// echo'module plein';
			$form = $this->createForm(new ModulesType(), $modules);
			$request = $this->getRequest();
			if ($request->getMethod() == 'POST')
			{	
				$form->bind($request);
				if ($form->isValid()) 
				{
					$prix = 0;
					$module1activation = $form->get('module1activation')->getData();// echo 'activation'.$module1activation;
					$module1debut = $form->get('module1debut')->getData();
					if($module1activation == 1 && $module1debut == null){$prix += $prixmodule1;}elseif($module1activation == 1 && $module1debut != null){}else{$modules->setModule1activation(0);$modules->setModule1debut('');$modules->setModule1expiration('');}
					
					$module2activation = $form->get('module2activation')->getData();//echo $form->get('module2debut')->getData();
					$module2debut = $form->get('module2debut')->getData();
					if($module2activation == 1 && $module2debut == null){$prix += $prixmodule2;}elseif($module2activation == 1 && $module2debut != null){}else{$modules->setModule2activation(0);$modules->setModule2debut('');$modules->setModule2expiration('');}
					
					$module3activation = $form->get('module3activation')->getData();//echo $form->get('module3debut')->getData();
					$module3debut = $form->get('module3debut')->getData();
					if($module3activation == 1 && $module3debut == null){$prix += $prixmodule3;}elseif($module3activation == 1 && $module3debut != null){}else{$modules->setModule3activation(0);$modules->setModule3debut('');$modules->setModule3expiration('');}
					
					$module4activation = $form->get('module4activation')->getData();//echo $form->get('module4debut')->getData();
					$module4debut = $form->get('module4debut')->getData();
					if($module4activation == 1 && $module4debut == null){$prix += $prixmodule4;}elseif($module4activation == 1 && $module4debut != null){}else{$modules->setModule4activation(0);$modules->setModule4debut('');$modules->setModule4expiration('');}
					
					$module5activation = $form->get('module5activation')->getData();//echo $form->get('module5debut')->getData();
					$module5debut = $form->get('module5debut')->getData();
					if($module5activation == 1 && $module5debut == null){$prix += $prixmodule5;}elseif($module5activation == 1 && $module5debut != null){}else{$modules->setModule5activation(0);$modules->setModule5debut('');$modules->setModule5expiration('');}
					
					$module6activation = $form->get('module6activation')->getData();//echo $form->get('module6debut')->getData();
					$module6debut = $form->get('module6debut')->getData();
					if($module6activation == 1 && $module6debut == null){$prix += $prixmodule6;}elseif($module6activation == 1 && $module6debut != null){}else{$modules->setModule6activation(0);$modules->setModule6debut('');$modules->setModule6expiration('');}
					
					$module7activation = $form->get('module7activation')->getData();//echo $form->get('module7debut')->getData();
					$module7debut = $form->get('module7debut')->getData();
					if($module7activation == 1 && $module7debut == null){$prix += $prixmodule7;}elseif($module7activation == 1 && $module7debut != null){}else{$modules->setModule7activation(0);$modules->setModule7debut('');$modules->setModule7expiration('');}
					
					$module8activation = $form->get('module8activation')->getData();//echo $form->get('module8debut')->getData();
					$module8debut = $form->get('module8debut')->getData();
					if($module8activation == 1 && $module8debut == null){$prix += $prixmodule8;}elseif($module8activation == 1 && $module8debut != null){}else{$modules->setModule8activation(0);$modules->setModule8debut('');$modules->setModule8expiration('');}
					
					$module9activation = $form->get('module9activation')->getData();//echo $form->get('module9debut')->getData();
					$module9debut = $form->get('module9debut')->getData();
					if($module9activation == 1 && $module9debut == null){$prix += $prixmodule9;}elseif($module9activation == 1 && $module9debut != null){}else{$modules->setModule9activation(0);$modules->setModule9debut('');$modules->setModule9expiration('');}
					
					$module10activation = $form->get('module10activation')->getData();//echo $form->get('module10debut')->getData();
					$module10debut = $form->get('module10debut')->getData();
					if($module10activation == 1 && $module10debut == null){$prix += $prixmodule10;}elseif($module10activation == 1 && $module10debut != null){}else{$modules->setModule10activation(0);$modules->setModule10debut('');$modules->setModule10expiration('');}
					
					$module11activation = $form->get('module11activation')->getData();//echo $form->get('module11debut')->getData();
					$module11debut = $form->get('module11debut')->getData();
					if($module11activation == 1 && $module11debut == null){$prix += $prixmodule11;}elseif($module11activation == 1 && $module11debut != null){}else{$modules->setModule11activation(0);$modules->setModule11debut('');$modules->setModule11expiration('');}
					
					$module12activation = $form->get('module12activation')->getData();//echo $form->get('module12debut')->getData();
					$module12debut = $form->get('module12debut')->getData();
					if($module12activation == 1 && $module12debut == null){$prix += $prixmodule12;}elseif($module12activation == 1 && $module12debut != null){}else{$modules->setModule12activation(0);$modules->setModule12debut('');$modules->setModule12expiration('');}					

					//Si pas suffisament de crédits on renvoie vers la fenêtre d'alerte
					if($credits < $prix)
					{//echo 'return1';
						$grant = 'nok';				
						return $this->render('BaclooCrmBundle:Crm:buyfiche.html.twig', array(
											'previous'    => $previous,
											'credits'    => $credits,
											'prix'    => $prix,
											'grant'    => $grant
											));	
					}
					else
					{
						$expiration = date('d/m/Y', strtotime("+30 days"));//echo $expiration;
						$soldepoints = $credits - $prix;
						$userdetails->setCredits($soldepoints);
						if($module1activation == 1){$modules->setModule1debut(date('d/m/Y'));$modules->setModule1expiration($expiration);}
						if($module2activation == 1){$modules->setModule2debut(date('d/m/Y'));$modules->setModule2expiration($expiration);}
						if($module3activation == 1){$modules->setModule3debut(date('d/m/Y'));$modules->setModule3expiration($expiration);}
						if($module4activation == 1){$modules->setModule4debut(date('d/m/Y'));$modules->setModule4expiration($expiration);}
						if($module5activation == 1){$modules->setModule5debut(date('d/m/Y'));$modules->setModule5expiration($expiration);}
						if($module6activation == 1){$modules->setModule6debut(date('d/m/Y'));$modules->setModule6expiration($expiration);}
						if($module7activation == 1){$modules->setModule7debut(date('d/m/Y'));$modules->setModule7expiration($expiration);}
						if($module8activation == 1){$modules->setModule8debut(date('d/m/Y'));$modules->setModule8expiration($expiration);}
						if($module9activation == 1){$modules->setModule9debut(date('d/m/Y'));$modules->setModule9expiration($expiration);}
						if($module10activation == 1){$modules->setModule10debut(date('d/m/Y'));$modules->setModule10expiration($expiration);}
						if($module11activation == 1){$modules->setModule11debut(date('d/m/Y'));$modules->setModule11expiration($expiration);}
						if($module12activation == 1){$modules->setModule12debut(date('d/m/Y'));$modules->setModule12expiration($expiration);}
						$em->persist($modules);
						$em->flush();						
					}

					return $this->redirect($this->generateUrl('bacloocrm_modules'));
			
				}
				else
				{
					//echo 'form pas valide';
				}
			}		
		}
		
		
		return $this->render('BaclooCrmBundle:Crm:modules.html.twig', array(
							'form' 		 => $form->createView(),
							'modules'    => $modules,
							'userdetails'    => $userdetails,
							'table_module'    => $table_module,
							'previous'   => $previous
							));						
	}

	public function gerer_utilisateursAction($dix)
	{
		$usersess= $this->get('security.context')->getToken()->getUsername(); if(empty($usersess) or !isset($usersess) or $usersess == 'anon.'){return $this->redirect($this->generateUrl('fos_user_security_login'));}		
		$em = $this->getDoctrine()->getManager();
		$previous = $this->get('request')->server->get('HTTP_REFERER');

		include('societe.php');//echo '$$$$'.$societe;

		$userdetails  = $em->getRepository('BaclooUserBundle:User')		
						   ->findOneByUsername($usersess);
		$credits = $userdetails->getCredits();
		
		$modules = $em->getRepository('BaclooCrmBundle:Modules')
						  ->findByUsersociete($societe);		
		if($dix == 1)
		{
			$moda = $em->getRepository('BaclooCrmBundle:Moda')
						 ->findOneBySociete('1234');
		}else
		{
			// echo 'bbbbb555';
		}

					 
		if(empty($moda))
		{//echo 'rrrrr';
			$moda = new moda();
			$moda->setSociete('1234');
			$em = $this->getDoctrine()->getManager();
			$em->persist($moda);			
		}else
		{
			// echo 'bbb6666';
		}					 
			$form = $this->createForm(new ModaType(), $moda);
			// on soumet la requete
			$request = $this->getRequest();
	// echo $request->getMethod();
			if ($request->getMethod() == 'POST') 
			{
			// On fait le lien Requête <-> Formulaire
			  $form->bind($request);$data = $form->getData();
			  if ($form->isValid())	
			  {
	// echo 'ici';
				$prix = 0;
				  //Boucle recup données formulaire
				  foreach ($form->get('modules')->getData() as $modulform)
				  {
	// echo 'Pour '.$modulform->getUsername();echo '  de la société '.$modulform->getUsersociete();
					//On récupère la modules correspondant en BDD
					$em = $this->getDoctrine()->getManager();
					$modulesbdd = $em->getRepository('BaclooCrmBundle:Modules')
							->findOneBy(array('username'=> $modulform->getUsername(), 'usersociete' => $societe));

						// echo 'bdd'.$modulesbdd->getModule1activation();echo '  form'.$modulform->getModule1activation();
						
						if($modulform->getBbuseractivation() == 1 && $modulesbdd->getBbuseractivation() == 0 )
						{
							$userprix = 3;
							if($credits < $userprix)
							{
								// echo 'return0';
								$grant = 'nok';				
								return $this->render('BaclooCrmBundle:Crm:buyfiche.html.twig', array(
													'previous'    => $previous,
													'credits'    => $credits,
													'prix'    => $userprix,
													'grant'    => $grant
													));	
							}
							else
							{
								$expiration = date('d/m/Y', strtotime("+30 days"));//echo 'xxx'.$expiration;
								$soldepoints = $credits - $userprix;
								$userdetails->setCredits($soldepoints);
								$modulesbdd->setUserprix($userprix);
								$modulesbdd->setUserdebut(date('d/m/Y'));
								$modulesbdd->setUserexpiration($expiration);
								$modulesbdd->setBbuseractivation(1);
								$em->persist($modulesbdd);
								$em->detach($moda);
								$em->flush();							
							}
						}
						elseif($modulform->getBbuseractivation() == 0  && $modulesbdd->getBbuseractivation() == 1)
						{
								$expiration = date('d/m/Y');//echo 'rrrrr'.$expiration;
								$modulesbdd->setUserexpiration($expiration);
								$modulesbdd->setBbuseractivation(0);
								$em->persist($modulesbdd);
								$em->detach($moda);
								$em->flush();
						}

						$module1prix = 1;
						$module2prix = 2;
						$module3prix = 1;
						$module4prix = 1;
						$module5prix = 1;
						$module6prix = 1;
						$module7prix = 1;
						$module8prix = 1;
						$module9prix = 45;
						$module10prix = 10;
						$module11prix = 1;
						$module12prix = 1;						
						
						include('gerermodule1.php');
						include('gerermodule2.php');
						include('gerermodule3.php');
						include('gerermodule4.php');
						include('gerermodule5.php');
						include('gerermodule6.php');
						include('gerermodule7.php');
						include('gerermodule8.php');
						include('gerermodule9.php');
						include('gerermodule10.php');
						include('gerermodule11.php');
						include('gerermodule12.php');						
						
					}
					return $this->redirect($this->generateUrl('bacloocrm_utilisateurs'));
				  }				
			  }
			
			return $this->render('BaclooCrmBundle:Crm:gerer_les_utilisateurs.html.twig', array(
							'form'    => $form->createView(),
							'societe'    => $societe,
							'credits' => $credits
							));
	}


	public function societeAction()
	{
		include('societe.php');
		return $this->render('BaclooCrmBundle:Crm:societe.html.twig', array(
									'societe'    => $societe
									));	
	}
	
	public function blancAction()
	{
		$usersess = $this->get('security.context')->getToken()->getUsername(); if(empty($usersess) or !isset($usersess) or $usersess == 'anon.'){return $this->redirect($this->generateUrl('fos_user_security_login'));}//Récupère le nom d'utilisateur

		$em = $this->getDoctrine()->getManager();
		
		$userdetails  = $em->getRepository('BaclooUserBundle:User')		
						   ->findOneByUsername($usersess);
						   
		$roleuser = $userdetails->getRoleuser();
		// $Usersociete = $userdetails->getUsersociete();
		if($roleuser == 'admin')
		{
			$usersess = $this->get('security.context')->getToken()->getUsername(); if(empty($usersess) or !isset($usersess) or $usersess == 'anon.'){return $this->redirect($this->generateUrl('fos_user_security_login'));}//Récupère le nom d'utilisateur
			$previous = $this->get('request')->server->get('HTTP_REFERER');
			
			$em = $this->getDoctrine()->getManager();
			
			$userdetails  = $em->getRepository('BaclooUserBundle:User')		
							   ->findOneByUsername($usersess);
			
			$societe = $userdetails->getUsersociete();//echo 'jkjjk'.$societe;
			
			// $alluser = $em->getRepository('BaclooUserBundle:User')
						  // ->findByUsersociete($societe);

			// $nbuser = count($alluser);
												
			$credits = $userdetails->getCredits();
			
			$modules = $em->getRepository('BaclooCrmBundle:Modules')		
						   ->findOneByUsername($usersess);
			$module_init = $modules->getBbactivation();	
				// echo'module plein';
				$form = $this->createForm(new ModulesType(), $modules);
				$request = $this->getRequest();
				if ($request->getMethod() == 'POST')
				{	
					$form->bind($request);
					if ($form->isValid()) 
					{
						$prixc = 150;
						$prixpc= 110;						
						if($userdetails->getTypebacloo() == 'fichier_commun'){$prix = $prixc;}else{$prix = $prixpc;}
						$bbactivation = $form->get('bbactivation')->getData();// echo 'activation'.$module1activation;

						// echo $bbactivation;
						// echo 'ggg'.$modules->getBbactivation();						
						
						//Si pas suffisament de crédits on renvoie vers la fenêtre d'alerte
						if($credits < $prix)
						{//echo 'return1';
							$grant = 'nok';				
							return $this->render('BaclooCrmBundle:Crm:buyfiche.html.twig', array(
												'previous'    => $previous,
												'credits'    => $credits,
												'prix'    => $prix,
												'grant'    => $grant
												));	
						}
						else
						{
							$expiration = date('d/m/Y', strtotime("+30 days"));//echo $expiration;
							
							if($bbactivation == 1 && $module_init != 1)
							{
								//echo 'laaaaaa';
								$soldepoints = $credits - $prix;
								$userdetails->setCredits($soldepoints);
								$modules->setbbdebut(date('d/m/Y'));
								$modules->setbbexpiration($expiration);
								$modules->setbbprix($prix);
							}
							$em->persist($modules);
							$em->flush();						
						}

						return $this->redirect($this->generateUrl('bacloocrm_bb'));
				
					}
					else
					{
						// echo 'form pas valide';
					}
			}
		
		
		return $this->render('BaclooCrmBundle:Crm:descbb.html.twig', array(
							'form' 		 => $form->createView(),
							'modules'    => $modules,
							'userdetails'    => $userdetails,
							'previous'   => $previous
							));				
		}
		else
		{
			$prixc = 150;
			$prixpc= 110;		
							   
			return $this->render('BaclooCrmBundle:Crm:descbb.html.twig', array(
								'userdetails'    => $userdetails,
								'roleuser'    	 => $roleuser,
								'prixc'			 => $prixc,
								'prixpc'		 => $prixpc
								));	
		}
	}
	
	public function confbbAction($mode, $credits, Request $request)
	{
		$usersess = $this->get('security.context')->getToken()->getUsername(); if(empty($usersess) or !isset($usersess) or $usersess == 'anon.'){return $this->redirect($this->generateUrl('fos_user_security_login'));}//Récupère le nom d'utilisateur
		$previous = $this->get('request')->server->get('HTTP_REFERER');
		
		$prixc = 150;
		$prixpc= 110;
		
		$defaultData = array('message' => 'Veuillez saisir un message, il nous fera avancer.');
		$form = $this->createFormBuilder($defaultData)
			->add('societe', 'text', array('required' => true))				
			->getForm();

		$form->handleRequest($request);
// echo $request->getMethod();
	if ($request->getMethod() == 'POST') 
	{
	// echo'llaaaaa';
		if ($form->isValid())
		{
		// echo 'iiiiiiiiii';
			// Les données sont un tableau avec les clés "name", "email", et "message"
			$data = $form->getData();
				// Partie envoi du mail
				// Récupération du service
			$society = $data['societe'];				
			$chaine = preg_replace("#[^a-zA-Z]#", "", $society);
			$tabact = array(' ', ' & ', '\'');
			$societe = str_replace($tabact, '_', $chaine);

			
			$em = $this->getDoctrine()->getManager();
			
			$userdetails  = $em->getRepository('BaclooUserBundle:User')		
							   ->findOneByUsername($usersess);
			$roleuser = $userdetails->getRoleuser(); //echo $roleuser;
			$userid = $userdetails->getId(); //echo $roleuser;
			$usersociete = $userdetails->getUsersociete();//echo $usersociete;
			// echo $roleuser;
			if($roleuser == 'admin')
			{
				return $this->render('BaclooCrmBundle:Crm:confbb.html.twig',array('mode'	=> 'nok',
																				'roleuser'	=> $roleuser
																		  ));
			}
			$credits = $userdetails->getCredits();

			$userdetails->setUsersociete($society);
			$userdetails->setTextaccueil('Personnalisez ce texte dans votre profil');
			$userdetails->setTypebacloo($mode);
			$userdetails->setRoleuser('admin');
			$userdetails->setNomrep($societe);

			// echo 'lierrrrrrrrrrrr';
			$em = $this->getDoctrine()->getManager();
			$modules  = $em->getRepository('BaclooCrmBundle:Modules')		
						   ->findOneByUsername($usersess);
			if(empty($modules))
			{
				// echo'module vide';
				$modules = new Modules();		
			}			
			$expiration = date('d/m/Y', strtotime("+30 days"));//echo $expiration;
			$modules->setBb('Bacloo personnalisé');
			if($mode == 'fichier_commun')
			{
				$prix = $prixc;
			}
			elseif($mode == 'fichier_pas_commun')
			{
				$prix = $prixpc;
			}
			$solde = $credits-$prix;
			$userdetails->setCredits($solde);			
			$modules->setUserid($userid);
			$modules->setUsername($usersess);
			$modules->setBb($mode);
			$modules->setBbprix($prix);
			$modules->setBbdebut(date('d/m/Y'));
			$modules->setBbexpiration($expiration);
			$modules->setBbactivation(1);
			$em->persist($modules);
			$em->flush();
			//Extration du contenu de bacloo.zip
			set_time_limit(300);
			$zip = new ZipArchive;
			if($mode == 'fichier_commun')
			{
				if ($zip->open('bacloo2.zip') === TRUE) {
					$zip->extractTo('b/');
					$zip->close();
					// echo 'ok';
				} else {
					// echo 'échec';
				}
				$fs = new Filesystem();	
				$fs->rename('b/bacloo2/', 'b/'.$societe.'/');				
			}
			else
			{
				if ($zip->open('bacloo.zip') === TRUE) {
					$zip->extractTo('b/');
					$zip->close();
					// echo 'ok';
				} else {
					// echo 'échec';
				}
				$fs = new Filesystem();	
				$fs->rename('b/bacloo/', 'b/'.$societe.'/');				
			}			

			// sleep(40);


			
		//On inscrit le nom de la societe dans societe.txt	

			$monfichier = fopen('b/'.$societe.'/src/Bacloo/CrmBundle/Controller/societe.php', 'w');
			$monfichier = fopen('b/'.$societe.'/src/Bacloo/CrmBundle/Controller/societe.php', 'r+');
			
			fseek($monfichier, 0); // On remet le curseur au début du fichier
			fputs($monfichier, '<?php $societe = "'.$society.'";?>'); // On écrit le nouveau nom de société			 
			fclose($monfichier);

			$monfichier2 = fopen('b/'.$societe.'/src/Bacloo/UserBundle/Controller/societe.php', 'w');
			$monfichier2 = fopen('b/'.$societe.'/src/Bacloo/UserBundle/Controller/societe.php', 'r+');

			fseek($monfichier2, 0); // On remet le curseur au début du fichier
			fputs($monfichier2, '<?php $societe = "'.$society.'";?>'); // On écrit le nouveau nom de société			 
			fclose($monfichier2);			
			// $file = "societe.php";
			// $fs->copy('societe.php', '../src/Bacloo/UserBundle/Controller/societe.php', true);
			// copy($file, "../src/Bacloo/UserBundle/Controller/societe.php");
			$destinataire = $userdetails;
						$mailer = $this->get('mailer');				
						
							$message = \Swift_Message::newInstance()
								->setSubject($destinataire->getPrenom(). ' : '.$usersess.' a créée un bacloo personnalisé')
								->setFrom(array('bacloo@bacloo.fr' => 'Bacloo CRM'))
								->setTo('ringuetjm@gmail.com')
								->setBody($society)
							;
							$mailer->send($message);
				// Fin partie envoi mail			
			$validation = 'ok';
			// $url = 'http://127.0.0.1/symfony2/web/b/lamiecaline/web/app_dev.php/login';
			$url = 'https://www.bacloo.fr/b/'.$societe.'/web/app.php';
			return $this->render('BaclooCrmBundle:Crm:confbb.html.twig',array('mode'		=> 'ok',
																			  'url'			=> $url
																		  ));		
		}
		// echo 'uuuuuu';
	}

		return $this->render('BaclooCrmBundle:Crm:confbb.html.twig',array('form' 		=> $form->createView(),
																		  'previous'    => $previous,
																		  'credits'     => $credits,
																		  'mode'		=> $mode
																		  ));		
	}
	
	public function pregenerationbbAction($typebb)
	{
		$defaultData = array();
		$form = $this->createFormBuilder($defaultData)
			->add('type_bacloo', 'text', array('required' => true))
			->add('email', 'email', array('required' => true))
			->add('message', 'textarea', array('required' => true))
			->getForm();

		$form->handleRequest($request); 

		//Extration du contenu de bacloo.zip
		$zip = new ZipArchive;
			if($mode == 'fichier_commun')
			{
				if ($zip->open('bacloo2.zip') === TRUE) {
					$zip->extractTo('b/');
					$zip->close();
					//echo 'ok';
				} else {
					//echo 'échec';
				}
				$fs = new Filesystem();	
				$fs->rename('b/bacloo2/', 'b/'.$societe);				
			}
			else
			{
				if ($zip->open('bacloo.zip') === TRUE) {
					$zip->extractTo('b/');
					$zip->close();
					//echo 'ok';
				} else {
					//echo 'échec';
				}
				$fs = new Filesystem();	
				$fs->rename('b/bacloo/', 'b/'.$societe);				
			}

		
	//On inscrit le nom de la societe dans societe.txt	
		
		$monfichier = fopen('../src/Bacloo/CrmBundle/Controller/societe.php', 'r+');
		$file = "societe.php";
		copy($file, "../src/Bacloo/UserBundle/Controller/societe.php");
		copy($file, "../src/Avro/CsvBundle/Import/societe.php");
		fseek($monfichier, 0); // On remet le curseur au début du fichier
		fputs($monfichier, '<?php $societe = "'.$societe.'";?>'); // On écrit le nouveau nom de société
		 
		fclose($monfichier);
		
		//Include à insérer dans le controler après décompréssion de bacloo.zip
		// include('societe.php');

	}

	public function gdriveAction($id, request $request)
	{
		$usersess = $this->get('security.context')->getToken()->getUsername(); if(empty($usersess) or !isset($usersess) or $usersess == 'anon.'){return $this->redirect($this->generateUrl('fos_user_security_login'));}//Récupère le nom d'utilisateur
		$previous = $this->get('request')->server->get('HTTP_REFERER');	
		$defaultData = array();
		$form = $this->createFormBuilder($defaultData)
			->add('folder_id', 'text', array('required' => false))
			->getForm();
// echo 'dodo'.$id;
		$form->handleRequest($request);

		if ($form->isValid()) {
				// echo 'XXXXXXXXXXXXXXXX';		
				// Les données sont un tableau avec les clés "name", "email", et "message"
				$data = $form->getData();
					// Partie envoi du mail
					// Récupération du service
			$folderid = $data['folder_id']; //echo 'uuuu'.$user;
			//Si le user est l'admin		
			$em = $this->getDoctrine()->getManager();
			$fiche  = $em->getRepository('BaclooCrmBundle:Fiche')		
						   ->findOneById($id);
			// echo'iddd'.$id;			   
			$fiche->setFolderid($folderid);
			$em->flush();

// echo 'partager=='.$partager;
			return $this->redirect($this->generateUrl('bacloocrm_voir', array('id' => $id)));
	
		}
		return $this->render('BaclooCrmBundle:Crm:gdrive.html.twig', array(
								'form' 		  => $form->createView(),
								'previous'    => $previous,
								'id'    	  => $id
							));	
	}
	
	public function colleguetempAction()
	{
		$usersess = $this->get('security.context')->getToken()->getUsername(); if(empty($usersess) or !isset($usersess) or $usersess == 'anon.'){return $this->redirect($this->generateUrl('fos_user_security_login'));}
	
		//On récupère les favoris niveau ALL
		$em = $this->getDoctrine()->getManager();

		$modules  = $em->getRepository('BaclooCrmBundle:Modules')		
					   ->findOneByUsername($usersess);	
		// include('societe.php');
		return $this->render('BaclooCrmBundle:Crm:collegues_temp.html.twig', array(
									'modules8activation' => $modules->getModule8activation()
									));	
	}
	
	public function showpointsAction()
	{
		$usersess = $this->get('security.context')->getToken()->getUsername();
	
		//On récupère les favoris niveau ALL
		$em = $this->getDoctrine()->getManager();

		$user  = $em->getRepository('BaclooUserBundle:User')		
					   ->findOneByUsername($usersess);
		$points = $user->getCredits();
		// include('societe.php');
		return $this->render('BaclooCrmBundle:Crm:showpoints.html.twig', array(
									'points' => $points
									));	
	}

	public function showcommAction($id, $module1act, Request $request)
	{
		$usersess = $this->get('security.context')->getToken()->getUsername(); 
		$em = $this->getDoctrine()->getManager();
		$fiche  = $em->getRepository('BaclooCrmBundle:Fiche')		
							   ->findOneById($id);
		$i = 0;
		$len = count($fiche->getEvent());

		if($len > 0)
		{
			$test = 'ok';
			foreach($fiche->getEvent() as $ev)
			{
				if($i == $len - 1)
				{

					$commentaire = $ev->getEventComment();
					$datecomm = $ev->getEventDate();
					break;
				}
				else
				{
					$i++;
				}
			}
		}
		else
		{
			$test = 'nok';
			$commentaire = '';
			$datecomm = '';
		}
		
		$defaultData = array();
		$form = $this->createFormBuilder($defaultData)
			->add('pseudo', 'text', array('required' => false))
			->getForm();

		$form->handleRequest($request);		
		
		return $this->render('BaclooCrmBundle:Crm:showcomm.html.twig', array(
								'form' 		  => $form->createView(),
								'commentaire'    => $commentaire,
								'module1act'	=> $module1act,
								'test'    => $test,
								'id'    => $id,
								'datecomm'    => $datecomm
								));		
	}
	
	public function showpipelineAction()
		{
			$usersess = $this->get('security.context')->getToken()->getUsername(); if(empty($usersess) or !isset($usersess) or $usersess == 'anon.'){return $this->redirect($this->generateUrl('fos_user_security_login'));}//Récupère le nom d'utilisateur	

			//On récupère l'id de l'utilisateur connecté
			$em = $this->getDoctrine()->getManager();
			
			$modules  = $em->getRepository('BaclooCrmBundle:Modules')		
						   ->findOneByUsername($usersess);					
			$module2activation = $modules->getmodule2activation();			
			
			$query = $em->createQuery(
				'SELECT u.id
				FROM BaclooUserBundle:User u
				WHERE u.username = :username'
			)->setParameter('username', $usersess);
			$uid = $query->getSingleScalarResult();
			//On regarde si l'utilisateur connecté est déja entegistré dnas la table userpipe
			$userpipe = $em->getRepository('BaclooCrmBundle:Userpipe')
			->findOneByUserid($uid);			  
	
			//On récupère les pipelines de l'utilisateur connecté
			$em2 = $this->getDoctrine()
					   ->getManager()
					   ->getRepository('BaclooCrmBundle:Pipeline');
			$pipe = $em2->findByUsername($usersess);


			//On récupère les userpipe du user connecté
			$em2 = $this->getDoctrine()
					   ->getManager()
					   ->getRepository('BaclooCrmBundle:Userpipe');
			$userpipa = $em2->findOneByUserid($uid);

			if(empty($userpipa))
			{
				// echo 'pppppppooo';
				$userpipe = new userpipe();
				$userpipe->setUserid($uid);
				$em = $this->getDoctrine()->getManager();
				$em->persist($userpipe);
				$em->flush();
				
				$em2 = $this->getDoctrine()
						   ->getManager()
						   ->getRepository('BaclooCrmBundle:Userpipe');
				$userpipo = $em2->findOneByUserid($uid);
				
				$pipe0 = new pipeline();
				$pipe0->setUserid($uid);
				$pipe0->setUsername($usersess);
				$pipe0->setPipename('---------');
				$pipe0->setPipeorder(0);				
				$pipe0->addUserpipe($userpipo);	
				$userpipo->addPipeline($pipe0);
				$em->persist($pipe0);
				$em->persist($userpipo);
				$em->flush();
				
				$pipe0 = new pipeline();
				$pipe0->setUserid($uid);
				$pipe0->setUsername($usersess);
				$pipe0->setPipename('Devis fait');
				$pipe0->setPipeorder(1);				
				$pipe0->addUserpipe($userpipo);	
				$userpipo->addPipeline($pipe0);
				$em->persist($pipe0);
				$em->persist($userpipo);
				$em->flush();
				
				$pipe0 = new pipeline();
				$pipe0->setUserid($uid);
				$pipe0->setUsername($usersess);
				$pipe0->setPipename('Affaires signées');
				$pipe0->setPipeorder(2);
				$pipe0->setRealise(true);				
				$pipe0->addUserpipe($userpipo);	
				$userpipo->addPipeline($pipe0);
				$em->persist($pipe0);
				$em->persist($userpipo);
				$em->flush();
				
				$pipe0 = new pipeline();
				$pipe0->setUserid($uid);
				$pipe0->setUsername($usersess);
				$pipe0->setPipename('Affaires perdues');
				$pipe0->setPipeorder(3);
				$pipe0->setPerdu(true);
				$pipe0->setExclusion(true);				
				$pipe0->addUserpipe($userpipo);	
				$userpipo->addPipeline($pipe0);
				$em->persist($pipe0);
				$em->persist($userpipo);
				$em->flush();				
			}
			else
			{
				// echo 'loulou';
				$pipe_zero = $em->getRepository('BaclooCrmBundle:Pipeline')
								->findOneBy(array('username' => $usersess, 'pipeorder' => 0, 'pipename' => '---------'));	
				if(empty($pipe_zero) && !isset($pipe_zero))
				{
					// echo 'lili';
					$em2 = $this->getDoctrine()
							   ->getManager()
							   ->getRepository('BaclooCrmBundle:Userpipe');
					$userpipo = $em2->findOneByUserid($uid);
					
					$pipe0 = new pipeline();
					$pipe0->setUserid($uid);
					$pipe0->setUsername($usersess);
					$pipe0->setPipename('---------');
					$pipe0->setPipeorder(0);				
					$pipe0->addUserpipe($userpipa);	
					$userpipa->addPipeline($pipe0);
					$em->persist($pipe0);
					$em->persist($userpipo);
					$em->flush();
				}					
			}

			$em2 = $this->getDoctrine()
					   ->getManager()
					   ->getRepository('BaclooCrmBundle:Userpipe');
			$userpipo = $em2->findOneByUserid($uid);

			$form = $this->createForm(new UserpipeType(), $userpipo);
			
			//Tag OK s'il y a des pipeline sinon NOK
			if(isset($pipe) && !empty($pipe)){$grant = 'ok';}else{$grant = 'nok';}		

			// on soumet la requete
			$request = $this->getRequest();
			// echo 'methodoooo'.$request->getMethod();
			if ($request->getMethod() == 'POST') {
			// On fait le lien Requête <-> Formulaire
			  $form->bind($request);
			  if ($form->isValid()) 
			  {
				// echo 'isi';
					foreach ($form->get('pipeline')->getData() as $bee) 
					{					
						if(!isset($bee)){echo 'iiiiiiggg';
							$userpipe->getPipeline()->clear();
						}
					}			  			  
				  
					$em = $this->getDoctrine()->getManager();
					$em->persist($userpipe);	
					$em->flush();


					// $listeBr = array();
					// foreach ($userpipe->getPipeline() as $br) {
					  // $listeBr[] = $br;
					// }				
					// $efface = 1;
					//On persiste les events
					foreach ($pipe as $originalBr) 
					{
						// echo 'compar pipeline'.$originalBr->getPipename();
						$efface = 1;
						$i=1;
						  foreach ($form->get('pipeline')->getData() as $rb) 
						  {
							// echo 'dada'.$rb->getPipename();
							    if($i < 4)
							    {
									// echo 'iiiii'.$i;
									// Si pas de rappel en bdd et rb existe: On persist
									if(empty($originalBr) && !empty($rb)){echo 'ddododod';
									// On persiste les pipeline et autres (propriétaire) maintenant que $fiche a un id
											if(isset($br) && !empty($br)){
											  // $br->addFiche($fiche);
											  $em->persist($br);
											}
									}
									elseif($originalBr->getPipename() == $rb->getPipename()) //si present db et form
									{
										// echo 'dododo'.$efface;
										$efface = 0;
									}
									elseif($originalBr->getPipename() == '---------') //si present db et form
									{
										// echo 'dododo'.$efface;
										$efface = 0;
									}
									if($efface == 1)
									{
										// echo 'cocococ'.$efface;
										$em->remove($originalBr);
									} 
									$i++;
								}
								else
								{
									// echo 'gggggg'.$i;
									$em->detach($userpipe);
									$i++;
								}
						  }
						if($efface == 1)
						{
							// echo 'cocococ'.$efface;
							$em->remove($originalBr);
						}
					}
					$em->persist($userpipe);
					$em->flush();
								   
					$pipe_zero2 = $em->getRepository('BaclooCrmBundle:Pipeline')
							->findBy(array('username' => $usersess, 'pipeorder' => 0, 'pipename' => '---------'));					
					if(empty($pipe_zero2))
					{
						$pipe0 = new pipeline();
						$pipe0->setUserid($uid);
						$pipe0->setUsername($usersess);
						$pipe0->setPipename('---------');
						$pipe0->setPipeorder(0);				
						$pipe0->addUserpipe($userpipo);	
						$userpipo->addPipeline($pipe0);
						$em->persist($pipe0);
						$em->persist($userpipo);
						$em->flush();
					}
					
					// $em->clear();
					// $pipeline = $em->getRepository('BaclooCrmBundle:Pipeline')
								   // ->findByUsername($usersess);
					// foreach($pipeline as $pipe)
					// {
						// if($pipe->getPipeorder() == 0 &&  $pipe->getPipename() != '---------')
						// {
							// echo 'LOGIQUE';
							// $em->remove($pipe);
							// $em->flush();
						// }
					// }					
					//Module 9
					$modules  = $em->getRepository('BaclooCrmBundle:Modules')		
								   ->findOneByUsername($usersess);					
					$module2activation = $modules->getmodule2activation();
					if($module2activation == 0)
					{
						$em->clear();
						$pipeline = $em->getRepository('BaclooCrmBundle:Pipeline')
									   ->findByUsername($usersess);

						$nbpipe = count($pipeline);//echo 'nbpipe'.$nbpipe;
						if($nbpipe > 4)
						{
							
							$i = 1;
							// echo 'LOLOLO'.$i;
							foreach($pipeline as $pipe)
							{
								// echo 'easy'.$i;echo $pipe->getPipeorder();
								if($i > 4)
								{
									// echo 'LALAAL'.$i;
									$em->remove($pipe);
									$em->flush();
								}							
								$i++;
							}
						}
					
					}					
						// On enregistre les prospects en base de donnée afin d'avoir son id
						return $this->redirect($this->generateUrl('bacloocrm_showpipeline'));
	//echo 'bogo';					
				}
			}			

	//echo 'baga';
			//On récupère les userpipe du user connecté
			// $em2->clear();
			$em->clear();

			
			return $this->render('BaclooCrmBundle:Crm:pipeline_list.html.twig', array(
							'form'    => $form->createView(),
							'userid' => $uid,
							'username' => $usersess,
							'module2activation' => $module2activation,
							'grant'	  => $grant
							));		

		}
			
	public function communicationAction()
	{
		$usersess = $this->get('security.context')->getToken()->getUsername();

		// include('societe.php');
		return $this->render('BaclooCrmBundle:Crm:communication.html.twig');
	}

	public function listuserAction($useracc, Request $request)
	{
		$usersess = $this->get('security.context')->getToken()->getUsername(); if(empty($usersess) or !isset($usersess) or $usersess == 'anon.'){return $this->redirect($this->generateUrl('fos_user_security_login'));}//Récupère le nom d'utilisateur
		$previous = $this->get('request')->server->get('HTTP_REFERER');	
		$defaultData = array();
		include('societe.php');
		$em = $this->getDoctrine()->getManager();
		$username = $em->getRepository('BaclooUserBundle:User')
					   ->findBy(array('usersociete' => $societe));
		$i = 0;
		foreach($username as $usern)
		{
			$i++;
		}
		if($i > 1)
		{
			foreach($username as $value) {
				$name_set[] = $value->getUsername();
				$id_set[] = $value->getId();
			}		   
			$form = $this->createFormBuilder($defaultData)
				->add('username', 'choice', array(
						'choice_list' => new ChoiceList($id_set, $name_set)
					))
				->getForm();
		}
		else
		{
			$form = $this->createFormBuilder($defaultData)
				->add('username', 'choice', array(
					'choices'	=> array(
						$usersess   => $usersess
					),
					'multiple'  => false))
				->getForm();		
		}

		$form->handleRequest($request);

		if ($form->isValid()) {
				// echo 'XXXXXXXXXXXXXXXX';
				$data = $form->getData();
			$user = $data['username']; //echo 'uuuu'.$user;
			//Si le user est l'admin
			$userdaccueil  = $em->getRepository('BaclooUserBundle:User')		
						   ->findOneById($user);
			$username = $userdaccueil->getUsername();

			return $this->redirect($this->generateUrl('bacloocrm_home', array('useracc' => $username)));
	
		}
		return $this->render('BaclooCrmBundle:Crm:listuser.html.twig', array(
							'form' 		  => $form->createView(),
							'useracc' 	  => $useracc
							));						
	}
		
	public function showcrAction($page, $mode)
	{
		$usersess = $this->get('security.context')->getToken()->getUsername();

		// echo 'yyy';echo $mode;



		$request = $this->getRequest();
		$session = $request->getSession();
		
		$du = $session->get('crdu');
		$au = $session->get('crau');
		$user = $session->get('username');
		$moda = $session->get('mode');
		$relances = $session->get('relances');
		if(isset($moda))
		{
			$mode = $moda;
		}
		// echo 'xxx';echo $mode;
		// $page = $session->get('page');
		// echo 'user1'.$user;
		if(!isset($du)){$du = date('Y-m-d', strtotime('-7 days'));}
		if(!isset($au)){$au = date('Y-m-d');}
		if(!isset($page)){$page = 1;}
		if(!isset($user)){$user = $usersess;}

		$defaultData = array();		
		include('societe.php');
		$em = $this->getDoctrine()->getManager();	
		$username = $em->getRepository('BaclooUserBundle:User')
						   ->findBy(array('usersociete' => $societe));
						   
		$i = 0;
		foreach($username as $usern)
		{
			$i++;
		}
		$name_set[] = 'tous';
		$id_set[] = 'xxx';
		if($i > 1)
		{
			foreach($username as $value) {
				$name_set[] = $value->getUsername();
				$id_set[] = $value->getId();
			}
		
			$form = $this->createFormBuilder($defaultData)
				->add('du', 'date', array('widget' => 'single_text',
											'input' => 'string',
											'format' => 'dd/MM/yyyy',
											'required' => false,
											'attr' => array('class' => 'date'),
											))
				->add('au', 'date', array('widget' => 'single_text',
											'input' => 'string',
											'format' => 'dd/MM/yyyy',
											'required' => false,
											'attr' => array('class' => 'date'),
											))
				->add('username', 'choice', array(
						'choice_list' => new ChoiceList($id_set, $name_set)
					))
				->add('relances', 'checkbox', array('required' => false))





				->getForm();
		}
		else
		{
			$form = $this->createFormBuilder($defaultData)
				->add('du', 'date', array('widget' => 'single_text',
											'input' => 'string',
											'format' => 'dd/MM/yyyy',
											'required' => false,
											'attr' => array('class' => 'date'),
											))
				->add('au', 'date', array('widget' => 'single_text',
											'input' => 'string',
											'format' => 'dd/MM/yyyy',
											'required' => false,
											'attr' => array('class' => 'date'),
											))
				->add('username', 'choice', array(
					'choices'	=> array(
						$usersess   => $usersess
					),
					'multiple'  => false))
				->getForm();			
		}
// echo 'dodo'.$id;
		$form->handleRequest($request);

		if ($form->isValid()) {
				// echo 'XXXXXXXXXXXXXXXX';		
				// Les données sont un tableau avec les clés "name", "email", et "message"
				$data = $form->getData();
				$du = $data['du'];
				$au = $data['au'];
				$user = $data['username'];
				$relances = $data['relances'];



				// echo $user;
				if($user == 'xxx')
				{
					$username = 'tous';
				}
				else
				{
					$userdaccueil  = $em->getRepository('BaclooUserBundle:User')		
								   ->findOneById($user);
					$username = $userdaccueil->getUsername();
				}
				// echo $username;
				$session->set('crdu', $du);
				$session->set('crau', $au);
				$session->set('username', $username);



				$session->set('relances', $relances);
				if($relances == 1)
				{
					$session->set('mode', 'brappels');
				}
				else
				{
					$session->set('mode', 'cr');
				}	
				return $this->redirect($this->generateUrl('bacloocrm_cr', array('mode' => $mode)));					

				}			













		$em = $this->getDoctrine()->getManager();
		$cr = $em->getRepository('BaclooCrmBundle:Event')
		->searchcr($du, $au, 30, $page, $user, $societe);
		
		$cra = $em->getRepository('BaclooCrmBundle:Event')
		->searchcradmin($du, $au, 30, $page, $user, $societe);
		
		$bra = $em->getRepository('BaclooCrmBundle:Brappels')
		->searchbrappelsadmin($du, $au, 30, $page, $user, $societe);

		$modules  = $em->getRepository('BaclooCrmBundle:Modules')		
			   ->findOneByUsername($usersess);
			   
		$userdacc  = $em->getRepository('BaclooUserBundle:User')		
					   ->findOneByUsername($usersess);
		$userdaccueil = $userdacc->getRoleuser();

		$module12activation = $modules->getModule12activation();

		// include('societe.php');
		return $this->render('BaclooCrmBundle:Crm:cr.html.twig', array('cr' => $cr,
																	   'cra' => $cra,
																	   'bra' => $bra,
																	   'du' => $du,
																	   'au' => $au,
																	   'mode' => $mode,
																	   'user' => $user,
																	   'societe' => $societe,
																	   'relances' => $relances,
																	   'userdaccueil' => $userdaccueil,
																	   'userdacc' => $userdacc,
																	   'page' => $page,
																	   'module12activation' => $module12activation,
																	   'nombrePage' => ceil(count($cr)/30),
																	   'form' => $form->createView()
																		));	
	}
		
	/**
	* function getDatesBetween
	* renvoie un tableau contenant toutes les dates, jour par jour,
	* comprises entre les deux dates passées en paramètre.
	* NB : les dates doivent être au format aaaa-mm-dd (mais on peut changer le parsing)
	* @param (string) $dStart : date de départ
	* @param (string) $dEnd : date de fin
	* @return (array) aDates : tableau des dates si succès
	* @return (bool) false : si échec
	*/
	public function createplanningAction()
		{
			$dStart = date('Y-m-d');
			// $dStart = '2018-10-31';
			$dEnd = date('Y-m-d', strtotime("+20 days"));
			// $dEnd = '2018-11-30';
			
		//1.Récupérer les données de la table Machines
			$em = $this->getDoctrine()->getManager();
			$locations  = $em->getRepository('BaclooCrmBundle:Machines')		
						   ->findAll();	
			   
		//2.On génère les entêtes de colonnes à partir de la fonction createplanning
			$iStart = strtotime ($dStart);//Formate une date/heure locale avec la Something is wronguration locale
			$iEnd = strtotime ($dEnd);
			if (false === $iStart || false === $iEnd) {
				return false;
			}
			$aStart = explode ('-', $dStart);
			$aEnd = explode ('-', $dEnd);
			if (count ($aStart) !== 3 || count ($aEnd) !== 3) {
				return false;
			}
			if (false === checkdate ($aStart[1], $aStart[2], $aStart[0]) || false === checkdate ($aEnd[1], $aEnd[2], $aEnd[0]) || $iEnd <= $iStart) {
				// return false;
			}
			for ($i = $iStart; $i < $iEnd + 86400; $i = strtotime ('+1 day', $i) ) {
				$sDateToArr = strftime ('%Y-%m-%d', $i);
				$sYear = substr ($sDateToArr, 0, 4);
				$sMonth = substr ($sDateToArr, 5, 2);
				$aDates[$sYear][$sMonth][] = $sDateToArr;
			}
			
			$nbannee = 0;
			$nbmoisparannee = 0;
			//Calcule le nombre de jours dans le mois
			$annee1 = date("Y", strtotime($dStart));
			$anneef = date("Y", strtotime($dStart));
			$anneefin = $anneef + 1;
			
			//Boucle parcours tableau année, mois, jours.
			//Celle-ci renvoie le nombre de  jours du premier mois m1
			$m11 = 1;
			foreach($aDates as $annee => $moiss)
			{
				foreach($moiss as $date => $mois)
				{
					if($m11 == 1)//si on est en m1 on procède sinon break
					{
						foreach($mois as $dat)
						{						
							$m11++;
						}
					}
					else
					{
						break;
					}
				}
				
			}
			$m1 = $m11-1;
			//Calcul du nb total de mois $m
			$m = 0;
			foreach($aDates as $annee => $moiss)
			{
				foreach($moiss as $date => $mois)
				{
					$m++;
				}
				
			}
			
			//Calcul du nb total d'années $a
			$an = 0;
			foreach($aDates as $annee => $moiss)
			{
				$an++;				
			}
// echo $m;			
			//Celle-ci renvoie le nombre de jours du dernier mois mm
			$mm = 0;
			$compteurm = 1;
			foreach($aDates as $annee => $moiss)
			{
				foreach($moiss as $date => $mois)
				{
					if($compteurm == $m)//si on est le dernier mois
					{
						foreach($mois as $dat)
						{						
							$mm++;
						}
					}
					else
					{}
				$compteurm++;
				}
				
			}
			
			//Celle-ci renvoie le nombre de jours de la première année $a1
			$a11 = 1;
			foreach($aDates as $annee => $moiss)
			{
				if($a11 == 1)//si on est en a1 on procède sinon break
				{
					foreach($moiss as $date => $mois)
					{
						foreach($mois as $dat)
						{						
							$a11++;
						}
					}
				}
				else
				{
					break;
				}
			}
			$a1 = $a11-1;
			//Fonction qui calcule le nombre de jours dans l'année
			function cal_days_in_year($year){
				$days=0; 
				for($month=1;$month<=12;$month++){ 
					$days = $days + cal_days_in_month(CAL_GREGORIAN,$month,$year);
				 }
			return $days;
			}			
			//Celle-ci renvoie le nombre de jours de la dernière année $aa
			$aa = 0;
			$compteura = 1;
			foreach($aDates as $annee => $moiss)
			{
				if($compteura == $an)//si on est en end ernière année on calcule le nb de jours $aa
				{
					foreach($moiss as $date => $mois)
					{
						foreach($mois as $dat)
						{						
							$aa++;
						}
					}
				}
				else
				{
					break;
				}
				$compteura++;
			}
			// echo 'www'.$mm.'www';
			// $mm = 0; //Compteur de mois qui s'incrémente de 1 afin de faire un compte indépendant des mois.
			$nbjrparmois = 0;
			$i = 1; //Compteur pour premier mois
			$a = 1; //Compteur pour la première année
			$nbmois = array();
			$nbjannee = array();
			foreach($aDates as $annee => $moiss)
			{	
				//Calculer le nombre d'années
				// echo $annee;
				if($a == 1)//Si on est en première année
				{
					$nbjannee[] = $a1;//nb de jours de la première année
				}
				elseif($a == $an)
				{
					$nbjannee[] = $aa;
				}
				else
				{
					$nbjannee[] = cal_days_in_year($annee);
				}
				foreach($moiss as $date => $mois)
				{
					if($i == 1)//on est au premier mois
					{
						//nb jours mois courant
						$nbmois[] = $m1;
					}
					elseif($i == $m)//Si on est  le dernier mois de la période on met le nb de jours
					{
						//nb de jours du dernier mois
						$nbmois[] = $mm;
					}
					else
					{
						//Pour les autres mois
						$nbmois[] = cal_days_in_month(CAL_GREGORIAN, $date, $annee);
					}
					$i++;
				}
				$a++;
			}
			// echo $i;
			// print_r($nbmois);
			//aDates contient nos entêtes de colonnes
			return $this->render('BaclooCrmBundle:Crm:planning.html.twig', array(
					'dates' => $aDates,
					'dstart' => $dStart,
					'dend' => $dEnd,
					'locations' => $locations,
					'nbjannee' => $nbjannee,
					'nbmois' => $nbmois
			));		
	}
		
	/**
	* function getDatesBetween
	* renvoie un tableau contenant toutes les dates, jour par jour,
	* comprises entre les deux dates passées en paramètre.
	* NB : les dates doivent être au format aaaa-mm-dd (mais on peut changer le parsing)
	* @param (string) $dStart : date de départ
	* @param (string) $dEnd : date de fin
	* @return (array) aDates : tableau des dates si succès
	* @return (bool) false : si échec
	*/
	public function createplanningslAction($mode, Request $request)
		{
			$dStart = date('Y-m-d');
			// $dStart = '2018-10-31';
			$dEnd = date('Y-m-d', strtotime("+20 days"));
			// $dEnd = '2018-11-30';
			
		//1.Récupérer les données de la table Machinessl
			$em = $this->getDoctrine()->getManager();
			
			if($mode == 'location')
			{
				$locations  = $em->getRepository('BaclooCrmBundle:Machinessl')		
							   ->findByEtat('En location');	
			}
			else
			{			
				$locations  = $em->getRepository('BaclooCrmBundle:Machinessl')		
							   ->findAll();	
			}	
			$defaultData = array();		
			$form = $this->createFormBuilder($defaultData)
				->add('filtre', 'choice', array(
						'choices'   => array(
							'location'   => 'En location',
							'all'   => 'Tout afficher',
						),
						'multiple'  => false,
					))	
				->getForm();
			$form->handleRequest($request);
			if($form->isValid()) {
				$data = $form->getData();
				$mode = $data['filtre'];	
				if(isset($mode) && $mode == 'all')
				{
					return $this->redirect($this->generateUrl('bacloocrm_planningsl', array('mode' => 'all' )));									
				}
				elseif(isset($mode) && $mode == 'location')
				{
					return $this->redirect($this->generateUrl('bacloocrm_planningsl', array('mode' => 'location' )));									
				}
			}
						   
		//2.On génère les entêtes de colonnes à partir de la fonction createplanning
			$iStart = strtotime ($dStart);//Formate une date/heure locale avec la Something is wronguration locale
			$iEnd = strtotime ($dEnd);
			if (false === $iStart || false === $iEnd) {
				return false;
			}
			$aStart = explode ('-', $dStart);
			$aEnd = explode ('-', $dEnd);
			if (count ($aStart) !== 3 || count ($aEnd) !== 3) {
				return false;
			}
			if (false === checkdate ($aStart[1], $aStart[2], $aStart[0]) || false === checkdate ($aEnd[1], $aEnd[2], $aEnd[0]) || $iEnd <= $iStart) {
				// return false;
			}
			for ($i = $iStart; $i < $iEnd + 86400; $i = strtotime ('+1 day', $i) ) {
				$sDateToArr = strftime ('%Y-%m-%d', $i);
				$sYear = substr ($sDateToArr, 0, 4);
				$sMonth = substr ($sDateToArr, 5, 2);
				$aDates[$sYear][$sMonth][] = $sDateToArr;
			}
			
			$nbannee = 0;
			$nbmoisparannee = 0;
			//Calcule le nombre de jours dans le mois
			$annee1 = date("Y", strtotime($dStart));
			$anneef = date("Y", strtotime($dStart));
			$anneefin = $anneef + 1;
			
			//Boucle parcours tableau année, mois, jours.
			//Celle-ci renvoie le nombre de  jours du premier mois m1
			$m11 = 1;
			foreach($aDates as $annee => $moiss)
			{
				foreach($moiss as $date => $mois)
				{
					if($m11 == 1)//si on est en m1 on procède sinon break
					{
						foreach($mois as $dat)
						{						
							$m11++;
						}
					}
					else
					{
						break;
					}
				}
				
			}
			$m1 = $m11-1;
			//Calcul du nb total de mois $m
			$m = 0;
			foreach($aDates as $annee => $moiss)
			{
				foreach($moiss as $date => $mois)
				{
					$m++;
				}
				
			}
			
			//Calcul du nb total d'années $a
			$an = 0;
			foreach($aDates as $annee => $moiss)
			{
				$an++;				
			}
// echo $m;			
			//Celle-ci renvoie le nombre de jours du dernier mois mm
			$mm = 0;
			$compteurm = 1;
			foreach($aDates as $annee => $moiss)
			{
				foreach($moiss as $date => $mois)
				{
					if($compteurm == $m)//si on est le dernier mois
					{
						foreach($mois as $dat)
						{						
							$mm++;
						}
					}
					else
					{}
				$compteurm++;
				}
				
			}
			
			//Celle-ci renvoie le nombre de jours de la première année $a1
			$a11 = 1;
			foreach($aDates as $annee => $moiss)
			{
				if($a11 == 1)//si on est en a1 on procède sinon break
				{
					foreach($moiss as $date => $mois)
					{
						foreach($mois as $dat)
						{						
							$a11++;
						}
					}
				}
				else
				{
					break;
				}
			}
			$a1 = $a11-1;
			//Fonction qui calcule le nombre de jours dans l'année
			function cal_days_in_year($year){
				$days=0; 
				for($month=1;$month<=12;$month++){ 
					$days = $days + cal_days_in_month(CAL_GREGORIAN,$month,$year);
				 }
			return $days;
			}			
			//Celle-ci renvoie le nombre de jours de la dernière année $aa
			$aa = 0;
			$compteura = 1;
			foreach($aDates as $annee => $moiss)
			{
				if($compteura == $an)//si on est en end ernière année on calcule le nb de jours $aa
				{
					foreach($moiss as $date => $mois)
					{
						foreach($mois as $dat)
						{						
							$aa++;
						}
					}
				}
				else
				{
					break;
				}
				$compteura++;
			}
			// echo 'www'.$mm.'www';
			// $mm = 0; //Compteur de mois qui s'incrémente de 1 afin de faire un compte indépendant des mois.
			$nbjrparmois = 0;
			$i = 1; //Compteur pour premier mois
			$a = 1; //Compteur pour la première année
			$nbmois = array();
			$nbjannee = array();
			foreach($aDates as $annee => $moiss)
			{	
				//Calculer le nombre d'années
				// echo $annee;
				if($a == 1)//Si on est en première année
				{
					$nbjannee[] = $a1;//nb de jours de la première année
				}
				elseif($a == $an)
				{
					$nbjannee[] = $aa;
				}
				else
				{
					$nbjannee[] = cal_days_in_year($annee);
				}
				foreach($moiss as $date => $mois)
				{
					if($i == 1)//on est au premier mois
					{
						//nb jours mois courant
						$nbmois[] = $m1;
					}
					elseif($i == $m)//Si on est  le dernier mois de la période on met le nb de jours
					{
						//nb de jours du dernier mois
						$nbmois[] = $mm;
					}
					else
					{
						//Pour les autres mois
						$nbmois[] = cal_days_in_month(CAL_GREGORIAN, $date, $annee);
					}
					$i++;
				}
				$a++;
			}
			
			// echo $i;
			// print_r($nbmois);
			//aDates contient nos entêtes de colonnes
			return $this->render('BaclooCrmBundle:Crm:planningsl.html.twig', array(
					'dates' => $aDates,
					'dstart' => $dStart,
					'dend' => $dEnd,
					'locations' => $locations,
					'nbjannee' => $nbjannee,
					'nbmois' => $nbmois,
					'mode' => $mode,
					'form' => $form->createView()
			));		
	}


	public function rechercheAction(Request $request)
	{
				$villes = 0;
				return $this->render('BaclooCrmBundle:Crm:recherche.html.twig', array(
				'villes' => $villes
				));
	}

	// public function larouteAction()
	// {
		// $usersess = $this->get('security.context')->getToken()->getUsername();
	
		
				// $repository = $this
				// ->getDoctrine()
				// ->getManager()->getRepository('BaclooCrmBundle:Fiche');
				
				// $villes = $repository->findByVille('gagny');
		
		// return $this->render('BaclooCrmBundle:Crm:result.html.twig', array(
									// 'villes' => $villes
									// ));	
	// }


	
	// public function listechantierAction(Request $request)
	// {
			// $term = $request->get('motcle');
	 
			// $em = $this->getDoctrine()->getManager();
			// $array = $em->getRepository('BaclooCrmBundle:Fiche')
					// ->updateData($term);
	  
        // $response = new Response(json_encode($array));
 
        // $response -> headers -> set('Content-Type', 'application/json');
        // return $response;
	// }	

    public function updatechantierAction(Request $request)
    {
			$search = $request->get('search');
			if(!empty($search))
			{
				$em = $this->getDoctrine()->getManager();	
				$query = $em->createQuery(
					'SELECT f
					FROM BaclooCrmBundle:Chantier f
					WHERE f.nom LIKE :nom'
				);
				$query->setParameter('nom', '%'.$search.'%');					
				$result = $query->getArrayResult();

				// Transformer le tableau associatif en un tableau standard
				$array = array();
				foreach ($result as $data) {
					$array[] = array("value"=>$data['id'],"label"=>$data['nom'],"adresse1"=>$data['adresse1'],"adresse2"=>$data['adresse2'],"adresse3"=>$data['adresse3'],"cp"=>$data['cp'],"ville"=>$data['ville']);
				}				
			}
		$response = new Response(json_encode($array));
		return $response;
    }	

    public function updatecodemachineinterneAction(Request $request)
    {
			$search = $request->get('search');
			if(!empty($search))
			{
				$em = $this->getDoctrine()->getManager();	
				$query = $em->createQuery(
					'SELECT f
					FROM BaclooCrmBundle:Machines f
					WHERE f.code LIKE :code
					AND f.etat = :etat'
				);
				$query->setParameter('code', '%'.$search.'%');					
				$query->setParameter('etat', 'Disponible');
				$result = $query->getArrayResult();

				// Transformer le tableau associatif en un tableau standard
				$array = array();
				foreach ($result as $data) {
					$array[] = array("label"=>$data['code']);
				}				
			}
		$response = new Response(json_encode($array));
		return $response;
    }	

    public function updatecodemachineinterneslAction(Request $request)
    {
			$search = $request->get('search');
			if(!empty($search))
			{
				$em = $this->getDoctrine()->getManager();	
				$query = $em->createQuery(
					'SELECT f
					FROM BaclooCrmBundle:Machinessl f
					WHERE f.code LIKE :code
					AND f.etat = :etat'
				);
				$query->setParameter('code', '%'.$search.'%');					
				$query->setParameter('etat', 'Disponible');
				$result = $query->getArrayResult();

				// Transformer le tableau associatif en un tableau standard
				$array = array();
				foreach ($result as $data) {
					$array[] = array("label"=>$data['code']);
				}				
			}
		$response = new Response(json_encode($array));
		return $response;
    }	

    public function updatecodemachineinternemixteAction(Request $request)
    {
			$search = $request->get('search');
			// $search = 'SL';
			if(!empty($search))
			{
				$em = $this->getDoctrine()->getManager();	
				$query = $em->createQuery(
					'SELECT f
					FROM BaclooCrmBundle:Machines f
					WHERE f.code LIKE :code
					AND f.etat = :etat'
				);
				$query->setParameter('code', '%'.$search.'%');					
				$query->setParameter('etat', 'Disponible');
				$result = $query->getArrayResult();
				if(!isset($result) or empty($result) or null === $result)
				{	//echo 'SLLLL';
					$query = $em->createQuery(
						'SELECT f
						FROM BaclooCrmBundle:Machinessl f
						WHERE f.code LIKE :code
						AND f.etat = :etat'
					);
					$query->setParameter('code', '%'.$search.'%');					
					$query->setParameter('etat', 'Disponible');
					$result = $query->getArrayResult();
				}
				// else{}print_r($result);
				// Transformer le tableau associatif en un tableau standard
				$array = array();
				foreach ($result as $data) {
					$array[] = array("label"=>$data['code']);
				}				
			}
		$response = new Response(json_encode($array));
		return $response;
    }	

	public function ajouterlocationAction($ficheid, $locid, $erreur, Request $request)
	{
		$objUser = $this->get('security.context')->getToken()->getUsername(); if(empty($objUser) or !isset($objUser) or $objUser == 'anon.'){return $this->redirect($this->generateUrl('fos_user_security_login'));}
		// echo 'erreur'.$erreur;
		// if ($this->container->has('profiler'))
		// {
			// $this->container->get('profiler')->disable();
		// }
		$today = date('Y-m-d');
		// $erreur = 0;
		$em = $this->getDoctrine()->getManager();//echo 'locid'.$locid;
					   
		$client  = $em->getRepository('BaclooCrmBundle:Fiche')		
					   ->findOneById($ficheid);

		$totalht = 0;//echo $locid;
		$totaltrspaller = 0;//echo $locid;
		$totaltrspretour = 0;//echo $locid;			
		$contributionverte = 0;//echo $locid;			
		$assurance = 0;//echo $locid;			
		$montantcarb = 0;
					   
		// On crée un objet Locata
		if($locid == 0)
		{		
			$locata = new Locata;
			$contrat = 0;
			$bdcrecu = 0;
			$montantcarb = 0;
		}
		else
		{
			$locata  = $em->getRepository('BaclooCrmBundle:Locata')		
						   ->findOneById($locid);
					   
			$client  = $em->getRepository('BaclooCrmBundle:Fiche')		
						   ->findOneById($ficheid);
						   
						   
			if($client->getAssurance() == 1 && $locata->getAssurance() == 0)
			{
				$locata->setAssurance(0);
				$em->persist($locata);
			}
			
			$contrat = $locata->getContrat();
			$bdcrecu = $locata->getBdcrecu();
			
			if(null == $locata->getChantierid())
			{
				$chantier = $em->getRepository('BaclooCrmBundle:Chantier')
									->findOneByNom($locata->getNomchantier());
						
				if(!empty($chantier))
				{					
					$chantierid = $chantier->getId();
					$locata->setChantierid($chantierid);
				}				
			}
			$em->flush();
		}
		$objUser = $this->get('security.context')->getToken()->getUsername(); if(empty($objUser) or !isset($objUser) or $objUser == 'anon.'){return $this->redirect($this->generateUrl('fos_user_security_login'));}
		$em = $this->getDoctrine()->getManager();
		$userdetails  = $em->getRepository('BaclooUserBundle:User')		
					   ->findOneByUsername($objUser);
					   
		$fiche  = $em->getRepository('BaclooCrmBundle:Fiche')		
					   ->findOneById($ficheid);			
		$userid = $userdetails->getId();
		$form = $this->createForm(new LocataType(), $locata);
		$today = date('Y-m-d');
		include('societe.php');

		//On met les locations dans un array pour controle ultérieur
		// $listeloc = array();
		// foreach ($locata->getLocations() as $loc) {
		  // $listeloc[] = $loc;
		// }		
		
		$em = $this->getDoctrine()->getManager();
		$modules  = $em->getRepository('BaclooCrmBundle:Modules')		
					   ->findOneByUsername($objUser);
// echo 'WWWWWWWWWWWWWWWWWWWWWWWWW';	
		// On récupère la requête
		$request = $this->get('request');
		// On vérifie qu'elle est de type POST
		 // echo $request->getMethod();

		if ($request->getMethod() == 'POST') 
		{//echo 'YYYYYYYYYYYYYYY';
			$form->bind($request);
		// On vérifie que les valeurs entrées sont correctes
		// $data = $form->getData();
			if ($form->isValid()){
				//Création du numero d'offre unique
echo 'loooogique';				
				//Création du numero de contrat unique
				// $data = $form->getData();
				$facturersamedi = $form->get('facturersamedi')->getData();
				$facturerdimanche = $form->get('facturerdimanche')->getData();
				if($facturersamedi == 1)
				{
					$locata->setFacturersamedi(1);
				}
				elseif($facturersamedi == 0)
				{

					$locata->setFacturersamedi(0);
				}
				if($facturerdimanche == 1)
				{
					$locata->setFacturerdimanche(1);
				}
				elseif($facturerdimanche == 0)
				{
					$locata->setFacturerdimanche(0);
				}

				$rempli = 0;		
				foreach($form->get('locations')->getData() as $loc)
				{
					if(null !== $loc->getCodemachine())
					{
						$rempli++;
						$machine2 = $em->getRepository('BaclooCrmBundle:Machines')
												->findBy(array('code' => $loc->getCodemachineinterne(), 'etat' => 'Réservé'));
												
						if(isset($machine2))
						{											
							foreach($machine2 as $macha)
							{
								if(isset($macha) && strtotime($macha->getDebutloc()) <= strtotime($loc->getFinloc()) && $macha->getEntreprise() != $loc->getEntreprise())
								{
									return $this->redirect($this->generateUrl('bacloocrm_ajouterlocation', array('ficheid' => $ficheid, 'locid' => $locid, 'erreur' => 6 )));
								}
							}
						}							
					}
				}		
				foreach($form->get('locationssl')->getData() as $loc)
				{
					if(null !== $loc->getCodemachine())
					{
						$rempli++;
					}
				}
				
				if($rempli == 0)
				{
					return $this->redirect($this->generateUrl('bacloocrm_ajouterlocation', array('ficheid' => $ficheid, 'locid' => $locid, 'erreur' => 3 )));	
				}
		
				// $debutloc = $form->get('debutloc')->getData();
				// $finloc = $form->get('finloc')->getData();
				$entreprise = $form->get('client')->getData();
				$nomchantier = $form->get('nomchantier')->getData();
				$adresse1 = $form->get('adresse1')->getData();
				$adresse2 = $form->get('adresse2')->getData();
				$adresse3 = $form->get('adresse3')->getData();
				$cp = $form->get('cp')->getData();
				$ville = $form->get('ville')->getData();
				$bdcrecu = $form->get('bdcrecu')->getData();
				$contrat = $form->get('contrat')->getData();
				$offreencours = $form->get('offreencours')->getData();
				$refusee = $form->get('offrerefusee')->getData();
				$locations = $form->get('locations')->getData();
					
				// if($contrat != 1 && $offreencours != 1)
				// {					
					$em->persist($locata);	
					$em->flush();
					$locid = $locata->getId();echo 'LOCAID'.$locid;
				// }				
				//Mise à jour de la table chantier si le chantier n'existe pas
				$chantier = $em->getRepository('BaclooCrmBundle:Chantier')
								->findOneByNom($nomchantier);
				if(empty($chantier))
				{
					$newchantier = new Chantier;
					$newchantier->setNom($nomchantier);
					$newchantier->setAdresse1($adresse1);
					$newchantier->setAdresse2($adresse2);
					$newchantier->setAdresse3($adresse3);
					$newchantier->setCp($cp);
					$newchantier->setVille($ville);
					$em->persist($newchantier);
					// $em->flush();
				}
				//Fin maj chantier

			//FACTURATION

				//Création du montant HT ligne par ligne
				$totalht = 0;//echo $locid;	
				$totaltrspaller = 0;
				$totaltrspretour = 0;
				$contributionverte = 0;
				$assurance = 0;

				//Calcul totalht locations parc
				foreach($form->get('locations')->getData() as $loc)
				{
						$nbjlocadeduire = 0;
						$nbjloc = 0;
						$nbjlocass = 0;
						$debutloc = $loc->getDebutloc();//echo $debutloc;
						$finloc = $loc->getFinloc();//echo $finloc;
						$dStart = $debutloc;
						$dEnd = $finloc;
						
						//mettre le if sur debutloc ou finloc et si <= date du jour >>>> redirect !
						if($debutloc <= $today && $loc->getEtatloc() != 'Location terminée')
						{
							$this->redirect($request->server->get('HTTP_REFERER'));
						}
						// fin redirect						
					//1.Récupérer les données de la table Machines
						   
					//2.On génère les entêtes de colonnes à partir de la fonction createplanning
						$iStart = strtotime ($dStart);//Formate une date/heure locale avec la Something is wronguration locale
						$iEnd = strtotime ($dEnd);
						if (false === $iStart || false === $iEnd) {
							// return false;
						}
						$aStart = explode ('-', $dStart);
						$aEnd = explode ('-', $dEnd);
						if (count ($aStart) !== 3 || count ($aEnd) !== 3) {
							// return false;
						}
						// if (false === checkdate ($aStart[1], $aStart[2], $aStart[0]) || false === checkdate ($aEnd[1], $aEnd[2], $aEnd[0]) || $iEnd <= $iStart) {
							// return false;
						// }
						
						$jour50 = $loc->getJour50();
						$jour100 = $loc->getJour100();
						
						$aDates = array();
						for ($i = $iStart; $i < $iEnd + 86400; $i = $i + 86400 ) {
							$sDateToArr = strftime ('%Y-%m-%d', $i);
							$sYear = substr ($sDateToArr, 0, 4);
							$sMonth = substr ($sDateToArr, 5, 2);
							$aDates[] = $sDateToArr;
						}	

					//on calcule le nombre de jours de location
									foreach($aDates as $dat)
									{						
										$time = strtotime($dat);
										// echo $dat;
										//Facturation WE ou pas
										$newformat = date('D',$time);

										if($facturersamedi == 1 && $newformat == 'Sat')
										{
											$nbjloc++;
										}
										elseif($facturerdimanche == 1 && $newformat == 'Sun')
										{
											$nbjloc++;
										}
										elseif($newformat == 'Sat' or $newformat == 'Sun')
										{}
										else
										{
											$nbjloc++;
										}
									}


						//nb jour pour les assurances car 7/7
									foreach($aDates as $dat)
									{
										$nbjlocass++;
									}
						$jour50 = $loc->getJour50();
						$jour100 = $loc->getJour100();	
									
						if(isset($jour50))
						{
							$nbjlocadeduire += $jour50*0.5;//nb jours corrigé
						}								
						if(isset($jour100))
						{
							$nbjlocadeduire += $jour100;//nb jours corrigé								
						}					
echo $nbjloc;			
						$nbjloc += $nbjlocadeduire;
						$nbjlocass += $nbjlocadeduire;
echo '***';
echo $nbjlocadeduire;						
echo 'HHHHH'.$nbjloc;
						if(null !== $loc->getLoyerp1())
						{
							$totalht += $nbjloc * $loc->getLoyerp1();
							$totalhtloc = $nbjloc * $loc->getLoyerp1();
							$totalhtlocass = $nbjlocass * $loc->getLoyerp1();
							$loyer = $loc->getLoyerp1();
						}
						elseif(null !== $loc->getLoyerp2())
						{
							$totalht += $nbjloc * $loc->getLoyerp2();
							$totalhtloc = $nbjloc * $loc->getLoyerp2();
							$totalhtlocass = $nbjlocass * $loc->getLoyerp2();
							$loyer = $loc->getLoyerp2();
						}
						elseif(null !== $loc->getLoyerp3())
						{
							$totalht += $nbjloc * $loc->getLoyerp3();
							$totalhtloc = $nbjloc * $loc->getLoyerp3();
							$totalhtlocass = $nbjlocass * $loc->getLoyerp3();
							$loyer = $loc->getLoyerp3();
						}
						elseif(null !== $loc->getLoyerp4())
						{
							$totalht += $nbjloc * $loc->getLoyerp4();
							$totalhtloc = $nbjloc * $loc->getLoyerp4();
							$totalhtlocass = $nbjlocass * $loc->getLoyerp4();
							$loyer = $loc->getLoyerp4();
						}
						elseif(null !== $loc->getLoyermensuel())
						{
							include('calculnbjlocmensuelle.php');	echo 'nbjloc'.$nbjloc;						
							$loyer = $loc->getLoyermensuel()/20;
							$totalht += $loyer * $nbjloc;
							$totalhtloc = $loyer * $nbjloc;					
							$totalhtlocass = ($loyer) * $nbjlocass;
						}
						// echo 'loyer';echo $loyer;
						$totaltrspaller += $loc->getTransportaller();
						$totaltrspretour += $loc->getTransportretour();
						
						if($loc->getContributionverte() == 1)
						{
							$contributionverte += 0.0215 * $loyer * $nbjloc;
						}
						
						if($loc->getAssurance() == 1)
						{
							$assurance += $totalhtlocass*0.10;
						}//echo 'nbjlocjm'.$nbjloc;	
echo 'machineid'.$loc->getMachineid();
						if($loc->getEtatloc() != 'Location terminée')
						{	
							$machine = $em->getRepository('BaclooCrmBundle:Machines')
									->findOneById($loc->getMachineid());
							if(isset($machine))
							{
								$machine->setDebutloc($loc->getDebutloc());		
								$machine->setFinloc($loc->getFinloc());	
								$em->persist($machine);
							}						
							$loc->setMontantloc($totalhtloc);
							$loc->setNbjloc($nbjloc);
							$loc->setNbjlocass($nbjlocass);
							$em->persist($loc);
						}
						$em->flush();
				}
				
				//Calcul total ht sous loc
				foreach ($form->get('locationssl')->getData() as $loc)
				{	//echo 'yyyyyyyyyy';
						$nbjlocadeduire = 0;
						$nbjloc = 0;
						$nbjlocass = 0;
						$debutloc = $loc->getDebutloc();//echo $debutloc;
						$finloc = $loc->getFinloc();//echo $finloc;
						$dStart = $debutloc;
						$dEnd = $finloc;
						
						//mettre le if sur debutloc ou finloc et si <= date du jour >>>> redirect !
						if($debutloc <= $today)
						{
							$this->redirect($request->server->get('HTTP_REFERER'));
						}
						// fin redirect						
					//1.Récupérer les données de la table Machines
						   
					//2.On génère les entêtes de colonnes à partir de la fonction createplanning
						$iStart = strtotime ($dStart);//Formate une date/heure locale avec la Something is wronguration locale
						$iEnd = strtotime ($dEnd);
						if (false === $iStart || false === $iEnd) {
							// return false;
						}
						$aStart = explode ('-', $dStart);
						$aEnd = explode ('-', $dEnd);
						if (count ($aStart) !== 3 || count ($aEnd) !== 3) {
							// return false;
						}
						// if (false === checkdate ($aStart[1], $aStart[2], $aStart[0]) || false === checkdate ($aEnd[1], $aEnd[2], $aEnd[0]) || $iEnd <= $iStart) {
							// return false;
						// }

						$jour50 = $loc->getJour50();
						$jour100 = $loc->getJour100();						
						$aDates = array();
						for ($i = $iStart; $i < $iEnd + 86400; $i = strtotime ('+1 day', $i) ) {
							$sDateToArr = strftime ('%Y-%m-%d', $i);
							$sYear = substr ($sDateToArr, 0, 4);
							$sMonth = substr ($sDateToArr, 5, 2);
							$aDates[] = $sDateToArr;
						}	

					//on calcule le nombre de jours de location
									foreach($aDates as $dat)
									{						
										$time = strtotime($dat);
										// echo $dat;
										//Facturation WE ou pas
										$newformat = date('D',$time);
										if($facturersamedi == 1 && $newformat == 'Sat')
										{
											$nbjloc++;
										}
										elseif($facturerdimanche == 1 && $newformat == 'Sun')
										{
											$nbjloc++;
										}
										elseif($newformat == 'Sat' or $newformat == 'Sun')
										{}
										else
										{
											$nbjloc++;
										}										
									}
					//nb jour pour les assurances car 7/7
									foreach($aDates as $dat)
									{
										$nbjlocass++;
									}
						$jour50 = $loc->getJour50();
						$jour100 = $loc->getJour100();									
						if(isset($jour50))
						{
							$nbjlocadeduire += $jour50*0.5;//nb jours corrigé
						}								
						if(isset($jour100))
						{
							$nbjlocadeduire += $jour100;//nb jours corrigé								
						}
echo $nbjloc;			
						$nbjloc += $nbjlocadeduire;
						$nbjlocass += $nbjlocadeduire;
echo '***';
echo $nbjlocadeduire;						
echo 'HHHHH'.$nbjloc;						
						if(null !== $loc->getLoyerp1())
						{
							$totalht += $nbjloc * $loc->getLoyerp1();
							$totalhtloc = $nbjloc * $loc->getLoyerp1();
							$totalhtlocass = $nbjlocass * $loc->getLoyerp1();
							$loyer = $loc->getLoyerp1();
						}
						elseif(null !== $loc->getLoyerp2())
						{
							$totalht += $nbjloc * $loc->getLoyerp2();
							$totalhtloc = $nbjloc * $loc->getLoyerp2();
							$totalhtlocass = $nbjlocass * $loc->getLoyerp2();
							$loyer = $loc->getLoyerp2();
						}
						elseif(null !== $loc->getLoyerp3())
						{
							$totalht += $nbjloc * $loc->getLoyerp3();
							$totalhtloc = $nbjloc * $loc->getLoyerp3();
							$totalhtlocass = $nbjlocass * $loc->getLoyerp3();
							$loyer = $loc->getLoyerp3();
						}
						elseif(null !== $loc->getLoyerp4())
						{
							$totalht += $nbjloc * $loc->getLoyerp4();
							$totalhtloc = $nbjloc * $loc->getLoyerp4();
							$totalhtlocass = $nbjlocass * $loc->getLoyerp4();
							$loyer = $loc->getLoyerp4();
						}
						elseif(null !== $loc->getLoyermensuel())
						{
							include('calculnbjlocmensuelle.php');							
							$loyer = $loc->getLoyermensuel()/20;
							$totalht += $loyer * $nbjloc;
							$totalhtloc = $loyer * $nbjloc;					
							$totalhtlocass = ($loyer) * $nbjlocass;
						}
echo 'LOYER';echo $loyer;						
echo 'totalhtloc';echo $totalhtloc;						
						$totaltrspaller += $loc->getTransportaller();
						$totaltrspretour += $loc->getTransportretour();
						
						if($loc->getContributionverte() == 1)
						{
							$contributionverte += 0.0215 * $loyer * $nbjloc;
						}
						
						if($loc->getAssurance() == 1)
						{
							$assurance += $totalhtlocass*0.10;
						}
						$loc->setMontantloc($totalhtloc);echo 'totalhtloc2';echo $totalhtloc;		
						$loc->setNbjloc($nbjloc);
						$loc->setNbjlocass($nbjlocass);
						$em->persist($loc);
						$em->flush();echo 'Loyerdef'.$loc->getMontantloc();
				}



				$montantvente = 0;			
				$totalvente = 0;			
				foreach($form->get('locataventes')->getData() as $ven)
				{
					$montantvente = $ven->getQuantite() * $ven->getPu();
					$totalvente += $ven->getQuantite() * $ven->getPu();
					
					$ven->setMontantvente($montantvente);
					$em->persist($ven);
					// $em->flush();
				}
			
					// if($locata->getRemise() > 0)
					// {
						// $totalht = $totalht - ($totalht * $locata->getRemise()/100);
					// }
// echo $totalht;						
					$locata->setTransportaller($totaltrspaller);
					$locata->setTransportretour($totaltrspretour);
					$locata->setAssurance($assurance);
					$locata->setContributionverte($contributionverte);	
					$locata->setMontantlocavente($totalvente);
					$locata->setMontantloc($totalht);
					// $em->persist($locata);
					// $em->flush();			
			//FIN FACTURATION	
//echo 'rrrrrrrrrrrrrr';			
				//MAJ de la table machine lorsqu'on reçoit un BDC pour réserver
				if($bdcrecu == 1 && $offreencours == 1 && $contrat == 0)
				{echo 'bdcrecu1 contrat0';			
					$locata  = $em->getRepository('BaclooCrmBundle:Locata')		
								   ->findOneById($locata->getId());

					//machines parc					
					foreach ($locata->getLocations() as $loc)
					{				
						//Insertion du code location à la machine
						$codelocations = $loc->getId();	
						$debutloc = $loc->getDebutloc();
						$finloc = $loc->getFinloc();					
echo 'x'.$codelocations;
						//On vérifie si une becane est déjà réservée sur cet ecode	
						$locations = $em->getRepository('BaclooCrmBundle:Locations')
								->findOneById($codelocations);				
						if(null === $locations->getCodemachineinterne() && isset($locations))
						{						
							$debutlocok = date('Y-m-d', strtotime($debutloc . ' -1 day'));
							$finlocok = date('Y-m-d', strtotime($finloc . ' +1 day'));
							$machin = $em->getRepository('BaclooCrmBundle:Machines')
									->unedispo($loc->getCodemachine(),$debutlocok, $finlocok);						
							if(!empty($machin))
							{
								foreach($machin as $mach)
								{
									$code = $mach['code'];
									$etat = $mach['etat'];
									$energie = $mach['energie'];
									$machineid = $mach['id'];
									$machinedef = $em->getRepository('BaclooCrmBundle:Machines')
											->dispoprecisenot($loc->getCodemachine(),$debutlocok, $finlocok);
									
										if($etat == 'Disponible')
										{
											break;
										}
								}
								if(empty($code))
								{
									foreach($machin as $mach)
									{
										$code = $mach['code'];
										$etat = $mach['etat'];
										$energie = $mach['energie'];
										$machineid = $mach['id'];
										$machinedef = $em->getRepository('BaclooCrmBundle:Machines')
												->dispoprecisenot($code, $debutlocok, $finlocok);
										
										if(empty($machinedef))
										{
											break;
										}
									}
								}
								if(!empty($code))
								{echo 'boucle2';
									foreach($machin as $mach)
									{echo 'les différents codes'.$mach['code'];
										$code = $mach['code'];
										$etat = $mach['etat'];
										$energie = $mach['energie'];
										
										$machineid = $mach['id'];
										$machinedef = $em->getRepository('BaclooCrmBundle:Machines')
												->dispoprecisenot($code, $debutlocok, $finlocok);
										
										if(!empty($machinedef))
										{echo 'machinedef pas vide';
											$machinedefresa = $em->getRepository('BaclooCrmBundle:Machines')
													->dispopreciseresa($code, $debutlocok, $finlocok);
											if(!isset($machinedefresa) and empty($machinedefresa))
											{	echo 'le code du break est '.$code;										
												break;
											}
										}
										else
										{
											echo 'machinedef est vide';
											break;
										}
									}
								}
							echo 'code1'.$code;
							
								//MAJ table Locations suite réservation
								$resaloc = $em->getRepository('BaclooCrmBundle:Locations')
										->findOneById($codelocations);
								$resaloc->setEtatloc('Réservé');
								$resaloc->setCodemachineinterne($code);
								$resaloc->setEnergie($energie);
								$resaloc->setMachineid($machineid);
								$em->persist($resaloc);
								$em->flush();
								
								if($etat == 'Disponible')
								{
									$today = date('Y-m-d');
									$diff = abs(strtotime($debutloc) - strtotime($today));
									$nbjrsdiff = $diff/86400;
								
									$machine = $em->getRepository('BaclooCrmBundle:Machines')
											->findOneByCode(array('code'=> $code, 'etat'=> 'Disponible'));
									if($nbjrsdiff < 2)
									{				
										$machine->setDebutloc($debutloc);
										$machine->setFinloc($finloc);
										$machine->setEtat('Réservé');
										$machine->setEntreprise($entreprise);
										$machine->setNomchantier($nomchantier);
										$machine->setcodelocations($codelocations);
										$machine->setcodecontrat($locid);
										$machine->setClientid($ficheid);
										$em->persist($machine);
										$em->flush();
									}
									else
									{
										$copymachine = clone $machine;											
										$copymachine->setDebutloc($debutloc);
										$copymachine->setFinloc($finloc);
										$copymachine->setEtat('Réservé');
										$copymachine->setEntreprise($entreprise);
										$copymachine->setNomchantier($nomchantier);
										$copymachine->setcodelocations($codelocations);
										$copymachine->setcodecontrat($locid);
										$copymachine->setClientid($ficheid);
										$copymachine->setOriginal(0);
										$em->persist($copymachine);
										$em->flush();								
									}
								}
								elseif($etat == 'En location')
								{
									$machine = $em->getRepository('BaclooCrmBundle:Machines')
											->findOneByCode(array('code'=> $code));
											
									$copymachine = clone $machine;											
									$copymachine->setDebutloc($debutloc);
									$copymachine->setFinloc($finloc);
									$copymachine->setEtat('Réservé');
									$copymachine->setEntreprise($entreprise);
									$copymachine->setNomchantier($nomchantier);
									$copymachine->setcodelocations($codelocations);
									$copymachine->setcodecontrat($locid);
									$copymachine->setClientid($ficheid);
									$copymachine->setOriginal(0);
									$em->persist($copymachine);
									$em->flush();
								}
								elseif($etat == 'Réservé')
								{
									$machine = $em->getRepository('BaclooCrmBundle:Machines')
											->findOneByCodelocations($codelocations);
									if(isset($machine))
									{
										$machine->setDebutloc($debutloc);
										$machine->setFinloc($finloc);
										$machine->setNomchantier($nomchantier);
										$em->persist($machine);
										$em->flush();									
									}
									else
									{
										$machine = $em->getRepository('BaclooCrmBundle:Machines')
												->findOneByCode(array('code'=> $code));
												
										$copymachine = clone $machine;											
										$copymachine->setDebutloc($debutloc);
										$copymachine->setFinloc($finloc);
										$copymachine->setEtat('Réservé');
										$copymachine->setEntreprise($entreprise);
										$copymachine->setNomchantier($nomchantier);
										$copymachine->setcodelocations($codelocations);
										$copymachine->setcodecontrat($locid);
										$copymachine->setClientid($ficheid);
										$copymachine->setOriginal(0);
										$em->persist($copymachine);
										$em->flush();								
									}
			
								}
								//Faire un if pour le cas d'un refus de l'offre alors qu'un BDC a été émis
								//Il faut donc supprimer la machine réservée en fonction du codelocation et du code origine
								if(isset($refusee) && $refusee == 1)
								{
									$machine = $em->getRepository('BaclooCrmBundle:Machines')
												->findOneBy(array('code'=> $code, 'codelocations' => $codelocations));
									//Si machine originale on fait un update
									if(isset($machine))
									{
										if($machine->getOriginal() == 1)
										{
											$machine->setCodelocations(NULL);
											$machine->setCodecontrat(NULL);
											$machine->setClientid($ficheid);
											$machine->setEntreprise(NULL);
											$machine->setNomchantier(NULL);
											$machine->setDebutloc(NULL);
											$machine->setFinloc(NULL);
											$machine->setEtat('Disponible');
											$em->persist($machine);
											$em->flush();
										}
										else
										{
											$em->remove($machine);
											$em->flush();
										}
									}
									$refusloc = $em->getRepository('BaclooCrmBundle:Locations')
											->findOneById($codelocations);
									$refusloc->setEtatloc('Refusé');$refusloc->setEtatlog('Refusé');
									$locata->setContrat(0);
									$em->persist($refusloc);
									$em->flush();						
										
								}
							}
						}
					}
					//Partie sous-locations
						$nbdemachines = 0;
						$nbdemachinesreservees = 0;
						if(null !== $locata->getLocationssl())
						{echo 'ttt';
							foreach ($locata->getLocationssl() as $loc)
							{
								if($loc->getTransport() == 1)
								{
									$nbdemachines++;
								}
								if(null !== $loc->getCodemachineinterne())
								{
									$nbdemachinesreservees++;
								}
							}
							
							$nbmachinesdispo = 0;
							foreach ($locata->getLocationssl() as $loc)
							{				
								//Insertion du code location à la machine
								$codelocations = $loc->getId();						
								// echo $codelocations;
								if($loc->getTransport() == 1)
								{

									$machine = $em->getRepository('BaclooCrmBundle:Machinessl')
											->findOneBy(array('codegenerique'=> $loc->getCodemachine(), 'loueur'=> $loc->getLoueur()));

									// On crée un objet Locatasl
									if(!empty($machine))
									{
										$nbmachinesdispo++;
									}
								}
							}
		echo 'XXXXXXXXXXXXXX';
		echo 'nbdemachines'.$nbdemachines;					
		echo 'nbmachinesdispo'.$nbmachinesdispo;					
						
							if($nbdemachinesreservees != $nbdemachines)
							{
								if($nbdemachines != $nbmachinesdispo)
								{
									$locata->setBdcrecu(0);
									$em->persist($locata);
									$em->flush();
									$em->clear();
									return $this->redirect($this->generateUrl('bacloocrm_ajouterlocation', array('ficheid' => $ficheid, 'locid' => $locid, 'erreur' => 1 )));
								}
							}						
							
							foreach ($locata->getLocationssl() as $loc)
							{		echo '22222';		

								//Insertion du code location à la machine
								$codelocations = $loc->getId();						
								// echo $codelocations;
								$debutloc = $loc->getDebutloc();
								$finloc = $loc->getFinloc();
								$debutlocok = date('Y-m-d', strtotime($debutloc . ' -1 day'));
								$finlocok = date('Y-m-d', strtotime($finloc . ' +1 day'));						
								$machin = $em->getRepository('BaclooCrmBundle:Machinessl')
										->unedispo($loc->getCodemachine(),$debutloc, $finloc, $loc->getLoueur());	
										
								if(!empty($machin))
								{
									foreach($machin as $mach)
									{
										$code = $mach['code'];
										$etat = $mach['etat'];
										$energie = $mach['energie'];
										$machineid = $mach['id'];
										$machinedef = $em->getRepository('BaclooCrmBundle:Machinessl')
												->dispoprecisenot($loc->getCodemachine(),$debutlocok, $finlocok, $loc->getLoueur());
										
										if($etat == 'Disponible')
										{
											break;
										}
									}
									if(empty($code))
									{echo '333';



										foreach($machin as $mach)
										{
											$code = $mach['code'];echo 'LE CODE'.$code;
											$etat = $mach['etat'];
											$energie = $mach['energie'];
											$machineid = $mach['id'];
											$machinedef = $em->getRepository('BaclooCrmBundle:Machinessl')
													->dispoprecisenot($code, $debutlocok, $finlocok, $loc->getLoueur());
											
											if(empty($machinedef))
											{
												break;
											}
										}
									}		


										//MAJ table Locations suite réservation
										$resaloc = $em->getRepository('BaclooCrmBundle:Locationssl')
												->findOneById($codelocations);
										$resaloc->setEtatloc('En location');
										$resaloc->setEtatlog('Livré chez le client');echo 'au dessus';
										if(!isset($code))
										{echo 'PAS ISset code';
											return $this->redirect($this->generateUrl('bacloocrm_ajouterlocation', array('ficheid' => $ficheid, 'locid' => $locid, 'erreur' => 7 )));
										}
										else
										{echo 'ISSET Code';
											$resaloc->setCodemachineinterne($code);
										}
										$resaloc->setEnergie($energie);
										$resaloc->setMachineid($machineid);
										$em->persist($resaloc);
										$em->flush();
										
										if($etat == 'Disponible')
										{
											$machine = $em->getRepository('BaclooCrmBundle:Machinessl')
													->findOneByCode(array('code'=> $code, 'etat'=> 'Disponible'));
															
											$machine->setDebutloc($debutloc);
											$machine->setFinloc($finloc);
											$machine->setEtat('En location');
											$machine->setEtatlog('Livré chez le client');
											$machine->setEntreprise($entreprise);
											$machine->setNomchantier($nomchantier);
											$machine->setcodelocations($codelocations);
											$machine->setcodecontrat($locid);
											$machine->setClientid($ficheid);
											$em->persist($machine);
											$em->flush();
										}
										// elseif($etat == 'En location')
										// {
											// $machine = $em->getRepository('BaclooCrmBundle:Machinessl')
													// ->findOneByCode(array('code'=> $code));
													
											// $copymachine = clone $machine;											
											// $copymachine->setDebutloc($debutloc);
											// $copymachine->setFinloc($finloc);
											// $copymachine->setEtat('Réservé');
											// $copymachine->setEntreprise($entreprise);
											// $copymachine->setNomchantier($nomchantier);
											// $copymachine->setcodelocations($codelocations);
											// $copymachine->setcodecontrat($locid);
											// $copymachine->setClientid($ficheid);
											// $copymachine->setLoueur($loc->getLoueur());
											// $em->persist($copymachine);
											// $em->flush();
										// }
										// elseif($etat == 'Réservé')
										// {
											// $machine = $em->getRepository('BaclooCrmBundle:Machinessl')
													// ->findOneByCodelocations($codelocations);
											// $machine->setDebutloc($debutloc);
											// $machine->setFinloc($finloc);
											// $machine->setNomchantier($nomchantier);
											// $em->persist($machine);
											// $em->flush();		
										// }
								}
								else//S'il n'y a pas de dispo
								{echo 'ajouuuuuuuuuuuuuuuuuuuuut1';echo $loc->getCodemachineinterne();
									if(null == $loc->getCodemachineinterne())
									{
										return $this->redirect($this->generateUrl('bacloocrm_ajouterlocation', array('ficheid' => $ficheid, 'locid' => $locid, 'erreur' => 2 )));	
									}
									//Puisqu'il n'y a pas de dispo on clone la machi
									// $machine = new Machinessl;
									// $machine->setCode($loc->getCodemachineinterne());
									// $machine->setCodegenerique($loc->getCodemachine());
									// $machine->setDescription($loc->getTypemachine());
									// $machine->setDebutloc($debutloc);
									// $machine->setFinloc($finloc);
									// $machine->setEtat('En location');
									// $machine->setEntreprise($entreprise);
									// $machine->setNomchantier($nomchantier);
									// $machine->setcodelocations($codelocations);
									// $machine->setcodecontrat($locid);
									// $machine->setClientid($ficheid);
									// $machine->setLoueur($loc->getLoueur());
									// $machine->setOriginal(1);

									// $em->persist($machine);
									// $em->flush();									
								}

								//Faire un if pour le cas d'un refus de l'offre alors qu'un BDC a été émis
								//Il faut donc supprimer la machine réservée en fonction du codelocation et du code origine
								if(isset($refusee) && $refusee == 1)
								{
									$machine = $em->getRepository('BaclooCrmBundle:Machinessl')
											->findOneBy(array('code'=> $code, 'codelocations' => $codelocations));
									//Si machine originale on fait un update
									if($machine->getOriginal() == 1)
									{
										$machine->setCodelocations(NULL);
										$machine->setCodecontrat(NULL);
										$machine->setClientid($ficheid);
										$machine->setEntreprise(NULL);
										$machine->setNomchantier(NULL);
										$machine->setDebutloc(NULL);
										$machine->setFinloc(NULL);
										$machine->setEtat('Disponible');
										$em->persist($machine);
										// $em->flush();
									}
									else
									{
										$em->remove($machine);
										// $em->flush();
									}
									$refusloc = $em->getRepository('BaclooCrmBundle:Locationssl')
											->findOneById($codelocations);
									$refusloc->setEtatloc('Refusé');$refusloc->setEtatlog('Refusé');
									$em->persist($refusloc);
									// $em->flush();				


								}								
							}				
						}
				}
				

				if($contrat == 1 && $offreencours == 1)
				{
					echo 'contrat ok offre ok';
					$locata  = $em->getRepository('BaclooCrmBundle:Locata')		
								   ->findOneById($locata->getId());
					$totalht = 0;
					$montantcarb = 0;
					$contributionverte = 0;
					if(null !== $locata->getLocations())
					{	
echo 'xxx';echo $loc->getId().'-';echo $nbjloc;echo 'xxx';					

						//Partie locations parc
						foreach ($locata->getLocations() as $loc)
						{
							$jour50 = $loc->getJour50();
							$jour100 = $loc->getJour100();
							if($loc->getEtatloc() != 'Location terminée')
							{
								//Insertion du code location à la machine
								$codelocations = $loc->getId();//echo $codelocations;
								$debutloc = $loc->getDebutloc();
								$finloc = $loc->getFinloc();						
								// echo $codelocationssl;
								//On vérifie si une becane est déjà réservée sur cet ecode	
								$locations = $em->getRepository('BaclooCrmBundle:Locations')
										->findOneById($codelocations);				
								if(null === $locations->getCodemachineinterne() && isset($locations))
								{	echo 'il est null';					
										$debutlocok = date('Y-m-d', strtotime($debutloc . ' -1 day'));
										$finlocok = date('Y-m-d', strtotime($finloc . ' +1 day'));
										$machin = $em->getRepository('BaclooCrmBundle:Machines')
												->unedispo($loc->getCodemachine(),$debutlocok, $finlocok);						
										if(!empty($machin))
										{							
											foreach($machin as $mach)
											{
												$code = $mach['code'];
												$etat = $mach['etat'];
												$energie = $mach['energie'];
												$machineid = $mach['id'];
												$machinedef = $em->getRepository('BaclooCrmBundle:Machines')
														->dispoprecisenot($loc->getCodemachine(),$debutlocok, $finlocok);
												
									if($etat == 'Disponible')
									{
										break;
									}
								}
								if(empty($code))
								{
									foreach($machin as $mach)
									{
										$code = $mach['code'];
										$etat = $mach['etat'];
										$energie = $mach['energie'];
										$machineid = $mach['id'];
										$machinedef = $em->getRepository('BaclooCrmBundle:Machines')
												->dispoprecisenot($code, $debutlocok, $finlocok);
										
										if(empty($machinedef))
										{
											break;
										}
									}
								}
								if(!empty($code))
								{echo 'boucle2';
									foreach($machin as $mach)
									{echo 'les différents coces'.$mach['code'];
										$code = $mach['code'];
										$etat = $mach['etat'];
										$energie = $mach['energie'];
										$machineid = $mach['id'];
										$machinedef = $em->getRepository('BaclooCrmBundle:Machines')
												->dispoprecisenot($code, $debutlocok, $finlocok);
										
										if(!empty($machinedef))
										{
											$machinedefresa = $em->getRepository('BaclooCrmBundle:Machines')
													->dispopreciseresa($code, $debutlocok, $finlocok);
											if(empty($machinedefresa))
											{											
												break;
											}
										}
										else
										{
											echo 'machinedef est vide';
											break;
										}
									}
								}
							echo 'code1'.$code;
											
											//MAJ table Locations suite réservation
											$resaloc = $em->getRepository('BaclooCrmBundle:Locations')
													->findOneById($codelocations);
											$resaloc->setEtatloc('Réservé');
											$resaloc->setCodemachineinterne($code);
											$resaloc->setEnergie($energie);
											$resaloc->setMachineid($machineid);
											$em->persist($resaloc);
											$em->flush();
											
											if($etat == 'Disponible')
											{
												$today = date('Y-m-d');
												$diff = abs(strtotime($debutloc) - strtotime($today));
												$nbjrsdiff = $diff/86400;
											
												$machine = $em->getRepository('BaclooCrmBundle:Machines')
														->findOneByCode(array('code'=> $code, 'etat'=> 'Disponible'));
												if($nbjrsdiff < 2)
												{				
													$machine->setDebutloc($debutloc);
													$machine->setFinloc($finloc);
													$machine->setEtat('Réservé');
													$machine->setEntreprise($entreprise);
													$machine->setNomchantier($nomchantier);
													$machine->setcodelocations($codelocations);
													$machine->setcodecontrat($locid);
													$machine->setClientid($ficheid);
													$em->persist($machine);
													$em->flush();
												}
												else
												{
													$copymachine = clone $machine;											
													$copymachine->setDebutloc($debutloc);
													$copymachine->setFinloc($finloc);
													$copymachine->setEtat('Réservé');
													$copymachine->setEntreprise($entreprise);
													$copymachine->setNomchantier($nomchantier);
													$copymachine->setcodelocations($codelocations);
													$copymachine->setcodecontrat($locid);
													$copymachine->setClientid($ficheid);
													$copymachine->setOriginal(0);
													$em->persist($copymachine);
													$em->flush();								
												}
											}
											elseif($etat == 'En location')
											{
												$machine = $em->getRepository('BaclooCrmBundle:Machines')
														->findOneByCode(array('code'=> $code));
														
												$copymachine = clone $machine;											
												$copymachine->setDebutloc($debutloc);
												$copymachine->setFinloc($finloc);
												$copymachine->setEtat('Réservé');
												$copymachine->setEntreprise($entreprise);
												$copymachine->setNomchantier($nomchantier);
												$copymachine->setcodelocations($codelocations);
												$copymachine->setcodecontrat($locid);
												$copymachine->setClientid($ficheid);
												$copymachine->setOriginal(0);
												$em->persist($copymachine);
												$em->flush();
											}
											elseif($etat == 'Réservé')
											{
												$machine = $em->getRepository('BaclooCrmBundle:Machines')
														->findOneByCodelocations($codelocations);
												if(isset($machine))
												{
													$machine->setDebutloc($debutloc);
													$machine->setFinloc($finloc);
													$machine->setNomchantier($nomchantier);
													$em->persist($machine);
													$em->flush();									
												}
												else
												{
													$machine = $em->getRepository('BaclooCrmBundle:Machines')
															->findOneByCode(array('code'=> $code));
															
													$copymachine = clone $machine;											
													$copymachine->setDebutloc($debutloc);
													$copymachine->setFinloc($finloc);
													$copymachine->setEtat('Réservé');
													$copymachine->setEntreprise($entreprise);
													$copymachine->setNomchantier($nomchantier);
													$copymachine->setcodelocations($codelocations);
													$copymachine->setcodecontrat($locid);
													$copymachine->setClientid($ficheid);
													$copymachine->setOriginal(0);
													$em->persist($copymachine);
													$em->flush();								
												}
						
											}
											//Faire un if pour le cas d'un refus de l'offre alors qu'un BDC a été émis
											//Il faut donc supprimer la machine réservée en fonction du codelocation et du code origine
											if(isset($refusee) && $refusee == 1)
											{
												$machine = $em->getRepository('BaclooCrmBundle:Machines')
															->findOneBy(array('code'=> $code, 'codelocations' => $codelocations));
												//Si machine originale on fait un update
												if($machine->getOriginal() == 1)
												{
													$machine->setCodelocations(NULL);
													$machine->setCodecontrat(NULL);
													$machine->setClientid($ficheid);
													$machine->setEntreprise(NULL);
													$machine->setNomchantier(NULL);
													$machine->setDebutloc(NULL);
													$machine->setFinloc(NULL);
													$machine->setEtat('Disponible');
													$em->persist($machine);
													$em->flush();
												}
												else
												{
													$em->remove($machine);
													$em->flush();
												}
												$refusloc = $em->getRepository('BaclooCrmBundle:Locations')
														->findOneById($codelocations);
												$refusloc->setEtatloc('Refusé');$refusloc->setEtatlog('Refusé');
												$em->persist($refusloc);
												$em->flush();						
													
											}
										}
								}
								else
								{ echo 'il est pas null le code machine';
									$machine = $em->getRepository('BaclooCrmBundle:Machines')
											->findOneByCodelocations($codelocations);
									if(isset($machine))
									{										
										$machine2 = $em->getRepository('BaclooCrmBundle:Machines')
																->findBy(array('code' => $loc->getCodemachineinterne(), 'etat' => 'Réservé'));
										if(isset($machine2))
										{											
											foreach($machine2 as $macha)
											{
												if(isset($macha) && strtotime($macha->getDebutloc()) <= strtotime($loc->getFinloc()) && $macha->getEntreprise() != $loc->getEntreprise())
												{
													return $this->redirect($this->generateUrl('bacloocrm_ajouterlocation', array('ficheid' => $ficheid, 'locid' => $locid, 'erreur' => 6 )));
												}
											}
										}
										else
										{
											$machine->setDebutloc($loc->getDebutloc());
											$machine->setFinloc($loc->getFinloc());
											$em->persist($machine);
											$em->flush();									
										}
									}								
								}
							}
							else //Location terminée
							{
								//Insertion du code location à la machine
								$codelocations = $loc->getId();
								$debutloc = $loc->getDebutloc();
								$finloc = $loc->getFinloc();
								$machine = $em->getRepository('BaclooCrmBundle:Machines')
										->findOneByCodelocations($codelocations);
								if(isset($machine))
								{
									$machine->setDebutloc($debutloc);
									$machine->setFinloc($finloc);
									$em->persist($machine);								
								}
							}	
								$montantlocactu = 0;
								$nbjlocadeduire = 0;
								//On récupère le loyer
								if(null !== $loc->getLoyerp1())
								{
									$loyer = $loc->getLoyerp1();
								}
								elseif(null !== $loc->getLoyerp2())
								{
									$loyer = $loc->getLoyerp2();
								}
								elseif(null !== $loc->getLoyerp3())
								{
									$loyer = $loc->getLoyerp3();
								}
								elseif(null !== $loc->getLoyerp4())
								{
									$loyer = $loc->getLoyerp4();
								}
								elseif(null !== $loc->getLoyermensuel())
								{
									$nbjloc = $loc->getNbjloc();
									include('calculnbjlocmensuelle.php');							
									$loyer = $loc->getLoyermensuel()/20;
								}								
								if($jour50 != 0)
								{
									$nbjlocadeduire += $jour50*0.5;//nb jours corrigé
								}								
								if($jour100 != 0)
								{
									$nbjlocadeduire += $jour100;//nb jours corrigé								
								}
								$nbjloc = $loc->getNbjloc();
								$montantlocactu = $loyer * ($nbjloc - $nbjlocadeduire);
								$montantcarb += $loc->getMontantcarb();
								$loc->setMontantloc($montantlocactu);
								$loc->setCloture(0);
								// $loc->setNbjloc($nbjloc - $nbjlocadeduire);
								$em->persist($loc);
								$em->flush();
								$nbjloc += $nbjlocadeduire;
								$nbjlocass += $nbjlocadeduire;
								$totalht += $nbjloc * $loyer;
								
								if($loc->getContributionverte() == 1)
								{
									$contributionverte += 0.0215 * $loyer * $nbjloc;

								}
						}
					}	
					//Partie sous-locations

					if(null !== $locata->getLocationssl())
					{	
echo 'YYY';echo $locata->getId().'-';
echo $nbjloc;echo 'xxx';					
						$nbdemachines = 0;
						$nbdemachinesreservees = 0;

						foreach ($locata->getLocationssl() as $loc)
						{
							if(null !== $loc->getCodemachine())
							{
								$nbdemachines++;
							}
							if(null !== $loc->getCodemachineinterne())
							{
								$nbdemachinesreservees++;
							}
						}
						
						$nbmachinesdispo = 0;
						foreach ($locata->getLocationssl() as $loc)
						{				
							//Insertion du code location à la machine
							$codelocations = $loc->getId();						
							// echo $codelocations;

								$machine = $em->getRepository('BaclooCrmBundle:Machinessl')
										->findOneBy(array('codegenerique'=> $loc->getCodemachine(), 'loueur'=> $loc->getLoueur()));

								// On crée un objet Locatasl
								if(!empty($machine))
								{
									$nbmachinesdispo++;
								}
						}
	echo 'XXXXXXXXXXXXXX';
	echo 'nbdemachines'.$nbdemachines;					
	echo 'nbmachinesdispo'.$nbmachinesdispo;					
	echo 'nbdemachinesreservees'.$nbdemachinesreservees;echo '<<';					
					if($nbdemachinesreservees != $nbdemachines)
					{
						if($nbdemachines != $nbmachinesdispo)
						{
							$locata->setContrat(0);
							$em->persist($locata);
							$em->flush();
							$em->clear();
							return $this->redirect($this->generateUrl('bacloocrm_ajouterlocation', array('ficheid' => $ficheid, 'locid' => $locid, 'erreur' => 1 )));
						}
					}					

						//Partie locations parc
						foreach ($locata->getLocationssl() as $loc)
						{
							$jour50 = $loc->getJour50();
							$jour100 = $loc->getJour100();
							if($loc->getEtatloc() != 'Location terminée')
							{
								//Insertion du code location à la machine
								$codelocations = $loc->getId();//echo $codelocations;
								$debutloc = $loc->getDebutloc();
								$finloc = $loc->getFinloc();						
								// echo $codelocationssl;
								//On vérifie si une becane est déjà réservée sur cet ecode	
								$locations = $em->getRepository('BaclooCrmBundle:Locationssl')
										->findOneById($codelocations);				
								if(null === $locations->getCodemachineinterne() && isset($locations))
								{						
										$debutlocok = date('Y-m-d', strtotime($debutloc . ' -1 day'));
										$finlocok = date('Y-m-d', strtotime($finloc . ' +1 day'));
										$machin = $em->getRepository('BaclooCrmBundle:Machinessl')
												->unedispo($loc->getCodemachine(),$debutlocok, $finlocok, $loc->getLoueur());						
										if(!empty($machin))
										{							
											foreach($machin as $mach)
											{
												$code = $mach['code'];
												$etat = $mach['etat'];
												$energie = $mach['energie'];
												$machineid = $mach['id'];
												$machinedef = $em->getRepository('BaclooCrmBundle:Machinessl')
														->dispoprecisenot($loc->getCodemachine(),$debutlocok, $finlocok, $loc->getLoueur());
												
												if($etat == 'Disponible')
												{
													break;
												}
											}
											if(empty($code))
											{
												foreach($machin as $mach)
												{
													$code = $mach['code'];
													$etat = $mach['etat'];
													$energie = $mach['energie'];
													$machineid = $mach['id'];
													$machinedef = $em->getRepository('BaclooCrmBundle:Machinessl')
															->dispoprecisenot($code, $debutlocok, $finlocok, $loc->getLoueur());
													
													if(empty($machinedef))
													{
														break;
													}
												}
											}
											
											//MAJ table Locations suite réservation
											$resaloc = $em->getRepository('BaclooCrmBundle:Locationssl')
													->findOneById($codelocations);
											$resaloc->setEtatloc('En location');
											if($loc->getTransport() == 1)
											{
												$resaloc->setEtatlog('Prêt au départ');
											}
											else
											{
												//$resaloc->setEtatlog('Livré chez le client');
												$resaloc->setEtatlog('Prêt au départ');
											}
											if(!isset($code))
											{
												return $this->redirect($this->generateUrl('bacloocrm_ajouterlocation', array('ficheid' => $ficheid, 'locid' => $locid, 'erreur' => 7 )));
											}
											else
											{	
												$resaloc->setCodemachineinterne($code);
											}
											$resaloc->setEnergie($energie);
											$resaloc->setMachineid($machineid);
											$em->persist($resaloc);
											$em->flush();
											
											if($etat == 'Disponible')
											{
												$machine = $em->getRepository('BaclooCrmBundle:Machinessl')
														->findOneByCode(array('code'=> $code, 'etat'=> 'Disponible'));
																
												$machine->setDebutloc($debutloc);
												$machine->setFinloc($finloc);
												$machine->setEtat('En location');
												if($loc->getTransport() == 1)
												{
													$machine->setEtatlog('Prêt au départ');
												}
												else
												{
													//$resaloc->setEtatlog('Livré chez le client');
													$resaloc->setEtatlog('Prêt au départ');
												}
												$machine->setEntreprise($entreprise);
												$machine->setNomchantier($nomchantier);
												$machine->setcodelocations($codelocations);
												$machine->setcodecontrat($locid);
												$machine->setClientid($ficheid);
												$em->persist($machine);
												$em->flush();
											}
											else
											{
												$locata->setContrat(0);
												$em->persist($locata);
												$em->flush();
												return $this->redirect($this->generateUrl('bacloocrm_ajouterlocation', array('ficheid' => $ficheid, 'locid' => $locid, 'erreur' => 2 )));	
											}
											// elseif($etat == 'En location')
											// {
												// $machine = $em->getRepository('BaclooCrmBundle:Machinessl')
														// ->findOneByCode(array('code'=> $code));
														
												// $copymachine = clone $machine;											
												// $copymachine->setDebutloc($debutloc);
												// $copymachine->setFinloc($finloc);
												// $copymachine->setEtat('Réservé');
												// $copymachine->setEntreprise($entreprise);
												// $copymachine->setNomchantier($nomchantier);
												// $copymachine->setcodelocations($codelocations);
												// $copymachine->setcodecontrat($locid);
												// $copymachine->setClientid($ficheid);
												// $copymachine->setOriginal(0);
												// $em->persist($copymachine);
												// $em->flush();
											// }
											// elseif($etat == 'Réservé')
											// {
												// $machine = $em->getRepository('BaclooCrmBundle:Machinessl')
														// ->findOneByCodelocations($codelocations);
												// if(isset($machine))
												// {
													// $machine->setDebutloc($debutloc);
													// $machine->setFinloc($finloc);
													// $machine->setNomchantier($nomchantier);
													// $em->persist($machine);
													// $em->flush();									
												// }
												// else
												// {
													// $machine = $em->getRepository('BaclooCrmBundle:Machinessl')
															// ->findOneByCode(array('code'=> $code));
															
													// $copymachine = clone $machine;											
													// $copymachine->setDebutloc($debutloc);
													// $copymachine->setFinloc($finloc);
													// $copymachine->setEtat('Réservé');
													// $copymachine->setEntreprise($entreprise);
													// $copymachine->setNomchantier($nomchantier);
													// $copymachine->setcodelocations($codelocations);
													// $copymachine->setcodecontrat($locid);
													// $copymachine->setClientid($ficheid);
													// $em->persist($copymachine);
													// $em->flush();								
												// }
						
											// }
											//Faire un if pour le cas d'un refus de l'offre alors qu'un BDC a été émis
											//Il faut donc supprimer la machine réservée en fonction du codelocation et du code origine
											if(isset($refusee) && $refusee == 1)
											{
												$machine = $em->getRepository('BaclooCrmBundle:Machinessl')
															->findOneBy(array('code'=> $code, 'codelocations' => $codelocations));
												//Si machine originale on fait un update
												if($machine->getOriginal() == 1)
												{
													$machine->setCodelocations(NULL);
													$machine->setCodecontrat(NULL);
													$machine->setClientid($ficheid);
													$machine->setEntreprise(NULL);
													$machine->setNomchantier(NULL);
													$machine->setDebutloc(NULL);
													$machine->setFinloc(NULL);
													$machine->setEtat('Disponible');
													$em->persist($machine);
													$em->flush();
												}
												else
												{
													$em->remove($machine);
													$em->flush();
												}
												$refusloc = $em->getRepository('BaclooCrmBundle:Locationssl')
														->findOneById($codelocations);
												$refusloc->setEtatloc('Refusé');$refusloc->setEtatlog('Refusé');
												$em->persist($refusloc);
												$em->flush();						
													
											}
										}
								}
								else
								{
									$machine = $em->getRepository('BaclooCrmBundle:Machinessl')
											->findOneByCodelocations($codelocations);
									if(isset($machine))
									{
										$machine->setDebutloc($loc->getDebutloc());
										$machine->setFinloc($loc->getFinloc());
										$em->persist($machine);
										$em->flush();									

									}								
								}
							}
							else //Location terminée
							{
								//Insertion du code location à la machine
								$codelocations = $loc->getId();
								$debutloc = $loc->getDebutloc();
								$finloc = $loc->getFinloc();
								$machine = $em->getRepository('BaclooCrmBundle:Machinessl')
										->findOneByCodelocations($codelocations);
								if(isset($machine))
								{
									$machine->setDebutloc($debutloc);
									$machine->setFinloc($finloc);
									$em->persist($machine);								
								}
							}	
								$montantlocactu = 0;
								$nbjlocadeduire = 0;
								//On récupère le loyer
								if(null !== $loc->getLoyerp1())
								{
									$loyer = $loc->getLoyerp1();
								}
								elseif(null !== $loc->getLoyerp2())
								{
									$loyer = $loc->getLoyerp2();
								}
								elseif(null !== $loc->getLoyerp3())
								{
									$loyer = $loc->getLoyerp3();
								}
								elseif(null !== $loc->getLoyerp4())
								{
									$loyer = $loc->getLoyerp4();
								}
								elseif(null !== $loc->getLoyermensuel())
								{
									$nbjloc = $loc->getNbjloc();
									include('calculnbjlocmensuelle.php');							
									$loyer = $loc->getLoyermensuel()/20;
								}								
								if($jour50 != 0)
								{
									$nbjlocadeduire += $jour50*0.5;//nb jours corrigé
								}								
								if($jour100 != 0)
								{
									$nbjlocadeduire += $jour100;//nb jours corrigé								
								}
								$nbjloc = $loc->getNbjloc();
								$montantlocactu = $loyer * ($nbjloc - $nbjlocadeduire);
								$montantcarb += $loc->getMontantcarb();
								$loc->setMontantloc($montantlocactu);
								$loc->setCloture(0);
								// $loc->setNbjloc($nbjloc - $nbjlocadeduire);
								$em->persist($loc);
								$em->flush();
								$nbjloc += $nbjlocadeduire;
								$nbjlocass += $nbjlocadeduire;
								$totalht += $nbjloc * $loyer;
								
								if($loc->getContributionverte() == 1)
								{
									$contributionverte += 0.0215 * $loyer * $nbjloc;
								}
						}
					}
echo $locata->getId();
echo 'iioiioiiiio'; 					
					$montantloclocatafrs = 0;
					foreach ($locata->getLocationssl() as $loc)
					{	echo 'pppppppppppppppppppppppp';echo $loc->getId();		
						//Insertion du code location à la machine
						$codelocationssl = $loc->getId();						
						// echo $codelocationssl;
echo $loc->getCodemachineinterne();
							if($loc->getEtatlog() == 'Livré chez le client' or $loc->getEtatlog() == 'Déposé en agence')
							{}
							else
							{
								$machine = $em->getRepository('BaclooCrmBundle:Machinessl')
										->findOneById($loc->getMachineid());

								$machine->setDebutloc($loc->getDebutloc());
								$machine->setFinloc($loc->getFinloc());
								$machine->setEtat('En location');
								$machine->setEntreprise($entreprise);
								$machine->setNomchantier($nomchantier);
								$machine->setCodelocations($codelocationssl);
								$machine->setCodecontrat($locid);
								$machine->setClientid($ficheid);
								$em->persist($machine);
			
								if($loc->getTransport() == 1 && $loc->getEtatloc() != 'En location' && $loc->getEtatloc() != 'Location terminée')
								{
									$loc->setEtatloc('Prêt au départ');
									$loc->setEtatlog('Prêt au départ');
									$machine->setEtat('Prêt au départ');
									$machine->setEtatlog('Prêt au départ');
								}
								elseif($loc->getEtatloc() == 'En location')
								{
									$loc->setEtatloc('En location');
									$loc->setEtatlog('Livré chez le client');
									$machine->setEtat('En location');
									$machine->setEtatlog('Livré chez le client');
								}
								// elseif($loc->getEtatloc('Location terminée')
								// {
									// $loc->setEtatloc('En location');
									// $loc->setEtatlog('Livré chez le client');
									// $machine->setEtat('En location');
									// $machine->setEtatlog('Livré chez le client');
								// }


							}
								// $em->persist($loc);
							// $em->flush();
								$montantlocactu = 0;
								$nbjlocadeduire = 0;
								//On récupère le loyer
								if(null !== $loc->getLoyerp1())
								{
									$loyer = $loc->getLoyerp1();
								}
								elseif(null !== $loc->getLoyerp2())
								{
									$loyer = $loc->getLoyerp2();
								}
								elseif(null !== $loc->getLoyerp3())
								{
									$loyer = $loc->getLoyerp3();
								}
								elseif(null !== $loc->getLoyerp4())
								{
									$loyer = $loc->getLoyerp4();
								}
								elseif(null !== $loc->getLoyermensuel())
								{
									$nbjloc = $loc->getNbjloc();
									include('calculnbjlocmensuelle.php');							
									$loyer = $loc->getLoyermensuel()/20;

								}								
								if($jour50 != 0)
								{
									$nbjlocadeduire += $jour50*0.5;//nb jours corrigé
								}								
								if($jour100 != 0)
								{
									$nbjlocadeduire += $jour100;//nb jours corrigé
								
								}
								$nbjloc = $loc->getNbjloc();	//??
								$montantlocactu = $loyer * ($nbjloc - $nbjlocadeduire);
								$montantcarb += $loc->getMontantcarb();
								$loc->setMontantloc($montantlocactu);
								$loc->setCloture(0);
								// $loc->setNbjloc($nbjloc - $nbjlocadeduire);
								$em->persist($loc);
								$em->flush();

								$nbjloc += $nbjlocadeduire;
								$nbjlocass += $nbjlocadeduire;
								// $totalht += $nbjloc * $loyer;echo 'TOTALHT0'.$totalht;						
								// if($loc->getContributionverte() == 1)
								// {
									 // $contributionverte += ($nbjlocass*$loyer)*0.0215;

								// }

					//GENERATION DES BDC AUTOMATIQUES
							
						//On est dans contrat, on vérifie s'il s'agit d'une sous-location
						if(null !== $loc->getDebutloc() && null !== $loc->getFinloc())
						{		echo '1 ';											
							//Si c'est une sous-location, on vérifie qu'un bdc (locatafrs) n'a pas été créé pour cette sl.
								$bdc  = $em->getRepository('BaclooCrmBundle:Locatafrs')		
										->findOneBy(array('codelocatasl' => $locata->getId(), 'fournisseur' => $loc->getLoueur()));
									
								//Si pas de Locatafrs, on créée un new
								if(!isset($bdc))
								{echo '2 ';	
									$bdcauto = new Locatafrs;
									$bdcauto->setChantierid($locata->getChantierid());
									$bdcauto->setNomchantier($locata->getNomchantier());
									$bdcauto->setAdresse1($locata->getAdresse1());
									$bdcauto->setAdresse2($locata->getAdresse2());
									$bdcauto->setAdresse3($locata->getAdresse3());
									$bdcauto->setCp($locata->getCp());
									$bdcauto->setVille($locata->getVille());
									$bdcauto->setFournisseurid($loc->getLoueurid());
									$bdcauto->setFournisseur($loc->getLoueur());				
									$bdcauto->setUser($locata->getUser());
									$bdcauto->setContact($locata->getContactchantier());
									$bdcauto->setDatemodif($locata->getDatemodif());
									$bdcauto->setAnnulee(0);
									$bdcauto->setEtatbdc(0);
									$bdcauto->setMontantloc($montantloclocatafrs);//Montant HT de la sous-loc. déterminer plus bas
									$bdcauto->setCommentaire($locata->getCommentaire());
									$bdcauto->setCodelocatasl($locata->getId());
									$em->persist($bdcauto);
									$em->flush();
									$erreur = 4;
								}
								else
								{echo '3 ';	
									//Si deja locatafrs, on appelle l'existant et on fait les updates nécessaires
									$bdcauto  = $bdc;
									$erreur = 5;									
								}

									//On verifie si le bdcloc existe dejà
									$bdclocauto  = $em->getRepository('BaclooCrmBundle:Locationsfrs')		
											 ->findOneByCodelocationsl($loc->getId());
	
									//Si existe pas on le créée
									if(!isset($bdclocauto))
									{echo '4 ';	
										$bdclocauto = new Locationsfrs;
										$bdclocauto->setCodeclient($locata->getClientid());
										$bdclocauto->setFournisseurid($loc->getLoueurid());
										$bdclocauto->setFournisseur($loc->getLoueur());
										$bdclocauto->setReference('location');
										$bdclocauto->setDebutloc($loc->getDebutloc());
										$bdclocauto->setFinloc($loc->getFinloc());
										$bdclocauto->setMensuel(0);
										$bdclocauto->setDesignation($loc->getTypemachine());
										$bdclocauto->setPu(0);
										$bdclocauto->setQuantite($loc->getNbjloc());
										$bdclocauto->setMontantht(0);
										$bdclocauto->setCodelocationsl($loc->getId());
										$bdclocauto->addLocatafr($bdcauto);
										$bdcauto->addLocationsfr($bdclocauto);
										$em->persist($bdclocauto);
										$em->flush();
									}
									else
									{echo '5 ';	
										//si existe on fait un update
										$bdclocauto->setCodeclient($locata->getClientid());
										$bdclocauto->setFournisseurid($loc->getLoueurid());
										$bdclocauto->setFournisseur($loc->getLoueur());
										$bdclocauto->setReference('location');
										$bdclocauto->setDebutloc($loc->getDebutloc());
										$bdclocauto->setFinloc($loc->getFinloc());
										$bdclocauto->setMensuel(0);
										$bdclocauto->setDesignation($loc->getTypemachine());
										$bdclocauto->setPu(0);
										$bdclocauto->setQuantite($loc->getNbjloc());
										$bdclocauto->setMontantht(0);
										$bdclocauto->setCodelocationsl($loc->getId());
										$em->persist($bdclocauto);
										$em->flush();										
									}								
							
						}
					//FIN GENERATION DES BDC AUTOMATIQUES
					}
					foreach ($locata->getLocataventes() as $loca)
					{
						$articles = $em->getRepository('BaclooCrmBundle:Articlesenvente')
							->findOneBy(array('reffrs' => $loca->getRefarticle(), 'designation' => $loca->getDescription()));						
						
						if(!empty($articles) && $loca->getStockenr() == 1)
						{				
							if($articles->getStockenr() < $articles->getStocktheo() - $loca->getQuantite())
							{
								$quantite = ($articles->getStocktheo() - $loca->getQuantite()) - $articles->getStockenr();
								$articles->setStocktheo($articles->getStocktheo() + $quantite);
								$articles->setStockreel($articles->getStockreel() + $quantite);
								$em->persist($articles);
								$em->flush();
								$em->clear();
								$articles = $em->getRepository('BaclooCrmBundle:Articlesenvente')
									->findOneBy(array('reffrs' => $loca->getRefarticle(), 'designation' => $loca->getDescription()));		
								$articles->setStockenr($articles->getStocktheo() - $loca->getQuantite());
							}
							elseif($articles->getStockenr() > $articles->getStocktheo() - $loca->getQuantite())
							{
								$quantite = $articles->getStockenr() - ($articles->getStocktheo() - $loca->getQuantite()) ;
								$articles->setStocktheo($articles->getStocktheo() - $quantite);
								$articles->setStockreel($articles->getStockreel() - $quantite);
								$em->persist($articles);
								$em->flush();
								$em->clear();	
								$articles = $em->getRepository('BaclooCrmBundle:Articlesenvente')
									->findOneBy(array('reffrs' => $loca->getRefarticle(), 'designation' => $loca->getDescription()));	
								$articles->setStockenr($articles->getStocktheo() - $loca->getQuantite());
							}								
							$loca->setStock($articles->getStocktheo());
						}
						else
						{
							if(isset($articles))
							{
								$articles->setStockenr($articles->getStocktheo());
								$articles->setStocktheo($articles->getStocktheo() - $loca->getQuantite());
								$articles->setStockreel($articles->getStockreel() - $loca->getQuantite());	
								$loca->setStockenr(1);								
								$loca->setStock($articles->getStocktheo());	
							}								
						}
						if(isset($articles))
						{						
							if($articles->getStockmini() > $articles->getStocktheo())
							{
								$articles->setAlerte(1);
							}
							elseif($articles->getStocktheo() > $articles->getStockmini())
							{
								$articles->setAlerte(0);								
							}
							$em->persist($articles);
							$em->flush();
						}					
					}echo 'TOTALHT'.$totalht;
					$locata->setMontantloc($totalht);
					$locata->setMontantcarb($montantcarb);
					$locata->setContributionverte($contributionverte);
					$em->persist($locata);
					$em->flush();
				}
				if(isset($refusee) && $refusee == 1 && $offreencours == 1)
				{
					foreach ($locata->getLocations() as $loc)
					{				
						//Insertion du code location à la machine
						$codelocations = $loc->getId();	
						$debutloc = $loc->getDebutloc();
						$finloc = $loc->getFinloc();					
						$code = $loc->getCodemachineinterne();					
						// echo $codelocations;
				
						$machine = $em->getRepository('BaclooCrmBundle:Machines')
									->findOneBy(array('code'=> $code, 'codelocations' => $codelocations));
						//Si machine originale on fait un update
						if(isset($machine))
						{
							if($machine->getOriginal() == 1)
							{
								$machine->setCodelocations(NULL);
								$machine->setCodecontrat(NULL);
								$machine->setClientid(0);
								$machine->setEntreprise(NULL);
								$machine->setNomchantier(NULL);
								$machine->setDebutloc(NULL);
								$machine->setFinloc(NULL);
								$machine->setEtat('Disponible');
								$em->persist($machine);
								// $em->flush();
							}
							else
							{
								$em->remove($machine);
								// $em->flush();
							}
						}
						$refusloc = $em->getRepository('BaclooCrmBundle:Locations')
								->findOneById($codelocations);
						$refusloc->setEtatloc('Refusé');$refusloc->setEtatlog('Refusé');
						$locata->setContrat(0);
						$em->persist($refusloc);
						// $em->flush();	
					}
					foreach ($locata->getLocationssl() as $loc)
					{				
						//Insertion du code location à la machine
						$codelocations = $loc->getId();	
						$debutloc = $loc->getDebutloc();
						$finloc = $loc->getFinloc();					
						$code = $loc->getCodemachineinterne();					
						// echo $codelocations;
				
						$machine = $em->getRepository('BaclooCrmBundle:Machinessl')
									->findOneBy(array('code'=> $code, 'codelocations' => $codelocations));
						//Si machine originale on fait un update
						if(isset($machine))
						{
							if($machine->getOriginal() == 1)
							{
								$machine->setCodelocations(NULL);
								$machine->setCodecontrat(NULL);
								$machine->setClientid($ficheid);
								$machine->setEntreprise(NULL);
								$machine->setNomchantier(NULL);
								$machine->setDebutloc(NULL);
								$machine->setFinloc(NULL);
								$machine->setEtat('Disponible');
								$em->persist($machine);
								// $em->flush();
							}
							else
							{
								$em->remove($machine);
								// $em->flush();
							}
						}
						$refusloc = $em->getRepository('BaclooCrmBundle:Locationssl')
								->findOneById($codelocations);
						$refusloc->setEtatloc('Refusé');$refusloc->setEtatlog('Refusé');
						$locata->setContrat(0);
						$em->persist($refusloc);
						// $em->flush();	

					}						
				}				
				echo 'ttttt';echo $locid;
				$em->persist($locata);
				$em->flush();	
			//Fin maj table machine
			// $em = $this->getDoctrine()->getManager();
				if($locid == 0)
				{
					$locid = $locata->getId();
				}
				if(!isset($erreur)){$erreur = 0;}				
				// On redirige vers la page de visualisation de la fiche nouvellement créée
				return $this->redirect($this->generateUrl('bacloocrm_ajouterlocation', array('ficheid' => $ficheid, 'locid' => $locid, 'erreur' => $erreur)));
			}
		}
		$listedispos = array();
		if($locid > 0)
		{//echo 'laaa';
			// $dstart = new \DateTime($locata->getDebutloc());
			// $dend = new \DateTime($locata->getFinloc());
			$listedispos = array();
			$listecodes = array();
			
			//Calcul total ht loc parc
			foreach($locata->getLocations() as $loca)
			{
				$dstart = $loca->getDebutloc();
				$dend = $loca->getFinloc();
				$dstartok = date('Y-m-d', strtotime($dstart . ' -1 day'));
				$dendok = date('Y-m-d', strtotime($dend . ' +1 day'));				
				$codemachine = $loca->getCodemachine();
				$dispos = $em->getRepository('BaclooCrmBundle:Machines')
						->dispos($codemachine, $dstartok, $dendok);
				// print_r($dispos);echo $codemachine;
				$i = 0;				
				foreach($dispos as $disp)
				{//echo 'AAA'.($disp['code']).'AAA';
					$dispo = $em->getRepository('BaclooCrmBundle:Machines')
							->dispoprecise($disp['code'], $dstart, $dend);
							// print_r($dispo);
					if(!empty($dispo)){$i = $i + 1;}
				}
				$listedispos[$codemachine]= count($dispos) - $i;		


			//FACTURATION
				$dStart = $loca->getDebutloc();
				$dEnd = $loca->getFinloc();
				
			//1.Récupérer les données de la table Machines
				   
			//2.On génère les entêtes de colonnes à partir de la fonction createplanning
			$nbjloc = $loca->getNbjloc();	
				//nb jour pour les assurances car 7/7
				$nbjlocass = $loca->getNbjlocass();	
				// echo 'xx'.$nbjloc.'xx';
				// echo 'hh'.$i.'hh';
				
				//Création du montant HT ligne par ligne
				

					$grille  = $em->getRepository('BaclooCrmBundle:Grille')		
								   ->findByCodeclient($locata->getClientid());




						if(null !== $loca->getLoyerp1())
						{
							$totalht += $nbjloc * $loca->getLoyerp1();
							$totalhtloc = $nbjloc * $loca->getLoyerp1();
							$totalhtlocass = $nbjlocass * $loca->getLoyerp1();
							$loyer = $loca->getLoyerp1();
						}
						elseif(null !== $loca->getLoyerp2())
						{
							$totalht += $nbjloc * $loca->getLoyerp2();
							$totalhtloc = $nbjloc * $loca->getLoyerp2();
							$totalhtlocass = $nbjlocass * $loca->getLoyerp2();
							$loyer = $loca->getLoyerp2();
						}
						elseif(null !== $loca->getLoyerp3())
						{
							$totalht += $nbjloc * $loca->getLoyerp3();
							$totalhtloc = $nbjloc * $loca->getLoyerp3();
							$totalhtlocass = $nbjlocass * $loca->getLoyerp3();
							$loyer = $loca->getLoyerp3();
						}
						elseif(null !== $loca->getLoyerp4())
						{
							$totalht += $nbjloc * $loca->getLoyerp4();
							$totalhtloc = $nbjloc * $loca->getLoyerp4();
							$totalhtlocass = $nbjlocass * $loca->getLoyerp4();
							$loyer = $loca->getLoyerp4();
						}
						elseif(null !== $loca->getLoyermensuel())
						{
							include('calculnbjlocamensuelle.php');							
							$loyer = $loca->getLoyermensuel()/20;
							$totalht += $loyer * $nbjloc;
							$totalhtloc = $loyer * $nbjloc;					
							$totalhtlocass = $loyer * $nbjlocass;
						}
						// echo 'c'.$totalht;echo 'nbjloccc'.$nbjloc;	



						if(null !== $loca->getMontantcarb() && $loca->getMontantcarb()>0)
						{
							$montantcarb += $loca->getLitrescarb()*1.97;
						}
						
						$totaltrspaller += $loca->getTransportaller();
						$totaltrspretour += $loca->getTransportretour();
						
						if($loca->getContributionverte() == 1)
						{
							$contributionverte += 0.0215 * $loyer * $nbjloc;
						}
						
						if($loca->getAssurance() == 1)
						{
							$assurance += $totalhtlocass*0.10;
						}
						// $loca->setMontantloc($totalhtloc);
						// $loca->setNbjloc($nbjloc);
						// $em->persist($loca);
						// $em->flush();
			}	
			
			//Calcul totalht Sous loc
			foreach($locata->getLocationssl() as $loca)
			{
				$dstart = $loca->getDebutloc();
				$dend = $loca->getFinloc();
				$dstartok = date('Y-m-d', strtotime($dstart . ' -1 day'));
				$dendok = date('Y-m-d', strtotime($dend . ' +1 day'));				
				$codemachine = $loca->getCodemachine();
				$dispos = $em->getRepository('BaclooCrmBundle:Machinessl')
						->dispos($codemachine, $dstartok, $dendok, $loca->getLoueur());
				// print_r($dispos);echo $codemachine;
				$i = 0;				
				foreach($dispos as $disp)
				{//echo 'AAA'.($disp['code']).'AAA';
					$dispo = $em->getRepository('BaclooCrmBundle:Machinessl')
							->dispoprecise($disp['code'], $dstart, $dend, $loca->getLoueur());
							// print_r($dispo);
					if(!empty($dispo)){$i = $i + 1;}
				}
				$listedispos[$codemachine]= count($dispos) - $i;		


			//FACTURATION
				$dStart = $loca->getDebutloc();
				$dEnd = $loca->getFinloc();
				
			//1.Récupérer les données de la table Machines
				   
			//2.On génère les entêtes de colonnes à partir de la fonction createplanning
			$nbjloc = $loca->getNbjloc();	
				//nb jour pour les assurances car 7/7
				$nbjlocass = $loca->getNbjlocass();				
				// echo 'xx'.$nbjloc.'xx';
				// echo 'hh'.$i.'hh';
				
				//Création du montant HT ligne par ligne
				

				$grille  = $em->getRepository('BaclooCrmBundle:Grille')		
							   ->findByCodeclient($locata->getClientid());
					
				if(null !== $loca->getLoyerp1())
				{
					$totalht += $nbjloc * $loca->getLoyerp1();
					$totalhtloc = $nbjloc * $loca->getLoyerp1();
					$totalhtlocass = $nbjlocass * $loca->getLoyerp1();
					$loyer = $loca->getLoyerp1();
				}
				elseif(null !== $loca->getLoyerp2())
				{
					$totalht += $nbjloc * $loca->getLoyerp2();
					$totalhtloc = $nbjloc * $loca->getLoyerp2();
					$totalhtlocass = $nbjlocass * $loca->getLoyerp2();
					$loyer = $loca->getLoyerp2();
				}
				elseif(null !== $loca->getLoyerp3())
				{
					$totalht += $nbjloc * $loca->getLoyerp3();
					$totalhtloc = $nbjloc * $loca->getLoyerp3();
					$totalhtlocass = $nbjlocass * $loca->getLoyerp3();
					$loyer = $loca->getLoyerp3();
				}
				elseif(null !== $loca->getLoyerp4())
				{
					$totalht += $nbjloc * $loca->getLoyerp4();
					$totalhtloc = $nbjloc * $loca->getLoyerp4();
					$totalhtlocass = $nbjlocass * $loca->getLoyerp4();
					$loyer = $loca->getLoyerp4();
				}
				elseif(null !== $loca->getLoyermensuel())
				{
					include('calculnbjlocamensuelle.php');							
					$loyer = $loca->getLoyermensuel()/20;
					$totalht += $loyer * $nbjloc;
					$totalhtloc = $loyer * $nbjloc;					
					$totalhtlocass = $loyer * $nbjlocass;
				}
				
				if(null !== $loca->getMontantcarb() && $loca->getMontantcarb()>0)
				{
					$montantcarb += $loca->getLitrescarb()*1.97;
				}
				
				$totaltrspaller += $loca->getTransportaller();
				$totaltrspretour += $loca->getTransportretour();
				
				if($loca->getContributionverte() == 1)
				{
					$contributionverte += 0.0215 * $loyer * $nbjloc;
				}
				
				if($loca->getAssurance() == 1)
				{
					$assurance += $totalhtlocass*0.10;
				}
				// $loca->setMontantloc($totalhtloc);
				// $loca->setNbjloc($nbjloc);
				// $em->persist($loca);
				// $em->flush();
			}			


			$montantvente = 0;			
			$totalvente = 0;			
			foreach($locata->getLocataventes() as $ven)
			{
				$montantvente = $ven->getQuantite() * $ven->getPu();
				$totalvente += $ven->getQuantite() * $ven->getPu();
				// $em->flush();
			}
			
			// if($locata->getRemise() > 0)
			// {
				// $totalht = $totalht - ($totalht * $locata->getRemise()/100);
			// }//echo 'b'.$totalht;


				// $locata->setMontantloc($totalht);
				// $locata->setTransportaller($totaltrspaller);
				// $locata->setTransportretour($totaltrspretour);
				// $locata->setAssurance($assurance);
				// $locata->setContributionverte($contributionverte);
				// $em->persist($locata);
				// $em->flush();		
			//FIN FACTURATION	
		}
		else
		{//echo 'ici';
			$totalht = 0;
			$nbjloc = 0;
			$nbjlocass = 0;
			$totalvente = 0;
			$grille = array();
		}//echo 'a'.$totalht;
		
		$factures = $em->getRepository('BaclooCrmBundle:Factures')		
					   ->findOneByCodelocata($locid);	
		if(isset($factures)){$afac = 'ok';}else{$afac = 'nok';}		   
		$userdetails  = $em->getRepository('BaclooUserBundle:User')		
					   ->findOneByUsername($objUser);
		$roleuser = $userdetails->getRoleuser();		
			// echo $grille;
			
	//On regarde dans les factures si deja compta
		$factures = $em->getRepository('BaclooCrmBundle:Factures')
			->findOneByCodelocata($locid);			
		if(isset($factures))
		{
			$proforma = 'ok';	
		}
		else
		{
			if($client->getDelaireglement() == 1)
			{
				$proforma = 'nok';
			}
			else
			{
				$proforma = 'ok';
			}

		}
		$documents  = $em->getRepository('BaclooCrmBundle:Document')		
					   ->findBy(array('codecontrat' => $locid, 'type' => 'contrat'));
		return $this->render('BaclooCrmBundle:Crm:nouvelle_location.html.twig', array('form' => $form->createView(),
																			'date' => $today,
																			'roleuser' => $roleuser,
																			'client' => $client,
																			'contrat' => $contrat,
																			'bdcrecu' => $bdcrecu,
																			'usersociete' => $societe,
																			'modules' => $modules,
																			'listedispos' => $listedispos,
																			'entreprise' => $client->getRaisonSociale(),
																			'id' => $ficheid,
																			'erreur' => $erreur,
																			'locid' => $locid,
																			'totalht' => $totalht,
																			'montantlocavente' => $totalvente,
																			'totaltrspaller' => $totaltrspaller,
																			'totaltrspretour' => $totaltrspretour,
																			'assurance' => $assurance,
																			'contributionverte' => $contributionverte,
																			'montantcarb' => $montantcarb,
																			'nbjloc' => $nbjloc,
																			'grille' => $grille,
																			'afac' => $afac,
																			'proforma' => $proforma,
																			'documents' => $documents,
																			'user' => $objUser));
	}
		

	public function requete1Action(Request $request)
	{
		// $request = $request->get('request');
		// if($request == 1){
			$search = $request->get('search');
			if(!empty($search))
			{
				$em = $this->getDoctrine()->getManager();	
				$query = $em->createQuery(
					'SELECT f
					FROM BaclooCrmBundle:Fiche f
					WHERE f.raisonSociale LIKE :raisonSociale'
				);
				$query->setParameter('raisonSociale', '%'.$search.'%');					
				$result = $query->getArrayResult();

				// Transformer le tableau associatif en un tableau standard
				$array = array();
				foreach ($result as $data) {
					$array[] = array("value"=>$data['typemachine'],"label"=>$data['raisonSociale'],"id"=>$data['loyerp1'],"desc"=>$data['loyerp2'],"icon"=>$data['loyerp3'],"p4"=>$data['loyerp4'],"p5"=>$data['loyermensuel']);
				}				
			}
		$response = new Response(json_encode($array));
		return $response;
		// }
	}
	
	public function requete2Action(Request $request)
	{
		// $request = $request->get('request');
		// if($request == 2){
			$userid = $request->get('userid');
			if(!empty($userid))
			{
				$em = $this->getDoctrine()->getManager();	
				$query = $em->createQuery(
					'SELECT f.raisonSociale, f.cp
					FROM BaclooCrmBundle:Fiche f
					WHERE f.id = :id'
				);
				$query->setParameter('id', $userid);				
				$result = $query->getArrayResult();				
				$users_arr1 = array();

				foreach ($result as $data) {
					$users_arr1[] = array("cp" => $data['cp'], "raisonSociale" => $data['raisonSociale']);
				};
			}
			$users_arr = new Response(json_encode($users_arr1));
			return $users_arr;
		// }
	}
	
	public function requete1grilleAction(Request $request)
	{
		// $request = $request->get('request');
		// if($request == 1){
			$search = $request->get('search');
			$codeclient = $request->get('codeclient');
			if(!empty($search))
			{
				$em = $this->getDoctrine()->getManager();	
				$query = $em->createQuery(
					'SELECT f
					FROM BaclooCrmBundle:Grille f
					WHERE f.codemachineinterne LIKE :codemachineinterne
					AND f.codeclient = :codeclient'
				);
				$query->setParameter('codemachineinterne', '%'.$search.'%');					
				$query->setParameter('codeclient', $codeclient);					
				$result = $query->getArrayResult();
				// Transformer le tableau associatif en un tableau standard
				$array = array();
				foreach ($result as $data) {
					$array[] = array("value"=>$data['typemachine'],"label"=>$data['codemachineinterne'],"id"=>$data['loyerp1'],"desc"=>$data['loyerp2'],"icon"=>$data['loyerp3'],"p4"=>$data['loyerp4'],"p5"=>$data['loyermensuel']);
				}
				
				if(empty($result))
				{
					$query = $em->createQuery(
					'SELECT f
					FROM BaclooCrmBundle:Grille f
					WHERE f.codemachineinterne LIKE :codemachineinterne
					AND f.codeclient = :codeclient'
				);
				$query->setParameter('codemachineinterne', '%'.$search.'%');					
				// $query->setParameter('codeclient', 5451);//Local					
				$query->setParameter('codeclient', 5458);//Prod					
				$result = $query->getArrayResult();
				// Transformer le tableau associatif en un tableau standard
				$array = array();
					foreach ($result as $data) {
						$array[] = array("value"=>$data['typemachine'],"label"=>$data['codemachineinterne'],"id"=>$data['loyerp1'],"desc"=>$data['loyerp2'],"icon"=>$data['loyerp3'],"p4"=>$data['loyerp4'],"p5"=>$data['loyermensuel']);
					}
				}
				
				if(empty($result))
				{
					$query = $em->createQuery(
						'SELECT f
						FROM BaclooCrmBundle:Machines f
						WHERE f.codegenerique LIKE :codegenerique
						Group by f.codegenerique'
					);
					$query->setParameter('codegenerique', '%'.$search.'%');					
					$result = $query->getArrayResult();
					// Transformer le tableau associatif en un tableau standard
					$array = array();
					foreach ($result as $data) {
						$array[] = array("value"=>$data['description'],"label"=>$data['codegenerique'],"id"=>'',"desc"=>'',"icon"=>'',"p4"=>'');
					}
				}				
			}
		$response = new Response(json_encode($array)); echo 'toto'; echo $search;
		// return $response;
		// }
	}
	
	public function requete1grille2Action(Request $request)
	{
		// $request = $request->get('request');
		// if($request == 1){
			$search = $request->get('search');
			$codeclient = $request->get('codeclient');
			if(!empty($search))
			{
				$em = $this->getDoctrine()->getManager();	
				$query = $em->createQuery(
						'SELECT f
						FROM BaclooCrmBundle:Machines f
						WHERE f.codegenerique LIKE :codegenerique
						Group by f.codegenerique'
					);
					$query->setParameter('codegenerique', '%'.$search.'%');					
					$result = $query->getArrayResult();
					// Transformer le tableau associatif en un tableau standard
					$array = array();
					foreach ($result as $data) {
						$array[] = array("value"=>$data['description'],"label"=>$data['codegenerique'],"id"=>'',"desc"=>'',"icon"=>'',"p4"=>'');
					}			
			}
		$response = new Response(json_encode($array));
		return $response;
		// }
	}
	
	public function requete1grilleslAction(Request $request)
	{
		// $request = $request->get('request');
		// if($request == 1){
			$search = $request->get('search');
			$loueur = $request->get('loueur');
			if(!empty($search))
			{
				$em = $this->getDoctrine()->getManager();	
				$query = $em->createQuery(
					'SELECT f
					FROM BaclooCrmBundle:Grillesl f
					WHERE f.codemachineinterne LIKE :codemachineinterne
					AND f.loueur = :loueur'
				);
				$query->setParameter('codemachineinterne', '%'.$search.'%');					
				$query->setParameter('loueur', $loueur);					
				$result = $query->getArrayResult();
				// Transformer le tableau associatif en un tableau standard
				$array = array();
				foreach ($result as $data) {
					$array[] = array("value"=>$data['typemachine'],"label"=>$data['codemachineinterne'],"id"=>$data['loyerp1'],"desc"=>$data['loyerp2'],"icon"=>$data['loyerp3'],"p4"=>$data['loyerp4'],"p5"=>$data['loyermensuel']);
				}
				
				if(empty($result))
				{
					$query = $em->createQuery(
						'SELECT f
						FROM BaclooCrmBundle:Machinessl f
						WHERE f.codegenerique LIKE :codegenerique
						AND f.loueur = :loueur
						Group by f.codegenerique'
					);
					$query->setParameter('codegenerique', '%'.$search.'%');				
					$query->setParameter('loueur', $loueur);					
					$result = $query->getArrayResult();
					// Transformer le tableau associatif en un tableau standard
					$array = array();
					foreach ($result as $data) {
						$array[] = array("value"=>$data['description'],"label"=>$data['codegenerique'],"id"=>'',"desc"=>'',"icon"=>'',"p4"=>'');
					}
				}				
			}
		$response = new Response(json_encode($array));
		return $response;
		// }
	}
	
	public function requete2grilleAction(Request $request)
	{
		// $request = $request->get('request');
		// if($request == 2){
			$codeclient = $request->get('userid');
			$codemachineinterne = $request->get('codemachineinterne');
			if(!empty($codeclient))
			{
				$em = $this->getDoctrine()->getManager();	
				$query = $em->createQuery(
					'SELECT f.codemachineinterne, f.typemachine, f.loyerp1, f.loyerp2, f.loyerp3, f.loyerp4, f.loyermensuel
					FROM BaclooCrmBundle:Grille f
					WHERE f.codeclient = :codeclient
					AND f.codemachineinterne = :codemachineinterne'
				);
				$query->setParameter('codeclient', $codeclient);				
				$query->setParameter('codemachineinterne', $codemachineinterne);				
				$result = $query->getArrayResult();				
				$users_arr1 = array();

				foreach ($result as $data) {
					$users_arr1[] = array("codemachineinterne" => $data['codemachineinterne'], "typemachine" => $data['typemachine'], "loyerp1" => $data['loyerp1'], "loyerp2" => $data['loyerp2'], "loyerp3" => $data['loyerp3'], "loyerp4" => $data['loyerp4'], "loyermensuel" => $data['loyermensuel']);
				};
			}
			$users_arr = new Response(json_encode($users_arr1));
			return $users_arr;
		// }
	}
	
	public function adispatcherAction(Request $request)
	{
		$usersess = $this->get('security.context')->getToken()->getUsername();
	
		//On récupère les favoris niveau ALL
		$em = $this->getDoctrine()->getManager();
		
		//Calcul de la date de sprochains départs
		//Tout d'abord faut éviter les week end
		//On vérifie que demain ne soit pas un samedi ou un dimanche
		$today = date('D');
		if($today == 'Fri')
		{
			$date = date('Y-m-d', strtotime("+4 days"));
		}
		elseif($today == 'Sat')
		{
			$date = date('Y-m-d', strtotime("+3 days"));
		}
		elseif($today == 'Thu')
		{
			$date = date('Y-m-d', strtotime("+5 days"));
		}
		else
		{
			$date = date('Y-m-d', strtotime("+4 days"));
		}

//Partie Départ		
		$adispatcher = $em->getRepository('BaclooCrmBundle:Locata')
		->adispatcher($date);
// print_r($adispatcher);
		$i = 0;
		foreach($adispatcher as $disp)
		{
			foreach($disp->getLocations() as $di )
			{
				$i++;
			}
		}
		$em->clear();
		
		$dejadispatch = $em->getRepository('BaclooCrmBundle:Locata')
		->dejadispatch($date);

		$a = 0;
		foreach($dejadispatch as $dejadisp)
		{
			foreach($dejadisp->getLocations() as $dis )
			{
				$a++;
			}
		}
		$em->clear();
		
		$resa = $em->getRepository('BaclooCrmBundle:Locata')
		->resa($date);

		$d = 0;
		foreach($resa as $res)
		{
			foreach($res->getLocations() as $dis )
			{
				$d++;
			}
		}
		$em->clear();
//Fin partie Départ	

//Partie retour
		$now = date('Y-m-d');
		$apreprarer = $em->getRepository('BaclooCrmBundle:Locata')
		->apreprarer($now);

		$j = 0;
		foreach($apreprarer as $disp)
		{
			foreach($disp->getLocations() as $di )
			{
				$j++;
			}
		}
		$em->clear();
		
		$machinespretes = $em->getRepository('BaclooCrmBundle:Machines')
		->findByEtat('Disponible');

		$b = 0;
		foreach($machinespretes as $mach)
		{
			$b++;
		}
//Fin partie retour

//Pannes
		$enpanne = $em->getRepository('BaclooCrmBundle:Machines')
		->findByEtat('En panne');

		$c = 0;
		foreach($enpanne as $mach)
		{
			$c++;
		}
//Fin pannes

//Inspection
		$inspection = $em->getRepository('BaclooCrmBundle:Machines')
		->findByEtat('Inspection');

		$e = 0;
		foreach($inspection as $mach)
		{
			$e++;
		}
//Fin inspection


		return $this->render('BaclooCrmBundle:Crm:adispatcher.html.twig', array(
									'adispatcher' => $adispatcher,
									'dejadispatch' => $dejadispatch,
									'apreprarer' => $apreprarer,
									'enpanne' => $enpanne,
									'inspection' => $inspection,
									'machinespretes' => $machinespretes,
									'resa' => $resa,
									'i' => $i,
									'a' => $a,
									'j' => $j,
									'b' => $b,
									'c' => $c,
									'd' => $d,
									'e' => $e,
									'date' => $date,
									'date1' => date('Y-m-d', strtotime(" -1 days"))
									));	
	}
	
	public function dispatchAction($code, $codecont, $machinedor, $erreur, Request $request)
	{
		$em = $this->getDoctrine()->getManager();
// echo 'machinedor'.$machinedor;
		$locations  = $em->getRepository('BaclooCrmBundle:Locations')		
					   ->findOneById($code);
		$etat = $locations->getEtatloc();
		$defaultData = array();		
		$form = $this->createFormBuilder($defaultData)
			->add('codemachineinterne', 'text', array('required' => false))	
			->getForm();
		$form->handleRequest($request);
		// On vérifie qu'elle est de type POST
		if ($request->getMethod() == 'POST') 
		{
			$data = $form->getData();
			
			// On vérifie que les valeurs entrées sont correctes
			if($form->isValid()){
				$data = $form->getData();	
				$ecode =  $data['codemachineinterne'];
				
				//On vérifie qu'une machine existe avec l'ecode saisi dans le formulaire
				$ecodemachine = $em->getRepository('BaclooCrmBundle:Machines')
				->findOneBy(array('code'=> $ecode));
				
				//On vérifie que la machine saisie dans le formulaire soit disponible
				$machine = $em->getRepository('BaclooCrmBundle:Machines')
				->findOneBy(array('code'=> $ecode, 'etat'=> 'Disponible', 'original' => 1));
				
				//On regarde si une machine clone réservée ne porte pas cet ecode
				$machineresa = $em->getRepository('BaclooCrmBundle:Machines')
				->findBy(array('code'=> $ecode, 'codelocations' => $locations->getId(), 'original' => 0));
				
				//On regarde si une machine d'origine ne porte pas cet ecode
				$machinedorigine = $em->getRepository('BaclooCrmBundle:Machines')
				->findOneBy(array('codelocations' => $locations->getId(), 'code' => $machinedor, 'entreprise' => $locations->getEntreprise()));
// echo 'codeloc'.$locations->getId();	echo 'ecode ori'.$machinedor;			
				//On récupère le contrat concerné
				$locata = $em->getRepository('BaclooCrmBundle:Locata')
				->findOneById($codecont);
				
				//Si il n'y a pas de machine qui porte cet ecode
				if(empty($ecodemachine) or $ecodemachine == NULL and isset($machine))
				{
					return $this->redirect($this->generateUrl('bacloocrm_dispatch', array('code' => $code, 'codecont' => $codecont, 'erreur' => 2)));
				}
				// elseif(!isset($machineresa) && !isset($machine))
				// {
					// return $this->redirect($this->generateUrl('bacloocrm_dispatch', array('code' => $code, 'codecont' => $codecont, 'erreur' => 1)));
				// }
// echo $locata->getDebutloc();
				// $em->clear();

				// elseif(isset($machineresa) && $machineresa->getCode() != $ecode)
				// {
					// $em->remove($machineresa);
					// $em->flush();
				// }
echo 'codezmch'.$ecode;
echo 'codecontrat'.$codecont;				
				$machin = $em->getRepository('BaclooCrmBundle:Machines')
				->findOneBy(array('code'=> $ecode, 'original'=> 1, 'etat' => 'disponible'));
				if(!isset($machin))
				{
					$machin = $em->getRepository('BaclooCrmBundle:Machines')
					->findOneBy(array('code'=> $ecode, 'original'=> 1, 'codecontrat' => $codecont));
				}

				if(isset($machin))
				{//echo 'okkkkkkk';
					$machin->setDebutloc($locations->getDebutloc());
					$machin->setFinloc($locations->getFinloc());
					$machin->setEtat('Prêt au départ');
					$machin->setEntreprise($locata->getClient());
					$machin->setClientid($locata->getClientid());
					$machin->setNomchantier($locata->getNomchantier());
					$machin->setCodelocations($code);
					$machin->setCodecontrat($locata->getId());
					$em->persist($machin);
				
					$locations->setEtatloc('Prêt au départ');
					$locations->setMachineid($machin->getId());
					$locations->setCodemachineinterne($ecode);
					$locations->setCodemachine($machin->getCodegenerique());
					$locations->setTypemachine($machin->getDescription());
					$locations->setEnergie($machin->getEnergie());
					$em->persist($locations);
					if(isset($machineresa))
					{
						foreach($machineresa as $mach)
						{
							$em->remove($mach);
						}
					}
					
					//Si la machine réservée est différente de la machine du formulaire : il s'agit d'un changement de machine par la tech.
					if(isset($machinedorigine) && $machinedorigine->getCode() != $ecode && $machinedorigine->getOriginal() == 1)
					{
						$machinedorigine->setCodelocations('');
						$machinedorigine->setCodecontrat('');
						$machinedorigine->setClientid(0);
						$machinedorigine->setEntreprise('');
						$machinedorigine->setNomchantier('');
						$machinedorigine->setDebutloc('');
						$machinedorigine->setFinloc('');
						$machinedorigine->setEtat('Disponible');
						$em->persist($machinedorigine);					
					}
					elseif(isset($machinedorigine) && $machinedorigine->getOriginal() == 0 )
					{
						$em->remove($machinedorigine);
					}
				}
				else
				{//echo 'yyyyyyyy';
					
					return $this->redirect($this->generateUrl('bacloocrm_dispatch', array('code' => $code, 'codecont' => $codecont, 'erreur' => 2)));
				}			
				
				$em->flush();

				
				// On redirige vers la page de visualisation de la fiche nouvellement créée
				return $this->redirect($this->generateUrl('bacloocrm_adispatcher'));
			}
		}

		return $this->render('BaclooCrmBundle:Crm:dispatch.html.twig', array(
									'code' => $code,
									'codecont' => $codecont,
									'machinedor' => $machinedor,
									'typemachine' => $locations->getCodemachine(),
									'erreur' => $erreur,
									'form' => $form->createView()
									));	
	}
	
	public function dispatchslAction($codecontrat, $machinedor, $erreur, Request $request)
	{
		$em = $this->getDoctrine()->getManager();
// echo 'machinedor'.$machinedor;
		$locata  = $em->getRepository('BaclooCrmBundle:Locata')		
					   ->findOneById($codecontrat);
// echo $codecontrat;					   
		foreach($locata->getLocationssl() as $loca)
		{//echo 'rrrrrr';echo $loca->getCodemachineinterne();echo $machinedor;
			if($loca->getCodemachineinterne() == $machinedor)
			{//echo 'tttttt';
				$code = $loca->getId();//echo $code;						
				$typemachine = $loca->getTypemachine();						
			}
		}					   
// echo $code;					   
		// $etat = $locationssl->getEtatloc();
		$defaultData = array();		
		$form = $this->createFormBuilder($defaultData)
			->add('codemachineinterne', 'text', array('required' => false))	
			->getForm();
		$form->handleRequest($request);
		// On vérifie qu'elle est de type POST
		if ($request->getMethod() == 'POST') 
		{
			$data = $form->getData();
			
			// On vérifie que les valeurs entrées sont correctes
			if($form->isValid()){
				$data = $form->getData();	
				$ecode =  $data['codemachineinterne'];
				
				if($ecode != '' or $ecode != 0)
				{
					//On vérifie qu'une machine existe avec l'ecode saisi dans le formulaire
					$ecodemachine = $em->getRepository('BaclooCrmBundle:Machinessl')
					->findOneBy(array('code'=> $ecode));
					
					//On vérifie que la machine saisie dans le formulaire soit disponible
					$machine = $em->getRepository('BaclooCrmBundle:Machinessl')
					->findOneBy(array('code'=> $ecode, 'etat'=> 'Disponible'));				
					
					//On regarde si une machine d'origine ne porte pas cet ecode
					$machinedorigine = $em->getRepository('BaclooCrmBundle:Machinessl')
					->findOneBy(array('codelocations' => $code, 'original' => 1, 'code' => $machinedor, 'entreprise' => $locata->getClient()));
	// echo 'codeloc'.$locations->getId();	echo 'ecode ori'.$machinedor;			
					//On récupère le contrat concerné
					$locata = $em->getRepository('BaclooCrmBundle:Locata')
					->findOneById($codecontrat);
					
					//Si il n'y a pas de machine qui porte cet ecode
					if(empty($ecodemachine) or $ecodemachine == NULL and isset($machine))
					{
						return $this->redirect($this->generateUrl('bacloocrm_dispatchsl', array('codecontrat' => $codecontrat, 'machinedor' => $machinedor, 'erreur' => 2)));
					}
				}
				//Si la machine réservée est différente de la machine du formulaire : il s'agit d'un changement de machine par la tech.
				if(isset($machinedorigine) && $machinedorigine->getCode() != $ecode && $machinedorigine->getOriginal() == 1)
				{echo 'laaaaaaa';
					$machinedorigine->setCodelocations('');
					$machinedorigine->setCodecontrat('');
					$machinedorigine->setClientid(0);
					$machinedorigine->setEntreprise('');
					$machinedorigine->setNomchantier('');
					$machinedorigine->setDebutloc('');
					$machinedorigine->setFinloc('');
					$machinedorigine->setEtat('Disponible');
					$em->persist($machinedorigine);					
				}				
// echo $ecode;
				$machin = $em->getRepository('BaclooCrmBundle:Machinessl')
				->findOneBy(array('code'=> $ecode, 'original'=> 1));


		
				foreach($locata->getLocationssl() as $loca)
				{
					if($loca->getCodemachineinterne() == $machinedor)
					{
						if($ecode == '' or $ecode == 0)
						{echo 'pppppppp';
							$em->remove($loca);
							$locata->setBdcrecu(0);
							$locata->setContrat(0);
							$em->persist($locata);
						}
						else
						{echo 'ici';
							$loca->setMachineid($machin->getId());
							$loca->setCodemachine($machin->getCodegenerique());
							$loca->setCodemachineinterne($ecode);
							$loca->setTypemachine($machin->getDescription());
							$loca->setEnergie($machin->getEnergie());
							$em->persist($loca);
						}
						if(isset($machin))
						{echo 'okkkkkkk';
							$machin->setDebutloc($loca->getDebutloc());
							$machin->setFinloc($loca->getFinloc());
							$machin->setEtat('Prêt au départ');
							$machin->setEntreprise($locata->getClient());
							$machin->setClientid($locata->getClientid());
							$machin->setNomchantier($locata->getNomchantier());
							$machin->setCodelocations($loca->getId());
							$machin->setCodecontrat($locata->getId());
							$em->persist($machin);
							$code = $loca->getId();echo $code;
						}
						elseif($ecode != '' or $ecode != 0)
						{//echo 'yyyyyyyy';
							return $this->redirect($this->generateUrl('bacloocrm_dispatchsl', array('codecontrat' => $codecontrat, 'machinedor' => $machinedor, 'erreur' => 2)));
						}						
					}
				}				
				$em->flush();

				
				// On redirige vers la page de visualisation de la fiche nouvellement créée
				return $this->redirect($this->generateUrl('bacloocrm_ajouterlocation', array('ficheid' => $locata->getClientid(), 'locid' => $codecontrat)));
			}
		}

		return $this->render('BaclooCrmBundle:Crm:dispatchsl.html.twig', array(
									'code' => $code,
									'codecont' => $codecontrat,
									'machinedor' => $machinedor,
									'typemachine' => $typemachine,
									'erreur' => $erreur,
									'ficheid' => $locata->getClientid(),
									'form' => $form->createView()
									));	
	}
	
	
	public function retoursAction($erreur)
	{
		//On récupère les favoris niveau ALL
		$em = $this->getDoctrine()->getManager();
		$qrcode = 0;
//Partie retours
		if(!isset($erreur))
		{
			$erreur = 0;
		}
		//Calcul de la date de sprochains départs
		//Tout d'abord faut éviter les week end
		//On vérifie que demain ne soit pas un samedi ou un dimanche
		$today = date('D');
		$now = date('Y-m-d');
		if($today == 'Fri')
		{
			$date = date('Y-m-d', strtotime("+4 days"));
		}
		elseif($today == 'Sat')
		{
			$date = date('Y-m-d', strtotime("+3 days"));
		}
		elseif($today == 'Sun')
		{
			$date = date('Y-m-d', strtotime("+2 days"));
		}
		else
		{
			$date = date('Y-m-d');
		}
		
		if($today == 'Thu')
		{
			$datelivraison = date('Y-m-d', strtotime("+5 days"));
		}		
		elseif($today == 'Fri')
		{
			$datelivraison = date('Y-m-d', strtotime("+4 days"));
		}
		elseif($today == 'Sat')
		{
			$datelivraison = date('Y-m-d', strtotime("+3 days"));
		}
		else
		{
			$datelivraison = date('Y-m-d', strtotime("+3 days"));
		}
		
		$retours = $em->getRepository('BaclooCrmBundle:Locata')
		->retours($now);



		$i = 0;
		foreach($retours as $ret)
		{
			foreach($ret->getLocations() as $di )
			{
				$i++;
			}
		}
		$em->clear();
		
		$retourssl = $em->getRepository('BaclooCrmBundle:Locata')
		->retourssl($now);

		foreach($retourssl as $ret)
		{
			foreach($ret->getLocationssl() as $di )
			{
				$i++;
			}
		}
		$em->clear();
		
		$retoursplanifies = $em->getRepository('BaclooCrmBundle:Locata')
		->findByEtatloc('Retour planifié');//c'est une requete du repository
		
		$a = 0;
		foreach($retoursplanifies as $ret)
		{
			foreach($ret->getLocations() as $di )
			{
				$a++;
			}
		}
		$em->clear();
		
		$retoursplanifiessl = $em->getRepository('BaclooCrmBundle:Locata')
		->findByEtatlocsl('Retour planifié');
		
		// $a = 0;
		foreach($retoursplanifiessl as $ret)
		{
			foreach($ret->getLocationssl() as $di )
			{
				$a++;
			}
		}
		$em->clear();
//Fin partie retours
//Partie Livraisons
		$livraisons = $em->getRepository('BaclooCrmBundle:Locata')
		->livraisons($datelivraison);
		
		$livraisonssl = $em->getRepository('BaclooCrmBundle:Locata')
		->livraisonssl($datelivraison);
// echo $datelivraison;
		//On cherche les machines réservées à passer en location ferme
		$machinesreserves = $em->getRepository('BaclooCrmBundle:Machines')
				->findBy(array('etat'=> 'Réservé', 'original' => 0, 'debutloc' => $datelivraison));
		
		if(isset($machinesreserves))
		{
				foreach($machinesreserves as $resa)
				{
					$machineclone = $em->getRepository('BaclooCrmBundle:Machines')
						->findOneBy(array('etat'=> 'Réservé', 'original' => 0, 'debutloc' => $datelivraison, 'code' => $resa->getCode()));	
					
					$machine = $em->getRepository('BaclooCrmBundle:Machines')
						->findOneBy(array('original' => 1, 'code' => $resa->getCode()));

					$machine->setDebutloc($machineclone->getDebutloc());
					$machine->setFinloc($machineclone->getFinloc());
					$machine->setEtat('Prêt au départ');
					$machine->setEntreprise($machineclone->getEntreprise());
					$machine->setNomchantier($machineclone->getNomchantier());
					$machine->setcodelocations($machineclone->getCodelocations());
					$machine->setcodecontrat($machineclone->getCodecontrat());
					$machine->setClientid($machineclone->getClientid());
					$em->persist($machine);
					$em->remove($machineclone);
					$em->flush();					
				}
		}	
						
		$j = 0;
		foreach($livraisons as $liv)
		{
			foreach($liv->getLocations() as $di )
			{
				$j++;
			}
		}
		$em->clear();
		
		foreach($livraisonssl as $liv)
		{
			foreach($liv->getLocationssl() as $di )
			{
				$j++;
			}
		}
		$em->clear();
// echo $datelivraison;
		$livraisonsok = $em->getRepository('BaclooCrmBundle:Locata')
		->findByEtatloca('Prêt pour le chargement', 'En cours de livraison', $datelivraison);
// print_r($livraisonsok);
		$livraisonsoksl = $em->getRepository('BaclooCrmBundle:Locata')
		->findByEtatlocasl('Prêt pour le chargement', 'En cours de livraison', $datelivraison);
		
		$b = 0;
		foreach($livraisonsok as $ret)
		{
			foreach($ret->getLocations() as $di )
			{
				$b++;
			}
		}
		
		foreach($livraisonsoksl as $ret)
		{
			foreach($ret->getLocationssl() as $di )
			{
				$b++;
			}
		}
//Fin partie Livraisons				
		return $this->render('BaclooCrmBundle:Crm:retours.html.twig', array(
									'retours' => $retours,
									'erreur' => $erreur,
									'retourssl' => $retourssl,
									'retoursplanifies' => $retoursplanifies,
									'retoursplanifiessl' => $retoursplanifiessl,
									'livraisons' => $livraisons,
									'livraisonssl' => $livraisonssl,
									'livraisonsok' => $livraisonsok,
									'livraisonsoksl' => $livraisonsoksl,
									'i' => $i,
									'a' => $a,
									'j' => $j,
									'b' => $b,
									'date' => $date,
									'now' => $now,
									'qrcode' => $qrcode,
									'datelivraison' => $datelivraison
									));	
	}

	public function repriseAction($codelocata, $codelocations, $ecode, $mode, $datereprise, Request $request)
	{echo 'codeloc>>>'; echo $codelocations;echo 'codelocata>>>'; echo $codelocata;echo 'ecode>>>'; echo $ecode;
		$em = $this->getDoctrine()->getManager();
		$qrcode = 0;
		if($mode == 'reprise')
		{
			//Modification du statut dela machine
			$machine = $em->getRepository('BaclooCrmBundle:Machines')
						->findOneBy(array('codelocations' => $codelocations, 'code' => $ecode ));
				// echo $codelocations;		
			$locata = $em->getRepository('BaclooCrmBundle:Locata')
						->findOneById($codelocata);
						
			$client = $em->getRepository('BaclooCrmBundle:Fiche')
						->findOneById($locata->getClientid());

						
			if(isset($machine))
			{
				$machine->setEtat('Retour planifié');
				$machine->setEtatlog('Retour planifié');
				$em->persist($machine);
			}
						
			//Modification du statut de la ligne de location
			$location  = $em->getRepository('BaclooCrmBundle:Locations')		
						   ->findOneById($codelocations);
						   
			if(isset($location))
			{
				$location->setEtatloc('Retour planifié');
				$location->setEtatlog('Retour planifié');
				$location->setDatereprise($datereprise);
				$em->persist($location);
			}
					
			//Majtable logistique
			$logis = $em->getRepository('BaclooCrmBundle:Logisrep')
						->findOneByEtatlog('Retour planifié');
						
			//insertion dans la table logistique
			$logistique  = $em->getRepository('BaclooCrmBundle:Logistiquerep')		
						   ->findOneBy(array('codelocations' => $codelocations, 'codecontrat' => $codelocata, 'materiel' => $ecode));
						   

				if(!isset($logistique))
				{
					$logistique  = new Logistiquerep;
				}
				
				$logistique->setClient($location->getEntreprise());
				$logistique->setnomchantier($locata->getNomchantier());
				$logistique->setDate($datereprise);
				$logistique->setAdresse1($locata->getAdresse1());
				$logistique->setAdresse2($locata->getAdresse2());
				$logistique->setAdresse3($locata->getAdresse3());
				$logistique->setCp($locata->getCp());
				$logistique->setVille($locata->getVille());
				$logistique->setMateriel($location->getCodemachineinterne());
				$logistique->setTypemateriel($location->getTypemachine());
				$logistique->setContactchantier($locata->getContactchantier());
				$logistique->setCodecontrat($codelocata);
				$logistique->setCodelocations($codelocations);
				$logistique->setTypetransport('Reprise');
				$logistique->setEtatlog('Retour planifié');
				if(!isset($logistique))
				{				
					$logistique->addLogisre($logis);
					$logis->addLogistiquerep($logistique);
				}
				$em->persist($logistique);
		
				$em->flush();
			
		}
		elseif($mode == 'reprisesl')
		{
			//Modification du statut dela machinesl
			$machine = $em->getRepository('BaclooCrmBundle:Machinessl')
						->findOneBy(array('codelocations' => $codelocations));
// echo $codelocations;						
						
			$locata = $em->getRepository('BaclooCrmBundle:Locata')
						->findOneById($codelocata);
						
			$client = $em->getRepository('BaclooCrmBundle:Fiche')
						->findOneById($locata->getClientid());

						
			if(isset($machine))
			{
				$machine->setEtat('Retour planifié');
				$machine->setEtatlog('Retour planifié');
			}
						
			//Modification du statut de la ligne de location
			$location  = $em->getRepository('BaclooCrmBundle:Locationssl')		
						   ->findOneById($codelocations);
						   
			if(isset($location))
			{
				if($location->getTransport() == 1)
				{
					$location->setEtatloc('Retour planifié');
					$location->setEtatlog('Retour planifié');
					$location->setDatereprise($datereprise);
					if(isset($machine))
					{
						$machine->setEtat('Retour planifié');
						$machine->setEtatlog('Retour planifié');
					}					
				}
				else
				{
					$location->setEtatloc('Location terminée');
					$location->setEtatlog('Déposé en agence');
					$location->setDatereprise($datereprise);
					if(isset($machine))
					{
						$machine->setEtat('Disponible');
						$machine->setEtatlog('');
						$machine->setDebutloc('');
						$machine->setFinloc('');
						$machine->setEntreprise('');
						$machine->setNomchantier('');
						$machine->setcodelocations('');
						$machine->setcodecontrat('');
						$machine->setClientid(0);						
					}					
				}
				$em->persist($machine);
				$em->persist($location);
				$em->flush();
			}
			
			if($location->getTransport() == 1)
			{
				//Majtable logistique
				$logis = $em->getRepository('BaclooCrmBundle:Logisrep')
							->findOneByEtatlog('Retour planifié');
							
				//insertion dans la table logistique
				$logistique  = $em->getRepository('BaclooCrmBundle:Logistiquerep')		
							   ->findOneBy(array('codelocations' => $codelocations, 'codecontrat' => $codelocata, 'materiel' => $ecode));			   

				if(!isset($logistique))
				{
					$logistique  = new Logistiquerep;
				}
				
				$logistique->setClient($location->getEntreprise());
				$logistique->setnomchantier($locata->getNomchantier());
				$logistique->setDate($datereprise);
				$logistique->setAdresse1($locata->getAdresse1());
				$logistique->setAdresse2($locata->getAdresse2());
				$logistique->setAdresse3($locata->getAdresse3());
				$logistique->setCp($locata->getCp());
				$logistique->setVille($locata->getVille());
				$logistique->setMateriel($location->getCodemachineinterne());
				$logistique->setTypemateriel($location->getTypemachine());
				$logistique->setContactchantier($locata->getContactchantier());
				$logistique->setCodecontrat($codelocata);
				$logistique->setCodelocations($codelocations);
				$logistique->setTypetransport('Reprisesl');
				$logistique->setEtatlog('Retour planifié');
				if(!isset($logistique))
				{				
					$logistique->addLogisre($logis);
					$logis->addLogistiquerep($logistique);
				}
				$em->persist($logistique);
		
				$em->flush();
				
				$logistiqueliv  = $em->getRepository('BaclooCrmBundle:Logistique')		
							   ->findOneBy(array('codelocations' => $codelocations, 'codecontrat' => $codelocata, 'materiel' => $ecode));
				if(!empty($logistiqueliv))
				{
					$em->remove($logistiqueliv);
				}
			}
		}
		elseif($mode == 'livraisons')
		{

			//Modification du statut dela machine
			$machine = $em->getRepository('BaclooCrmBundle:Machines')
						->findOneBy(array('codelocations' => $codelocations, 'code' => $ecode));
			$typeloc = 'parc';
			if(!isset($machine))
			{
				$machine = $em->getRepository('BaclooCrmBundle:Machinessl')
							->findOneBy(array('codelocations' => $codelocations, 'code' => $ecode));
				$typeloc = 'sl';
			}
				
			$locata = $em->getRepository('BaclooCrmBundle:Locata')
						->findOneById($codelocata);
echo 'typeloc'.$typeloc;					
			if(isset($machine))
			{echo 'isset machine';
				$machine->setEtat('En location');
				$machine->setEtatlog('Prêt pour le chargement');
			}
			
			$location  = $em->getRepository('BaclooCrmBundle:Locations')		
						   ->findOneBy(array('id' => $codelocations, 'codemachineinterne' => $ecode));

			if(!isset($location))
			{
				$location = $em->getRepository('BaclooCrmBundle:Locationssl')
							->findOneBy(array('id' => $codelocations, 'codemachineinterne' => $ecode));			
			}						   



			if(isset($machine))
			{echo 'machien est set';
				$machine->setEtat('En location');
				$location->setEtatloc('En location');
				if($typeloc == 'sl')
				{
					if($location->getTransport() == 1)
					{
						$location->setEtatlog('Prêt pour le chargement');
					}
					else
					{					
						$location->setEtatlog('Livré chez le client');
					}
				}
				else
				{
					$location->setEtatlog('Prêt pour le chargement');
				}
			}
			$em->flush();		
			$logis = $em->getRepository('BaclooCrmBundle:Logis')
						->findOneByEtatlog('Prêt pour le chargement');
						
			//insertion dans la table logistique
			$logistiqua  = $em->getRepository('BaclooCrmBundle:Logistique')		
						   ->findOneBy(array('codelocations' => $codelocations, 'codecontrat' => $codelocata, 'materiel' => $ecode));
						   
			if(!isset($logistiqua))
			{
				$logistique  = new Logistique;
				$logistique->setClient($location->getEntreprise());
				$logistique->setnomchantier($locata->getNomchantier());
				$logistique->setDate($datereprise);
				$logistique->setAdresse1($locata->getAdresse1());
				$logistique->setAdresse2($locata->getAdresse2());
				$logistique->setAdresse3($locata->getAdresse3());
				$logistique->setCp($locata->getCp());
				$logistique->setVille($locata->getVille());
				$logistique->setContactchantier($locata->getContactchantier());
				$logistique->setMateriel($location->getCodemachineinterne());
				$logistique->setTypemateriel($location->getTypemachine());
				$logistique->setCodecontrat($codelocata);
				$logistique->setCodelocations($codelocations);
				if($typeloc = 'parc')
				{
					$logistique->setTypetransport('Livraison');
				}
				else
				{
					$logistique->setTypetransport('Livraisonsl');
				}
				$logistique->setEtatlog('Prêt pour le chargement');			
				$logistique->addLogi($logis);
				$logis->addLogistique($logistique);

				$em->persist($logistique);			
			}
			else
			{
				$logistiqua->setClient($location->getEntreprise());
				$logistiqua->setnomchantier($locata->getNomchantier());
				$logistiqua->setDate($datereprise);
				$logistiqua->setAdresse1($locata->getAdresse1());
				$logistiqua->setAdresse2($locata->getAdresse2());
				$logistiqua->setAdresse3($locata->getAdresse3());
				$logistiqua->setCp($locata->getCp());
				$logistiqua->setVille($locata->getVille());
				$logistiqua->setContactchantier($locata->getContactchantier());
				$logistiqua->setMateriel($location->getCodemachineinterne());
				$logistiqua->setTypemateriel($location->getTypemachine());
				$logistiqua->setCodecontrat($codelocata);
				$logistiqua->setCodelocations($codelocations);
				if($typeloc = 'parc')
				{
					$logistiqua->setTypetransport('Livraison');
				}
				else
				{
					$logistiqua->setTypetransport('Livraisonsl');
				}
				$logistiqua->setEtatlog('Prêt pour le chargement');						   
				$em->persist($logistiqua);
			}
		}
		
		$em->flush();		

				
		// On redirige vers la page de visualisation de la fiche nouvellement créée
		return $this->redirect($this->generateUrl('bacloocrm_retours'));
	
	}


	public function preparationAction($codelocations, $ecode, $mode, Request $request)
	{
		$em = $this->getDoctrine()->getManager();

		//Modification du statut dela machine
		if($mode == 'Inspection')
		{echo 'ici?';echo $ecode;
			$machine = $em->getRepository('BaclooCrmBundle:Machines')
						->findOneBy(array('code'=> $ecode, 'original'=> 1, 'codelocations' => $codelocations));						
			if(isset($machine))
			{echo 'machine?';						
				//Majtable logistique
				$logistique  = $em->getRepository('BaclooCrmBundle:Logistiquerep')		
							   ->findOneByMateriel($machine->getCode());
echo $machine->getCode();				
				if(isset($logistique))
				{
					$em->remove($logistique);
				}
				
				//Modification du statut de la ligne de location
				$location  = $em->getRepository('BaclooCrmBundle:Locations')		
							   ->findOneById($codelocations);
				
				if(isset($location))
				{
					$location->setEtatloc('Location terminée');
				}
				$machine->setEtat('Inspection');
				$machine->setEtatlog('Déposé en agence');
				// $machine->setCodelocations(NULL);
				$machine->setDebutloc(NULL);
				$machine->setFinloc(NULL);
				$machine->setCodecontrat(NULL);
				$machine->setClientid(0);
				$machine->setNomchantier('');
				$machine->setEntreprise('');
			}
		}
		elseif($mode == 'Disponible')
		{
			$query = $em->createQuery(
				'SELECT f
				FROM BaclooCrmBundle:Machines f
				WHERE f.code = :code
				AND f.original = :original'
			);
			$query->setParameter('code', $ecode);
			$query->setParameter('original', 1);
			$machine = $query->getOneOrNullResult();
			
			if(isset($machine))
			{
				//Majtable logistique
				$logistique  = $em->getRepository('BaclooCrmBundle:Logistiquerep')		
							   ->findOneByMateriel($machine->getCode());
				if(isset($logistique))
				{
					$em->remove($logistique);
				}
				//Modification du statut de la ligne de location
				$location  = $em->getRepository('BaclooCrmBundle:Locations')		
							   ->findOneById($codelocations);
				
				if(isset($location))
				{
					$location->setEtatloc('Location terminée');
				}
				
				$machineclone = $em->getRepository('BaclooCrmBundle:Machines')
						->findOneBy(array('code'=> $ecode, 'original' => 0));
				if(isset($machineclone))
				{
					$clonedebutloc = $machineclone->getDebutloc();
					$today = date('Y-m-d');
					$diff = abs(strtotime($clonedebutloc) - strtotime($today));
					$nbjrsdiff = $diff/86400;
					if($nbjrsdiff > 5)
					{
						$machine->setEtat('Disponible');
						$machine->setDebutloc('');
						$machine->setFinloc('');
						$machine->setEntreprise('');
						$machine->setNomchantier('');
						$machine->setcodelocations('');
						$machine->setcodecontrat('');
						$machine->setClientid(0);
						$em->persist($machine);
						$em->flush();						
					}
					else
					{
						$machine->setDebutloc($machineclone->getDebutloc());
						$machine->setFinloc($machineclone->getFinloc());
						$machine->setEtat('Prêt au départ');
						$machine->setEntreprise($machineclone->getEntreprise());
						$machine->setNomchantier($machineclone->getNomchantier());
						$machine->setcodelocations($machineclone->getCodelocations());
						$machine->setcodecontrat($machineclone->getCodecontrat());
						$machine->setClientid($machineclone->getClientid());
						$em->persist($machine);
						$em->remove($machineclone);
						$em->flush();						
					}
				}				
				else
				{
					$machine->setEtat('Disponible');
					$machine->setDebutloc('');
					$machine->setFinloc('');
					$machine->setEntreprise('');
					$machine->setNomchantier('');
					$machine->setcodelocations('');
					$machine->setcodecontrat('');
					$machine->setClientid(0);
					$em->persist($machine);	
					$em->flush();				
				}
			}
			else
			{
				//Modification du statut de la ligne de location
				$location  = $em->getRepository('BaclooCrmBundle:Locations')		
							   ->findOneById($codelocations);
				
				if(isset($location))
				{
					$location->setEtatloc('Location terminée');
				}				
			}
		}
		elseif($mode == 'Enpanne')
		{
			$query = $em->createQuery(
				'SELECT f
				FROM BaclooCrmBundle:Machines f
				WHERE f.code = :code
				AND f.original = :original'
			);
			$query->setParameter('code', $ecode);
			$query->setParameter('original', 1);
			$machine = $query->getOneOrNullResult();
			
			if(isset($machine))
			{
				$machine->setEtat('En panne');
				$machine->setDebutloc('');
				$machine->setFinloc('');
				$machine->setEntreprise('');
				$machine->setNomchantier('');
				$machine->setcodelocations('');
				$machine->setcodecontrat('');
				$machine->setClientid(0);
				$em->persist($machine);	
				$em->flush();
				//Majtable logistique
				
				$logistique  = $em->getRepository('BaclooCrmBundle:Logistiquerep')		
							   ->findOneByMateriel($machine->getCode());
				
				if(isset($logistique))
				{
					$em->remove($logistique);
				}
				
				//Modification du statut de la ligne de location
				$location  = $em->getRepository('BaclooCrmBundle:Locations')		
							   ->findOneById($codelocations);
				
				if(isset($location))
				{
					$location->setEtatloc('Location terminée');
				}	
			}
		}
		
		$em->flush();		

				
		// On redirige vers la page de visualisation de la fiche nouvellement créée
		return $this->redirect($this->generateUrl('bacloocrm_adispatcher'));
	
	}

	public function modiflivraisonsAction($codecont, $codelocations, $ecode, $mode, Request $request)
	{
		$em = $this->getDoctrine()->getManager();

		//Modification du statut dela machine
		if($mode == 'annuler')
		{
			$machine = $em->getRepository('BaclooCrmBundle:Machines')
						->findOneBy(array('code'=> $ecode, 'original'=> 1, 'codelocations' => $codelocations));						
			if(!isset($machine))
			{
				$machine = $em->getRepository('BaclooCrmBundle:Machinessl')
							->findOneBy(array('code'=> $ecode, 'original'=> 1, 'codelocations' => $codelocations));					
			}
			
			if(isset($machine))
			{
				$codelocata = $machine->getCodecontrat();
				$machine->setEtat('Disponible');
				$machine->setCodelocations(NULL);
				$machine->setDebutloc('');
				$machine->setFinloc('');
				$machine->setCodecontrat(NULL);
				$machine->setClientid(NULL);
				$machine->setNomchantier('');
				$machine->setEntreprise('');
				$machine->setEtatlog('');
			}
						
			//Modification du statut de la ligne de location
			$location  = $em->getRepository('BaclooCrmBundle:Locations')		
						->findOneBy(array('codemachineinterne'=> $ecode, 'id' => $codelocations));
						   
			if(!isset($location))
			{
				$location  = $em->getRepository('BaclooCrmBundle:Locationssl')		
						->findOneBy(array('codemachineinterne'=> $ecode, 'id' => $codelocations));
			}
			
			if(isset($location))
			{
				// $em->remove($locations);
				$location->setMachineid(0);
				$location->setCodemachineinterne('');
				$location->setEtatloc('');
				$location->setEtatlog('');
				$em->persist($location);
			}
			$locata  = $em->getRepository('BaclooCrmBundle:Locata')		
						->findOneById($codelocata);
						
			$locata->setBdcrecu(0);
			$locata->setContrat(0);
			
			//Suppression de la ligne logistique
			$logistique  = $em->getRepository('BaclooCrmBundle:Logistique')		
						   ->findOneByMateriel($ecode);
						   
			if(isset($logistique))
			{
				$em->remove($logistique);
			}

			$logistiquerep  = $em->getRepository('BaclooCrmBundle:Logistiquerep')		
						   ->findOneByMateriel($ecode);
			
			if(isset($logistiquerep))
			{
				$em->remove($logistiquerep);
			}
			$em->flush();	
		}
		
		$em->flush();		

				
		// On redirige vers la page de visualisation de la fiche nouvellement créée
		return $this->redirect($this->generateUrl('bacloocrm_retours'));
	
	}
	
	public function reportlivraisonsAction($codecont, $codelocations, $ecode, $erreur, Request $request)
	{
		$usersess = $this->get('security.context')->getToken()->getUsername();
		$em = $this->getDoctrine()->getManager();
// echo 'codelocaation'.$codelocations;echo '***';echo $ecode;
		$locations  = $em->getRepository('BaclooCrmBundle:Locations')		
					   ->findOneBy(array('id' => $codelocations, 'codemachineinterne' => $ecode));
		// echo 'IDX';echo $locations->getEntid();echo '<<<<';				   
		if(!isset($locations))
		{
			$locations  = $em->getRepository('BaclooCrmBundle:Locationssl')		
			   ->findOneBy(array('id' => $codelocations, 'codemachineinterne' => $ecode));
		}
		$defaultData = array();		
		$form = $this->createFormBuilder($defaultData)
		->add('du', 'date', array('widget' => 'single_text',
									'input' => 'string',
									'format' => 'dd/MM/yyyy',
									'required' => false,
									'attr' => array('class' => 'date'),
									))
		->add('au', 'date', array('widget' => 'single_text',
									'input' => 'string',
									'format' => 'dd/MM/yyyy',
									'required' => false,
									'attr' => array('class' => 'date'),
									))
		->getForm();
		$form->handleRequest($request);
		// On vérifie qu'elle est de type POST
		if ($request->getMethod() == 'POST') 
		{
			$data = $form->getData();
			// On vérifie que les valeurs entrées sont correctes
			if($form->isValid()){
				$data = $form->getData();	
				$debutloc = $data['du'];
				$finloc = $data['au'];
				$today = date('Y-m-d');

				$machin = $em->getRepository('BaclooCrmBundle:Machines')
				->findOneBy(array('code'=> $ecode, 'codelocations'=> $codelocations));	

				if(!isset($machin))
				{
					$machin = $em->getRepository('BaclooCrmBundle:Machinessl')
						->findOneBy(array('code'=> $ecode, 'codelocations'=> $codelocations));
				}
				$locations->setDebutloc($debutloc);
				$locations->setFinloc($finloc);
				$locations->setEtatloc('Réservé');
				$machin->setDebutloc($debutloc);
				$machin->setFinloc($finloc);
				$machin->setEtat('Réservé');
				$em->persist($machin);
				$em->persist($locations);
				$em->flush();
				
				// On redirige vers la page de visualisation de la fiche nouvellement créée
				return $this->redirect($this->generateUrl('bacloocrm_reportlivraisons', array('codecont' => $codecont, 'codelocations' => $codelocations, 'ecode' => $ecode, 'erreur' => 0)));
			}
		}
		if(!isset($erreur)){$erreur = 0;}
		// echo 'ID';echo $locations->getEntid();
		return $this->render('BaclooCrmBundle:Crm:reportlivraisons.html.twig', array(
									'codelocations' => $codelocations,
									'codecont' => $codecont,
									'ecode' => $ecode,
									'erreur' => $erreur,
									'user' => $usersess,
									'id' => $locations->getCodeclient(),
									'entreprise' => $locations->getEntreprise(),
									'du' => $locations->getdebutloc(),
									'au' => $locations->getFinloc(),
									'contrat' => 1,
									'form' => $form->createView()
									));	
	}
	
	public function tcardAction($mode, Request $request)
	{
		$em = $this->getDoctrine()->getManager();
		// $machines = $em->getRepository('BaclooCrmBundle:Machines')		
					   // ->findAll();
					   
		$defaultData = array();		
		$form = $this->createFormBuilder($defaultData)
			->add('filtre', 'choice', array(
					'choices'   => array(
						'all'   => 'Tout afficher',
						'vgp'   => 'VGP à faire',
						'maintenance' => 'Maintenance',
					),
					'multiple'  => false,
				))	
			->getForm();
		$form->handleRequest($request);
		if($form->isValid()) {
			$data = $form->getData();
			$mode = $data['filtre'];	
			if(isset($mode) && $mode == 'vgp')
			{
				return $this->redirect($this->generateUrl('bacloocrm_tcard', array('mode' => 'vgp' )));									
			}
			elseif(isset($mode) && $mode == 'maintenance')
			{
				return $this->redirect($this->generateUrl('bacloocrm_tcard', array('mode' => 'maintenance' )));									
			}
		}
		
		if($mode =='vgp')
		{
			$datevgp = date('Y-m-d', strtotime("+20 days"));
			$query = $em->createQuery(
				'SELECT f.codegenerique
				FROM BaclooCrmBundle:Machines f
				Group By f.codegenerique'
			);				
			$machines = $query->getArrayResult();
			$macha = array();
			$allecodes = array();
			foreach($machines as $mach)
			{
				$m = $mach['codegenerique'];
				$query = $em->createQuery(
				'SELECT f
				FROM BaclooCrmBundle:Machines f
				WHERE f.codegenerique = :codegenerique
				AND f.prochaineVgp <= :prochaineVgp'
				);
				$query->setParameter('codegenerique', $mach['codegenerique']);			
				$query->setParameter('prochaineVgp', $datevgp);		
				$ecodes = $query->getResult();
				$allecodes[$m] = $ecodes;
			}
			
			if(empty($allecodes))
			{
				$compte = 0;
			}
			else
			{
				$compte = count(max($allecodes));
			}
				
		}
		elseif($mode == 'maintenance')
		{
			$datemaintenance = date('Y-m-d', strtotime("+20 days"));
			$query = $em->createQuery(
				'SELECT f.codegenerique
				FROM BaclooCrmBundle:Machines f
				Group By f.codegenerique'
			);				
			$machines = $query->getArrayResult();
			$macha = array();
			$allecodes = array();
			foreach($machines as $mach)
			{
				$m = $mach['codegenerique'];
				$query = $em->createQuery(
				'SELECT f
				FROM BaclooCrmBundle:Machines f
				WHERE f.codegenerique = :codegenerique
				AND f.prochaineRevision <= :prochaineRevision'
				);
				$query->setParameter('codegenerique', $mach['codegenerique']);			
				$query->setParameter('prochaineRevision', $datemaintenance);		
				$ecodes = $query->getResult();
				$allecodes[$m] = $ecodes;
			}
			
			if(empty($allecodes))
			{
				$compte = 0;
			}
			else
			{
				$compte = count(max($allecodes));
			}
		}
		else
		{
			$query = $em->createQuery(
				'SELECT f.codegenerique
				FROM BaclooCrmBundle:Machines f
				Group By f.codegenerique'
			);				
			$machines = $query->getArrayResult();
			$macha = array();
			$allecodes = array();
			foreach($machines as $mach)
			{
				$m = $mach['codegenerique'];
				$query = $em->createQuery(
				'SELECT f
				FROM BaclooCrmBundle:Machines f
				WHERE f.codegenerique = :codegenerique'
				);
				$query->setParameter('codegenerique', $mach['codegenerique']);			
				$ecodes = $query->getResult();
				$allecodes[$m] = $ecodes;
			}
			
			if(empty($allecodes))
			{
				$compte = 0;
			}
			else
			{
				$compte = count(max($allecodes));
			}
		}
		
		$totalparc = $em->getRepository('BaclooCrmBundle:Machines')
						->totalparc(); //echo 'totalparc : '.$totalparc;
						
		return $this->render('BaclooCrmBundle:Crm:tcard.html.twig', array(
									'compte' => $compte,
									'mode' => $mode,
									'totalparc' => $totalparc,
									'allecodes' => $allecodes,
									'form' => $form->createView()
									));			
	}
	
	public function machinesAction($machineid, Request $request)
	{//echo $machineid;
		$user = $this->get('security.context')->getToken()->getUsername(); 
		$today = date('Y-m-d');
		$em = $this->getDoctrine()->getManager();
		$qrcode = 0;
		if($machineid == 0)
		{
			$machine = new Machines;
			$last5loc = 0;
			$codemachine = '';
		}
		else
		{
			$machine  = $em->getRepository('BaclooCrmBundle:Machines')		
						   ->findOneById($machineid);
			$codemachine = $machine->getCode();
			$last5loc  = $em->getRepository('BaclooCrmBundle:Locata')		
						   ->last5loc($machineid);
		}
		$form = $this->createForm(new MachinesType(), $machine);
		$request = $this->get('request');
		if($request->getMethod() == 'POST') 
		{
			$form->bind($request);
			if($form->isValid())
			{
				$em->persist($machine);	
				$em->flush();
				
				$codemachine = $form->get('code')->getData();
				$machine  = $em->getRepository('BaclooCrmBundle:Machines')		
							   ->findOneByCode($codemachine);
				$machineid = $machine->getId();
				
				return $this->redirect($this->generateUrl('bacloocrm_machines', array('machineid' => $machineid)));
			}
		}
		$ventes = $em->getRepository('BaclooCrmBundle:Venda')
					   ->findBy(array('clientid' => $machineid));
					   
		$documents  = $em->getRepository('BaclooCrmBundle:Document')		
					   ->findBy(array('codecontrat' => $machineid, 'type' => 'machine'));
		// echo '&&&&'.$machineid;		   
		$previous = $this->get('request')->server->get('HTTP_REFERER');
		return $this->render('BaclooCrmBundle:Crm:machines.html.twig', array('form' => $form->createView(),
																			'date' => $today,
																			'codemachine' => $codemachine,
																			'machineid' => $machineid,
																			'previous' => $previous,
																			'last5loc' => $last5loc,
																			'qrcode' => $qrcode,
																			'documents' => $documents,
																			'user' => $user));
	}

	public function qrcodeAction($codemachine)
	{
		return $this->render('BaclooCrmBundle:Crm:qrcode.html.twig', array('codemachine' => $codemachine));				
	}

	public function transporteurAction($codemachine, $etatlog, $lat, $long, $mode, $codelocation, Request $request)
    {
		$codemachine = $request->get('codemachine');//echo $codemachine;	
		$lat = $request->get('lat');//echo 'xxx'.$lat;
		$long = $request->get('long');//echo 'yyy'.$long;
		$etatlog = $request->get('etatlog');//var_dump($etatlog);
		$user = $this->get('security.context')->getToken()->getUsername();
		$em = $this->getDoctrine()->getManager();
		$usersess  = $em->getRepository('BaclooUserBundle:User')		
					   ->findOneByUsername($user);	
		//Protect double connexion
		$session = $request->getSession();
		$sessionId = $session->getId();					   
		if($usersess->getLogged() != $sessionId)
		{
			return $this->redirect($this->generateUrl('fos_user_security_logout'));
		}
		
		$userdetails  = $em->getRepository('BaclooUserBundle:User')		
					   ->findOneByUsername($user);
		$roleuser = $userdetails->getRoleuser();
		
		$machines  = $em->getRepository('BaclooCrmBundle:Machines')		
					   ->findOneBy(array('code'=> $codemachine, 'original'=> 1, 'codelocations' => $codelocation));
					   
		if(empty($machines))
		{echo 'machinessl';
			$machines  = $em->getRepository('BaclooCrmBundle:Machinessl')		
						   ->findOneBy(array('code'=> $codemachine, 'original'=> 1, 'codelocations' => $codelocation));
		}
		$codelocations = $codelocation;	
 echo 'codeloc'.$codelocations;echo 'ecode'.$codemachine;			
		$locations  = $em->getRepository('BaclooCrmBundle:Locations')		
					   ->findOneBy(array('id' => $codelocations, 'codemachineinterne' => $codemachine));
// echo 'XX'.$locations->getId();echo 'yy'.$locations->getCodemachine();				   
		if(empty($locations))
		{echo 'SSL';echo '<<<';
			$locations  = $em->getRepository('BaclooCrmBundle:Locationssl')		
						   ->findOneBy(array('id' => $codelocations, 'codemachineinterne' => $codemachine));	
		}
		else{echo 'pas empty loc parc';
		}		
	if(isset($machines))
	{		
		//Majtable logistique
		$logistiquelivr  = $em->getRepository('BaclooCrmBundle:Logistique')		
					   ->findOneBy(array('codelocations' => $codelocations, 'codecontrat' => $machines->getCodecontrat(), 'materiel' => $codemachine));	
					   
		//Majtable logistique
		$logistiquerep  = $em->getRepository('BaclooCrmBundle:Logistiquerep')		
					   ->findOneBy(array('codelocations' => $codelocations, 'codecontrat' => $machines->getCodecontrat(), 'materiel' => $codemachine));
	}				   
		// $etatloga = (string)$etatlog;
		// echo 'xxxxxxxx'.gettype$etatloga.'xxxxxxxxxxx';
		if($etatlog == 'xxx')
		{//echo '1'.$etatlog;
		}
		elseif($etatlog == 'Livré')
		{echo 'xx2xx';		
			if(isset($machines))
			{
				$machines->setEtatlog('Livré chez le client');
				$machines->setEtat('En location');
				$machines->setLatitude($lat);
				$machines->setLongitude($long);
				$em->persist($machines);
			}
			$locations->setEtatlog('Livré chez le client');
			$em->persist($locations);
			if(isset($logistiquelivr))
			{
				$logistiquelivr->setEtatlog('Livré chez le client');
				$em->persist($logistiquelivr);
			}
			$em->flush();
		}
		elseif($etatlog == 'Recupere')
		{//echo '3';		
			if(isset($machines))
			{
				$machines->setEtat('Retour planifié');
				$machines->setEtatlog('En route vers agence');
				$em->persist($machines);
			}
			$locations->setEtatlog('En route vers agence');
			$em->persist($locations);
			$logistiquerep->setEtatlog('En route vers agence');
			$em->persist($logistiquerep);
			$em->flush();
		}
		elseif($etatlog == 'Déposé_en_agence')
		{
			if($mode == 'qr0')
			{
				// echo 'QR00000';
				// echo $machines->getCode();
				// echo 'matos logisrep';echo $logistiquerep->getMateriel();		
				if(isset($machines))
				{
					$machines->setEtatlog('Déposé en agence');
					$machines->setLatitude($lat);
					$machines->setLongitude($long);
					$em->persist($machines);
				}
				$locations->setEtatlog('Déposé en agence');
				$locations->setEtatloc('Location terminée');
				$em->persist($locations);
				if(isset($logistiquerep))
				{
					$em->remove($logistiquerep);
				}
				$em->flush();				
			}
			else
			{		
				if(isset($machines))
				{
					$machines->setEtatlog('Déposé en agence');
					$machines->setLatitude($lat);
					$machines->setLongitude($long);
					$em->persist($machines);
				}
				$locations->setEtatlog('Déposé en agence');
				$em->persist($locations);
				$logistiquerep->setEtatlog('Déposé en agence');
				$em->persist($logistiquerep);
				$em->flush();
			}
			//Réinitialisation de la table machine		
			if(isset($machines))
			{
				$machines->setCodelocations(NULL);
				$machines->setCodecontrat(NULL);
				$machines->setClientid(0);
				$machines->setEntreprise(NULL);
				$machines->setNomchantier(NULL);
				$machines->setDebutloc(NULL);
				$machines->setFinloc(NULL);
				$machines->setEtat('Disponible');
				$em->persist($machines);
				$em->flush();
			}
		}
		elseif($etatlog == 'En_cours_de_livraison')
		{		
			if(isset($machines))
			{
				$machines->setEtatlog('En cours de livraison');
				$em->persist($machines);
			}
			$locations->setEtatlog('En cours de livraison');
			$em->persist($locations);
			$logistiquelivr->setEtatlog('En cours de livraison');
			$em->persist($logistiquelivr);
			$em->flush();
		}
		// echo '***';
// echo $mode;
		// echo 'xxxxx';
		//Faire la modif sur l'état de la machine en fonction de l'état de la livraison
		if($mode == 'transporteur')
		{
			if(!isset($machines))
			{
				$machines = 0;
			}
			return $this->render('BaclooCrmBundle:Crm:transporteur.html.twig', array('codemachine' => $codemachine,
																					 'roleuser' => $roleuser,
																					 'machines' => $machines
																					));	
		}
		else
		{
			return $this->redirect($this->generateUrl('bacloocrm_retours'));
		}
	}

	public function mapsAction($latitude, $longitude)
	{
		return $this->render('BaclooCrmBundle:Crm:maps.html.twig', array(
																	'latitude' => $latitude,
																	'longitude' => $longitude
																	));				
	}

	public function dispatchtransportAction($formnum)
	{
		$usersess = $this->get('security.context')->getToken()->getUsername();
		$pdfObj = $this->get("white_october.tcpdf")->create();
		$em = $this->getDoctrine()->getManager();
		$qrcode = 0;
		$logisrep = $em->getRepository('BaclooCrmBundle:Logisrep')		
					   ->findOneByEtatlog('Retour planifié');

		if($qrcode == 0)
		{
			$daterecup = date('Y-m-d', strtotime("-1 days"));
			$query = $em->createQuery(
				'SELECT f
				FROM BaclooCrmBundle:Logistiquerep f
				WHERE f.date <= :date'
			);
			$query->setParameter('date', $daterecup);	
			$logistiquerepa  = $query->getResult();

			foreach($logistiquerepa as $logistiquerep)
			{
				$em->remove($logistiquerep);
						$em->flush();
			}

			$query = $em->createQuery(
				'SELECT f
				FROM BaclooCrmBundle:Logistique f
				WHERE f.date <= :date'
			);
			$query->setParameter('date', $daterecup);	
			$logistiqueliva  = $query->getResult();

			foreach($logistiqueliva as $logistiqueliv)
			{
				$em->remove($logistiqueliv);
						$em->flush();
			}
		}
		
		$logis = $em->getRepository('BaclooCrmBundle:Logis')		
					   ->findOneByEtatlog('Prêt pour le chargement');
		// echo $logis;
		$form2 = $this->createForm(new LogisType(), $logis);	
		$form1 = $this->createForm(new LogisrepType(), $logisrep);	

		// On récupère la requête
		$request = $this->get('request');
		// On vérifie qu'elle est de type POST
		if ($request->getMethod() == 'POST') 
		{
			if($formnum == 1)//REPRISE
			{
				$form1->bind($request);
				// On vérifie que les valeurs entrées sont correctes
				if($form1->isValid()){
					if($qrcode == 0)
					{
						$logistiquerep = $form1->get('logistiquerep')->getData();
						foreach($logistiquerep as $log)
						{
							$codemachine = $log->getMateriel();
							$etatlog = $log->getEtatlog();
							$codelocations = $log->getCodelocations();
													
						//MISE A JOUR DES TABLES		
							$machine = $em->getRepository('BaclooCrmBundle:Machines')
										->findOneBy(array('codelocations' => $codelocations, 'code' => $codemachine));
							if(!isset($machine))
							{
								$machine = $em->getRepository('BaclooCrmBundle:Machinessl')
											->findOneBy(array('codelocations' => $codelocations, 'code' => $codemachine));
								$machine->setEtat('Disponible');
								$machine->setEtatlog('Déposé en agence');
								$machine->setDebutloc('');
								$machine->setFinloc('');
								$machine->setEntreprise('');
								$machine->setNomchantier('');
								$machine->setcodelocations('');
								$machine->setcodecontrat('');
								$machine->setClientid(0);								
							}
							else
							{
								$machine->setEtat('Retour planifié');
								$machine->setEtatlog('Retour planifié');
							}	
										
							$locata = $em->getRepository('BaclooCrmBundle:Locata')
										->findOneById($machine->getCodecontrat());

							$location  = $em->getRepository('BaclooCrmBundle:Locations')		
										   ->findOneBy(array('id' => $codelocations, 'codemachineinterne' => $machine->getCode()));
	
							if(!isset($location))
							{
								$location = $em->getRepository('BaclooCrmBundle:Locationssl')
											->findOneBy(array('id' => $codelocations, 'codemachineinterne' => $machine->getCode()));
											
								$location->setEtatloc('Retour Planifié');
								$location->setEtatlog('Retour Planifié');
							}
							else
							{
								$machine->setEtat('Retour Planifié');
								$location->setEtatlog('Retour Planifié');
							}						
						}
					}				
				$em->persist($logisrep);	
				$em->flush();				
				}
			}
			elseif($formnum == 2)//LIVRAISON
			{
				$form2->bind($request);
				// On vérifie que les valeurs entrées sont correctes
				if($form2->isValid()){
					if($qrcode == 0)
					{
						$logistique= $form2->get('logistique')->getData();
						foreach($logistique as $log)
						{
							$codemachine = $log->getMateriel();
							$etatlog = $log->getEtatlog();
							$codelocations = $log->getCodelocations();
echo 'codelocation'.$codelocations;
echo ' codemachine'.$codemachine;													
						//MISE A JOUR DES TABLES		
							$machine = $em->getRepository('BaclooCrmBundle:Machines')
										->findOneBy(array('codelocations' => $codelocations, 'code' => $codemachine));
							
							if(!isset($machine))
							{
								$machine = $em->getRepository('BaclooCrmBundle:Machinessl')
											->findOneBy(array('codelocations' => $codelocations, 'code' => $codemachine));
							}			
							$locata = $em->getRepository('BaclooCrmBundle:Locata')
										->findOneById($machine->getCodecontrat());
									
							if(isset($machine))
							{
								$machine->setEtat('En location');
								$machine->setEtatlog('En cours de livraison');
							}
							$location  = $em->getRepository('BaclooCrmBundle:Locations')		
										   ->findOneBy(array('id' => $codelocations, 'codemachineinterne' => $machine->getCode()));
							
							if(!isset($location))
							{
								$location  = $em->getRepository('BaclooCrmBundle:Locationssl')
											   ->findOneBy(array('id' => $codelocations, 'codemachineinterne' => $machine->getCode()));
							}
							
							if(isset($codelocations))
							{
								$location->setEtatloc('En location');
								$location->setEtatlog('En cours de livraison');
							}
							
							//FIN MISE A JOUR DES TABLES
						}
					}		
				$em->persist($logis);	
				$em->flush();				
				}
			}
			return $this->redirect($this->generateUrl('bacloocrm_dispatchtransport'));
		}
		$today = date('D');
		if($today == 'Fri')
		{
			$datelivraison = date('Y-m-d', strtotime("+3 days"));
		}
		elseif($today == 'Sat')
		{
			$datelivraison = date('Y-m-d', strtotime("+2 days"));
		}
		else
		{
			$datelivraison = date('Y-m-d', strtotime("+1 days"));
		}
		//Sélection des utilisateurs à affichier
		$query = $em->createQuery(
			'SELECT f
			FROM BaclooCrmBundle:logistiquerep f
			WHERE f.etatlog = :etatlog
			Group By f.user'
		);
		$query->setParameter('etatlog', 'retour planifié');					
		$listuserrep = $query->getResult();		

		$query = $em->createQuery(
			'SELECT f
			FROM BaclooCrmBundle:logistique f
			WHERE f.etatlog = :etatlog
			Group By f.user'
		);
		$query->setParameter('etatlog', 'Prêt pour le chargement');					
		$listusers= $query->getResult();			
		
		if(count($listuserrep) > count($listusers))
		{
			$listuser = $listuserrep;
		}
		else
		{
			$listuser = $listusers;
		}
		
		
		$now = date('Y-m-d');
		return $this->render('BaclooCrmBundle:Crm:dispatch_transport.html.twig', array(
																	'today' => $now,
																	'listuser' => $listuser,
																	'datelivraison' => $datelivraison,
																	'form1' => $form1->createView(),
																	'form2' => $form2->createView()
																	));				
	}

	public function dispatchtransportpdfAction($chauffeur)
	{
		$usersess = $this->get('security.context')->getToken()->getUsername();
		$pdfObj = $this->get("white_october.tcpdf")->create();
		$em = $this->getDoctrine()->getManager();
		$qrcode = 0;
		$logistiquerep = $em->getRepository('BaclooCrmBundle:Logistiquerep')		
					   ->findByEtatlog('Retour planifié');

		$query = $em->createQuery(
			'SELECT f
			FROM BaclooCrmBundle:logistiquerep f
			WHERE f.etatlog = :etatlog
			Group By f.user'
		);
		$query->setParameter('etatlog', 'retour planifié');					
		$listuserrep = $query->getResult();

		$logistique = $em->getRepository('BaclooCrmBundle:Logistique')		
					   ->findByEtatlog('Prêt pour le chargement');

		$query = $em->createQuery(
			'SELECT f
			FROM BaclooCrmBundle:logistique f
			WHERE f.etatlog = :etatlog
			Group By f.user'
		);
		$query->setParameter('etatlog', 'Prêt pour le chargement');					
		$listuser = $query->getResult();					   
		// echo $logis;

		// On récupère la requête

		$today = date('D');
		if($today == 'Fri')
		{
			$datelivraison = date('Y-m-d', strtotime("+3 days"));
		}
		elseif($today == 'Sat')
		{
			$datelivraison = date('Y-m-d', strtotime("+2 days"));
		}
		else
		{
			$datelivraison = date('Y-m-d', strtotime("+1 days"));
		}
		$now = date('Y-m-d');

		$pdf = $this->get("white_october.tcpdf")->create();
		
        $html = $this->renderView('BaclooCrmBundle:Crm:dispatch_transportpdf.html.twig', array(
																	'logistiquerep' => $logistiquerep,
																	'listuserrep' => $listuserrep,
																	'logistique' => $logistique,
																	'listuser' => $listuser,
																	'today' => $now,
																	'chauffeur' => $chauffeur,
																	'datelivraison' => $datelivraison
																	));	
		$pdf->SetFont('helvetica', '', 9, '', true);
		
        $pdf->AddPage('L', 'A4');
        $pdf->writeHTML($html, true, false, true, false, '');
        $pdf->lastPage();
 
        $response = new Response($pdf->Output('file.pdf'));
        $response->headers->set('Content-Type', 'application/pdf');
 
        return $response;																		
        // return $this->render('BaclooCrmBundle:Crm:dispatch_transportpdf.html.twig', array(
																	// 'logistiquerep' => $logistiquerep,
																	// 'logistique' => $logistique,
																	// 'today' => $now,
																	// 'datelivraison' => $datelivraison
																	// ));																		
	}
	
	public function machinesslAction($machineid, Request $request)
	{
		$user = $this->get('security.context')->getToken()->getUsername(); 
		$today = date('Y-m-d');
		$em = $this->getDoctrine()->getManager();
		if($machineid == 0)
		{
			$machine = new Machinessl;
			$last5loc = 0;
		}
		else
		{
			$machine  = $em->getRepository('BaclooCrmBundle:Machinessl')		
						   ->findOneById($machineid);
			$codemachine = $machine->getCode();
			$last5locsl  = $em->getRepository('BaclooCrmBundle:Locata')		
						   ->last5locsl($machineid);
		}
		if(!isset($last5locsl)){$last5locsl = 0;}
		$form = $this->createForm(new MachinesslType(), $machine);
		$request = $this->get('request');
		if($request->getMethod() == 'POST') 
		{
			$form->bind($request);
			if($form->isValid())
			{
				$em->persist($machine);	
				$em->flush();
				
				$codemachine = $form->get('code')->getData();
				$machinessl  = $em->getRepository('BaclooCrmBundle:Machinessl')		
							   ->findOneByCode($codemachine);
				$machineid = $machine->getId();

				return $this->redirect($this->generateUrl('bacloocrm_machinessl', array('machineid' => $machineid)));
			}
		}
		return $this->render('BaclooCrmBundle:Crm:machinessl.html.twig', array('form' => $form->createView(),
																			'date' => $today,
																			'machineid' => $machineid,
																			'last5locsl' => $last5locsl,
																			'user' => $user));
	}
	
	public function requeteloueurAction(Request $request)
	{
		// $request = $request->get('request');
		// if($request == 1){
			$search = $request->get('search');
			// $search = 'altitop';
			if(!empty($search))
			{
				$em = $this->getDoctrine()->getManager();
				$query = $em->createQuery(
					'SELECT f
					FROM BaclooCrmBundle:Fiche f
					WHERE f.raisonSociale LIKE :raison
					AND (f.typefiche = :fournisseur)
					Group By f.raisonSociale'
				);
				$query->setParameter('raison', '%'.$search.'%');					
				$query->setParameter('fournisseur', 'loueur');					
				$result = $query->getArrayResult();

				// Transformer le tableau associatif en un tableau standard
				$array = array();
				foreach ($result as $data) {
					$array[] = array("label"=>$data['raisonSociale'], "value"=>$data['id']);
				}				
			}
		$response = new Response(json_encode($array));
		return $response;
		// }
	}
	
	public function requete2loueurAction(Request $request)
	{
			$search = $request->get('search');
			if(!empty($search))
			{
				$em = $this->getDoctrine()->getManager();	
				$query = $em->createQuery(
					'SELECT f
					FROM BaclooCrmBundle:Fiche f
					WHERE f.raisonSociale LIKE :raisonSociale
					and f.typefiche = :typefiche'
				);
				$query->setParameter('raisonSociale', '%'.$search.'%');					
				$query->setParameter('typefiche', 'fournisseur');					
				$result = $query->getArrayResult();

				// Transformer le tableau associatif en un tableau standard
				$array = array();
				foreach ($result as $data) {
					$array[] = array("label"=>$data['raisonSociale']);
				}				
			}
		$response = new Response(json_encode($array));
		return $response;
	}

	public function ajouterlocationfrsAction($ficheid, $locid, $type, $bdctransport, $mode, $erreur, Request $request)
	{
		$objUser = $this->get('security.context')->getToken()->getUsername(); if(empty($objUser) or !isset($objUser) or $objUser == 'anon.'){return $this->redirect($this->generateUrl('fos_user_security_login'));}
		$em = $this->getDoctrine()->getManager();//echo 'locid'.$locid;
		$bdcid = $locid;//echo 'bdcid'.$bdcid;
		if($bdcid == 0 )
		{		//echo 'aaaaaa';
			$locatafrs = new Locatafrs;
			$contrat = 0;
			$locatafrs->setDatecrea(date('Y-m-d'));
		
			$query = $em->createQuery(
				'SELECT b.compteurfac
				FROM BaclooCrmBundle:Factures b
				where b.typedoc = :bdc
				ORDER BY b.id DESC'
			)->setParameter('bdc', 'bon de commande');
			$query->setMaxResults(1);
			$lastnumfact = $query->getOneOrNullResult();
			if(empty($lastnumfact) or !isset($lastnumfact) or $lastnumfact == null)
			{
				$lastnumfact = 0;//echo 'vide';
			}
			else
			{
				$lastnumfact = $query->getSingleScalarResult();//echo 'pas vide';
			}
			$numbdc = date('Y').'H'.($lastnumfact++);
			$locatafrs->setNumbdc($numbdc);
		}
		elseif(($type == 'aller' or $type == 'retour') && $bdctransport == 1)
		{//echo 'bbbbb';		
			$locatafrs = new Locatafrs;
			$contrat = $locid;
			$locata  = $em->getRepository('BaclooCrmBundle:Locata')		
						   ->findOneById($locid);	
			$locatafrs->setNomchantier($locata->getNomchantier());
			$locatafrs->setAdresse1($locata->getAdresse1());
			$locatafrs->setAdresse2($locata->getAdresse2());
			$locatafrs->setAdresse3($locata->getAdresse3());
			$locatafrs->setCp($locata->getCp());
			$locatafrs->setVille($locata->getVille());
			$locatafrs->setCodelocatasl($locata->getId());
			$locatafrs->setTypes($type);
			$em->persist($locatafrs);
			$em->flush();
			foreach ($locata->getLocations() as $loc) 
			{
				$bdclocauto = new Locationsfrs;
				$bdclocauto->setCodeclient($locata->getClientid());
				$bdclocauto->setFournisseurid($loc->getLoueurid());
				$bdclocauto->setFournisseur($loc->getLoueur());
				$bdclocauto->setReference('transport');
				$bdclocauto->setDebutloc($loc->getDebutloc());
				$bdclocauto->setFinloc($loc->getFinloc());
				$bdclocauto->setMensuel(false);
				$bdclocauto->setDesignation($loc->getTypemachine());
				$bdclocauto->setPu(0);
				$bdclocauto->setQuantite($loc->getNbjloc());
				$bdclocauto->setMontantht(0);
				$bdclocauto->setCodelocationsl($loc->getId());
				$bdclocauto->addLocatafr($locatafrs);
				$locatafrs->addLocationsfr($bdclocauto);
				$em->persist($bdclocauto);
				$em->flush();				
			}
			foreach ($locata->getLocationssl() as $loc) 
			{
				$bdclocauto = new Locationsfrs;
				$bdclocauto->setCodeclient($locata->getClientid());
				$bdclocauto->setFournisseurid($loc->getLoueurid());
				$bdclocauto->setFournisseur($loc->getLoueur());
				$bdclocauto->setReference('transport');
				$bdclocauto->setDebutloc($loc->getDebutloc());
				$bdclocauto->setFinloc($loc->getFinloc());
				$bdclocauto->setMensuel(false);
				$bdclocauto->setDesignation($loc->getTypemachine());
				$bdclocauto->setPu(0);
				$bdclocauto->setQuantite($loc->getNbjloc());
				$bdclocauto->setMontantht(0);
				$bdclocauto->setCodelocationsl($loc->getId());
				$bdclocauto->addLocatafr($locatafrs);
				$locatafrs->addLocationsfr($bdclocauto);
				$em->persist($bdclocauto);
				$em->flush();				
			}//echo '9999999'.$locatafrs->getId();
			$bdcid = $locatafrs->getId();;
		}
		else
		{
			$locatafrs  = $em->getRepository('BaclooCrmBundle:Locatafrs')		
						   ->findOneById($bdcid);	//echo 'ici'.$locatafrs->getId();	
			$bdcid = $locatafrs->getId();
		}
		$userdetails  = $em->getRepository('BaclooUserBundle:User')		
					   ->findOneByUsername($objUser);			
		$userid = $userdetails->getId();
		$form = $this->createForm(new LocatafrsType(), $locatafrs);

		$today = date('Y-m-d');
		include('societe.php');

		//On met les locationsfrs dans un array pour controle ultérieur
		// $listeloc = array();
		// foreach ($locatafrs->getLocationsfrs() as $loc) {
		  // $listeloc[] = $loc;
		// }		
		
		$em = $this->getDoctrine()->getManager();
		$modules  = $em->getRepository('BaclooCrmBundle:Modules')		
					   ->findOneByUsername($objUser);
					   
		$fournisseur  = $em->getRepository('BaclooCrmBundle:Fiche')		
					   ->findOneById($ficheid);		

		// On récupère la requête
		$request = $this->get('request');
		// On vérifie qu'elle est de type POST
		if ($request->getMethod() == 'POST') 
		{
			$form->bind($request);
		// On vérifie que les valeurs entrées sont correctes
		// $data = $form->getData();
			if ($form->isValid()){
				//Création du numero dde bdc unique
				if($mode == 'recurrent'){$locatafrs->setMode('recurrent');}
				// $locatafrs->set
				$em->persist($locatafrs);	
				// $em->flush();
				
				$fournisseurnom = $form->get('fournisseur')->getData();echo 'XXX';echo $fournisseurnom;
				$nomchantier = $form->get('nomchantier')->getData();
				$adresse1 = $form->get('adresse1')->getData();
				$adresse2 = $form->get('adresse2')->getData();
				$adresse3 = $form->get('adresse3')->getData();
				$cp = $form->get('cp')->getData();
				$ville = $form->get('ville')->getData();
				$locationsfrs = $form->get('locationsfrs')->getData();

				if(isset($nomchantier))
				{
					//Mise à jour de la table chantier si le chantier n'existe pas
					$chantier = $em->getRepository('BaclooCrmBundle:Chantier')
														->findOneByNom($nomchantier);
					if(empty($chantier))
					{
						$newchantier = new Chantier;
						$newchantier->setNom($nomchantier);
						$newchantier->setAdresse1($adresse1);
						$newchantier->setAdresse2($adresse2);
						$newchantier->setAdresse3($adresse3);
						$newchantier->setCp($cp);
						$newchantier->setVille($ville);
						$em->persist($newchantier);
						// $em->flush();					
					}
					//Fin maj chantier
				}
				$quantite = 0;
				$locationht = 0;
				$assuranceht = 0;
				$contributionverteht = 0;
				$pieceht = 0;
				$transportht = 0;
				$materielht = 0;
				$prestationht = 0;
				$autreht = 0;

				//Création du montant HT ligne par ligne
				$totalht = 0;//echo $locid;
				$assurancetotal = 0;
				$contributionvertetotal = 0;
				foreach ($form->get('locationsfrs')->getData() as $loc)
					{echo ' EFERENCE'.$loc->getReference();	echo'debutloc';echo $loc->getDebutloc();				
						$fournisseur = $em->getRepository('BaclooCrmBundle:Fiche')
							->findOneById($ficheid);
						$fournisseurnom = $fournisseur->getRaisonSociale();
						$fournisseurid = $fournisseur->getId();
						//caclcul du nbjloc pour servir les quantité pour loc eco et assert
						if(($loc->getReference() == 'location' or $loc->getReference() == 'contributionverte' or $loc->getReference() == 'assurance') && $loc->getDebutloc() != '' && $loc->getFinloc() != '')
						{echo '11111';
							$dStart = $loc->getDebutloc();
							$dEnd = $loc->getFinloc();
							$begin = new \DateTime($dStart);
							$end = new \DateTime($dEnd);
							$end = $end->modify( '+1 day' ); 

							$interval = DateInterval::createFromDateString('1 day');
							$period = new DatePeriod($begin, $interval, $end);
							$nbjloc = 0;
							$nbjlocass = 0;

							foreach ($period as $dt) {
								$newformat = $dt->format("D");
								$nbjlocass++;
								if($loc->getFacturersamedi() == 1 && $newformat == 'Sat')
								{echo 'samedi';
									$nbjloc++;
								}
								elseif($loc->getFacturerdimanche() == 1 && $newformat == 'Sun')
								{echo 'dimanche';
									$nbjloc++;
								}
								elseif($newformat == 'Sat' or $newformat == 'Sun')
								{}
								else
								{echo 'autrejour';
									$nbjloc++;
								}							
							}
							$loc->setNbjlocass($nbjlocass);
						}echo '<br>NBJLOC'.$nbjloc;
						if(empty($nbjloc)){$nbjloc = 0;}
						if($loc->getReference() == 'location')
						{echo '222222';
							if($loc->getMensuel() == 1)
							{echo 'aaa';
								include('calculnbjlocmensuellebdc.php');
								$locationht += $nbjloc*$loc->getPu()/20;echo 'LOCATIONHT'.$locationht; 
								$locationhtligne = $nbjloc*$loc->getPu()/20;
								if((null !== $locatafrs->getCodelocatasl() && $locatafrs->getCodelocatasl() > 0) or $mode == 'recurrent')
								{echo '&&&&&&&&';
									$loc->setQuantite($nbjloc/20);
								}
							}
							else
							{echo 'nbjloc'.$nbjloc;
								if($nbjloc > 0)
								{echo 'bbb';
									$locationht += $nbjloc*$loc->getPu();echo 'LOCATIONHT'.$locationht; 
									$locationhtligne = $nbjloc*$loc->getPu();
									if((null !== $locatafrs->getCodelocatasl() && $locatafrs->getCodelocatasl() > 0) or (null !==$loc->getDebutloc() && null !== $loc->getFinloc()))
									{echo'yes';
										$loc->setQuantite($nbjloc);
									}else{echo 'no';}
								}
								else
								{
									$locationht += $loc->getQuantite()*$loc->getPu();echo 'LOCATIONHT'.$locationht; 
									$locationhtligne = $loc->getQuantite()*$loc->getPu();echo 'locationhtligne'.$locationhtligne; 
								}
							}
							$loc->setMontantht($locationhtligne);

								//calcul de l'assurance
							if($fournisseur->getFrsrc() == 1)
							{
								if($fournisseur->getUniterc() == '%')
								{
									$assuranceunite = $loc->getPu() * $fournisseur->getMontantrc()/100;
								}
								else
								{
									$assuranceunite = $fournisseur->getMontantrc();
								}
								if($fournisseur->getBasecalculrc() == 1)
								{
									$assurance = $assuranceunite;
								}
								elseif($fournisseur->getBasecalculeco() == 5)
								{
									$assurance = $assuranceunite*$nbjloc;
								}
								elseif($fournisseur->getBasecalculeco() == 7)
								{
									$assurance = $assuranceunite*$nbjlocass;
								}

							}
							else//si pas d'eco
							{
								$assurance = 0;
							}
							$assurancetotal += $assurance;
							$loc->setAssurance($assurance);
							if($fournisseur->getFrseco() == 1)
							{echo 'uuuuuuuuuu';
								if($fournisseur->getUniteeco() == '%')
								{
									$ecopartunite = $loc->getPu() * $fournisseur->getMontanteco()/100;
								}
								else
								{
									$ecopartunite = $fournisseur->getMontanteco();
								}
								if($fournisseur->getBasecalculeco() == 1)
								{
									$contributionverte = $ecopartunite;
									$nbjloceco = 1;
								}
								elseif($fournisseur->getBasecalculeco() == 5)
								{
									$contributionverte = $ecopartunite*$nbjloc;
									$nbjloceco = $nbjloc;
								}
								elseif($fournisseur->getBasecalculeco() == 7)
								{
									$contributionverte = $ecopartunite*$nbjlocass;
									$nbjloceco = $nbjlocass;
								}
								echo 'BBBBBBBBB';$loc->setContributionverte($contributionverte);
							}
							else//si pas d'eco
							{echo 'iiiiiiiiiiiiii';
								$contributionverte = 0;
							}
							$contributionvertetotal += $contributionverte;
							$loc->setContributionverte($contributionverte);							
						}
						elseif($loc->getReference() == 'piece')
						{echo '333333333';
							$pieceht += $loc->getQuantite()*$loc->getPu();
							$piecehtligne = $loc->getQuantite()*$loc->getPu();				
							$articles = $em->getRepository('BaclooCrmBundle:Articlesenvente')
								->findOneByDesignation($loc->getDesignation());
							if(isset($articles))
							{
								$articles->setEnattentereception($loc->getQuantite());
								$em->persist($articles);
							}
							$loc->setMontantht($piecehtligne);
						}
						elseif($loc->getReference() == 'transport')
						{echo '66666666';
							$transportht += $loc->getQuantite()*$loc->getPu();
							$transporthtligne = $loc->getQuantite()*$loc->getPu();
							$loc->setMontantht($transporthtligne);
						}
						elseif($loc->getReference() == 'materiel')
						{echo '777777';
							$materielht += $loc->getQuantite()*$loc->getPu();
							$materielhtligne = $loc->getQuantite()*$loc->getPu();
							$loc->setMontantht($materielhtligne);
						}
						elseif($loc->getReference() == 'prestation')
						{echo '8888888888';
							$prestationht += $loc->getQuantite()*$loc->getPu();
							$prestationhtligne = $loc->getQuantite()*$loc->getPu();
							$loc->setMontantht($prestationhtligne);
						}
						elseif($loc->getReference() == 'autre')
						{echo '9999999999';
							$autreht += $loc->getQuantite()*$loc->getPu();
							$autrehtligne = $loc->getQuantite()*$loc->getPu();
							$loc->setMontantht($autrehtligne);
						}		
					}
					$em->flush();echo 'LOCATIONHT1X';
					foreach ($form->get('locationsfrs')->getData() as $loc)
					{//echo ' EFERENCE'.$loc->getReference();	echo'debutloc';echo $loc->getDebutloc();				
						$fournisseur = $em->getRepository('BaclooCrmBundle:Fiche')
							->findOneById($ficheid);
						$fournisseurnom = $fournisseur->getRaisonSociale();
						$fournisseurid = $fournisseur->getId();
						//caclcul du nbjloc pour servir les quantité pour loc eco et assert
						if(($loc->getReference() == 'location' or $loc->getReference() == 'contributionverte' or $loc->getReference() == 'assurance') && $loc->getDebutloc() != '' && $loc->getFinloc() != '')
						{echo '11111';
							$dStart = $loc->getDebutloc();
							$dEnd = $loc->getFinloc();
							$begin = new \DateTime($dStart);
							$end = new \DateTime($dEnd);
							$end = $end->modify( '+1 day' ); 

							$interval = DateInterval::createFromDateString('1 day');
							$period = new DatePeriod($begin, $interval, $end);
							$nbjloc = 0;
							$nbjlocass = 0;

							foreach ($period as $dt) {
								$newformat = $dt->format("D");
								$nbjlocass++;
								if($loc->getFacturersamedi() == 1 && $newformat == 'Sat')
								{echo 'samedi';
									$nbjloc++;
								}
								elseif($loc->getFacturerdimanche() == 1 && $newformat == 'Sun')
								{echo 'dimanche';
									$nbjloc++;
								}
								elseif($newformat == 'Sat' or $newformat == 'Sun')
								{}
								else
								{echo 'autrejour';
									$nbjloc++;
								}							
							}									
						}echo '<br>NBJLOC'.$nbjloc;
						if(empty($nbjloc)){$nbjloc = 0;}	
						
						if($loc->getReference() == 'assurance')
						{echo '444444444';
							//Calcul locationht
							if($loc->getMensuel() == 1)
							{								
								if($nbjloc < 20)
								{
									$assuranceht = ($loc->getPu()/20)*$nbjloc;
								}
								else
								{
									$assuranceht = $loc->getPu();
									$nbjloc = 20;
									$nbjlocass = 28;
								}
								//PBM Locationht est faux pour assurance et contributionverte. donc ne pas renseigner le PU ok pour la quantité

							}
							else//Si Loyer pas mensuel
							{
								$location = $loc->getPu()*$nbjloc;

								$loc->setMontantht($location);
								$totalht += $location;
								$loc->setPu($loc->getPu());
								if($loc->getReference() == 'assurance')
								{
									if(null !== $locatafrs->getCodelocatasl() && $locatafrs->getCodelocatasl() > 0)
									{echo 'ccc';
										$loc->setQuantite($nbjloc);
									}
								}
								//calcul de l'assurance
								
							}
							echo 'PU'.$loc->getPu();
							echo 'QUANTITE'.$loc->getQuantite();
							if($assurance == 0 && $loc->getQuantite() > 0){$assurancehtligne = $loc->getPu()*$loc->getQuantite();}else{$assurancehtligne = $assurance;}
							$loc->setPu($loc->getPu());
							if(null !== $locatafrs->getCodelocatasl() && $locatafrs->getCodelocatasl() > 0)
							{echo 'eee';
								$loc->setQuantite($nbjloceco);
							}			
							$assuranceht += $assurancehtligne;
							$loc->setMontantht($assurancehtligne);
							$loc->setFournisseur($fournisseurnom);
							$loc->setFournisseurid($fournisseurid);
						}
						elseif($loc->getReference() == 'contributionverte')
						{echo '5555555555';

							//Calcul locationht
							if($loc->getMensuel() == 1)
							{
								if($nbjloc < 20)
								{echo 'yyyyyyyy';
									$location = ($loc->getPu()/20)*$nbjloc;
								}
								else
								{echo 'dddddddddda';
									$location = $loc->getPu();
									$nbjloc = 20;
									$nbjlocass = 28;
								}
								//calcul de l'ecoparticiaption
				
							}							
							else//Si Loyer pas mensuel
							{
								$location = $loc->getPu()*$nbjloc;
								
								//calcul de l'ecoparticiaption
								if($fournisseur->getFrseco() == 1)
								{
									if($fournisseur->getUniteeco() == '%')
									{
										$ecopartunite = $location * $fournisseur->getMontanteco()/100;
									}
									else
									{
										$ecopartunite = $fournisseur->getMontanteco();
									}
									if($fournisseur->getBasecalculeco() == 1)
									{
										$contributionverte = $ecopartunite;
										$nbjloceco = 1;
									}
									elseif($fournisseur->getBasecalculeco() == 5)
									{
										$contributionverte = $ecopartunite*$nbjloc;
										$nbjloceco = $nbjloc;
									}
									elseif($fournisseur->getBasecalculeco() == 7)
									{
										$contributionverte = $ecopartunite*$nbjlocass;
										$nbjloceco = $nbjlocass;
									}								
								}
								else//si pas d'eco
								{
									$contributionverte = 0;
								}
								echo 'AAAAAAAAA';$loc->setContributionverte($contributionverte);
							}
							echo 'PU'.$loc->getPu();
							echo 'QUANTITE'.$loc->getQuantite();
							if($contributionverte == 0 && $loc->getQuantite() > 0){$contributionvertehtligne = $loc->getPu()*$loc->getQuantite();}else{$contributionvertehtligne = $contributionverte;}
							$loc->setPu($loc->getPu());
							if(null !== $locatafrs->getCodelocatasl() && $locatafrs->getCodelocatasl() > 0)
							{echo 'eee';
								$loc->setQuantite($nbjloceco);
							}			
							$contributionverteht += $contributionvertehtligne;
							$loc->setMontantht($contributionvertehtligne);
						}
						// $loc->setCodeclient($fournisseur->getId());				
					}
					$em->flush();
echo 'LAAAAAAAA';					
					$totalht = $locationht + $assuranceht + $contributionverteht + $pieceht + $transportht + $materielht + $prestationht + $autreht;
					echo 'locationht'.$locationht;echo 'assuranceht'.$assuranceht;echo 'contributionverte'.$contributionverteht;echo 'autres'.$autreht;echo 'pieceht'.$pieceht;echo 'transportht'.$transportht;echo 'materielht'.$materielht;echo 'prestationht'.$prestationht;
					$tva = $totalht * 0.20;
					$totalttc = $totalht + $tva;
// echo $fournisseurnom;						
					$locatafrs->setContributionverte($contributionvertetotal);
					$locatafrs->setAssurance($assurancetotal);
					$locatafrs->setMontantloc($totalht);
					$locatafrs->setFournisseur($fournisseurnom);
					$locatafrs->setFournisseurid($ficheid);
					$em->persist($locatafrs);
					$em->flush();	

					$bdcid = $locatafrs->getId();


				$em->flush();
				
				// On redirige vers la page de visualisation de la fiche nouvellement créée
				return $this->redirect($this->generateUrl('bacloocrm_ajouterlocationfrs', array('ficheid' => $ficheid, 'locid' => $locatafrs->getId(), 'type' => $type, 'mode' => $mode )));
			}
		}
		
		if($bdcid > 0)
		{//echo 'laaa';
			$totalht = $locatafrs->getMontantloc();
			$grille = array();	
		}
		else
		{//echo 'ici';
			$totalht = 0;
		}		
					// echo $grille;	

					// echo $locid;		   									   
		return $this->render('BaclooCrmBundle:Crm:nouvelle_locationfrs.html.twig', array('form' => $form->createView(),
																			'date' => $today,
																			'fournisseur' => $fournisseur,
																			'usersociete' => $societe,
																			'modules' => $modules,
																			'entreprise' => $fournisseur->getRaisonSociale(),
																			'typefiche' => $fournisseur->getTypefiche(),
																			'id' => $ficheid,
																			'erreur' => $erreur,
																			'bdcid' => $bdcid,
																			'mode' => $mode,
																			'totalht' => $totalht,
																			'user' => $objUser));
	}

	public function ajouterlocationfrsspeedAction($message, Request $request)
	{
		$objUser = $this->get('security.context')->getToken()->getUsername(); if(empty($objUser) or !isset($objUser) or $objUser == 'anon.'){return $this->redirect($this->generateUrl('fos_user_security_login'));}
		$em = $this->getDoctrine()->getManager();//echo 'locid'.$locid;
		// $bdcid = $locid;//echo 'bdcid'.$bdcid;

		$userdetails  = $em->getRepository('BaclooUserBundle:User')		
					   ->findOneByUsername($objUser);			
		$userid = $userdetails->getId();

		$today = date('Y-m-d');
		include('societe.php');

		//On met les locationsfrs dans un array pour controle ultérieur
		// $listeloc = array();
		// foreach ($locatafrs->getLocationsfrs() as $loc) {
		  // $listeloc[] = $loc;
		// }		
		
		$em = $this->getDoctrine()->getManager();
			
		//création du formlaire de saisie rapide
		$defaultData = array();
		$form = $this->createFormBuilder($defaultData)
            ->add('reference', 'choice', array(
					'choices'   => array(
						'hotel'   => 'Hôtel',
						'restauration'   => 'Restauration',
						'deplacements'   => 'Déplacements',
						'transport' => 'Transport',
						'piece' => 'Pièce',
						'materiel' => 'Materiel',
						'prestation' => 'Prestation',
						'autre' => 'Autres',
					),
					'multiple'  => false,
				))
			->add('fournisseur', 'text', array('required' => false))
			->add('fournisseurid', 'text', array('required' => false))
			->add('designation', 'text', array('required' => false))
			->add('pu', 'number', array('required' => false))
			->add('quantite', 'integer', array('required' => false))
			->add('montantht', 'number', array('required' => false))
			->add('montantttc', 'number', array('required' => false))
			->getForm();		
		// On récupère la requête
		// $request = $this->get('request');
		// On vérifie qu'elle est de type POST
		if ($request->getMethod() == 'POST') 
		{echo 'post';
			// $form->bind($request);
			$form->handleRequest($request);
		// On vérifie que les valeurs entrées sont correctes
		// $data = $form->getData();
			if ($form->isValid())
			{		echo 'valide';		
				
			// if($form2->isValid()){echo 'ttttttt';
				$data = $form->getData();	
				$reference = $data['reference'];
				$fournisseurnom = $data['fournisseur'];
				$fournisseurid = $data['fournisseurid'];
				$designation = $data['designation'];
				$pu = $data['pu'];
				$quantite = $data['quantite'];//echo 'CLIENT'.$client;
				$montantht = $data['montantht'];//echo 'CLIENT'.$client;
				$montantttc = $data['montantttc'];//echo 'CLIENT'.$client;
				
				$fournisseur  = $em->getRepository('BaclooCrmBundle:Fiche')		
												   ->findOneByRaisonSociale($fournisseurnom);				
			
				if(empty($fournisseur))
				{echo 'empty';
					$fournisseur = new Fiche;
					$fournisseur->setRaisonsociale($fournisseurnom);					
					$fournisseur->setTypefiche('fournisseur');					
					$fournisseur->setUser($objUser);				
					$fournisseur->setUsersociete($societe);				
					$fournisseur->setLastmodif($today);				
					$em->persist($fournisseur);
					$em->flush();
				}
				
				$query = $em->createQuery(
					'SELECT b.compteurfac
					FROM BaclooCrmBundle:Factures b
					where b.typedoc = :bdc
					ORDER BY b.id DESC'
				)->setParameter('bdc', 'bon de commande');
				$query->setMaxResults(1);
				$lastnumfact = $query->getOneOrNullResult();
				if(empty($lastnumfact) or !isset($lastnumfact) or $lastnumfact == null)
				{
					$lastnumfact = 0;//echo 'vide';
				}
				else
				{
					$lastnumfact = $query->getSingleScalarResult();//echo 'pas vide';
				}
				$numbdc = date('Y').'H'.($lastnumfact++);									
				$locatafrs = new Locatafrs;
				$locatafrs->setFournisseur($fournisseurnom);
				$locatafrs->setFournisseurid($fournisseur->getId());
				$locatafrs->setUser($objUser);
				$locatafrs->setDatemodif($today);
				$locatafrs->setMontantloc($montantht);
				$locatafrs->setMontantttc($montantttc);
				$locatafrs->setEtatbdc(1);
				$locatafrs->setNumbdc($numbdc);	

				$em->persist($locatafrs);
				$em->flush();
				
				$locationsfrs = new Locationsfrs;
				$locationsfrs->setReference($reference);
				$locationsfrs->setFournisseurid($fournisseur->getId());
				$locationsfrs->setFournisseur($fournisseurnom);
				$locationsfrs->setDesignation($designation);
				$locationsfrs->setPu($pu);
				$locationsfrs->setQuantite($quantite);
				$locationsfrs->setMontantht($montantht);
				$locationsfrs->setMontantttc($montantttc);
				$locationsfrs->addLocatafr($locatafrs);
				$locatafrs->addLocationsfr($locationsfrs);
				$em->persist($locationsfrs);
				$em->persist($locatafrs);
				$em->flush();
				
				$message = 'ok';
				include('achatsimple.php');
				return $this->redirect($this->generateUrl('bacloocrm_ajouterlocationfrsspeed', array('message' => $message )));
			}
		}		   									   
		return $this->render('BaclooCrmBundle:Crm:nouvelle_locationfrsspeed.html.twig', array('form' => $form->createView(),
																								'message' => $message));
	}


	public function modifierfacfrsAction($ficheid, $locid, $type, $bdctransport, $erreur, Request $request)
	{
		$objUser = $this->get('security.context')->getToken()->getUsername(); if(empty($objUser) or !isset($objUser) or $objUser == 'anon.'){return $this->redirect($this->generateUrl('fos_user_security_login'));}
		$em = $this->getDoctrine()->getManager();//echo 'locid'.$locid;
		$bdcid = $locid;//echo 'bdcid'.$bdcid;

		$locatafrs  = $em->getRepository('BaclooCrmBundle:Locatafrsclone')		
					   ->findOneById($bdcid);	//echo 'ici'.$locatafrs->getId();	
		$bdcid = $locatafrs->getId();
		
		$userdetails  = $em->getRepository('BaclooUserBundle:User')		
					   ->findOneByUsername($objUser);			
		$userid = $userdetails->getId();
		$form = $this->createForm(new LocatafrscloneType(), $locatafrs);

		$today = date('Y-m-d');
		include('societe.php');

		//On met les locationsfrs dans un array pour controle ultérieur
		// $listeloc = array();
		// foreach ($locatafrs->getLocationsfrs() as $loc) {
		  // $listeloc[] = $loc;
		// }		
		
		$em = $this->getDoctrine()->getManager();
		$modules  = $em->getRepository('BaclooCrmBundle:Modules')		
					   ->findOneByUsername($objUser);
					   
		$fournisseur  = $em->getRepository('BaclooCrmBundle:Fiche')		
					   ->findOneById($ficheid);		

		// On récupère la requête
		$request = $this->get('request');
		// On vérifie qu'elle est de type POST
		if ($request->getMethod() == 'POST') 
		{
			$form->bind($request);
		// On vérifie que les valeurs entrées sont correctes
		// $data = $form->getData();
			if ($form->isValid()){
				//Création du numero dde bdc unique
	
				// $locatafrs->set
				$em->persist($locatafrs);	
				// $em->flush();
				
				$fournisseurnom = $form->get('fournisseur')->getData();echo 'XXX';echo $fournisseurnom;
				$nomchantier = $form->get('nomchantier')->getData();
				$adresse1 = $form->get('adresse1')->getData();
				$adresse2 = $form->get('adresse2')->getData();
				$adresse3 = $form->get('adresse3')->getData();
				$cp = $form->get('cp')->getData();
				$ville = $form->get('ville')->getData();
				$locationsfrs = $form->get('locationsfrsclone')->getData();

				
				//Mise à jour de la table chantier si le chantier n'existe pas
				$chantier = $em->getRepository('BaclooCrmBundle:Chantier')
												    ->findOneByNom($nomchantier);

				//Fin maj chantier

				$quantite = 0;
				$locationht = 0;
				$assuranceht = 0;
				$contributionverteht = 0;
				$pieceht = 0;
				$transportht = 0;
				$materielht = 0;
				$prestationht = 0;
				$autreht = 0;
				$locpu = 0;

				//Création du montant HT ligne par ligne
				$totalht = 0;//echo $locid;
					foreach ($form->get('locationsfrsclone')->getData() as $loc)
					{echo ' EFERENCE'.$loc->getReference();	echo'debutloc';echo $loc->getDebutloc();				
						$fournisseur = $em->getRepository('BaclooCrmBundle:Fiche')
							->findOneById($ficheid);
						$fournisseurnom = $fournisseur->getRaisonSociale();
						$fournisseurid = $fournisseur->getId();
						//caclcul du nbjloc pour servir les quantité pour loc eco et assert
						if(($loc->getReference() == 'location' or $loc->getReference() == 'contributionverte' or $loc->getReference() == 'assurance') && $loc->getDebutloc() != '' && $loc->getFinloc() != '')
						{echo '11111';
							$dStart = $loc->getDebutloc();
							$dEnd = $loc->getFinloc();
							$begin = new \DateTime($dStart);
							$end = new \DateTime($dEnd);
							$end = $end->modify( '+1 day' ); 

							$interval = DateInterval::createFromDateString('1 day');
							$period = new DatePeriod($begin, $interval, $end);
							$nbjloc = 0;
							$nbjlocass = 0;

							foreach ($period as $dt) {
								$newformat = $dt->format("D");
								$nbjlocass++;
								if($loc->getFacturersamedi() == 1 && $newformat == 'Sat')
								{echo 'samedi';
									$nbjloc++;
								}
								elseif($loc->getFacturerdimanche() == 1 && $newformat == 'Sun')
								{echo 'dimanche';
									$nbjloc++;
								}
								elseif($newformat == 'Sat' or $newformat == 'Sun')
								{}
								else
								{echo 'autrejour';
									$nbjloc++;
								}							
							}									
						}//echo '<br>NBJLOC'.$nbjloc;
						if(empty($nbjloc)){$nbjloc = 0;}
						if($loc->getReference() == 'location')
						{echo '222222';
							if($loc->getMensuel() == 1)
							{echo 'aaa';
								include('calculnbjlocmensuellebdc.php');
								$locationht += $nbjloc*$loc->getPu()/20;echo 'LOCATIONHT'.$locationht; 
								$locationhtligne = $nbjloc*$loc->getPu()/20;
								if(null !== $locatafrs->getCodelocatasl() && $locatafrs->getCodelocatasl() > 0)
								{
									$loc->setQuantite($nbjloc/20);
								}
							}
							else
							{echo 'nbjloc'.$nbjloc;
								if($nbjloc > 0)
								{echo 'bbb';
									$locationht += $nbjloc*$loc->getPu();echo 'LOCATIONHT'.$locationht; 
									$locationhtligne = $nbjloc*$loc->getPu();
									if((null !== $locatafrs->getCodelocatasl() && $locatafrs->getCodelocatasl() > 0) or (null !==$loc->getDebutloc() && null !== $loc->getFinloc()))
									{echo'yes';
										$loc->setQuantite($nbjloc);
									}else{echo 'no';}
								}
								else
								{
									$locationht += $loc->getQuantite()*$loc->getPu();echo 'LOCATIONHT'.$locationht; 
									$locationhtligne = $loc->getQuantite()*$loc->getPu();echo 'locationhtligne'.$locationhtligne; 
								}
							}
							$loc->setMontantht($locationhtligne);
						}
						elseif($loc->getReference() == 'piece')
						{echo '333333333';
							$pieceht += $loc->getQuantite()*$loc->getPu();
							$piecehtligne = $loc->getQuantite()*$loc->getPu();				
							$articles = $em->getRepository('BaclooCrmBundle:Articlesenvente')
								->findOneByDesignation($loc->getDesignation());
							if(isset($articles))
							{
								$articles->setEnattentereception($loc->getQuantite());
								$em->persist($articles);
							}
							$loc->setMontantht($piecehtligne);
						}			
						elseif($loc->getReference() == 'assurance')
						{echo '444444444';
							//Calcul locationht
							if($loc->getMensuel() == 1)
							{								
								if($nbjloc < 20)
								{
									$assuranceht = ($loc->getPu()/20)*$nbjloc;
								}
								else
								{
									$assuranceht = $loc->getPu();
									$nbjloc = 20;
									$nbjlocass = 28;
								}
								//PBM Locationht est faux pour assurance et contributionverte. donc ne pas renseigner le PU ok pour la quantité
								//calcul de l'assurance
								if($fournisseur->getFrsrc() == 1)
								{
									if($fournisseur->getUniterc() == '%')
									{
										$assuranceunite = $assuranceht * $fournisseur->getMontantrc()/100;
									}
									else
									{
										$assuranceunite = $fournisseur->getMontantrc();
									}
									if($fournisseur->getBasecalculrc() == 1)
									{
										$assurance = $assuranceunite;
									}
									elseif($fournisseur->getBasecalculeco() == 5)
									{
										$assurance = $assuranceunite*$nbjloc;
									}
									elseif($fournisseur->getBasecalculeco() == 7)
									{
										$assurance = $assuranceunite*$nbjlocass;
									}

								}
								else//si pas d'eco
								{
									$assurance = 0;
								}
							}
							else//Si Loyer pas mensuel
							{echo 'loyer pas mensuel';echo 'NBJLOC'.$nbjloc;
								$locationht = $loc->getPu()*$nbjloc;echo 'LOCATION HT'.$locationht;echo 'PUUU'.$loc->getPU();

								$loc->setMontantht($locationht);
								$totalht += $locationht;
								$loc->setPu($loc->getPu());
								if($loc->getReference() == 'assurance')
								{
									if(null !== $locatafrs->getCodelocatasl() && $locatafrs->getCodelocatasl() > 0)
									{echo 'ccc';
										$loc->setQuantite($nbjloc);
									}
								}
								//calcul de l'assurance
								if($fournisseur->getFrsrc() == 1)
								{echo 'AUTO';
									if($fournisseur->getUniterc() == '%')
									{echo '%%%';
										$assuranceunite = $locationht * $fournisseur->getMontantrc()/100;echo 'ASSSURANCEUNITE'.$assuranceunite;
									}
									else
									{
										$assuranceunite = $fournisseur->getMontantrc();
									}
									if($fournisseur->getBasecalculrc() == 1)
									{
										$assurance = $assuranceunite;
									}
									elseif($fournisseur->getBasecalculrc() == 5)
									{
										$assurance = $assuranceunite*$nbjloc;
									}
									elseif($fournisseur->getBasecalculrc() == 7)
									{
										$assurance = $assuranceunite*$nbjloc;
									}
									
								}
								else//si pas d'eco
								{echo 'PAS AUTO';
									$assurance = 0;
								}
							}
							$loc->setPu($loc->getPu());echo 'ASSURANCE'.$assurance;
							if($assurance == 0 && $loc->getQuantite() > 0){$assurancehtligne = $loc->getPu()*$loc->getQuantite();}else{$assurancehtligne = $assurance;}
							if(null !== $locatafrs->getCodelocatasl() && $locatafrs->getCodelocatasl() > 0)
							{echo 'ddd';
								$loc->setQuantite($nbjlocass);
							}
							$assuranceht += $nbjlocass*$loc->getPu();
							$loc->setMontantht($assurancehtligne);
							$loc->setFournisseur($fournisseurnom);
							$loc->setFournisseurid($fournisseurid);
						}
						elseif($loc->getReference() == 'contributionverte')
						{echo '5555555555';

							//Calcul locationht
							if($loc->getMensuel() == 1)
							{
								if($nbjloc < 20)
								{echo 'yyyyyyyy';
									$locationht = ($loc->getPu()/20)*$nbjloc;
								}
								else
								{echo 'dddddddddda';
									$locationht = $loc->getPu();
									$nbjloc = 20;
									$nbjlocass = 28;
								}
								//calcul de l'ecoparticiaption
								if($fournisseur->getFrseco() == 1)
								{echo 'uuuuuuuuuu';
									if($fournisseur->getUniteeco() == '%')
									{
										$ecopartunite = $locationht * $fournisseur->getMontanteco()/100;
									}
									else
									{
										$ecopartunite = $fournisseur->getMontanteco();
									}
									if($fournisseur->getBasecalculeco() == 1)
									{
										$contributionverte = $ecopartunite;
										$nbjloceco = 1;
									}
									elseif($fournisseur->getBasecalculeco() == 5)
									{
										$contributionverte = $ecopartunite*$nbjloc;
										$nbjloceco = $nbjloc;
									}
									elseif($fournisseur->getBasecalculeco() == 7)
									{
										$contributionverte = $ecopartunite*$nbjlocass;
										$nbjloceco = $nbjlocass;
									}							
								}
								else//si pas d'eco
								{echo 'iiiiiiiiiiiiii';
									$contributionverte = 0;
								}				
							}							
							else//Si Loyer pas mensuel
							{
								$locationht = $loc->getPu()*$nbjloc;
								
								//calcul de l'ecoparticiaption
								if($fournisseur->getFrseco() == 1)
								{
									if($fournisseur->getUniteeco() == '%')
									{
										$ecopartunite = $locationht * $fournisseur->getMontanteco()/100;
									}
									else
									{
										$ecopartunite = $fournisseur->getMontanteco();
									}
									if($fournisseur->getBasecalculeco() == 1)
									{
										$contributionverte = $ecopartunite;
										$nbjloceco = 1;
									}
									elseif($fournisseur->getBasecalculeco() == 5)
									{
										$contributionverte = $ecopartunite*$nbjloc;
										$nbjloceco = $nbjloc;
									}
									elseif($fournisseur->getBasecalculeco() == 7)
									{
										$contributionverte = $ecopartunite*$nbjlocass;
										$nbjloceco = $nbjlocass;
									}echo 'YYY';								
								}
								else//si pas d'eco
								{echo 'XXXX';
									$contributionverte = 0;
								}
							}//echo 'nbjloceco1x'.$nbjloceco;
							echo 'PU'.$loc->getPu();
							echo 'QUANTITE'.$loc->getQuantite();
							if($contributionverte == 0 && $loc->getQuantite() > 0){$contributionvertehtligne = $loc->getPu()*$loc->getQuantite();}else{$contributionvertehtligne = $contributionverte;}
							$loc->setPu($loc->getPu());
							if(null !== $locatafrs->getCodelocatasl() && $locatafrs->getCodelocatasl() > 0)
							{echo 'eee';
								$loc->setQuantite($nbjloceco);
							}			
							$contributionverteht += $contributionvertehtligne;
							$loc->setMontantht($contributionvertehtligne);
						}
						elseif($loc->getReference() == 'transport')
						{echo '66666666';
							$transportht += $loc->getQuantite()*$loc->getPu();
							$transporthtligne = $loc->getQuantite()*$loc->getPu();
							$loc->setMontantht($transporthtligne);
						}
						elseif($loc->getReference() == 'materiel')
						{echo '777777';
							$materielht += $loc->getQuantite()*$loc->getPu();
							$materielhtligne = $loc->getQuantite()*$loc->getPu();
							$loc->setMontantht($materielhtligne);
						}
						elseif($loc->getReference() == 'prestation')
						{echo '8888888888';
							$prestationht += $loc->getQuantite()*$loc->getPu();
							$prestationhtligne = $loc->getQuantite()*$loc->getPu();
							$loc->setMontantht($prestationhtligne);
						}
						elseif($loc->getReference() == 'autre')
						{echo '9999999999';
							$autreht += $loc->getQuantite()*$loc->getPu();
							$autrehtligne = $loc->getQuantite()*$loc->getPu();
							$loc->setMontantht($autrehtligne);
						}
						else
						{echo '***********';echo $loc->getQuantite();echo $loc->getPu();
							$autreht += $loc->getQuantite()*$loc->getPu();
							$autrehtligne = $loc->getQuantite()*$loc->getPu();				
							$articles = $em->getRepository('BaclooCrmBundle:Articlesenvente')
								->findOneByDesignation($loc->getDesignation());
							if(isset($articles))
							{
								$articles->setEnattentereception($loc->getQuantite());
								$em->persist($articles);
							}
							$loc->setMontantht($autrehtligne);
						}
						// $loc->setCodeclient($fournisseur->getId());				
					}
					$totalht = $locationht + $assuranceht + $contributionverteht + $pieceht + $transportht + $materielht + $prestationht + $autreht;
					$tva = $totalht * 0.20;
					$totalttc = $totalht + $tva;
// echo $fournisseurnom;						
					$locatafrs->setMontantloc($totalht);
					$locatafrs->setFournisseur($fournisseurnom);
					$locatafrs->setFournisseurid($ficheid);
					$em->persist($locatafrs);
					$em->flush();	

					$bdcid = $locatafrs->getId();


				$em->flush();
				
				// On redirige vers la page de visualisation de la fiche nouvellement créée
				// return $this->redirect($this->generateUrl('bacloocrm_modifierfacfrs', array('ficheid' => $ficheid, 'locid' => $locatafrs->getId(), 'type' => $type )));
			}
		}
		
		if($bdcid > 0)
		{//echo 'laaa';
			$totalht = $locatafrs->getMontantloc();
			$grille = array();	
		}
		else
		{//echo 'ici';
			$totalht = 0;
		}		
					// echo $grille;	

					// echo $locid;		   									   
		return $this->render('BaclooCrmBundle:Crm:modifier_locationfrs.html.twig', array('form' => $form->createView(),
																			'date' => $today,
																			'fournisseur' => $fournisseur,
																			'usersociete' => $societe,
																			'modules' => $modules,
																			'entreprise' => $fournisseur->getRaisonSociale(),
																			'typefiche' => $fournisseur->getTypefiche(),
																			'id' => $ficheid,
																			'erreur' => $erreur,
																			'bdcid' => $bdcid,
																			'totalht' => $totalht,
																			'user' => $objUser));
	}

	// public function genererpdf($html)
	// {
//         //set_time_limit(30); uncomment this line according to your needs
//         // If you are not in a controller, retrieve of some way the service container and then retrieve it
//         //$pdf = $this->container->get("white_october.tcpdf")->create('vertical', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        // if you are in a controlller use :
//         $pdf = $this->get("white_october.tcpdf")->create('vertical', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
//         $pdf->SetAuthor('Our Code World');
//         $pdf->SetTitle(('Our Code World Title'));
//         $pdf->SetSubject('Our Code World Subject');
//         $pdf->setFontSubsetting(true);
//         $pdf->SetFont('helvetica', '', 11, '', true);
//         //$pdf->SetMargins(20,20,40, true);
//         $pdf->AddPage();
//         
//         $filename = 'ourcodeworld_pdf_demo';
//         
//         $pdf->writeHTMLCell($w = 0, $h = 0, $x = '', $y = '', $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = '', $autopadding = true);
//         $pdf->Output($filename.".pdf",'I'); // This will output the PDF as a response directly
	// }
	
	public function testpdfAction()
	{
		$title_page = 'Bon de commande';
        $pdf = $this->get("white_october.tcpdf")->create();
        $html = $this->renderView('BaclooCrmBundle:Crm:testpdf.html.twig', array('texte' => 'test',
																			'texte2' => 'texte plus long pour tester',
																		'texte3' => 'texte3'));
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('Nicola Asuni');
		$pdf->SetTitle('TCPDF Example 003');
		$pdf->SetSubject('TCPDF Tutorial');
		$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

		// set default header data
		$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

		// set header and footer fonts
		$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

		// set default monospaced font
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

		// set margins
		$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

		// set auto page breaks
		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

		// set image scale factor
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

		// set some language-dependent strings (optional)
		if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
			require_once(dirname(__FILE__).'/lang/eng.php');
			$pdf->setLanguageArray($l);
		}

		// ---------------------------------------------------------

		// set font
		$pdf->SetFont('helvetica', '', 11, '', true);

        $pdf->AddPage();
        $pdf->writeHTML($html, true, false, true, false, '');
        $pdf->lastPage();
 
        $response = new Response($pdf->Output('file.pdf'));
        $response->headers->set('Content-Type', 'application/pdf');
 
        return $response;	
	}
	
	public function ajouterlocationpdfAction($ficheid, $locid, $mode, Request $request)
	{
		$objUser = $this->get('security.context')->getToken()->getUsername(); if(empty($objUser) or !isset($objUser) or $objUser == 'anon.'){return $this->redirect($this->generateUrl('fos_user_security_login'));}
		// if ($this->container->has('profiler'))
		// {
			// $this->container->get('profiler')->disable();
		// }
		$today = date('Y-m-d');
		$erreur = 0;
		$em = $this->getDoctrine()->getManager();//echo 'locid'.$locid;
					   
		$client  = $em->getRepository('BaclooCrmBundle:Fiche')		
					   ->findOneById($ficheid);			
		// On crée un objet Locata
		if($locid == 0)
		{		
			$locata = new Locata;
			$contrat = 0;
			$bdcrecu = 0;
			$montantcarb = 0;
		}
		else
		{
			$locata  = $em->getRepository('BaclooCrmBundle:Locata')		
						   ->findOneById($locid);
			if($client->getAssurance() == 1 && $locata->getAssurance() == 0)
			{
				$locata->setAssurance(0);
				$em->persist($locata);
				$em->flush();
			}
			
			$contrat = $locata->getContrat();
			$bdcrecu = $locata->getBdcrecu();
		}
		$userdetails  = $em->getRepository('BaclooUserBundle:User')		
					   ->findOneByUsername($objUser);			
		$userid = $userdetails->getId();
		$form = $this->createForm(new LocataType(), $locata);

		$objUser = $this->get('security.context')->getToken()->getUsername(); if(empty($objUser) or !isset($objUser) or $objUser == 'anon.'){return $this->redirect($this->generateUrl('fos_user_security_login'));}
		$today = date('Y-m-d');
		include('societe.php');

		//On met les locations dans un array pour controle ultérieur
		// $listeloc = array();
		// foreach ($locata->getLocations() as $loc) {
		  // $listeloc[] = $loc;
		// }		
		
		$em = $this->getDoctrine()->getManager();
		$modules  = $em->getRepository('BaclooCrmBundle:Modules')		
					   ->findOneByUsername($objUser);
	
		// On récupère la requête
		$request = $this->get('request');
		// On vérifie qu'elle est de type POST
		$listedispos = array();
		if($locid > 0)
		{//echo 'laaa';
			// $dstart = new \DateTime($locata->getDebutloc());
			// $dend = new \DateTime($locata->getFinloc());
			$listedispos = array();
			$listecodes = array();
			$totalht = 0;//echo $locid;
			$totaltrspaller = 0;
			$totaltrspretour = 0;			
			$montantcarb = 0;
			$contributionverte = 0;
			$assurance = 0;
			
			//Calcul total ht loc parc
			foreach($locata->getLocations() as $loca)
			{
				$dstart = $loca->getDebutloc();
				$dend = $loca->getFinloc();
				$dstartok = date('Y-m-d', strtotime($dstart . ' -1 day'));
				$dendok = date('Y-m-d', strtotime($dend . ' +1 day'));				
				$codemachine = $loca->getCodemachine();
				$dispos = $em->getRepository('BaclooCrmBundle:Machines')
						->dispos($codemachine, $dstartok, $dendok);
				// print_r($dispos);echo $codemachine;
				$i = 0;				
				foreach($dispos as $disp)
				{//echo 'AAA'.($disp['code']).'AAA';
					$dispo = $em->getRepository('BaclooCrmBundle:Machines')
							->dispoprecise($disp['code'], $dstart, $dend);
							// print_r($dispo);
					if(!empty($dispo)){$i = $i + 1;}
				}
				$listedispos[$codemachine]= count($dispos) - $i;		


			//FACTURATION
				$dStart = $loca->getDebutloc();
				$dEnd = $loca->getFinloc();
				
			//1.Récupérer les données de la table Machines
				   
			//2.On génère les entêtes de colonnes à partir de la fonction createplanning
				$iStart = strtotime ($dStart);//Formate une date/heure locale avec la Something is wronguration locale
				$iEnd = strtotime ($dEnd);
				if (false === $iStart || false === $iEnd) {
					return false;
				}
				$aStart = explode ('-', $dStart);
				$aEnd = explode ('-', $dEnd);
				if (count ($aStart) !== 3 || count ($aEnd) !== 3) {
					return false;
				}
				if (false === checkdate ($aStart[1], $aStart[2], $aStart[0]) || false === checkdate ($aEnd[1], $aEnd[2], $aEnd[0]) || $iEnd <= $iStart) {
					// return false;
				}
				$aDates = array();
				for ($i = $iStart; $i < $iEnd + 86400; $i = strtotime ('+1 day', $i) ) {
					$sDateToArr = strftime ('%Y-%m-%d', $i);
					$sYear = substr ($sDateToArr, 0, 4);
					$sMonth = substr ($sDateToArr, 5, 2);
					$aDates[] = $sDateToArr;
				}
			//on calcule le nombre de jours de location
				$nbjloc = 0;
							foreach($aDates as $dat)
							{						
								$time = strtotime($dat);
								
								//Facturation WE ou pas
								$newformat = date('D',$time);
										if($locata->getFacturersamedi() == 1 && $newformat == 'Sat')
										{
											$nbjloc++;
										}
										elseif($locata->getFacturerdimanche() == 1 && $newformat == 'Sun')
										{
											$nbjloc++;
										}
										elseif($newformat == 'Sat' or $newformat == 'Sun')
										{}
										else
										{
											$nbjloc++;
										}$i++;
							}
				// echo 'xx'.$nbjloc.'xx';
				// echo 'hh'.$i.'hh';
				
				//Création du montant HT ligne par ligne
				

					$grille  = $em->getRepository('BaclooCrmBundle:Grille')		
								   ->findByCodeclient($locata->getClientid());
							
						if(null !== $loca->getLoyerp1())
						{
							$totalht += $nbjloc * $loca->getLoyerp1();
							$totalhtloc = $nbjloc * $loca->getLoyerp1();
							$loyer = $loca->getLoyerp1();
						}
						elseif(null !== $loca->getLoyerp2())
						{
							$totalht += $nbjloc * $loca->getLoyerp2();
							$totalhtloc = $nbjloc * $loca->getLoyerp2();
							$loyer = $loca->getLoyerp2();
						}
						elseif(null !== $loca->getLoyerp3())
						{
							$totalht += $nbjloc * $loca->getLoyerp3();
							$totalhtloc = $nbjloc * $loca->getLoyerp3();
							$loyer = $loca->getLoyerp3();
						}
						elseif(null !== $loca->getLoyerp4())
						{
							$totalht += $loca->getLoyerp4();
							$totalhtloc = $loca->getLoyerp4();
							$loyer = $loca->getLoyerp4();
						}
						elseif(null !== $loca->getLoyermensuel())
						{
							include('calculnbjlocamensuelle.php');							
							$loyer = $loca->getLoyermensuel()/20;
							$totalht += $loyer * $nbjloc;
							$totalhtloc = $loyer * $nbjloc;
						}
						if(null !== $loca->getMontantcarb() && $loca->getMontantcarb()>0)
						{
							$montantcarb += $loca->getLitrescarb()*1.97;
						}
						
						$totaltrspaller += $loca->getTransportaller();
						$totaltrspretour += $loca->getTransportretour();
						
						if($loca->getContributionverte() == 1)
						{
							$contributionverte += 0.0215 * $loyer * $nbjloc;
						}
						
						if($loca->getAssurance() == 1)
						{
							$assurance += $totalhtloc*0.10;
						}

			}	
			
			//Calcul totalht Sous loc
			foreach($locata->getLocationssl() as $loca)
			{
				$dstart = $loca->getDebutloc();
				$dend = $loca->getFinloc();
				$dstartok = date('Y-m-d', strtotime($dstart . ' -1 day'));
				$dendok = date('Y-m-d', strtotime($dend . ' +1 day'));				
				$codemachine = $loca->getCodemachine();
				$dispos = $em->getRepository('BaclooCrmBundle:Machinessl')
						->dispos($codemachine, $dstartok, $dendok, $loca->getLoueur());
				// print_r($dispos);echo $codemachine;
				$i = 0;				
				foreach($dispos as $disp)
				{//echo 'AAA'.($disp['code']).'AAA';
					$dispo = $em->getRepository('BaclooCrmBundle:Machinessl')
							->dispoprecise($disp['code'], $dstart, $dend, $loca->getLoueur());
							// print_r($dispo);
					if(!empty($dispo)){$i = $i + 1;}
				}
				$listedispos[$codemachine]= count($dispos) - $i;		


			//FACTURATION
				$dStart = $loca->getDebutloc();
				$dEnd = $loca->getFinloc();
				
			//1.Récupérer les données de la table Machines
				   
			//2.On génère les entêtes de colonnes à partir de la fonction createplanning
				$iStart = strtotime ($dStart);//Formate une date/heure locale avec la Something is wronguration locale
				$iEnd = strtotime ($dEnd);
				if (false === $iStart || false === $iEnd) {
					return false;
				}
				$aStart = explode ('-', $dStart);
				$aEnd = explode ('-', $dEnd);
				if (count ($aStart) !== 3 || count ($aEnd) !== 3) {
					return false;
				}
				if (false === checkdate ($aStart[1], $aStart[2], $aStart[0]) || false === checkdate ($aEnd[1], $aEnd[2], $aEnd[0]) || $iEnd <= $iStart) {
					// return false;
				}
				$aDates = array();
				for ($i = $iStart; $i < $iEnd + 86400; $i = strtotime ('+1 day', $i) ) {
					$sDateToArr = strftime ('%Y-%m-%d', $i);
					$sYear = substr ($sDateToArr, 0, 4);
					$sMonth = substr ($sDateToArr, 5, 2);
					$aDates[] = $sDateToArr;
				}
			//on calcule le nombre de jours de location
				$nbjloc = 0;
							foreach($aDates as $dat)
							{						
								$time = strtotime($dat);
								
								//Facturation WE ou pas
										$newformat = date('D',$time);
										if($locata->getFacturersamedi() == 1 && $newformat == 'Sat')
										{
											$nbjloc++;
										}
										elseif($locata->getFacturerdimanche() == 1 && $newformat == 'Sun')
										{
											$nbjloc++;
										}
										elseif($newformat == 'Sat' or $newformat == 'Sun')
										{}
										else
										{
											$nbjloc++;
										}$i++;
							}
				// echo 'xx'.$nbjloc.'xx';
				// echo 'hh'.$i.'hh';
				
				//Création du montant HT ligne par ligne
				

					$grille  = $em->getRepository('BaclooCrmBundle:Grille')		
								   ->findByCodeclient($locata->getClientid());
							
						if(null !== $loca->getLoyerp1())
						{
							$totalht += $nbjloc * $loca->getLoyerp1();
							$totalhtloc = $nbjloc * $loca->getLoyerp1();
							$loyer = $loca->getLoyerp1();
						}
						elseif(null !== $loca->getLoyerp2())
						{
							$totalht += $nbjloc * $loca->getLoyerp2();
							$totalhtloc = $nbjloc * $loca->getLoyerp2();
							$loyer = $loca->getLoyerp2();
						}
						elseif(null !== $loca->getLoyerp3())
						{
							$totalht += $nbjloc * $loca->getLoyerp3();
							$totalhtloc = $nbjloc * $loca->getLoyerp3();
							$loyer = $loca->getLoyerp3();
						}
						elseif(null !== $loca->getLoyerp4())
						{
							$totalht += $nbjloc * $loca->getLoyerp4();
							$totalhtloc = $nbjloc * $loca->getLoyerp4();
							$loyer = $loca->getLoyerp4();
						}
						elseif(null !== $loca->getLoyermensuel())
						{
							include('calculnbjlocamensuelle.php');							
							$loyer = $loca->getLoyermensuel()/20;
							$totalht += $loyer * $nbjloc;
							$totalhtloc = $loyer * $nbjloc;							
						}
						
						if(null !== $loca->getMontantcarb() && $loca->getMontantcarb()>0)
						{
							$montantcarb += $loca->getLitrescarb()*1.97;
						}
						
						$totaltrspaller += $loca->getTransportaller();
						$totaltrspretour += $loca->getTransportretour();
						
						if($loca->getContributionverte() == 1)
						{
							$contributionverte += 0.0215 * $loyer * $nbjloc;
						}
						
						if($loca->getAssurance() == 1)
						{
							$assurance += $totalhtloc*0.10;
						}
		
			}			

			$montantvente = 0;			
			$totalvente = 0;			
			foreach($locata->getLocataventes() as $ven)
			{
				$montantvente = $ven->getQuantite() * $ven->getPu();
				$totalvente += $ven->getQuantite() * $ven->getPu();
				// $em->flush();
			}

			
			// if($locata->getRemise() > 0)
			// {
				// $totalht = $totalht - ($totalht * $locata->getRemise()/100);
			// }
				
	
			//FIN FACTURATION	
	
		}
		else
		{//echo 'ici';
			$totalht = 0;
			$nbjloc = 0;
			$nbjlocass = 0;
			$totalvente = 0;
			$grille = array();

		}
		
		$machines  = $em->getRepository('BaclooCrmBundle:Machines')		
					   ->findAll();		
		$machinessl  = $em->getRepository('BaclooCrmBundle:Machinessl')		
					   ->findAll();	

		$userdetails  = $em->getRepository('BaclooUserBundle:User')		
					   ->findOneByUsername($objUser);
		$roleuser = $userdetails->getRoleuser();		

		if(empty($nbjloc))
		{
						$totalht = 0;
						$nbjloc = 0;
						$nbjlocass = 0;
						$totalvente = 0;
						$erreur = 3;
						$grille = array();


		}			

		$pdf = $this->get("white_october.tcpdf")->create();
		if($mode == 'bdl')
		{
			$html = $this->renderView('BaclooCrmBundle:Crm:bdl.html.twig', array('form' => $form->createView(),
																				'mode' => $mode,
																				'date' => $today,
																				'roleuser' => $roleuser,
																				'client' => $client,
																				'locata' => $locata,
																				'contrat' => $contrat,
																				'bdcrecu' => $bdcrecu,
																				'usersociete' => $societe,
																				'modules' => $modules,
																				'machines' => $machines,
																				'machinessl' => $machinessl,
																				'listedispos' => $listedispos,
																				'entreprise' => $client->getRaisonSociale(),
																				'id' => $ficheid,
																				'erreur' => $erreur,
																				'locid' => $locid,
																				'totalht' => $totalht,
																				'montantcarb' => $montantcarb,
																				'totalvente' => $totalvente,
																				'nbjloc' => $nbjloc,
																				'grille' => $grille,
																				'user' => $objUser));
		}
		else
		{
			$html = $this->renderView('BaclooCrmBundle:Crm:nouvelle_locationpdf.html.twig', array('form' => $form->createView(),
																				'mode' => $mode,
																				'date' => $today,
																				'roleuser' => $roleuser,
																				'client' => $client,
																				'locata' => $locata,
																				'contrat' => $contrat,
																				'bdcrecu' => $bdcrecu,
																				'usersociete' => $societe,
																				'modules' => $modules,
																				'machines' => $machines,
																				'machinessl' => $machinessl,
																				'listedispos' => $listedispos,
																				'entreprise' => $client->getRaisonSociale(),
																				'id' => $ficheid,
																				'erreur' => $erreur,
																				'locid' => $locid,
																				'totalht' => $totalht,
																				'montantcarb' => $montantcarb,
																				'totalvente' => $totalvente,
																				'nbjloc' => $nbjloc,
																				'grille' => $grille,
																				'user' => $objUser));
		}
		$pdf->SetFont('helvetica', '', 9, '', true);
		// set margins
		$pdf->SetMargins(13, '10', '5', '0');
		// SetMargins($left,$top,$right = -1,$keepmargins = false)
        $pdf->AddPage();
		
		// -- set new background ---

		// get the current page break margin
		$bMargin = $pdf->getBreakMargin();
		// get current auto-page-break mode
		$auto_page_break = $pdf->getAutoPageBreak();
		// disable auto-page-break
		$pdf->SetAutoPageBreak(false, 0);
		// set bacground image
		$img_file = K_PATH_IMAGES.'devistemplate.jpg';
		$pdf->Image($img_file, 0, 0, 210, 297, 'JPG', '', '', false, 300, '', false, false, 0);
		// restore auto-page-break status
		$pdf->SetAutoPageBreak($auto_page_break, $bMargin);
		// set the starting point for the page content
		$pdf->setPageMark();		
		
        $pdf->writeHTML($html, true, false, true, false, '');
		
        $pdf->lastPage();
 
        $response = new Response($pdf->Output('file.pdf'));
        $response->headers->set('Content-Type', 'application/pdf');
 
        return $response;
	}
	
	public function comptaAction($vue, $mode, $page, $message, $date, $nbresult, Request $request)
	{
		$user = $this->get('security.context')->getToken()->getUsername(); 
		$objUser = $user;
		if(empty($objUser) or !isset($objUser) or $objUser == 'anon.'){return $this->redirect($this->generateUrl('fos_user_security_login'));}

		if($this->getRequest()->request->get('pagination') > 0)
		{
			$page = $this->getRequest()->request->get('pagination');
			// echo 'la page2'.$page;
		}		
// $date = '2019-08-14';
// echo $date;
// echo date('Y-m-t', strtotime($date));		
		$em = $this->getDoctrine()->getManager();
		$userdetails  = $em->getRepository('BaclooUserBundle:User')		
					   ->findOneByUsername($objUser);			
		$nbparpage = 30;
		$today = date('Y-m-d');
		// $session = new Session();		
		// $session = $request->getSession();
		// $session->set('page', $page);
		// $page = $session->get('page');
// $date = strtotime(date('Y-m-01'));
// $d15 = strtotime('+14 days',$date);
// echo date('Y-m-d', $d15);*
// $mois15 = strtotime(date('Y-m-01', strtotime(" -1 month")));
// $m15 = strtotime('+14 days',$mois15);
// echo date('Y-m-d', $m15);		
			
		//création du formlaire de recherche de factures
		$defaultData = array();
		$form2 = $this->createFormBuilder($defaultData)
			->add('du', 'date', array('widget' => 'single_text',
										'input' => 'string',
										'format' => 'dd/MM/yyyy',
										'required' => false,
										'attr' => array('class' => 'date'),
										))
			->add('au', 'date', array('widget' => 'single_text',
										'input' => 'string',
										'format' => 'dd/MM/yyyy',
										'required' => false,
										'attr' => array('class' => 'date'),
										))
			->add('numfacture', 'text', array('required' => false))
			// ->add('clientid', 'text', array('required' => false))
			// ->add('typedoc', 'choice', array(
					// 'choices'   => array(
						// 'facture'   => 'Facture',
					// ),
					// 'multiple'  => false,
				// ))
			->add('client', 'text', array('required' => false))
			->add('totalttc', 'number', array('required' => false))
			->add('ttcgroupe', 'number', array('required' => false))
			->add('daterech', 'date', array('widget' => 'single_text',
										'input' => 'string',
										'format' => 'dd/MM/yyyy',
										'required' => false,
										'read_only' => false,
										'attr' => array('class' => 'daterech'),
										))
			->add('dejareg', 'number', array('required' => false))
            ->add('modepaiement', 'choice', array(
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
            // ->add('reglement', 'choice', array(
					// 'choices'   => array(
						// 0   => '',
						// 1   => 'Comptant',
						// 2   => '45 jours fdm',
					// ),
					// 'data' => 2,
					// 'multiple'  => false,
				// ))
			->getForm();
	if($request->getMethod() == 'POST')
	{//echo 'post'; echo $this->getRequest()->request->get('envoyer');
		if ($this->getRequest()->request->get('recherche') == 'Rechercher')
		{//echo 'recherche';
			$form2->handleRequest($request);
			// if($form2->isValid()){echo 'ttttttt';
				$data = $form2->getData();	
				$du = $data['du'];
				$au = $data['au'];
				$daterech = $data['daterech'];
				$dejareg = $data['dejareg'];
				// $clientid = $data['clientid'];
				$client = $data['client'];//echo 'CLIENT'.$client;
				$numfacture = $data['numfacture'];//echo 'CLIENT'.$client;
				$totalttc1 = $data['totalttc'];//echo 'CLIENT'.$client;
				$ttcgroupe1 = $data['ttcgroupe'];//echo 'CLIENT'.$client;
				$modepaiement = $data['modepaiement'];//echo 'CLIENT'.$client;
				// $reglement = $data['reglement'];
				// $typedoc = $data['typedoc'];
				// $datecrea = $data['datecrea'];
				$session = new Session();
				$session = $request->getSession();

				// définit et récupère des attributs de session
				$session->set('du', $du);
				$session->set('au', $au);				
				$session->set('client', $client);				
				$session->set('numfacture', $numfacture);				
				$session->set('totalttc', $totalttc1);				
				$session->set('ttcgroupe', $ttcgroupe1);				
				$session->set('modepaiement', $modepaiement);				
				$session->set('daterech', $daterech);				
				$session->set('dejareg', $dejareg);				
			// }
		}
		elseif ($this->getRequest()->request->get('maj') == 'Enregistrer')
		{//echo 'maj';
		
		}
	}
			$session = $request->getSession();
			if(null !== $session->get('du'))
			{
				$du = $session->get('du');
			}
			if(null !== $session->get('au'))
			{
				$au = $session->get('au');
			}
			if(null !== $session->get('client'))
			{
				$client = $session->get('client');
			}
			if(null !== $session->get('numfacture'))
			{
				$numfacture = $session->get('numfacture');
			}
			if(null !== $session->get('totalttc'))
			{
				$totalttc = $session->get('totalttc');
			}
			if(null !== $session->get('ttcgroupe'))
			{
				$ttcgroupe = $session->get('ttcgroupe');
			}
			if(null !== $session->get('modepaiement'))
			{
				$modepaiement = $session->get('modepaiement');
			}
			if(null !== $session->get('dejareg'))
			{
				$dejareg = $session->get('dejareg');
			}
			if(null !== $session->get('daterech'))
			{
				$daterech = $session->get('daterech');
			}
	// echo 'la sessin daterech'.$session->get('daterech');
		
		if(!isset($du))
		{
			$du = 0;
		}		
		if(!isset($au))
		{
			$au = 0;
		}		
		if(!isset($clientid))
		{
			$clientid = 0;
		}		
		if(!isset($client))
		{
			$client = 0;
		}		
		if(!isset($reglement))
		{
			$reglement = 0;
		}
		elseif($reglement == 666)
		{
			$reglement = 0;
		}	
		if(!isset($typedoc))
		{
			$typedoc = 0;
		}	
		if(!isset($numfacture))
		{
			$numfacture = 0;
		}		
		if(!isset($datecrea))
		{
			$datecrea = 0;
		}		
		if(!isset($totalttc))
		{
			$totalttc = 0;
		}		
		if(!isset($ttcgroupe))
		{
			$ttcgroupe = 0;
		}		
		if(!isset($modepaiement))
		{
			$modepaiement = 0;
		}		
		if(!isset($daterech))
		{
		// echo 'datrech00000'.$daterech;
			$daterech = 0;
		}
		else
		{
			// echo 'datechoookkkkXXXXXXX'.$daterech;
		}		
		if(!isset($dejareg))
		{
			$dejareg = 0;
		}
		// echo 'aaaaaaaaaaaa'.$dejareg;
// echo 'lala';
// echo 'MOOOODE'.$mode;echo 'CLIENNNN'.$client;echo 'NUmfacture'.$numfacture;echo 'modepaiement'.$modepaiement;echo 'TOTALTTC'.$totalttc;
	$em = $this->getDoctrine()
			   ->getManager()
			   ->getRepository('BaclooCrmBundle:Factures');
	$facture = $em->listefactures($vue, $mode, $numfacture, $client, $totalttc, $ttcgroupe, $modepaiement, $nbparpage, $page, $daterech, $dejareg);				
// if(isset($facture)){echo 'plein';}else{echo 'pas plein';}
// var_dump($facture);
	// foreach($facture as $fact)
	// {
		// echo 'dada';
		// echo $fact->getNumfacture();
	// }
		
		$em = $this->getDoctrine()->getManager();
		$query = $em->createQuery(
			'SELECT u.codegroupe
			FROM BaclooCrmBundle:Factures u
			WHERE u.codegroupe >= :codegroupe
			AND u.typedoc = :typedoc
			ORDER BY u.codegroupe DESC'
		)->setParameter('codegroupe', 0)
		->setParameter('typedoc', 'facture')
		->setMaxResults(1);
		$codeg = $query->getSingleScalarResult();
		// echo 'nextcode'.$codeg;
		$nextcodegroupe = $codeg + 1;
		// echo 'nextcodegroupe'.$nextcodegroupe;
		
		$moisprecedent = date('m', strtotime(" -1 month"));
		$findumois = date('Y-m-t');
		// echo '-5'.date('Y-m-d', strtotime($findumois. '-5 days'));
		if(strtotime(date('Y-m-d')) >= strtotime(date('Y-m-d', strtotime($findumois. '-5 days'))) && strtotime(date('Y-m-d')) <= strtotime(date('Y-m-t')))
		{
			$show = 1;
		}
		else
		{
			$show = 0;
		}
		
		// $em->clear();

			$moisprecedent = date('m', strtotime(" -1 month"));

			// echo 'bb'.$reglement.'bb';
			// echo $mode;
		$em = $this->getDoctrine()->getManager();				   
		$ttesfacturesimpayees  = $em->getRepository('BaclooCrmBundle:Factures')		
					   ->ttesfacturesimpayees();
					   
		$ttesfacturesimpayeesnonechues  = $em->getRepository('BaclooCrmBundle:Factures')		
					   ->ttesfacturesimpayeesnonechues();
					   
		$ttesfacturesechues  = $em->getRepository('BaclooCrmBundle:Factures')		
					   ->ttesfacturesechues();			
			
		if($vue == 'achats')
		{		
			return $this->render('BaclooCrmBundle:Crm:comptaachats.html.twig', array('factures' => $facture,
																		'form2' => $form2->createView(),
																		'user' => $user,
																		'userdetails' => $userdetails,
																		'mode' => $mode,
																		'vue' => $vue,
																		'message' => $message,
																		'date' => $date,
																		'du' => $du,
																		'au' => $au,
																		'show' => $show,
																		// 'clientid' => $clientid,
																		'client' => $client,
																		// 'reglement' => $reglement,
																		'typedoc' => $typedoc,
																		'numfacture' => $numfacture,
																		'totalttc' => $totalttc,
																		'ttcgroupe' => $ttcgroupe,
																		'modepaiement' => $modepaiement,
																		'datecrea' => $datecrea,
																		'moisprecedent' => $moisprecedent,
																		'ttesfacturesimpayees' => $ttesfacturesimpayees,
																		'ttesfacturesimpayeesnonechues' => $ttesfacturesimpayeesnonechues,
																		'ttesfacturesechues' => $ttesfacturesechues,
																		'nextcodegroupe' => $nextcodegroupe,
																		'dejareg' => $dejareg,
																		'daterech' => $daterech,
																		'nombrePage' => ceil(count($facture)/$nbparpage),
																		'page'	  	  => $page
																		));	
		}
		else
		{		
			return $this->render('BaclooCrmBundle:Crm:compta.html.twig', array('factures' => $facture,
																		'form2' => $form2->createView(),
																		'user' => $user,
																		'userdetails' => $userdetails,
																		'mode' => $mode,
																		'vue' => $vue,
																		'message' => $message,
																		'date' => $date,
																		'du' => $du,
																		'au' => $au,
																		'show' => $show,
																		// 'clientid' => $clientid,
																		'client' => $client,
																		// 'reglement' => $reglement,
																		'typedoc' => $typedoc,
																		'numfacture' => $numfacture,
																		'totalttc' => $totalttc,
																		'ttcgroupe' => $ttcgroupe,
																		'modepaiement' => $modepaiement,
																		'datecrea' => $datecrea,
																		'moisprecedent' => $moisprecedent,
																		'ttesfacturesimpayees' => $ttesfacturesimpayees,
																		'ttesfacturesimpayeesnonechues' => $ttesfacturesimpayeesnonechues,
																		'ttesfacturesechues' => $ttesfacturesechues,
																		'nextcodegroupe' => $nextcodegroupe,
																		'dejareg' => $dejareg,
																		'daterech' => $daterech,
																		'nombrePage' => ceil(count($facture)/$nbparpage),
																		'page'	  	  => $page
																		));	
		}
	}
	
	public function comptadefAction($numfacture, $mode, $page, $doc, Request $request)
	{//echo 'isi';
		$em = $this->getDoctrine()->getManager();
		$facture = $em->getRepository('BaclooCrmBundle:Factures')
						->findOneByNumfacture($numfacture);
						
		$codecontrat = $facture->getLocatacloneid();
		$clientid = $facture->getClientid();
		echo ' CODeCONtrAtX';echo $facture->getCodelocata();echo $facture->getLocatacloneid();			
		$locata = $em->getRepository('BaclooCrmBundle:Locataclone')		
		   ->findOneById($codecontrat);
			   
		$venda = $em->getRepository('BaclooCrmBundle:Venda')		
		   ->findOneById($codecontrat);	
		   
		$typeachat = 'nok';
		if($facture->getCodelocata() == 'H-'.$facture->getLocatacloneid())
		{
			$locatafrs = $em->getRepository('BaclooCrmBundle:Locatafrs')		
			   ->findOneById($codecontrat);
			$typeachat = 'normal';
		}
		else
		{
			$locatafrs = $em->getRepository('BaclooCrmBundle:Locatafrsclone')		
			   ->findOneById($codecontrat);
			$typeachat = 'sousloc';
		}
		 // echo 'codecontrat'.$codecontrat;
		   
		$machines = $em->getRepository('BaclooCrmBundle:Machines')		
		   ->findAll();
		   
		$machinessl = $em->getRepository('BaclooCrmBundle:Machinessl')		
		   ->findAll();	   

		// $facture  = $em->getRepository('BaclooCrmBundle:Factures')		
		   // ->findOneByNumfacture($numfacture);
	
		$clients  = $em->getRepository('BaclooCrmBundle:Fiche')		
		   ->findOneById($clientid);
//echo 'ttttt';echo $this->getRequest()->request->get('definitif');				
		
		include('facturationmensuelledefinitive.php');
		$facture->setSelection(0);
		$em->flush();
			
		if($doc == 'locations' or $doc == 'ventes')
		{			
			return $this->redirect($this->generateUrl('bacloocrm_compta', array('vue' => 'locations', 'page' => $page, 'mode' => $mode)));			
		}
		elseif($doc == 'achats')
		{
			return $this->redirect($this->generateUrl('bacloocrm_compta', array('vue' => 'achats', 'page' => $page, 'mode' => $mode)));			
		}
		else
		{
			return $this->redirect($this->generateUrl('bacloocrm_compta', array('vue' => 'locations', 'page' => $page, 'mode' => $mode)));				
		}
	}	

	public function facturestableauAction($facture, $page, $mode, $numfacture, $modepaiement, $totalttc, $client, $vue, Request $request)
	{//echo 'lavue'.$vue;
		$objUser = $this->get('security.context')->getToken()->getUsername();
		$today = date('Y-m-d');
		$em = $this->getDoctrine()->getManager();
		$userdetails  = $em->getRepository('BaclooUserBundle:User')
					   ->findOneByUsername($objUser);
					   
		//création du formlaire dans la liste des articles
		$defaultData2 = array();
		
		$form = $this->createFormBuilder($defaultData2)
		->add('numfacture', 'text', array('required' => false))
		->add('numfacfrs', 'text', array('required' => false))
		->add('echeance', 'date', array('widget' => 'single_text',
									'input' => 'string',
									'format' => 'dd/MM/yyyy',
									'required' => false,
									'read_only' => false,
									'attr' => array('class' => 'echeance'),
									))
		->add('datecrea', 'date', array('widget' => 'single_text',
									'input' => 'string',
									'format' => 'dd/MM/yyyy',
									'required' => false,
									'read_only' => false,
									'attr' => array('class' => 'datecrea'),
									))
		->add('reglement', 'checkbox', array('required' => false))
		->add('montantreg', 'number', array('required' => false))
		->add('datepaiement', 'date', array('widget' => 'single_text',
									'input' => 'string',
									'format' => 'dd/MM/yyyy',
									'required' => false,
									'read_only' => false,
									'attr' => array('class' => 'datepaiement'),
									))
		->add('modepaiement', 'choice', array(
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
        ->add('commentaire','textarea', array('required' => false))
		->add('montantdejareg', 'number', array('required' => false))
		->add('encaisse', 'choice', array(
			'choices'   => array(
				'pas encaisse'   => 'Pas encaissé',
				'encaisse'   => 'Encaissé',
			),
			'multiple'  => false,
			))
		->add('codegroupe', 'integer', array('required' => false))
		->add('ttcgroupe', 'number', array('required' => false))
		->getForm();	
		
		if($request->getMethod() == 'POST')
		{
			$form->handleRequest($request);
			$data = $form->getData();
			$datecrea = $data['datecrea'];
			$echeance = $data['echeance'];
			$numfacture = $data['numfacture'];
			$numfacfrs = $data['numfacfrs'];
			$reglement = $data['reglement'];
			$montantreg = $data['montantreg'];
			$datepaiement = $data['datepaiement'];
			$modepaiement = $data['modepaiement'];
			$montantdejareg = $data['montantdejareg'];
			$commentaire = $data['commentaire'];
			$encaisse = $data['encaisse'];
			$codegroupe = $data['codegroupe'];
			// if($form->isValid()){echo '+++++';
echo 'NUMFACT';echo $numfacture;echo $montantreg;
			$facture = $em->getRepository('BaclooCrmBundle:Factures')
							->findOneByNumfacture($numfacture);
			$client = $em->getRepository('BaclooCrmBundle:Fiche')
							->findOneById($facture->getClientid());
				//Passer directement l'écriture de réglement ici afin de solder le compte client
				//et créditer le compte banque
			if($montantdejareg == $facture->getTotalttc() + $facture->getMontantavoir()){$reglement = 1;}else{$reglement = 0;}
			// $facture->setReglement($reglement);
			$facture->setMontantreg(0);
			$facture->setNumfacfrs($numfacfrs);
			$facture->setDatecrea($datecrea);
			$facture->setEcheance($echeance);
			$facture->setDatepaiement($datepaiement);
			$facture->setModepaiement($modepaiement);
			$facture->setCommentaire($commentaire);
			$facture->setEncaisse($encaisse);
			$facture->setMontantdejareg($montantdejareg+$montantreg);
			$facture->setCodegroupe($codegroupe);
			$facture->setTtcgroupe($montantdejareg+$montantreg);
			$em->persist($facture);
			$em->flush();			
										
			$facturesgroupe = $em->getRepository('BaclooCrmBundle:Factures')
							->findByCodegroupe($codegroupe);
			
			$ttcgroupe = 0;			
			foreach($facturesgroupe as $factagroupe)
			{
				//un premier tour pour remplir ttcgroupe
				$ttcgroupe += $factagroupe->getMontantdejareg();
			}
						
			foreach($facturesgroupe as $factagroupe)
			{
				//un deuxième tour pour remplir le ttcgroupe de chaque membre
				$factagroupe->setTtcgroupe($ttcgroupe);
				$em->persist($factagroupe);
			}
			$em->flush();

			//echo '1';echo $fac->getNumfacture();
				//Avant de passer l'écriture on vérifie qua ça n'a pas déjà été fait

				// $facture->setMontantdejareg($totalreg + $facture->getMontantreg());echo 'totalreg'.$totalreg;

				if($facture->getMontantdejareg() > 0 and round(($facture->getMontantdejareg() + $facture->getMontantavoir()),2) == $facture->getTotalttc())
				{echo '22222';
					if($facture->getModepaiement() == 'cheque' or $facture->getModepaiement() == 'lcr' and $facture->getEncaisse() == 'encaisse' )
					{	
						$facture->setReglement(1);
					}
					elseif($facture->getModepaiement() != 'cheque' or $facture->getModepaiement() != 'lcr')
					{
						$facture->setReglement(1);
					}
					if($facture->getTypedoc() == 'facture')
					{//echo '3';						
						//On enregistre un paiement par virement
						//On crédite 512
						$banque = new Afacturer;
						$banque->setDate($today);
						$banque->setJournal('VT');
						$banque->setCompte(512);
						$banque->setDebit($montantreg);			
						$banque->setCredit(0);			
						$banque->setLibelle($facture->getClient());			
						$banque->setPiece($numfacture);			
						$banque->setEcheance($facture->getEcheance());		
						$banque->setAnalytique('Reglement client');
						$em->persist($banque);
						$em->flush();						

						$compteclient = $client->getid();
						//On débit le bon 411
						$clientok = new Afacturer;
						$clientok->setDate($today);
						$clientok->setJournal('VT');
						$clientok->setCompte($compteclient);
						$clientok->setDebit(0);			
						$clientok->setCredit($montantreg);			
						$clientok->setLibelle($facture->getClient());			
						$clientok->setPiece($numfacture);			
						$clientok->setEcheance($facture->getEcheance());		
						$clientok->setAnalytique('Reglement client');
						$em->persist($clientok);							
						
						$facture->setMontantreg(0);
						$em->persist($facture);
						$em->flush();
						
					}
					elseif($facture->getTypedoc() == 'bon de commande')
					{//echo '4';
						$facture->setMontantdejareg($montantdejareg + $facture->getMontantreg());
						//On enregistre le paiement du fournisseur par virement
						//On debite 512
						$banque = new Afacturer;
						$banque->setDate($today);
						$banque->setJournal('ACH');
						$banque->setCompte(512);
						$banque->setDebit(0);			
						$banque->setCredit($montantreg);			
						$banque->setLibelle($facture->getClient());			
						$banque->setPiece($numfacture);			
						$banque->setEcheance($facture->getEcheance());		
						$banque->setAnalytique('Règlement fournisseur');
						$em->persist($banque);
						$em->flush();						

						$compteclient = '401'.$facture->getClientid();
						//On crédite le bon 401
						$clientok = new Afacturer;
						$clientok->setDate($today);
						$clientok->setJournal('ACH');
						$clientok->setCompte($compteclient);
						$clientok->setDebit($montantreg);			
						$clientok->setCredit(0);			
						$clientok->setLibelle($facture->getClient());			
						$clientok->setPiece($facture->getNumfacture());			
						$clientok->setEcheance($numfacture);		
						$clientok->setAnalytique('Règlement fournisseur');
						$em->persist($clientok);							
						
						$facturereglee->setMontantreg(0);
						$em->flush();							
					}
				}
				else
				{
					$facture->setReglement(0);
				}

			if($facture->getTypedoc() == 'avoir'){$facture->setReglement(1);}
			$em->persist($facture);	
			$em->flush();
			return $this->redirect($this->generateUrl('bacloocrm_compta', array('vue' => $vue, 'page' => $page, 'mode' => $mode)));	
		}
		if($vue == 'achats')
		{
			return $this->render('BaclooCrmBundle:Crm:compta_tableauachats.html.twig', array('form' => $form->createView(),
																		'facture' => $facture,
																		'userdetails' => $userdetails,
																		'page' => $page,
																		'vue' => $vue,
																		// 'search' => $search,
																		'mode' => $mode
																	));
		}
		else
		{	
			return $this->render('BaclooCrmBundle:Crm:compta_tableau.html.twig', array('form' => $form->createView(),
																		'facture' => $facture,
																		'userdetails' => $userdetails,
																		'page' => $page,
																		'vue' => $vue,
																		// 'search' => $search,
																		'mode' => $mode
																	));
		}
	}

	public function envoyerfactureAction($numfacture, $mode, $page, $relance, Request $request)
	{//echo 'isi';
		$em = $this->getDoctrine()->getManager();
		$facture = $em->getRepository('BaclooCrmBundle:Factures')
						->findOneByNumfacture($numfacture);
		$facturesechues = $em->getRepository('BaclooCrmBundle:Factures')
						->facturesechues($facture->getClientid());
						
		$codecontrat = $facture->getLocatacloneid();
		$clientid = $facture->getClientid();
			if($facture->getCodelocata() == 'V-'.$codecontrat)
			{
				$locata = $em->getRepository('BaclooCrmBundle:Venda')
				   ->findOneById($codecontrat);
				$type = 'vente';
			}
			elseif($facture->getCodelocata() == 'H-'.$codecontrat)
			{
				$locata = $em->getRepository('BaclooCrmBundle:Locatafrsclone')
				   ->findOneById($codecontrat);
				$type = 'achat';
			}
			else
			{
				$locata = $em->getRepository('BaclooCrmBundle:Locataclone')
				   ->findOneById($codecontrat);
				$type = 'loc';
			}
			 // echo 'codecontrat'.$codecontrat;

			if($mode == 'avoir')
			{
				$facturedor = $em->getRepository('BaclooCrmBundle:Factures')
					->findOneBy(array('locatacloneid' => $facture->getLocatacloneid(), 'typedoc' => 'facture', 'chantier' =>  $facture->getChantier()));
			}
			else
			{
				$facturedor = 0;
			}
// echo 'addresse1'; echo $clients->getAdresse1();
// echo '----'.$selection.'----';echo $facture->getClient();
			$clients  = $em->getRepository('BaclooCrmBundle:Fiche')
			   ->findOneById($clientid);
			foreach($clients->getBcontacts() as $contact)
			{
				// echo 'RECOIT';echo $contact->getRecoitfact();
				if($contact->getRecoitfact() == 1)
				{
					$facturesaimprimer[] = $locata;
					$client[] = $clients;
					// Récupération du service
					$pdf = $this->get("white_october.tcpdf")->create();
					if($relance == 0)
					{
						if($type == 'vente')
						{
							$html = $this->renderView('BaclooCrmBundle:Crm:impression_facturesventepdfmail.html.twig', array(
																						'locata' => $locata,
																						'mode' => 'facture',
																						'numfacture' => $numfacture,
																						'facture' => $facture,
																						'facturedor' => $facturedor,
																						'clients' => $client,
																						'type' => $type
																								));
						}
						else
						{
							$html = $this->renderView('BaclooCrmBundle:Crm:impression_facturespdfmail.html.twig', array(
																						'locata' => $locata,
																						'mode' => 'facture',
																						'numfacture' => $numfacture,
																						'facture' => $facture,
																						'facturedor' => $facturedor,
																						'clients' => $client,
																						'type' => $type
																								));
						}
						$pdf->SetFont('helvetica', '', 9, '', true);
						// set margins
						$pdf->SetMargins(13, '10', '5', '0');
						$pdf->AddPage();

						// -- set new background ---

						// get the current page break margin
						$bMargin = $pdf->getBreakMargin();
						// get current auto-page-break mode
						$auto_page_break = $pdf->getAutoPageBreak();
						// disable auto-page-break
						$pdf->SetAutoPageBreak(false, 0);
						// set bacground image
						$img_file = K_PATH_IMAGES.'facturetemplate.jpg';
						$pdf->Image($img_file, 0, 0, 210, 297, 'JPG', '', '', false, 300, '', false, false, 0);
						// restore auto-page-break status
						$pdf->SetAutoPageBreak($auto_page_break, $bMargin);
						// set the starting point for the page content
						$pdf->setPageMark();

						$pdf->writeHTML($html, true, false, true, false, '');
						$pdf->lastPage();
						$pdf_as_string = new Response($pdf->Output('facture.pdf', 'S')); // $pdf is a TCPDF instance
						// $pdf_as_string = $response->headers->set('Content-Type', 'application/pdf');
					}
					$mailer = $this->get('mailer');
					
					if($relance == 0)
					{
						$message = \Swift_Message::newInstance()
							->setSubject('Locamat-Services : Votre dernière facture (n°'.$numfacture.')')
							->setFrom(array('facturation.trans@gmail.com' => 'Locamat-Services'))
							->setTo($contact->getEmail())
							// ->setTo('ringuetjm@gmail.com')
							->setBody($this->renderView('BaclooCrmBundle:Crm:facture_email.html.twig', array('nom' => $contact->getNom(),
																									 'prenom' => $contact->getPrenom(),
																									 'civilite'	=> $contact->getCivilite()
																									  )))
						;
						$attachment = \Swift_Attachment::newInstance($pdf_as_string, 'facture.pdf', 'application/pdf');
						$message->attach($attachment);
						$mailer->send($message);
					}
					elseif($relance == 1)
					{
						$message = \Swift_Message::newInstance()
							->setSubject('Locamat-Services : Relance facture 1')
							->setFrom(array('facturation.trans@gmail.com' => 'Locamat-Services'))
							->setTo($contact->getEmail())
							// ->setTo('ringuetjm@gmail.com')
							->setBody($this->renderView('BaclooCrmBundle:Crm:facture_email1.html.twig', array('nom' => $contact->getNom(),
																									 'prenom' => $contact->getPrenom(),
																									 'facturesechues' => $facturesechues,
																									 'civilite'	=> $contact->getCivilite()
																									  )))
						;
						// $attachment = \Swift_Attachment::newInstance($pdf_as_string, 'facture.pdf', 'application/pdf');
						// $message->attach($attachment);
						$mailer->send($message);
					}
					elseif($relance == 2)
					{
						$message = \Swift_Message::newInstance()
							->setSubject('Locamat-Services : Relance facture 2')
							->setFrom(array('facturation.trans@gmail.com' => 'Locamat-Services'))
							->setTo($contact->getEmail())
							// ->setTo('ringuetjm@gmail.com')
							->setBody($this->renderView('BaclooCrmBundle:Crm:facture_email2.html.twig', array('nom' => $contact->getNom(),
																									 'prenom' => $contact->getPrenom(),
																									 'facturesechues' => $facturesechues,
																									 'civilite'	=> $contact->getCivilite()
																									  )))
						;
						// $attachment = \Swift_Attachment::newInstance($pdf_as_string, 'facture.pdf', 'application/pdf');
						// $message->attach($attachment);
						$mailer->send($message);
					}
				}
			}
			$relance1 = $facture->getDaterelance1();
			$relance2 = $facture->getDaterelance2();
			$relance3 = $facture->getDaterelance3();

			if($relance == 0)
			{
				$facture->setDaterelance1(date('Y-m-d'));
			}
			elseif($relance == 1)
			{
				foreach($facturesechues as $fact)
				{
					$fact->setDaterelance2(date('Y-m-d'));
					$em->persist($fact);
				}
			}
			elseif($relance == 2)
			{
				foreach($facturesechues as $fact)
				{
					$fact->setDaterelance2(date('Y-m-d'));
					$em->persist($fact);
				}
			}
			$em->persist($facture);
			$em->flush();

	return $this->redirect($this->generateUrl('bacloocrm_compta', array('vue' => 'locations', 'page' => $page, 'mode' => $mode)));
	}
	
	public function facturationAction($codecontrat, $vue, $mode)
	{echo 'VUUUUE'.$vue;echo 'MODA'.$mode;
		if($vue == 'achats')
		{
			include('prefacturationmensuelleachats.php');
		}
		else
		{
			include('prefacturationmensuelle.php');
		}
		if(!isset($message)){$message = 0;}
		if(!isset($date)){$date = 0;}
		// return $this->redirect($this->generateUrl('bacloocrm_compta', array('vue' => $vue, 'mode' => 'all', 'message' => $message, 'date' => $date)));	
	}
	
	// public function facturationdefAction($codecontrat, $vue)
	// {
		// include('facturationmensuelledefinitive.php');
		// if(!isset($message)){$message = 0;}
		// if(!isset($date)){$date = 0;}
		// return $this->redirect($this->generateUrl('bacloocrm_compta', array('vue' => $vue, 'mode' => 'all', 'message' => $message, 'date' => $date)));	
	// }
				
	public function echangesAction($ecode, $locid, $typeloc, $message, Request $request)
	{//echo $ecode;echo $typeloc;
	//echo 'message1'.$message;
		$usersess = $this->get('security.context')->getToken()->getUsername();
		$em = $this->getDoctrine()->getManager();					
		$now = date('Y-m-d');
		$defaultData = array();
		$form = $this->createFormBuilder($defaultData)
			->add('newmateriel', 'text', array('required' => true))
			->add('transportaller', 'integer', array('required' => true))
			->add('transportretour', 'integer', array('required' => true))
			->add('bdcrecu', 'checkbox', array('required' => false))
			->add('numbdc', 'text', array('required' => false))
			->getForm();
// echo $typeloc;echo $ecode;
		$typelocorigine = $typeloc;
		//on cherche une dispo
		if($typeloc == 'parc')
		{
			$oldmat = $em->getRepository('BaclooCrmBundle:Machines')
					->findOneBy(array('code'=>$ecode, 'original' => 1));
			$codegenerique = $oldmat->getCodegenerique();
			$codelocations = $oldmat->getCodelocations();
			$debutloc = $oldmat->getDebutloc();
			$finloc = $oldmat->getFinloc();	
// echo $codegenerique;					
			$machine = $em->getRepository('BaclooCrmBundle:Machines')
					->unedispo($codegenerique, $debutloc, $finloc);
// echo $debutloc;
// echo $finloc;
// print_r($machine);		
			if(!empty($machine))
			{//echo '55555';
				foreach($machine as $mach)
				{
					$ecodenewmat = $mach['code'];//echo '1111';
				}
				// $message = 0;
			}
			else
			{//echo '44444';
				if($machine != 'sl')
				{
					$message = 1;//Pas de machine de parc dispo
					$ecodenewmat = null;//echo '22222';
				}
				else
				{
					$message = 2; //Pas de sous loc dispo
					$ecodenewmat = null;//echo '33333';
				}
			}
		}
		else
		{
			$oldmat = $em->getRepository('BaclooCrmBundle:Machinessl')
					->findOneBy(array('code'=>$ecode, 'original' => 1));
			$codegenerique = $oldmat->getCodegenerique();
			$codelocations = $oldmat->getCodelocations();
			$debutloc = $oldmat->getDebutloc();
			$finloc = $oldmat->getFinloc();	
// echo $codegenerique;					
			$machine = $em->getRepository('BaclooCrmBundle:Machinessl')
					->unedispo($codegenerique, $debutloc, $finloc, $oldmat->getLoueur());
		
			if(!empty($machine))
			{//echo '55555';
				foreach($machine as $mach)
				{
					$ecodenewmat = $mach['code'];//echo '1111';
				}
				// $message = 0;
			}
			else
			{//echo '44444';
				if($machine == 'sl')
				{
					$message = 1;////Pas de machine sous-location dispo mais on met un autre modèle
					$ecodenewmat = null;//echo '22222';
				}
				else
				{
					$message = 2; //Pas de sous loc dispo
					$ecodenewmat = null;//echo '33333';
				}
			}
		}
		
		$form->handleRequest($request);
		if($form->isValid()) {
			$data = $form->getData();
			$newmateriel = $data['newmateriel'];
			$transportaller = $data['transportaller'];
			$transportretour = $data['transportretour'];
			$bdcrecu = $data['bdcrecu'];
			$numbdc = $data['numbdc'];
echo 'newmatos'.$newmateriel;
echo 'locid'.$locid;			
echo 'typeloc'.$typeloc;			
			//Controle avant modif
			if($typeloc == 'parc')
			{				
				$dejaenr = $em->getRepository('BaclooCrmBundle:Locata')		
							   ->dejaenr($newmateriel, $locid);			
			}
			else
			{				
				$dejaenr = $em->getRepository('BaclooCrmBundle:Locata')		
							   ->dejaenrsl($newmateriel, $locid);	
			}
			if(empty($dejaenr))
			{
				//On créée une nouvelle location pour ce nouveau matos
				$locata = $em->getRepository('BaclooCrmBundle:Locata')		
							   ->findOneById($oldmat->getCodecontrat());
				//Calcul de demain
				$today = date('D');
				if($today == 'Fri')
				{
					$demain = date('Y-m-d', strtotime("+3 days"));
				}
				elseif($today == 'Sat')
				{
					$demain = date('Y-m-d', strtotime("+2 days"));
				}
				else
				{
					$demain = date('Y-m-d', strtotime("+1 days"));
				}
							   
				if($typeloc == 'parc')
				{//echo 'ECODE'.$ecode;
					$oldmat  = $em->getRepository('BaclooCrmBundle:Machines')		
								   ->findOneBy(array('code'=>$ecode, 'original' => 1));
					$codegenerique = $oldmat->getCode();
					$codelocations = $oldmat->getCodelocations();
					$debutloc = $oldmat->getDebutloc();
					$finloc = $oldmat->getFinloc();			
				
					$newmat  = $em->getRepository('BaclooCrmBundle:Machines')
								   ->findOneBy(array('code'=>$newmateriel, 'original' => 1));
					if(!isset($newmat))
					{
						$newmat  = $em->getRepository('BaclooCrmBundle:Machinessl')		
									   ->findOneBy(array('code'=>$newmateriel, 'original' => 1));
						$typeloc = 'sl';
					}								   
					if(isset($newmat))
					{
						//On recopie les données de l'ancien matos dans le nouveau
						$newmat->setCodecontrat($oldmat->getCodecontrat());
						$newmat->setClientid($oldmat->getClientid());
						$newmat->setEntreprise($oldmat->getEntreprise());
						$newmat->setNomchantier($oldmat->getNomchantier());
						if(strtotime($demain) > strtotime($oldmat->getFinloc()))
						{
							$newmat->setDebutloc($oldmat->getFinloc());
						}
						else
						{
							$newmat->setDebutloc($demain);
						}
						$newmat->setFinloc($oldmat->getFinloc());
						$newmat->setEtat('Prêt au départ');
						$newmat->setEtatlog('Prêt pour le chargement');
						$em->persist($newmat);
						
						foreach ($locata->getLocations() as $loc)
						{
							if($loc->getCodemachineinterne() == $ecode && $loc->getId() == $oldmat->getCodelocations())
							{				
								//On recopie ces nouvelles données dans la nouvelle location pour le nouveau matos
								if($typeloc == 'parc')
								{
									$locatio  = $em->getRepository('BaclooCrmBundle:Locations')		
									   ->findOneBy(array('codemachineinterne' => $ecode, 'id' => $oldmat->getCodelocations()));
									$locations = clone $locatio;
								}
								else
								{
									$locatio  = $em->getRepository('BaclooCrmBundle:Locations')		
									   ->findOneBy(array('codemachineinterne' => $ecode, 'id' => $oldmat->getCodelocations()));
									$locations = new Locationssl;
									$locations->setCodeclient($loc->getCodeclient());
									$locations->setEntreprise($loc->getEntreprise());
									$locations->setLoyerp1($loc->getLoyerp1());
									$locations->setLoyerp2($loc->getLoyerp2());
									$locations->setLoyerp3($loc->getLoyerp3());
									$locations->setLoyerp4($loc->getLoyerp4());
									$locations->setLoyermensuel($loc->getLoyermensuel());
									$locations->setContributionverte($loc->getContributionverte());
									$locations->setAssurance($loc->getAssurance());
									$locations->setTransportaller($loc->getTransportaller());
									$locations->setTransportretour($loc->getTransportretour());
									$locations->setTransportretour($loc->getTransportretour());
									$locations->setLitrescarb($loc->getLitrescarb());
									$locations->setCloture($loc->getCloture());
									$locations->setLoueur($newmat->getLoueur());
								}
								$locations->setCodemachineinterne($newmateriel);
								$locations->setMachineid($newmat->getId());
								$locations->setTypemachine($newmat->getDescription());
								$locations->setCodemachine($newmat->getCodegenerique());
								$locations->setCodeclient($loc->getCodeclient());
								$locations->setEtatloc('Prêt au départ');
								$locations->setEtatlog('Prêt pour le chargement');
								$locations->setEnergie($newmat->getEnergie());
								//Démarrage de la loc du nouveau matos à demain
								if(strtotime($demain) > strtotime($loc->getFinloc()))
								{
									$locations->setDebutloc($loc->getFinloc());
								}
								else
								{
									$locations->setDebutloc($demain);
								}
								$locations->setFinloc($loc->getFinloc());
								$nbjlocadeduire = 0;
								$nbjloc = 0;
								$nbjlocass = 0;								
								$iStart = strtotime ($demain);//Formate une date/heure locale avec la Something is wronguration locale
								$iEnd = strtotime ($loc->getFinloc());
								if (false === $iStart || false === $iEnd) {
									// return false;
								}
								$aStart = explode ('-', $demain);
								$aEnd = explode ('-', $loc->getFinloc());
								if (count ($aStart) !== 3 || count ($aEnd) !== 3) {
									// return false;
								}
								// if (false === checkdate ($aStart[1], $aStart[2], $aStart[0]) || false === checkdate ($aEnd[1], $aEnd[2], $aEnd[0]) || $iEnd <= $iStart) {
									// return false;
								// }

								$jour50 = $loc->getJour50();
								$jour100 = $loc->getJour100();						
								$aDates = array();
								for ($i = $iStart; $i < $iEnd + 86400; $i = $i + 86400 ) {
									$sDateToArr = strftime ('%Y-%m-%d', $i);
									$sYear = substr ($sDateToArr, 0, 4);
									$sMonth = substr ($sDateToArr, 5, 2);
									$aDates[] = $sDateToArr;
								}	

							//on calcule le nombre de jours de location
								foreach($aDates as $dat)
								{						
									$time = strtotime($dat);
									// echo $dat;
									//Facturation WE ou pas
									$newformat = date('D',$time);
									if($locata->getFacturersamedi() == 1 && $newformat == 'Sat')
									{
										$nbjloc++;
									}
									elseif($locata->getFacturerdimanche() == 1 && $newformat == 'Sun')
									{
										$nbjloc++;
									}
									elseif($newformat == 'Sat' or $newformat == 'Sun')
									{}
									else
									{
										$nbjloc++;
									}										
								}
							//nb jour pour les assurances car 7/7
								foreach($aDates as $dat)
								{
									$nbjlocass++;
								}
								$locations->setNbjloc($nbjloc);								
								$locations->setNbjlocass($nbjlocass);								
								$locations->addLocatum($locata);
								if($typeloc == 'sl')
								{
									$locata->addLocationssl($locations);
								}
								else
								{
									$locata->addLocation($locations);
								}
								$em->persist($locations);					
								$em->flush();
								//On stoppe la location de l'ancien matos à aujourd'hui
								$locatio->setFinloc($now);
								
								$nbjlocadeduire = 0;
								$nbjloc = 0;
								$nbjlocass = 0;								
								$iStart = strtotime ($locatio->getDebutloc());//Formate une date/heure locale avec la Something is wronguration locale
								$iEnd = strtotime ($now);
								if (false === $iStart || false === $iEnd) {
									// return false;
								}
								$aStart = explode ('-', $locatio->getDebutloc());
								$aEnd = explode ('-', $now);
								if (count ($aStart) !== 3 || count ($aEnd) !== 3) {
									// return false;
								}
								// if (false === checkdate ($aStart[1], $aStart[2], $aStart[0]) || false === checkdate ($aEnd[1], $aEnd[2], $aEnd[0]) || $iEnd <= $iStart) {
									// return false;
								// }

								$jour50 = $loc->getJour50();
								$jour100 = $loc->getJour100();						
								$aDates = array();
								for ($i = $iStart; $i < $iEnd + 86400; $i = strtotime ('+1 day', $i) ) {
									$sDateToArr = strftime ('%Y-%m-%d', $i);
									$sYear = substr ($sDateToArr, 0, 4);
									$sMonth = substr ($sDateToArr, 5, 2);
									$aDates[] = $sDateToArr;
								}	

							//on calcule le nombre de jours de location
								foreach($aDates as $dat)
								{						
									$time = strtotime($dat);
									// echo $dat;
									//Facturation WE ou pas
									$newformat = date('D',$time);
									if($locata->getFacturersamedi() == 1 && $newformat == 'Sat')
									{
										$nbjloc++;
									}
									elseif($locata->getFacturerdimanche() == 1 && $newformat == 'Sun')
									{
										$nbjloc++;
									}
									elseif($newformat == 'Sat' or $newformat == 'Sun')
									{}
									else
									{
										$nbjloc++;
									}										
								}
							//nb jour pour les assurances car 7/7
								foreach($aDates as $dat)
								{
									$nbjlocass++;
								}								
								$locatio->setNbjloc($nbjloc);
								$locatio->setNbjlocass($nbjlocass);
								$locatio->setFinloc($now);
								$em->persist($locatio);
								$em->flush();
								
								//On met l'ancien matos en retour planifié et finloc à today
								$oldmat->setFinloc($now);
								$newmat->setCodelocations($locations->getId());
								$em->flush();
							}
						}
						$message = 5;//Echange effectué ajout dans la table échange	
						$echange = new Echanges;
						$echange->setDate($demain);
						$echange->setClientId($locata->getClientid());
						$echange->setClient($locata->getClient());
						$echange->setChantierid($locata->getChantierid());
						$echange->setChantier($locata->getNomchantier());
						$echange->setCp($locata->getCp());
						$echange->setMaterielinitial($codegenerique);
						$echange->setMaterielremplacement($newmateriel);
						$echange->setUser($usersess);
						$echange->setTypeloc($typeloc);
						$echange->setCodecontrat($locid);
						$em->persist($echange);
						$em->flush();
						// echo 'OK ECHANGE';
					}
					else
					{
						$message = 3;//Machine sélectionnée pas dispo
					}		
				}
				else
				{echo 'on est sl';echo $ecode;
					$oldmat  = $em->getRepository('BaclooCrmBundle:Machinessl')		
								   ->findOneByCode($ecode);
					$codegenerique = $oldmat->getCode();
					$codelocations = $oldmat->getCodelocations();
					$debutloc = $oldmat->getDebutloc();
					$finloc = $oldmat->getFinloc();
					//Calcul de demain
					$today = date('D');
					if($today == 'Fri')
					{
						$demain = date('Y-m-d', strtotime("+3 days"));
					}
					elseif($today == 'Sat')
					{
						$demain = date('Y-m-d', strtotime("+2 days"));
					}
					else
					{
						$demain = date('Y-m-d', strtotime("+1 days"));
					}			
echo 'newmat'.$newmateriel;				
					$newmat  = $em->getRepository('BaclooCrmBundle:Machinessl')		
								   ->findOneBy(array('code'=>$newmateriel, 'original' => 1));
					if(!isset($newmat))
					{
						$newmat  = $em->getRepository('BaclooCrmBundle:Machines')		
									   ->findOneBy(array('code'=>$newmateriel, 'original' => 1));
						$typeloc = 'parc';
					}
					if(isset($newmat))
					{
						//On recopie les données de l'ancien matos dans le nouveau
						$newmat->setCodecontrat($oldmat->getCodecontrat());
						$newmat->setClientid($oldmat->getClientid());
						$newmat->setEntreprise($oldmat->getEntreprise());
						$newmat->setNomchantier($oldmat->getNomchantier());
						if(strtotime($demain) > strtotime($oldmat->getFinloc()))
						{
							$newmat->setDebutloc($oldmat->getFinloc());
						}
						else
						{
							$newmat->setDebutloc($demain);
						};
						$newmat->setFinloc($oldmat->getFinloc());
						$newmat->setEtat('Prêt au départ');
						$newmat->setEtatlog('Prêt pour le chargement');
						$em->persist($newmat);
						$em->flush();
echo 'nouveau matos'.$newmat->getCode();echo 'typeloc'.$typeloc;						
						foreach ($locata->getLocationssl() as $loc)
						{
							if($loc->getCodemachineinterne() == $ecode && $loc->getId() == $oldmat->getCodelocations())
							{					
								//On recopie ces nouvelles données dans la nouvelle location pour le nouveau matos
								if($typeloc == 'sl')
								{
									$locatio  = $em->getRepository('BaclooCrmBundle:Locationssl')		
									   ->findOneBy(array('codemachineinterne' => $ecode, 'id' => $oldmat->getCodelocations()));
									$locations = clone $locatio;
								}
								else
								{
									$locatio  = $em->getRepository('BaclooCrmBundle:Locationssl')		
									   ->findOneBy(array('codemachineinterne' => $ecode, 'id' => $oldmat->getCodelocations()));
									$locations = new Locations;
									$locations->setCodeclient($loc->getCodeclient());
									$locations->setEntreprise($loc->getEntreprise());
									$locations->setLoyerp1($loc->getLoyerp1());
									$locations->setLoyerp2($loc->getLoyerp2());
									$locations->setLoyerp3($loc->getLoyerp3());
									$locations->setLoyerp4($loc->getLoyerp4());
									$locations->setLoyermensuel($loc->getLoyermensuel());
									$locations->setContributionverte($loc->getContributionverte());
									$locations->setAssurance($loc->getAssurance());
									$locations->setTransportaller($loc->getTransportaller());
									$locations->setTransportretour($loc->getTransportretour());
									$locations->setTransportretour($loc->getTransportretour());
									$locations->setLitrescarb($loc->getLitrescarb());
									$locations->setCloture($loc->getCloture());
								}
								$locations->setCodemachineinterne($newmateriel);
								$locations->setMachineid($newmat->getId());
								$locations->setTypemachine($newmat->getDescription());
								$locations->setCodemachine($newmat->getCodegenerique());
								$locations->setCodeclient($loc->getCodeclient());
								$locations->setEtatloc('Prêt au départ');
								$locations->setEtatlog('Prêt pour le chargement');
								$locations->setEnergie($newmat->getEnergie());
								//Démarrage de la loc du nouveau matos à demain
								if(strtotime($demain) > strtotime($loc->getFinloc()))
								{
									$locations->setDebutloc($loc->getFinloc());
								}
								else
								{
									$locations->setDebutloc($demain);
								}
								$locations->setFinloc($loc->getFinloc());
								$nbjlocadeduire = 0;
								$nbjloc = 0;
								$nbjlocass = 0;								
								$iStart = strtotime ($demain);//Formate une date/heure locale avec la Something is wronguration locale
								$iEnd = strtotime ($loc->getFinloc());
								if (false === $iStart || false === $iEnd) {
									// return false;
								}
								$aStart = explode ('-', $demain);
								$aEnd = explode ('-', $loc->getFinloc());
								if (count ($aStart) !== 3 || count ($aEnd) !== 3) {
									// return false;
								}
								// if (false === checkdate ($aStart[1], $aStart[2], $aStart[0]) || false === checkdate ($aEnd[1], $aEnd[2], $aEnd[0]) || $iEnd <= $iStart) {
									// return false;
								// }

								$jour50 = $loc->getJour50();
								$jour100 = $loc->getJour100();						
								$aDates = array();
								for ($i = $iStart; $i < $iEnd + 86400; $i = $i + 86400 ) {
									$sDateToArr = strftime ('%Y-%m-%d', $i);
									$sYear = substr ($sDateToArr, 0, 4);
									$sMonth = substr ($sDateToArr, 5, 2);
									$aDates[] = $sDateToArr;
								}	

							//on calcule le nombre de jours de location
								foreach($aDates as $dat)
								{						
									$time = strtotime($dat);
									// echo $dat;
									//Facturation WE ou pas
									$newformat = date('D',$time);
									if($locata->getFacturersamedi() == 1 && $newformat == 'Sat')
									{
										$nbjloc++;
									}
									elseif($locata->getFacturerdimanche() == 1 && $newformat == 'Sun')
									{
										$nbjloc++;
									}
									elseif($newformat == 'Sat' or $newformat == 'Sun')
									{}
									else
									{
										$nbjloc++;
									}										
								}
							//nb jour pour les assurances car 7/7
								foreach($aDates as $dat)
								{
									$nbjlocass++;
								}
								$locations->setNbjloc($nbjloc);								
								$locations->setNbjlocass($nbjlocass);								
								$locations->addLocatum($locata);
								$em->persist($locations);
								$em->flush();
								$newmat->setCodelocations($locations->getId());
								if($typeloc == 'sl')
								{
									$locata->addLocationssl($locations);
								}
								else
								{
									$locata->addLocation($locations);
								}
								
								//On stoppe la location de l'ancien matos à aujourd'hui
								$locatio->setFinloc($now);
								
								$nbjlocadeduire = 0;
								$nbjloc = 0;
								$nbjlocass = 0;								
								$iStart = strtotime ($locatio->getDebutloc());//Formate une date/heure locale avec la Something is wronguration locale
								$iEnd = strtotime ($now);
								if (false === $iStart || false === $iEnd) {
									// return false;
								}
								$aStart = explode ('-', $locatio->getDebutloc());
								$aEnd = explode ('-', $now);
								if (count ($aStart) !== 3 || count ($aEnd) !== 3) {
									// return false;
								}
								// if (false === checkdate ($aStart[1], $aStart[2], $aStart[0]) || false === checkdate ($aEnd[1], $aEnd[2], $aEnd[0]) || $iEnd <= $iStart) {
									// return false;
								// }

								$jour50 = $loc->getJour50();
								$jour100 = $loc->getJour100();						
								$aDates = array();
								for ($i = $iStart; $i < $iEnd + 86400; $i = $i + 86400 ) {
									$sDateToArr = strftime ('%Y-%m-%d', $i);
									$sYear = substr ($sDateToArr, 0, 4);
									$sMonth = substr ($sDateToArr, 5, 2);
									$aDates[] = $sDateToArr;
								}	

							//on calcule le nombre de jours de location
								foreach($aDates as $dat)
								{						
									$time = strtotime($dat);
									// echo $dat;
									//Facturation WE ou pas
									$newformat = date('D',$time);
									if($locata->getFacturersamedi() == 1 && $newformat == 'Sat')
									{
										$nbjloc++;
									}
									elseif($locata->getFacturerdimanche() == 1 && $newformat == 'Sun')
									{
										$nbjloc++;
									}
									elseif($newformat == 'Sat' or $newformat == 'Sun')
									{}
									else
									{
										$nbjloc++;
									}										
								}
							//nb jour pour les assurances car 7/7
								foreach($aDates as $dat)
								{
									$nbjlocass++;
								}								
								$locatio->setNbjloc($nbjloc);
								$locatio->setNbjlocass($nbjlocass);
								$locatio->setFinloc($now);
								$em->persist($locatio);
								$em->flush();
							}
						}
						$oldmat->setFinloc($now);
						$em->flush();
						$message = 5;//Echange effectué ajout dans la table échange	
					}
					else
					{
						$message = 3;//Machine sélectionnée pas dispo
					}
				}
				//Ajout Vente Transport échange
				$venda = new Venda;
				$venda->setDate($now);
				$venda->setClientid($locata->getClientid());
				$venda->setClient($locata->getClient());
				$venda->setUser($usersess);
				$venda->setOffreencours(1);
				$venda->setBdcrecu($bdcrecu);
				$venda->setNumbdc($numbdc);
				$em->persist($venda);
				
				$description  = 'Livraison du matériel  '.$newmat->getCode().' lors de l\'échange avec '.$oldmat->getCode();
				$vente = new Ventes;
				$vente->setDate($now);
				$vente->setUser($usersess);
				$vente->setRefarticle('trsp');
				$vente->setDescription($description);
				$vente->setQuantite(1);
				$vente->setPu($transportaller);
				$vente->setMontantvente($transportaller);
				$vente->addvenda($venda);
				$venda->addVente($vente);			
				$em->persist($vente);
				$em->flush();
				
				$description  = 'Reprise du matériel  '.$oldmat->getCode().' lors de l\'échange avec '.$newmat->getCode();
				$vente = new Ventes;
				$vente->setDate($now);
				$vente->setUser($usersess);
				$vente->setRefarticle('trsp');
				$vente->setDescription($description);
				$vente->setQuantite(1);
				$vente->setPu($transportaller);
				$vente->setMontantvente($transportaller);
				$vente->addvenda($venda);
				$venda->addVente($vente);			
				$em->persist($vente);
				$em->flush();			
				//Fin ajout vente transport échange	
			}
			// else
			// {
				// $message = 4;
			// }
			return $this->redirect($this->generateUrl('bacloocrm_echanges', array('ecode' => $ecode, 'locid' => $locid, 'typeloc' => $typelocorigine, 'message' => $message)));
		}
		$previous = $this->get('request')->server->get('HTTP_REFERER');
		return $this->render('BaclooCrmBundle:Crm:echanges.html.twig', array('form' => $form->createView(),
																	'ecodenewmat' => $ecodenewmat,
																	'codelocations' => $codelocations,
																	'ecodeancienmat' => $ecode,
																	'message' => $message,
																	'previous' => $previous,
																	'ficheid' => $oldmat->getClientid(),
																	'locid' => $oldmat->getCodecontrat(),
																	'typeloc' => $typeloc
																	));		
	}
	
			
	public function echangespdfAction($ecode, $locid, $typeloc, Request $request)
	{
		$usersess = $this->get('security.context')->getToken()->getUsername();
		$em = $this->getDoctrine()->getManager();					
		$now = date('Y-m-d');
		$defaultData = array();
		$form = $this->createFormBuilder($defaultData)
			->add('newmateriel', 'text', array('required' => true))
			->add('transportaller', 'integer', array('required' => true))
			->add('transportretour', 'integer', array('required' => true))
			->add('bdcrecu', 'checkbox', array('required' => false))
			->add('numbdc', 'text', array('required' => false))
			->getForm();
// echo $typeloc;
		//on cherche une dispo
		if($typeloc == 'parc')
		{
			$oldmat = $em->getRepository('BaclooCrmBundle:Machines')
					->findOneByCode($ecode);
			$codegenerique = $oldmat->getCodegenerique();
			$codelocations = $oldmat->getCodelocations();
			$debutloc = $oldmat->getDebutloc();
			$finloc = $oldmat->getFinloc();	
// echo $codegenerique;					
			$machine = $em->getRepository('BaclooCrmBundle:Machines')
					->unedispo($codegenerique, $debutloc, $finloc);
// echo $debutloc;
// echo $finloc;
// print_r($machine);		
			if(!empty($machine))
			{//echo '55555';
				foreach($machine as $mach)
				{
					$ecodenewmat = $mach['code'];//echo '1111';
				}
				$message = 0;
			}
			else
			{//echo '44444';
				if($machine != 'sl')
				{
					$message = 1;//Pas de machine de parc dispo
					$ecodenewmat = null;//echo '22222';
				}
				else
				{
					$message = 2; //Pas de sous loc dispo
					$ecodenewmat = null;//echo '33333';
				}
			}
		}
		else
		{
			$oldmat = $em->getRepository('BaclooCrmBundle:Machinessl')
					->findOneByCode($ecode);
			$codegenerique = $oldmat->getCode();
			$codelocations = $oldmat->getCodelocations();
			$debutloc = $oldmat->getDebutloc();
			$finloc = $oldmat->getFinloc();	
// echo $codegenerique;					
			$machine = $em->getRepository('BaclooCrmBundle:Machinessl')
					->unedispo($codegenerique, $debutloc, $finloc, $oldmat->getLoueur());
		
			if(!empty($machine))
			{//echo '55555';
				foreach($machine as $mach)
				{
					$ecodenewmat = $mach['code'];//echo '1111';
				}
				$message = 0;
			}
			else
			{//echo '44444';
				if($machine != 'sl')
				{
					$message = 1;//Pas de machine de parc dispo
					$ecodenewmat = null;//echo '22222';
				}
				else
				{
					$message = 2; //Pas de sous loc dispo
					$ecodenewmat = null;//echo '33333';
				}
			}
		}
		
		$form->handleRequest($request);
		return $this->render('BaclooCrmBundle:Crm:echanges.html.twig', array('form' => $form->createView(),
																	'ecodenewmat' => $ecodenewmat,
																	'codelocations' => $codelocations,
																	'ecodeancienmat' => $ecode,
																	'message' => $message,
																	'ficheid' => $oldmat->getClientid(),
																	'locid' => $oldmat->getCodecontrat(),
																	'typeloc' => $typeloc
																	));		
	}
	
	public function transfertsAction($ecode, $typeloc, $codelocations, $codecontrat, $message, Request $request)
	{
		$usersess = $this->get('security.context')->getToken()->getUsername();
		$today = date('Y-m-d');
		$em = $this->getDoctrine()->getManager();		
		//On recupère le bon codelocations
		if($codelocations == 0)
		{
			$locatacodeloc = $em->getRepository('BaclooCrmBundle:Locata')
				->recupcodeloc($ecode, $typeloc, $codecontrat);
				// print_r($locatacodeloc);
			foreach($locatacodeloc as $locat)
			{
				$codelocations = $locat['c_id'];
			}
		}
		//On recupère les infos de l'ancien chantier
		$locata = $em->getRepository('BaclooCrmBundle:Locata')
			->findOneById($codecontrat);
	
		//On dessine notre formulaire indépendant
		$defaultData = array();
		$form = $this->createFormBuilder($defaultData)
			->add('date', 'text', array('required' => true))
			->add('chantierid', 'integer', array('required' => true))
			->add('transportaller', 'integer', array('required' => true))
			->add('nomchantier', 'text', array('required' => true))
			->add('adresse1', 'text', array('required' => false))
			->add('adresse2', 'text', array('required' => false))
			->add('adresse3', 'text', array('required' => false))
			->add('cp', 'integer', array('required' => true))
			->add('ville', 'text', array('required' => true))
			->add('demandeur', 'text', array('required' => true))
			->add('contact', 'text', array('required' => true))
			->add('bdcrecu', 'checkbox', array('required' => false))
			->add('numbdc', 'text', array('required' => false))
			->getForm();

		$form->handleRequest($request);
		if($form->isValid()) {
			$data = $form->getData();
			$date = $data['date'];
			$demandeur = $data['demandeur'];
			$contact = $data['contact'];
			$newchantier = $data['nomchantier'];
			$newadresse1 = $data['adresse1'];
			$newadresse2 = $data['adresse2'];
			$newadresse3 = $data['adresse3'];
			$newcp = $data['cp'];
			$newville = $data['ville'];
			$transportaller = $data['transportaller'];
			$bdcrecu = $data['bdcrecu'];
			$numbdc = $data['numbdc'];
			
			//On regarde si le nouveau chantier existe déjà dans la table chantier
			$chantier = $em->getRepository('BaclooCrmBundle:Chantier')
				->findOneByNom($newchantier);
			
			//Si new chantier n'existe pas alors on l'insere dans la table chanter et on flush pour avoir l'id
			if(empty($chantier))
			{
				$nouveauchantier = new Chantier;
				$nouveauchantier->setNom($newchantier);
				$nouveauchantier->setAdresse1($newadresse1);
				$nouveauchantier->setAdresse2($newadresse2);
				$nouveauchantier->setAdresse3($newadresse3);
				$nouveauchantier->setCp($newcp);
				$nouveauchantier->setVille($newville);
				$em->persist($nouveauchantier);
				$em->flush();
				
				$chantier = $em->getRepository('BaclooCrmBundle:Chantier')
								->findOneByNom($newchantier);
			}
			
			//On regarde si le nouveau transfert existe déjà dans la table transferts
			$newtransfert = $em->getRepository('BaclooCrmBundle:Transferts')
				->findOneBy(array('clientid' => $locata->getClientid(), 'ecode' => $ecode, 'codecontrat' => $codecontrat));	
			if(empty($newtransfert))
			{
				//On écrit les informations du transfère dans la table transfert
				$transfert = new Transferts;
				$transfert->setDate($date);
				$transfert->setEcode($ecode);
				$transfert->setChantierid($locata->getChantierid());
				$transfert->setClientid($locata->getClientid());
				$transfert->setClient($locata->getClient());
				$transfert->setOldnomchantier($locata->getNomchantier());
				$transfert->setOldadresse1($locata->getAdresse1());
				$transfert->setOldadresse2($locata->getAdresse2());
				$transfert->setOldadresse3($locata->getAdresse3());
				$transfert->setOldcp($locata->getCp());
				$transfert->setOldville($locata->getVille());
				$transfert->setNewnomchantier($newchantier);
				$transfert->setNewadresse1($newadresse1);
				$transfert->setNewadresse2($newadresse2);
				$transfert->setNewadresse3($newadresse3);
				$transfert->setNewcp($newcp);
				$transfert->setNewville($newville);
				$transfert->setTransportaller($transportaller);
				$transfert->setDemandeur($demandeur);
				$transfert->setContact($contact);
				$transfert->setCodecontrat($codecontrat);
				$transfert->setTypeloc($typeloc);
				$transfert->setUser($usersess);
				$em->persist($transfert);
				$em->flush();
				
				//On insere le nom du nouveau chantier dans la table locata
				$locata->setChantierid($chantier->getId());
				$locata->setNomchantier($newchantier);
				$locata->setAdresse1($newadresse1);
				$locata->setAdresse2($newadresse2);
				$locata->setAdresse3($newadresse3);
				$locata->setCp($newcp);
				$locata->setVille($newville);
				$em->persist($locata);			
				
				//On insere le nom du nouveau chantier dans la table machines
				$machine = $em->getRepository('BaclooCrmBundle:Machines')
								->findOneBy(array('code' => $ecode, 'original' => 1));
				if(!isset($machine))
				{
					$machine = $em->getRepository('BaclooCrmBundle:Machinessl')
									->findOneBy(array('code' => $ecode, 'original' => 1));
				}	
				$machine->setNomchantier($newchantier);
				$machine->setEtat('Prêt au départ');
				$machine->setEtatlog('Prêt pour le chargement');
				
				//On modifie le statut de la livraison
				$locations = $em->getRepository('BaclooCrmBundle:Locations')
								->findOneByid($codelocations);
				if(!isset($locations) && $typeloc == 'sl')
				{
					$locations = $em->getRepository('BaclooCrmBundle:Locationssl')
									->findOneByid($codelocations);
				}
				$locations->setEtatloc('Prêt au départ');
				$locations->setEtatlog('Prêt pour le chargement');	
				$em->flush();	
									
				//Ajout Vente Transport transfert
				$now = date('Y-m-d');
				$venda = new Venda;
				$venda->setDate($now);
				$venda->setClientid($locata->getClientid());
				$venda->setClient($locata->getClient());
				$venda->setUser($usersess);
				$venda->setOffreencours(1);
				$venda->setBdcrecu($bdcrecu);
				$venda->setNumbdc($numbdc);
				$em->persist($venda);
				
				$description  = 'Transfert de '.$locata->getNomchantier().' à '.$newchantier;
				$vente = new Ventes;
				$vente->setDate($now);
				$vente->setUser($usersess);
				$vente->setRefarticle('trsp');
				$vente->setDescription($description);
				$vente->setQuantite(1);
				$vente->setPu($transportaller);
				$vente->setMontantvente($transportaller);
				$vente->addvenda($venda);
				$venda->addVente($vente);			
				$em->persist($vente);
				$em->flush();			
				//Fin ajout vente transport transfert	
				return $this->redirect($this->generateUrl('bacloocrm_transferts', array('ecode' => $ecode, 'typeloc' => $typeloc, 'codelocations' => $codelocations, 'codecontrat' => $codecontrat, 'message' => 1)));
			}	
			return $this->redirect($this->generateUrl('bacloocrm_transferts', array('ecode' => $ecode, 'typeloc' => $typeloc, 'codelocations' => $codelocations, 'codecontrat' => $codecontrat, 'message' => 2)));
		}
	
		return $this->render('BaclooCrmBundle:Crm:transferts.html.twig', array('form' => $form->createView(),
																	'nomoldchantier' => $locata->getNomchantier(),
																	'codelocations' => $codelocations,
																	'codecontrat' => $codecontrat,
																	'typeloc' => $typeloc,
																	'date' => $today,
																	'client' => $locata->getClient(),
																	'clientid' => $locata->getClientid(),
																	'message' => $message,
																	'ecode' => $ecode
																	));						
	}
	
	
	public function transfertspdfAction($ecode, $typeloc, $codelocations, $codecontrat, $message, Request $request)
	{
		$usersess = $this->get('security.context')->getToken()->getUsername();
		$today = date('Y-m-d');
		$em = $this->getDoctrine()->getManager();		
		//On recupère le bon codelocations
		if($codelocations == 0)
		{
			$locatacodeloc = $em->getRepository('BaclooCrmBundle:Locata')
				->recupcodeloc($ecode, $typeloc, $codecontrat);
				// print_r($locatacodeloc);
			foreach($locatacodeloc as $locat)
			{
				$codelocations = $locat['c_id'];
			}
		}
		//On recupère les infos de l'ancien chantier
		$locata = $em->getRepository('BaclooCrmBundle:Locata')
			->findOneById($codecontrat);
	
		//On dessine notre formulaire indépendant
		$defaultData = array();
		$form = $this->createFormBuilder($defaultData)
			->add('date', 'text', array('required' => true))
			->add('chantierid', 'integer', array('required' => true))
			->add('transportaller', 'integer', array('required' => true))
			->add('nomchantier', 'text', array('required' => true))
			->add('adresse1', 'text', array('required' => false))
			->add('adresse2', 'text', array('required' => false))
			->add('adresse3', 'text', array('required' => false))
			->add('cp', 'integer', array('required' => true))
			->add('ville', 'text', array('required' => true))
			->add('demandeur', 'text', array('required' => true))
			->add('contact', 'text', array('required' => true))
			->add('bdcrecu', 'checkbox', array('required' => false))
			->add('numbdc', 'text', array('required' => false))
			->getForm();

		$pdf = $this->get("white_october.tcpdf")->create();
		
		$html = $this->renderView('BaclooCrmBundle:Crm:transferts.html.twig', array('form' => $form->createView(),
																	'nomoldchantier' => $locata->getNomchantier(),
																	'codelocations' => $codelocations,
																	'codecontrat' => $codecontrat,
																	'typeloc' => $typeloc,
																	'date' => $today,
																	'client' => $locata->getClient(),
																	'clientid' => $locata->getClientid(),
																	'message' => $message,
																	'ecode' => $ecode
																	));
		$pdf->SetFont('helvetica', '', 9, '', true);
        $pdf->AddPage();
        $pdf->writeHTML($html, true, false, true, false, '');
        $pdf->lastPage();
 
        $response = new Response($pdf->Output('file.pdf'));
        $response->headers->set('Content-Type', 'application/pdf');
 
        return $response;			
	}
	
	public function ventesAction($ficheid, $vendaid, $mode)
	{
		$user = $this->get('security.context')->getToken()->getUsername(); if(empty($user) or !isset($user) or $user == 'anon.'){return $this->redirect($this->generateUrl('fos_user_security_login'));}
		$em = $this->getDoctrine()->getManager();
		$userdetails  = $em->getRepository('BaclooUserBundle:User')		
					   ->findOneByUsername($user);
		$today = date('Y-m-d');
		
		$client  = $em->getRepository('BaclooCrmBundle:Fiche')		
					   ->findOneById($ficheid);	
					   
		if($vendaid == 0)
		{
			$venda = new Venda;			
			$totalvente = 0;
			$bdcrecu = 0;
			$new = 1;
		}
		else
		{
			$new = 0;
			$venda = $em->getRepository('BaclooCrmBundle:Venda')
						->findOneById($vendaid);
			$bdcrecu = $venda->getBdcrecu();
			//FACTURATION
			$montantvente = 0;			
			$totalvente = 0;			
			foreach($venda->getVentes() as $ven)
			{
				$montantvente = $ven->getQuantite() * $ven->getPu();
				$totalvente += $ven->getQuantite() * $ven->getPu();
			}	

			//FIN FACTURATION
		}
		$form = $this->createForm(new VendaType(), $venda);
		$request = $this->get('request');
		if ($request->getMethod() == 'POST') 
		{
			$form->bind($request);
			if($form->isValid()){
			$montantvente = 0;			
			$totalvente = 0;
				foreach($form->get('ventes')->getData() as $ven)
				{echo  $ven->getPu();
					$montantvente = $ven->getQuantite() * $ven->getPu();
					$totalvente += $ven->getQuantite() * $ven->getPu();
					
					$ven->setMontantvente($montantvente);
					$em->persist($ven);
					$em->flush();
				}echo 'totalvete'.$totalvente;	
				$venda->setMontantvente($totalvente);
				if($new == 1){$venda->setDate(date('Y-m-d'));}
				$em->persist($venda);
				$em->flush();
				$facture = $em->getRepository('BaclooCrmBundle:Factures')
						->findOneByCodelocata('V-'.$venda->getId());
					
				if(isset($facture))
				{
					$facture->setTotalht($venda->getMontantvente()*(1-$venda->getRemise()/100));
					$facture->setTotalttc($venda->getMontantvente() * 1.2*(1-$venda->getRemise()/100));
					$em->persist($facture);
					$em->flush();
				}
							
				if($vendaid == 0)
				{				
					$vendaid = $venda->getId();
				}
				else
				{
					$facture = $em->getRepository('BaclooCrmBundle:Factures')
							->findOneByCodelocata('V-'.$venda->getId());
						
					if(isset($facture))
					{
						$facture->setTotalht($venda->getMontantvente()*(1-$venda->getRemise()/100));
						$facture->setTotalttc($venda->getMontantvente() * 1.2*(1-$venda->getRemise()/100));
						$em->persist($facture);
						$em->flush();
					}					
				}
// echo 'BDC RECU'.$venda->getBdcrecu();				
				if($venda->getBdcrecu() == 1)
				{
					$venda = $em->getRepository('BaclooCrmBundle:Venda')
								->findOneById($venda->getId());						
					$codecontrat = 'V-'.$venda->getId();
					$facturemois = $em->getRepository('BaclooCrmBundle:Factures')
								->facturesmois($codecontrat);
//echo $codecontrat;
// print_r($facturemois);
					$totalht = 0;//echo $locid;			
					$venteslignes = 0;			
					$entretienlignes = 0;			
					$transportlignes = 0;			
					$annexeslignes = 0;			
					$assurancelignes = 0;			
					$descriptionvente = array();			
					$descriptionentretien = array();			
					$descriptiontransport = array();			
					$descriptionannexe = array();
				
					if($venda->getBdcrecu() == 1)
					{
						foreach($venda->getVentes() as $loca)
						{
							//Nous récupérons et formatons les différentes dates
							// $finloc = strtotime ($loca->getFinloc());	
							// $finlocsec = strtotime ($loca->getFinloc());	
							// $dStart = $loca->getDebutloc();
							// $dStartsec = strtotime ($loca->getDebutloc());
							// $dEnd = $loca->getFinloc();

							//Si date début antérieure au début du mois >> date début = début mois
							// if($dStartsec <= $debutmoissec)
							// {
								// $dStart = $debutmois;
							// }
							//Si date fin posterieure à fin du mois >> date début = début mois
							// if($finlocsec >= $finmoissec)
							// {
								// $dEnd = $finmois;
							// }
							//Création du montant HT de la ligne
							if(null == $loca->getQuantite())
							{
								$quantite = 1;
							}
							else
							{
								$quantite = $loca->getQuantite();
							}
							$montantligne = $loca->getPu() * $quantite;
							$totalht += $montantligne;

							// $client = $em->getRepository('BaclooCrmBundle:Venda')
										// ->findOneById($venda->getClientid());					
							//On affecte chaque ligne à sa famille
							if($loca->getCodifvente() == 'vente')
							{
								$venteslignes += $montantligne;
								$descriptionvente[] = $loca->getDescription();
							}
							elseif($loca->getCodifvente() == 'entretien')
							{
								$entretienlignes += $montantligne;
								$descriptionentretien[] = $loca->getDescription();
							}
							elseif($loca->getCodifvente() == 'transport')
							{
								$transportlignes += $montantligne;
								$descriptiontransport[] = $loca->getDescription();
							}
							elseif($loca->getCodifvente() == 'annexes')
							{
								$annexeslignes += $montantligne;
								$descriptionannexe[] = $loca->getDescription();
							}
							elseif($loca->getCodifvente() == 'remise')
							{
							}
							elseif($loca->getCodifvente() == 'assurance')
							{
								$assurancelignes += $montantligne;
							}
							//Fin affectation ligne à sa famille
							
							$loca->setMontantvente($montantligne);
							$em->persist($loca);
							//$articles->getStockenr() = le stock avant l'enregistrement de la vente
							$articles = $em->getRepository('BaclooCrmBundle:Articlesenvente')
								->findOneBy(array('reffrs' => $loca->getRefarticle(), 'designation' => $loca->getDescription()));								

						}					
						$compteclient = '411'.$venda->getClientid();
// echo 'CODECONTRAT'.$codecontrat;
						//Avant de saisir les écritures on vérifie qu'elle n'aient pas déjà été saisies
						$facture = $em->getRepository('BaclooCrmBundle:Factures')
									->findOneByCodelocata($codecontrat);
						if(!isset($facture))
						{
							$new = 1;
							$facture = new Factures;
							$query = $em->createQuery(
								'SELECT b.compteurfac
								FROM BaclooCrmBundle:Factures b
								ORDER BY b.id DESC'
							)->setMaxResults(1);
							$lastnumfact = $query->getOneOrNullResult();
							if(empty($lastnumfact) or !isset($lastnumfact) or $lastnumfact == null)
							{
								$lastnumfact = 0;//echo 'vide';
							}
							else
							{
								$lastnumfact = $query->getSingleScalarResult();//echo 'pas vide';
							}
							$numfacture = date('Y').'V'.$lastnumfact++;							
						}
						else
						{
							$new = 0;
							$lastnumfact = $facture->getCompteurfac();	
							$numfacture = $facture->getNumfacture();	
						}
							$message = 0;										
							$client = $em->getRepository('BaclooCrmBundle:Fiche')
										->findOneById($venda->getClientid());
// echo 'NEW'.$new;						
						$v = 0;
						$e = 0;
						$t = 0;
						$ass = 0;
						$ann = 0;
							
								//Ajout à la table factures
									// $facta = $em->getRepository('BaclooCrmBundle:Facta')
												// ->findOneByControle('1234');

												
									$client = $em->getRepository('BaclooCrmBundle:Fiche')		
									 ->findOneById($venda->getClientid());
									 
									if($client->getDelaireglement() == 'comptant')
									{
										$next45 = $venda->getDate();
									}
									elseif($client->getDelaireglement() == '15JDF')
									{
										$next45 = date('Y-m-d', strtotime($venda->getDate() . '+15 days'));
									}
									elseif($client->getDelaireglement() == '30J')
									{
										$next45 = date('Y-m-d', strtotime($venda->getDate() . '+30 days'));
									}
									elseif($client->getDelaireglement() == '30JFM')
									{
										$date = date('Y-m-t', strtotime($venda->getDate()));
										$next45 = date('Y-m-d', strtotime($date . '+30 days'));
									}
									elseif($client->getDelaireglement() == '30JFM5')
									{
										$date = date('Y-m-t', strtotime($venda->getDate()));
										$next45 = date('Y-m-d', strtotime($date . '+35 days'));
									}
									elseif($client->getDelaireglement() == '30JFM10')
									{
										$date = date('Y-m-t', strtotime($venda->getDate()));
										$next45 = date('Y-m-d', strtotime($date . '+40 days'));
									}
									elseif($client->getDelaireglement() == '30JFM15')
									{
										$date = date('Y-m-t', strtotime($venda->getDate()));
										$next45 = date('Y-m-d', strtotime($date . '+45 days'));
									}
									elseif($client->getDelaireglement() == '30JDF5')
									{
										$next45 = date('Y-m-d', strtotime($venda->getDate() . '+35 days'));
									}
									elseif($client->getDelaireglement() == '30JDF20')
									{
										$next45 = date('Y-m-d', strtotime($venda->getDate() . '+50 days'));
									}
									elseif($client->getDelaireglement() == '45JDF')
									{
										$next45 = date('Y-m-d', strtotime($venda->getDate() . '+45 days'));
									}
									elseif($client->getDelaireglement() == '45JFM')
									{
										$date = date('Y-m-t', strtotime($venda->getDate()));
										$next45 = date('Y-m-d', strtotime($date . '+45 days'));
									}
									elseif($client->getDelaireglement() == '45JFM28')
									{
										$date = date('Y-m-t', strtotime($venda->getDate()));
										$next45 = date('Y-m-d', strtotime($date . '+76 days'));
									}
									elseif($client->getDelaireglement() == '60JDF')
									{
										$date = date('Y-m-t', strtotime($venda->getDate()));
										$next45 = date('Y-m-d', strtotime($date . '+45 days'));
									}
									elseif($client->getDelaireglement() == '60JFM')
									{
										$date = date('Y-m-t', strtotime($venda->getDate()));
										$next45 = date('Y-m-d', strtotime($date . '+60 days'));
									}
									elseif($client->getDelaireglement() == '60JFM10')
									{
										$date = date('Y-m-t', strtotime($venda->getDate()));
										$next45 = date('Y-m-d', strtotime($date . '+70 days'));
									}
									else
									{
										$next45 = $venda->getDate();
									}
						if($venda->getRemise() > 0)
						{echo 'REMIIIIIIIISE';
							$totalhtfac = $venda->getMontantvente() - ($venda->getMontantvente() * $venda->getRemise()/100);echo $totalhtfac;
						}
						else
						{echo 'PAAAASS REMISE';
							$totalhtfac = $venda->getMontantvente();
						}
						if($venda->getAcompte() > 0)
						{
							$totalhtfac = $venda->getMontantvente() - ($venda->getMontantvente() * $venda->getRemise()/100) - $venda->getAcompte()/1.2;
						}
						else
						{
							$totalhtfac = $venda->getMontantvente() - ($venda->getMontantvente() * $venda->getRemise()/100);
						}
// echo 'Echeance'.$next45;					
						$tva20 = $totalhtfac * 0.20;
						$totalttc = $totalhtfac + $tva20;										
									
									$facture->setNumfacture($numfacture);
									$facture->setCodelocata('V-'.$venda->getId());
									$facture->setClientid($venda->getClientid());
									$facture->setClient($venda->getClient());
									$facture->setTotalht($totalhtfac);
									if($client->getTypeclient() == 'export')
									{
										$facture->setTotalttc($totalhtfac);
									}
									else
									{
										$facture->setTotalttc($totalhtfac * 1.2);
									}
									$facture->setEcheance($next45);
									$facture->setChantier($venda->getClient());
									$facture->setReglement(0);
									$facture->setDatepaiement('');
									$facture->setDatecrea(date('Y-m-d'));
									// $facture->setModepaiement($client->getTypepaiement());
									$facture->setTypedoc('facture');
									if($mode != 'modif'){$facture->setDatecrea($today);}
									$facture->setCompteurfac($lastnumfact);
									$facture->setUser($venda->getUser());
									$facture->setLocatacloneid($venda->getId());
									$facture->setAnnee(date('Y'));
									if($new == 1)
									{
										// $facture->addFactum($facta);
										// $facta->addFacture($facture);
									}
									$em->persist($venda);
									$em->persist($facture);
									$em->flush();
								//Fin ajout table factures					
									
					}
					else{echo 'faut pas enregistrer les ventes';}					
				}
				
				
				
				return $this->redirect($this->generateUrl('bacloocrm_ventes', array('ficheid' => $ficheid, 'vendaid' => $vendaid)));
			}
		}	
		$factures = $em->getRepository('BaclooCrmBundle:Factures')		
					   ->findOneByCodelocata('V-'.$vendaid);
//echo 'ttoto';					   
		if(isset($factures)){$afac = 'ok';$numfacture = $factures->getNumfacture();}else{$afac = 'nok';$numfacture = 0;}
		//echo 'NUMFACTURE';echo $numfacture;
		$factures = $em->getRepository('BaclooCrmBundle:Factures')
			->findOneByCodelocata('V-'.$vendaid);
// echo '444444444444'.$client->getDelaireglement() ;			
		if(isset($factures))
		{//echo 'il a des factures';
			$proforma = 'ok';	
		}
		else
		{
			if($client->getDelaireglement() == 1)
			{
				$proforma = 'ok';
			}
			else
			{
				$proforma = 'ok';
			}

		}//echo'proforma'.$proforma;	
		return $this->render('BaclooCrmBundle:Crm:nouvelle_vente.html.twig', array('form' => $form->createView(),
																			'date' => $today,
																			'mode' => $mode,
																			'vendaid' => $vendaid,
																			'afac' => $afac,
																			'client' => $client,
																			'totalvente' => $totalvente,
																			'bdcrecu' => $bdcrecu,
																			'userdetails' => $userdetails,
																			'numfacture' => $numfacture,
																			'proforma' => $proforma,
																			'user' => $user
																			));
	}
	
	public function ventespdfAction($ficheid, $mode, $vendaid, Request $request)
	{
		$user = $this->get('security.context')->getToken()->getUsername(); if(empty($user) or !isset($user) or $user == 'anon.'){return $this->redirect($this->generateUrl('fos_user_security_login'));}
		$em = $this->getDoctrine()->getManager();
		$userdetails  = $em->getRepository('BaclooUserBundle:User')		
					   ->findOneByUsername($user);
		$today = date('Y-m-d');
		
		$client  = $em->getRepository('BaclooCrmBundle:Fiche')		
					   ->findOneById($ficheid);	
					   
		if($vendaid == 0)
		{
			$venda = new Venda;			
			$totalvente = 0;
			$bdcrecu = 0;
		}
		else
		{
			$venda = $em->getRepository('BaclooCrmBundle:Venda')
						->findOneById($vendaid);
			$bdcrecu = $venda->getBdcrecu();
			//FACTURATION
			$montantvente = 0;			
			$totalvente = 0;			
			foreach($venda->getVentes() as $ven)
			{
				$montantvente = $ven->getQuantite() * $ven->getPu();
				$totalvente += $ven->getQuantite() * $ven->getPu();
				
				$ven->setMontantvente($montantvente);
				$em->persist($ven);
				$em->flush();
			}	
			$venda->setMontantvente($totalvente);
			$em->persist($venda);
			$em->flush();
			//FIN FACTURATION
		}

		$pdf = $this->get("white_october.tcpdf")->create();
		
        $html = $this->renderView('BaclooCrmBundle:Crm:nouvelle_ventepdf.html.twig', array('date' => $today,
																			'vendaid' => $vendaid,
																			'client' => $client,
																			'totalvente' => $totalvente,
																			'bdcrecu' => $bdcrecu,
																			'venda' => $venda,
																			'mode' => $mode,
																			'userdetails' => $userdetails,
																			'user' => $user
																			));
		$pdf->SetFont('helvetica', '', 9, '', true);
		// set margins
		$pdf->SetMargins(13, '10', '5', '0');
		// SetMargins($left,$top,$right = -1,$keepmargins = false)
        $pdf->AddPage();
		
		// -- set new background ---

		// get the current page break margin
		$bMargin = $pdf->getBreakMargin();
		// get current auto-page-break mode
		$auto_page_break = $pdf->getAutoPageBreak();
		// disable auto-page-break
		$pdf->SetAutoPageBreak(false, 0);
		// set bacground image
		$img_file = K_PATH_IMAGES.'ventetemplate.jpg';
		$pdf->Image($img_file, 0, 0, 210, 297, 'JPG', '', '', false, 300, '', false, false, 0);
		// restore auto-page-break status
		$pdf->SetAutoPageBreak($auto_page_break, $bMargin);
		// set the starting point for the page content
		$pdf->setPageMark();		
		
        $pdf->writeHTML($html, true, false, true, false, '');
        $pdf->lastPage();
 
        $response = new Response($pdf->Output('file.pdf'));
        $response->headers->set('Content-Type', 'application/pdf');
 
        return $response;
	}	
	
	public function avoirlocAction($locid, $message, $numavoir, $numfacture, Request $request)
	{
		$usersess = $this->get('security.context')->getToken()->getUsername();
		$today = date('Y-m-d');
//echo 'numavoir'.$numavoir;	
//echo 'numfacture'.$numfacture;	

		$em = $this->getDoctrine()->getManager();
		if($numfacture == 0)
		{
			$lavoir = $em->getRepository('BaclooCrmBundle:Factures')
				->findOneByNumfacture($numavoir);		
			$lafacturedor = $em->getRepository('BaclooCrmBundle:Factures')
				->findOneBy(array('locatacloneid' => $lavoir->getLocatacloneid(), 'typedoc' => 'facture'));
			$numfacture = $lafacturedor->getNumfacture();
		}		
		$locata = $em->getRepository('BaclooCrmBundle:Locataclone')
			->findOneById($locid);	
		
		$numfacturedor = $numfacture;
// echo $locid;
// echo $locata->getId();	
// echo $locata->getClientid();	
		//On dessine notre formulaire indépendant
		$defaultData = array();
		$form = $this->createFormBuilder($defaultData)
			->add('avoirtotal', 'checkbox', array('required' => false))
			->add('montantavoirpartiel', 'number', array('required' => false))
			->add('commentaire', 'textarea', array('required' => true))
			->getForm();

		$form->handleRequest($request);
		if($form->isValid()) {
			$data = $form->getData();
			$avoirtotal = $data['avoirtotal'];
			$montantavoirpartiel = $data['montantavoirpartiel'];
			$commentaire = $data['commentaire'];
			$client = $em->getRepository('BaclooCrmBundle:Fiche')
						->findOneById($locata->getClientid());	
						
			//On calcul les montants dont on aura besoin
			if($avoirtotal == 1)
			{
				//Si avoir Total
				
				//On débite le compte assurance si assurance facturé
				if($locata->getAssurance() == 1)
				{
					$totalhthorsass = $locata->getMontantloc() + $locata->getContributionverte() + $locata->getTransportaller() + $locata->getTransportretour() + $locata->getMontantcarb();
					$assurance = $locata->getAssurance();
					$totalht = $totalhthorsass + $assurance;
				}
				else
				{
					$assurance = 0;
					$totalht = $locata->getMontantloc() + $locata->getContributionverte() + $locata->getAssurance() + $locata->getTransportaller() + $locata->getTransportretour() + $locata->getMontantcarb();					
				}
				if($client->getTypeclient() == 'france')
				{				
					$tva = $totalht * 0.20;
					$totalttc = $totalht + $tva;
				}
				else
				{
					$tva = 0;
					$totalttc = $totalht;
				}
			}
			else
			{
				//Si avoir partiel
				$totalht = $montantavoirpartiel;
				
				if($client->getTypeclient() == 'france')
				{
					$tva = $montantavoirpartiel*0.20;
					$totalttc = $totalht + $tva;
				}
				else
				{
					$tva = 0;
					$totalttc = $totalht + $tva;
				}
				
				if($locata->getAssurance() == 1)
				{							
					$totalhthorsass = $totalht/1.1;				
					$assurance = $totalht - $totalhthorsass;
				}
				else
				{							
					$totalhthorsass = $totalht;				
					$assurance = 0;					
				}
			}
			
			if($numavoir == 0)
			{	echo 'ici';			
				$facture = new Factures;
				
				$query = $em->createQuery(
					'SELECT b.compteurfac
					FROM BaclooCrmBundle:Factures b
					ORDER BY b.id DESC'
				)->setMaxResults(1);
				// $lastnumfact = $query->getResult();
				// if(empty($lastnumfact)){$lastnum = 0;}
				// else{foreach($lastnumfact as $last){$lastnum = $last['id'];}}
				$lastnumfact = $query->getOneOrNullResult();
				if(empty($lastnumfact) or !isset($lastnumfact) or $lastnumfact == null)
				{
					$lastnumfact = 0;//echo 'vide';
				}
				else
				{
					$lastnumfact = $query->getSingleScalarResult();//echo 'pas vide';
				}
				$numfacture = date('Y').($lastnumfact++);				
			}
			else
			{echo 'laaaa';
				$facture = $em->getRepository('BaclooCrmBundle:Factures')
							->findOneByNumfacture($numavoir);	
				$numfacture = $numavoir;
			}
						
			//avant de passer les écritures on vérifie qu'elles n'existent pas deja dans le journalori
			$compteclient = '411'.$locata->getClientid();
			$journalori = $em->getRepository('BaclooCrmBundle:Afacturer')
							->findOneBy(array('compte'=>$compteclient, 'credit'=>$totalttc, 'piece'=>$locata->getId()));	
							
			//Si opréation déjà passée alerter l'utilisateur et bloquer sinon passer
			if(!empty($journalori))
			{
				$message = 1; //Vous avez déjà passé cette écriture le ...
				return $this->redirect($this->generateUrl('bacloocrm_avoirloc', array('locid' => $locata->getId(), 'message' => $message)));
			}
			else
			{
				//On passe les écritures
				
				//On débite le compte 700 utilisé				
				$ftotalht = new Afacturer;
				$ftotalht->setDate($today);
				$ftotalht->setJournal('VT');
				if($client->getTypeclient() == 'france')
				{
					$ftotalht->setCompte(706100);		
				}
				elseif($client->getTypeclient() == 'ue')
				{
					$ftotalht->setCompte(706110);		
				}
				elseif($client->getTypeclient() == 'export')
				{
					$ftotalht->setCompte(706115);		
				}else{$ftotalht->setCompte(9999999);}
				$ftotalht->setDebit($totalht);			
				$ftotalht->setCredit(0);			
				$ftotalht->setLibelle('Avoir sur facture n°'.$numfacture);			
				$ftotalht->setPiece($numfacture);				
				$ftotalht->setEcheance(date('Y-m-d'));			
				$ftotalht->setAnalytique('Loc');
				$em->persist($ftotalht);
				
				//On débite le compte assurance si assurance facturé
				if($locata->getAssurance() == 1)
				{
					$fassurance= new Afacturer;
					$fassurance->setDate($today);
					$fassurance->setJournal('VT');
					if($client->getTypeclient() == 'france')
					{
						$fassurance->setCompte(706200);			
						$fassurance->setLibelle('Assurance France');
					}
					elseif($client->getTypeclient() == 'ue')
					{
						$fassurance->setCompte(706201);			
						$fassurance->setLibelle('Assurance UE');		
					}
					elseif($client->getTypeclient() == 'export')
					{
						$fassurance->setCompte(706202);			
						$fassurance->setLibelle('Assurance Export');		
					}
					$fassurance->setDebit($assurance);			
					$fassurance->setCredit(0);			
					$fassurance->setPiece($numfacture);				
					$fassurance->setEcheance(date('Y-m-d', strtotime("+45 days")));			
					$fassurance->setAnalytique('Assurance');
					$em->persist($fassurance);					
				}
				
				//On débite le compte TVA si client france
				if($client->getTypeclient() == 'france')
				{
					$ftva = new Afacturer;
					$ftva->setDate($today);
					$ftva->setJournal('VT');
					$ftva->setCompte(445710);
					$ftva->setDebit($tva);			
					$ftva->setCredit(0);			
					$ftva->setLibelle('TVA collectée');			
					$ftva->setPiece($numfacture);				
					$ftva->setEcheance(date('Y-m-d'));			
					$ftva->setAnalytique('Tva');
					$em->persist($ftva);						
				}				
				
				//On crédite 411
				$afacturer = new Afacturer;
				$afacturer->setDate($today);
				$afacturer->setJournal('VT');
				$afacturer->setCompte($compteclient);
				$afacturer->setDebit(0);
				if($client->getTypeclient() != 'france')
				{					
					$afacturer->setCredit($totalht);	
				}
				else
				{	
					$afacturer->setCredit($totalttc);
				}					
				$afacturer->setLibelle($locata->getClient());			
				$afacturer->setPiece($numfacture);			
				$afacturer->setEcheance(date('Y-m-d', strtotime("+45 days")));			
				$afacturer->setAnalytique('Client');
				$em->persist($afacturer);
				$em->flush();
			}
			//Ajout à la table factures
			// $facta = $em->getRepository('BaclooCrmBundle:Facta')
						// ->findOneByControle('1234');


			
			$client = $em->getRepository('BaclooCrmBundle:Fiche')		
			 ->findOneById($locata->getClientid());
			if($client->getDelaireglement() == 1)
			{
				$next45 = $locata->getDatemodif();
			}
			elseif($client->getDelaireglement() == 2)
			{
				$next45 = date('Y-m-d', strtotime($locata->getDatemodif() . '+45 days'));
			}
			elseif($client->getDelaireglement() == 3)
			{
				$next45 = date('Y-m-d', strtotime($locata->getDatemodif() . '+30 days'));
			}
			
			$facture->setNumfacture($numfacture);
			$facture->setCodelocata($locata->getOldid());
			$facture->setClientid($locata->getClientid());
			$facture->setClient($locata->getClient());
			$facture->setTotalht($totalht);
			$facture->setTotalttc($totalttc);
			$facture->setEncompta(1);
			if($client->getTypeclient() != 'france')
			{					
				$afacturer->setCredit($totalht);	
			}
			else
			{	
				$afacturer->setCredit($totalttc);
			}
			$facture->setEcheance($next45);
			// $facture->setDebutloc($locata->getDebutloc());
			// $facture->setFinloc($locata->getFinloc());
			$facture->setChantier($locata->getNomchantier());
			$facture->setReglement(1);
			$facture->setDatepaiement('');
			$facture->setModepaiement('');
			$facture->setTypedoc('avoir');
			$facture->setDatecrea($today);
			if($numavoir == 0)
			{			
				$facture->setCompteurfac($lastnumfact++);				
			}
			else
			{echo 'laaaa';
				$facture->setCompteurfac($facture->getCompteurfac());
			}
			$facture->setUser($locata->getUser());
			$facture->setLocatacloneid($locata->getId());
			$facture->setCommentaire($commentaire);
			$facture->setAnnee(date('Y'));
			if($numavoir == 0)
			{
				// $facture->addFactum($facta);
				// $facta->addFacture($facture);
			}
			if($avoirtotal == 1)
			{
				$facturedor = $em->getRepository('BaclooCrmBundle:Factures')
							->findOneByNumfacture($numfacturedor);
				$facturedor->setReglement(1);
				$facturedor->setMontantavoir($facturedor->getMontantavoir() + $totalttc);
				$facturedor->setCommentaire('Facture annulée par l\'avoir n°'.$numavoir);
				$em->persist($facturedor);
			}
			else
			{
				$facturedor = $em->getRepository('BaclooCrmBundle:Factures')
							->findOneByNumfacture($numfacturedor);
				$facturedor->setMontantavoir($facturedor->getMontantavoir() + $totalttc);
				$facturedor->setCommentaire('Avoir n°'.$numavoir.' réalisé pour un montant de ttc de '.$totalttc.' €');
				$em->persist($facturedor);		
			}
			$em->persist($facture);
			$em->flush();
			//Fin ajout table factures
				
			return $this->redirect($this->generateUrl('bacloocrm_avoirloc', array('locid' => $locata->getId(), 'numavoir'=> $numavoir, 'numfacture' => $numfacture, 'message' => 2)));//Avoir enregistré
		}	
		if($numavoir == 0)
		{
			$avoirtotal = 0;
			$montantavoirpartiel = 0;
			$commentaire = 0;
		}
		else
		{
			// echo 'numavoir'.$numavoir;	
			$avoir = $em->getRepository('BaclooCrmBundle:Factures')
						->findOneByNumfacture($numavoir);
// echo $avoir->getTotalht();						
			$facturedor = $em->getRepository('BaclooCrmBundle:Factures')
				->findOneBy(array('locatacloneid' => $avoir->getLocatacloneid(), 'typedoc' => 'facture', 'chantier' =>  $avoir->getChantier())); 	
			if($avoir->getTotalht() == $facturedor->getTotalht())
			{
				$avoirtotal = 1;
				$montantavoirpartiel = $avoir->getTotalht();
				$commentaire = $avoir->getCommentaire();
			}
			else
			{
				$avoirtotal = 0;
				$montantavoirpartiel = $avoir->getTotalht();
				$commentaire = $avoir->getCommentaire();
			}
// echo $commentaire;			
// echo $avoirtotal;			
		}
		$previous = $this->get('request')->server->get('HTTP_REFERER');
		return $this->render('BaclooCrmBundle:Crm:avoirloc.html.twig', array('form' => $form->createView(),
																	'locata' => $locata,
																	'message' => $message,
																	'previous' => $previous,
																	'avoirtotal' => $avoirtotal,
																	'montantavoirpartiel' => $montantavoirpartiel,
																	'commentaire' => $commentaire,
																	'numavoir' => $numavoir,
																	'numfacture' => $numfacture,
																	'ficheid' => $locata->getClientid()
																	));		
	}
		
	public function avoirventesAction($vendaid, $message, $numavoir, $numfacture, Request $request)
	{//echo $numavoir;
		$usersess = $this->get('security.context')->getToken()->getUsername();
		$today = date('Y-m-d');
		$em = $this->getDoctrine()->getManager();
 // echo 'numfacture'.$numfacture;
		if($numfacture == 0)
		{
			$facturedorigine = $em->getRepository('BaclooCrmBundle:Factures')
			->findOneByLocatacloneid($vendaid);
			$numfacture = $facturedorigine->getNumfacture();
		}	
		$numfacturedor = $numfacture;
		
		//On recupère les infos de la vente
		$venda = $em->getRepository('BaclooCrmBundle:Venda')
			->findOneById($vendaid);
	
		//On dessine notre formulaire indépendant
		$defaultData = array();
		$form = $this->createFormBuilder($defaultData)
			->add('avoirtotal', 'checkbox', array('required' => false))
			->add('montantavoirpartiel', 'number', array('required' => false))
			->add('commentaire', 'textarea', array('required' => true))
			->add('vente', 'number', array('required' => false))
			->add('entretien', 'number', array('required' => false))
			->add('transport', 'number', array('required' => false))
			->add('assurance', 'number', array('required' => false))
			->add('paa', 'number', array('required' => false))
			->getForm();

		$form->handleRequest($request);
		if($form->isValid()) {
			$data = $form->getData();
			$avoirtotal = $data['avoirtotal'];
			$montantavoirpartiel = $data['montantavoirpartiel'];
			$commentaire = $data['commentaire'];
			$venteht = $data['vente'];
			$entretienht = $data['entretien'];
			$transportht = $data['transport'];
			$assuranceht = $data['assurance'];
			$paaht = $data['paa'];
			$client = $em->getRepository('BaclooCrmBundle:Fiche')
						->findOneById($venda->getClientid());	
						
			//On calcul les montant dont on aura besoin
			if(isset($avoirtotal) && $avoirtotal == 1)
			{
				//Si avoir Total
				$totalht = $venda->getMontantvente();
				if($client->getTypeclient() == 'france')
				{
					//Faire une boucle pour recup montantht chaque compte 7
					$venteht = 0;
					$entretienht = 0;
					$transportht = 0;
					$assuranceht = 0;
					$paaht = 0;					
					foreach($venda->getVentes() as $vente)
					{
						if($vente->getCodifvente() == 'vente')
						{
							$venteht += $vente->getMontantvente();
						}
						if($vente->getCodifvente() == 'entretien')
						{
							$entretienht += $vente->getMontantvente();
						}
						if($vente->getCodifvente() == 'transport')
						{
							$transportht += $vente->getMontantvente();
						}
						if($vente->getCodifvente() == 'annexes')
						{
							$paaht += $vente->getMontantvente();
						}
						if($vente->getCodifvente() == 'assurance')
						{
							$assuranceht += $vente->getMontantvente();
						}				
						$tva = $totalht * 0.20;
						$totalttc = $totalht + $tva;
					}					
				}
				else
				{
					$tva = 0;
					$venteht = $venteht;
					$entretienht = $entretienht;
					$transportht = $transportht;
					$assuranceht = $assuranceht;
					$paaht = $paaht;
					$totalttc = $totalht;	
				}
			}
			else
			{
				//Si avoir partiel				
				$totalht = $venteht + $entretienht + $transportht + $assuranceht + $paaht;				
				if($client->getTypeclient() == 'france')
				{
					$totalttc = $totalht*1.2;
					$tva = $totalttc - $totalht;
					$ventettc = $venteht*1.2;
					$entretienttc = $entretienht*1.2;
					$transportttc = $transportht*1.2;
					$assurancettc = $assuranceht*1.2;
					$paattc = $paaht*1.2;
				}
				else
				{
					$totalttc = $totalht;
					$tva = 0;
					$venteht = $venteht;
					$entretienht = $entretienht;
					$transportht = $transportht;
					$assuranceht = $assuranceht;
					$paaht = $paaht;
				}
			}
			
			//avant de passer les écritures on vérifie qu'elles n'existent pas deja dans le journalori
			$compteclient = '411'.$venda->getClientid();
			$journalori = $em->getRepository('BaclooCrmBundle:Afacturer')
							->findOneBy(array('compte'=>$compteclient, 'credit'=>$totalttc, 'piece'=>'V-'.$venda->getId()));	
							
			//Si opréation déjà passée alerter l'utilisateur et bloquer sinon passer
			if(!empty($journalori))
			{
				$message = 1; //Vous avez déjà passé cette écriture le ...
				return $this->redirect($this->generateUrl('bacloocrm_avoirventes', array('vendaid' => $venda->getId(), 'message' => $message)));
			}
			else
			{
				$venteht1 = 0;
				$entretienht1 = 0;
				$transportht1 = 0;
				$assuranceht1 = 0;
				$paaht1 = 0;	
				//On récupère les montants ht de chaque compte 7
				foreach($venda->getVentes() as $vente)
				{
					if($vente->getCodifvente() == 'vente')
					{
						$venteht1 += $vente->getMontantvente();
					}
					if($vente->getCodifvente() == 'entretien')
					{
						$entretienht1 += $vente->getMontantvente();
					}
					if($vente->getCodifvente() == 'transport')
					{
						$transportht1 += $vente->getMontantvente();
					}
					if($vente->getCodifvente() == 'annexes')
					{
						$paaht1 += $vente->getMontantvente();
					}
					if($vente->getCodifvente() == 'assurance')
					{
						$assuranceht1 += $vente->getMontantvente();
					}
				}					
				//On passe les écritures
				
				//On débite le compte 700 utilisé
				//On débite le compte vente 707
				if(isset($venteht) && $venteht > 0 && isset($venteht1))
				{
					if($venteht <= ($totalht))
					{
						$ventes = new Afacturer;
						$ventes->setDate($today);
						$ventes->setJournal('VT');
						if($client->getTypeclient() == 'france')
						{
							$ventes->setCompte(707100);		
						}
						elseif($client->getTypeclient() == 'ue')
						{
							$ventes->setCompte(707110);		
						}
						elseif($client->getTypeclient() == 'export')
						{
							$ventes->setCompte(707115);		
						}else{$ventes->setCompte(9999999);}
						$ventes->setDebit($venteht);			
						$ventes->setCredit(0);			
						$ventes->setLibelle($venda->getClient());			
						$ventes->setPiece($numavoir);				
						$ventes->setEcheance(date('Y-m-d'));			
						$ventes->setAnalytique('Vente');
						$em->persist($ventes);					
					}
					else
					{
						return $this->redirect($this->generateUrl('bacloocrm_avoirventes', array('vendaid' => $venda->getId(), 'message' => 3)));//Le montant saisi ne doit pas être supérieur au montant ci-dessus.(montant d'origine)
					}
				}
				
				//on débite le compte entretien 706
				if(isset($entretienht) && $entretienht > 0 && isset($entretienht1))
				{
					if($entretienht <= ($totalht))
					{
						$entretien = new Afacturer;
						$entretien->setDate($today);
						$entretien->setJournal('VT');
						if($client->getTypeclient() == 'france')
						{
							$entretien->setCompte(706220);		
						}
						elseif($client->getTypeclient() == 'ue')
						{
							$entretien->setCompte(706221);		
						}
						elseif($client->getTypeclient() == 'export')
						{
							$entretien->setCompte(706222);		
						}else{$entretien->setCompte(9999999);}
						$entretien->setDebit($entretienht);			
						$entretien->setCredit(0);			
						$entretien->setLibelle($venda->getClient());			
						$entretien->setPiece($numavoir);				
						$entretien->setEcheance(date('Y-m-d'));			
						$entretien->setAnalytique('Entretien');
						$em->persist($entretien);						
					}
					else
					{
						return $this->redirect($this->generateUrl('bacloocrm_avoirventes', array('vendaid' => $venda->getId(), 'message' => 3)));//Le montant saisi ne doit pas être supérieur au montant ci-dessus.(montant d'origine)
					}
				}
				
				//On débite le compte transport 706
				if(isset($transportht) && $transportht > 0 && isset($transportht1))
				{
					if($transportht <= ($totalht))
					{
						$transport = new Afacturer;
						$transport->setDate($today);
						$transport->setJournal('VT');
						if($client->getTypeclient() == 'france')
						{
							$transport->setCompte(706210);		
						}
						elseif($client->getTypeclient() == 'ue')
						{
							$transport->setCompte(706211);		
						}
						elseif($client->getTypeclient() == 'export')
						{
							$transport->setCompte(706212);		
						}else{$transport->setCompte(9999999);}
						$transport->setDebit($transportht);			
						$transport->setCredit(0);			
						$transport->setLibelle($venda->getClient());			
						$transport->setPiece($numavoir);				
						$transport->setEcheance(date('Y-m-d'));			
						$transport->setAnalytique('transport');
						$em->persist($transport);
					}
					else
					{
						return $this->redirect($this->generateUrl('bacloocrm_avoirventes', array('vendaid' => $venda->getId(), 'message' => 3)));//Le montant saisi ne doit pas être supérieur au montant ci-dessus.(montant d'origine)
					}
				}
				
				//On débite le compte assurance si assurance facturé								
				if(isset($assuranceht) && $assuranceht  > 0 && isset($assuranceht1) && $assuranceht <= ($totalht))
				{
					$fassurance= new Afacturer;
					$fassurance->setDate($today);
					$fassurance->setJournal('VT');
					if($client->getTypeclient() == 'france')
					{
						$fassurance->setCompte(706200);			
						$fassurance->setLibelle('Assurance France');
					}
					elseif($client->getTypeclient() == 'ue')
					{
						$fassurance->setCompte(706201);			
						$fassurance->setLibelle('Assurance UE');		
					}
					elseif($client->getTypeclient() == 'export')
					{
						$fassurance->setCompte(706202);			
						$fassurance->setLibelle('Assurance Export');		
					}
					$fassurance->setDebit($assuranceht);			
					$fassurance->setCredit(0);			
					$fassurance->setPiece($numavoir);				
					$fassurance->setEcheance(date('Y-m-d', strtotime("+45 days")));			
					$fassurance->setAnalytique('Assurance');
					$em->persist($fassurance);
					$em->flush();					
				}
				
				//On débite le compte TVA si client france
				if($client->getTypeclient() == 'france')
				{
					$ftva = new Afacturer;
					$ftva->setDate($today);
					$ftva->setJournal('VT');
					$ftva->setCompte(445710);
					$ftva->setDebit($tva);			
					$ftva->setCredit(0);			
					$ftva->setLibelle('TVA collectée');			
					$ftva->setPiece($numavoir);				
					$ftva->setEcheance(date('Y-m-d'));			
					$ftva->setAnalytique('Tva');
					$em->persist($ftva);
					$em->flush();						
				}				
				
				//On crédite 411
				$afacturer = new Afacturer;
				$afacturer->setDate($today);
				$afacturer->setJournal('VT');
				$afacturer->setCompte($compteclient);
				$afacturer->setDebit(0);			
				if($client->getTypeclient() != 'france')
				{					
					$afacturer->setCredit($totalht);	
				}
				else
				{	
					$afacturer->setCredit($totalttc);
				}			
				$afacturer->setLibelle($venda->getClient());			
				$afacturer->setPiece($numavoir);			
				$afacturer->setEcheance(date('Y-m-d', strtotime("+45 days")));			
				$afacturer->setAnalytique('Client');
				$em->persist($afacturer);

			//Ajout à la table factures
				// $facta = $em->getRepository('BaclooCrmBundle:Facta')
							// ->findOneByControle('1234');
// echo 'uuuuuuuuuuuu';
				if($numavoir == 0)
				{	//echo 'ici';			
					$facture = new Factures;
					
					$query = $em->createQuery(
						'SELECT b.compteurfac
						FROM BaclooCrmBundle:Factures b
						WHERE b.typedoc != :typedoc
						ORDER BY b.id DESC'
					)->setMaxResults(1);
					// $lastnumfact = $query->getResult();
					// if(empty($lastnumfact)){$lastnum = 0;}
					// else{foreach($lastnumfact as $last){$lastnum = $last['id'];}}
					$lastnumfact = $query->getOneOrNullResult();
					if(empty($lastnumfact) or !isset($lastnumfact) or $lastnumfact == null)
					{
						$lastnumfact = 0;//echo 'vide';
					}
					else
					{
						$lastnumfact = $query->getSingleScalarResult();//echo 'pas vide';
					}
					$numfacture = date('Y').($lastnumfact++);				
				}
				else
				{
					$facture = $em->getRepository('BaclooCrmBundle:Factures')
								->findOneByNumfacture($numavoir);	
					$numfacture = $numavoir;
					$lastnumfact = $facture->getCompteurfac();
				}

				
				$afacturer->setPiece($numfacture);
				if($client->getTypeclient() == 'france')
				{		
					$ftva->setPiece($numfacture);		
				}
				if(isset($assuranceht) && $assuranceht  > 0 && isset($assuranceht1) && $assuranceht <= ($totalht))
				{			
					$fassurance->setPiece($numfacture);					
				}
				if(isset($transportht) && $transportht > 0 && isset($transportht1))
				{
					if($transportht <= ($totalht))
					{			
						$transport->setPiece($numfacture);
					}
				}
				if(isset($entretienht) && $entretienht > 0 && isset($entretienht1))
				{
					if($entretienht <= ($totalht))
					{		
						$entretien->setPiece($numfacture);					
					}
				}
				if(isset($venteht) && $venteht > 0 && isset($venteht1))
				{
					if($venteht <= ($totalht))
					{		
						$ventes->setPiece($numfacture);				
					}
				}
							
				$client = $em->getRepository('BaclooCrmBundle:Fiche')		
				 ->findOneById($venda->getClientid());
				if($client->getDelaireglement() == 1)
				{
					$next45 = $venda->getDate();
				}
				elseif($client->getDelaireglement() == 2)
				{
					$next45 = date('Y-m-d', strtotime($venda->getDate() . '+45 days'));
				}
				elseif($client->getDelaireglement() == 3)
				{
					$date = date('Y-m-t', strtotime($venda->getDate()));
					$next45 = date('Y-m-d', strtotime($date . '+30 days'));
				}
				
				$facture->setNumfacture($numfacture);
				$facture->setCodelocata('V-'.$venda->getId());
				$facture->setClientid($venda->getClientid());
				$facture->setClient($venda->getClient());
				$facture->setTotalht($totalht);
				$facture->setTotalttc($totalttc);
				$facture->setEcheance($next45);
				$facture->setChantier($venda->getClient());
				$facture->setReglement(1);
				$facture->setEncompta(1);
				$facture->setCommentaire($commentaire);
				$facture->setDatepaiement(date('Y-m-d'));
				$facture->setModepaiement('');
				$facture->setTypedoc('avoir');
				$facture->setDatecrea($today);
				$facture->setCompteurfac($lastnumfact);
				$facture->setUser($venda->getUser());
				$facture->setLocatacloneid($venda->getId());
				if($numavoir == 0)
				{
					// $facture->addFactum($facta);
					// $facta->addFacture($facture);
				}
			
				if($avoirtotal == 1)
				{
					$facturedor = $em->getRepository('BaclooCrmBundle:Factures')
								->findOneByNumfacture($numfacturedor);
					$facturedor->setReglement(1);
					$facturedor->setMontantavoir($totalttc);
					$facturedor->setCommentaire('Facture annulée par l\'avoir n°'.$numavoir);
					$em->persist($facturedor);
					$em->flush();
				}
				else
				{echo 'numfacturedor'.$numfacturedor;
					$facturedor = $em->getRepository('BaclooCrmBundle:Factures')
								->findOneByNumfacture($numfacturedor);
					$facturedor->setMontantavoir($totalttc);
					$facturedor->setCommentaire('Avoir n°'.$numavoir.' réalisé pour un montant de ttc de '.$totalttc.' €');
					$em->persist($facturedor);
					$em->flush();			
				}				
				$em->persist($facture);
				$em->flush();
				//Fin ajout table factures				
			}
			return $this->redirect($this->generateUrl('bacloocrm_avoirventes', array('vendaid' => $vendaid, 'message' => 2, 'numavoir' => $numavoir, 'numfacture' => $numfacture)));//Avoir enregistré
		}

		if($numavoir == 0)
		{
			$avoirtotal = 0;
			$montantavoirpartiel = 0;
			$commentaire = 0;
		}
		else
		{
			// echo 'numavoir'.$numavoir;	
			$avoir = $em->getRepository('BaclooCrmBundle:Factures')
						->findOneByNumfacture($numavoir);
// echo $avoir->getTotalht();						
			$facturedor = $em->getRepository('BaclooCrmBundle:Factures')
				->findOneBy(array('locatacloneid' => $avoir->getLocatacloneid(), 'typedoc' => 'facture', 'chantier' =>  $avoir->getChantier())); 	
			if($avoir->getTotalht() == $facturedor->getTotalht())
			{
				$avoirtotal = 1;
				$montantavoirpartiel = $avoir->getTotalht();
				$commentaire = $avoir->getCommentaire();
			}
			else
			{
				$avoirtotal = 0;
				$montantavoirpartiel = $avoir->getTotalht();
				$commentaire = $avoir->getCommentaire();
			}
// echo $commentaire;			
// echo $avoirtotal;			
		}
		$previous = $this->get('request')->server->get('HTTP_REFERER');		
		return $this->render('BaclooCrmBundle:Crm:avoirventes.html.twig', array('form' => $form->createView(),
																	'venda' => $venda,
																	'message' => $message,
																	'previous' => $previous,
																	'avoirtotal' => $avoirtotal,
																	'montantavoirpartiel' => $montantavoirpartiel,
																	'commentaire' => $commentaire,
																	'numavoir' => $numavoir,
																	'numfacture' => $numfacture,
																	'ficheid' => $venda->getClientid(),
																	'message' => $message
																	));		
	}
	
	public function proformaAction($codecontrat, $mode, $message)
	{
		$usersess = $this->get('security.context')->getToken()->getUsername();
		$today = date('Y-m-d');
		$em = $this->getDoctrine()->getManager();		

		//nous établissons 2 modes : prévisualisation, avanceacompta
		//Prévisualisation : pour un client qui veut une proforma sans paiement d'avanceacompta
		//Prévisualisation : client en paiement d'avance dont les ecritures ont deja été passées
		//avanceacompta : client en paiement d'avance pour lequel il faut passer les écritures
// echo $codecontrat;		
		//On regarde dans les factures si deja compta
		$factures = $em->getRepository('BaclooCrmBundle:Factures')
			->findOneByCodelocata($codecontrat);
		if($message == 'vente')
		{			
			$locata = $em->getRepository('BaclooCrmBundle:Venda')
				->findOneById($codecontrat);
		}
		else
		{			
			$locata = $em->getRepository('BaclooCrmBundle:Locata')
				->findOneById($codecontrat);
		}
			echo 'message'.$message;
		//On récupère les infos client
		$client = $em->getRepository('BaclooCrmBundle:Fiche')
			->findOneById($locata->getClientid());		
			
		if(isset($factures) && $mode == 'previsualisation')
		{
			//Redirection vers la prévisualisation de la facture
			return $this->redirect($this->generateUrl('bacloocrm_ajouterlocationpdf', array('ficheid' => $client->getId(), 'locid' => $codecontrat, 'mode' => 'proforma')));	
		}
		elseif(!isset($factures) && $mode == 'previsualisation')
		{
			//Redirection vers la prévisualisation de la facture
			return $this->redirect($this->generateUrl('bacloocrm_ajouterlocationpdf', array('ficheid' => $client->getId(), 'locid' => $codecontrat, 'mode' => 'proforma')));			
		}
		elseif(!isset($factures) && $client->getDelaireglement() == 1 && $mode == 'avanceacompta')
		{
			//Passage des écritures et prévisualisation de la facture
			include('facturationcomptantloc.php');
			$message = 1; //Création proforma ok
			return $this->redirect($this->generateUrl('bacloocrm_proforma', array('codecontrat' => $codecontrat, 'mode' => 'all', 'message' => $message, 'date' => $today)));	
		}
		return $this->render('BaclooCrmBundle:Crm:proforma.html.twig', array(
																	'message' => $message,
																	'ficheid' => $client->getId(),
																	'locid' => $codecontrat
																	));
	}

	public function impressionfacturesAction($codecontrat, $clientid, $numlocatavente, $mode, $numfacture)
	{
		$em = $this->getDoctrine()->getManager();
		// echo $numlocatavente; 
		 // echo 'codecontrat'.$codecontrat;  
		$clients  = $em->getRepository('BaclooCrmBundle:Fiche')		
		   ->findOneById($clientid);
		   
		$machines = $em->getRepository('BaclooCrmBundle:Machines')		
		   ->findAll();
		   
		$machinessl = $em->getRepository('BaclooCrmBundle:Machinessl')		
		   ->findAll();
			
		$facture  = $em->getRepository('BaclooCrmBundle:Factures')		
		   ->findOneByNumfacture($numfacture);		
	if($numlocatavente[0] == 'V')
	{//echo 'iiiiu';
		// $codelocata = substr($codelocata, 2); //On envlève le V-
		$locata = $em->getRepository('BaclooCrmBundle:Venda')		
		   ->findOneByid($codecontrat);
		   $type = 'vente';	   
		
		if($mode == 'avoir')
		{//echo 'ici';	
			$facturedor = $em->getRepository('BaclooCrmBundle:Factures')
				->findOneBy(array('locatacloneid' => $facture->getLocatacloneid(), 'typedoc' => 'facture', 'chantier' =>  $facture->getChantier())); 	
		}
		else
		{//echo 'laaaa';
			$facturedor = 0;
		}
	}
	else
	{//echo 'tttt';
		$locata = $em->getRepository('BaclooCrmBundle:Locataclone')		
		   ->findOneByid($codecontrat);	
		   $type = 'loc';   
		
		if($mode == 'avoir')
		{//echo 'ici';	
			$facturedor = $em->getRepository('BaclooCrmBundle:Factures')
				// ->findOneByCodelocata($facture->getLocatacloneid());
				->findOneBy(array('locatacloneid' => $facture->getLocatacloneid(), 'typedoc' => 'facture', 'chantier' =>  $facture->getChantier())); 				
		}
		else
		{//echo 'laaaa';
			$facturedor = 0;
		}	
	}

		// foreach($machines as $machine)
		// {echo 'ooooooooo';echo $machine->getCode();
		
		// }				   
			// $facturesaimprimer = $locata;  
			$client = $clients;  
			// $em->persist($facta);	
			// $em->flush();					   
			   
// var_dump($facturedor);
		// print_r($facturesaimprimer);
		// foreach($facturesaimprimer as $loca)
		// {//echo 'ooooooooo';
			// echo $loca->getClient();
			// foreach($loca->getLocationsclone() as $loc)
			// {//echo 'xxxxxxxxxxxxxxxxxxxxxxxxx';
				// echo $loc->getTypemachine();
			// }
		// }
		$pdf = $this->get("white_october.tcpdf")->create();	
		if($type == 'loc')
		{
			$html = $this->renderView('BaclooCrmBundle:Crm:impression_facturespdf.html.twig', array(
																		'locata' => $locata,
																		'mode' => $mode,
																		'machines' => $machines,
																		'machinessl' => $machinessl,
																		'numfacture' => $numfacture,
																		'facture' => $facture,
																		'facturedor' => $facturedor,
																		'clients' => $client
																		));
		}
		else
		{
			$html = $this->renderView('BaclooCrmBundle:Crm:impression_facturesventepdf.html.twig', array(
																		'locata' => $locata,
																		'mode' => $mode,
																		'machines' => $machines,
																		'machinessl' => $machinessl,
																		'numfacture' => $numfacture,
																		'facture' => $facture,
																		'facturedor' => $facturedor,
																		'clients' => $client
																		));	
			
		}
		$pdf->SetFont('helvetica', '', 9, '', true);
		// set margins
		$pdf->SetMargins(13, '10', '5', '0');
		$pdf->AddPage();
		
		// -- set new background ---

		// get the current page break margin
		$bMargin = $pdf->getBreakMargin();
		// get current auto-page-break mode
		$auto_page_break = $pdf->getAutoPageBreak();
		// disable auto-page-break
		$pdf->SetAutoPageBreak(false, 0);
		// set bacground image
		$img_file = K_PATH_IMAGES.'facturetemplate.jpg';
		$pdf->Image($img_file, 0, 0, 210, 297, 'JPG', '', '', false, 300, '', false, false, 0);
		// restore auto-page-break status
		$pdf->SetAutoPageBreak($auto_page_break, $bMargin);
		// set the starting point for the page content
		$pdf->setPageMark();		
		
		$pdf->writeHTML($html, true, false, true, false, '');
		$pdf->lastPage();
 
		$response = new Response($pdf->Output('file.pdf'));
		$response->headers->set('Content-Type', 'application/pdf');
 
		return $response;	
	}

	public function impressionbdcAction($codecontrat, $clientid, $mode)
	{
		$em = $this->getDoctrine()->getManager();
// echo 'codecontrat'.$codecontrat;echo $mode;
		if($mode == 'contrat')
		{
			$locatafrs = $em->getRepository('BaclooCrmBundle:Locatafrs')
			   ->findOneByid($codecontrat);
			  $type = 'normal';
		}
		else
		{
			$facture = $em->getRepository('BaclooCrmBundle:Factures')
			   ->findOneByLocatacloneid($codecontrat);
// echo 'H'.$facture->getLocatacloneid();	echo '===='.$facture->getCodelocata();	   

				$type = 'normal';
				$locatafrs = $em->getRepository('BaclooCrmBundle:Locatafrs')
				   ->findOneByid($codecontrat);
		
		}//echo 'type'.$type;	
		 // echo 'codecontrat'.$codecontrat;
		$clients  = $em->getRepository('BaclooCrmBundle:Fiche')
		   ->findOneById($clientid);


		$pdf = $this->get("white_october.tcpdf")->create();

		// $moisdevis = date("m", strtotime($locatafrs->getDatecrea()));
		// $anneedevis = date("Y", strtotime($locatafrs->getDatecrea()));
		// $lastnumbdc = str_pad($facture->getCompteurfac(), 4, "0", STR_PAD_LEFT);


		$html = $this->renderView('BaclooCrmBundle:Crm:impression_bdc.html.twig', array(
																		'locatafrs' => $locatafrs,
																		'mode' => 'bdc',
																		// 'moisdevis' => $moisdevis,
																		// 'anneedevis' => $anneedevis,
																		// 'compteurbdc' => $lastnumbdc,
																		'clients' => $clients,
																		'type' => $type
																		));
	
		$pdf->SetFont('helvetica', '', 9, '', true);
		// set margins
		$pdf->SetMargins(13, '10', '5', '0');
		$pdf->AddPage();
		
		// -- set new background ---

		// get the current page break margin
		$bMargin = $pdf->getBreakMargin();
		// get current auto-page-break mode
		$auto_page_break = $pdf->getAutoPageBreak();
		// disable auto-page-break
		$pdf->SetAutoPageBreak(false, 0);
		// set bacground image
		$img_file = K_PATH_IMAGES.'bdctemplate.jpg';
		$pdf->Image($img_file, 0, 0, 210, 297, 'JPG', '', '', false, 300, '', false, false, 0);
		// restore auto-page-break status
		$pdf->SetAutoPageBreak($auto_page_break, $bMargin);
		// set the starting point for the page content
		$pdf->setPageMark();		
		
		$pdf->writeHTML($html, true, false, true, false, '');
		$pdf->lastPage();
 
		$response = new Response($pdf->Output('file.pdf'));
		$response->headers->set('Content-Type', 'application/pdf');
 
		return $response;	
	}

	public function impressionbdccomptaAction($codecontrat, $clientid, $mode)
	{
		$em = $this->getDoctrine()->getManager();
// echo 'codecontrat'.$codecontrat;echo $mode;
		if($mode == 'contrat')
		{
			$locatafrs = $em->getRepository('BaclooCrmBundle:Locatafrs')
			   ->findOneByid($codecontrat);
			  $type = 'normal';
		}
		else
		{
			$facture = $em->getRepository('BaclooCrmBundle:Factures')
			   ->findOneByLocatacloneid($codecontrat);
// echo 'H'.$facture->getLocatacloneid();	echo '===='.$facture->getCodelocata();	   
			if('H-'.$facture->getLocatacloneid() == $facture->getCodelocata())
			{
				$type = 'normal';
				$locatafrs = $em->getRepository('BaclooCrmBundle:Locatafrs')
				   ->findOneByid($codecontrat);
			}
			else
			{	
				$type = 'clone';
				$locatafrs = $em->getRepository('BaclooCrmBundle:Locatafrsclone')
				   ->findOneByid($codecontrat);
			}
		}//echo 'type'.$type;	
		 // echo 'codecontrat'.$codecontrat;
		$clients  = $em->getRepository('BaclooCrmBundle:Fiche')
		   ->findOneById($clientid);


		$pdf = $this->get("white_october.tcpdf")->create();

		// $moisdevis = date("m", strtotime($locatafrs->getDatecrea()));
		// $anneedevis = date("Y", strtotime($locatafrs->getDatecrea()));
		// $lastnumbdc = str_pad($facture->getCompteurfac(), 4, "0", STR_PAD_LEFT);

		if($mode != 'contrat')
		{
			$html = $this->renderView('BaclooCrmBundle:Crm:impression_bdccompta.html.twig', array(
																			'locatafrs' => $locatafrs,
																			'mode' => 'facture',
																			// 'moisdevis' => $moisdevis,
																			// 'anneedevis' => $anneedevis,
																			// 'compteurbdc' => $lastnumbdc,
																			'clients' => $clients,
																			'type' => $type
																			));
		}
		else
		{
			$html = $this->renderView('BaclooCrmBundle:Crm:impression_bdccompta.html.twig', array(
																			'locatafrs' => $locatafrs,
																			'mode' => 'bdc',
																			// 'moisdevis' => $moisdevis,
																			// 'anneedevis' => $anneedevis,
																			// 'compteurbdc' => $lastnumbdc,
																			'clients' => $clients,
																			'type' => $type
																			));
		}
		$pdf->SetFont('helvetica', '', 9, '', true);
		// set margins
		$pdf->SetMargins(13, '10', '5', '0');
		$pdf->AddPage();

		// -- set new background ---

		// get the current page break margin
		$bMargin = $pdf->getBreakMargin();
		// get current auto-page-break mode
		$auto_page_break = $pdf->getAutoPageBreak();
		// disable auto-page-break
		$pdf->SetAutoPageBreak(false, 0);
		// set bacground image
		$img_file = K_PATH_IMAGES.'bdctemplate.jpg';
		$pdf->Image($img_file, 0, 0, 210, 297, 'JPG', '', '', false, 300, '', false, false, 0);
		// restore auto-page-break status
		$pdf->SetAutoPageBreak($auto_page_break, $bMargin);
		// set the starting point for the page content
		$pdf->setPageMark();

		$pdf->writeHTML($html, true, false, true, false, '');
		$pdf->lastPage();

		$response = new Response($pdf->Output('file.pdf'));
		$response->headers->set('Content-Type', 'application/pdf');

		return $response;
	}



	public function impressionbdcfacAction($codecontrat, $clientid, $mode)
	{
		$em = $this->getDoctrine()->getManager(); 

		$locatafrs = $em->getRepository('BaclooCrmBundle:Locatafrsclone')		
		   ->findOneByid($codecontrat);	
			   
		 // echo 'codecontrat'.$codecontrat;  
		$clients  = $em->getRepository('BaclooCrmBundle:Fiche')		
		   ->findOneById($clientid);
		   

		$pdf = $this->get("white_october.tcpdf")->create();	
		if($mode == 'facture')
		{
			$html = $this->renderView('BaclooCrmBundle:Crm:impression_bdcfac.html.twig', array(
																			'locatafrs' => $locatafrs,
																			'mode' => 'facture',
																			'clients' => $clients
																			));
		}
		else
		{
			$html = $this->renderView('BaclooCrmBundle:Crm:impression_bdcfac.html.twig', array(
																			'locatafrs' => $locatafrs,
																			'mode' => 'bdc',
																			'clients' => $clients
																			));
		}
		$pdf->SetFont('helvetica', '', 9, '', true);
		// set margins
		$pdf->SetMargins(5, '10', '5', '0');
		$pdf->AddPage();
		
		// -- set new background ---

		// get the current page break margin
		$bMargin = $pdf->getBreakMargin();
		// get current auto-page-break mode
		$auto_page_break = $pdf->getAutoPageBreak();
		// disable auto-page-break
		$pdf->SetAutoPageBreak(false, 0);
		// set bacground image
		$img_file = K_PATH_IMAGES.'bdctemplate.jpg';
		$pdf->Image($img_file, 0, 0, 210, 297, 'JPG', '', '', false, 300, '', false, false, 0);
		// restore auto-page-break status
		$pdf->SetAutoPageBreak($auto_page_break, $bMargin);
		// set the starting point for the page content
		$pdf->setPageMark();		
		
		$pdf->writeHTML($html, true, false, true, false, '');
		$pdf->lastPage();
 
		$response = new Response($pdf->Output('file.pdf'));
		$response->headers->set('Content-Type', 'application/pdf');
 
		return $response;	
	}

	public function impressiongrilleAction($ficheid, $mode)
	{
		$em = $this->getDoctrine()->getManager(); 
		if($mode == 'parc')
		{//echo 'ici';
			$grille = $em->getRepository('BaclooCrmBundle:Grille')		
			   ->findBy(array('codeclient' => $ficheid),array('id' => 'ASC'));
		}
		else
		{//echo 'sl';
			$grille = $em->getRepository('BaclooCrmBundle:Grillesl')		
			   ->findBy(array('codeclient' => $ficheid),array('id' => 'ASC'));
		}
// print_r($grille);			   
		$client  = $em->getRepository('BaclooCrmBundle:Fiche')		
		   ->findOneById($ficheid);
		$annee = date('Y'); 
		   

		$pdf = $this->get("white_october.tcpdf")->create();	
		$html = $this->renderView('BaclooCrmBundle:Crm:impressiongrille.html.twig', array(
																		'grille' => $grille,
																		'annee' => $annee,
																		'client'=> $client
																		));
		
		$pdf->SetFont('helvetica', '', 9, '', true);
		// set margins
		$pdf->SetMargins(5, '10', '5', '0');
		$pdf->AddPage();
		
		// -- set new background ---

		// get the current page break margin
		$bMargin = $pdf->getBreakMargin();
		// get current auto-page-break mode
		$auto_page_break = $pdf->getAutoPageBreak();
		// disable auto-page-break
		$pdf->SetAutoPageBreak(false, 0);
		// set bacground image
		$img_file = K_PATH_IMAGES.'grilletemplate.jpg';
		$pdf->Image($img_file, 0, 0, 210, 297, 'JPG', '', '', false, 300, '', false, false, 0);
		// restore auto-page-break status
		$pdf->SetAutoPageBreak($auto_page_break, $bMargin);
		// set the starting point for the page content
		$pdf->setPageMark();		
		
		$pdf->writeHTML($html, true, false, true, false, '');
		$pdf->lastPage();
 
		$response = new Response($pdf->Output('file.pdf'));
		$response->headers->set('Content-Type', 'application/pdf');
 
		return $response;	
	}


	public function sitewebAction()
	{
		$reponse = 'coco';
		return $this->render('BaclooCrmBundle:Crm:siteweb.html.twig');
	}

	public function modifierfactureAction($ficheid, $locid, $erreur, Request $request)
	{
		$objUser = $this->get('security.context')->getToken()->getUsername(); if(empty($objUser) or !isset($objUser) or $objUser == 'anon.'){return $this->redirect($this->generateUrl('fos_user_security_login'));}
		// echo 'erreur'.$erreur;
		// if ($this->container->has('profiler'))
		// {
			// $this->container->get('profiler')->disable();
		// }
		$today = date('Y-m-d');
		// $erreur = 0;
		$em = $this->getDoctrine()->getManager();//echo 'locid'.$locid;
					   
		$client  = $em->getRepository('BaclooCrmBundle:Fiche')		
					   ->findOneById($ficheid);
		$fiche = $client;
		$totalht = 0;//echo $locid;
		$totaltrspaller = 0;//echo $locid;
		$totaltrspretour = 0;//echo $locid;			
		$contributionverte = 0;//echo $locid;			
		$assurance = 0;//echo $locid;			
		$montantcarb = 0;
					   
		// On crée un objet Locata
		$locata  = $em->getRepository('BaclooCrmBundle:Locataclone')		
					   ->findOneById($locid);
		if($client->getAssurance() == 1 && $locata->getAssurance() == 0)
		{
			$locata->setAssurance(0);
			$em->persist($locata);
		}
		
		$contrat = $locata->getContrat();
		$bdcrecu = $locata->getBdcrecu();
		
		if(null == $locata->getChantierid())
		{
			$chantier = $em->getRepository('BaclooCrmBundle:Chantier')
								->findOneByNom($locata->getNomchantier());
					
			if(!empty($chantier))
			{					
				$chantierid = $chantier->getId();
				$locata->setChantierid($chantierid);
			}				
		}
		$em->flush();
		
		$objUser = $this->get('security.context')->getToken()->getUsername(); if(empty($objUser) or !isset($objUser) or $objUser == 'anon.'){return $this->redirect($this->generateUrl('fos_user_security_login'));}
		$em = $this->getDoctrine()->getManager();
		$userdetails  = $em->getRepository('BaclooUserBundle:User')		
					   ->findOneByUsername($objUser);			
		$userid = $userdetails->getId();
		$form = $this->createForm(new LocatacloneType(), $locata);
		$today = date('Y-m-d');
		include('societe.php');

		//On met les locations dans un array pour controle ultérieur
		// $listeloc = array();
		// foreach ($locata->getLocationsclone() as $loc) {
		  // $listeloc[] = $loc;
		// }		
		
		$em = $this->getDoctrine()->getManager();
		$modules  = $em->getRepository('BaclooCrmBundle:Modules')		
					   ->findOneByUsername($objUser);
// echo 'WWWWWWWWWWWWWWWWWWWWWWWWW';	
		// On récupère la requête
		$request = $this->get('request');
		// On vérifie qu'elle est de type POST
		 // echo $request->getMethod();

		if ($request->getMethod() == 'POST') 
		{//echo 'YYYYYYYYYYYYYYY';
			$form->bind($request);
		// On vérifie que les valeurs entrées sont correctes
		// $data = $form->getData();
			if ($form->isValid()){
				//Création du numero d'offre unique
echo 'loooogique';				
				//Création du numero de contrat unique
				// $data = $form->getData();
				$facturersamedi = $form->get('facturersamedi')->getData();
				$facturerdimanche = $form->get('facturerdimanche')->getData();
				if($facturersamedi == 1)
				{
					$locata->setFacturersamedi(1);
				}
				elseif($facturersamedi == 0)
				{

					$locata->setFacturersamedi(0);
				}
				if($facturerdimanche == 1)
				{
					$locata->setFacturerdimanche(1);
				}
				elseif($facturerdimanche == 0)
				{
					$locata->setFacturerdimanche(0);
				}

				$rempli = 0;		
				foreach($form->get('locationsclone')->getData() as $loc)
				{
					if(null !== $loc->getCodemachine())
					{
						$rempli++;
					}
				}		
				foreach($form->get('locationsslclone')->getData() as $loc)
				{
					if(null !== $loc->getCodemachine())
					{
						$rempli++;
					}
				}
				
				if($rempli == 0)
				{
					return $this->redirect($this->generateUrl('bacloocrm_ajouterlocation', array('ficheid' => $ficheid, 'locid' => $locid, 'erreur' => 3 )));	
				}
		

				// $debutloc = $form->get('debutloc')->getData();
				// $finloc = $form->get('finloc')->getData();
				$entreprise = $form->get('client')->getData();
				$nomchantier = $form->get('nomchantier')->getData();
				$adresse1 = $form->get('adresse1')->getData();
				$adresse2 = $form->get('adresse2')->getData();
				$adresse3 = $form->get('adresse3')->getData();
				$cp = $form->get('cp')->getData();
				$ville = $form->get('ville')->getData();
				$bdcrecu = $form->get('bdcrecu')->getData();
				$contrat = $form->get('contrat')->getData();
				$offreencours = $form->get('offreencours')->getData();
				$refusee = $form->get('offrerefusee')->getData();
				$locations = $form->get('locationsclone')->getData();
					
				
					$em->persist($locata);	
					$em->flush();

				//Mise à jour de la table chantier si le chantier n'existe pas
				$chantier = $em->getRepository('BaclooCrmBundle:Chantier')
								->findOneByNom($nomchantier);
				if(empty($chantier))
				{
					$newchantier = new Chantier;
					$newchantier->setNom($nomchantier);
					$newchantier->setAdresse1($adresse1);
					$newchantier->setAdresse2($adresse2);
					$newchantier->setAdresse3($adresse3);
					$newchantier->setCp($cp);
					$newchantier->setVille($ville);
					$em->persist($newchantier);
					// $em->flush();
				}
				//Fin maj chantier

			//FACTURATION

				//Création du montant HT ligne par ligne
				$totalht = 0;//echo $locid;	
				$totaltrspaller = 0;
				$totaltrspretour = 0;
				$contributionverte = 0;
				$montantcarb1 = 0;
				$assurance = 0;

				//Calcul totalht locations parc
				foreach($form->get('locationsclone')->getData() as $loc)
				{
						$nbjlocadeduire = 0;
						$nbjloc = 0;
						$nbjlocass = 0;
						$debutloc = $loc->getDebutloc();//echo $debutloc;
						$finloc = $loc->getFinloc();//echo $finloc;
						$dStart = $debutloc;
						$dEnd = $finloc;
						
						//mettre le if sur debutloc ou finloc et si <= date du jour >>>> redirect !
						if($debutloc <= $today && $loc->getEtatloc() != 'Location terminée')
						{
							$this->redirect($request->server->get('HTTP_REFERER'));
						}
						// fin redirect						
					//1.Récupérer les données de la table Machines
						   
					//2.On génère les entêtes de colonnes à partir de la fonction createplanning
						$iStart = strtotime ($dStart);//Formate une date/heure locale avec la Something is wronguration locale
						$iEnd = strtotime ($dEnd);
						if (false === $iStart || false === $iEnd) {
							// return false;
						}
						$aStart = explode ('-', $dStart);
						$aEnd = explode ('-', $dEnd);
						if (count ($aStart) !== 3 || count ($aEnd) !== 3) {
							// return false;
						}
						// if (false === checkdate ($aStart[1], $aStart[2], $aStart[0]) || false === checkdate ($aEnd[1], $aEnd[2], $aEnd[0]) || $iEnd <= $iStart) {
							// return false;
						// }
						
						$jour50 = $loc->getJour50();
						$jour100 = $loc->getJour100();
						
						$aDates = array();
						for ($i = $iStart; $i < $iEnd + 86400; $i = $i + 86400 ) {
							$sDateToArr = strftime ('%Y-%m-%d', $i);
							$sYear = substr ($sDateToArr, 0, 4);
							$sMonth = substr ($sDateToArr, 5, 2);
							$aDates[] = $sDateToArr;
						}	

					//on calcule le nombre de jours de location
									foreach($aDates as $dat)
									{						
										$time = strtotime($dat);
										// echo $dat;
										//Facturation WE ou pas
										$newformat = date('D',$time);

										if($facturersamedi == 1 && $newformat == 'Sat')
										{
											$nbjloc++;
										}
										elseif($facturerdimanche == 1 && $newformat == 'Sun')
										{
											$nbjloc++;
										}
										elseif($newformat == 'Sat' or $newformat == 'Sun')
										{}
										else
										{
											$nbjloc++;
										}
									}


						//nb jour pour les assurances car 7/7
									foreach($aDates as $dat)
									{
										$nbjlocass++;
									}
						$jour50 = $loc->getJour50();
						$jour100 = $loc->getJour100();	
									
						if(isset($jour50))
						{
							$nbjlocadeduire += $jour50*0.5;//nb jours corrigé
						}								
						if(isset($jour100))
						{
							$nbjlocadeduire += $jour100;//nb jours corrigé								
						}					
// echo $nbjloc;			
						$nbjloc += $nbjlocadeduire;
						$nbjlocass += $nbjlocadeduire;
// echo '***';
// echo $nbjlocadeduire;						
// echo 'HHHHH'.$nbjloc;
						if(null !== $loc->getLoyerp1())
						{
							$totalht += $nbjloc * $loc->getLoyerp1();
							$totalhtloc = $nbjloc * $loc->getLoyerp1();
							$totalhtlocass = $nbjlocass * $loc->getLoyerp1();
							$loyer = $loc->getLoyerp1();
						}
						elseif(null !== $loc->getLoyerp2())
						{
							$totalht += $nbjloc * $loc->getLoyerp2();
							$totalhtloc = $nbjloc * $loc->getLoyerp2();
							$totalhtlocass = $nbjlocass * $loc->getLoyerp2();
							$loyer = $loc->getLoyerp2();
						}
						elseif(null !== $loc->getLoyerp3())
						{
							$totalht += $nbjloc * $loc->getLoyerp3();
							$totalhtloc = $nbjloc * $loc->getLoyerp3();
							$totalhtlocass = $nbjlocass * $loc->getLoyerp3();
							$loyer = $loc->getLoyerp3();
						}
						elseif(null !== $loc->getLoyerp4())
						{
							$totalht += $nbjloc * $loc->getLoyerp4();
							$totalhtloc = $nbjloc * $loc->getLoyerp4();
							$totalhtlocass = $nbjlocass * $loc->getLoyerp4();
							$loyer = $loc->getLoyerp4();
						}
						elseif(null !== $loc->getLoyermensuel())
						{
							include('calculnbjlocmensuellemodiffac.php');	echo 'nbjloc'.$nbjloc;						
							$loyer = $loc->getLoyermensuel()/20;
							$totalht += $loyer * $nbjloc;
							$totalhtloc = $loyer * $nbjloc;					
							$totalhtlocass = ($loyer) * $nbjlocass;
						}
						echo 'loyer';echo $loyer;
						$totaltrspaller += $loc->getTransportaller();
						$totaltrspretour += $loc->getTransportretour();
						
						if($loc->getContributionverte() == 1)
						{
							$contributionverte += 0.0215 * $loyer * $nbjloc;
						}
						
						if($loc->getAssurance() == 1)
						{
							$assurance += $totalhtlocass*0.10;
						}//echo 'nbjlocjm'.$nbjloc;
;	
						$montantcarb1 += $loc->getLitrescarb()*1.97;
						$loc->setMontantcarb($loc->getLitrescarb()*1.97);
						$loc->setMontantloc($totalhtloc);echo 'nbjlocjm3'.$nbjloc;	
						$loc->setNbjloc($nbjloc);
						$loc->setNbjlocass($nbjlocass);
						$em->persist($loc);
						$em->flush();
				}
				
				//Calcul total ht sous loc
				foreach ($form->get('locationsslclone')->getData() as $loc)
				{	//echo 'yyyyyyyyyy';
						$nbjlocadeduire = 0;
						$nbjloc = 0;
						$nbjlocass = 0;
						$debutloc = $loc->getDebutloc();//echo $debutloc;
						$finloc = $loc->getFinloc();//echo $finloc;
						$dStart = $debutloc;
						$dEnd = $finloc;
echo 'DSTART'.$dStart;
echo 'dEnd'.$dEnd;						
						//mettre le if sur debutloc ou finloc et si <= date du jour >>>> redirect !
						if($debutloc <= $today)
						{
							$this->redirect($request->server->get('HTTP_REFERER'));
						}
						// fin redirect						
						$begin = new \DateTime($dStart);
				  
						$end = new \DateTime($dEnd);
						$end = $end->modify( '+1 day' ); 

		  
			
						$interval = DateInterval::createFromDateString('1 day');
						$period = new DatePeriod($begin, $interval, $end);
						$nbjloc = 0;
						$nbjlocass = 0;   

						foreach ($period as $dt) {
							$newformat = $dt->format("D");
							$nbjlocass++;
							if($locata->getFacturersamedi() == 1 && $newformat == 'Sat')
							{
								$nbjloc++;
							}
							elseif($locata->getFacturerdimanche() == 1 && $newformat == 'Sun')
							{
								$nbjloc++;
							}
							elseif($newformat == 'Sat' or $newformat == 'Sun')
							{}
							else
							{
								$nbjloc++;
							}							
						}	
						$jour50 = $loc->getJour50();
						$jour100 = $loc->getJour100();									
						if(isset($jour50))
						{
							$nbjlocadeduire += $jour50*0.5;//nb jours corrigé
						}								
						if(isset($jour100))
						{
							$nbjlocadeduire += $jour100;//nb jours corrigé								
						}
echo $nbjloc;			
						$nbjloc += $nbjlocadeduire;
						$nbjlocass += $nbjlocadeduire;
echo '***';
echo $nbjlocadeduire;						
echo 'HHHHH'.$nbjloc;						
						if(null !== $loc->getLoyerp1())
						{
							$totalht += $nbjloc * $loc->getLoyerp1();
							$totalhtloc = $nbjloc * $loc->getLoyerp1();
							$totalhtlocass = $nbjlocass * $loc->getLoyerp1();
							$loyer = $loc->getLoyerp1();
						}
						elseif(null !== $loc->getLoyerp2())
						{
							$totalht += $nbjloc * $loc->getLoyerp2();
							$totalhtloc = $nbjloc * $loc->getLoyerp2();
							$totalhtlocass = $nbjlocass * $loc->getLoyerp2();
							$loyer = $loc->getLoyerp2();
						}
						elseif(null !== $loc->getLoyerp3())
						{
							$totalht += $nbjloc * $loc->getLoyerp3();
							$totalhtloc = $nbjloc * $loc->getLoyerp3();
							$totalhtlocass = $nbjlocass * $loc->getLoyerp3();
							$loyer = $loc->getLoyerp3();
						}
						elseif(null !== $loc->getLoyerp4())
						{
							$totalht += $nbjloc * $loc->getLoyerp4();
							$totalhtloc = $nbjloc * $loc->getLoyerp4();
							$totalhtlocass = $nbjlocass * $loc->getLoyerp4();
							$loyer = $loc->getLoyerp4();
						}
						elseif(null !== $loc->getLoyermensuel())
						{
							include('calculnbjlocamensuellemodiffac.php');							
							$loyer = $loc->getLoyermensuel()/20;
							$totalht += $loyer * $nbjloc;
							$totalhtloc = $loyer * $nbjloc;					
							$totalhtlocass = ($loyer) * $nbjlocass;
						}

echo '$totalhtlocass1'.$totalhtlocass;						
						$totaltrspaller += $loc->getTransportaller();
						$totaltrspretour += $loc->getTransportretour();
						
						if($loc->getContributionverte() == 1)
						{
							$contributionverte += 0.0215 * $loyer * $nbjloc;
						}
						
						if($loc->getAssurance() == 1)
						{
							$assurance += $totalhtlocass*0.10;
						}
						$montantcarb1 += $loc->getLitrescarb()*1.97;	
						$loc->setMontantcarb($loc->getLitrescarb()*1.97);
						$loc->setMontantloc($totalhtloc);
						$loc->setNbjloc($nbjloc);
						$loc->setNbjlocass($nbjlocass);
						$em->persist($loc);
						$em->flush();
				}

				$montantvente = 0;			
				$totalvente = 0;			
				foreach($form->get('locataventesclone')->getData() as $ven)
				{
					$montantvente = $ven->getQuantite() * $ven->getPu();
					$totalvente += $ven->getQuantite() * $ven->getPu();
					
					$ven->setMontantvente($montantvente);
					$em->persist($ven);
					// $em->flush();
				}
			
					// if($locata->getRemise() > 0)
					// {
						// $totalht = $totalht - ($totalht * $locata->getRemise()/100);
					// }
// echo $totalht;						

					$locata->setTransportaller($totaltrspaller);
					$locata->setTransportretour($totaltrspretour);
					$locata->setAssurance($assurance);
					$locata->setContributionverte($contributionverte);	
					$locata->setMontantlocavente($totalvente);
					$locata->setMontantloc($totalht);
					// $em->persist($locata);
					// $em->flush();			
			//FIN FACTURATION	
//echo 'rrrrrrrrrrrrrr';			
				//MAJ de la table machine lorsqu'on reçoit un BDC pour réserver
				if($bdcrecu == 1 && $offreencours == 1 && $contrat == 0)
				{//echo 'cont0000';			
					$locata  = $em->getRepository('BaclooCrmBundle:Locataclone')		
								   ->findOneById($locata->getId());

					//machines parc					
					foreach ($locata->getLocationsclone() as $loc)
					{				
						//Insertion du code location à la machine
						$codelocations = $loc->getId();	
						$debutloc = $loc->getDebutloc();
						$finloc = $loc->getFinloc();					
//echo 'x'.$codelocations;
						
						$debutlocok = date('Y-m-d', strtotime($debutloc . ' -1 day'));
						$finlocok = date('Y-m-d', strtotime($finloc . ' +1 day'));
						$machin = $em->getRepository('BaclooCrmBundle:Machines')
								->unedispo($loc->getCodemachine(),$debutlocok, $finlocok);						
						if(!empty($machin))
						{
							foreach($machin as $mach)
							{
								$code = $mach['code'];
								$etat = $mach['etat'];
								$energie = $mach['energie'];
								$machinedef = $em->getRepository('BaclooCrmBundle:Machines')
										->dispoprecisenot($loc->getCodemachine(),$debutlocok, $finlocok);
								
									if($etat == 'Disponible')
									{
										break;
									}
							}
								if(empty($code))
								{
									foreach($machin as $mach)
									{
										$code = $mach['code'];
										$etat = $mach['etat'];
										$energie = $mach['energie'];
										$adblue = $mach['adblue'];
										$machineid = $mach['id'];
										$machinedef = $em->getRepository('BaclooCrmBundle:Machines')
												->dispoprecisenot($code, $debutlocok, $finlocok);
										
										if(empty($machinedef))
										{
											break;
										}
									}
								}
								if(!empty($code))
								{echo 'boucle2';
									foreach($machin as $mach)
									{echo 'les différents coces'.$mach['code'];
										$code = $mach['code'];
										$etat = $mach['etat'];
										$energie = $mach['energie'];
										$adblue = $mach['adblue'];
										$machineid = $mach['id'];
										$machinedef = $em->getRepository('BaclooCrmBundle:Machines')
												->dispoprecisenot($code, $debutlocok, $finlocok);
										
										if(!empty($machinedef))
										{
											$machinedefresa = $em->getRepository('BaclooCrmBundle:Machines')
													->dispoprecisenotresa($code, $debutlocok, $finlocok);
											if(empty($machinedefresa))
											{											
												break;
											}
										}
									}
								}
							echo 'code1'.$code;
						
							//MAJ table Locations suite réservation

							//Faire un if pour le cas d'un refus de l'offre alors qu'un BDC a été émis
							//Il faut donc supprimer la machine réservée en fonction du codelocation et du code origine
							if(isset($refusee) && $refusee == 1)
							{
								
							}
						}
					}
				//Partie sous-locations
					$nbdemachines = 0;
					if(null !== $locata->getLocationsslclone())
					{echo 'ttt';
						foreach ($locata->getLocationsslclone() as $loc)
						{
							if($loc->getTransport() == 1)
							{
								$nbdemachines++;
							}
						}
						
						$nbmachinesdispo = 0;
						foreach ($locata->getLocationsslclone() as $loc)
						{				
							//Insertion du code location à la machine
							$codelocations = $loc->getId();						
							// echo $codelocations;
							if($loc->getTransport() == 1)
							{

								$machine = $em->getRepository('BaclooCrmBundle:Machinessl')
										->findOneBy(array('codegenerique'=> $loc->getCodemachine(), 'loueur'=> $loc->getLoueur()));

								// On crée un objet Locatasl
								if(!empty($machine))
								{
									$nbmachinesdispo++;
								}
							}
						}
	// echo 'XXXXXXXXXXXXXX';
	// echo 'nbdemachines'.$nbdemachines;					
	// echo 'nbmachinesdispo'.$nbmachinesdispo;					
				
						
						foreach ($locata->getLocationsslclone() as $loc)
						{		echo '22222';		

							//Insertion du code location à la machine
							$codelocations = $loc->getId();						
							// echo $codelocations;
							$debutloc = $loc->getDebutloc();
							$finloc = $loc->getFinloc();
							$debutlocok = date('Y-m-d', strtotime($debutloc . ' -1 day'));
							$finlocok = date('Y-m-d', strtotime($finloc . ' +1 day'));						
							$machin = $em->getRepository('BaclooCrmBundle:Machinessl')
									->unedispo($loc->getCodemachine(),$debutloc, $finloc, $loc->getLoueur());	
							
						}				
					}
				}

				if($contrat == 1 && $offreencours == 1)
				{
					// echo 'contrat ok offre ok';
					echo ' TOTALHTDDDd'.$totalht;
					$locata  = $em->getRepository('BaclooCrmBundle:Locataclone')		
								   ->findOneById($locata->getId());
					// $totalht = 0;
					$montantcarb = 0;
					// $contributionverte = 0;
					if(null !== $locata->getLocationsclone())
					{	
// echo 'xxx';echo $loc->getId().'-';echo $nbjloc;echo 'xxx';					

						//Partie locations parc
						foreach ($locata->getLocationsclone() as $loc)
						{
							$jour50 = $loc->getJour50();
							$jour100 = $loc->getJour100();
							if($loc->getEtatloc() != 'Location terminée')
							{
								//Insertion du code location à la machine
								$codelocations = $loc->getId();//echo $codelocations;
								$debutloc = $loc->getDebutloc();
								$finloc = $loc->getFinloc();						
								// echo $codelocationssl;
								//On vérifie si une becane est déjà réservée sur cet ecode	
		 

								$locations = $em->getRepository('BaclooCrmBundle:Locations')
										->findOneById($codelocations);				
								if(isset($locations) && null == $locations->getCodemachineinterne())
								{						
										$debutlocok = date('Y-m-d', strtotime($debutloc . ' -1 day'));
										$finlocok = date('Y-m-d', strtotime($finloc . ' +1 day'));
										$machin = $em->getRepository('BaclooCrmBundle:Machines')
												->unedispo($loc->getCodemachine(),$debutlocok, $finlocok);						
										if(!empty($machin))
										{							
											foreach($machin as $mach)
											{
												$code = $mach['code'];
												$etat = $mach['etat'];
												$energie = $mach['energie'];
												$machineid = $mach['id'];
												$machinedef = $em->getRepository('BaclooCrmBundle:Machines')
														->dispoprecisenot($loc->getCodemachine(),$debutlocok, $finlocok);
												
									if($etat == 'Disponible')
									{
										break;
									}
								}
								if(empty($code))
								{
									foreach($machin as $mach)
									{
										$code = $mach['code'];
										$etat = $mach['etat'];
										$energie = $mach['energie'];
										$machineid = $mach['id'];
										$machinedef = $em->getRepository('BaclooCrmBundle:Machines')
												->dispoprecisenot($code, $debutlocok, $finlocok);
										
										if(empty($machinedef))
										{
											break;
										}
									}
								}
								if(!empty($code))
								{echo 'boucle2';
									foreach($machin as $mach)
									{echo 'les différents coces'.$mach['code'];
										$code = $mach['code'];
										$etat = $mach['etat'];
										$energie = $mach['energie'];
										$adblue = $mach['adblue'];
										$machineid = $mach['id'];
										$machinedef = $em->getRepository('BaclooCrmBundle:Machines')
												->dispoprecisenot($code, $debutlocok, $finlocok);
										
										if(!empty($machinedef))
										{
											$machinedefresa = $em->getRepository('BaclooCrmBundle:Machines')
													->dispoprecisenotresa($code, $debutlocok, $finlocok);
											if(empty($machinedefresa))
											{											
												break;
											}
										}
									}
								}
							echo 'code1'.$code;
											
											//MAJ table Locations suite réservation
											$resaloc = $em->getRepository('BaclooCrmBundle:Locations')
													->findOneById($codelocations);
											$resaloc->setEtatloc('Réservé');
											$resaloc->setCodemachineinterne($code);
											$resaloc->setEnergie($energie);
											$resaloc->setMachineid($machineid);
											$em->persist($resaloc);
											$em->flush();
											
											//Faire un if pour le cas d'un refus de l'offre alors qu'un BDC a été émis
											//Il faut donc supprimer la machine réservée en fonction du codelocation et du code origine
											if(isset($refusee) && $refusee == 1)
											{
												$refusloc = $em->getRepository('BaclooCrmBundle:Locations')
														->findOneById($codelocations);
												$refusloc->setEtatloc('Refusé');$refusloc->setEtatlog('Refusé');
												$em->persist($refusloc);
												$em->flush();						
													
											}
										}
								}
								else
								{}
							}
							foreach ($locata->getLocationsclone() as $loc)
							{
								if($loc->getCodemachineinterne() == '' OR $loc->getCodemachineinterne() == NULL )
								{//echo 'iciiiiiiii';
									$locata->setContrat(0);
									$em->persist($locata);
									$em->flush();							
								return $this->redirect($this->generateUrl('bacloocrm_ajouterlocation', array('ficheid' => $ficheid, 'locid' => $locid, 'erreur' => 2 )));
								}
								else
								{
									//echo 'laaaaaaaaaaaaaa';
								}
							}
							$montantloclocatafrs = 0;
							foreach ($locata->getLocationsclone() as $loc)
							{			
								//Insertion du code location à la machine
								$codelocationssl = $loc->getId();						
								// echo $codelocationssl;

									if($loc->getEtatlog() == 'Livré chez le client' or $loc->getEtatlog() == 'Déposé en agence')
									{}
									else
									{
			
									}
										// $em->persist($loc);
									// $em->flush();
										$montantlocactu = 0;
										$nbjlocadeduire = 0;
										//On récupère le loyer
										if(null !== $loc->getLoyerp1())
										{
											$loyer = $loc->getLoyerp1();
										}
										elseif(null !== $loc->getLoyerp2())
										{
											$loyer = $loc->getLoyerp2();
										}
										elseif(null !== $loc->getLoyerp3())
										{
											$loyer = $loc->getLoyerp3();
										}
										elseif(null !== $loc->getLoyerp4())
										{
											$loyer = $loc->getLoyerp4();
										}
										elseif(null !== $loc->getLoyermensuel())
										{echo 'BIEN LA';
											// $nbjloc = $loc->getNbjloc();
											// include('calculnbjlocmensuellemodiffac.php');echo 'NBJLOCO contrat '.$nbjloc;								
											$loyer = $loc->getLoyermensuel()/20;

										}								
										if($jour50 != 0)
										{
											$nbjlocadeduire += $jour50*0.5;//nb jours corrigé
										}								
										if($jour100 != 0)
										{
											$nbjlocadeduire += $jour100;//nb jours corrigé
										
										}	//??
										$montantlocactu = $loyer * ($nbjloc + $nbjlocadeduire);
										//$montantcarb += $loc->getMontantcarb();
										//$loc->setMontantloc($montantlocactu);
										// $loc->setNbjloc($nbjloc + $nbjlocadeduire);
										$em->persist($loc);
										$em->flush();
echo ' CARBLOC '.$montantcarb;
										$nbjloc += $nbjlocadeduire;
										// $nbjlocass += $nbjlocadeduire;
										// $totalht += $nbjloc * $loyer;						
										//if($loc->getContributionverte() == 1)
										//{
											// $contributionverte += 0.0215 * $loyer * $nbjloc;
										//}

							}
						}					
					}	
					//Partie sous-locations

					foreach ($locata->getLocationsslclone() as $loc)
					{echo 'laaaaaaaaxxx';
						$jour50 = $loc->getJour50();
						$jour100 = $loc->getJour100();
						$machine = $em->getRepository('BaclooCrmBundle:Machinessl')
								->findOneBy(array('codegenerique'=> $loc->getCodemachine(), 'loueur'=> $loc->getLoueur()));

echo 'ZZZZZZZZZZZZZZZZZZZ';									
						$debutloc = $loc->getDebutloc();
						$finloc = $loc->getFinloc();
						// On crée un objet Locatasl
						if(empty($machine) && $loc->getTransport() == 1)
						{
							return $this->redirect($this->generateUrl('bacloocrm_ajouterlocation', array('ficheid' => $ficheid, 'locid' => $locid, 'erreur' => 1 )));
						}
						if(null == $loc->getCodemachineinterne())
						{
							$nbdemachines = 0;
							foreach ($locata->getLocationsslclone() as $loc)
							{
								if($loc->getTransport() == 1)
								{
									$nbdemachines++;
								}
							}
							
							$nbmachinesdispo = 0;
							foreach ($locata->getLocationsslclone() as $loc)
							{				
								//Insertion du code location à la machine
								$codelocations = $loc->getId();						
								// echo $codelocations;
								if($loc->getTransport() == 1)
								{

									$machine = $em->getRepository('BaclooCrmBundle:Machinessl')
											->findOneBy(array('codegenerique'=> $loc->getCodemachine(), 'loueur'=> $loc->getLoueur()));

									// On crée un objet Locatasl
									if(!empty($machine))
									{
										$nbmachinesdispo++;
									}
								}
							}
		// echo 'XXXXXXXXXXXXXX';
		// echo 'nbdemachines'.$nbdemachines;					
		// echo 'nbmachinesdispo'.$nbmachinesdispo;					
							if($nbdemachines != $nbmachinesdispo)
							{
								$em->clear();
								return $this->redirect($this->generateUrl('bacloocrm_ajouterlocation', array('ficheid' => $ficheid, 'locid' => $locid, 'erreur' => 1 )));
							}					
							
							foreach ($locata->getLocationsslclone() as $loc)
							{				
								//Insertion du code location à la machine
								$codelocations = $loc->getId();						
								// echo $codelocations;
								$debutloc = $loc->getDebutloc();
								$finloc = $loc->getFinloc();
								$debutlocok = date('Y-m-d', strtotime($debutloc . ' -1 day'));
								$finlocok = date('Y-m-d', strtotime($finloc . ' +1 day'));						
								$machin = $em->getRepository('BaclooCrmBundle:Machinessl')
										->unedispo($loc->getCodemachine(),$debutloc, $finloc, $loc->getLoueur());	
									
								if(!empty($machin))

								{echo 'yyyy';


									foreach($machin as $mach)
									{
										$code = $mach['code'];
										$etat = $mach['etat'];
										$energie = $mach['energie'];
										$machineid = $mach['id'];
										$machinedef = $em->getRepository('BaclooCrmBundle:Machinessl')
												->dispoprecisenot($loc->getCodemachine(),$debutlocok, $finlocok, $loc->getLoueur());
										
										if($etat == 'Disponible')
										{
											break;
										}
									}

									if(empty($code))
									{echo '333';

										foreach($machin as $mach)
										{
											$code = $mach['code'];
											$etat = $mach['etat'];
											$energie = $mach['energie'];
											$machineid = $mach['id'];
											$machinedef = $em->getRepository('BaclooCrmBundle:Machinessl')
													->dispoprecisenot($code, $debutlocok, $finlocok, $loc->getLoueur());					

											if(empty($machinedef))
											{
												break;
											}
										}
									}
									


										//MAJ table Locations suite réservation
										$resaloc = $em->getRepository('BaclooCrmBundle:Locationssl')
												->findOneById($codelocations);
										$resaloc->setEtatloc('Réservé');
										if(!isset($code))
										{
											return $this->redirect($this->generateUrl('bacloocrm_ajouterlocation', array('ficheid' => $ficheid, 'locid' => $locid, 'erreur' => 7 )));
										}
										else
										{	
											$resaloc->setCodemachineinterne($code);
										}
										$resaloc->setEnergie($energie);
										$resaloc->setMachineid($machineid);
										$em->persist($resaloc);
										$em->flush();
				
								}
								else
								{echo 'ajouuuuuuuuuuuuuuuuuuuuut2';echo $loc->getCodemachineinterne();
									if(null == $loc->getCodemachineinterne())
									{
										return $this->redirect($this->generateUrl('bacloocrm_ajouterlocation', array('ficheid' => $ficheid, 'locid' => $locid, 'erreur' => 2 )));	
									}								
								}													
							}	
						}

								//Faire un if pour le cas d'un refus de l'offre alors qu'un BDC a été émis
								//Il faut donc supprimer la machine réservée en fonction du codelocation et du code origine
								if(isset($refusee) && $refusee == 1)
								{
									$machine = $em->getRepository('BaclooCrmBundle:Machinessl')
											->findOneBy(array('code'=> $code, 'codelocations' => $codelocations));
									//Si machine originale on fait un update

									$refusloc = $em->getRepository('BaclooCrmBundle:Locationssl')
											->findOneById($codelocations);
									$refusloc->setEtatloc('Refusé');$refusloc->setEtatlog('Refusé');
									$em->persist($refusloc);
									$em->flush();													


						}
					}


					foreach ($locata->getLocationsslclone() as $loc)
					{
						if($loc->getCodemachineinterne() == '' OR $loc->getCodemachineinterne() == NULL )
						{//echo 'iciiiiiiii';
							$locata->setContrat(0);
							$em->persist($locata);
							$em->flush();							
						return $this->redirect($this->generateUrl('bacloocrm_ajouterlocation', array('ficheid' => $ficheid, 'locid' => $locid, 'erreur' => 2 )));
						}
						else
						{
							echo 'laaaaaaaaaaaaaa';
						}
					}
					$montantloclocatafrs = 0;
					foreach ($locata->getLocationsslclone() as $loc)
					{			
						//Insertion du code location à la machine
						$codelocationssl = $loc->getId();						
						// echo $codelocationssl;

							if($loc->getEtatlog() == 'Livré chez le client' or $loc->getEtatlog() == 'Déposé en agence')
							{}
							else
							{
	
							}
								// $em->persist($loc);
							// $em->flush();
								$montantlocactu = 0;
								$nbjlocadeduire = 0;
								//On récupère le loyer
								if(null !== $loc->getLoyerp1())
								{
									$loyer = $loc->getLoyerp1();
								}
								elseif(null !== $loc->getLoyerp2())
								{
									$loyer = $loc->getLoyerp2();
								}
								elseif(null !== $loc->getLoyerp3())
								{
									$loyer = $loc->getLoyerp3();
								}
								elseif(null !== $loc->getLoyerp4())
								{
									$loyer = $loc->getLoyerp4();
								}
								elseif(null !== $loc->getLoyermensuel())
								{
									$nbjloc = $loc->getNbjloc();
									include('calculnbjlocmensuelle.php');							
									$loyer = $loc->getLoyermensuel()/20;

								}								
								if($jour50 != 0)
								{
									$nbjlocadeduire += $jour50*0.5;//nb jours corrigé
								}								
								if($jour100 != 0)
								{
									$nbjlocadeduire += $jour100;//nb jours corrigé
								
								}
								echo 'LOCADEDUIRE'.$nbjlocadeduire;$a = $nbjloc + $nbjlocadeduire; echo 'aaaaaaaaaaaaaaa'.$a;
								// $nbjloc = $loc->getNbjloc();	//??
								$montantlocactu = $loyer * ($nbjloc + $nbjlocadeduire);
								// $montantcarb += $loc->getMontantcarb();
								//$loc->setMontantloc($montantlocactu);
								// $loc->setNbjloc($nbjloc + $nbjlocadeduire);
								$em->persist($loc);
								$em->flush();

								$nbjloc += $nbjlocadeduire;
								$nbjlocass += $nbjlocadeduire;
								// $totalht += $nbjloc * $loyer;						
								//if($loc->getContributionverte() == 1)
								//{
									 //$contributionverte += 0.0215 * $loyer * $nbjloc;
								//}

					}echo 'assurance'.$locata->getAssurance();
					$facture  = $em->getRepository('BaclooCrmBundle:Factures')		
								   ->findOneBy(array('locatacloneid'=> $locata->getId(), 'typedoc'=> 'facture'));
					echo ' CARB '.$montantcarb;
					$totalhtfac = $totalht + $locata->getTransportaller() + $locata->getTransportretour() + $locata->getAssurance() + $contributionverte + $montantcarb + $totalvente - ($totalht*$locata->getRemise()/100);
					echo 'TOTALHTFACT'.$totalhtfac;
					$facture->setTotalht($totalhtfac);
					if($client->getTypeclient() == 'export')
					{
						$facture->setTotalttc($totalhtfac);
					}
					else
					{
						$facture->setTotalttc($totalhtfac * 1.2);
					}								   
					$locata->setMontantloc($totalht);
					$locata->setMontantcarb($montantcarb);
					$locata->setContributionverte($contributionverte);
					$em->persist($locata);
					$em->persist($facture);
					$em->flush();
echo ' total nas fac'.$facture->getTotalttc();					
				}
				if(isset($refusee) && $refusee == 1 && $offreencours == 1)
				{
					foreach ($locata->getLocationsclone() as $loc)
					{				
						//Insertion du code location à la machine
						$codelocations = $loc->getId();	
						$debutloc = $loc->getDebutloc();
						$finloc = $loc->getFinloc();					
						$code = $loc->getCodemachineinterne();					
						// echo $codelocations;	
					}
					foreach ($locata->getLocationsslclone() as $loc)
					{				
						//Insertion du code location à la machine
						$codelocations = $loc->getId();	
						$debutloc = $loc->getDebutloc();
						$finloc = $loc->getFinloc();					
						$code = $loc->getCodemachineinterne();					
						// echo $codelocations;
				
						$refusloc = $em->getRepository('BaclooCrmBundle:Locationssl')
								->findOneById($codelocations);
						$refusloc->setEtatloc('Refusé');$refusloc->setEtatlog('Refusé');
						$locata->setContrat(0);
						$em->persist($refusloc);
						// $em->flush();	
					}						
				}				
				// echo 'ttttt';echo $locid;
				$em->persist($locata);
				$em->flush();	
			//Fin maj table machine
			// $em = $this->getDoctrine()->getManager();
				if($locid == 0)
				{
					$result = $em->getRepository('BaclooCrmBundle:Locataclone')
							->findOneBy(array('clientid' => $client->getId(), 'datemodif' => $today, 'nomchantier' => $nomchantier, 'user' => $objUser), array('id' => 'DESC'));

					$locid = $result->getId();
				}
				if(!isset($erreur)){$erreur = 0;}				
				// On redirige vers la page de visualisation de la fiche nouvellement créée
				return $this->redirect($this->generateUrl('bacloocrm_modifierfacture', array('ficheid' => $ficheid, 'locid' => $locid, 'erreur' => $erreur)));
			}
		}
		$listedispos = array();
		if($locid > 0)
		{//echo 'laaa';
			$grille  = $em->getRepository('BaclooCrmBundle:Grille')		
						   ->findByCodeclient($locata->getClientid());	
						   
			$factures = $em->getRepository('BaclooCrmBundle:Factures')
							->findOneBy(array('locatacloneid'=> $locid, 'typedoc'=> 'facture'));			

			$totalht = $locata->getMontantloc();
			$assurance = $locata->getAssurance();
			$contributionverte = $locata->getContributionverte();
			$montantcarb = $locata->getMontantcarb();
			$montantvente = 0;			
			$totalvente = 0;			
			foreach($locata->getLocataventesclone() as $ven)
			{
				$montantvente = $ven->getQuantite() * $ven->getPu();
				$totalvente += $ven->getQuantite() * $ven->getPu();
				// $em->flush();
			}						   
		}
		else
		{//echo 'ici';
			$totalht = 0;
			$nbjloc = 0;
			$nbjlocass = 0;
			$totalvente = 0;
			$grille = array();
		}//echo 'TOTALHTAAAa'.$totalht;
		
		$factures = $em->getRepository('BaclooCrmBundle:Factures')		
					   ->findOneByCodelocata($locid);	
		if(isset($factures)){$afac = 'ok';}else{$afac = 'nok';}		   
		$userdetails  = $em->getRepository('BaclooUserBundle:User')		
					   ->findOneByUsername($objUser);
		$roleuser = $userdetails->getRoleuser();		
			// echo $grille;
			
	//On regarde dans les factures si deja compta		
		if(isset($factures))
		{
			$proforma = 'ok';	
		}
		else
		{
			if($client->getDelaireglement() == 1)
			{
				$proforma = 'nok';
			}
			else
			{
				$proforma = 'ok';
			}

		}
// echo 'totalhtfacFIN'.$facture->getTotalht();echo 'bumfact'.$facture->getNumfacture();
		return $this->render('BaclooCrmBundle:Crm:modifier_facture.html.twig', array('form' => $form->createView(),
																			'date' => $today,
																			'roleuser' => $roleuser,
																			'client' => $client,
																			'contrat' => $contrat,
																			'bdcrecu' => $bdcrecu,
																			'usersociete' => $societe,
																			'modules' => $modules,
																			'listedispos' => $listedispos,
																			'entreprise' => $client->getRaisonSociale(),
																			'id' => $ficheid,
																			'erreur' => $erreur,
																			'locid' => $locid,
																			'totalht' => $totalht,
																			'montantlocavente' => $totalvente,
																			'assurance' => $assurance,
																			'contributionverte' => $contributionverte,
																			'montantcarb' => $montantcarb,
																			'grille' => $grille,
																			'afac' => $afac,
																			'proforma' => $proforma,
																			'user' => $objUser));
	}
	
	public function removefactureAction($numfacture, $locatacloneid, $type)
	{
		$em = $this->getDoctrine()->getManager();
		$previous = $this->get('request')->server->get('HTTP_REFERER');

			$facture  = $em->getRepository('BaclooCrmBundle:Factures')		
						   ->findOneByNumfacture($numfacture);	
		if($type == 'location')
		{
			$locataclone  = $em->getRepository('BaclooCrmBundle:Locataclone')		
						   ->findOneById($locatacloneid);	

			$locata = $em->getRepository('BaclooCrmBundle:Locataclone')		
						   ->findOneById($facture->getCodelocata());
			if(isset($locataclone))
			{				
				$locatadorigineid = $locataclone->getOldid();

				foreach($locataclone->getLocationsclone() as $loca)
				{
					$locationsid = $loca->getOldid();
					$locations = $em->getRepository('BaclooCrmBundle:Locations')		
						->findOneById($locationsid);
					$locations->setCloture(0);
					$em->persist($locations);
					$em->remove($loca);	
					$em->flush();
				}

				foreach($locataclone->getLocationsslclone() as $locas)
				{
					$locationsid = $locas->getOldid();
					$locations = $em->getRepository('BaclooCrmBundle:Locationssl')		
						->findOneById($locationsid);
					$locations->setCloture(0);
					$em->persist($locations);									
					$em->remove($locas);	
					$em->flush();
				}					
				$em->remove($locataclone);
			}
		}
		elseif($type == 'vente')
		{echo 'vente';echo $locatacloneid;
			$venda  = $em->getRepository('BaclooCrmBundle:Venda')		
						   ->findOneById($locatacloneid);
						   
			if(isset($venda))
			{
				$venda->setBdcrecu(0);
				$em->persist($venda);	
				$em->flush();
			}
		}
		$facture->setClientid(0);
		$facture->setClient('Erreur logiciel');
		$facture->setEcheance('');
		$facture->setDatepaiement('');
		$facture->setTotalht(0);
		$facture->setTotalttc(0);
		$facture->setEncompta(0);
		$facture->setCodelocata(0);
		$facture->setLocatacloneid(0);
		$facture->setReglement(1);
		$facture->setMontantdejareg(0);
		$em->persist($facture);	
		$em->flush();
		return $this->redirect($this->generateUrl('bacloocrm_compta', array('vue' => 'locations')));		
	}
	
	public function removefacturedefAction($numfacture, $locatacloneid)
	{
		$em = $this->getDoctrine()->getManager();
		$previous = $this->get('request')->server->get('HTTP_REFERER');

			$facture  = $em->getRepository('BaclooCrmBundle:Factures')		
						   ->findOneByNumfacture($numfacture);	
			$mode = $facture->getTypedoc();
		if($facture->getTypedoc() == 'locations')
		{
			$locataclone  = $em->getRepository('BaclooCrmBundle:Locataclone')		
						   ->findOneById($locatacloneid);
			if(isset($locataclone))
			{				
				$locatadorigineid = $locataclone->getOldid();	

				$locatadorigine  = $em->getRepository('BaclooCrmBundle:Locata')		
							   ->findOneById($locatadorigineid);

				foreach($locataclone->getLocationsclone() as $loca)
				{
					$em->remove($loca);	
					// $em->flush();
				}
				
				foreach($locatadorigine->getLocations() as $locat)
				{
					$locationsid = $locat->getId();
					$locations = $em->getRepository('BaclooCrmBundle:Locations')		
						->findOneById($locationsid);
					$locations->setCloture(0);
					$em->persist($locations);
				}
				
				foreach($locataclone->getLocationsslclone() as $locas)
				{
					$em->remove($locas);	
					// $em->flush();
				}
				
				foreach($locatadorigine->getLocationssl() as $locast)
				{
					$locationsid = $locast->getId();echo 'LOCATIONSID '.$locationsid;
					$locations = $em->getRepository('BaclooCrmBundle:Locationssl')		
						->findOneById($locationsid);
					$locations->setCloture(0);
					$em->persist($locations);
				}					
				$em->remove($locataclone);
			}
			$em->remove($facture);	
			$em->remove($locataclone);	
			$em->flush();
		}
		elseif($facture->getTypedoc() == 'bon de commande')
		{
			$locatafrsclone  = $em->getRepository('BaclooCrmBundle:Locatafrsclone')		
						   ->findOneById($locatacloneid);
			if(isset($locatafrsclone))
			{				
				$locatadorigineid = $locatafrsclone->getOldid();	

				$locatadorigine  = $em->getRepository('BaclooCrmBundle:Locatafrs')		
							   ->findOneById($locatadorigineid);

				foreach($locatafrsclone->getLocationsfrsclone() as $loca)
				{
					$em->remove($loca);	
					// $em->flush();
				}
				
				foreach($locatadorigine->getLocationsfrs() as $locat)
				{
					$locationsid = $locat->getId();
					$locationsfrs = $em->getRepository('BaclooCrmBundle:Locationsfrs')		
						->findOneById($locationsid);
					$locationsfrs->setCloture(0);
					$em->persist($locationsfrs);
				}
												
				$em->remove($locatafrsclone);
			}
			$em->remove($facture);	
			$em->remove($locatafrsclone);	
			$em->flush();
		}
		if($mode == 'locations')
		{
			return $this->redirect($this->generateUrl('bacloocrm_compta', array('vue' => 'locations')));				
		}
		else
		{
			return $this->redirect($this->generateUrl('bacloocrm_compta', array('vue' => 'achats')));
		}
	}
	
	public function recupfactureAction($numfacture, $locatacloneid, $vue, $mode, $page, Request $request)
	{
		$em = $this->getDoctrine()->getManager();
		$previous = $this->get('request')->server->get('HTTP_REFERER');

		$facture  = $em->getRepository('BaclooCrmBundle:Factures')		
					   ->findOneByNumfacture($numfacture);

		$codelocata = $facture->getCodelocata();
		if($codelocata[0] == 'V')
		{
			$typefact = 'vente';
			$vue = 'locations';
			$locataclone  = $em->getRepository('BaclooCrmBundle:Locataclone')		
						   ->findOneById($locatacloneid);
			$afacturer  = $em->getRepository('BaclooCrmBundle:Afacturer')		
							   ->findByPiece($numfacture);
		}
		elseif($facture->getTypedoc() == 'bon de commande')
		{
			$typefact = 'achats';
			$vue = 'achats';
			$locatafrsclone  = $em->getRepository('BaclooCrmBundle:Locatafrsclone')		
						   ->findOneById($locatacloneid);
			$afacturer  = $em->getRepository('BaclooCrmBundle:Afacturer')		
							   ->findByPiece($facture->getNumfacfrs());
		}
		else
		{
			$typefact = 'location';
			$vue = 'locations';
			$afacturer  = $em->getRepository('BaclooCrmBundle:Afacturer')		
							   ->findByPiece($numfacture);
		}
					   
		// $locatadorigineid = $locataclone->getOldid();

		foreach($afacturer as $afact)
		{
			// echo 'id afact'; echo $afact->getId();
			$afactu = $em->getRepository('BaclooCrmBundle:Afacturer')		
				->findOneById($afact->getId());
			
			$em->remove($afactu);
		}
		
		if($typefact == 'location')
		{
			foreach($locataclone->getLocationsclone() as $locas)
			{
				$locas->setDef(0);
				// $em->persist($locas);
			}

			foreach($locataclone->getLocationsslclone() as $locass)
			{
				$locass->setDef(0);
				// $em->persist($locass);
			}
		}
		
		if($typefact == 'achats')
		{
			foreach($locatafrsclone->getLocationsfrsclone() as $locas)
			{
				$locas->setDef(0);
				// $em->persist($locas);
			}
		}
		$facture->setEncompta(0);
		// $em->persist($facture());
		$em->flush();
		return $this->redirect($this->generateUrl('bacloocrm_compta', array('vue' => $vue, 'mode' => $mode, 'page' => $page)));		
	}
	
	public function remettreenlocAction($locataid, $ecode)
	{
		$em = $this->getDoctrine()->getManager();
		$previous = $this->get('request')->server->get('HTTP_REFERER');

		$locata  = $em->getRepository('BaclooCrmBundle:Locata')		
					   ->findOneById($locataid);
		
		foreach($locata->getLocations() as $loca)
		{echo 'location';echo $loca->getCodemachineinterne();
			if($loca->getCodemachineinterne() == $ecode)
			{		
				$loca->setEtatloc('En location');
				$loca->setEtatlog('Livré chez le client');
				$loca->setCloture(0);
				
				$machines = $em->getRepository('BaclooCrmBundle:Machines')		
							   ->findOneBy(array('code' => $loca->getCodemachineinterne(), 'original' => 1));
				if(!isset($machines))
				{
					$machines = $em->getRepository('BaclooCrmBundle:Machinessl')		
								   ->findOneBy(array('code' => $loca->getCodemachineinterne(), 'original' => 1));		
				}
echo ' LA MACHINE'.$machines->getCode();				
				$machines->setCodelocations($loca->getId());
				$machines->setCodecontrat($locataid);
				$machines->setClientid($loca->getCodeclient());
				$machines->setEntreprise($loca->getEntreprise());
				$machines->setNomchantier($locata->getNomchantier());
				$machines->setDebutloc($loca->getDebutloc());
				$machines->setFinloc($loca->getFinloc());
				$machines->setEtat('En location');
				$machines->setEtatlog('Livré chez le client');
				$em->persist($machines);
				$em->persist($loca);
				
				$locationsclone = $em->getRepository('BaclooCrmBundle:Locationsclone')		
							   ->findBy(array('oldid' => $loca->getId()));
				if(isset($locationsclone))
				{
					foreach($locationsclone as $loco)
					{
						$loco->setEtatloc('En location');
						$loco->setCloture(0);
						$em->persist($loco);
					}
				}							   
				$em->flush();				
			}
		}
		
		foreach($locata->getLocationssl() as $loca)
		{
			if($loca->getCodemachineinterne() == $ecode)
			{		
				$loca->setEtatloc('En location');
				$loca->setEtatlog('Livré chez le client');
				$loca->setCloture(0);
				
				$machines  = $em->getRepository('BaclooCrmBundle:Machines')		
							   ->findOneBy(array('code' => $loca->getCodemachineinterne(), 'original' => 1));
				if(!isset($machine))
				{
					$machines  = $em->getRepository('BaclooCrmBundle:Machinessl')		
								   ->findOneBy(array('code' => $loca->getCodemachineinterne(), 'original' => 1));		
				}
				
				$machines->setCodelocations($loca->getId());
				$machines->setCodecontrat($locataid);
				$machines->setClientid($loca->getCodeclient());
				$machines->setEntreprise($loca->getEntreprise());
				$machines->setNomchantier($locata->getNomchantier());
				$machines->setDebutloc($loca->getDebutloc());
				$machines->setFinloc($loca->getFinloc());
				$machines->setEtat('En location');
				$em->persist($machines);
				$em->persist($loca);
				
				$locationsslclone = $em->getRepository('BaclooCrmBundle:Locationsslclone')		
							   ->findBy(array('oldid' => $loca->getId()));
				if(isset($locationsslclone))
				{
					foreach($locationsslclone as $loco)
					{
						$loco->setEtatloc('En location');
						$loco->setCloture(0);
						$em->persist($loco);
					}
				}
				$em->flush();				
			}
		}

		$fiche  = $em->getRepository('BaclooCrmBundle:Fiche')		
					   ->findOneById($locata->getClientid());

		return $this->redirect($this->generateUrl('bacloocrm_ajouterlocation', array('ficheid' => $fiche->getId(), 'locid' => $locataid )));				
		
	}
	
	public function removebdcAction($numfacture, $locatacloneid)
	{//$id = id ligne partenaire
		$em = $this->getDoctrine()->getManager();
		$previous = $this->get('request')->server->get('HTTP_REFERER');

			$facture  = $em->getRepository('BaclooCrmBundle:Factures')		
						   ->findOneByNumfacture($numfacture);	

			$locatafrsclone  = $em->getRepository('BaclooCrmBundle:Locatafrsclone')		
						   ->findOneById($locatacloneid);

			foreach($locatafrsclone->getLocationsfrsclone() as $loca)
			{
				$locationsid = $loca->getOldid();
				$locations = $em->getRepository('BaclooCrmBundle:Locationsfrs')		
					->findOneById($locationsid);
				$locations->setCloture(0);				
				$em->remove($loca);
			}
			$em->remove($facture);	
			$em->remove($locatafrsclone);	
			$em->flush();	
			return $this->redirect($this->generateUrl('bacloocrm_compta', array('vue' => 'achats')));						
	}
	
	public function removebdcficheAction($locid)
	{//$id = id ligne partenaire
		$em = $this->getDoctrine()->getManager();

		$locatafrs = $em->getRepository('BaclooCrmBundle:Locatafrs')		
					   ->findOneById($locid);
					   
		$ficheid = $locatafrs->getFournisseurid();
		foreach($locatafrs->getLocationsfrs() as $loca)
		{			
			$em->remove($loca);
		}
		$em->remove($locatafrs);	
		$em->flush();	
		return $this->redirect($this->generateUrl('bacloocrm_voir', array('id' => $ficheid)));						
	}

	public function statfiAction($dStart, $dEnd, Request $request)
	{
		$defaultData = array();
		// $dStart = 0;
		// $dEnd = 0;		
		$form = $this->createFormBuilder($defaultData)
			->add('du', 'date', array('widget' => 'single_text',
										'input' => 'string',
										'format' => 'dd/MM/yyyy',
										'required' => false,
										'attr' => array('class' => 'date'),
										))
			->add('au', 'date', array('widget' => 'single_text',
										'input' => 'string',
										'format' => 'dd/MM/yyyy',
										'required' => false,
										'attr' => array('class' => 'date'),
										))
			->getForm();
		if($request->getMethod() == 'POST') {//echo 'VALIDE';		
			$form->handleRequest($request);
			$data = $form->getData();//var_dump($data);
			if(isset($data['du']))
			{
				$dStart = $data['du'];	
			}
			if(isset($data['au']))
			{
				$dEnd = $data['au'];
			}
		return $this->redirect($this->generateUrl('bacloocrm_statsvendeurs', array('dstart' => $dStart, 'dend' => $dEnd)));
		}
// echo 'dend '.$dEnd;
		if($dStart == 0)
		{
			$dStart = date('Y-m-d', strtotime("-6 months"));
		}

		if($dEnd == 0)
		{
			$dEnd = date('Y-m-d');
		}
// echo $dStart;			
			// $dEnd = '2018-11-30';
			
		//1.Récupérer les données de la table Faccture
			$em = $this->getDoctrine()->getManager();
			
			$today = date('Y-m-d');
			$prev12 = date('Y-m-d', strtotime("-12 months"));			
			$ventespackdumois  = $em->getRepository('PaymentBundle:Payment')		
						   ->ventespackdumois();	
						   
			$comptepackdumois  = $em->getRepository('PaymentBundle:Payment')		
						   ->comptepackdumois();
			$ventesleadsmois  = $em->getRepository('BaclooCrmBundle:Transaction')		
						   ->ventesleadsmois();
			if(!isset($ventesleadsmois)){$ventesleadsmois = 0;}	
			
			$compteleadsmois  = $em->getRepository('BaclooCrmBundle:Transaction')		
						   ->compteleadsmois();
			if(!isset($compteleadsmois)){$compteleadsmois = 0;}	
			
			$capacks  = $em->getRepository('PaymentBundle:Payment')		
						   ->capacks($dStart, $dEnd);
						   
			$caleads  = $em->getRepository('BaclooCrmBundle:Transaction')		
						   ->caleads($dStart, $dEnd);	
		
// echo '$$$$$$'.print_r($ca);	echo '<<<<<';		   
		//2.On génère les entêtes de colonnes à partir de la fonction createplanning
			$iStart = strtotime ($dStart);//Formate une date/heure locale avec la Something is wronguration locale
			$iEnd = strtotime ($dEnd);
			if (false === $iStart || false === $iEnd) {
				// return false;
			}
			$aStart = explode ('-', $dStart);
			$aEnd = explode ('-', $dEnd);
			if (count ($aStart) !== 3 || count ($aEnd) !== 3) {
				// return false;
			}
			// if (false === checkdate ($aStart[1], $aStart[2], $aStart[0]) || false === checkdate ($aEnd[1], $aEnd[2], $aEnd[0]) || $iEnd <= $iStart) {
				// return false;
			// }
			for ($i = $iStart; $i < $iEnd + 86400; $i = strtotime ('+1 day', $i) ) {
				$sDateToArr = strftime ('%Y-%m-%d', $i);
				$sYear = substr ($sDateToArr, 0, 4);
				$sMonth = substr ($sDateToArr, 5, 2);
				$aDates[$sYear][$sMonth][] = $sDateToArr;
			}
			
			$nbannee = 0;
			$nbmoisparannee = 0;
			//Calcule le nombre de jours dans le mois
			$annee1 = date("Y", strtotime($dStart));
			$anneef = date("Y", strtotime($dStart));
			$anneefin = $anneef + 1;
			
			//Boucle parcours tableau année, mois, jours.
			//Celle-ci renvoie le nombre de  jours du premier mois m1
			$m11 = 1;
			foreach($aDates as $annee => $moiss)
			{
				foreach($moiss as $date => $mois)
				{
					if($m11 == 1)//si on est en m1 on procède sinon break
					{
						foreach($mois as $dat)
						{						
							$m11++;
						}
					}
					else
					{
						break;
					}
				}
				
			}
			$m1 = $m11-1;
			//Calcul du nb total de mois $m
			$m = 0;
			foreach($aDates as $annee => $moiss)
			{
				foreach($moiss as $date => $mois)
				{
					$m++;
				}
				
			}
			
			//Calcul du nb total d'années $a
			$an = 0;
			foreach($aDates as $annee => $moiss)
			{
				$an++;				
			}
// echo $m;			
			//Celle-ci renvoie le nombre de jours du dernier mois mm
			$mm = 0;
			$compteurm = 1;
			foreach($aDates as $annee => $moiss)
			{
				foreach($moiss as $date => $mois)
				{
					if($compteurm == $m)//si on est le dernier mois
					{
						foreach($mois as $dat)
						{						
							$mm++;
						}
					}
					else
					{}
				$compteurm++;
				}
				
			}
			
			//Celle-ci renvoie le nombre de jours de la première année $a1
			$a11 = 1;
			foreach($aDates as $annee => $moiss)
			{
				if($a11 == 1)//si on est en a1 on procède sinon break
				{
					foreach($moiss as $date => $mois)
					{
						foreach($mois as $dat)
						{						
							$a11++;
						}
					}
				}
				else
				{
					break;
				}
			}
			$a1 = $a11-1;
			//Fonction qui calcule le nombre de jours dans l'année
			function cal_days_in_year($year){
				$days=0; 
				for($month=1;$month<=12;$month++){ 
					$days = $days + cal_days_in_month(CAL_GREGORIAN,$month,$year);
				 }
			return $days;
			}			
			//Celle-ci renvoie le nombre de jours de la dernière année $aa
			$aa = 0;
			$compteura = 1;//echo '$an'.$an;
			foreach($aDates as $annee => $moiss)
			{
				if($compteura == $an)//si on est en end ernière année on calcule le nb de jours $aa
				{
					foreach($moiss as $date => $mois)
					{
						foreach($mois as $dat)
						{						
							$aa++;
						}
					}
				}
				elseif($compteura > $an)
				{
					break;
				}
				$compteura++;
			}//echo 'aa'.$aa;echo 'compteura'.$compteura;
			// echo 'www'.$mm.'www';
			// $mm = 0; //Compteur de mois qui s'incrémente de 1 afin de faire un compte indépendant des mois.
			$nbjrparmois = 0;
			$i = 1; //Compteur pour premier mois
			$a = 1; //Compteur pour la première année
			$nbmois = array();
			$nbjannee = array();
			foreach($aDates as $annee => $moiss)
			{	
				//Calculer le nombre d'années
				// echo $annee;
				if($a == 1)//Si on est en première année
				{
					$nbjannee[] = $a1;//nb de jours de la première année
				}
				elseif($a == $an)
				{
					$nbjannee[] = $aa;
				}
				else
				{
					$nbjannee[] = cal_days_in_year($annee);
				}
				foreach($moiss as $date => $mois)
				{
					if($i == 1)//on est au premier mois
					{
						//nb jours mois courant
						$nbmois[] = $m1;
					}
					elseif($i == $m)//Si on est  le dernier mois de la période on met le nb de jours
					{
						//nb de jours du dernier mois
						$nbmois[] = $mm;
					}
					else
					{
						//Pour les autres mois
						$nbmois[] = cal_days_in_month(CAL_GREGORIAN, $date, $annee);
					}
					$i++;
				}
				$a++;
			}
// partie calcul ca loc
			$dEnda = date('Y-m-d');
			$dEnda2 = date('Y-m-t');
			// $dStart = '2018-10-31';
			$dStarta = date('Y-m-d', strtotime("-20 days"));
			$dStarta2 = date('Y-m-01');
			// $dEnd = '2018-11-30';
// var_dump($calocjour);	

				include('nbjourscamois.php');		   			   
		//2.On génère les entêtes de colonnes à partir de la fonction createplanning
			$iStart = strtotime ($dStarta);//Formate une date/heure locale avec la Something is wronguration locale
			$iEnd = strtotime ($dEnda);
			if (false === $iStart || false === $iEnd) {
				return false;
			}
			$aStart = explode ('-', $dStarta);
			$aEnd = explode ('-', $dEnda);
			if (count ($aStart) !== 3 || count ($aEnd) !== 3) {
				return false;
			}
			if (false === checkdate ($aStart[1], $aStart[2], $aStart[0]) || false === checkdate ($aEnd[1], $aEnd[2], $aEnd[0]) || $iEnd <= $iStart) {
				// return false;
			}
			for ($i = $iStart; $i < $iEnd + 86400; $i = strtotime ('+1 day', $i) ) {
				$sDateToArra = strftime ('%Y-%m-%d', $i);
				$sYear = substr ($sDateToArra, 0, 4);
				$sMonth = substr ($sDateToArra, 5, 2);
				$aDatesa[$sYear][$sMonth][] = $sDateToArra;
			}
			
			$nbanneea = 0;
			$nbmoisparanneea = 0;
			//Calcule le nombre de jours dans le mois
			$annee1 = date("Y", strtotime($dStart));
			$anneef = date("Y", strtotime($dStart));
			$anneefin = $anneef + 1;
			
			//Boucle parcours tableau année, mois, jours.
			//Celle-ci renvoie le nombre de  jours du premier mois m1
			$m11a = 1;
			foreach($aDatesa as $anneea => $moissa)
			{
				foreach($moissa as $datea => $moisa)
				{
					if($m11a == 1)//si on est en m1 on procède sinon break
					{
						foreach($moisa as $data)
						{						
							$m11a++;
						}
					}
					else
					{
						break;
					}
				}
				
			}
			$m1a = $m11a-1;
			//Calcul du nb total de mois $m
			$ma = 0;
			foreach($aDatesa as $anneea => $moissa)
			{
				foreach($moissa as $datea => $moisa)
				{
					$ma++;
				}
				
			}
			
			//Calcul du nb total d'années $a
			$ana = 0;
			foreach($aDatesa as $anneea => $moissa)
			{
				$ana++;				
			}
// echo $ma;			
			//Celle-ci renvoie le nombre de jours du dernier mois mm
			$mma = 0;
			$compteurma = 1;
			foreach($aDatesa as $anneea => $moissa)
			{
				foreach($moissa as $datea => $moisa)
				{
					if($compteurma == $ma)//si on est le dernier mois
					{
						foreach($moisa as $data)
						{						
							$mma++;
						}
					}
					else
					{}
				$compteurma++;
				}
				
			}
			
			//Celle-ci renvoie le nombre de jours de la première année $a1
			$a11a = 1;
			foreach($aDatesa as $anneea => $moissa)
			{
				if($a11a == 1)//si on est en a1 on procède sinon break
				{
					foreach($moissa as $datea => $moisa)
					{
						foreach($moisa as $data)
						{						
							$a11a++;
						}
					}
				}
				else
				{
					break;
				}
			}
			$a1a = $a11a-1;
			//Fonction qui calcule le nombre de jours dans l'année

				
			//Celle-ci renvoie le nombre de jours de la dernière année $aa
			$aaa = 0;
			$compteuraa = 1;
			foreach($aDatesa as $anneea => $moissa)
			{
				if($compteuraa == $ana)//si on est en end ernière année on calcule le nb de jours $aa
				{
					foreach($moissa as $datea => $moisa)
					{
						foreach($moisa as $data)
						{						
							$aaa++;
						}
					}
				}
				else
				{
					break;
				}
				$compteuraa++;
			}
			// echo 'www'.$mm.'www';
			// $mma = 0; //Compteur de mois qui s'incrémente de 1 afin de faire un compte indépendant des mois.
			$nbjrparmoisa = 0;
			$ia = 1; //Compteur pour premier mois
			$aa = 1; //Compteur pour la première année
			$nbmoisaa = array();
			$nbjanneeaa = array();
			foreach($aDatesa as $anneea => $moissa)
			{	
				//Calculer le nombre d'années
				// echo $anneea;
				if($aa == 1)//Si on est en première année
				{
					$nbjanneea[] = $a1a;//nb de jours de la première année
				}
				elseif($aa == $ana)
				{
					$nbjanneea[] = $aa;
				}
				else
				{
					$nbjanneea[] = cal_days_in_year($anneea);
				}
				foreach($moissa as $datea => $moisa)
				{
					if($ia == 1)//on est au premier mois
					{
						//nb jours mois courant
						$nbmoisa[] = $m1a;
					}
					elseif($ia == $ma)//Si on est  le dernier mois de la période on met le nb de jours
					{
						//nb de jours du dernier mois
						$nbmoisa[] = $mma;
					}
					else
					{
						//Pour les autres mois
						$nbmoisa[] = cal_days_in_month(CAL_GREGORIAN, $datea, $anneea);
					}
					$ia++;
				}
				$aa++;
			}
			

			//NB de départs
				$today = date('D');
				
				if($today == 'Fri')
				{
					$datelivraison = date('Y-m-d', strtotime("+3 days"));
				}
				elseif($today == 'Sat')
				{
					$datelivraison = date('Y-m-d', strtotime("+2 days"));
				}
				else
				{
					$datelivraison = date('Y-m-d', strtotime("+1 days"));
				}
				$livraisonsok = $em->getRepository('BaclooCrmBundle:Locata')
				->findByEtatloca2('Prêt pour le chargement', 'En cours de livraison', $datelivraison);//echo $datelivraison;
		// print_r($livraisonsok);
				$livraisonsoksl = $em->getRepository('BaclooCrmBundle:Locata')
				->findByEtatlocasl2('Prêt pour le chargement', 'En cours de livraison', $datelivraison);
				
				$b = 0;
				foreach($livraisonsok as $ret)
				{
					foreach($ret->getLocations() as $di )
					{
						if($di->getDebutloc() == $datelivraison)
						{
							$b++;
						}
					}
				}
				
				foreach($livraisonsoksl as $ret)
				{
					foreach($ret->getLocationssl() as $di )
					{
						if($di->getDebutloc() == $datelivraison)
						{
							$b++;
						}
					}
				}
			//Fin nb de départs
			
			//Nb de retours
				$now = date('Y-m-d');
				if($today == 'Fri')
				{
					$date = date('Y-m-d', strtotime("+3 days"));
				}
				elseif($today == 'Sat')
				{
					$date = date('Y-m-d', strtotime("+2 days"));
				}
				elseif($today == 'Sun')
				{
					$date = date('Y-m-d', strtotime("+1 days"));
				}
				else
				{
					$date = date('Y-m-d');
				}
				
				$retours = $em->getRepository('BaclooCrmBundle:Locata')
				->retours($now);

				$i = 0;
				foreach($retours as $ret)
				{
					foreach($ret->getLocations() as $di )
					{
						if($di->getFinloc() == $now)
						{
							$i++;
						}
					}
				}
				
				$retourssl = $em->getRepository('BaclooCrmBundle:Locata')
				->retourssl($now);

				foreach($retourssl as $ret)
				{
					foreach($ret->getLocationssl() as $di )
					{
						if($di->getFinloc() == $now)
						{
							$i++;
						}
					}
				}	
			$commerciaux = array('Stripe','Mike','jmr');			
			$cacommerciaux  = $em->getRepository('BaclooCrmBundle:Factures')		
						   ->last12mca3commerciaux($dStart, $dEnd);//print_r($cacommerciaux);	
			//Fin nb de retours
			return $this->render('BaclooCrmBundle:Crm:statfi.html.twig', array(
					'retours' => $i,
					'departs' => $b,
					'today' => $today,
					'dates' => $aDates,
					'datesa' => $aDatesa,
					'datesa2' => $aDatesa2,
					'dstart' => $dStart,
					'dstarta' => $dStarta,
					'dstarta2' => $dStarta2,
					'dend' => $dEnd,
					'denda' => $dEnda,
					'cacommerciaux' => $cacommerciaux,
					'ventespackdumois' => $ventespackdumois,
					'comptepackdumois' => $comptepackdumois,
					'ventesleadsmois' => $ventesleadsmois,
					'compteleadsmois' => $compteleadsmois,
					'capacks' => $capacks,
					'caleads' => $caleads,
					'ansa' => $ana,
					'ans' => $an,
					// 'commerciaux' => $commerciaux,
					'nbjannee' => $nbjannee,
					'nbjanneea' => $nbjanneea,
					'form' => $form->createView(),
					'nbmois' => $nbmois,
					'nbmoisa' => $nbmoisa,
					'commerciaux' => $commerciaux
			));		
	}
	
	public function statcomAction(Request $request)
	{//$id = id ligne partenaire
		include('societe.php');
		$nomsociete = $societe;
		$session = new Session();
		$session = $request->getSession();
		$usersess = $this->get('security.context')->getToken()->getUsername();
		$em = $this->getDoctrine()->getManager();
		$user  = $em->getRepository('BaclooUserBundle:User')		
					   ->findOneByUsername($usersess);

		// echo 'testfichespipe'.$testfichespipe;
		//Protect double connexion
		$session = $request->getSession();
		$sessionId = $session->getId();
		// echo $sessionId;
		// echo 'xxxxx'.$user->getLogged();
		// echo '  '.$user->getUsername();
		if($user->getLogged() != $sessionId)
		{
			return $this->redirect($this->generateUrl('fos_user_security_logout'));
		}
		//Fin protect double connexion

		// if($user->getRoleuser() != 'admin' && $user->getUsersociete() != null)
		if($user->getRoleuser() != 'admin' && $user->getUsersociete() != $societe)
		{
			$societe = $user->getNomrep();
			// $url = 'http://127.0.0.1/symfony2/web/b/lamiecaline/web/app_dev.php/login';
			$url = 'https://www.bacloo.fr/b/'.$societe.'/web/app.php';
			return $this->redirect($url);
		}
		
		if($user->getRoleuser() == 'admin' && $user->getUsersociete() != $societe)
		{
			$societe = $user->getNomrep();
			// $url = 'http://127.0.0.1/symfony2/web/b/lamiecaline/web/app_dev.php/login';
			$url = 'https://www.bacloo.fr/b/'.$societe.'/web/app.php';
			return $this->redirect($url);
		}
		
		
		//Ici on met à jour la société au cas l'admin aurait créé sont Bacloo perso après avoir importé son fichier
		// if($user->getRoleuser() == 'admin')
		// {
			// $fiches = $em->getRepository('BaclooCrmBundle:Fiche')
							   // ->findBy(array('user' => $usersess, 'usersociete' => NULL));
			// if(isset($fiche) && $fiches->getUsersociete() != $societe)
			// {
				// $fichesok = $em->getRepository('BaclooCrmBundle:Fiche')
								   // ->find($usersess);
				// foreach($fichesok as $fiche)
				// {
					// set_time_limit(300);
					// $fiche->setUsersociete($societe);
					// $em->persist($fiche);
				// }
				// $em->flush();
			// }

		// }
					   
		if($user->getRoleuser() != 'admin'){$useracc = $usersess;}
		if(isset($useracc))
		{
			if($useracc == 'societe')
			{
				//On calcule critères
				$i = 1;
				$em = $this->getDoctrine()->getManager();
				$listuser = $em->getRepository('BaclooUserBundle:User')
							   ->findBy(array('usersociete' => $societe));				
				foreach($listuser as $listu)
				{						
					${'choix'.$i++} = $listu->getUsername();
				}
				//echo 'choix1'.$choix1;
				$critere = array($usersess);
				
				for($j=1;$j<$i;$j++)
				{
					${'critere'.$j} = array(${"choix".$j});
					$critere = array_merge(${'critere'.$j},$critere);
				}
				$usersessok = $critere;
			}
			else
			{
				$usersessok = $useracc;
			}
		}
		else
		{
			$usersessok = $usersess;
		}

		if($usersess == 'anon.')
		{
			return $this->redirect($this->generateUrl('fos_user_security_login'));
		}

		$em = $this->getDoctrine()->getManager();
		$user  = $em->getRepository('BaclooUserBundle:User')		
					   ->findOneByUsername($usersess);
// echo '111'.$usersess;
		if($user->getRoleuser() != 'admin')
		{
			$userdetails  = $em->getRepository('BaclooUserBundle:User')		
				   ->findOneBy(array('roleuser'=> 'admin', 'usersociete' => $societe));
			// $usersess = $userdetails->getUsername();			
		}
// echo '222'.$usersess;		
				$query = $em->createQuery(
					'SELECT u.id
					FROM BaclooUserBundle:User u
					WHERE u.username = :username'
				)->setParameter('username', $usersess);
				$uid = $query->getSingleScalarResult();
				//On regarde si l'utilisateur connecté est déja entegistré dnas la table userpipe
				$userpipe = $em->getRepository('BaclooCrmBundle:Userpipe')
				->findOneByUserid($uid);			  
		
				//On récupère les pipelines de l'utilisateur connecté
				$em2 = $this->getDoctrine()
						   ->getManager()
						   ->getRepository('BaclooCrmBundle:Pipeline');
				$pipe = $em2->findByUsername($usersess);

				$pipe_zero = $em->getRepository('BaclooCrmBundle:Pipeline')
								->findByPipeorder(0);

				//On récupère les userpipe du user connecté
				$em2 = $this->getDoctrine()
						   ->getManager()
						   ->getRepository('BaclooCrmBundle:Userpipe');
				$userpipa = $em2->findOneByUserid($uid);

				if(empty($userpipa))
				{
					// echo 'pppppppooo'.$uid;
					$userpipe = new userpipe();
					$userpipe->setUserid($uid);
					$em = $this->getDoctrine()->getManager();
					$em->persist($userpipe);
					$em->flush();
					
					$em2 = $this->getDoctrine()
							   ->getManager()
							   ->getRepository('BaclooCrmBundle:Userpipe');
					$userpipo = $em2->findOneByUserid($uid);
					
					$pipe0 = new pipeline();
					$pipe0->setUserid($uid);
					$pipe0->setUsername($usersess);
					$pipe0->setPipename('---------');
					$pipe0->setPipeorder(0);				
					$pipe0->addUserpipe($userpipo);	
					$userpipo->addPipeline($pipe0);
					$em->persist($pipe0);
					$em->persist($userpipo);
					$em->flush();
					
					$pipe0 = new pipeline();
					$pipe0->setUserid($uid);
					$pipe0->setUsername($usersess);
					$pipe0->setPipename('Devis fait');
					$pipe0->setPipeorder(1);				
					$pipe0->addUserpipe($userpipo);	
					$userpipo->addPipeline($pipe0);
					$em->persist($pipe0);
					$em->persist($userpipo);
					$em->flush();
					
					$pipe0 = new pipeline();
					$pipe0->setUserid($uid);
					$pipe0->setUsername($usersess);
					$pipe0->setPipename('Affaires signées');
					$pipe0->setPipeorder(2);
					$pipe0->setRealise(true);				
					$pipe0->addUserpipe($userpipo);	
					$userpipo->addPipeline($pipe0);
					$em->persist($pipe0);
					$em->persist($userpipo);
					$em->flush();
					
					$pipe0 = new pipeline();
					$pipe0->setUserid($uid);
					$pipe0->setUsername($usersess);
					$pipe0->setPipename('Affaires perdues');
					$pipe0->setPipeorder(3);
					$pipe0->setPerdu(true);
					$pipe0->setExclusion(true);				
					$pipe0->addUserpipe($userpipo);	
					$userpipo->addPipeline($pipe0);
					$em->persist($pipe0);
					$em->persist($userpipo);
					$em->flush();				
				}
				else
				{
					$pipe_zero = $em->getRepository('BaclooCrmBundle:Pipeline')
						->findByPipeorder(0);
					if(empty($pipe_zero))
					{
						$em2 = $this->getDoctrine()
								   ->getManager()
								   ->getRepository('BaclooCrmBundle:Userpipe');
						$userpipo = $em2->findOneByUserid($uid);
						
						$pipe0 = new pipeline();
						$pipe0->setUserid($uid);
						$pipe0->setUsername($usersess);
						$pipe0->setPipename('---------');
						$pipe0->setPipeorder(0);				
						$pipe0->addUserpipe($userpipo);	
						$userpipo->addPipeline($pipe0);
						$em->persist($pipe0);
						$em->persist($userpipo);
						$em->flush();
					}					
				}					   

			$query = $em->createQuery(
				'SELECT p
				FROM BaclooCrmBundle:Pipeline p
				WHERE p.username = :username
				AND p.pipeorder > :pipeorder
				ORDER BY p.pipeorder ASC'
			)->setParameter('username', $usersess)
			->setParameter('pipeorder', 0);
						   
			$pipeselect = $query->getResult();
							 
			$nbpipe = count($pipeselect);
			if($nbpipe == 0){$nbpipe = 1;}
			$offset = round(12/$nbpipe, 0, PHP_ROUND_HALF_DOWN);	

			$today = date('Y-m-d');
			$prev30 = date('Y-m-d', strtotime("-29 days"));
			
		if(is_array($usersessok) == 1)
		{
			$fichespipe = $em->getRepository('BaclooCrmBundle:Fiche')
							 ->createpiplinearray($usersessok);
								 
			$em = $this->getDoctrine()->getManager();
			$nbevents  = $em->getRepository('BaclooCrmBundle:Fiche')		
						   ->last30eventarray($usersessok, $today, $prev30);
						   
			$capotbefore  = $em->getRepository('BaclooCrmBundle:Fiche')		
						   ->before30capotarray($usersess, $prev30);	
			if(empty($capotbefore)){$capotbefore = 0;}
			// echo 'capotbefore'.$capotbefore;
			$carealbefore  = $em->getRepository('BaclooCrmBundle:Fiche')		
						   ->before30carealarray($usersess, $prev30);
			if(empty($carealbefore)){$carealbefore = 0;}				   
						   
			$caperdubefore  = $em->getRepository('BaclooCrmBundle:Fiche')		
						   ->before30caperduarray($usersess, $prev30);
			if(empty($caperdubefore)){$caperdubefore = 0;}	
			
			$cachart  = $em->getRepository('BaclooCrmBundle:Ca')		
						   ->last30caarray($usersess, $today, $prev30);							 
		}
		else
		{
			$fichespipe = $em->getRepository('BaclooCrmBundle:Fiche')
							 ->createpipline($usersessok);
								 
			$em = $this->getDoctrine()->getManager();
			$nbevents  = $em->getRepository('BaclooCrmBundle:Fiche')		
						   ->last30event($usersessok, $today, $prev30);
						   
			$capotbefore  = $em->getRepository('BaclooCrmBundle:Fiche')		
						   ->before30capot($usersessok, $prev30);	
			if(empty($capotbefore)){$capotbefore = 0;}
			// echo 'capotbefore'.$capotbefore;
			$carealbefore  = $em->getRepository('BaclooCrmBundle:Fiche')		
						   ->before30careal($usersessok, $prev30);
			if(empty($carealbefore)){$carealbefore = 0;}				   
						   
			$caperdubefore  = $em->getRepository('BaclooCrmBundle:Fiche')		
						   ->before30caperdu($usersessok, $prev30);
			if(empty($caperdubefore)){$caperdubefore = 0;}	
			
			$cachart  = $em->getRepository('BaclooCrmBundle:Ca')		
						   ->last30ca($usersessok, $today, $prev30);	
		}
						 
		if(empty($fichespipe))
		{
			$testfichespipe = 0;
			$ca_pot = 0;
			$aff_pot = 0;
			$nbperdu = 0;
			$ca_perdu = 0;	
			$nbrealise = 0;
			$ca_realise = 0;			
		}
		else
		{
			$testfichespipe = 1;
			$ca_pot = 0;
			$aff_pot = 0;
			$nbperdu = 0;
			$ca_perdu = 0;	
			$nbrealise = 0;
			$ca_realise = 0;
			foreach($fichespipe as $fp)
			{
				if($fp->getPipeline()->getExclusion() == 0)
				{
					$ca_pot = $ca_pot + $fp->getPotentiel();
				}
				if($fp->getPipeline()->getRealise() == 1)
				{
					$ca_realise = $ca_realise + $fp->getPotentiel();				
				}
				if($fp->getPipeline()->getPerdu() == 1)
				{			
					$ca_perdu = $ca_perdu + $fp->getPotentiel();
				}				
			}			
		}
		

		
				$userdetails = $user;

		
				
//Gros check des modules
		$credits = $userdetails->getCredits();

		$listmodalerte = 0;// pour lister les modules en alerte expiration
		$comptemodalerte = 0;// pour compter les modules en  alerte
		$listmodarret = 0;// pour lister les modules en alerte expiration
		$comptemodarret = 0;// pour compter les modules en  alerte

		$modules  = $em->getRepository('BaclooCrmBundle:Modules')		
					   ->findOneByUsername($usersess);
		// echo $usersess;
		$moda = $em->getRepository('BaclooCrmBundle:Moda')
					 ->findOneBySociete('1234');

		if(empty($moda))
		{
			$moda = new moda();
			$moda->setSociete('1234');
			$em = $this->getDoctrine()->getManager();
			$em->persist($moda);			
		}
					 
		$userprix = 3;
		if(empty($modules))
		{//echo 'oooooooooooooooooooooooo';
			if($user->getRoleuser() == 'admin')
			{//echo 'sssssssssssssssssss';
				$modules = new Modules();
				$modules->setUserprix($userprix);
				$modules->setUserdebut(date('d/m/Y'));
				$modules->setUserexpiration('illimité');
				$modules->setBbuseractivation(1);
				$modules->setUsersociete($nomsociete);
				$modules->setModule1('Partage rapide des fiches');
				$modules->setModule1prix(1);
				$modules->setModule1debut(date('25/12/2016'));
				$modules->setModule1expiration('15/01/2017');
				$modules->setModule1activation(0);
				$modules->setModule2('Pipeline des ventes');
				$modules->setModule2prix(2);
				$modules->setModule2debut(date('30/11/2016'));
				$modules->setModule2expiration('31/12/2016');
				$modules->setModule2activation(0);
				$modules->setModule3('Bloc devis et commandes');
				$modules->setModule3prix(1);
				$modules->setModule3debut(date('30/11/2016'));
				$modules->setModule3expiration('31/12/2017');
				$modules->setModule3activation(0);
				$modules->setModule4('Recherche avancée');
				$modules->setModule4prix(1);
				$modules->setModule4debut(date('25/12/2016'));
				$modules->setModule4expiration('15/01/2017');
				$modules->setModule4activation(0);
				$modules->setModule5('Synchronisation avec agenda');
				$modules->setModule5prix(1);
				$modules->setModule5debut(date('30/11/2016'));
				$modules->setModule5expiration('31/12/2020');
				$modules->setModule5activation(0);
				$modules->setModule6('Fiches fournisseurs');
				$modules->setModule6prix(1);
				$modules->setModule6debut(date('25/12/2016'));
				$modules->setModule6expiration('15/01/2017');
				$modules->setModule6activation(0);
				$modules->setModule7('Google Docs');
				$modules->setModule7prix(1);
				$modules->setModule7debut(date('25/12/2016'));
				$modules->setModule7expiration('15/01/2017');
				$modules->setModule7activation(0);
				$modules->setModule8('Collègues : Partage de fiches');
				$modules->setModule8prix(0);
				$modules->setModule8debut(date('30/11/2016'));
				$modules->setModule8expiration('31/12/2020');
				$modules->setModule8activation(1);
				$modules->setModule9('Annuaire');
				$modules->setModule9prix(45);
				$modules->setModule9debut(date('25/12/2016'));
				$modules->setModule9expiration('15/01/2017');
				$modules->setModule9activation(0);
				$modules->setModule10('Bacloo Illimité');
				$modules->setModule10prix(3);
				$modules->setModule10debut(date('25/12/2016'));
				$modules->setModule10expiration('15/01/2017');
				$modules->setModule10activation(1);
				$modules->setModule11('Speed menu');
				$modules->setModule11prix(1);
				$modules->setModule11debut(date('25/12/2016'));
				$modules->setModule11expiration('15/01/2017');
				$modules->setModule11activation(1);
				$modules->setModule11('Compte-rendu activité');
				$modules->setModule12prix(1);
				$modules->setModule12debut(date('25/12/2016'));
				$modules->setModule12expiration('15/01/2017');
				$modules->setModule12activation(0);
				$modules->setUserid($user->getId());
				$modules->setUsername($usersess);
				// $modules->setUsersociete();
				$modules->addModa($moda);
				$moda->addModule($modules);
				$em->persist($modules);
				$em->persist($moda);
				$em->flush();		
			}
			else
			{
				$modules = new Modules();
				$modules->setUserprix($userprix);
				$modules->setUserdebut(date('d/m/Y'));
				$modules->setUserexpiration('illimité');
				$modules->setBbuseractivation(0);
				$modules->setUsersociete($nomsociete);
				$modules->setUserid($user->getId());
				$modules->setUsername($usersess);
				$modules->setModule1('Partage rapide des fiches');
				$modules->setModule1prix(1);
				$modules->setModule1debut(date('25/12/2016'));
				$modules->setModule1expiration('15/01/2017');
				$modules->setModule1activation(0);
				$modules->setModule2('Pipeline des ventes');
				$modules->setModule2prix(2);
				$modules->setModule2debut(date('25/12/2016'));
				$modules->setModule2expiration('15/01/2017');
				$modules->setModule2activation(0);
				$modules->setModule3('Bloc devis et commandes');
				$modules->setModule3prix(1);
				$modules->setModule3debut(date('25/12/2016'));
				$modules->setModule3expiration('15/01/2017');
				$modules->setModule3activation(0);
				$modules->setModule4('Recherche avancée');
				$modules->setModule4prix(1);
				$modules->setModule4debut(date('25/12/2016'));
				$modules->setModule4expiration('15/01/2017');
				$modules->setModule4activation(0);
				$modules->setModule5('Synchronisation avec agenda');
				$modules->setModule5prix(1);
				$modules->setModule5debut(date('25/12/2016'));
				$modules->setModule5expiration('15/01/2017');
				$modules->setModule5activation(0);
				$modules->setModule6('Fiches fournisseurs');
				$modules->setModule6prix(1);
				$modules->setModule6debut(date('25/12/2016'));
				$modules->setModule6expiration('15/01/2017');
				$modules->setModule6activation(0);
				$modules->setModule7('Google Docs');
				$modules->setModule7prix(1);
				$modules->setModule7debut(date('25/12/2016'));
				$modules->setModule7expiration('15/01/2017');
				$modules->setModule7activation(0);
				$modules->setModule8('Collègues : Partage de fiches');
				$modules->setModule8prix(1);
				$modules->setModule8debut(date('25/12/2016'));
				$modules->setModule8expiration('15/01/2017');
				$modules->setModule8activation(0);
				$modules->setModule9('Annuaire');
				$modules->setModule9prix(45);
				$modules->setModule9debut(date('25/12/2016'));
				$modules->setModule9expiration('15/01/2017');
				$modules->setModule9activation(0);
				$modules->setModule10('Bacloo Illimité');
				$modules->setModule10prix(3);
				$modules->setModule10debut(date('25/12/2016'));
				$modules->setModule10expiration('15/01/2017');
				$modules->setModule10activation(0);
				$modules->setModule11('Speed menu');
				$modules->setModule11prix(1);
				$modules->setModule11debut(date('25/12/2016'));
				$modules->setModule11expiration('15/01/2017');
				$modules->setModule11activation(0);
				$modules->setModule12('Compte-rendu activité');
				$modules->setModule12prix(1);
				$modules->setModule12debut(date('25/12/2016'));
				$modules->setModule12expiration('15/01/2017');
				$modules->setModule12activation(0);				
				// $modules->setUsersociete();
				$modules->addModa($moda);
				$moda->addModule($modules);
				$em->persist($modules);
				$em->persist($moda);
				$em->flush();	
			}
		}
//Controle validité de tous les moduels

		$modulesuser  = $em->getRepository('BaclooCrmBundle:Modules')		
					   ->findOneByUsername($usersess);
					   
		// if($modulesuser->getBbuseractivation() == 0 && $user->getRoleuser() != 'admin')
		// {
			// $request->getSession()
				// ->getFlashBag()
				// ->add('fail', 'Votre compte n\'a pas encore été activé par l\'administrateur');			
			// return $this->redirect($this->generateUrl('fos_user_security_logout'));
		// }
			

		include('checkmodule1.php');
		include('checkmodule2.php');
		include('checkmodule3.php');
		include('checkmodule4.php');
		include('checkmodule5.php');
		include('checkmodule6.php');
		include('checkmodule7.php');
		include('checkmodule8.php');
		include('checkmodule9.php');
		include('checkmodule10.php');
		include('checkmodule11.php');
		include('checkmodule12.php');

$today = date('Y-m-d');

// echo 'aaaa'.$listmodalerte;
// echo 'arret'.$comptemodarret;
// echo 'alerte'.$comptemodalerte;
		
if($comptemodarret != 0 && $comptemodalerte != 0 && $modules->getDatemailalerte() <> $today)
{
// echo 'xxxxxxx';
	//envoyer un mail à l'admin  indiquant que module désactivé faute de crédits 
	// Récupération du service
	$mailer = $this->get('mailer');				
	
		$message = \Swift_Message::newInstance()
			->setSubject($userdetails->getPrenom(). ' : '.$comptemodarret.' modules en arrêt et '.$comptemodalerte.' modules qui s\'arrêtent dans 5 jours')
			->setFrom(array('bacloo@bacloo.fr' => 'Bacloo CRM'))
			->setTo($userdetails->getEmail())
			->setBody($this->renderView('BaclooCrmBundle:Crm:bbalerte_user.html.twig', array('prenom'	=> $userdetails->getPrenom(),
																								 'user'	=> $usersess,
																								 'comptemodarret'	=> $comptemodarret,
																								 'comptemodalerte'	=> $comptemodalerte,
																								 'mode' => 'module'
																					  )))
		;
		$mailer->send($message);
		
	$mailer = $this->get('mailer');				
	
		$message = \Swift_Message::newInstance()
			->setSubject($userdetails->getPrenom(). ' : '.$comptemodarret.' modules en arrêt et '.$comptemodalerte.' modules qui s\'arrêtent dans 5 jours')
			->setFrom(array('bacloo@bacloo.fr' => 'Bacloo CRM'))
			->setTo('ringuetjm@gmail.com')
			->setBody($this->renderView('BaclooCrmBundle:Crm:bbalerte_user.html.twig', array('prenom'	=> $userdetails->getPrenom(),
																								 'user'	=> $usersess,
																								 'comptemodarret'	=> $comptemodarret,
																								 'comptemodalerte'	=> $comptemodalerte,
																								 'mode' => 'module'
																					  )))
		;
		$mailer->send($message);
		
		// $modules->setDatemailalerte($today);
		// $modules->setDatemailarret($today);
		
	// Fin partie envoi mail	
}
elseif($comptemodarret > 0 && $comptemodalerte < 1 && $modules->getDatemailarret() <> $today)
{
//echo 'b'.$listmodalerte;
	//envoyer un mail à l'admin  indiquant que module désactivé faute de crédits 
	// Récupération du service
	$mailer = $this->get('mailer');				
	
		$message = \Swift_Message::newInstance()
			->setSubject($userdetails->getPrenom(). ' : '.$comptemodarret.' modules en arrêt')
			->setFrom(array('bacloo@bacloo.fr' => 'Bacloo CRM'))
			->setTo($userdetails->getEmail())
			->setBody($this->renderView('BaclooCrmBundle:Crm:bbalerte_user.html.twig', array('prenom'	=> $userdetails->getPrenom(),
																								 'user'	=> $usersess,
																								 'comptemodarret'	=> $comptemodarret,
																								 'mode' => 'modules_arret'
																					  )))
		;
		$mailer->send($message);
		
	$mailer = $this->get('mailer');				
	
		$message = \Swift_Message::newInstance()
			->setSubject($userdetails->getPrenom(). ' : '.$comptemodarret.' modules en arrêt')
			->setFrom(array('bacloo@bacloo.fr' => 'Bacloo CRM'))
			->setTo('ringuetjm@gmail.com')
			->setBody($this->renderView('BaclooCrmBundle:Crm:bbalerte_user.html.twig', array('prenom'	=> $userdetails->getPrenom(),
																								 'user'	=> $usersess,
																								 'comptemodarret'	=> $comptemodarret,
																								 'mode' => 'modules_arret'
																					  )))
		;
		$mailer->send($message);
		
		$modules->setDatemailalerte($today);
		$modules->setDatemailarret($today);		
		
	// Fin partie envoi mail
}
elseif($comptemodarret < 1 && $comptemodalerte > 0 && $modules->getDatemailalerte() <> $today)
{
// echo 'c'.$listmodalerte;
	//envoyer un mail à l'admin  indiquant que module désactivé faute de crédits 
	// Récupération du service
	// $mailer = $this->get('mailer');				
	
		// $message = \Swift_Message::newInstance()
			// ->setSubject($userdetails->getPrenom(). ' : '.$comptemodalerte.' modules qui s arrêtent dans 5 jours '.$listmodalerte)
			// ->setFrom(array('bacloo@bacloo.fr' => 'Bacloo CRM'))
			// ->setTo($userdetails->getEmail())
			// ->setBody($this->renderView('BaclooCrmBundle:Crm:bbalerte_user.html.twig', array('prenom'	=> $userdetails->getPrenom(),
																								 // 'user'	=> $usersess,
																								 // 'comptemodalerte'	=> $comptemodalerte,
																								 // 'mode' => 'modules_alerte'
																					  // )))
		// ;
		// $mailer->send($message);
		
	// $mailer = $this->get('mailer');				
	
		// $message = \Swift_Message::newInstance()
			// ->setSubject($userdetails->getPrenom(). ' : '.$comptemodalerte.'modules qui s arrêtent dans 5 jours '.$listmodalerte)
			// ->setFrom(array('bacloo@bacloo.fr' => 'Bacloo CRM'))
			// ->setTo('ringuetjm@gmail.com')
			// ->setBody($this->renderView('BaclooCrmBundle:Crm:bbalerte_user.html.twig', array('prenom'	=> $userdetails->getPrenom(),
																								 // 'user'	=> $usersess,
																								 // 'comptemodalerte'	=> $comptemodalerte,
																								 // 'mode' => 'modules_alerte'
																					  // )))
		// ;
		// $mailer->send($message);

		// $modules->setDatemailalerte($today);
		// $modules->setDatemailarret($today);		
		
	// Fin partie envoi mail
}
$em->flush();		
//Fin controle sur tous les modules	
		
		$em = $this->getDoctrine()->getManager();
		$query = $em->createQuery(
			'SELECT u
			FROM BaclooUserBundle:User u
			WHERE u.username = :username'
		)->setParameter('username', $usersess);
		$userdetail = $query->getSingleResult();
		$actvise= $userdetail->getActvise();
		$tabtags = $userdetail->getTags();

		$activisse = str_replace(", ", ",", $actvise);
		$actv	   = explode(",", $activisse);
		if(empty($actv) && !isset($actv)){$actv = array(0);}
		// si tags, on sort les prospects correspondants qu'on stock dans $fiche (instance de Fiche)
		$tagss = str_replace(", ", ",", $tabtags);
		$tags = explode(",", $tagss);
		if(empty($tags) && !isset($tags)){$tags = array(0);}		
// echo 'taaags';print_r($tags);		
// echo 'actv';print_r($actv);		
			if(empty($actvise) && empty($tabtags))
			{//echo 'ici';
				$i = 0;
			}
			else
			{
			// echo 'la';
				$session = $request->getSession();
				$refresh = $session->get('countprospot');
				if(!empty($refresh))
				{
					//ne pas faire le refresh
					// echo 'sessiopr';
					$i = $refresh;
				}
				else
				{
					//Lancer la requête
					// echo 'calcpr';
					$em = $this->getDoctrine()
							   ->getManager()
							   ->getRepository('BaclooCrmBundle:Prospot');
					$prospotaa = $em->findBy(array(
												'user'=>$usersess,
												'voir'=>0));
												
					$em = $this->getDoctrine()->getManager();							
					$listintfiche2  = $em->getRepository('BaclooCrmBundle:interresses')		
								   ->findByUsername($usersess);	
					$i  = count($listintfiche2);			   
					$i += count($prospotaa);
					//maj la valeur prospot en session
					$session->set('countprospot', $i);
				}	

			}
// echo 'iiiiiiiiii'.$i;				
		$refreshfv = $this->get('session')->get('countfv');
		if(isset($refreshfv))
		{
			//ne pas faire le refresh
			$nbfiche = $refreshfv;
		}
		else
		{
			//Lancer la requête
			$em = $this->getDoctrine()
				   ->getManager();	
			$query = $em->createQuery(
				'SELECT COUNT(i.id) as nbfiche
				FROM BaclooCrmBundle:Fichesvendables i
				WHERE i.vendeur = :vendeur'
			);
			$query->setParameter('vendeur', $usersess);

			$nbfiche = $query->getOneOrNullResult();		

			//maj la valeur fichesvendables en session
			$this->get('session')->set('countfv', $nbfiche);
			
		}	
			$nblocparc = $em->getRepository('BaclooCrmBundle:Locata')
						->nblocparc(); //echo 'nblocparc : '.$nblocparc;
			// $nblocparc = count($nblocparca);
// echo $nblocparc;						
			$totalparc = $em->getRepository('BaclooCrmBundle:Machines')
							->totalparc(); //echo 'totalparc : '.$totalparc;	

			$nblocsl = $em->getRepository('BaclooCrmBundle:Locata')
							->nblocparcsl(); //echo 'nblocsl : '.$nblocsl;
						
		$devisnonvadparc = $em->getRepository('BaclooCrmBundle:Locata')
						->devisnonvadparc(); //echo 'devisnonvadparc : '.count($devisnonvadparc);
		$devisnonval = count($devisnonvadparc);
		
		foreach($devisnonvadparc as $devisnonvadp)
		{
			//echo $devisnonvadp->getClient();
		}
		
		$devisnonvadsl = $em->getRepository('BaclooCrmBundle:Locata')
						->devisnonvadsl(); //echo 'devisnonvadsl : '.count($devisnonvadsl);

		$devisnonvalsl = count($devisnonvadsl);				
												
		$dispogenerale = $em->getRepository('BaclooCrmBundle:Machines')
						->findByEtat('Disponible'); //echo 'dispogenerale : '.count($dispogenerale);
		$dispogene = count($dispogenerale);
		
		$modules  = $em->getRepository('BaclooCrmBundle:Modules')		
					   ->findOneByUsername($usersess);
					   
		$offresdumois  = $em->getRepository('BaclooCrmBundle:Locata')		
					   ->offresdumois();
		$nboffresmois = count($offresdumois);
		$listedispos = array();
		$dstart = new \DateTime(date('Y-m-d'));
		$dend = new \DateTime(date('Y-m-d'));
		$listedispos = array();
		$listecodes = array();
						
		$gamme = $em->getRepository('BaclooCrmBundle:Machines')
						->gamme();
				   			
			foreach($gamme as $gam)
			{
				$codemachine = $gam['codegenerique'];
				$dispos = $em->getRepository('BaclooCrmBundle:Machines')
						->dispos($codemachine, $dstart, $dend);
				// print_r($dispos);
				$i = 0;				
				foreach($dispos as $dispo)
				{//echo 'AAA'.($dispo['code']).'AAA';
					$dispo = $em->getRepository('BaclooCrmBundle:Machines')
							->dispoprecise($dispo['code'], $dstart, $dend);
							// echo 'xxx'.$dispo.'xxx';
					if(!empty($dispo)){$i = $i + 1;};
				}
				
				$listedispos[$codemachine]= count($dispos) - $i;		
			}
			

//STATS users
			// ON sort la liste des users concernés
			$query = $em->createQuery(
				'SELECT f.username
				FROM BaclooUserBundle:User f
				WHERE f.roleuser = :hdc
				OR f.roleuser = :admin
				OR f.roleuser = :commercial'
			);
			$query->setParameter('hdc', 'hdc');
			$query->setParameter('admin', 'admin');
			$query->setParameter('commercial', 'commercial');
			$listusers = $query->getResult();
			// print_r($listusers);
			//On prépare le tableau
			$statsusers = array();
			$du = new \DateTime("first day of January");//echo $du->format('Y-m-d');
			foreach($listusers as $list)
			{
			$infos = array();
				// echo $list['username'];
				$infos['user'] = $list['username']; 
				$countoffres = $em->getRepository('BaclooCrmBundle:Locata')
						->countoffres($du, $list['username']);
				$infos['countoffres'] = $countoffres;
				
				$countcontrats= $em->getRepository('BaclooCrmBundle:Locata')
						->countcontrats($du, $list['username']);
				$infos['countcontrats'] = $countcontrats;
				
				$caoffres = $em->getRepository('BaclooCrmBundle:Locata')
						->caoffres($du, $list['username']);
				$infos['caoffres'] = $caoffres;
				
				$cacontrats= $em->getRepository('BaclooCrmBundle:Locata')
						->cacontrats($du, $list['username']);
				$infos['cacontrats'] = $cacontrats;
				
				$statsusers[] = $infos;
						
				$vgpafaire = $em->getRepository('BaclooCrmBundle:Machines')
								->vgpafaire(); //echo 'devisnonvadparc : '.count($devisnonvadparc);
				$nbvgpafaire = count($vgpafaire);
			// print_r($infos);				
			}
			// print_r($statsusers);
//FIN stats users
		if($nbpipe > 3 && $modules->getModule2activation() == 0){$nbpipe = 3;}
		$offset = round(12/$nbpipe, 0, PHP_ROUND_HALF_DOWN);						   
		return $this->render('BaclooCrmBundle:Crm:statcom.html.twig', array(
						'prospot' => $i,
						'datevgp' => $datevgp = date('Y-m-d', strtotime("+35 days")),
						'vgpafaire' => $vgpafaire,
						'nbvgpafaire' => $nbvgpafaire,
						'testfichespipe' => $testfichespipe,
						'fichespipe' => $fichespipe,
						'pipeselect' => $pipeselect,
						'offset' => $offset,
						'nbpipe' => $nbpipe,
						'prev30' => $prev30,
						'nbevents' => $nbevents,
						'cachart' => $cachart,
						'capotbefore' => $capotbefore,
						'caperdubefore' => $caperdubefore,
						'carealbefore' => $carealbefore,
						'ca_pot' => $ca_pot,
						'aff_pot' => $aff_pot,
						'nbperdu' => $nbperdu,
						'ca_perdu' => $ca_perdu,
						'module2activation' => $modules->getModule2activation(),
						'ca_realise' => $ca_realise,
						'nbrealise' => $nbrealise,
						'societe' => $societe,
						'usersessok' => $usersessok,
						'user' => $usersess,
						'listedispos' => $listedispos,
						'roleuser' => $user->getRoleuser(),
						'type' => 'accueil',
						'nblocparc' => $nblocparc,
						'totalparc' => $totalparc,
						'nblocsl' => $nblocsl,
						'devisnonvadparc' => $devisnonvadparc,
						'devisnonval' => $devisnonval,
						'devisnonvadsl' => $devisnonvadsl,
						'devisnonvalsl' => $devisnonvalsl,
						'dispogene' => $dispogene,
						'nboffresmois' => $nboffresmois,
						'statsusers' => $statsusers,
						'nbfiche' => $nbfiche					
						));							
	}
	
	public function accueilAction($dstart, $dend, Request $request)
	{//$id = id ligne partenaire
		$usersess = $this->get('security.context')->getToken()->getUsername(); if(empty($usersess) or !isset($usersess) or $usersess == 'anon.'){return $this->redirect($this->generateUrl('fos_user_security_login'));}//Récupère le nom d'utilisateur
		$em = $this->getDoctrine()->getManager();
		$userdetails  = $em->getRepository('BaclooUserBundle:User')				
					   ->findOneByUsername($usersess);
					   
		include('societe.php');
		$nomsociete = $societe;
		$session = new Session();
		$session = $request->getSession();
		$usersess = $this->get('security.context')->getToken()->getUsername();
		$em = $this->getDoctrine()->getManager();
		$user  = $em->getRepository('BaclooUserBundle:User')		
					   ->findOneByUsername($usersess);

		// echo 'testfichespipe'.$testfichespipe;
		//Protect double connexion
		$session = $request->getSession();
		$sessionId = $session->getId();
		// echo $sessionId;
		// echo 'xxxxx'.$user->getLogged();
		// echo '  '.$user->getUsername();
		if($user->getLogged() != $sessionId)
		{
			return $this->redirect($this->generateUrl('fos_user_security_logout'));
		}
		//Fin protect double connexion

		// if($user->getRoleuser() != 'admin' && $user->getUsersociete() != null)
		if($user->getRoleuser() != 'admin' && $user->getUsersociete() != $societe)
		{
			$societe = $user->getNomrep();
			// $url = 'http://127.0.0.1/symfony2/web/b/lamiecaline/web/app_dev.php/login';
			$url = 'https://www.bacloo.fr/b/'.$societe.'/web/app.php';
			return $this->redirect($url);
		}
		
		if($user->getRoleuser() == 'admin' && $user->getUsersociete() != $societe)
		{
			$societe = $user->getNomrep();
			// $url = 'http://127.0.0.1/symfony2/web/b/lamiecaline/web/app_dev.php/login';
			$url = 'https://www.bacloo.fr/b/'.$societe.'/web/app.php';
			return $this->redirect($url);
		}
		// echo $user->getRoleuser();
		if(($user->getRoleuser() != 'admin' and $user->getRoleuser() != 'super user') and null === $user->getNom())
		{
			return $this->redirect($this->generateUrl('fos_user_profile_edit'));
		}
		// if($user->getRoleuser() == 'technicien')
		// {
			// return $this->redirect($this->generateUrl('bacloocrm_tcard'));
		// }
		
		//Ici on met à jour la société au cas l'admin aurait créé sont Bacloo perso après avoir importé son fichier
		// if($user->getRoleuser() == 'admin')
		// {
			// $fiches = $em->getRepository('BaclooCrmBundle:Fiche')
							   // ->findBy(array('user' => $usersess, 'usersociete' => NULL));
			// if(isset($fiche) && $fiches->getUsersociete() != $societe)
			// {
				// $fichesok = $em->getRepository('BaclooCrmBundle:Fiche')
								   // ->find($usersess);
				// foreach($fichesok as $fiche)
				// {
					// set_time_limit(300);
					// $fiche->setUsersociete($societe);
					// $em->persist($fiche);
				// }
				// $em->flush();
			// }

		// }
		$defaultData = array();		
		$form = $this->createFormBuilder($defaultData)
			->add('du', 'date', array('widget' => 'single_text',
										'input' => 'string',
										'format' => 'dd/MM/yyyy',
										'required' => false,
										'attr' => array('class' => 'date'),
										))
			->add('au', 'date', array('widget' => 'single_text',
										'input' => 'string',
										'format' => 'dd/MM/yyyy',
										'required' => false,
										'attr' => array('class' => 'date'),
										))
			->getForm();//echo $request->getMethod();
		if($request->getMethod() == 'POST') {// 'VALIDE';		
			$form->handleRequest($request);
			$data = $form->getData();//var_dump($data);
			if(isset($data['du']))
			{//echo 'aaa';
				$dstart = $data['du'];	
			}
			if(isset($data['au']))
			{
				$dEnd = $data['au'];
			}
			$search = 1;
		}
// echo 'dend '.$dEnd;
		if($dstart == 0)
		{
			$dstart = date('Y-m-d', strtotime("-6 months"));
		}

		if($dend == 0)
		{
			$dend = date('Y-m-d');
		}
		
		if($user->getRoleuser() != 'admin'){$useracc = $usersess;}
		if(isset($useracc))
		{
			if($useracc == 'societe')
			{
				//On calcule critères
				$i = 1;
				$em = $this->getDoctrine()->getManager();
				$listuser = $em->getRepository('BaclooUserBundle:User')
							   ->findBy(array('usersociete' => $societe));				
				foreach($listuser as $listu)
				{						
					${'choix'.$i++} = $listu->getUsername();
				}
				//echo 'choix1'.$choix1;
				$critere = array($usersess);
				
				for($j=1;$j<$i;$j++)
				{
					${'critere'.$j} = array(${"choix".$j});
					$critere = array_merge(${'critere'.$j},$critere);
				}
				$usersessok = $critere;
			}
			else
			{
				$usersessok = $useracc;
			}
		}
		else
		{
			$usersessok = $usersess;
		}

		if($usersess == 'anon.')
		{
			return $this->redirect($this->generateUrl('fos_user_security_login'));
		}

		$em = $this->getDoctrine()->getManager();
		$user  = $em->getRepository('BaclooUserBundle:User')		
					   ->findOneByUsername($usersess);
// echo '111'.$usersess;
		if($user->getRoleuser() != 'admin')
		{
			$userdetails  = $em->getRepository('BaclooUserBundle:User')		
				   ->findOneBy(array('roleuser'=> 'admin', 'usersociete' => $societe));
			// $usersess = $userdetails->getUsername();			
		}
// echo '222'.$usersess;		
				$query = $em->createQuery(
					'SELECT u.id
					FROM BaclooUserBundle:User u
					WHERE u.username = :username'
				)->setParameter('username', $usersess);
				$uid = $query->getSingleScalarResult();
				//On regarde si l'utilisateur connecté est déja entegistré dnas la table userpipe
				$userpipe = $em->getRepository('BaclooCrmBundle:Userpipe')
				->findOneByUserid($uid);			  
		
				//On récupère les pipelines de l'utilisateur connecté
				$em2 = $this->getDoctrine()
						   ->getManager()
						   ->getRepository('BaclooCrmBundle:Pipeline');
				$pipe = $em2->findByUsername($usersess);

				$pipe_zero = $em->getRepository('BaclooCrmBundle:Pipeline')
								->findByPipeorder(0);

				//On récupère les userpipe du user connecté
				$em2 = $this->getDoctrine()
						   ->getManager()
						   ->getRepository('BaclooCrmBundle:Userpipe');
				$userpipa = $em2->findOneByUserid($uid);

				if(empty($userpipa))
				{
					// echo 'pppppppooo'.$uid;
					$userpipe = new userpipe();
					$userpipe->setUserid($uid);
					$em = $this->getDoctrine()->getManager();
					$em->persist($userpipe);
					$em->flush();
					
					$em2 = $this->getDoctrine()
							   ->getManager()
							   ->getRepository('BaclooCrmBundle:Userpipe');
					$userpipo = $em2->findOneByUserid($uid);
					
					$pipe0 = new pipeline();
					$pipe0->setUserid($uid);
					$pipe0->setUsername($usersess);
					$pipe0->setPipename('---------');
					$pipe0->setPipeorder(0);				
					$pipe0->addUserpipe($userpipo);	
					$userpipo->addPipeline($pipe0);
					$em->persist($pipe0);
					$em->persist($userpipo);
					$em->flush();
					
					$pipe0 = new pipeline();
					$pipe0->setUserid($uid);
					$pipe0->setUsername($usersess);
					$pipe0->setPipename('Devis fait');
					$pipe0->setPipeorder(1);				
					$pipe0->addUserpipe($userpipo);	
					$userpipo->addPipeline($pipe0);
					$em->persist($pipe0);
					$em->persist($userpipo);
					$em->flush();
					
					$pipe0 = new pipeline();
					$pipe0->setUserid($uid);
					$pipe0->setUsername($usersess);
					$pipe0->setPipename('Affaires signées');
					$pipe0->setPipeorder(2);
					$pipe0->setRealise(true);				
					$pipe0->addUserpipe($userpipo);	
					$userpipo->addPipeline($pipe0);
					$em->persist($pipe0);
					$em->persist($userpipo);
					$em->flush();
					
					$pipe0 = new pipeline();
					$pipe0->setUserid($uid);
					$pipe0->setUsername($usersess);
					$pipe0->setPipename('Affaires perdues');
					$pipe0->setPipeorder(3);
					$pipe0->setPerdu(true);
					$pipe0->setExclusion(true);				
					$pipe0->addUserpipe($userpipo);	
					$userpipo->addPipeline($pipe0);
					$em->persist($pipe0);
					$em->persist($userpipo);
					$em->flush();				
				}
				else
				{
					$pipe_zero = $em->getRepository('BaclooCrmBundle:Pipeline')
						->findByPipeorder(0);
					if(empty($pipe_zero))
					{
						$em2 = $this->getDoctrine()
								   ->getManager()
								   ->getRepository('BaclooCrmBundle:Userpipe');
						$userpipo = $em2->findOneByUserid($uid);
						
						$pipe0 = new pipeline();
						$pipe0->setUserid($uid);
						$pipe0->setUsername($usersess);
						$pipe0->setPipename('---------');
						$pipe0->setPipeorder(0);				
						$pipe0->addUserpipe($userpipo);	
						$userpipo->addPipeline($pipe0);
						$em->persist($pipe0);
						$em->persist($userpipo);
						$em->flush();
					}					
				}					   

			$query = $em->createQuery(
				'SELECT p
				FROM BaclooCrmBundle:Pipeline p
				WHERE p.username = :username
				AND p.pipeorder > :pipeorder
				ORDER BY p.pipeorder ASC'
			)->setParameter('username', $usersess)
			->setParameter('pipeorder', 0);
						   
			$pipeselect = $query->getResult();
							 
			$nbpipe = count($pipeselect);
			if($nbpipe == 0){$nbpipe = 1;}
			$offset = round(12/$nbpipe, 0, PHP_ROUND_HALF_DOWN);	

			$today = date('Y-m-d');
			$prev30 = date('Y-m-d', strtotime("-29 days"));
			
		if(is_array($usersessok) == 1)
		{
			$fichespipe = $em->getRepository('BaclooCrmBundle:Fiche')
							 ->createpiplinearray($usersessok);
								 
			$em = $this->getDoctrine()->getManager();
			$nbevents  = $em->getRepository('BaclooCrmBundle:Fiche')		
						   ->last30eventarray($usersessok, $today, $prev30);
						   
			$capotbefore  = $em->getRepository('BaclooCrmBundle:Fiche')		
						   ->before30capotarray($usersess, $prev30);	
			if(empty($capotbefore)){$capotbefore = 0;}
			// echo 'capotbefore'.$capotbefore;
			$carealbefore  = $em->getRepository('BaclooCrmBundle:Fiche')		
						   ->before30carealarray($usersess, $prev30);
			if(empty($carealbefore)){$carealbefore = 0;}				   
						   
			$caperdubefore  = $em->getRepository('BaclooCrmBundle:Fiche')		
						   ->before30caperduarray($usersess, $prev30);
			if(empty($caperdubefore)){$caperdubefore = 0;}	
			
			$cachart  = $em->getRepository('BaclooCrmBundle:Ca')		
						   ->last30caarray($usersess, $today, $prev30);							 
		}
		else
		{
			$fichespipe = $em->getRepository('BaclooCrmBundle:Fiche')
							 ->createpipline($usersessok);
								 
			$em = $this->getDoctrine()->getManager();
			$nbevents  = $em->getRepository('BaclooCrmBundle:Fiche')		
						   ->last30event($usersessok, $today, $prev30);
						   
			$capotbefore  = $em->getRepository('BaclooCrmBundle:Fiche')		
						   ->before30capot($usersessok, $prev30);	
			if(empty($capotbefore)){$capotbefore = 0;}
			// echo 'capotbefore'.$capotbefore;
			$carealbefore  = $em->getRepository('BaclooCrmBundle:Fiche')		
						   ->before30careal($usersessok, $prev30);
			if(empty($carealbefore)){$carealbefore = 0;}				   
						   
			$caperdubefore  = $em->getRepository('BaclooCrmBundle:Fiche')		
						   ->before30caperdu($usersessok, $prev30);
			if(empty($caperdubefore)){$caperdubefore = 0;}	
			
			$cachart  = $em->getRepository('BaclooCrmBundle:Ca')		
						   ->last30ca($usersessok, $today, $prev30);	
		}
						 
		if(empty($fichespipe))
		{
			$testfichespipe = 0;
			$ca_pot = 0;
			$aff_pot = 0;
			$nbperdu = 0;
			$ca_perdu = 0;	
			$nbrealise = 0;
			$ca_realise = 0;			
		}
		else
		{
			$testfichespipe = 1;
			$ca_pot = 0;
			$aff_pot = 0;
			$nbperdu = 0;
			$ca_perdu = 0;	
			$nbrealise = 0;
			$ca_realise = 0;
			foreach($fichespipe as $fp)
			{
				if($fp->getPipeline()->getExclusion() == 0)
				{
					$ca_pot = $ca_pot + $fp->getPotentiel();
				}
				if($fp->getPipeline()->getRealise() == 1)
				{
					$ca_realise = $ca_realise + $fp->getPotentiel();				
				}
				if($fp->getPipeline()->getPerdu() == 1)
				{			
					$ca_perdu = $ca_perdu + $fp->getPotentiel();
				}				
			}			
		}
		

		
				$userdetails = $user;

		
				
//Gros check des modules
		$credits = $userdetails->getCredits();

		$listmodalerte = 0;// pour lister les modules en alerte expiration
		$comptemodalerte = 0;// pour compter les modules en  alerte
		$listmodarret = 0;// pour lister les modules en alerte expiration
		$comptemodarret = 0;// pour compter les modules en  alerte

		$modules  = $em->getRepository('BaclooCrmBundle:Modules')		
					   ->findOneByUsername($usersess);
		// echo $usersess;
		$moda = $em->getRepository('BaclooCrmBundle:Moda')
					 ->findOneBySociete('1234');

		if(empty($moda))
		{
			$moda = new moda();
			$moda->setSociete('1234');
			$em = $this->getDoctrine()->getManager();
			$em->persist($moda);			
		}
					 
		$userprix = 3;
		if(empty($modules))
		{//echo 'oooooooooooooooooooooooo';
			if($user->getRoleuser() == 'admin')
			{//echo 'sssssssssssssssssss';
				$modules = new Modules();
				$modules->setUserprix($userprix);
				$modules->setUserdebut(date('d/m/Y'));
				$modules->setUserexpiration('illimité');
				$modules->setBbuseractivation(1);
				$modules->setUsersociete($nomsociete);
				$modules->setModule1('Partage rapide des fiches');
				$modules->setModule1prix(1);
				$modules->setModule1debut(date('25/12/2016'));
				$modules->setModule1expiration('15/01/2017');
				$modules->setModule1activation(0);
				$modules->setModule2('Pipeline des ventes');
				$modules->setModule2prix(2);
				$modules->setModule2debut(date('30/11/2016'));
				$modules->setModule2expiration('31/12/2016');
				$modules->setModule2activation(0);
				$modules->setModule3('Bloc devis et commandes');
				$modules->setModule3prix(1);
				$modules->setModule3debut(date('30/11/2016'));
				$modules->setModule3expiration('31/12/2017');
				$modules->setModule3activation(0);
				$modules->setModule4('Recherche avancée');
				$modules->setModule4prix(1);
				$modules->setModule4debut(date('25/12/2016'));
				$modules->setModule4expiration('15/01/2017');
				$modules->setModule4activation(0);
				$modules->setModule5('Synchronisation avec agenda');
				$modules->setModule5prix(1);
				$modules->setModule5debut(date('30/11/2016'));
				$modules->setModule5expiration('31/12/2020');
				$modules->setModule5activation(0);
				$modules->setModule6('Fiches fournisseurs');
				$modules->setModule6prix(1);
				$modules->setModule6debut(date('25/12/2016'));
				$modules->setModule6expiration('15/01/2017');
				$modules->setModule6activation(0);
				$modules->setModule7('Google Docs');
				$modules->setModule7prix(1);
				$modules->setModule7debut(date('25/12/2016'));
				$modules->setModule7expiration('15/01/2017');
				$modules->setModule7activation(0);
				$modules->setModule8('Collègues : Partage de fiches');
				$modules->setModule8prix(0);
				$modules->setModule8debut(date('30/11/2016'));
				$modules->setModule8expiration('31/12/2020');
				$modules->setModule8activation(1);
				$modules->setModule9('Annuaire');
				$modules->setModule9prix(45);
				$modules->setModule9debut(date('25/12/2016'));
				$modules->setModule9expiration('15/01/2017');
				$modules->setModule9activation(0);
				$modules->setModule10('Bacloo Illimité');
				$modules->setModule10prix(3);
				$modules->setModule10debut(date('25/12/2016'));
				$modules->setModule10expiration('15/01/2017');
				$modules->setModule10activation(1);
				$modules->setModule11('Speed menu');
				$modules->setModule11prix(1);
				$modules->setModule11debut(date('25/12/2016'));
				$modules->setModule11expiration('15/01/2017');
				$modules->setModule11activation(1);
				$modules->setModule11('Compte-rendu activité');
				$modules->setModule12prix(1);
				$modules->setModule12debut(date('25/12/2016'));
				$modules->setModule12expiration('15/01/2017');
				$modules->setModule12activation(0);
				$modules->setUserid($user->getId());
				$modules->setUsername($usersess);
				// $modules->setUsersociete();
				$modules->addModa($moda);
				$moda->addModule($modules);
				$em->persist($modules);
				$em->persist($moda);
				$em->flush();		
			}
			else
			{
				$modules = new Modules();
				$modules->setUserprix($userprix);
				$modules->setUserdebut(date('d/m/Y'));
				$modules->setUserexpiration('illimité');
				$modules->setBbuseractivation(0);
				$modules->setUsersociete($nomsociete);
				$modules->setUserid($user->getId());
				$modules->setUsername($usersess);
				$modules->setModule1('Partage rapide des fiches');
				$modules->setModule1prix(1);
				$modules->setModule1debut(date('25/12/2016'));
				$modules->setModule1expiration('15/01/2017');
				$modules->setModule1activation(0);
				$modules->setModule2('Pipeline des ventes');
				$modules->setModule2prix(2);
				$modules->setModule2debut(date('25/12/2016'));
				$modules->setModule2expiration('15/01/2017');
				$modules->setModule2activation(0);
				$modules->setModule3('Bloc devis et commandes');
				$modules->setModule3prix(1);
				$modules->setModule3debut(date('25/12/2016'));
				$modules->setModule3expiration('15/01/2017');
				$modules->setModule3activation(0);
				$modules->setModule4('Recherche avancée');
				$modules->setModule4prix(1);
				$modules->setModule4debut(date('25/12/2016'));
				$modules->setModule4expiration('15/01/2017');
				$modules->setModule4activation(0);
				$modules->setModule5('Synchronisation avec agenda');
				$modules->setModule5prix(1);
				$modules->setModule5debut(date('25/12/2016'));
				$modules->setModule5expiration('15/01/2017');
				$modules->setModule5activation(0);
				$modules->setModule6('Fiches fournisseurs');
				$modules->setModule6prix(1);
				$modules->setModule6debut(date('25/12/2016'));
				$modules->setModule6expiration('15/01/2017');
				$modules->setModule6activation(0);
				$modules->setModule7('Google Docs');
				$modules->setModule7prix(1);
				$modules->setModule7debut(date('25/12/2016'));
				$modules->setModule7expiration('15/01/2017');
				$modules->setModule7activation(0);
				$modules->setModule8('Collègues : Partage de fiches');
				$modules->setModule8prix(1);
				$modules->setModule8debut(date('25/12/2016'));
				$modules->setModule8expiration('15/01/2017');
				$modules->setModule8activation(0);
				$modules->setModule9('Annuaire');
				$modules->setModule9prix(45);
				$modules->setModule9debut(date('25/12/2016'));
				$modules->setModule9expiration('15/01/2017');
				$modules->setModule9activation(0);
				$modules->setModule10('Bacloo Illimité');
				$modules->setModule10prix(3);
				$modules->setModule10debut(date('25/12/2016'));
				$modules->setModule10expiration('15/01/2017');
				$modules->setModule10activation(0);
				$modules->setModule11('Speed menu');
				$modules->setModule11prix(1);
				$modules->setModule11debut(date('25/12/2016'));
				$modules->setModule11expiration('15/01/2017');
				$modules->setModule11activation(0);
				$modules->setModule12('Compte-rendu activité');
				$modules->setModule12prix(1);
				$modules->setModule12debut(date('25/12/2016'));
				$modules->setModule12expiration('15/01/2017');
				$modules->setModule12activation(0);				
				// $modules->setUsersociete();
				$modules->addModa($moda);
				$moda->addModule($modules);
				$em->persist($modules);
				$em->persist($moda);
				$em->flush();	
			}
		}
//Controle validité de tous les moduels

		$modulesuser  = $em->getRepository('BaclooCrmBundle:Modules')		
					   ->findOneByUsername($usersess);
					   
		// if($modulesuser->getBbuseractivation() == 0 && $user->getRoleuser() != 'admin')
		// {
			// $request->getSession()
				// ->getFlashBag()
				// ->add('fail', 'Votre compte n\'a pas encore été activé par l\'administrateur');			
			// return $this->redirect($this->generateUrl('fos_user_security_logout'));
		// }
			

		include('checkmodule1.php');
		include('checkmodule2.php');
		include('checkmodule3.php');
		include('checkmodule4.php');
		include('checkmodule5.php');
		include('checkmodule6.php');
		include('checkmodule7.php');
		include('checkmodule8.php');
		include('checkmodule9.php');
		include('checkmodule10.php');
		include('checkmodule11.php');
		include('checkmodule12.php');

$today = date('Y-m-d');

// echo 'aaaa'.$listmodalerte;
// echo 'arret'.$comptemodarret;
// echo 'alerte'.$comptemodalerte;
		
if($comptemodarret != 0 && $comptemodalerte != 0 && $modules->getDatemailalerte() <> $today)
{
// echo 'xxxxxxx';
	//envoyer un mail à l'admin  indiquant que module désactivé faute de crédits 
	// Récupération du service
	$mailer = $this->get('mailer');				
	
		$message = \Swift_Message::newInstance()
			->setSubject($userdetails->getPrenom(). ' : '.$comptemodarret.' modules en arrêt et '.$comptemodalerte.' modules qui s\'arrêtent dans 5 jours')
			->setFrom(array('bacloo@bacloo.fr' => 'Bacloo CRM'))
			->setTo($userdetails->getEmail())
			->setBody($this->renderView('BaclooCrmBundle:Crm:bbalerte_user.html.twig', array('prenom'	=> $userdetails->getPrenom(),
																								 'user'	=> $usersess,
																								 'comptemodarret'	=> $comptemodarret,
																								 'comptemodalerte'	=> $comptemodalerte,
																								 'mode' => 'module'
																					  )))
		;
		$mailer->send($message);
		
	$mailer = $this->get('mailer');				
	
		$message = \Swift_Message::newInstance()
			->setSubject($userdetails->getPrenom(). ' : '.$comptemodarret.' modules en arrêt et '.$comptemodalerte.' modules qui s\'arrêtent dans 5 jours')
			->setFrom(array('bacloo@bacloo.fr' => 'Bacloo CRM'))
			->setTo('ringuetjm@gmail.com')
			->setBody($this->renderView('BaclooCrmBundle:Crm:bbalerte_user.html.twig', array('prenom'	=> $userdetails->getPrenom(),
																								 'user'	=> $usersess,
																								 'comptemodarret'	=> $comptemodarret,
																								 'comptemodalerte'	=> $comptemodalerte,
																								 'mode' => 'module'
																					  )))
		;
		$mailer->send($message);
		
		// $modules->setDatemailalerte($today);
		// $modules->setDatemailarret($today);
		
	// Fin partie envoi mail	
}
elseif($comptemodarret > 0 && $comptemodalerte < 1 && $modules->getDatemailarret() <> $today)
{
//echo 'b'.$listmodalerte;
	//envoyer un mail à l'admin  indiquant que module désactivé faute de crédits 
	// Récupération du service
	$mailer = $this->get('mailer');				
	
		$message = \Swift_Message::newInstance()
			->setSubject($userdetails->getPrenom(). ' : '.$comptemodarret.' modules en arrêt')
			->setFrom(array('bacloo@bacloo.fr' => 'Bacloo CRM'))
			->setTo($userdetails->getEmail())
			->setBody($this->renderView('BaclooCrmBundle:Crm:bbalerte_user.html.twig', array('prenom'	=> $userdetails->getPrenom(),
																								 'user'	=> $usersess,
																								 'comptemodarret'	=> $comptemodarret,
																								 'mode' => 'modules_arret'
																					  )))
		;
		$mailer->send($message);
		
	$mailer = $this->get('mailer');				
	
		$message = \Swift_Message::newInstance()
			->setSubject($userdetails->getPrenom(). ' : '.$comptemodarret.' modules en arrêt')
			->setFrom(array('bacloo@bacloo.fr' => 'Bacloo CRM'))
			->setTo('ringuetjm@gmail.com')
			->setBody($this->renderView('BaclooCrmBundle:Crm:bbalerte_user.html.twig', array('prenom'	=> $userdetails->getPrenom(),
																								 'user'	=> $usersess,
																								 'comptemodarret'	=> $comptemodarret,
																								 'mode' => 'modules_arret'
																					  )))
		;
		$mailer->send($message);
		
		$modules->setDatemailalerte($today);
		$modules->setDatemailarret($today);		
		
	// Fin partie envoi mail
}
elseif($comptemodarret < 1 && $comptemodalerte > 0 && $modules->getDatemailalerte() <> $today)
{
// echo 'c'.$listmodalerte;
	//envoyer un mail à l'admin  indiquant que module désactivé faute de crédits 
	// Récupération du service
	// $mailer = $this->get('mailer');				
	
		// $message = \Swift_Message::newInstance()
			// ->setSubject($userdetails->getPrenom(). ' : '.$comptemodalerte.' modules qui s arrêtent dans 5 jours '.$listmodalerte)
			// ->setFrom(array('bacloo@bacloo.fr' => 'Bacloo CRM'))
			// ->setTo($userdetails->getEmail())
			// ->setBody($this->renderView('BaclooCrmBundle:Crm:bbalerte_user.html.twig', array('prenom'	=> $userdetails->getPrenom(),
																								 // 'user'	=> $usersess,
																								 // 'comptemodalerte'	=> $comptemodalerte,
																								 // 'mode' => 'modules_alerte'
																					  // )))
		// ;
		// $mailer->send($message);
		
	// $mailer = $this->get('mailer');				
	
		// $message = \Swift_Message::newInstance()
			// ->setSubject($userdetails->getPrenom(). ' : '.$comptemodalerte.'modules qui s arrêtent dans 5 jours '.$listmodalerte)
			// ->setFrom(array('bacloo@bacloo.fr' => 'Bacloo CRM'))
			// ->setTo('ringuetjm@gmail.com')
			// ->setBody($this->renderView('BaclooCrmBundle:Crm:bbalerte_user.html.twig', array('prenom'	=> $userdetails->getPrenom(),
																								 // 'user'	=> $usersess,
																								 // 'comptemodalerte'	=> $comptemodalerte,
																								 // 'mode' => 'modules_alerte'
																					  // )))
		// ;
		// $mailer->send($message);

		// $modules->setDatemailalerte($today);
		// $modules->setDatemailarret($today);		
		
	// Fin partie envoi mail
}
$em->flush();				
				   
		$modules  = $em->getRepository('BaclooCrmBundle:Modules')		
					   ->findOneByUsername($usersess);
		if($nbpipe > 3 && $modules->getModule2activation() == 0){$nbpipe = 3;}
		
		// if($user->getTypeuser() == 'entreprise' && $avant == 'http://127.0.0.1/symfony2/web/app_dev.php/login')
		if($user->getTypeuser() == 'entreprise' && $avant == 'https://www.bacloo.fr/login')
		{
			return $this->redirect($this->generateUrl('bacloocrm_bb'));
			// echo 'YYYYYYYYY'.$avant;
		}		
		return $this->render('BaclooCrmBundle:Crm:accueil.html.twig', array(
								'userdetails'=> $userdetails,
								'dstart'=> $dstart,
								'dend'=> $dend
								));							
	}
	
	Public function comptadefrattrapageAction()
	{
		$em = $this->getDoctrine()->getManager();
		$facture  = $em->getRepository('BaclooCrmBundle:Factures')		
					   ->findAll();	
		foreach($facture as $fact)
		{
			$mystring = $fact->getCodelocata();
			$findme   = 'H';
			$pos = strpos($mystring, $findme);
			if($pos === false)
			{
				$selection = $fact->getSelection();//echo '+++'.$selection.'+++';
				$codecontrat = $fact->getLocatacloneid();
				$clientid = $fact->getClientid();
				$numfacture = $fact->getNumfacture();
				echo 'CODeCONtrAt';echo $fact->getCodelocata();	
				echo 'CODeCONtrAtV';echo $fact->getLocatacloneid();	
				if($fact->getCodelocata() == 'V-'.$fact->getLocatacloneid())
				{
					$doc = 'ventes';			   
					$venda = $em->getRepository('BaclooCrmBundle:Venda')		
					   ->findOneById($codecontrat);	
				}
				else
				{
					$doc = 'locations';			
					$locata = $em->getRepository('BaclooCrmBundle:Locataclone')		
					   ->findOneById($codecontrat);
				}
				$typeachat = 'nok';
				if($fact->getCodelocata() == 'H-'.$fact->getLocatacloneid())
				{
					$locatafrs = $em->getRepository('BaclooCrmBundle:Locatafrs')		
					   ->findOneById($codecontrat);
					$typeachat = 'normal';
					$doc = 'achat';//echo 'YYYYYYYYYYYYYYY';
				}
				else
				{
					$locatafrs = $em->getRepository('BaclooCrmBundle:Locatafrsclone')		
					   ->findOneById($codecontrat);
					$typeachat = 'sousloc';
					// echo 'VVVVVVVVVVVVVVV';
				}
				 echo 'codecontrat'.$codecontrat;
				   
				$machines = $em->getRepository('BaclooCrmBundle:Machines')		
				   ->findAll();
				   
				$machinessl = $em->getRepository('BaclooCrmBundle:Machinessl')		
				   ->findAll();	   

				$facture  = $em->getRepository('BaclooCrmBundle:Factures')		
				   ->findOneByNumfacture($numfacture);
			
				$clients  = $em->getRepository('BaclooCrmBundle:Fiche')		
				   ->findOneById($clientid);
				//echo 'ttttt';echo $this->getRequest()->request->get('definitif');				

				echo ' XXXX'.$doc;
				if($doc == 'ventes' or $doc == 'locations' and $fact->getTotalttc() > 0)
				{//echo 'on def';
					include('facturationmensuelledefinitivehard.php');
					$fact->setSelection(0);
					$em->flush();
				}
			}
			else
			{
				echo 'ACHAT';
			}
		}
		return $this->redirect($this->generateUrl('bacloocrm_compta', array('vue' => 'locations')));	
	}	
	
	Public function removemachineAction($ecode, $typeloc, $codecontrat)
	{
		$em = $this->getDoctrine()->getManager();
		if($typeloc == 'parc')
		{
			$machine  = $em->getRepository('BaclooCrmBundle:Machines')		
						   ->findOneBy(array('code' => $ecode, 'codecontrat' => $codecontrat));
						   
			$locata = $em->getRepository('BaclooCrmBundle:Locata')		
						   ->findOneById($codecontrat);
			
			if(!isset($machine))
			{
				foreach($locata->getLocations() as $locat)
				{
					if($locat->getCodemachineinterne() == $ecode)
					{
						$codelocation = $locat->getId();
					}
				}
				$locations  = $em->getRepository('BaclooCrmBundle:Locations')		
							   ->findOneById($codelocation);
			}
			else
			{
				$codelocation = $machine->getCodelocations();
				$locations  = $em->getRepository('BaclooCrmBundle:Locations')		
							   ->findOneById($codelocation);
				if($machine->getOriginal() == 0)
				{
					$em->remove($machine);
				}
				else
				{
					$machine->setEtat('Disponible');
					$machine->setDebutloc('');
					$machine->setFinloc('');
					$machine->setEntreprise('');
					$machine->setNomchantier('');
					$machine->setcodelocations('');
					$machine->setcodecontrat('');
					$machine->setClientid(0);
					$em->persist($machine);
				}
			}
			$locations  = $em->getRepository('BaclooCrmBundle:Locations')		
						   ->findOneById($codelocation);
						   
			$ficheid = $locations->getCodeclient();	
			


			// $em->remove($locations);
			$locations->setMachineid(0);
			$locations->setCodemachineinterne('');
			$locations->setEtatloc('');
			$locations->setEtatlog('');
			$em->persist($locations);
			
			$locata->setBdcrecu(0);
			$locata->setContrat(0);
			$em->persist($locata);
			
			$logistiqueliv  = $em->getRepository('BaclooCrmBundle:Logistique')		
						   ->findOneBy(array('codelocations' => $codelocation, 'codecontrat' => $codecontrat, 'materiel' => $ecode));
			if(!empty($logistiqueliv))
			{
				$em->remove($logistiqueliv);
			}

			$logistique  = $em->getRepository('BaclooCrmBundle:Logistiquerep')		
						   ->findOneByMateriel($ecode);
			
			if(isset($logistique))
			{
				$em->remove($logistique);
			}
			$em->flush();			
		}
		elseif($typeloc == 'sl')
		{
			$machine  = $em->getRepository('BaclooCrmBundle:Machinessl')		
						   ->findOneBy(array('code' => $ecode, 'codecontrat' => $codecontrat));
			$locata = $em->getRepository('BaclooCrmBundle:Locata')		
						   ->findOneById($codecontrat);
			
			if(!isset($machine))
			{
				foreach($locata->getLocations() as $locat)
				{
					if($locat->getCodemachineinterne() == $ecode)
					{
						$codelocation = $locat->getId();
					}
				}
			}
			else
			{
				$codelocation = $machine->getCodelocations();
				if($machine->getOriginal() == 0)
				{
					$em->remove($machine);
				}
				else
				{
					$machine->setEtat('Disponible');
					$machine->setDebutloc('');
					$machine->setFinloc('');
					$machine->setEntreprise('');
					$machine->setNomchantier('');
					$machine->setcodelocations('');
					$machine->setcodecontrat('');
					$machine->setClientid(0);
					$em->persist($machine);
				}
			}						   
			$locations  = $em->getRepository('BaclooCrmBundle:Locationssl')		
						   ->findOneById($codelocation);
						   
			$ficheid = $locations->getCodeclient();

			// $em->remove($locations);
			$locations->setMachineid(0);
			$locations->setCodemachineinterne('');
			$locations->setEtatloc('');
			$locations->setEtatlog('');
			$em->persist($locations);
			
			$locata->setBdcrecu(0);
			$locata->setContrat(0);
			$em->persist($locata);
			
			$logistiqueliv  = $em->getRepository('BaclooCrmBundle:Logistique')		
						   ->findOneBy(array('codelocations' => $codelocation, 'codecontrat' => $codecontrat, 'materiel' => $ecode));
			if(!empty($logistiqueliv))
			{
				$em->remove($logistiqueliv);
			}

			$logistique  = $em->getRepository('BaclooCrmBundle:Logistiquerep')		
						   ->findOneByMateriel($ecode);
			
			if(isset($logistique))
			{
				$em->remove($logistique);
			}
			$em->flush();			
		}
	return $this->redirect($this->generateUrl('bacloocrm_ajouterlocation', array('ficheid' => $ficheid, 'locid' => $codecontrat )));
	}

	public function removecontratAction($id, $codecontrat, $mode)
	{
		//$id  = fiche id
		//$raison = raison sociale de l'E
		//Mode permet de savoir s'il s'agit d'un contrat de vente ou de location
		$em = $this->getDoctrine()->getManager();
		$previous = $this->get('request')->server->get('HTTP_REFERER');
		
		if($mode == 'location')
		{		
			$contrat  = $em->getRepository('BaclooCrmBundle:Locata')		
						   ->findOneById($codecontrat);
						   
			$facture  = $em->getRepository('BaclooCrmBundle:Factures')		
						   ->findOneByCodelocata($codecontrat);	
						   
			if(empty($facture))
			{
				if($contrat->getContrat() != 1 && $contrat->getBdcrecu() != 1)
				{
					if(null !== $contrat->getLocations())
					{
						foreach($contrat->getLocations() as $loca)
						{
							$em->remove($loca);
						}
					}
					
					if(null !== $contrat->getLocationssl())
					{
						foreach($contrat->getLocationssl() as $loca)
						{
							$em->remove($loca);
						}
					}
					$em->remove($contrat);
					$em->flush();
				}
				elseif($contrat->getContrat() == 1 or $contrat->getBdcrecu() == 1)
				{
					if(null !== $contrat->getLocations())
					{
						foreach($contrat->getLocations() as $loca)
						{
							if(null !== $loca->getCodemachineinterne())
							{
								$machine = $em->getRepository('BaclooCrmBundle:Machines')		
											->findOneBy(array('code' => $loca->getCodemachineinterne(), 'codecontrat' => $codecontrat));

								if(isset($machine) && $machine->getOriginal() == 0)
								{
									$em->remove($machine);
								}
								elseif(isset($machine) && $machine->getOriginal() == 1)
								{
									$machine->setCodelocations(NULL);
									$machine->setCodecontrat(NULL);
									$machine->setClientid(0);
									$machine->setEntreprise(NULL);
									$machine->setNomchantier(NULL);
									$machine->setDebutloc(NULL);
									$machine->setFinloc(NULL);
									$machine->setEtat('Disponible');
									$em->persist($machine);
								}
								
								$logistique = $em->getRepository('BaclooCrmBundle:Logistique')		
											->findOneBy(array('materiel' => $loca->getCodemachineinterne(), 'codecontrat' => $codecontrat));
								if(!empty($logistique)){$em->remove($logistique);}
								
								$logistiquerep = $em->getRepository('BaclooCrmBundle:Logistiquerep')		
											->findOneBy(array('materiel' => $loca->getCodemachineinterne(), 'codecontrat' => $codecontrat));
								if(!empty($logistiquerep)){$em->remove($logistiquerep);}
							}
							$em->remove($loca);
						}
					}
					
					if(null !== $contrat->getLocationssl())
					{
						foreach($contrat->getLocationssl() as $loca)
						{
							if(null !== $loca->getCodemachineinterne())
							{
								$machine = $em->getRepository('BaclooCrmBundle:Machinessl')		
											->findOneBy(array('code' => $loca->getCodemachineinterne(), 'codecontrat' => $codecontrat));

								if(isset($machine))
								{
									$machine->setCodelocations(NULL);
									$machine->setCodecontrat(NULL);
									$machine->setClientid(0);
									$machine->setEntreprise(NULL);
									$machine->setNomchantier(NULL);
									$machine->setDebutloc(NULL);
									$machine->setFinloc(NULL);
									$machine->setEtat('Disponible');
									$em->persist($machine);
								}
								
								$logistique = $em->getRepository('BaclooCrmBundle:Logistique')		
											->findOneBy(array('materiel' => $loca->getCodemachineinterne(), 'codecontrat' => $codecontrat));
								if(!empty($logistique)){$em->remove($logistique);}
								
								$logistiquerep = $em->getRepository('BaclooCrmBundle:Logistiquerep')		
											->findOneBy(array('materiel' => $loca->getCodemachineinterne(), 'codecontrat' => $codecontrat));
								if(!empty($logistiquerep)){$em->remove($logistiquerep);}
							}
							$em->remove($loca);
						}
					}
					$em->remove($contrat);
					$em->flush();				
				}
			}
			else
			{
				$erreur = 1;
				return $this->redirect($this->generateUrl('bacloocrm_erreur', array('id' => $id, 'erreur' => $erreur)));					
			}
		}
		elseif($mode == 'vente')
		{
			$venda = $em->getRepository('BaclooCrmBundle:Venda')		
				   ->findOneByid($codecontrat);
				   
			$facture = $em->getRepository('BaclooCrmBundle:Factures')		
				   ->findOneBycodelocata('V-'.$codecontrat);
			
			if(!isset($facture))
			{
				$em->remove($venda);
				$em->flush();
			}
			else
			{
				$erreur = 1;
				return $this->redirect($this->generateUrl('bacloocrm_erreur', array('id' => $id, 'erreur' => $erreur)));					
			}
		}			
		return $this->redirect($this->generateUrl('bacloocrm_voir', array('id' => $id)));						
	}

	public function erreurAction($id, $erreur)
	{
		return $this->render('BaclooCrmBundle:Crm:erreur.html.twig', array(
							'id' => $id,
							'erreur'  => $erreur
							));	
	}
	
	public function ajouterChantierAction()
	{
		
		$objUser = $this->get('security.context')->getToken()->getUsername(); if(empty($objUser) or !isset($objUser) or $objUser == 'anon.'){return $this->redirect($this->generateUrl('fos_user_security_login'));}
		$em = $this->getDoctrine()->getManager();
		$userdetails  = $em->getRepository('BaclooUserBundle:User')		
					   ->findOneByUsername($objUser);			
		$userid = $userdetails->getId();	
		

		// On crée un objet Chantier
		$chantier = new Chantier;
		// $userid = $this->get('security.context')->getToken()->GetUser()->getId(); 
		$form = $this->createForm(new ChantierType($userid), $chantier);

		$today = date('d/m/Y');
		include('societe.php');
		// On récupère la requête
		$request = $this->get('request');//echo $request->getMethod();
		// On vérifie qu'elle est de type POST
		if ($request->getMethod() == 'POST') 
		{
		// On fait le lien Requête <-> Formulaire
		// À partir de maintenant, la variable $chantier contient les valeurs entrées dans le formulaire rempli par le visiteur
		// $form->bind($request);
		// On vérifie que les valeurs entrées sont correctes

			
				//Avant de persister la fiche, on supprime les collections qui sont entièrement vides
echo 'valide ?';
				// On enregistre notre objet $chantier dans la base de données		
				$form->bind($request);
				$nomchantier = $form->get('nom')->getData();echo 'lalala';echo $nomchantier;
				if(isset($nomchantier))
				{
					$chantia = $em->getRepository('BaclooCrmBundle:Chantier')		
						   ->findOneByNom($nomchantier);
					if(isset($chantia))
					{
						$chantier = $chantia;
					}
				}
				$chantier->setDescription(1);//On utulise le champ description pour flagger;

				$em->persist($chantier);
				$em->flush();
				// On définit un message flash sympa
				$this->get('session')->getFlashBag()->add('info', 'Chantier bien ajouté');			
				
				// On redirige vers la page de visualisation de la fiche nouvellement créée
				return $this->redirect($this->generateUrl('bacloocrm_voirchantier', array('id' => $chantier->getId())));
			
		}
		$em = $this->getDoctrine()->getManager();
		
		$user  = $em->getRepository('BaclooUserBundle:User')		
					   ->findOneByUsername($objUser);

		
		$modules  = $em->getRepository('BaclooCrmBundle:Modules')		
					   ->findOneByUsername($objUser);
					   
		return $this->render('BaclooCrmBundle:Crm:ajouterchantier.html.twig', array('form' => $form->createView(),
																			'date' => $today,
																			'usersociete' => $societe,
																			'user' => $objUser));
	}	

	public function voirchantierAction($id, Request $request)
	{
		$objUser = $this->get('security.context')->getToken()->getUsername();

		$em = $this->getDoctrine()->getManager();
		$userdetails  = $em->getRepository('BaclooUserBundle:User')		
					   ->findOneByUsername($objUser);			
		$userid = $userdetails->getId();
// echo 'idddd'.$id;
		$chantier = $em->getRepository('BaclooCrmBundle:Chantier')		
					   ->findOneById($id);		
		
		if(empty($objUser) or !isset($objUser) or $objUser == 'anon.')
		{
			return $this->redirect($this->generateUrl('fos_user_security_login'));
		}	

		$session = new Session();
		$session = $request->getSession();

		// définit et récupère des attributs de session
		$session->set('idchantier', $id);
		$session->set('init', '1');//on est en recherche
// echo 'view session'.$session->get('view');			
		$vue = $session->get('vue');
		$pid = $session->get('idsearch');
		$idsearchrap = $session->get('idsearchrap');
		if($session->get('page') > 0)
		{
			$page = $session->get('page');
		}
		else
		{
			$page = 1;
		}
		$view = $session->get('view');
		$init = $session->get('init');	
		include('societe.php');
				
				// $chantier_sel  = $em->getRepository('BaclooCrmBundle:Chantier')		
							   // ->find($id);

	// echo '  décollage';
		// On récupère l'EntityManager
		// $em = $this->getDoctrine()
				   // ->getManager();
					
		$today = date('d/m/Y');	
						// $listeBr = array();
						// foreach ($chantier->getBrappels() as $br) {
						  // $listeBr[] = $br;
						// }
						
						// $listeBe = array();
						// foreach ($chantier->getEvent() as $be) {
						  // $listeBe[] = $be;
						// }	

		// On créé le formulaire

		$userid = $userdetails->getId();	
		$form = $this->createForm(new ChantierType($userid), $chantier);
		$request = $this->get('request');
		if ($request->getMethod() == 'POST') {
	echo 'posssssssssssssssssssssss';
			$form->bind($request);
			if ($form->isValid()) {
			  
			$em = $this->getDoctrine()->getManager();	
			$em->persist($chantier);							
			$em->flush();
			// echo 'adresse1'.$chantier->getAdresse1();
			//ON vire les éléments vides
			// foreach ($chantier->getBrappels() as $br) {
			  // if(empty($br->getRapTexte())){$em->remove($br);}
			// }
			
			// $listeBe = array();
			// foreach ($chantier->getEvent() as $be) {
			  // if(empty($be->getEventComment())){$em->remove($be);}
			// }	
			//ON vire les éléments vides
			foreach ($chantier->getBrappels() as $br) {
			  if(empty($br->getRapTexte())){$em->remove($br);}
			}
			
			$listeBe = array();
			foreach ($chantier->getEvent() as $be) {
			  if(empty($be->getEventComment())){$em->remove($be);}
			}	
			$em->flush();
			
			
			return $this->redirect($this->generateUrl('bacloocrm_voirchantier', array('id' => $chantier->getId())));	 		 
		  } 
		 } 


	//créer table ca avec cols : userid, username, capot, cares, caperdu, date, ficheid				
			   
			$devis  = $em->getRepository('BaclooCrmBundle:Locata')		
						   ->findBy(array('clientid' => $id, 'offreencours' => 1, 'contrat' => 0),array('id' => 'DESC'));
				   
			$contrats  = $em->getRepository('BaclooCrmBundle:Locata')		
						   ->findBy(array('clientid' => $id, 'contrat' => 1),array('id' => 'DESC'));
						   
			$devisventes = $em->getRepository('BaclooCrmBundle:Venda')		
						   ->findBy(array('clientid' => $id, 'bdcrecu' => 0));
						   
			$ventes = $em->getRepository('BaclooCrmBundle:Venda')		
						   ->findBy(array('clientid' => $id, 'bdcrecu' => 1));
						   
			$contratssl  = $em->getRepository('BaclooCrmBundle:Locatasl')		
						   ->findBy(array('clientid' => $id, 'contrat' => 1));	
						   
	;		
	// echo 'looooo';
		// $string = str_replace(' ', '+', $chantier->getRaisonSociale());
		// $urlg = 'http://www.google.com/search?q='.$string;//echo $urlg;
		$pagesr = $session->get('pagesr');				   
		$userdetails  = $em->getRepository('BaclooUserBundle:User')		
					   ->findOneByUsername($objUser);			   
		$intervenants  = $em->getRepository('BaclooCrmBundle:Intervenantschantier')		
					   ->findByChantierid($id);
		return $this->render('BaclooCrmBundle:Crm:voirchantier.html.twig', array(
															  'form'    => $form->createView(),
															  //'countinter' => $countinter,
															  // 'list_tags' => $list_tags,
															  'id' => $chantier->getId(),
															  'societe' => $chantier->getNom(),
															  'cp' => $chantier->getCp(),
															  'usersociete' => $societe,
															  'useracc' => $objUser,
															  'userdetails' => $userdetails,
															  'chantier' => $chantier,
															  'vue' => $vue,
															  'page' => $page,
															  'pagesr' => $pagesr,
															  'pid'	=> $pid,
															  'idsearchrap'	=> $idsearchrap,
															  'view' => $view,
															  'init' => $init,
															  'date' => $today,	  
															  'roleuser' => $userdetails->getRoleuser(),
															  'user' => $objUser,
															  // 'modules' => $modules,	  
															  'contrats' => $contrats,	  
															  'contratssl' => $contratssl,	  
															  'devis' => $devis,	  
															  'devisventes' => $devisventes,	  
															  'ventes' => $ventes,
															  'intervenants' => $intervenants,
															  'roleuser' => $userdetails->getRoleuser()
															  // 'urlg' => $urlg	  
															));
	}	
	
	public function removechantierAction($id, $check)
	{//$id = id ligne partenaire
		$em = $this->getDoctrine()->getManager();
		$previous = $this->get('request')->server->get('HTTP_REFERER');

		if($check == '0')
		{
			return $this->render('BaclooCrmBundle:Crm:removechantier.html.twig', array('id' => $id,
																					'previous' => $previous,
																					'check' => 1));	
		}
		elseif($check == 'ok')
		{
				$chantier = $em->getRepository('BaclooCrmBundle:Chantier')		
							   ->findOneByid($id);			
				$em->remove($chantier);	
			$em->flush();	
			return $this->render('BaclooCrmBundle:Crm:removechantier.html.twig', array('check' => $check));				
		}				
	}	

    public function intertableauAction($id, $intervenants, $page, $mode, Request $request)
	{//echo 'idaaaaaa'.$id;
		$em = $this->getDoctrine()->getManager();
		//création du formlaire dans la liste des articles
		$defaultData = array();
		$form = $this->createFormBuilder($defaultData)
			->add('id')
            ->add('societeid', 'integer', array('required' => false))
            ->add('chantierid', 'integer', array('required' => false))
            ->add('societe', 'text', array('required' => false))
            ->add('activite', 'text', array('required' => true))
            ->add('civilite', 'text', array('required' => false))
            ->add('nom', 'text', array('required' => false))
            ->add('prenom', 'text', array('required' => false))
            ->add('fonction', 'text', array('required' => false))
            ->add('tel', 'text', array('required' => false))
            ->add('mail', 'text', array('required' => false))
            ->add('description', 'text', array('required' => false))
            ->add('commentaire','textarea', array('required' => false))
            ->add('statut', 'choice', array(
					'choices'   => array(
						'En cours'   => 'En cours',
						'Devis en cours' => 'Devis en cours',
						'Location' => 'Location',
						'Refus devis' => 'Refus devis',
						'Pas de besoin' => 'Pas de besoin',
					),
					'multiple'  => false,
				))
			->getForm();
// echo 'societe'.$intervenants;
			
			if($request->getMethod() == 'POST')
			{
				$form->handleRequest($request);
				$data = $form->getData();
				$interid = $data['id'];
				$societeid = $data['societeid'];
				$chantierid = $data['chantierid'];
				$societe = $data['societe'];
				$activite = $data['activite'];
				$civilite = $data['civilite'];
				$nom = $data['nom'];
				$prenom = $data['prenom'];
				$fonction = $data['fonction'];
				$tel = $data['tel'];
				$mail = $data['mail'];
				$commentaire = $data['commentaire'];
				$statut = $data['statut'];
				$description = $data['statut'];
				
				// if($form->isValid()){echo '+++++';
				// echo 'maj';	echo $mode;
				if($mode == 'creation')
				{
					$inter = new Intervenantschantier;
				}
				else
				{
					$inter = $em->getRepository('BaclooCrmBundle:Intervenantschantier')		
						   ->findOneById($interid);
				}
echo 'iffffff'.$interid;

				$inter->setSociete($societe);
				$inter->setSocieteid($societeid);
				$inter->setChantierid($chantierid);
				$inter->setActivite($activite);
				$inter->setCivilite($civilite);
				$inter->setNom($nom);
				$inter->setPrenom($prenom);
				$inter->setFonction($fonction);
				$inter->setTel($tel);
				$inter->setMail($mail);
				$inter->setCommentaire($commentaire);
				$inter->setStatut($statut);
					
				$em->persist($inter);
				$em->flush();
																// ));				
				return $this->redirect($this->generateUrl('bacloocrm_voirchantier', array('id' => $id)));
			}
		if(isset($intervenants) && $intervenants != '0')
		{	
			$query = $em->createQuery(
				'SELECT COUNT(f.id) as nbdevis
				FROM BaclooCrmBundle:Locata f
				WHERE f.clientid = :clientid
				AND f.chantierid = :chantierid');
			$query->setParameter('clientid', $intervenants->getSocieteid());
			$query->setParameter('chantierid', $id);
			$nbdevis = $query->getSingleScalarResult();
			
			$query = $em->createQuery(
				'SELECT COUNT(f.id) as nbdevis
				FROM BaclooCrmBundle:Locata f
				WHERE f.clientid = :clientid
				AND f.chantierid = :chantierid
				AND f.contrat = :contrat');
			$query->setParameter('clientid', $intervenants->getSocieteid());
			$query->setParameter('chantierid', $id);
			$query->setParameter('contrat', 1);
			$nbcontrats = $query->getSingleScalarResult();
			
			$query = $em->createQuery(
				'SELECT SUM(f.montantloc)+SUM(f.transportaller)+SUM(f.transportretour)+SUM(f.assurance)+SUM(f.contributionverte)
				FROM BaclooCrmBundle:Locata f
				WHERE f.clientid = :clientid
				AND f.chantierid = :chantierid
				AND f.contrat = :contrat');
			$query->setParameter('clientid', $intervenants->getSocieteid());
			$query->setParameter('chantierid', $id);
			$query->setParameter('contrat', 1);
			$cacontrats = $query->getSingleScalarResult();
		}
		else
		{
			$nbdevis = 0;
			$nbcontrats = 0;
			$cacontrats = 0;
		}
		if(!isset($cacontrats)){$cacontrats = 0;}
		return $this->render('BaclooCrmBundle:Crm:inter_tableau.html.twig', array('form' => $form->createView(),
																	'intervenant' => $intervenants,
																	'page' => $page,
																	'id' => $id,
																	'nbdevis' => $nbdevis,
																	'nbcontrats' => $nbcontrats,
																	'cacontrats' => $cacontrats,
																	'mode' => $mode
																));
	}
	
	public function requetesocieteAction(Request $request)
	{
			$search = $request->get('search');
			if(!empty($search))
			{
				$em = $this->getDoctrine()->getManager();	
				$query = $em->createQuery(
					'SELECT f
					FROM BaclooCrmBundle:Fiche f
					WHERE f.raisonSociale LIKE :raisonSociale'
				);
				$query->setParameter('raisonSociale', '%'.$search.'%');						
				$result = $query->getArrayResult();
				// Transformer le tableau associatif en un tableau standard
				$array = array();
				foreach ($result as $data) {
					$array[] = array("value"=>$data['id'], "label"=>$data['raisonSociale'],"id"=>$data['activite']);
				}			
			}
		$response = new Response(json_encode($array));
		return $response;
	}	
	
	public function removeintervenantAction($id, $idchantier)
	{//$id = id ligne partenaire
		$em = $this->getDoctrine()->getManager();
		$previous = $this->get('request')->server->get('HTTP_REFERER');

		$inter  = $em->getRepository('BaclooCrmBundle:Intervenantschantier')		
							   ->findOneByid($id);			
		$em->remove($inter);	
		$em->flush();	
		return $this->redirect($this->generateUrl('bacloocrm_voirchantier', array('id' => $idchantier)));			
						
	}

	public function dropzoneAction($codecontrat, $type, Request $request)
    {echo 'xxxxx'.$codecontrat;
		 $output = array('uploaded' => false);
		 // get the file from the request object
		 $file = $request->files->get('file');
		 // generate a new filename (safer, better approach)
		 // To use original filename, $fileName = $this->file->getClientOriginalName();
		 $fileName = $file->getClientOriginalName();
		 // Note: While using $file->guessExtension(), sometimes the MIME-guesser may fail silently for improperly encoded files. It is recommended to use a fallback for such cases if you know what file extensions are expected. (You can loop-over the allowed file extensions or even hard-code it if you expect only a particular type of file extension.)
	 
		 // set your uploads directory
		 $uploadDir = $this->get('kernel')->getRootDir() . '/../web/uploads/'.$type.'/'.$codecontrat.'/';
		 if (!file_exists($uploadDir) && !is_dir($uploadDir)) {
			 mkdir($uploadDir, 0775, true);
		 }
		 if ($file->move($uploadDir, $fileName)) { 
		         // get entity manager
			$em = $this->getDoctrine()->getManager();
	 
			// create and set this mediaEntity
			$document = new Document();
			$document->setNom($fileName);
			$document->setCodecontrat($codecontrat);
			$document->setType($type);
	 
			// save the uploaded filename to database
			$em->persist($document);
			$em->flush();
			$output['uploaded'] = true;
			$output['fileName'] = $fileName;
		 }
		 // return new JsonResponse($output);
		 if($type == 'machine')
		 {
			return $this->redirect($this->generateUrl('bacloocrm_machines', array('machineid' => $codecontrat)));
		 }
		 elseif($type == 'fiche')
		 {
			return $this->redirect($this->generateUrl('bacloocrm_voir', array('id' => $codecontrat)));
		 }
		 elseif($type == 'contrat')
		 {
			$contrat  = $em->getRepository('BaclooCrmBundle:Locata')		
						   ->findOneById($codecontrat);
			return $this->redirect($this->generateUrl('bacloocrm_ajouterlocation', array('ficheid' => $contrat->getClientid(), 'locid' => $codecontrat)));
		 }
	}
	
	public function testdropAction($codecontrat)
	{
        $em = $this->getDoctrine()->getManager();
		$documents  = $em->getRepository('BaclooCrmBundle:Document')		
					   ->findByCodecontrat($codecontrat);
		return $this->render('BaclooCrmBundle:Crm:dropzone.html.twig', array('documents'	=> $documents));
	}
	
    public function deleteResourceAction($codecontrat, Request $request){
        $output = array('deleted' => false, 'error' => false);
        $mediaID = $request->get('id');
        $fileName = $request->get('fileName');
        $em = $this->getDoctrine()->getManager();
        $media = $em->find('BaclooCrmBundle:Document', $mediaID);
        if ($fileName && $media && $media instanceof Document) {
            $uploadDir = $this->get('kernel')->getRootDir() . '/../web/uploads/';
            $output['deleted'] = unlink($uploadDir.$fileName);
            if ($output['deleted']) {
                // delete linked Document
                $em = $this->getDoctrine()->getManager();
                $em->remove($media);
                $em->flush();
            }
        } else {
            $output['error'] = 'Missing/Incorrect Media ID and/or FileName';
        }
        return new JsonResponse($output);
    }
	
	public function removedocumentAction($iddoc, $codecontrat, $type, Request $request)
	{//$id = id ligne partenaire
		$em = $this->getDoctrine()->getManager();
		$previous = $this->get('request')->server->get('HTTP_REFERER');
// echo 'iddoc'.$iddoc;echo 'type'.$type;echo 'codecontrat'.$codecontrat;
			$document  = $em->getRepository('BaclooCrmBundle:Document')		
						   ->findOneBy(array('id' => $iddoc, 'type' => $type));

			$nomfichier = $document->getNom();		
			$fs = new Filesystem();	

		 if($type == 'machine')
		 {	
			$fs->remove($this->get('kernel')->getRootDir().'/../web/uploads/machine/'.$codecontrat.'/'.$nomfichier);
			$em->remove($document);
			$em->flush();
			return $this->redirect($this->generateUrl('bacloocrm_machines', array('machineid' => $codecontrat)));
		 }
		 elseif($type == 'fiche')
		 {
			$em->remove($document);
			$em->flush();
			$fs->remove($this->get('kernel')->getRootDir().'/../web/uploads/fiche/'.$codecontrat.'/'.$nomfichier);
			return $this->redirect($this->generateUrl('bacloocrm_voir', array('id' => $codecontrat)));
		 }
		 elseif($type == 'contrat')
		 {
			$em->remove($document);
			$em->flush();
			$fs->remove($this->get('kernel')->getRootDir().'/../web/uploads/contrat/'.$codecontrat.'/'.$nomfichier);
			$contrat  = $em->getRepository('BaclooCrmBundle:Locata')		
						   ->findOneById($codecontrat);
			return $this->redirect($this->generateUrl('bacloocrm_ajouterlocation', array('ficheid' => $contrat->getClientid(), 'locid' => $codecontrat)));
		 }
	}
	
	public function listerelanceAction(Request $request)
	{
		$em = $this->getDoctrine()->getManager();		
		$listerelance = $em->getRepository('BaclooCrmBundle:Factures')
						->listerelance();
	
		$pdf = $this->get("white_october.tcpdf")->create();
		$html = $this->renderView('BaclooCrmBundle:Crm:listerelance.html.twig', array('listerelance' => $listerelance));
				$pdf->SetFont('helvetica', '', 9, '', true);
		
        $pdf->AddPage('L', 'A4');
        $pdf->writeHTML($html, true, false, true, false, '');
        $pdf->lastPage();
 
        $response = new Response($pdf->Output('file.pdf'));
        $response->headers->set('Content-Type', 'application/pdf');
 
        return $response;	
	}
	
	public function caCsvAction($dStart, $dEnd)
	{
		$response = new StreamedResponse();
		$response->setCallback(function() {
		$handle = fopen('php://output', 'w+');

        // Add the header of the CSV file
        fputcsv($handle, ['Mois', 'CA'],';');
	
		$em = $this->getDoctrine()->getManager();
		
		$results  = $em->getRepository('BaclooCrmBundle:Factures')		
					   ->last12mca3($dStart, $dEnd);	

		foreach($results as $c) {
            fputcsv(
                $handle, // The file pointer
		[$c->getDatemodif(), $c->getCareal()], // The fields
                ';' // The delimiter
            );
        }

			fclose($handle);
		});

		$response->setStatusCode(200);
		$response->headers->set('Content-Type', 'text/csv; charset=utf-8');
		$response->headers->set('Content-Disposition','attachment; filename="export.csv"');

		return $response;
	}

	public function camensuelclientsdetailleAction($mode, $page, $search, $dStart, $dEnd,  $client, Request $request)
	{
		$nbparpage = 30;
		$defaultData = array();		
		$form = $this->createFormBuilder($defaultData)
			->add('du', 'date', array('widget' => 'single_text',
										'input' => 'string',
										'format' => 'dd/MM/yyyy',
										'required' => false,
										'attr' => array('class' => 'date'),
										))
			->add('au', 'date', array('widget' => 'single_text',
										'input' => 'string',
										'format' => 'dd/MM/yyyy',
										'required' => false,
										'attr' => array('class' => 'date'),
										))
			->add('client', 'text', array('required' => false))
			->getForm();
		if($request->getMethod() == 'POST') {//echo 'VALIDE';		
			$form->handleRequest($request);
			$data = $form->getData();//var_dump($data);
			if(isset($data['du']))
			{
				$dStart = $data['du'];	
			}
			if(isset($data['au']))
			{
				$dEnd = $data['au'];
			}
			if(isset($data['client']))
			{
				$client = $data['client'];
			}
			$search = 1;
		}
// echo 'dend '.$dEnd;
		if($dStart == 0)
		{
			$dStart = date('Y-m-d', strtotime("-6 months"));
		}

		if($dEnd == 0)
		{
			$dEnd = date('Y-m-d');
		}
// echo 'DDTARTREPO'.$dStart;			
// echo 'DENDREPO'.$dEnd;			
			// $dEnd = '2018-11-30';
// echo 'search'.$search;			
		//1.Récupérer les données de la table Faccture
			$em = $this->getDoctrine()->getManager();
			
			$today = date('Y-m-d');
			$prev12 = date('Y-m-d', strtotime("-6 months"));			
			$ca  = $em->getRepository('BaclooCrmBundle:Locataclone')		
						   ->camensueldet($search, $dStart, $dEnd, $client);
			$caarray  = $em->getRepository('BaclooCrmBundle:Locataclone')		
						   ->camensuelarrayclientdet($search, $nbparpage, $page, $dStart, $dEnd, $client);
			$artica = $em->getRepository('BaclooCrmBundle:Locataclone')
							->camensuelarrayclienttotaldet($dStart, $dEnd, $client, $search);	
			$avoirsclients = $em->getRepository('BaclooCrmBundle:Factures')		
						   ->avoirsclients($dStart, $dEnd, $client, $search);			   

			// print_r($nbjannee);
			$commerciaux = array();
			foreach($caarray as $comm)
			{
				$commerciaux[]=$comm->getClient();
			}
			// foreach($ca as $con)
			// {
				// if($con->getClient() =='AIRESS')
				// {
					// echo $con->getClient();echo '>>';echo $con->getDatemodif();echo '>>';echo $con->getMontantloc();echo '<br>';
				// }
			// }
			// print_r($commerciaux);
			// foreach($commerciaux as $com)
			// {
				// echo 'XXXXXXXXXX';echo $com;
			// }
			// echo $i;
			// print_r($nbmois);
			//aDates contient nos entêtes de colonnes
			return $this->render('BaclooCrmBundle:Crm:camensuelclientsdetaille.html.twig', array(
					'search' => $search,
					'dstart' => $dStart,
					'dend' => $dEnd,
					'ca' => $ca,
					'avoirsclients' => $avoirsclients,
					'nombrePage' => ceil(count($artica)/$nbparpage),					
					'commerciaux' => $commerciaux,
					'form' => $form->createView(),
					'page' => $page,
					'mode' => $mode
			));		
	}

	public function camensuelclientsAction($mode, $page, $search, $dStart, $dEnd,  $client, Request $request)
	{
		$nbparpage = 30;
		$defaultData = array();		
		$form = $this->createFormBuilder($defaultData)
			->add('du', 'date', array('widget' => 'single_text',
										'input' => 'string',
										'format' => 'dd/MM/yyyy',
										'required' => false,
										'attr' => array('class' => 'date'),
										))
			->add('au', 'date', array('widget' => 'single_text',
										'input' => 'string',
										'format' => 'dd/MM/yyyy',
										'required' => false,
										'attr' => array('class' => 'date'),
										))
			->add('client', 'text', array('required' => false))
			->getForm();
		if($request->getMethod() == 'POST') {//echo 'VALIDE';		
			$form->handleRequest($request);
			$data = $form->getData();//var_dump($data);
			if(isset($data['du']))
			{
				$dStart = $data['du'];	
			}
			if(isset($data['au']))
			{
				$dEnd = $data['au'];
			}
			if(isset($data['client']))
			{
				$client = $data['client'];
			}
			$search = 1;
		}
// echo 'dend '.$dEnd;
		if($dStart == 0)
		{
			$dStart = date('Y-m-d', strtotime("-6 months"));
		}

		if($dEnd == 0)
		{
			$dEnd = date('Y-m-d');
		}
// echo $dStart;			
			// $dEnd = '2018-11-30';
// echo 'search'.$search;			
		//1.Récupérer les données de la table Faccture
			$em = $this->getDoctrine()->getManager();
			
			$today = date('Y-m-d');
			$prev12 = date('Y-m-d', strtotime("-6 months"));			
			$ca  = $em->getRepository('BaclooCrmBundle:Locataclone')		
						   ->camensuel($search, $dStart, $dEnd, $client);
			$caarray  = $em->getRepository('BaclooCrmBundle:Locataclone')		
						   ->camensuelarrayclient($search, $nbparpage, $page, $dStart, $dEnd, $client);
			$artica = $em->getRepository('BaclooCrmBundle:Locataclone')
							->camensuelarrayclienttotal($dStart, $dEnd, $client, $search);		   
// var_dump($ca);			   
// echo '$$$$$$'.print_r($ca);	echo '<<<<<';		   
		//2.On génère les entêtes de colonnes à partir de la fonction createplanning
			$iStart = strtotime ($dStart);//Formate une date/heure locale avec la Something is wronguration locale
			$iEnd = strtotime ($dEnd);
			if (false === $iStart || false === $iEnd) {
				// return false;
			}
			$aStart = explode ('-', $dStart);
			$aEnd = explode ('-', $dEnd);
			if (count ($aStart) !== 3 || count ($aEnd) !== 3) {
				// return false;
			}
			// if (false === checkdate ($aStart[1], $aStart[2], $aStart[0]) || false === checkdate ($aEnd[1], $aEnd[2], $aEnd[0]) || $iEnd <= $iStart) {
				// return false;
			// }
			for ($i = $iStart; $i < $iEnd + 86400; $i = strtotime ('+1 day', $i) ) {
				$sDateToArr = strftime ('%Y-%m-%d', $i);
				$sYear = substr ($sDateToArr, 0, 4);
				$sMonth = substr ($sDateToArr, 5, 2);
				$aDates[$sYear][$sMonth][] = $sDateToArr;
			}
			
			$nbannee = 0;
			$nbmoisparannee = 0;
			//Calcule le nombre de jours dans le mois
			$annee1 = date("Y", strtotime($dStart));
			$anneef = date("Y", strtotime($dStart));
			$anneefin = $anneef + 1;
			
			//Boucle parcours tableau année, mois, jours.
			//Celle-ci renvoie le nombre de  jours du premier mois m1
			$m11 = 1;
			foreach($aDates as $annee => $moiss)
			{
				foreach($moiss as $date => $mois)
				{
					if($m11 == 1)//si on est en m1 on procède sinon break
					{
						foreach($mois as $dat)
						{						
							$m11++;
						}
					}
					else
					{
						break;
					}
				}
				
			}
			$m1 = $m11-1;
			//Calcul du nb total de mois $m
			$m = 0;
			foreach($aDates as $annee => $moiss)
			{
				foreach($moiss as $date => $mois)
				{
					$m++;
				}
				
			}
			
			//Calcul du nb total d'années $a
			$an = 0;
			foreach($aDates as $annee => $moiss)
			{
				$an++;				
			}
// echo $m;			
			//Celle-ci renvoie le nombre de jours du dernier mois mm
			$mm = 0;
			$compteurm = 1;
			foreach($aDates as $annee => $moiss)
			{
				foreach($moiss as $date => $mois)
				{
					if($compteurm == $m)//si on est le dernier mois
					{
						foreach($mois as $dat)
						{						
							$mm++;
						}
					}
					else
					{}
				$compteurm++;
				}
				
			}
			
			//Celle-ci renvoie le nombre de jours de la première année $a1
			$a11 = 1;
			foreach($aDates as $annee => $moiss)
			{
				if($a11 == 1)//si on est en a1 on procède sinon break
				{
					foreach($moiss as $date => $mois)
					{
						foreach($mois as $dat)
						{						
							$a11++;
						}
					}
				}
				else
				{
					break;
				}
			}
			$a1 = $a11-1;
			//Fonction qui calcule le nombre de jours dans l'année
			function cal_days_in_year($year){
				$days=0; 
				for($month=1;$month<=12;$month++){ 
					$days = $days + cal_days_in_month(CAL_GREGORIAN,$month,$year);
				 }
			return $days;
			}			
			//Celle-ci renvoie le nombre de jours de la dernière année $aa
			$aa = 0;
			$compteura = 1;//echo '$an'.$an;
			foreach($aDates as $annee => $moiss)
			{
				if($compteura == $an)//si on est en end ernière année on calcule le nb de jours $aa
				{
					foreach($moiss as $date => $mois)
					{
						foreach($mois as $dat)
						{						
							$aa++;
						}
					}
				}
				elseif($compteura > $an)
				{
					break;
				}
				$compteura++;
			}//echo 'aa'.$aa;echo 'compteura'.$compteura;
			// echo 'www'.$mm.'www';
			// $mm = 0; //Compteur de mois qui s'incrémente de 1 afin de faire un compte indépendant des mois.
			$nbjrparmois = 0;
			$i = 1; //Compteur pour premier mois
			$a = 1; //Compteur pour la première année
			$nbmois = array();
			$nbjannee = array();
			foreach($aDates as $annee => $moiss)
			{	
				//Calculer le nombre d'années
				// echo $annee;
				if($a == 1)//Si on est en première année
				{
					$nbjannee[] = $a1;//nb de jours de la première année
				}
				elseif($a == $an)
				{
					$nbjannee[] = $aa;
				}
				else
				{
					$nbjannee[] = cal_days_in_year($annee);
				}
				foreach($moiss as $date => $mois)
				{
					if($i == 1)//on est au premier mois
					{
						//nb jours mois courant
						$nbmois[] = $m1;
					}
					elseif($i == $m)//Si on est  le dernier mois de la période on met le nb de jours
					{
						//nb de jours du dernier mois
						$nbmois[] = $mm;
					}
					else
					{
						//Pour les autres mois
						$nbmois[] = cal_days_in_month(CAL_GREGORIAN, $date, $annee);
					}
					$i++;
				}
				$a++;
			}
			// print_r($nbjannee);
			$commerciaux = array();
			foreach($caarray as $comm)
			{
				$commerciaux[]=$comm->getClient();
			}
			// foreach($ca as $con)
			// {
				// if($con->getClient() =='AIRESS')
				// {
					// echo $con->getClient();echo '>>';echo $con->getDatemodif();echo '>>';echo $con->getMontantloc();echo '<br>';
				// }
			// }
			// print_r($commerciaux);
			// foreach($commerciaux as $com)
			// {
				// echo 'XXXXXXXXXX';echo $com;
			// }
			// echo $i;
			// print_r($nbmois);
			//aDates contient nos entêtes de colonnes
			return $this->render('BaclooCrmBundle:Crm:camensuelclients.html.twig', array(
					'dates' => $aDates,
					'dstart' => $dStart,
					'dend' => $dEnd,
					'search' => $search,
					'ca' => $ca,
					'nombrePage' => ceil(count($artica)/$nbparpage),
					'ans' => $an,
					'commerciaux' => $commerciaux,
					'nbjannee' => $nbjannee,
					'form' => $form->createView(),
					'page' => $page,
					'mode' => $mode,
					'nbmois' => $nbmois
			));		
	}
	
	function foldersizeAction()
	{
		$dir = 'uploads/';
		$bytes = 0;
		$iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir));
		foreach ($iterator as $i) 
		{
		  $bytes += $i->getSize();
		}
		return $this->render('BaclooCrmBundle:Crm:foldersize.html.twig', array(
											'size' => $bytes
											));
	}

	public function camensuelmachinesAction($mode, $page, $search, $dStart, $dEnd, Request $request)
	{
		$nbparpage = 30;
		$defaultData = array();		
		$form = $this->createFormBuilder($defaultData)
			->add('du', 'date', array('widget' => 'single_text',
										'input' => 'string',
										'format' => 'dd/MM/yyyy',
										'required' => false,
										'attr' => array('class' => 'date'),
										))
			->add('au', 'date', array('widget' => 'single_text',
										'input' => 'string',
										'format' => 'dd/MM/yyyy',
										'required' => false,
										'attr' => array('class' => 'date'),
										))
			->getForm();
		if($request->getMethod() == 'POST') {//echo 'VALIDE';		
			$form->handleRequest($request);
			$data = $form->getData();//var_dump($data);
			if(isset($data['du']))
			{
				$dStart = $data['du'];	
			}
			if(isset($data['au']))
			{
				$dEnd = $data['au'];
			}				
		}
// echo 'dend '.$dEnd;
		if($dStart == 0)
		{
			$dStart = date('Y-m-d', strtotime("-6 months"));
		}

		if($dEnd == 0)
		{
			$dEnd = date('Y-m-d');
		}
// echo $dStart;			
			// $dEnd = '2018-11-30';
// echo 'search'.$search;			
		//1.Récupérer les données de la table Faccture
			$em = $this->getDoctrine()->getManager();
			
			$today = date('Y-m-d');
			$prev12 = date('Y-m-d', strtotime("-6 months"));			
			$ca  = $em->getRepository('BaclooCrmBundle:Locationsclone')		
						   ->camensuel($search, $dStart, $dEnd);
			$caarray  = $em->getRepository('BaclooCrmBundle:Locationsclone')		
						   ->camensuelarrayclient($search, $nbparpage, $page, $dStart, $dEnd);
			$artica = $em->getRepository('BaclooCrmBundle:Locationsclone')
							->camensuelarrayclienttotal($dStart, $dEnd);						   
// var_dump($ca);			   
// echo '$$$$$$'.print_r($ca);	echo '<<<<<';		   
		//2.On génère les entêtes de colonnes à partir de la fonction createplanning
			$iStart = strtotime ($dStart);//Formate une date/heure locale avec la Something is wronguration locale
			$iEnd = strtotime ($dEnd);
			if (false === $iStart || false === $iEnd) {
				// return false;
			}
			$aStart = explode ('-', $dStart);
			$aEnd = explode ('-', $dEnd);
			if (count ($aStart) !== 3 || count ($aEnd) !== 3) {
				// return false;
			}
			// if (false === checkdate ($aStart[1], $aStart[2], $aStart[0]) || false === checkdate ($aEnd[1], $aEnd[2], $aEnd[0]) || $iEnd <= $iStart) {
				// return false;
			// }
			for ($i = $iStart; $i < $iEnd + 86400; $i = strtotime ('+1 day', $i) ) {
				$sDateToArr = strftime ('%Y-%m-%d', $i);
				$sYear = substr ($sDateToArr, 0, 4);
				$sMonth = substr ($sDateToArr, 5, 2);
				$aDates[$sYear][$sMonth][] = $sDateToArr;
			}
			
			$nbannee = 0;
			$nbmoisparannee = 0;
			//Calcule le nombre de jours dans le mois
			$annee1 = date("Y", strtotime($dStart));
			$anneef = date("Y", strtotime($dStart));
			$anneefin = $anneef + 1;
			
			//Boucle parcours tableau année, mois, jours.
			//Celle-ci renvoie le nombre de  jours du premier mois m1
			$m11 = 1;
			foreach($aDates as $annee => $moiss)
			{
				foreach($moiss as $date => $mois)
				{
					if($m11 == 1)//si on est en m1 on procède sinon break
					{
						foreach($mois as $dat)
						{						
							$m11++;
						}
					}
					else
					{
						break;
					}
				}
				
			}
			$m1 = $m11-1;
			//Calcul du nb total de mois $m
			$m = 0;
			foreach($aDates as $annee => $moiss)
			{
				foreach($moiss as $date => $mois)
				{
					$m++;
				}
				
			}
			
			//Calcul du nb total d'années $a
			$an = 0;
			foreach($aDates as $annee => $moiss)
			{
				$an++;				
			}
// echo $m;			
			//Celle-ci renvoie le nombre de jours du dernier mois mm
			$mm = 0;
			$compteurm = 1;
			foreach($aDates as $annee => $moiss)
			{
				foreach($moiss as $date => $mois)
				{
					if($compteurm == $m)//si on est le dernier mois
					{
						foreach($mois as $dat)
						{						
							$mm++;
						}
					}
					else
					{}
				$compteurm++;
				}
				
			}
			
			//Celle-ci renvoie le nombre de jours de la première année $a1
			$a11 = 1;
			foreach($aDates as $annee => $moiss)
			{
				if($a11 == 1)//si on est en a1 on procède sinon break
				{
					foreach($moiss as $date => $mois)
					{
						foreach($mois as $dat)
						{						
							$a11++;
						}
					}
				}
				else
				{
					break;
				}
			}
			$a1 = $a11-1;
			//Fonction qui calcule le nombre de jours dans l'année
			function cal_days_in_year($year){
				$days=0; 
				for($month=1;$month<=12;$month++){ 
					$days = $days + cal_days_in_month(CAL_GREGORIAN,$month,$year);
				 }
			return $days;
			}			
			//Celle-ci renvoie le nombre de jours de la dernière année $aa
			$aa = 0;
			$compteura = 1;//echo '$an'.$an;
			foreach($aDates as $annee => $moiss)
			{
				if($compteura == $an)//si on est en end ernière année on calcule le nb de jours $aa
				{
					foreach($moiss as $date => $mois)
					{
						foreach($mois as $dat)
						{						
							$aa++;
						}
					}
				}
				elseif($compteura > $an)
				{
					break;
				}
				$compteura++;
			}//echo 'aa'.$aa;echo 'compteura'.$compteura;
			// echo 'www'.$mm.'www';
			// $mm = 0; //Compteur de mois qui s'incrémente de 1 afin de faire un compte indépendant des mois.
			$nbjrparmois = 0;
			$i = 1; //Compteur pour premier mois
			$a = 1; //Compteur pour la première année
			$nbmois = array();
			$nbjannee = array();
			foreach($aDates as $annee => $moiss)
			{	
				//Calculer le nombre d'années
				// echo $annee;
				if($a == 1)//Si on est en première année
				{
					$nbjannee[] = $a1;//nb de jours de la première année
				}
				elseif($a == $an)
				{
					$nbjannee[] = $aa;
				}
				else
				{
					$nbjannee[] = cal_days_in_year($annee);
				}
				foreach($moiss as $date => $mois)
				{
					if($i == 1)//on est au premier mois
					{
						//nb jours mois courant
						$nbmois[] = $m1;
					}
					elseif($i == $m)//Si on est  le dernier mois de la période on met le nb de jours
					{
						//nb de jours du dernier mois
						$nbmois[] = $mm;
					}
					else
					{
						//Pour les autres mois
						$nbmois[] = cal_days_in_month(CAL_GREGORIAN, $date, $annee);
					}
					$i++;
				}
				$a++;
			}
			// print_r($nbjannee);
			$commerciaux = array();
			foreach($caarray as $comm)
			{
				$commerciaux[]=$comm->getCodemachineinterne();
			}
			// foreach($ca as $con)
			// {
				// if($con->getClient() =='AIRESS')
				// {
					// echo $con->getClient();echo '>>';echo $con->getDatemodif();echo '>>';echo $con->getMontantloc();echo '<br>';
				// }
			// }
			// print_r($commerciaux);
			// foreach($commerciaux as $com)
			// {
				// echo 'XXXXXXXXXX';echo $com;
			// }
			// echo $i;
			// print_r($nbmois);
			//aDates contient nos entêtes de colonnes
			return $this->render('BaclooCrmBundle:Crm:camensuelmachines.html.twig', array(
					'dates' => $aDates,
					'dstart' => $dStart,
					'dend' => $dEnd,
					'search' => $search,
					'ca' => $ca,
					'nombrePage' => ceil(count($artica)/$nbparpage),
					'ans' => $an,
					'commerciaux' => $commerciaux,
					'nbjannee' => $nbjannee,
					'form' => $form->createView(),
					'page' => $page,
					'mode' => $mode,
					'nbmois' => $nbmois
			));		
	}

	public function camensueltypemachinesAction($mode, $page, $search, $dStart, $dEnd, Request $request)
	{
		$nbparpage = 60;
		$defaultData = array();		
		$form = $this->createFormBuilder($defaultData)
			->add('du', 'date', array('widget' => 'single_text',
										'input' => 'string',
										'format' => 'dd/MM/yyyy',
										'required' => false,
										'attr' => array('class' => 'date'),
										))
			->add('au', 'date', array('widget' => 'single_text',
										'input' => 'string',
										'format' => 'dd/MM/yyyy',
										'required' => false,
										'attr' => array('class' => 'date'),
										))
			->getForm();
		if($request->getMethod() == 'POST') {//echo 'VALIDE';		
			$form->handleRequest($request);
			$data = $form->getData();//var_dump($data);
			if(isset($data['du']))
			{
				$dStart = $data['du'];	
			}
			if(isset($data['au']))
			{
				$dEnd = $data['au'];
			}				
		}
// echo 'dend '.$dEnd;
		if($dStart == 0)
		{
			$dStart = date('Y-m-d', strtotime("-6 months"));
		}

		if($dEnd == 0)
		{
			$dEnd = date('Y-m-d');
		}
// echo $dStart;			
			// $dEnd = '2018-11-30';
// echo 'search'.$search;			
		//1.Récupérer les données de la table Faccture
			$em = $this->getDoctrine()->getManager();
			
			$today = date('Y-m-d');
			$prev12 = date('Y-m-d', strtotime("-6 months"));			
			$ca  = $em->getRepository('BaclooCrmBundle:Locationsclone')		
						   ->camensueltype($search, $dStart, $dEnd);
			$caarray  = $em->getRepository('BaclooCrmBundle:Locationsclone')		
						   ->camensuelarrayclienttype($search, $nbparpage, $page, $dStart, $dEnd);
			$artica = $em->getRepository('BaclooCrmBundle:Locationsclone')
							->camensuelarraycodemachine($dStart, $dEnd);						   
// var_dump($ca);			   
// echo '$$$$$$'.print_r($ca);	echo '<<<<<';		   
		//2.On génère les entêtes de colonnes à partir de la fonction createplanning
			$iStart = strtotime ($dStart);//Formate une date/heure locale avec la Something is wronguration locale
			$iEnd = strtotime ($dEnd);
			if (false === $iStart || false === $iEnd) {
				// return false;
			}
			$aStart = explode ('-', $dStart);
			$aEnd = explode ('-', $dEnd);
			if (count ($aStart) !== 3 || count ($aEnd) !== 3) {
				// return false;
			}
			// if (false === checkdate ($aStart[1], $aStart[2], $aStart[0]) || false === checkdate ($aEnd[1], $aEnd[2], $aEnd[0]) || $iEnd <= $iStart) {
				// return false;
			// }
			for ($i = $iStart; $i < $iEnd + 86400; $i = strtotime ('+1 day', $i) ) {
				$sDateToArr = strftime ('%Y-%m-%d', $i);
				$sYear = substr ($sDateToArr, 0, 4);
				$sMonth = substr ($sDateToArr, 5, 2);
				$aDates[$sYear][$sMonth][] = $sDateToArr;
			}
			
			$nbannee = 0;
			$nbmoisparannee = 0;
			//Calcule le nombre de jours dans le mois
			$annee1 = date("Y", strtotime($dStart));
			$anneef = date("Y", strtotime($dStart));
			$anneefin = $anneef + 1;
			
			//Boucle parcours tableau année, mois, jours.
			//Celle-ci renvoie le nombre de  jours du premier mois m1
			$m11 = 1;
			foreach($aDates as $annee => $moiss)
			{
				foreach($moiss as $date => $mois)
				{
					if($m11 == 1)//si on est en m1 on procède sinon break
					{
						foreach($mois as $dat)
						{						
							$m11++;
						}
					}
					else
					{
						break;
					}
				}
				
			}
			$m1 = $m11-1;
			//Calcul du nb total de mois $m
			$m = 0;
			foreach($aDates as $annee => $moiss)
			{
				foreach($moiss as $date => $mois)
				{
					$m++;
				}
				
			}
			
			//Calcul du nb total d'années $a
			$an = 0;
			foreach($aDates as $annee => $moiss)
			{
				$an++;				
			}
// echo $m;			
			//Celle-ci renvoie le nombre de jours du dernier mois mm
			$mm = 0;
			$compteurm = 1;
			foreach($aDates as $annee => $moiss)
			{
				foreach($moiss as $date => $mois)
				{
					if($compteurm == $m)//si on est le dernier mois
					{
						foreach($mois as $dat)
						{						
							$mm++;
						}
					}
					else
					{}
				$compteurm++;
				}
				
			}
			
			//Celle-ci renvoie le nombre de jours de la première année $a1
			$a11 = 1;
			foreach($aDates as $annee => $moiss)
			{
				if($a11 == 1)//si on est en a1 on procède sinon break
				{
					foreach($moiss as $date => $mois)
					{
						foreach($mois as $dat)
						{						
							$a11++;
						}
					}
				}
				else
				{
					break;
				}
			}
			$a1 = $a11-1;
			//Fonction qui calcule le nombre de jours dans l'année
			function cal_days_in_year($year){
				$days=0; 
				for($month=1;$month<=12;$month++){ 
					$days = $days + cal_days_in_month(CAL_GREGORIAN,$month,$year);
				 }
			return $days;
			}			
			//Celle-ci renvoie le nombre de jours de la dernière année $aa
			$aa = 0;
			$compteura = 1;//echo '$an'.$an;
			foreach($aDates as $annee => $moiss)
			{
				if($compteura == $an)//si on est en end ernière année on calcule le nb de jours $aa
				{
					foreach($moiss as $date => $mois)
					{
						foreach($mois as $dat)
						{						
							$aa++;
						}
					}
				}
				elseif($compteura > $an)
				{
					break;
				}
				$compteura++;
			}//echo 'aa'.$aa;echo 'compteura'.$compteura;
			// echo 'www'.$mm.'www';
			// $mm = 0; //Compteur de mois qui s'incrémente de 1 afin de faire un compte indépendant des mois.
			$nbjrparmois = 0;
			$i = 1; //Compteur pour premier mois
			$a = 1; //Compteur pour la première année
			$nbmois = array();
			$nbjannee = array();
			foreach($aDates as $annee => $moiss)
			{	
				//Calculer le nombre d'années
				// echo $annee;
				if($a == 1)//Si on est en première année
				{
					$nbjannee[] = $a1;//nb de jours de la première année
				}
				elseif($a == $an)
				{
					$nbjannee[] = $aa;
				}
				else
				{
					$nbjannee[] = cal_days_in_year($annee);
				}
				foreach($moiss as $date => $mois)
				{
					if($i == 1)//on est au premier mois
					{
						//nb jours mois courant
						$nbmois[] = $m1;
					}
					elseif($i == $m)//Si on est  le dernier mois de la période on met le nb de jours
					{
						//nb de jours du dernier mois
						$nbmois[] = $mm;
					}
					else
					{
						//Pour les autres mois
						$nbmois[] = cal_days_in_month(CAL_GREGORIAN, $date, $annee);
					}
					$i++;
				}
				$a++;
			}
			// print_r($nbjannee);
			$commerciaux = array();
			foreach($caarray as $comm)
			{
				$commerciaux[]=$comm['codemachine'];
			}
			// foreach($ca as $con)
			// {
				// if($con->getClient() =='AIRESS')
				// {
					// echo $con->getClient();echo '>>';echo $con->getDatemodif();echo '>>';echo $con->getMontantloc();echo '<br>';
				// }
			// }
			// print_r($commerciaux);
			// foreach($commerciaux as $com)
			// {
				// echo 'XXXXXXXXXX';echo $com;
			// }
			// echo $i;
			// print_r($nbmois);
			//aDates contient nos entêtes de colonnes
			return $this->render('BaclooCrmBundle:Crm:camensueltypemachines.html.twig', array(
					'dates' => $aDates,
					'dstart' => $dStart,
					'dend' => $dEnd,
					'search' => $search,
					'ca' => $ca,
					'nombrePage' => ceil(count($artica)/$nbparpage),
					'ans' => $an,
					'commerciaux' => $commerciaux,
					'nbjannee' => $nbjannee,
					'form' => $form->createView(),
					'page' => $page,
					'mode' => $mode,
					'nbmois' => $nbmois
			));		
	}

	public function camensueltypemachinesslAction($mode, $page, $search, $dStart, $dEnd, Request $request)
	{
		$nbparpage = 100;
		$defaultData = array();		
		$form = $this->createFormBuilder($defaultData)
			->add('du', 'date', array('widget' => 'single_text',
										'input' => 'string',
										'format' => 'dd/MM/yyyy',
										'required' => false,
										'attr' => array('class' => 'date'),
										))
			->add('au', 'date', array('widget' => 'single_text',
										'input' => 'string',
										'format' => 'dd/MM/yyyy',
										'required' => false,
										'attr' => array('class' => 'date'),
										))
			->getForm();
		if($request->getMethod() == 'POST') {//echo 'VALIDE';		
			$form->handleRequest($request);
			$data = $form->getData();//var_dump($data);
			if(isset($data['du']))
			{
				$dStart = $data['du'];	
			}
			if(isset($data['au']))
			{
				$dEnd = $data['au'];
			}				
		}
// echo 'dend '.$dEnd;
		if($dStart == 0)
		{
			$dStart = date('Y-m-d', strtotime("-6 months"));
		}

		if($dEnd == 0)
		{
			$dEnd = date('Y-m-d');
		}
// echo $dStart;			
			// $dEnd = '2018-11-30';
// echo 'search'.$search;			
		//1.Récupérer les données de la table Faccture
			$em = $this->getDoctrine()->getManager();
			
			$today = date('Y-m-d');
			$prev12 = date('Y-m-d', strtotime("-6 months"));			
			$ca  = $em->getRepository('BaclooCrmBundle:Locationsslclone')		
						   ->camensueltype($search, $dStart, $dEnd);
			$caarray  = $em->getRepository('BaclooCrmBundle:Locationsslclone')		
						   ->camensuelarrayclienttype($search, $nbparpage, $page, $dStart, $dEnd);
			$artica = $em->getRepository('BaclooCrmBundle:Locationsslclone')
							->camensuelarraycodemachine($dStart, $dEnd);						   
// var_dump($ca);			   
// echo '$$$$$$'.print_r($ca);	echo '<<<<<';		   
		//2.On génère les entêtes de colonnes à partir de la fonction createplanning
			$iStart = strtotime ($dStart);//Formate une date/heure locale avec la Something is wronguration locale
			$iEnd = strtotime ($dEnd);
			if (false === $iStart || false === $iEnd) {
				// return false;
			}
			$aStart = explode ('-', $dStart);
			$aEnd = explode ('-', $dEnd);
			if (count ($aStart) !== 3 || count ($aEnd) !== 3) {
				// return false;
			}
			// if (false === checkdate ($aStart[1], $aStart[2], $aStart[0]) || false === checkdate ($aEnd[1], $aEnd[2], $aEnd[0]) || $iEnd <= $iStart) {
				// return false;
			// }
			for ($i = $iStart; $i < $iEnd + 86400; $i = strtotime ('+1 day', $i) ) {
				$sDateToArr = strftime ('%Y-%m-%d', $i);
				$sYear = substr ($sDateToArr, 0, 4);
				$sMonth = substr ($sDateToArr, 5, 2);
				$aDates[$sYear][$sMonth][] = $sDateToArr;
			}
			
			$nbannee = 0;
			$nbmoisparannee = 0;
			//Calcule le nombre de jours dans le mois
			$annee1 = date("Y", strtotime($dStart));
			$anneef = date("Y", strtotime($dStart));
			$anneefin = $anneef + 1;
			
			//Boucle parcours tableau année, mois, jours.
			//Celle-ci renvoie le nombre de  jours du premier mois m1
			$m11 = 1;
			foreach($aDates as $annee => $moiss)
			{
				foreach($moiss as $date => $mois)
				{
					if($m11 == 1)//si on est en m1 on procède sinon break
					{
						foreach($mois as $dat)
						{						
							$m11++;
						}
					}
					else
					{
						break;
					}
				}
				
			}
			$m1 = $m11-1;
			//Calcul du nb total de mois $m
			$m = 0;
			foreach($aDates as $annee => $moiss)
			{
				foreach($moiss as $date => $mois)
				{
					$m++;
				}
				
			}
			
			//Calcul du nb total d'années $a
			$an = 0;
			foreach($aDates as $annee => $moiss)
			{
				$an++;				
			}
// echo $m;			
			//Celle-ci renvoie le nombre de jours du dernier mois mm
			$mm = 0;
			$compteurm = 1;
			foreach($aDates as $annee => $moiss)
			{
				foreach($moiss as $date => $mois)
				{
					if($compteurm == $m)//si on est le dernier mois
					{
						foreach($mois as $dat)
						{						
							$mm++;
						}
					}
					else
					{}
				$compteurm++;
				}
				
			}
			
			//Celle-ci renvoie le nombre de jours de la première année $a1
			$a11 = 1;
			foreach($aDates as $annee => $moiss)
			{
				if($a11 == 1)//si on est en a1 on procède sinon break
				{
					foreach($moiss as $date => $mois)
					{
						foreach($mois as $dat)
						{						
							$a11++;
						}
					}
				}
				else
				{
					break;
				}
			}
			$a1 = $a11-1;
			//Fonction qui calcule le nombre de jours dans l'année
			function cal_days_in_year($year){
				$days=0; 
				for($month=1;$month<=12;$month++){ 
					$days = $days + cal_days_in_month(CAL_GREGORIAN,$month,$year);
				 }
			return $days;
			}			
			//Celle-ci renvoie le nombre de jours de la dernière année $aa
			$aa = 0;
			$compteura = 1;//echo '$an'.$an;
			foreach($aDates as $annee => $moiss)
			{
				if($compteura == $an)//si on est en end ernière année on calcule le nb de jours $aa
				{
					foreach($moiss as $date => $mois)
					{
						foreach($mois as $dat)
						{						
							$aa++;
						}
					}
				}
				elseif($compteura > $an)
				{
					break;
				}
				$compteura++;
			}//echo 'aa'.$aa;echo 'compteura'.$compteura;
			// echo 'www'.$mm.'www';
			// $mm = 0; //Compteur de mois qui s'incrémente de 1 afin de faire un compte indépendant des mois.
			$nbjrparmois = 0;
			$i = 1; //Compteur pour premier mois
			$a = 1; //Compteur pour la première année
			$nbmois = array();
			$nbjannee = array();
			foreach($aDates as $annee => $moiss)
			{	
				//Calculer le nombre d'années
				// echo $annee;
				if($a == 1)//Si on est en première année
				{
					$nbjannee[] = $a1;//nb de jours de la première année
				}
				elseif($a == $an)
				{
					$nbjannee[] = $aa;
				}
				else
				{
					$nbjannee[] = cal_days_in_year($annee);
				}
				foreach($moiss as $date => $mois)
				{
					if($i == 1)//on est au premier mois
					{
						//nb jours mois courant
						$nbmois[] = $m1;
					}
					elseif($i == $m)//Si on est  le dernier mois de la période on met le nb de jours
					{
						//nb de jours du dernier mois
						$nbmois[] = $mm;
					}
					else
					{
						//Pour les autres mois
						$nbmois[] = cal_days_in_month(CAL_GREGORIAN, $date, $annee);
					}
					$i++;
				}
				$a++;
			}
			// print_r($nbjannee);
			$commerciaux = array();
			foreach($caarray as $comm)
			{
				$commerciaux[]=$comm['codemachine'];
			}
			// foreach($ca as $con)
			// {
				// if($con->getClient() =='AIRESS')
				// {
					// echo $con->getClient();echo '>>';echo $con->getDatemodif();echo '>>';echo $con->getMontantloc();echo '<br>';
				// }
			// }
			// print_r($commerciaux);
			// foreach($commerciaux as $com)
			// {
				// echo 'XXXXXXXXXX';echo $com;
			// }
			// echo $i;
			// print_r($nbmois);
			//aDates contient nos entêtes de colonnes
			return $this->render('BaclooCrmBundle:Crm:camensueltypemachinessl.html.twig', array(
					'dates' => $aDates,
					'dstart' => $dStart,
					'dend' => $dEnd,
					'search' => $search,
					'ca' => $ca,
					'nombrePage' => ceil(count($artica)/$nbparpage),
					'ans' => $an,
					'commerciaux' => $commerciaux,
					'nbjannee' => $nbjannee,
					'form' => $form->createView(),
					'page' => $page,
					'mode' => $mode,
					'nbmois' => $nbmois
			));		
	}		
		
	public function formulaireleadAction($id, $messagex)
	{
		// $usersess = $this->get('security.context')->getToken()->getUsername();

		// include('societe.php');
		$cr = 'HELLO WORLD';
		return $this->render('BaclooCrmBundle:Crm:formulairelead.html.twig', array(
					'id' => $id,
					'messagex' => $messagex,
					));			
	}
	
	public function requetedetail1Action(Request $request)
	{
		// $request = $request->get('request');
		// if($request == 1){
			$search = $request->get('search');
			// $search = 'renov';
			if(!empty($search))
			{
				$em = $this->getDoctrine()->getManager();
				$query = $em->createQuery(
					'SELECT f
					FROM BaclooCrmBundle:Categorielead f
					WHERE f.formname LIKE :search
					Group By f.formname'
				);
				$query->setParameter('search', '%'.$search.'%');					
				$result = $query->getArrayResult();

				// Transformer le tableau associatif en un tableau standard
				$array = array();
				foreach ($result as $data) {
					$array[] = array("label"=>$data['formname'], "value"=>$data['id']);
				}				
			}
		$response = new Response(json_encode($array));
		return $response;
		// }
	}
	
	public function categorieAction(Request $request)
	{
		$objUser = $this->get('security.context')->getToken()->getUsername(); if(empty($objUser) or !isset($objUser) or $objUser == 'anon.'){return $this->redirect($this->generateUrl('fos_user_security_login'));}
		$em = $this->getDoctrine()->getManager();	
		$cata = $em->getRepository('BaclooCrmBundle:Cata')		
					   ->findOneByControle('1234');
		$form = $this->createForm(new CataType(), $cata);
		
		$userdetails  = $em->getRepository('BaclooUserBundle:User')		
					   ->findOneByUsername($objUser);			
		$userid = $userdetails->getId();

		$request = $this->get('request');
		if($request->getMethod() == 'POST') 
		{
			$form->bind($request);// On vérifie que les valeurs entrées sont correctes
			if($form->isValid())
			{				
				$tags = '';
				foreach($form->get('categorie')->getData() as $cat)
				{
					if($cat->getSelection() == 1)
					{
						$i=1;
						if($i == 1)
						{
							$tags .= $cat->getNomartisan().',';
						}
						else
						{
							$tags .= ','.$cat->getNomartisan();
						}
					}
				}
				$userdetails->setTags($tags);
				$i++;
				
				$em->persist($cata);	
				$em->flush();
				return $this->redirect($this->generateUrl('fos_user_profile_edit'));	
			}
		}
		return $this->render('BaclooCrmBundle:Crm:categorie.html.twig', array(
																	'form' => $form->createView()
																	));		
	}
	
	public function callbackviteundevisAction(Request $request)
	{	
		$devisid = $request->query->get('devis_id');
		$etat = $request->query->get('etat');
		$etattexte = $request->query->get('etat_texte');
		$reversement = $request->query->get('reversement');
// echo 'call me back';		
		$em = $this->getDoctrine()->getManager();
		//Créer une table reponsevite1devis afin d'y insérer les callbacks		
		$reponsevite1devis  = new Reponsevite1devis;	
		$reponsevite1devis->setDevisid($devisid);
		$reponsevite1devis->setEtat($etat);
		$reponsevite1devis->setEtattexte($etattexte);
		$reponsevite1devis->setReversement($reversement);		
		$em->persist($reponsevite1devis);
		$em->flush();
		
		//INSERER AUSSI UNE TRANSACTION		
		$fiche  = $em->getRepository('BaclooCrmBundle:Fiche')		
					   ->findOneById($devisid);
		if(isset($fiche) && $etat == 1)
		{
			$transac = $em->getRepository('BaclooCrmBundle:Transac')
						->findOneByVendeur('1234');				
			$transaction = new Transaction();
			$transaction->setRaisonSociale($fiche->GetRaisonSociale());
			$transaction->setVendeur($fiche->GetUser());
			$transaction->setAcheteur('Vite1devis');
			$transaction->setDate(date('Y-m-d'));
			$transaction->setPrix($reversement);
			$transaction->setTypetransac('palteforme');			
			$transaction->setControle('1234');			
			$transaction->setFicheid($fiche->getId());
			$transaction->setCommentaire($etattexte);
			$transaction->addTransac($transac);
			$transac->addTransaction($transaction);
			$em = $this->getDoctrine()->getManager();
			
			$fiche->setNbachatvite1devis($fiche->getNbachatvite1devis()+1);
													  
			$interresse = $em->getRepository('BaclooCrmBundle:interresses')
						->findOneBy(array('ficheid' => $fiche->getId(),
										  'username' => 'Vite1devis'));
			$interresse->setAchat($interresse->getAchat()+1);
			
			$prospot = $em->getRepository('BaclooCrmBundle:Prospot')
						->findOneBy(array('ficheid' => $fiche->getId(),
										  'user' => 'Vite1devis'));			
			$prospot->setNbachatvite1devis($prospot->getNbachatvite1devis()+1);
			
			$em->persist($fiche);
			$em->persist($interresse);
			$em->persist($prospot);
			$em->persist($transaction);
			$em->persist($transac);				
			$em->flush();
		}
		elseif($etat == 0)
		{
			$transac = $em->getRepository('BaclooCrmBundle:Transac')
						->findOneByVendeur('1234');				
			$transaction = new Transaction();
			$transaction->setRaisonSociale($fiche->GetRaisonSociale());
			$transaction->setVendeur($fiche->GetUser());
			$transaction->setAcheteur('Vite1devis');
			$transaction->setDate(date('Y-m-d'));
			$transaction->setPrix($reversement);
			$transaction->setTypetransac('palteforme');			
			$transaction->setControle('1234');			
			$transaction->setFicheid($fiche->getId());
			$transaction->setCommentaire($etattexte);
			$transaction->addTransac($transac);
			$transac->addTransaction($transaction);
			$em = $this->getDoctrine()->getManager();
			$em->persist($transaction);
			$em->persist($transac);	
			$em->flush();
		}
		$response = 'Thank you';
		return $response;
	}		

//PARTIE STRIPE		
	public function stripeAction()
	{
		// $usersess = $this->get('security.context')->getToken()->getUsername();

		// include('societe.php');
		$cr = 'HELLO WORLD';
		return $this->render('BaclooCrmBundle:Crm:stripe.html.twig', array(
					'cr' => $cr,
					));			
	}

	public function paymentAction($montant, $description, $a, Request $request)
	{
		$em = $this->getDoctrine()->getManager();
		$defaultData = array();
		$form = $this->createFormBuilder($defaultData)
		->add('token','text',['constraints' => [new NotBlank()],
			])
		->getForm();
		

		// $a = random_str(2);
		$session = new Session();
		$session = $request->getSession();
		$session->set('idtransaction', $a);
		$session->set('montant', $montant);echo 'mONTATAN'.$montant;
		$session->set('description', $description);
		$prix = $session->get('montant');echo 'PRIX'.$prix;
		
		if ($request->isMethod('POST')) {
			$form->handleRequest($request);
		}

		$objUser = $this->get('security.context')->getToken()->getUsername(); if(empty($objUser) or !isset($objUser) or $objUser == 'anon.'){return $this->redirect($this->generateUrl('fos_user_security_login'));}
		$em = $this->getDoctrine()->getManager();			
		$userdetails  = $em->getRepository('BaclooUserBundle:User')		
					   ->findOneByUsername($objUser);
					   
		return $this->render('BaclooCrmBundle:Crm:stripe.html.twig', array(
																	'idtransaction' => $a,
																	'montant' => $montant,
																	'email' => $userdetails->getEmail(),
																	'description' => $description,
																	));
	}
	
	public function stripecheckoutAction(Request $request)
	{		
		$session = $request->getSession();
		$user = $this->get('security.context')->getToken()->getUsername();
		$idtransaction = $request->query->get('id');
		$prix = $session->get('montant');echo 'PRIX'.$prix;
		$description = $session->get('description');
		// echo 'idtransacsess'.$session->get('idtransaction');echo '<br>idtransac'.$idtransaction;
		// echo 'rrrrrrrrr'.$_SERVER['HTTP_REFERER'];
		if(isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] == 'http://127.0.0.1:8080/symfony2/web/b/lead4you/web/app_dev.php/boutique_credits/' && $idtransaction == $session->get('idtransaction'))
		{
			
			$em = $this->getDoctrine()->getManager();
			
			//On récupère les crédits de l'utilisateur connecté
			$query = $em->createQuery(
				'SELECT u
				FROM BaclooUserBundle:User u
				WHERE u.username LIKE :username'
			);
			$query->setParameter('username', $user);				
			$acheteur = $query->getSingleResult();
			
			$payment = $em->getRepository('PaymentBundle:Payment')
					 ->findOneByNumber($idtransaction);
			if(!isset($payment))
			{//echo 'Process';
				$payment = new payment;
				$payment->setNumber($idtransaction);
				$payment->setCurrencyCode('EUR');
				$payment->setTotalAmount($prix); // 1.23 EUR
				$payment->setDescription($description);
				$payment->setClientId($acheteur->getId());
				$payment->setClientEmail($acheteur->getEmail());
				$payment->setUser($user);
				$payment->setDate(new \DateTime("now"));	
				if($prix == 20)
				{
					$creditsht = 20;
				}
				elseif($prix == 30)
				{
					$creditsht = 30;
				}
				else
				{
					$creditsht = 50;
				}
				$creditsfinal = $acheteur->getCredits() + $creditsht;
				
				$acheteur->setCredits($creditsfinal);
				$payment->setStatut('ok');
				$em->persist($payment);
				$em->persist($acheteur);
				$em->flush();	
			}
			else
			{
				//echo 'pas process';
				$creditsht = 0;
			}
			
			return $this->render('BaclooCrmBundle:Crm:stripecheckout.html.twig', array('credit' => $creditsht));
		}
		else
		{
			//echo 'flop';
			return $this->redirect($this->generateUrl('bacloocrm_store'));	
		}
	}
//FIN PARTIE STRIPE
	
	public function impression_factureleadAction($paymentid, Request $request)
	{
		$objUser = $this->get('security.context')->getToken()->getUsername(); if(empty($objUser) or !isset($objUser) or $objUser == 'anon.'){return $this->redirect($this->generateUrl('fos_user_security_login'));}
		
		$today = date('Y-m-d');
		$erreur = 0;
		$em = $this->getDoctrine()->getManager();//echo 'locid'.$locid;
					   
		$client  = $em->getRepository('BaclooUserBundle:User')		
					   ->findOneByUsername($objUser);
					   
		$payment  = $em->getRepository('PaymentBundle:Payment')		
					   ->findOneById($paymentid);			
		$annee = date('Y');
		$pdf = $this->get("white_october.tcpdf")->create();	
		$html = $this->renderView('BaclooCrmBundle:Crm:impression_factureslead.html.twig', array('client' => $client,
																			'annee' => $annee,
																			'payment' => $payment));
		
		$pdf->SetFont('helvetica', '', 9, '', true);
		// set margins
		$pdf->SetMargins(13, '10', '5', '0');
		$pdf->AddPage();
		
		// -- set new background ---

		// get the current page break margin
		$bMargin = $pdf->getBreakMargin();
		// get current auto-page-break mode
		$auto_page_break = $pdf->getAutoPageBreak();
		// disable auto-page-break
		$pdf->SetAutoPageBreak(false, 0);
		// set bacground image
		$img_file = K_PATH_IMAGES.'devistemplate.jpg';
		$pdf->Image($img_file, 0, 0, 210, 297, 'JPG', '', '', false, 300, '', false, false, 0);
		// restore auto-page-break status
		$pdf->SetAutoPageBreak($auto_page_break, $bMargin);
		// set the starting point for the page content
		$pdf->setPageMark();		
		
		$pdf->writeHTML($html, true, false, true, false, '');
		$pdf->lastPage();
 
		$response = new Response($pdf->Output('file.pdf'));
		$response->headers->set('Content-Type', 'application/pdf');
 
		return $response;	
	}
	
}