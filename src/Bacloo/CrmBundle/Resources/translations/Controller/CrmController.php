<?php
namespace Bacloo\CrmBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Httpfoundation\Response;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Validator\Constraints\Email as EmailConstraint;
use Symfony\Component\Form\Extension\Core\ChoiceList\ChoiceList;

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
use Bacloo\UserBundle\Entity\UserRepository;


class CrmController extends Controller
{	
	public function ajouterAction()
	{
		// On cr??e un objet Fiche
		$fiche = new Fiche;
		$userid = $this->get('security.context')->getToken()->GetUser()->getId(); 
		$form = $this->createForm(new FicheType($userid), $fiche);
		$objUser = $this->get('security.context')->getToken()->getUsername(); if(empty($objUser) or !isset($objUser) or $objUser == 'anon.'){return $this->redirect($this->generateUrl('fos_user_security_login'));}
		$today = date('d/m/Y');
		include('societe.php');
		// On r??cup??re la requ??te
		$request = $this->get('request');
		// On v??rifie qu'elle est de type POST
		if ($request->getMethod() == 'POST') 
		{
		// On fait le lien Requ??te <-> Formulaire
		// ?? partir de maintenant, la variable $fiche contient les valeurs entr??es dans le formulaire rempli par le visiteur
		$form->bind($request);
		// On v??rifie que les valeurs entr??es sont correctes

			if ($form->isValid()){ 
				//Avant de persister la fiche, on supprime les collections qui sont enti??rement vides
				foreach ($form->get('event')->getData() as $bee) {
					if(!isset($bee)){
						$fiche->getEvent()->clear();
					}
				}					
					
				foreach ($form->get('bcontacts')->getData() as $bcc) {
					if(!isset($bcc)){
						$fiche->getBcontacts()->clear();
					}				
				}
				
				foreach ($form->get('brappels')->getData() as $brr) {
					if(!isset($brr)){
						$fiche->getBrappels()->clear();
					}
	
				}				
				foreach ($form->get('commandes')->getData() as $bcoco) {
					if(!isset($bcoco)){
						$fiche->getCommandes()->clear();
					}
	
				}
				// On enregistre notre objet $fiche dans la base de donn??es		
				$em = $this->getDoctrine()->getManager();
				$em->persist($fiche);	
				$em->flush();

				//On persiste les rappels
				foreach ($form->get('brappels')->getData() as $br) {
				  $br->addFiche($fiche);
				  if(isset($br)){//echo'llllllllllloooooooo';
					$br->setEntreprise($fiche->GetRaisonSociale());
					$br->setCp($fiche->GetCp());
					$em->persist($br);
				  }
				}

				//On persiste les events
				foreach ($form->get('event')->getData() as $be) {
				  $be->addFiche($fiche);
				  if(isset($be)){
					$be->setEntreprise($fiche->GetRaisonSociale());
					$be->setCp($fiche->GetCp());
					$em->persist($be);
				  }
				}

				//On persiste les contacts
				foreach ($form->get('bcontacts')->getData() as $bc) {
				  $bc->addFiche($fiche);
				  if(isset($bc)){
					$bc->setEntreprise($fiche->GetRaisonSociale());
					$bc->setCp($fiche->GetCp());
					$bc->setUser($objUser);
					$em->persist($bc);
				  }
				}

				//On persiste les commandes
				foreach ($form->get('commandes')->getData() as $bco) {
				  $bco->addFiche($fiche);
				  if(isset($bco)){
				    $bco->setEntreprise($fiche->GetRaisonSociale());
					$bco->setUser($objUser);
					$em->persist($bco);
				  }
				}
				
				// on flush le tout
				$em->flush();	
				
				// On d??finit un message flash sympa
				$this->get('session')->getFlashBag()->add('info', 'Fiche bien ajout??');			
				
				// On redirige vers la page de visualisation de la fiche nouvellement cr????e
				return $this->redirect($this->generateUrl('bacloocrm_voir', array('id' => $fiche->getId())));
			}
		}
		$em = $this->getDoctrine()->getManager();
		$modules  = $em->getRepository('BaclooCrmBundle:Modules')		
					   ->findOneByUsername($objUser);
					   
		return $this->render('BaclooCrmBundle:Crm:ajouter.html.twig', array('form' => $form->createView(),
																			'date' => $today,
																			'usersociete' => $societe,
																			'modules' => $modules,
																			'user' => $objUser));
	}
	
public function voirAction($id, Request $request)
  {
	$objUser = $this->get('security.context')->getToken()->getUsername(); 
	if(empty($objUser) or !isset($objUser) or $objUser == 'anon.')
	{
		return $this->redirect($this->generateUrl('fos_user_security_login'));
	}	

			$session = new Session();
			$session = $request->getSession();

			// d??finit et r??cup??re des attributs de session
			$session->set('idfiche', $id);
			$session->set('init', '1');//on est en recherche
// echo 'view session'.$session->get('view');			
			$vue = $session->get('vue');
			$pid = $session->get('idsearch');
			if($session->get('page') > 0)
			{
				$page = $session->get('page');
			}
			else
			{
				$page = 0;
			}
			$view = $session->get('view');
			$init = $session->get('init');	
	include('societe.php');
	$em = $this->getDoctrine()->getManager();



			
// echo '  d??collage';
	// On r??cup??re l'EntityManager
	$em = $this->getDoctrine()
			   ->getManager();
	// On r??cup??re la fiche qui nous int??resse
				$query = $em->createQuery(
					'SELECT f
					FROM BaclooCrmBundle:Fiche f
					WHERE f.id = :id'
				);
				$query->setParameter('id', $id);	
				
				$fichecheck = $query->getSingleResult();

				////On r??cup??re les favoris niveau ALL
				// $em = $this->getDoctrine()->getManager();
				// $query = $em->createQuery(
						// 'SELECT f.favusername
						// FROM BaclooCrmBundle:Favoris f
						// WHERE f.favusername = :favusername
						// AND f.toutpart = :toutpart'
					// )->setParameter('favusername', $objUser);
					// $query->setParameter('toutpart', 1);
					// $favoriall = $query->getResult();
					////echo 'cbien2 favoriall'.count($favoriall);

				////On cr????e un tableau sous le mod??le 'user'=>$xxxx pour le repository
				// if(isset($favoriall) && !empty($favoriall))
				// {//echo 'liiiiiii';
					// $i = 1;
					// foreach($favoriall as $favo)
					// {
						// foreach($favo as $fav)
						// {
						////echo 'favo'.$fav;
							// $favor  = $em->getRepository('BaclooCrmBundle:Favoris')		
										   // ->findOneByFavusername($objUser);						
							// ${'choix'.$i++} = $favor->getUsername();
						// }
					// }
					////echo 'choix1'.$choix1;
					// $critere = array($objUser);
					
					// for($j=1;$j<$i;$j++)
					// {
						// ${'critere'.$j} = array(${"choix".$j});
						// $critere = array_merge(${'critere'.$j},$critere);
					// }
					
				// }
				// else
				// {
					// $critere = array($objUser);
				// }
				// foreach($critere as $listuser)
				// {
					// if($fichecheck->getUser() == $listuser)
					// {
						// $autorisation = 'ok';
					// }
				// }	
				// if($autorisation == 'ok')
				// {
					// $query = $em->createQuery(
						// 'SELECT f
						// FROM BaclooCrmBundle:Fiche f
						// WHERE f.id = :id'
					// );
					// $query->setParameter('id', $id);	
					
					// $fiche = $query->getSingleResult();
					
					// $statut = 'proprio';
				// }
				// else
				// {
					// $alteruser = $em->getRepository('BaclooCrmBundle:Alteruser')		
					 // ->findByFicheid($id);				
					// foreach($alteruser as $ua) 
					// {
						// if($ua->getUsername() == $objUser)
						// {			
							$query = $em->createQuery(
								'SELECT f
								FROM BaclooCrmBundle:Fiche f
								WHERE f.id = :id'
							);
							$query->setParameter('id', $id);
							
							$fiche = $query->getSingleResult();
							$userdetails  = $em->getRepository('BaclooUserBundle:User')		
										   ->findOneByUsername($objUser);	
							if($userdetails->getUsersociete() != $societe)
							{
								return $this->redirect($this->generateUrl('bacloocrm_search'));
							}							
							// $statut = 'collegue';
						// }
						// else
						// {//echo 'palter';
							// return $this->redirect($this->generateUrl('bacloocrm_search', array()));				
						// }
					// }
				// }
				

				// $originalalteruser = $em->getRepository('BaclooCrmBundle:Alteruser')		
				 // ->findByFicheid($id);
				 // print_r($fiche);
				if(empty($fiche) OR !isset($fiche))
				{
					//echo 'palter2';return $this->redirect($this->generateUrl('bacloocrm_search', array()));
				}
				
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

    // On cr???? le formulaire
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
		//echo '  form valide';
	  
	    $em = $this->getDoctrine()->getManager();
        $em->persist($fiche);
				foreach ($form->get('event')->getData() as $bee) {
					if(!isset($bee) && empty($bee)){
						$fiche->getEvent()->clear();
					}
				}							
					
				foreach ($form->get('bcontacts')->getData() as $bcc) {
					if(!isset($bcc) && empty($bcc)){
						$fiche->getBcontacts()->clear();
					}				
				}
				
				foreach ($form->get('brappels')->getData() as $brr) {
					if(!isset($brr) && empty($brr)){
						$fiche->getBrappels()->clear();
					}
				}

				foreach ($form->get('alteruser')->getData() as $baa) {
					if(!isset($baa) && empty($baa)){
						$fiche->getAlteruser()->clear();
					}
				}

				foreach ($form->get('commandes')->getData() as $bcoco) {
					if(!isset($bcoco) && empty($bcoco)){
						$fiche->getCommandes()->clear();
					}
				}				
				
        $em->flush();
        // --- Comme on a des manytomany imbriqu??s dans le formulaire - 3/3 ---

		
        // on persiste que si brappels pas dans bdd
        foreach ($listeBr as $originalBr) {//echo 'compar brappels';
          foreach ($form->get('brappels')->getData() as $rb) {
			// Si pas de rappel en bdd et rb existe: On persist
			if(empty($originalBr) && !empty($rb)){
			// On persiste les brappels et autres (propri??taire) maintenant que $fiche a un id
					if(isset($br) && !empty($br)){
					  // $br->addFiche($fiche);
					  $em->persist($br);
					}
			}
          }        
        }
		
        // on persiste que si event pas dans bdd
        foreach ($listeBe as $originalBe) {
          foreach ($form->get('event')->getData() as $eb) {
            if(empty($originalBe) && !empty($eb)){
				if(isset($be) && !empty($be)){
				  // $be->addFiche($fiche);
				  $em->persist($be);
				}
			}
          }        
        }		

        // on persiste que si pas dans bdd
        foreach ($listeBc as $originalBc) {
          foreach ($form->get('bcontacts')->getData() as $cb) {
            if(empty($originalBc) && !empty($cb)){
				if(isset($bc) && !empty($bc)){
				  // $bc->addFiche($fiche);
				  	$bc->setEntreprise($fiche->GetRaisonSociale());
				  	$bc->setCp($fiche->GetCp());
					$bc->setUser($objUser);
				  $em->persist($bc);
				}	
            }
          }        
        }		

        // on persiste que si pas dans bdd
        foreach ($listeBco as $originalBco) {
          foreach ($form->get('commandes')->getData() as $cob) {
            if(empty($originalBco) && !empty($cob)){
				if(isset($bco) && !empty($bco)){
				  // $bc->addFiche($fiche);
				  	$bco->setEntreprise($fiche->GetRaisonSociale());
					$bco->setUser($objUser);
				  $em->persist($bco);
				}	
            }
          }        
        }						
				
				
		$z=0;
	if($fiche->getAlteruser())
	{
		foreach ($fiche->getAlteruser() as $ba) {//echo'foreach ba';
			foreach ($form->get('alteruser')->getData() as $ua) {//chaque alteruser envoy?? par le formulaire
// echo 'foreach alter';			//D??but partie contr??le insertion
				if(isset($ua))
				{
					// echo ' ua estset '.$ua->getUsername();		
					//On contr??le alteruser popst?? pas pr??sent en bdd Alter user
					$controlealteruser = $em->getRepository('BaclooCrmBundle:Alteruser')		
					 ->findOneByUsername($ua->getUsername());
					 
					//On regarde s'il fait parti des favoris
					$controlefavori = $em->getRepository('BaclooCrmBundle:Favoris')		
					 ->findOneByfavusername($ua->getUsername());		 

					 //si new alter user pas dans table alteruser mais pas dans favoris
					if(!isset($controlefavori))
					{//echo 'user pas dans favoris';
						// $em->clear($fiche->getAlteruser());
						// $em->remove($fiche->getAlteruser());
						$em->remove($controlealteruser);
						// $em->clear($controlefavori);
					}
					elseif(isset($controlefavori) && !isset($controlealteruser))
					{
						// echo 'user dans  favoris';
						// Partie envoi du mail
						$em = $this->getDoctrine()->getManager();
						$destinataire  = $em->getRepository('BaclooUserBundle:User')		
									   ->findOneByUsername($ua->getUsername());					

						$objUser = $this->get('security.context')->getToken()->getUsername(); 
						if(empty($objUser) or !isset($objUser) or $objUser == 'anon.')
						{
							return $this->redirect($this->generateUrl('fos_user_security_login'));
						}
						$expediteur  = $em->getRepository('BaclooUserBundle:User')		
									   ->findOneByUsername($objUser);						
						// R??cup??ration du service
						$mailer = $this->get('mailer');				
						
							$message = \Swift_Message::newInstance()
								->setSubject($destinataire->getPrenom(). ' : '.$objUser.' a partag?? un de ses prospects qualifi?? avec vous')
								->setFrom(array('bacloo@bacloo.fr' => 'Bacloo CRM'))
								->setTo($destinataire->getEmail())
								->setBody($this->renderView('BaclooCrmBundle:Crm:new_fichepartage.html.twig', array('nom' 		=> $expediteur->getNom(), 
																										 'prenom'	=> $expediteur->getPrenom(),
																										 'societe'	=> $fichecheck->getRaisonSociale(),
																										 'dest_prenom'	=> $destinataire->getPrenom()
																										  )))
							;
							$mailer->send($message);
							
						$mailer = $this->get('mailer');				
						
							$message = \Swift_Message::newInstance()
								->setSubject($destinataire->getPrenom(). ' : '.$objUser.' a partag?? un de ses prospects qualifi?? avec vous')
								->setFrom(array('bacloo@bacloo.fr' => 'Bacloo CRM'))
								->setTo('ringuetjm@gmail.com')
								->setBody($this->renderView('BaclooCrmBundle:Crm:new_fichepartage.html.twig', array('nom' 		=> $expediteur->getNom(), 
																										 'prenom'	=> $expediteur->getPrenom(),
																										 'societe'	=> $fichecheck->getRaisonSociale(),
																										 'dest_prenom'	=> $destinataire->getPrenom()
																										  )))
							;
							$mailer->send($message);
						// Fin partie envoi mail							
					}				
				//Fin partie contr??le insertion	
// $em->flush();
				//D??but Partie suppression
				
			

						// foreach ($form->get('alteruser')->getData() as $ua) 
						// {//echo 'ba'.$ba->getUsername();echo 'ua'.$ua->getUsername();
							// if($ba->getUsername() == $ua->getUsername())
							// {
								// if($ba->getUsername() == $ua->getUsername())
								// {
								// echo'z=1';//pas supprimer
									// $z=1;
								// }
							// }
							// else
							// {
							   // echo'z=0';
														  
								// $em->remove($controlealteruser);	//Ce remove enl??ve l'alteruser de la bdd				
							// }
						
						// }
				//Fin Partie suppression
				// unset($ua);
				}
			

			
			}
					// if(isset($ba)){echo'ba set';
						  // if($z==0)
						  // {echo'z=0';
						// $controlealteruser = $em->getRepository('BaclooCrmBundle:Alteruser')		
						 // ->findOneByUsername($ba->getUsername());							  
							// $em->remove($ba);	//Ce remove enl??ve l'alteruser de la bdd				
						  // }	
						// }else
						// {echo'ba pas set';}
		}
	}
	$controlealteruser = $em->getRepository('BaclooCrmBundle:Alteruser')		
	 ->findOneByFicheid($id);
	// if(isset($controlealteruser))
	// {
		// $em->remove($controlealteruser);
		// echo ' patate to manman';		
 	// }      
       $em->flush();
       $em->clear();


	   
        // --- Fin du cas 3/3 ---
		// nous pr??parons les param??tres pour le formulaire afin de savoir si le formulaire est vide ou pas
			if (isset($bc)){
				$cb=1;
				}
				else{
				$cb=0;	
				}

			if (isset($br)){
				$rb=1;
				}
				else{
				$rb=0;	
				}	
				
			if (isset($be)){
				$eb=1;
				}
				else{
				$eb=0;	
				}
				
			if (isset($ba)){
				$ab=1;
				}
				else{
				$ab=0;	
				}

			if (isset($bco)){
				$cob=1;
				}
				else{
				$cob=0;	
				}

//cr??er table ca avec cols : userid, username, capot, cares, caperdu, date, ficheid				
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
				if($ficheca->getPotentiel() == NULL && $ca->getCapot() != $ficheca->getPotentiel())
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
				{			
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
				
        // On d??finit un message flash
		
		$modules  = $em->getRepository('BaclooCrmBundle:Modules')		
					   ->findOneByUsername($objUser);
        
	  return $this->render('BaclooCrmBundle:Crm:voir.html.twig', array(
      'form'    => $form->createView(),
	  // 'countinter' => $countinter,
	  // 'list_tags' => $list_tags,
	  'id' => $fiche->getId(),
	  'societe' => $fiche->getRaisonSociale(),
	  'usersociete' => $societe,
	  'useracc' => $objUser,
      'fiche' => $fiche,
      'vue' => $vue,
	  'page' => $page,
	  'pid'	=> $pid,
	  'view' => $view,
	  'init' => $init,
	  'date' => $today,
	  'user' => $objUser,
	  'module3activation' => $modules->getModule3activation(),
	  'module5activation' => $modules->getModule5activation(),
	  'module7activation' => $modules->getModule7activation(),
	  'module8activation' => $modules->getModule8activation(),
	  'cb' => $cb,
	  'cob' => $cob,
	  'eb' => $eb,
	  'rb' => $rb,	  
	  'ab' => $ab	  
    )); 
      }
	 } 
	else{
//echo ' pas post la fin';

					

					// foreach($originalalteruser as $oa)
					// {echo 'original ifcheid'.$oa->getFicheid();
						// $newalteruser = $em->getRepository('BaclooCrmBundle:Alteruser')		
						 // ->findOneByFicheid($oa->getFicheid());
						 // if(empty($newalteruser))
						 // {echo 'remove';
							 // $em->remove($oa);
							 // $em->flush();
						 // }
						 // else
						 // {
						 // echo ' idnew'.$newalteruser->getficheId();
						 // echo 'pas vide';
						 // }
					// }
	}
// nous pr??parons les param??tres pour le formulaire afin de savoir si le formulaire est vide ou pas
if (isset($bc)){
	$cb=1;
	}
	else{
	$cb=0;	
	}

if (isset($br)){
	$rb=1;
	}
	else{
	$rb=0;	
	}	
	
if (isset($be)){
	$eb=1;
	}
	else{
	$eb=0;	
	}
	
if (isset($ba)){
	$ab=1;
	}
	else{
	$ab=0;	
	}
	
if (isset($bco)){
	$cob=1;
	}
	else{
	$cob=0;	
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
	


//cr??er table ca avec cols : userid, username, capot, cares, caperdu, date, ficheid				
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
				if($ficheca->getPotentiel() == NULL && $ca->getCapot() != $ficheca->getPotentiel())
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
				{			
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
		
		$modules  = $em->getRepository('BaclooCrmBundle:Modules')		
					   ->findOneByUsername($objUser);
    return $this->render('BaclooCrmBundle:Crm:voir.html.twig', array(
      'form'    => $form->createView(),
	  // 'countinter' => $countinter,
	  // 'list_tags' => $list_tags,
	  'id' => $fiche->getId(),
	  'societe' => $fiche->getRaisonSociale(),
	  'usersociete' => $societe,
	  'useracc' => $objUser,
      'fiche' => $fiche,
      'vue' => $vue,
	  'page' => $page,
	  'pid'	=> $pid,
	  'view' => $view,
	  'init' => $init,
	  'date' => $today,
	  'module3activation' => $modules->getModule3activation(),
	  'module5activation' => $modules->getModule5activation(),
	  'module7activation' => $modules->getModule7activation(),
	  'module8activation' => $modules->getModule8activation(),
	  'user' => $objUser,
	  'modules' => $modules,
	  'cb' => $cb,
	  'cob' => $cob,
	  'eb' => $eb,
	  'rb' => $rb,	  
	  'ab' => $ab	  
    ));
  }
  
 	public function searchAction($page, $view, $init, $vue, $speed, Request $request)
		{//echo 'view init'.$view;
				$page=1;
				$nbparpage = 15;
				set_time_limit(600);
				if(!isset($page) || $page == 0){$page =1;}
				include('societe.php');
				$usersess = $this->get('security.context')->getToken()->getUsername(); if(empty($usersess) or !isset($usersess) or $usersess == 'anon.'){return $this->redirect($this->generateUrl('fos_user_security_login'));}//R??cup??re le nom d'utilisateur
				$em = $this->getDoctrine()->getManager();//echo'usersess'.$usersess;
		// echo 'vue_envoy??e'.$vue;
							   
				$session = $request->getSession();
		// echo 'id   ds sess'.$session->get('id');echo 'init'.$init;
				$vue2 = $session->get('vue');	
				// echo 'vue session'.$vue2;
				// echo 'view session'.$session->get('view');
				$id = $session->get('idsearch');//echo 'ooo'.$id;
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
				}
		//echo 'xxx'.$session->get('idsearch');
				if(isset($vue) && $vue != 'def')
				{
				$session = new Session();//echo 'daaaaaa';
				$session->set('vue', $vue);
				}
				else
				{
				$session = new Session();//echo 'new vue sess';
				$session->set('vue', $vue2);				
				}

				//On r??cup??re les favoris niveau ALL
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

				//On cr????e un tableau sous le mod??le 'user'=>$xxxx pour le repository
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
		// On d??place la v??rification du num??ro de page dans cette m??thode

	
							   
		// echo 'vue33333'.$vue;		
		$user  = $em->getRepository('BaclooUserBundle:User')		
					   ->findOneByUsername($usersess);

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
				if($view != 'search')
				{
					$mesfichestot = $em->getRepository('BaclooCrmBundle:Fiche')
								->searchfiche_init($nbparpage, $page, $critere, $societe);
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
								->searchfiche_init_fournisseur(10, $page, $usersess, $societe);
					if(!isset($mesfiches)){$mesfiches = 'nok';$session->set('id', '0');}
					
				}
				elseif($view == 'corbeille')
				{
					$mesfiches = $em->getRepository('BaclooCrmBundle:Fiche')
								->searchfiche_init_corbeille($nbparpage, $page, $usersess, $societe);
					if(!isset($mesfiches)){$mesfiches = 'nok';$session->set('id', '0');}
					
					$lesfichesss = $mesfiches;
				}	
				elseif($view == 'shared')
				{//echo 'ocooooooooooooooo';
					$mesfiches = $em->getRepository('BaclooCrmBundle:Fiche')
								->searchfiche_init_shared($nbparpage, $page, $usersess, $societe);
					if(!isset($mesfiches)){$mesfiches = 'nok';$session->set('id', '0');}
					
					$lesfichesss = $mesfiches;
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
								->searchfiche_init_fournisseur(10, $page, $usersess, $societe);
					if(!isset($mesfiches)){$mesfiches = 'nok';}
					if($id > 0)
					{
						return $this->redirect($this->generateUrl('bacloocrm_find', array('id' => $id, 'page' => $session->get('page'), 'view' => $session->get('view') )));
					}
					else
					{
						$session->set('id', '0');
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
				$view = 'client';
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

		// Pour r??cup??rer le service UserManager du bundle
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
		
		// On cr??e un objet Search
		$search = new Search;//echo 'eeeeeeeeeeeeeeee';
		$form = $this->createForm(new SearchType(), $search);
		$request = $this->getRequest();
			if ($request->getMethod() == 'POST') {
			  $form->bind($request);
				  if ($form->isValid()) {
					// On Flush la recherche
					$em = $this->getDoctrine()->getManager();
					$em->persist($search);		
					// on flush le tout
					$em->flush();						
					$session = new Session();
					$session = $request->getSession();
					$session->set('page', $page);
					$session->set('view', $view);
					
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
			if($speed == 1)
			{
				return $this->render('BaclooCrmBundle:Crm:search3.html.twig', array('mesfiches' => $mesfiches,
																					'page' => $page,
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
																					'form' => $form->createView()));
			}
			else
			{
			if(!isset($lesfichesss)){$lesfichesss = 0;}//echo 'uiuiuiii';echo $id;
				return $this->render('BaclooCrmBundle:Crm:search.html.twig', array('mesfiches' => $mesfiches,
																					'page' => $page,
																					'user' => $usersess,
																					'modules' => $modules,
																					'mesfichestot' => $mesfichestot,
																					'view' => $view,
																					'vue' => $vue,
																					'speed' => $speed,
																					'tab' => 'tab1',
																					'lesfichesss' => count($lesfichesss),
																					'nombrePage' => ceil(count($lesfichesss)/$nbparpage),
																					'actvise' => $actvise,
																					'activite' => $activite,
																					'tags' => $tags,
																					'form' => $form->createView()));
			}
		} 	
	
		public function search2Action($vue, $speed, $useracc, Request $request)
		{if(!isset($page)){$page =1;}
		$nbparpage = 15;
		include('societe.php');		
		$usersess = $this->get('security.context')->getToken()->getUsername(); if(empty($usersess) or !isset($usersess) or $usersess == 'anon.'){return $this->redirect($this->generateUrl('fos_user_security_login'));}//R??cup??re le nom d'utilisateur
		$em = $this->getDoctrine()->getManager();
		
		$mesfichestot = $em->getRepository('BaclooCrmBundle:Fiche')
					->searchfiche_init($nbparpage, $page, $usersess, $societe);		

		$session = $request->getSession();
		$view = $session->get('view');
		//echo 'lavue'.$view;

		//On r??cup??re les favoris niveau ALL
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

		//On cr????e un tableau sous le mod??le 'user'=>$xxxx pour le repository
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
						->searchfiche_init_fournisseur(10, $page, $usersess, $societe);
			if(!isset($mesfiches)){$mesfiches = 'nok';}
		}
		elseif($view == 'corbeille')
		{
			$mesfiches = $em->getRepository('BaclooCrmBundle:Fiche')
						->searchfiche_init_corbeille($nbparpage, $page, $usersess, $societe);
			if(!isset($mesfiches)){$mesfiches = 'nok';}
			$lesfiches = $mesfiches;
		}	
		elseif($view == 'shared')
		{
			$mesfiches = $em->getRepository('BaclooCrmBundle:Fiche')
						->searchfiche_init_shared($nbparpage, $page, $usersess, $societe);
			if(!isset($mesfiches)){$mesfiches = 'nok';}
			$session->set('id', '0');
			$lesfiches = $mesfiches;
		}
		else
		{
			$typefiche = 'client';
			include('searchprospects.php');
			
			if(!isset($mesfiches)){$mesfiches = 'nok';}
		}
		// On cr??e un objet Search
		$search = new Search;//echo 'ffffffffffffffff';
		$form = $this->createForm(new SearchType(), $search);
		$request = $this->getRequest();
			if ($request->getMethod() == 'POST') {//echo 'persistseach';
			  $form->bind($request);
				  if ($form->isValid()) {
					// On Flush la recherche
					$em = $this->getDoctrine()->getManager();
					$em->persist($search);		
					// on flush le tout
					$em->flush();						
							
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
																						'form' => $form->createView()));			
			}
		}	

// le param??tre de l'action doit se remplir en fonction des crit??res de recherche		
 	public function findAction($id, $page, $view, $speed, Request $request)
		{//echo 'page1'.$page;
		//echo 'lavue1'.$view;
		//echo $id;
		$nbparpage = 15;
		include('societe.php');	
		$usersess = $this->get('security.context')->getToken()->getUsername(); if(empty($usersess) or !isset($usersess) or $usersess == 'anon.'){return $this->redirect($this->generateUrl('fos_user_security_login'));}
			// On r??cup??re l'EntityManager
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
				
					//On r??cup??re les favoris niveau ALL
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

					//On cr????e un tableau sous le mod??le 'user'=>$xxxx pour le repository
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
					$fiche = new Fiche;
					$em = $this->getDoctrine()->getManager();
					$resultats = $em->getRepository('BaclooCrmBundle:Fiche')
								->searchfiche($raisonSociale, $view, $nom, $activite, $besoin, $nbparpage, $page, $societe, $cp, $ville, $cperso1, $cperso2, $cperso3, $memo, $histo, $fonction);
					// echo count($resultats);
					if(isset($resultats))
					{//echo 'set'.$id;
					$session = new Session();
					$session = $request->getSession();
					// $session->remove('idsearch');
					$session->set('page', $page);
					$session->set('view', $view);
					//c'est icic que se d??cide la sessionde ID
					
					$idsearch = $session->get('idsearch');
					// $session->set('id', $idsearch);
					//echo 'id2'.$idsearch.'<<';
					
					
					}else
					{
					$session = new Session();
					$session = $request->getSession();
					$session->set('page', $page);
					$session->set('view', $view);
					$session->set('id', 0);						
						
					}
					$lesfichesss = $resultats;
					 // echo 'id pas 0';echo $view;
				}
				else
				{
					$session = new Session();
					$session = $request->getSession();
					$session->set('page', $page);
					$session->set('view', $view);
					// $session->set('id', $id);					
					//On r??cup??re les favoris niveau ALL
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

					//On cr????e un tableau sous le mod??le 'user'=>$xxxx pour le repository
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
						elseif($view == 'annuaire')
						{//echo ' on est annuaire';
							$typefiche = 'prospect';
							include('searchprospects.php');
							
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
				if(!empty($resultats) && isset($resultats) && $resultats != 'nok')
				{//echo ' esttttttttttttttt ';echo $view;echo count($lesfiches);
					// On cr??e un objet Search
				
				$session = $request->getSession();
				$init = $session->get('init');//echo 'init sess'.$init;
					$search = new Search;
					//echo 'ggggggggggggggggg';echo $request->getMethod();
					$form = $this->createForm(new SearchType(), $search);
					$request = $this->getRequest();
						if ($request->getMethod() == 'POST') {
						  $form->bind($request);
							  if ($form->isValid()) {
								// On Flush la recherche
								$em = $this->getDoctrine()->getManager();
								$em->persist($search);		
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
				$id = $session->get('id');//echo 'iiddddd'.$session->get('id');
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
								'id' => $idsearch,
								'lesfichesss' => count($lesfichesss),
								'nombrePage' => ceil(count($lesfichesss)/$nbparpage),
								'resultats' => $resultats, 
								'actvise' => $actvise,
								'activite' => $activite,
								'tags' => $tags,
								'form' => $form->createView()));
					}
					else
					{			
						return $this->render('BaclooCrmBundle:Crm:search.html.twig', array(
								'id' => $idsearch,
								'search' => $searchsess,
								'page' => $page,
								'user' => $usersess,
								'modules' => $modules,
								'view' => $view,
								'lesfichesss' => count($lesfichesss),
								'vue' => 'rappels',
								'nombrePage' => ceil(count($lesfichesss)/$nbparpage),
								'resultats' => $resultats, // C'est ici tout l'int??r??t : le contr??leur passe les variables n??cessaires au template !
								'tags' => $tags,
								'actvise' => $actvise,
								'activite' => $activite,
								'form' => $form->createView()
						));
					}
					
				}
				else{//echo ' onnnnnnnnnnnnnn ';
					// On cr??e un objet Search
					$search = new Search;
					$form = $this->createForm(new SearchType(), $search);
					$request = $this->getRequest();
						if ($request->getMethod() == 'POST') {
						  $form->bind($request);
							  if ($form->isValid()) {
								// On Flush la recherche
								$em = $this->getDoctrine()->getManager();
								$em->persist($search);		
								// on flush le tout
								$em->flush();
								
								//echo 'lavue4'.$view;
								// On redirige vers la page de visualisation de recherche
								// return $this->redirect($this->generateUrl('bacloocrm_find', array('id' => $search->getFicheid(), 'view' => $view)));
							}
						}
						
					$modules  = $em->getRepository('BaclooCrmBundle:Modules')		
								   ->findOneByUsername($usersess);
					return $this->render('BaclooCrmBundle:Crm:search.html.twig', array('form' => $form->createView(),'tags' => $tags,'actvise' => $actvise, 'activite' => $activite, 'user' => $usersess, 'modules' => $modules, 'view' => $view));			
				}
			
		}

		public function searchrappelsAction($vue, $speed, Request $request){
		$user= $this->get('security.context')->getToken()->getUsername(); if(empty($user) or !isset($user) or $user == 'anon.'){return $this->redirect($this->generateUrl('fos_user_security_login'));}	
		// Avant de lancer une recherche on vide la table rapsearch
		$em = $this->getDoctrine()->getManager();

		$session = $request->getSession();
		$du = $session->get('du');
		$au = $session->get('au');
		$vue = $session->get('vue');//echo 'session vue'.$vue;
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
		//$fiche = new Fiche;	
		$fiche = $em->getRepository('BaclooCrmBundle:Fiche')
		->searchrap($du, $au, 10, $page=1, $user);
		$id = 0;
		$session->set('vue', $vue);		
	}
	elseif($vue == 'a_faire')
	{
		$fiche = $em->getRepository('BaclooCrmBundle:Fiche')
		->searcha_faire($du, $au, 10, $page=1, $user);
		$id = 0;
		$session = new Session();
		$session->set('vue', $vue);
	}
	elseif($vue == 'rdv')
	{
		$fiche = $em->getRepository('BaclooCrmBundle:Fiche')
		->searchrdv($du, $au, 10, $page=1, $user);
		$id = 0;
		$session->set('vue', $vue);		
	}
	elseif($vue == 'all')
	{
		$fiche = $em->getRepository('BaclooCrmBundle:Fiche')
		->searchallrap($du, $au, 10, $page=1, $user);
		$id = 0;
		$session->set('vue', $vue);		
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
					// On redirige vers la page de visualisation de recherche
					//ici l'array doit se constituer en fonction des champs de formulaire remplis
					// $du = $rapsearch->getdu();
					// $au= $rapsearch->getAu();
					$id = $rapsearch->getid();	//echo 'iddddd ='.$id;
					//$em->remove($rapsearch);
							return $this->redirect($this->generateUrl('bacloocrm_showrappels', array('id' => $id, 'vue'=> $vue)
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
																							'fiche' => $fiche, // C'est ici tout l'int??r??t : le contr??leur passe les variables n??cessaires au template !
																							'du' => $du,
																							'modules' => $modules,
																							'au'=> $au,
																							'vue'=> $vue,
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
																							'fiche' => $fiche, // C'est ici tout l'int??r??t : le contr??leur passe les variables n??cessaires au template !
																							'du' => $du,
																							'modules' => $modules,
																							'au'=> $au,
																							'vue'=> $vue,
																							'vue'=> $vue,
																							'p'=> '1',
																							'user' => $user,
																							'useracc' => $user,
																							'form' => $form->createView()
																							));				
				}
				
		}
		
		public function showrappelsAction($page, $id, $vue, Request $request){//echo 'showrap';
			if(!isset($page) || $page == 0){$page =1;}//echo $page;
			$user= $this->get('security.context')->getToken()->getUsername(); if(empty($user) or !isset($user) or $user == 'anon.'){return $this->redirect($this->generateUrl('fos_user_security_login'));}	
			$em = $this->getDoctrine()->getManager();
			$useracc = $user;
			$session = $request->getSession();
			$du = $session->get('du');
			$au = $session->get('au');
			$vue = $session->get('vue');
			$viewb = $session->get('view');//echo 'viewb'.$viewb;
			if(isset($viewb))
			{
				$view = $viewb;
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
									->searchrap($du, $au, 10, $page, $user);
				}
				else{//echo 'rech';
				// echo $id;
						$em = $this->getDoctrine()->getManager();
						$rapsearch = $em->getRepository('BaclooCrmBundle:Rapsearch')->find($id);
						$du = $rapsearch->getDu();
						$au = $rapsearch->getAu();
						$fiche = new Fiche;				
						$resultrap = $em->getRepository('BaclooCrmBundle:Fiche')
									->searchrap($du, $au, 10, $page, $user);				
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
									->searcha_faire($du, $au, 10, $page, $user);
				}
				else{//echo 'rech';
				// echo $id;
						$em = $this->getDoctrine()->getManager();
						$rapsearch = $em->getRepository('BaclooCrmBundle:Rapsearch')->find($id);
						$du = $rapsearch->getDu();
						$au = $rapsearch->getAu();
						$fiche = new Fiche;				
						$resultrap = $em->getRepository('BaclooCrmBundle:Fiche')
									->searcha_faire($du, $au, 10, $page, $user);				
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
									->searchrdv($du, $au, 10, $page, $user);
				}
				else{//echo 'rech';
				// echo $id;
						$em = $this->getDoctrine()->getManager();
						$rapsearch = $em->getRepository('BaclooCrmBundle:Rapsearch')->find($id);
						$du = $rapsearch->getDu();
						$au = $rapsearch->getAu();
						$fiche = new Fiche;				
						$resultrap = $em->getRepository('BaclooCrmBundle:Fiche')
									->searchrdv($du, $au, 10, $page, $user);				
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
									->searchallrap($du, $au, 10, $page, $user);
				}
				else{//echo 'rech';
				// echo $id;
						$em = $this->getDoctrine()->getManager();
						$rapsearch = $em->getRepository('BaclooCrmBundle:Rapsearch')->find($id);
						$du = $rapsearch->getDu();
						$au = $rapsearch->getAu();
						$fiche = new Fiche;				
						$resultrap = $em->getRepository('BaclooCrmBundle:Fiche')
									->searchallrap($du, $au, 10, $page, $user);				
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
						  if ($form->isValid()) {
						// On Flush la recherche
						$em = $this->getDoctrine()->getManager();
						$em->persist($rapsearch);		
						// on flush le tout
						$em->flush();						
						// On d??finit un message flash sympa
						$this->get('session')->getFlashBag()->add('info', 'votre recherche a ??t?? soumise');								
						// On redirige vers la page de visualisation de recherche
						//ici l'array doit se constituer en fonction des champs de formulaire remplis
						$du = $rapsearch->getdu();
						$au= $rapsearch->getAu();
						$id= $rapsearch->getid();					

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
						'useracc' => $useracc,
						'modules' => $modules,
						'page' => $page,
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
							->searchrap($du, $au, 10, $page, $user);
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
						'nombrePage' => ceil(count($resultrap)/10),							
						'fiche' => $fiche,
						'useracc' => $useracc,
						'modules' => $modules,
						'id' => $id,
						'vue' => $vue,
						'form' => $form->createView()
					));		
			}
		}
		//Compte les prospects potentiel dans le bandeau du haut
		public function showprospotAction($mode, Request $request)
		{
			$usersess = $this->get('security.context')->getToken()->getUsername();//R??cup??re le nom d'utilisateur
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
		
		public function showprospotlistAction($page, $nbresult, $insert, Request $request)
		{
			$usersess = $this->get('security.context')->getToken()->getUsername(); if(empty($usersess) or !isset($usersess) or $usersess == 'anon.'){return $this->redirect($this->generateUrl('fos_user_security_login'));}//R??cup??re le nom d'utilisateur	
			$nbparpage = 20;

			if($this->getRequest()->request->get('pagination') > 0)
			{
				$page = $this->getRequest()->request->get('pagination');
				// echo 'la page2'.$page;
			}
			$em = $this->getDoctrine()->getManager();
			$userdetails  = $em->getRepository('BaclooUserBundle:User')		
						   ->findOneByUsername($usersess);

				//On r??cup??re l'id de l'utilisateur connect??
			$uid = $userdetails->getId();
			// echo $request->getMethod();
			if($insert == 'nok')
			{ //echo 'insert nok';				
			$prospota = $em->getRepository('BaclooCrmBundle:Prospects')
							->findOneByUserid($uid);					
				
			// On cr???? le formulaire	
			$form = $this->createForm(new ProspectsType(), $prospota);
			// on soumet la requete
			$request = $this->getRequest();

				if ($this->getRequest()->request->get('masquer') == 'Masquer la s??lection')
				{
					if ($request->getMethod() == 'POST') {//echo 'POST';
					// On fait le lien Requ??te <-> Formulaire
					  $form->bind($request);
					  if ($form->isValid()) 
					  {//echo 'form valide';			  
							// if(!empty($form)){echo'plein';}else{echo'vide';}
							//on rend invisible les prospots qui ont ??t?? suppr
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
								// On enregistre les prospects en base de donn??e afin d'avoir son id
								return $this->redirect($this->generateUrl('bacloocrm_showprospotlist', array('nbresult' => $nbresult, 'page' => $page, 'insert' => 'nok')));						
						}
					}
					return $this->redirect($this->generateUrl('bacloocrm_showprospotlist', array('nbresult' => $nbresult, 'page' => $page, 'insert' => 'nok')));
				}
				elseif ($this->getRequest()->request->get('pagination') == $page)
				{
					if ($request->getMethod() == 'POST')
					{//echo 'POST';
					// On fait le lien Requ??te <-> Formulaire
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
				//On r??cup??re le nombre de prospects de ce user
				$prospinit  = $em->getRepository('BaclooCrmBundle:Prospot')		
								 ->findByUser($usersess);
				$nbprospotinit = count($prospinit);

				$tabact = array('',',',' de',' du',' avec',' dans',' pour',' des',' les', ' et', ' ??', ' au', '&', ' en', 'd\'');
				$tabact2 = str_replace($tabact, '', $userdetails->getTags());
				$splitby = array('',',');
				$text    = $tabact2;
				$pattern = '/\s'.implode($splitby, '\s?|\s?').'\s?/';
				$tagsu   = preg_split($pattern, $text, -1, PREG_SPLIT_NO_EMPTY);

				//On r??cup??re les activit??s vis??es de l'utilisateur
				$actvise   = $userdetails->getActvise();
				$activisse = str_replace(", ", ",", $actvise);
				$actv	   = explode(",", $activisse);
				
				function str_to_noaccent($str)
				{
					$url = $str;
					$url = preg_replace('#??#', 'C', $url);
					$url = preg_replace('#??#', 'c', $url);
					$url = preg_replace('#??|??|??|??#', 'e', $url);
					$url = preg_replace('#??|??|??|??#', 'E', $url);
					$url = preg_replace('#??|??|??|??|??|??#', 'a', $url);
					$url = preg_replace('#@|??|??|??|??|??|??#', 'A', $url);
					$url = preg_replace('#??|??|??|??#', 'i', $url);
					$url = preg_replace('#??|??|??|??#', 'I', $url);
					$url = preg_replace('#??|??|??|??|??|??#', 'o', $url);
					$url = preg_replace('#??|??|??|??|??#', 'O', $url);
					$url = preg_replace('#??|??|??|??#', 'u', $url);
					$url = preg_replace('#??|??|??|??#', 'U', $url);
					$url = preg_replace('#??|??#', 'y', $url);
					$url = preg_replace('#??#', 'Y', $url);
					 
					return ($url);
				}


				//DEBUT MENAGE TABLE PROSPOT au cas ou le user a modif/suppr ses tags ou actvise
				//!!!!!Verifier s'il y a des occurences des mots cl??s actuels dans les prospo et virer tous les 
				//prospo qui n'ont pas d'occurence. Pour ce faire exploser les mots cl??s comme dnas la recherche de prospot dans fiche
				// et ?? chaque it??ration faire le remove.
				
				if(empty($tagsu) && empty($actvise))//Si le user n'a pas de tags et d'activit??s vis??es
				{
					// echo 'tagsu vide';
					//On la vire des fiches vendables
		
					//On le vire des interresses
					$listintfiche2  = $em->getRepository('BaclooCrmBundle:interresses')		
								   ->findByUsername($usersess);
					foreach($listintfiche2 as $list2)
					{
						$em->remove($list2);
						$em->flush();
					}
					//On la vire des fiches prospot 
					$listintfiche3  = $em->getRepository('BaclooCrmBundle:Prospot')		
								   ->findByUser($usersess);
								   
					foreach($listintfiche3 as $list3)
					{
						$em->remove($list3);
						$em->flush();
					}
				}
				else // S'il a des tags OU des activit??s vis??es : on vire les prospot qui n'ont plus de correspondance
				{
					// echo 'tagsu pas vide';
					//On fait la m??me pour chacun des tags					
					foreach($prospinit as $prospi)
					{
						$p = 0;
						foreach($tagsu as $tags)
						{
							// echo $tags; echo ' vs '.$prospi->getBesoins();
							if(stristr(str_to_noaccent($prospi->getBesoins()), str_to_noaccent($tags)))//si la chaine de caract??re commence pas le tag
							{
								$p = 1;
							}							
						}
						foreach($actv as $act)
						{
							// echo $act; echo ' vs '.$prospi->getActivite();
							if(stristr(str_to_noaccent($prospi->getActivite()), str_to_noaccent($act)))//si la chaine de caract??re commence pas le tag
							{
								$p = 1;
							}							
						}
						//echo' p= '.$p;
						if($p == 0)//Si aucun prosppot ne correspond aux tags de l'utilisateur
						{//echo 'suppr';
								$em->remove($prospi);
								$em->flush();
						}
					}
				}
				// FIN DU MENAGE
													
				//D??but ajout des prospects	
				set_time_limit(300);
				// if(empty($tagsu)){echo 'yagsu vide';}else{echo 'tagsu plein';}			
				// if(!isset($actvise)){echo 'actv vide';}else{echo 'actv plein';}		
					if(empty($tagsu) && empty($actvise)){
						$fiche = 0;//si pas de tags alors pas de prospects
					}
					else //s'il a des tags ou des actvises => on ins??re
					{
						//On r??cup??re l'array avec  les prospot
						// echo 't la';
						// var_dump($tagsu);
						// var_dump($actv);
						//$em->clear();
						$fiche = $em->getRepository('BaclooCrmBundle:Fiche')
									->prospotlist($tagsu, $actv, $usersess);// on obtient la liste des prospects


						//$fiche = array_slice($fiches, $limitebasse, $nbparpage);//echo 'nbslice'.count($fiche);
					}						

					//On regarde si l'utilisateur connect?? est d??ja entegistr?? dnas la table prospects
					$em2 = $this->getDoctrine()
							   ->getManager()
							   ->getRepository('BaclooCrmBundle:Prospects');
					$prospects = $em2->findOneByUserid($uid);
					
					//On r??cup??re les anciens prospot propos??s ?? l'utilisateur connect??
					$em = $this->getDoctrine()
							   ->getManager()
							   ->getRepository('BaclooCrmBundle:Prospot');
					$prospotaa = $em->findByUser($usersess);	
		
				if(empty($prospects))//Si utilisateur pas enregistr?? dans prospect on l'ins??re
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
				//pour chaque prospect propos??, on regarde s'il a d??j?? ??t?? propos??
			if(isset($fiche) && !empty($fiche))
			{				
				foreach($fiche as $fic)// pour chaque fiche trouv??e
				{				
						if(isset($prospotaa) && !empty($prospotaa))// Si des prospects lui ont deja ??t?? propos??s on compare aux nouveaux avant d'ajouter
						{
							//on cherche prospect bdd qui correspond a prospect trouv??
							$em = $this->getDoctrine()
								   ->getManager()
								   ->getRepository('BaclooCrmBundle:Prospot');
							$prospotok = $em->findOneBy(array('RaisonSociale' => $fic->GetRaisonSociale(), 'user' => $usersess));// y a t il des prospot qui ont deja cette raison sociale ?					

							$em = $this->getDoctrine()
									   ->getManager();		
							$query = $em->createQuery(
								'SELECT u.email
								FROM BaclooUserBundle:User u
								WHERE u.username = :username'
							)->setParameter('username', $fic->GetUser());
							$mail = $query->getSingleScalarResult();
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
								$prospot->setDescbesoins($fic->GetDescbesoins());
								$prospot->setVemail($mail);										
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
							elseif(!empty($prospotok)) // si nouveau prospect d??j?? dans prospot mais user dans table prospects
							{
								if($fic->getTags() != $prospotok->getBesoins())// Si les besoins  ont ??t?? mis ?? jour
								{
									$prospotok->setBesoins($fic->getTags());
									$prospotok->setVoir(false);
									$prospotok->setMasquer(0);
								}										
								elseif($fic->getActivite() != $prospotok->getActivite())// Si les activit??s  ont ??t?? mises ?? jour
								{
									$prospotok->setActivite($fic->getActivite());
									$prospotok->setVoir(false);
									$prospotok->setMasquer(0);
								}										
								elseif($fic->getAVendre() != $prospotok->getAvendre())// Si statut ?? vendre a chang??
								{
									$prospotok->setAvendre($fic->getAvendre());
									$prospotok->setPrixsscont($fic->getPrixsscont());
									$prospotok->setVoir(false);
									$prospotok->setMasquer(0);
								}										
								elseif($fic->getAVendrec() != $prospotok->getAvendrec())// Si statut ?? vendre a chang??
								{
									$prospotok->setAvendrec($fic->getAvendrec());
									$prospotok->setPrixavcont($fic->getPrixavcont());
									$prospotok->setVoir(false);
									$prospotok->setMasquer(0);
								}
								elseif($fic->getPrixsscont() != $prospotok->getPrixsscont())// Si prix sans contact a chang??
								{
									$prospotok->setPrixsscont($fic->getPrixsscont());
									$prospotok->setVoir(false);
									$prospotok->setMasquer(0);
								}
								elseif($fic->getPrixavcont() != $prospotok->getPrixavcont())// Si prix avec contact a chang??
								{
									$prospotok->setPrixavcont($fic->getPrixavcont());
									$prospotok->setVoir(false);
									$prospotok->setMasquer(0);
								}
								$em->flush();
							}
						}
						else //Si aucun prospect ne lui a ??t?? propos?? pr??c??demment cad qu'on ne trouve l'utilisateur ni dans prospects, ni dans prospot
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
								$query = $em->createQuery(
									'SELECT u.email
									FROM BaclooUserBundle:User u
									WHERE u.username = :username'
								)->setParameter('username', $fic->GetUser());
								$mail = $query->getSingleScalarResult();
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
									$prospot->setDescbesoins($fic->GetDescbesoins());
									$prospot->setVemail($mail);
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
			//On r??cup??re l'entite Prospects avec sa colection Prospot
			


			
			$em = $this->getDoctrine()
					   ->getManager()
					   ->getRepository('BaclooCrmBundle:Prospot');
			$prospotaa = $em->findBy(array(
										'user'=>$usersess,
										'voir'=>0));				
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
			// echo 'nbpage'.$nombrePage;
			$form = $this->createForm(new ProspectsType(), $prospota);
			$limitebasse = ($nbparpage*$page)-$nbparpage;//echo 'limitebasse'.$limitebasse;
			$limitehaute = ($nbparpage*$page)+1;//echo 'limitehaute'.$limitehaute;			
					return $this->render('BaclooCrmBundle:Crm:opportunity_list.html.twig', array(
											'form'    => $form->createView(),
											'nbresultats'	  => $nbresult,									
											'limitebasse'	  => $limitebasse,
											'limitehaute'	  => $limitehaute,
											'nombrePage' 	  => $nombrePage,
											'page'	  	 	  => $page,								
											));		

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
		
				$raisonsociale = $query->getSingleScalarResult();//compte des users interress?? par cettee fiche				

				$query = $em->createQuery(
					'SELECT i
					FROM BaclooCrmBundle:interresses i
					WHERE i.ficheid = :ficheid'
				);
				$query->setParameter('ficheid', $id);
		
				$listint = $query->getResult();//compte des users interress?? par cettee fiche				

					return $this->render('BaclooCrmBundle:Crm:interresses_list.html.twig', array(
									'listint'    => $listint,
									'id'			=> $id,
									'raisonsociale'	=> $raisonsociale
									));					
	}	
	
	public function listficheintAction()
	{
		$usersess = $this->get('security.context')->getToken()->getUsername(); if(empty($usersess) or !isset($usersess) or $usersess == 'anon.'){return $this->redirect($this->generateUrl('fos_user_security_login'));}//R??cup??re le nom d'utilisateur	
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
			// On fait le lien Requ??te <-> Formulaire
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
				// R??cup??ration du service
				$mailer = $this->get('mailer');				
				
					$message = \Swift_Message::newInstance()
						->setSubject('Bacloo : Un nouveau message est arriv??')
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
						->setSubject('Bacloo : Un nouveau message est arriv??')
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
			// On fait le lien Requ??te <-> Formulaire
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
				// R??cup??ration du service
				$mailer = $this->get('mailer');				
				
					$message = \Swift_Message::newInstance()
						->setSubject('Bacloo : Un nouveau message est arriv??')
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
						->setSubject('Bacloo : Un nouveau message est arriv??')
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
			// On fait le lien Requ??te <-> Formulaire
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
				// R??cup??ration du service
				$mailer = $this->get('mailer');				
				
					$message = \Swift_Message::newInstance()
						->setSubject('Bacloo : Un nouveau message est arriv??')
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
						->setSubject('Bacloo : Un nouveau message est arriv??')
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
	{
		//On r??cup??re les cr??dits de l'achteur
		$user= $this->get('security.context')->getToken()->getUsername(); if(empty($user) or !isset($user) or $user == 'anon.'){return $this->redirect($this->generateUrl('fos_user_security_login'));}		
		$em = $this->getDoctrine()->getManager();	
		$query = $em->createQuery(
			'SELECT u.credits
			FROM BaclooUserBundle:User u
			WHERE u.username LIKE :username'
		);
		$query->setParameter('username', $user);				
		$credits = $query->getSingleScalarResult();

		//On r??cup??re les cr??dits du vendeur
		$query = $em->createQuery(
			'SELECT u.credits
			FROM BaclooUserBundle:User u
			WHERE u.username LIKE :username'
		);
		$query->setParameter('username', $vendeur);				
		$creditsv = $query->getSingleScalarResult();	
		
		//On r??cup??re les d??tails de la fiche vendue
		$fiche  = $em->getRepository('BaclooCrmBundle:Fiche')		
					   ->find($ficheid);

		//On r??cup??re l'id du vendeur			   
		$query = $em->createQuery(
			'SELECT u.id
			FROM BaclooUserBundle:User u
			WHERE u.username LIKE :username'
		);
		$query->setParameter('username', $fiche->getUser());				
		$vendeurid = $query->getSingleScalarResult();					   
		
		//On r??cup??re les d??tails de la fiche vendue dasn prospot
		$prospot  = $em->getRepository('BaclooCrmBundle:Prospot')		
					   ->findOneByFicheid($ficheid);

		//Si les cr??dits de l'acheteur sont inf??rieurs au prix d'achat
		//on retourne message cr??dits insufisants
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
				
			//Si les cr??dits sont suffisants ont valide la transaction
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
				//D??but clonage
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
					// On r??cup??re la fiche qui nous int??resse
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
					$transaction = new Transaction();
					$transaction->setRaisonSociale($fiche->GetRaisonSociale());
					$transaction->setVendeur($fiche->GetUser());
					$transaction->setAcheteur($user);
					$transaction->setDate($today);
					if($typev == 'ssc'){$type = 'Sans des contacts';$transaction->setPrix($fiche->getPrixsscont());}else{$type = 'Avec les contacts';$transaction->setPrix($fiche->getPrixavcont());}
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

					$destinataire  = $em->getRepository('BaclooUserBundle:User')		
								   ->findOneByUsername($fiche->GetUser());
					// Partie envoi du mail
					// R??cup??ration du service
					$mailer = $this->get('mailer');				
					
					$message = \Swift_Message::newInstance()
						->setSubject('Bacloo : Vous avez effectu?? une vente')
						->setFrom(array('bacloo@bacloo.fr' => 'Bacloo CRM'))
						->setTo($destinataire->getEmail())
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
			// On fait le lien Requ??te <-> Formulaire
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
			// On fait le lien Requ??te <-> Formulaire
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
		
				$lisachatsc = $query->getResult();//compte des users interress??s par cettee fiche
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
			// Les donn??es sont un tableau avec les cl??s "name", "email", et "message"
			$data = $form->getData();
				// Partie envoi du mail
				// R??cup??ration du service
				$mailer = $this->get('mailer');				
				
					$message = \Swift_Message::newInstance()
						->setSubject('Bacloo : Message re??u du formulaire de contact')
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
			// Les donn??es sont un tableau avec les cl??s "name", "email", et "message"
			$data = $form->getData();
				// Partie envoi du mail
				// R??cup??ration du service
				$mailer = $this->get('mailer');				
				
					$message = \Swift_Message::newInstance()
						->setSubject('Bacloo : Message re??u du formulaire de contact')
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
			return $this->render('BaclooCrmBundle:Crm:store.html.twig');		
	}

//Recherche de Prospects	
 	public function searchbaclooAction($mode)
	{	
		$page=1;
		if(!isset($page) || $page == 0){$page =1;}
		$usersess = $this->get('security.context')->getToken()->getUsername(); if(empty($usersess) or !isset($usersess) or $usersess == 'anon.'){return $this->redirect($this->generateUrl('fos_user_security_login'));}//R??cup??re le nom d'utilisateur
		$em = $this->getDoctrine()->getManager();	

		// echo 'on efface';
		//On r??initialise la recherche
		$em = $this->getDoctrine()
				   ->getManager()
				   ->getRepository('BaclooCrmBundle:Prospotbacloo');
		$prospotaa = $em->findByUser($usersess);			

		// Si des prospotbacloo lui ont deja ??t?? propos??s on supprime avant d'ajouter
		$em = $this->getDoctrine()->getManager();
		if(isset($prospotaa) && !empty($prospotaa))
		{//echo '3';
			foreach($prospotaa as $prosp)
			{
				$em->remove($prosp);//echo '4';
				$em->flush();
			}
		}		
		
		// On cr??e un objet Search
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

// le param??tre de l'action doit se remplir en fonction des crit??res de recherche		
 	public function findbaclooAction($id, $mode, $page, $toc, $insert, Request $request)
	{
		//echo 'find';echo 'mode'.$mode;echo 'letoc'.$this->getRequest()->request->get('pagination');
		
		//$toc = 1, signifie que pagination = page : on a cliqu?? sur un bouton  de pagination
		//$insert signifie qu'on a juste cliqu?? sur tout cocher ou tout d??cocher
		//$find pour indiquer que nous avons d??j?? fait l'ajout dans la fonction find

		$usersess = $this->get('security.context')->getToken()->getUsername(); if(empty($usersess) or !isset($usersess) or $usersess == 'anon.'){return $this->redirect($this->generateUrl('fos_user_security_login'));}
		// On r??cup??re l'EntityManager
		$em = $this->getDoctrine()->getManager();
		// On r??cupere l'id de la recherche	puis les param??tres dela recherche   
		$search = $em->getRepository('BaclooCrmBundle:Search')->find($id);
		$besoin = $search->getBesoins();
		$activite = $search->getRaisonSociale();
		$departement = $search->getNom();		
		// On r??cupere l'id de la recherche	puis les param??tres dela recherche   
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
		// Dans le cas ou le formulaire a ??t?? post??
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
		//$toc = 1, signifie que pagination = page : on a cliqu?? sur un bouton  de pagination
		//$insert signifie qu'on a juste cliqu?? sur tout cocher ou tout d??cocher
		//$find pour indiquer que nous avons d??j?? fait l'ajout dans la fonction find
		
		$usersess = $this->get('security.context')->getToken()->getUsername(); if(empty($usersess) or !isset($usersess) or $usersess == 'anon.'){return $this->redirect($this->generateUrl('fos_user_security_login'));}//R??cup??re le nom d'utilisateur
		//echo 'la page'.$page;
		$nbparpage = 20;
		set_time_limit(300);//Pour augmenter le temps d'ex??cution des grosses requ??tes
		
		//Si c'est le bouton pagination qui a ??t?? cliqu?? ?????????
		if($this->getRequest()->request->get('pagination') > 0)
		{
			$page = $this->getRequest()->request->get('pagination');
			// echo 'la page2'.$page;
		}

		$em = $this->getDoctrine()->getManager();
		//echo 'id'.$id;
		// on r??cup??re la recherche
		$search = $em->getRepository('BaclooCrmBundle:Search')->find($id);
		$besoin = $search->getBesoins();
		$activite = $search->getRaisonSociale();
		$departement = $search->getNom();
		//$usersess = 'jmr';				
		//$fiche = new Fiche;
		//echo 'besoin1'.$besoin;echo 'activite1'.$activite;echo 'departement1'.$departement;
		//On r??cup??re les fiches bacloo qui correspondent ?? la recherche	

		//On r??cup??re l'id de l'utilisateur connect??
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

			if(empty($prospota2))//Si utilisateur pas enregistr?? dans prospect
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
		// On cr???? le formulaire	
		$form = $this->createForm(new ProspectsbaclooType(), $prospota2);
		// on soumet la requete
		$request = $this->getRequest();
		
		// Si c'est le bouton acheter qui a ??t?? appuy??	
		if ($this->getRequest()->request->get('acheter') == 'Acheter')
		{
			//echo 'acheter';
			$previous = $this->get('request')->server->get('HTTP_REFERER');
			if($request->getMethod() == 'POST') 
			{//echo '6';
			// On fait le lien Requ??te <-> Formulaire	
				
				$form->bind($request);//echo $form->isValid();
				if ($form->isValid()) 
				{//echo '7';		  

			  
				// ICI ON COMMENCE L'OPERATION BUYFICHE AVEC LA BOUCLE
				//On r??cup??re les cr??dits de l'acheteur
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
						//On r??cup??re les d??tails des fiches vendues
						$fiche  = $em->getRepository('BaclooCrmBundle:Fiche')		
									   ->find($ficheid);
						//echo 'ici';			   
						//On r??cup??re les cr??dits du vendeur
						$query = $em->createQuery(
							'SELECT u.credits
							FROM BaclooUserBundle:User u
							WHERE u.username LIKE :username'
						);
						$query->setParameter('username', $fiche->getUser());				
						$creditsv = $query->getSingleScalarResult();

						//On r??cup??re l'id du vendeur			   
						$query = $em->createQuery(
							'SELECT u.id
							FROM BaclooUserBundle:User u
							WHERE u.username LIKE :username'
						);
						$query->setParameter('username', $fiche->getUser());				
						$vendeurid = $query->getSingleScalarResult();
						
						//On r??cup??re les d??tails de la fiche vendue dasn prospot
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
								//D??but clonage
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
								// On r??cup??re la fiche qui nous int??resse
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
								// R??cup??ration du service
								$mailer = $this->get('mailer');				
								
								$message = \Swift_Message::newInstance()
									->setSubject('Bacloo : Vous avez effectu?? une vente')
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
									->setSubject('Bacloo : Vous avez effectu?? une vente')
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
		elseif ($this->getRequest()->request->get('pagination') == $page || $this->getRequest()->request->get('pagination') == 'Tout cocher' || $this->getRequest()->request->get('pagination') == 'Tout d??cocher' || $toc == 1)
		{
			//echo 'pagination'.$request->getMethod();echo $this->getRequest()->request->get('pagination');
			//echo ' toc2'.$toc.'insert2'.$insert;
			// 1. Un bouton de pagination a ??t?? appuy??, on update les donn??es de la page pr??c??dente dans la table
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
						// On r??cup??re Prospectsbacloo
						// $em2 = $this->getDoctrine()
								   // ->getManager()
								   // ->getRepository('BaclooCrmBundle:Prospectsbacloo');
						// $prospota2 = $em2->findOneByUserid($uid);

						// On r??cup??re ProspotBacloo
						$em3 = $this->getDoctrine()
								   ->getManager()
								   ->getRepository('BaclooCrmBundle:Prospotbacloo');
						$prospo2 = $em3->findOneByRaisonSociale($pr->getRaisonsociale());
						
						// echo 'ph1'.$prospo2->getAcheter();
						// echo 'ph2'.$pr->getAcheter();
						
						//Si tout cocher ou tout d??cocher a ??t?? cliqu??

						$prospo2->setAcheter($pr->getAcheter());
						$insert = 'ok';//echo 'toc=null';

							$em->flush();
							
							//Comme cette condition est r??alis??e on ne fait pas d'insertion
							

					// echo 'lolorrrr';
					// 2. On r??cup??re les donn??es de la page suivante pour les affich??es
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
					else // S'il ne s'agit pas de tout cocher ou tout d??cocher alors $insert = nok
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
						//S'il y a des fiches correspondantes ?? la recherche
						if(!empty($fiche ))
						{
							// echo 'pas empty result';
							//D??but ajout des resultats dans la table prospotbacloo
							//echo 'countfiche1'.count($fiche);	
							//On r??cup??re l'id de l'utilisateur connect??
							$query = $em->createQuery(
								'SELECT u.id
								FROM BaclooUserBundle:User u
								WHERE u.username = :username'
							)->setParameter('username', $usersess);
							$uid = $query->getSingleScalarResult();	

							//On regarde si l'utilisateur connect?? est d??ja entegistr?? dans la table prospects
							$em2 = $this->getDoctrine()
									   ->getManager()
									   ->getRepository('BaclooCrmBundle:Prospectsbacloo');
							$prospectsbacloo = $em2->findOneByUserid($uid);

							$em2 = $this->getDoctrine()
									   ->getManager()
									   ->getRepository('BaclooCrmBundle:Prospotbacloo');
							$prospotbacloo = $em2->findByUser($usersess);
							$countprospotbacloo = count($prospotbacloo);

							// si le nombre de prospot est inf??rieur au nombre de r??sultats on ins??re
							if(count($fiche)> $countprospotbacloo)
							{
								//S'il n'y a pas encore de prospot dans la table prosppotbacloo
								$i=0;
								// Pour chaque fiche trouv??e on l'ins??re dans la table prospot
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
										
										//Permet de bloquer la r??insertion ?? la fin de showbacloolist.
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
	//S'il y a des fiches correspondantes ?? la recherche
	//if($this->getRequest()->request->get('pagination') == ''){echo '??galit??';}else{echo'pas ??galit??';}echo'findzzzzzzzzz'.$find.'insert'.$insert;

	if(!empty($fiche))
	{
		// echo 'pas empty result';
		//D??but ajout des resultats dans la table prospotbacloo
		//echo 'countfiche1'.count($fiche);	
		//On r??cup??re l'id de l'utilisateur connect??
		$query = $em->createQuery(
			'SELECT u.id
			FROM BaclooUserBundle:User u
			WHERE u.username = :username'
		)->setParameter('username', $usersess);
		$uid = $query->getSingleScalarResult();	

		//On regarde si l'utilisateur connect?? est d??ja entegistr?? dans la table prospects
		$em2 = $this->getDoctrine()
				   ->getManager()
				   ->getRepository('BaclooCrmBundle:Prospectsbacloo');
		$prospectsbacloo = $em2->findOneByUserid($uid);

		$em2 = $this->getDoctrine()
				   ->getManager()
				   ->getRepository('BaclooCrmBundle:Prospotbacloo');
		$prospotbacloo = $em2->findByUser($usersess);
		$countprospotbacloo = count($prospotbacloo);

		// si le nombre de prospot est inf??rieur au nombre de r??sultats on ins??re
		if(count($fiche)> $countprospotbacloo)
		{
			//S'il n'y a pas encore de prospot dans la table prosppotbacloo
			$i=0;
			// Pour chaque fiche trouv??e on l'ins??re dans la table prospot
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

					$find = 'ok';//Permet de bloquer la r??insertion ?? la fin de showbacloolist.
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
		// On cr???? le formulaire	
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
		$usersess = $this->get('security.context')->getToken()->getUsername(); if(empty($usersess) or !isset($usersess) or $usersess == 'anon.'){return $this->redirect($this->generateUrl('fos_user_security_login'));}//R??cup??re le nom d'utilisateur
		$em = $this->getDoctrine()->getManager();
		
		//On met l'anti refresh ?? 
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
	
		
		// On cr??e un objet Search
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
			// On r??cup??re l'EntityManager
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
				// On cr??e un objet Search
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
				// On cr??e un objet Search
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
		$usersess = $this->get('security.context')->getToken()->getUsername(); if(empty($usersess) or !isset($usersess) or $usersess == 'anon.'){return $this->redirect($this->generateUrl('fos_user_security_login'));}//R??cup??re le nom d'utilisateur			
		//D??but ajout des favoris				
		$previous = $this->get('request')->server->get('HTTP_REFERER');		
					
					//On r??cup??re l'id de l'utilisateur connect??
					$em = $this->getDoctrine()->getManager();
					$query = $em->createQuery(
						'SELECT u
						FROM BaclooUserBundle:User u
						WHERE u.username = :username'
					)->setParameter('username', $usersess);
					$user = $query->getSingleResult();	

					//On regarde si l'utilisateur connect?? est d??ja entegistr?? dnas la table userfav
					$em2 = $this->getDoctrine()
							   ->getManager()
							   ->getRepository('BaclooCrmBundle:Userfav');
					$userfav = $em2->findOneByUserid($user->getId());
					
					//On r??cup??re les anciens utilisateutrs favoris propos??s ?? l'utilisateur connect??
					// $em = $this->getDoctrine()
							   // ->getManager()
							   // ->getRepository('BaclooCrmBundle:Favoris');
					// $ancfavoris = $em->findByUsername(array(
												// 'user'=>$usersess));	
			
					if(empty($userfav))//Si utilisateur pas enregistr?? dans userfav
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
						// R??cup??ration du service
						$mailer = $this->get('mailer');				
						
							$message = \Swift_Message::newInstance()
								->setSubject($destinataire->getPrenom().' : L\'utilisateur '.$expediteur->getNom().' vous a ajout?? dans sa liste de coll??gues sur Bacloo')
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
								->setSubject($destinataire->getPrenom().' : L\'utilisateur '.$expediteur->getNom().' vous a ajout?? dans sa liste de coll??gues sur Bacloo')
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
			$usersess = $this->get('security.context')->getToken()->getUsername(); if(empty($usersess) or !isset($usersess) or $usersess == 'anon.'){return $this->redirect($this->generateUrl('fos_user_security_login'));}//R??cup??re le nom d'utilisateur	

			//On r??cup??re l'id de l'utilisateur connect??
			$em = $this->getDoctrine()->getManager();
			$query = $em->createQuery(
				'SELECT u.id
				FROM BaclooUserBundle:User u
				WHERE u.username = :username'
			)->setParameter('username', $usersess);
			$uid = $query->getSingleScalarResult();
			
			//On r??cup??re les favoris de l'utilisateur connect??
			$em2 = $this->getDoctrine()
					   ->getManager()
					   ->getRepository('BaclooCrmBundle:Favoris');
			$favo = $em2->findByUsername($usersess);
			
			//Tag OK s'il y a des favoris sinon NOK
			if(isset($favo) && !empty($favo)){$grant = 'ok';}else{$grant = 'nok';}
			
			//On r??cup??re les userfav du user connect??
			$em2 = $this->getDoctrine()
					   ->getManager()
					   ->getRepository('BaclooCrmBundle:Userfav');
			$userfava = $em2->findOneByUserid($uid);					
				
			// On cr???? le formulaire	
			$form = $this->createForm(new UserfavType(), $userfava);
			// on soumet la requete
			$request = $this->getRequest();
			
			//echo 'method'.$request->getMethod();
			if ($request->getMethod() == 'POST') {
			// On fait le lien Requ??te <-> Formulaire
			  $form->bind($request);
			  if ($form->isValid()) 
			  {
					//echo 'form valide'.$grant;
					// if(!isset($form->get('favoris')->getData())){echo 'form vide';}else{echo 'form plein';}
					//on rend invisible les favoris qui ont ??t?? suppr

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

							//S'il n'y a pas de favoris ??quivalent dans le formulaire ---> c'est qu'il a ??t?? supprim??

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
						// On enregistre les prospects en base de donn??e afin d'avoir son id
						return $this->redirect($this->generateUrl('bacloocrm_showfavoris'));
	//echo 'bogo';					
				}
			}
	//echo 'baga';
					//On r??cup??re les userfav du user connect??
					// $em2->clear();
					// $em->clear();
					$em2 = $this->getDoctrine()
							   ->getManager()
							   ->getRepository('BaclooCrmBundle:Userfav');
					$userfava = $em2->findOneByUserid($uid);					
						
					// On cr???? le formulaire	
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
		//On r??cup??re les d??tails de la fiche vendue
		
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
					//On r??cup??re l'id du vendeur			   
					$query = $em->createQuery(
						'SELECT u.id
						FROM BaclooUserBundle:User u
						WHERE u.username LIKE :username'
					);
					$query->setParameter('username', $fiche->getUser());				
					$vendeurid = $query->getSingleScalarResult();					   
			//echo '2';		

					//Si les cr??dits de l'acheteur sont inf??rieurs au prix d'achat
					//on retourne message cr??dits insufisants

					//Si les cr??dits sont suffisants ont valide la transaction
						$grant = 'ok';
						$today = date('Y-m-d');
						$vente = 'don';
					//D??but clonage
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
						// On r??cup??re la fiche qui nous int??resse
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
						// R??cup??ration du service
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
				// On fait le lien Requ??te <-> Formulaire
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
						// R??cup??ration du service
							$mailer = $this->get('mailer');	
							$data = $form->getData();
								$message = \Swift_Message::newInstance()
									->setSubject($form->get('raisonsociale')->getData().' - '.$expediteur->getPrenom().' '.$expediteur->getNom().' vous invite ?? rejoindre Bacloo.fr pour trouver vos futurs clients')
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
						// R??cup??ration du service
							$mailer = $this->get('mailer');	
							$data = $form->getData();
								$message = \Swift_Message::newInstance()
									->setSubject($form->get('raisonsociale')->getData().' - '.$expediteur->getPrenom().' '.$expediteur->getNom().' vous invite ?? rejoindre Bacloo.fr pour trouver vos futurs clients')
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
				// On fait le lien Requ??te <-> Formulaire
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
					// R??cup??ration du service
					// $mailer = $this->get('mailer');				
					
						// $message = \Swift_Message::newInstance()
							// ->setSubject('Bacloo : Un nouveau message est arriv??')
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
						//On r??cup??re l'id du vendeur			   
						$query = $em->createQuery(
							'SELECT u.id
							FROM BaclooUserBundle:User u
							WHERE u.username LIKE :username'
						);
						$query->setParameter('username', $usersess);				
						$vendeurid = $query->getSingleScalarResult();					   
				//echo '2';		

						//Si les cr??dits de l'acheteur sont inf??rieurs au prix d'achat
						//on retourne message cr??dits insufisants

						//Si les cr??dits sont suffisants ont valide la transaction
							$grant = 'ok';
							$today = date('Y-m-d');
							$vente = 'donemail';
						//D??but clonage
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
							// On r??cup??re la fiche qui nous int??resse
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
						// R??cup??ration du service
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
					// R??cup??ration du service
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

		//On cr????e un tableau sous le mod??le 'user'=>$xxxx pour le repository
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

		//On cr????e un tableau sous le mod??le 'user'=>$xxxx pour le repository
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
	
	public function compterappelsAction($type, $useracc, Request $request)
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
			$nbrappels = $em->getRepository('BaclooCrmBundle:Fiche')
						->count_rappelsarray($du, $au, $user);			
		}
		else
		{
			$nbrappels = $em->getRepository('BaclooCrmBundle:Fiche')
						->count_rappels($du, $au, $user);	
		}
					return $this->render('BaclooCrmBundle:Crm:compterappels.html.twig', array(
									'nbrappels'    => $nbrappels,
									'type'    => $type
									));	
	}	
	public function comptea_faireAction($type, $useracc, Request $request)
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
			$nba_faire = $em->getRepository('BaclooCrmBundle:Fiche')
						->count_a_faire_array($du, $au, $user);			
		}
		else
		{
			$nba_faire = $em->getRepository('BaclooCrmBundle:Fiche')
						->count_a_faire($du, $au, $user);		
		}		


					return $this->render('BaclooCrmBundle:Crm:comptea_faire.html.twig', array(
									'nba_faire'    => $nba_faire,
									'type'    => $type
									));	
	}	
	public function compterdvAction($type, $useracc, Request $request)
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
			$nbrdv = $em->getRepository('BaclooCrmBundle:Fiche')
						->count_rdv_array($du, $au, $user);	
		}
		else
		{
			$nbrdv = $em->getRepository('BaclooCrmBundle:Fiche')
						->count_rdv($du, $au, $user);	
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

	public function exportAction()
	{
	$usersess = $this->get('security.context')->getToken()->getUsername(); if(empty($usersess) or !isset($usersess) or $usersess == 'anon.'){return $this->redirect($this->generateUrl('fos_user_security_login'));}//R??cup??re le nom d'utilisateur

	include('societe.php');	
	$em = $this->getDoctrine()->getManager();
	// si user pas dans modules on cr???? sa ligne module avec les infos user
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
		// On r??cup??re les activit??s connexes
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
			
		// On traite la chaine de caract??re des activit??s connexes de mani??re ?? les ins??rer dans un tableau $activites_connexes sans les virgules et autres				   
			$splitby = array(',',', ',' , ',' ,');
			$text = $acticouser;
			$pattern = '/\s'.implode($splitby, '\s?|\s?').'\s?/';
			$listactico = preg_split($pattern, $text, -1, PREG_SPLIT_NO_EMPTY);	
			// print_r($listactico);					   
		
		
			//$listactico = preg_split("/\s|[\s,]+|\s?de\s?|\s?du\s?|\s?avec\s?|\s?dans\s?|\s?pour\s?|\s?des\s?|\s?les\s?/", $acticouser);
			// print_r($listactico);
			
		// Partie liste activit??s 2 cas de figure :
		// - Activit??s connexes nulles
		// - Activit??s connexes Existantes
		
		// Si cet utilisateur n'a pas de listactico on ne fait rien
		// Si la fiche utilisateur a le champs activit??s connexes renseign??, on r??cup??re les termes dans un tableau et on rempli la table
		// $Partenaires
		
				if(!empty($listactico))
				{
				// On r??cup??re la liste des utilisateurs d??j?? dans la table $partenaires
					$partenaires  = $em->getRepository('BaclooCrmBundle:Partenaires')		
								   ->findByUserid($id);						
				}
				// Pour chaque activit?? connexe
				// On sort la liste des utilisateurs ayant dezs activit??s correspondantes
				
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
						
				//Liste des users ayant les activit??s connexes qui correspondent
						$list_partspot = $query->getResult();					
						//print_r($list_partspot);
						
				//Si il y a d??j?? des utilisateurs dans la table $partenaires on les comparent au r??sultat de la recherche
							if(!empty($partenaires))
							{
							//Pour chaque utilisateur avec les activit??s connexes de la fiche
								foreach($list_partspot as $lfp)
								{
								// On regarde s'il est pr??sent dans la table $partenaires	
									foreach($partenaires as $lif)
									{
										$fichecheck  = $em->getRepository('BaclooCrmBundle:Partenaires')		
													 ->findOneBy(array('userid'=> $id, 'partpotid' => $lfp->GetId()));									

									// S'il n'est pas pr??sent on l'ins??re
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
					// Si diff = 1 on envoie un mail disant qu'il y a de nouveaux partenaires potentiels d??tect??s ?
						if(isset($diff) && $diff == 1)
						{
						// Partie envoi du mail
						// R??cup??ration du service
							$mailer = $this->get('mailer');								
								$message = \Swift_Message::newInstance()
									->setSubject('Bacloo : Nouveaux Partenaires Commerciaux d??tect??s')
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
	// On r??cup??re les activit??s connexes
					//Pour count partenaires
					$refreshpart = $this->get('session')->get('countpart');
					if(isset($refreshpart))
					{
						//ne pas faire le refresh
						$i = $refreshpart;
					}
					else
					{
						//Lancer la requ??te
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
									
								// On traite la chaine de caract??re des activit??s connexes de mani??re ?? les ins??rer dans un tableau $activites_connexes sans les virgules et autres				   
									$splitby = array(',',', ',' , ',' ,');
									$text = $acticouser;
									$pattern = '/\s'.implode($splitby, '\s?|\s?').'\s?/';
									$listactico = preg_split($pattern, $text, -1, PREG_SPLIT_NO_EMPTY);	
									//print_r($listactico);					   
								
								
									//$listactico = preg_split("/\s|[\s,]+|\s?de\s?|\s?du\s?|\s?avec\s?|\s?dans\s?|\s?pour\s?|\s?des\s?|\s?les\s?/", $acticouser);
									// print_r($listactico);
									
								// Partie liste activit??s 2 cas de figure :
								// - Activit??s connexes nulles
								// - Activit??s connexes Existantes
								
								// Si cet utilisateur n'a pas de listactico on ne fait rien
								// Si la fiche utilisateur a le champs activit??s connexes renseign??, on r??cup??re les termes dans un tableau et on rempli la table
								// $Partenaires
								
										if(!empty($listactico))
										{
										// On r??cup??re la liste des utilisateurs d??j?? dans la table $partenaires
											$partenaires  = $em->getRepository('BaclooCrmBundle:Partenaires')		
														   ->findByUserid($id);						
										}
										// Pour chaque activit?? connexe
										// On sort la liste des utilisateurs ayant des activit??s correspondantes
										
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
												
										//Liste des users ayant les activit??s connexes qui correspondent
												$list_partspot = $query->getResult();					
												//print_r($list_partspot);
												
										//Si il y a d??j?? des utilisateurs dans la table $partenaires on les comparent au r??sultat de la recherche
													if(!empty($partenaires))
													{
													//Pour chaque utilisateur avec les activit??s connexes de la fiche
														foreach($list_partspot as $lfp)
														{//echo 'xxxxxxxxxxxxxxxx';
														// On regarde s'il est pr??sent dans la table $partenaires	
															foreach($partenaires as $lif)
															{
																$fichecheck  = $em->getRepository('BaclooCrmBundle:Partenaires')		
																			 ->findOneBy(array('userid'=> $id, 'partpotid' => $lfp->GetId()));									

															// S'il n'est pas pr??sent on l'ins??re
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
											// Si diff = 1 on envoie un mail disant qu'il y a de nouveaux partenaires potentiels d??tect??s ?
												if(isset($diff) && $diff == 1)
												{
												// Partie envoi du mail
												// R??cup??ration du service
													$mailer = $this->get('mailer');								
														$message = \Swift_Message::newInstance()
															->setSubject('Bacloo : Nouveaux Partenaires Commerciaux d??tect??s')
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
		//$uid = id user connect??
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
	
	public function accueilAction($useracc, Request $request)
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
		
		//Ici on met ?? jour la soci??t?? au cas l'admin aurait cr???? sont Bacloo perso apr??s avoir import?? son fichier
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
				//On calcule crit??res
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
				//On regarde si l'utilisateur connect?? est d??ja entegistr?? dnas la table userpipe
				$userpipe = $em->getRepository('BaclooCrmBundle:Userpipe')
				->findOneByUserid($uid);			  
		
				//On r??cup??re les pipelines de l'utilisateur connect??
				$em2 = $this->getDoctrine()
						   ->getManager()
						   ->getRepository('BaclooCrmBundle:Pipeline');
				$pipe = $em2->findByUsername($usersess);

				$pipe_zero = $em->getRepository('BaclooCrmBundle:Pipeline')
								->findByPipeorder(0);

				//On r??cup??re les userpipe du user connect??
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
					$pipe0->setPipename('Affaires sign??es');
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
			$offset = 12/$nbpipe;

			$today = date('Y-m-d');
			$prev30 = date('Y-m-d', strtotime("-29 days"));
			
		if(is_array($usersessok) == 1)
		{
			$fichespipe = $em->getRepository('BaclooCrmBundle:Fiche')
							 ->createpiplinearray($usersessok);
								 
			$em = $this->getDoctrine()->getManager();
			$nbevents  = $em->getRepository('BaclooCrmBundle:Fiche')		
						   ->last30eventarray($usersess, $today, $prev30);
						   
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
					$ca_pot = $ca_pot + $fp->getPotentiel();;
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
					 
		$userprix = 10;
		if(empty($modules))
		{//echo 'oooooooooooooooooooooooo';
			if($user->getRoleuser() == 'admin')
			{//echo 'sssssssssssssssssss';
				$modules = new Modules();
				$modules->setUserprix($userprix);
				$modules->setUserdebut(date('d/m/Y'));
				$modules->setUserexpiration('illimit??');
				$modules->setBbuseractivation(0);
				$modules->setUsersociete($nomsociete);
				$modules->setModule1('Partage rapide des fiches');
				$modules->setModule1prix(10);
				$modules->setModule1debut(date('25/12/2016'));
				$modules->setModule1expiration('15/01/2017');
				$modules->setModule1activation(0);
				$modules->setModule2('Pipeline des ventes');
				$modules->setModule2prix(40);
				$modules->setModule2debut(date('30/11/2016'));
				$modules->setModule2expiration('31/12/2016');
				$modules->setModule2activation(0);
				$modules->setModule3('Bloc devis et commandes');
				$modules->setModule3prix(0);
				$modules->setModule3debut(date('30/11/2016'));
				$modules->setModule3expiration('31/12/2020');
				$modules->setModule3activation(1);
				$modules->setModule4('Recherche avanc??e');
				$modules->setModule4prix(10);
				$modules->setModule4debut(date('25/12/2016'));
				$modules->setModule4expiration('15/01/2017');
				$modules->setModule4activation(0);
				$modules->setModule5('Synchronisation avec agenda');
				$modules->setModule5prix(0);
				$modules->setModule5debut(date('30/11/2016'));
				$modules->setModule5expiration('31/12/2020');
				$modules->setModule5activation(1);
				$modules->setModule6('Fiches fournisseurs');
				$modules->setModule6prix(10);
				$modules->setModule6debut(date('25/12/2016'));
				$modules->setModule6expiration('15/01/2017');
				$modules->setModule6activation(0);
				$modules->setModule7('Google Docs');
				$modules->setModule7prix(10);
				$modules->setModule7debut(date('25/12/2016'));
				$modules->setModule7expiration('15/01/2017');
				$modules->setModule7activation(0);
				$modules->setModule8('Coll??gues : Partage de fiches');
				$modules->setModule8prix(0);
				$modules->setModule8debut(date('30/11/2016'));
				$modules->setModule8expiration('31/12/2020');
				$modules->setModule8activation(1);
				$modules->setModule9('Annuaire');
				$modules->setModule9prix(80);
				$modules->setModule9debut(date('25/12/2016'));
				$modules->setModule9expiration('15/01/2017');
				$modules->setModule9activation(1);
				$modules->setModule10('Bacloo Illimit??');
				$modules->setModule10prix(100);
				$modules->setModule10debut(date('25/12/2016'));
				$modules->setModule10expiration('15/01/2017');
				$modules->setModule10activation(1);
				$modules->setModule11('Speed menu');
				$modules->setModule11prix(10);
				$modules->setModule11debut(date('25/12/2016'));
				$modules->setModule11expiration('15/01/2017');
				$modules->setModule11activation(1);
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
				$modules->setUserexpiration('illimit??');
				$modules->setBbuseractivation(0);
				$modules->setUsersociete($nomsociete);
				$modules->setUserid($user->getId());
				$modules->setUsername($usersess);
				$modules->setModule1('Partage rapide des fiches');
				$modules->setModule1prix(10);
				$modules->setModule1debut(date('25/12/2016'));
				$modules->setModule1expiration('15/01/2017');
				$modules->setModule1activation(0);
				$modules->setModule2('Pipeline des ventes');
				$modules->setModule2prix(40);
				$modules->setModule2debut(date('25/12/2016'));
				$modules->setModule2expiration('15/01/2017');
				$modules->setModule2activation(0);
				$modules->setModule3('Bloc devis et commandes');
				$modules->setModule3prix(10);
				$modules->setModule3debut(date('25/12/2016'));
				$modules->setModule3expiration('15/01/2017');
				$modules->setModule3activation(0);
				$modules->setModule4('Recherche avanc??e');
				$modules->setModule4prix(10);
				$modules->setModule4debut(date('25/12/2016'));
				$modules->setModule4expiration('15/01/2017');
				$modules->setModule4activation(0);
				$modules->setModule5('Synchronisation avec agenda');
				$modules->setModule5prix(10);
				$modules->setModule5debut(date('25/12/2016'));
				$modules->setModule5expiration('15/01/2017');
				$modules->setModule5activation(0);
				$modules->setModule6('Fiches fournisseurs');
				$modules->setModule6prix(10);
				$modules->setModule6debut(date('25/12/2016'));
				$modules->setModule6expiration('15/01/2017');
				$modules->setModule6activation(0);
				$modules->setModule7('Google Docs');
				$modules->setModule7prix(10);
				$modules->setModule7debut(date('25/12/2016'));
				$modules->setModule7expiration('15/01/2017');
				$modules->setModule7activation(0);
				$modules->setModule8('Coll??gues : Partage de fiches');
				$modules->setModule8prix(10);
				$modules->setModule8debut(date('25/12/2016'));
				$modules->setModule8expiration('15/01/2017');
				$modules->setModule8activation(0);
				$modules->setModule9('Annuaire');
				$modules->setModule9prix(80);
				$modules->setModule9debut(date('25/12/2016'));
				$modules->setModule9expiration('15/01/2017');
				$modules->setModule9activation(1);
				$modules->setModule10('Bacloo Illimit??');
				$modules->setModule10prix(100);
				$modules->setModule10debut(date('25/12/2016'));
				$modules->setModule10expiration('15/01/2017');
				$modules->setModule10activation(1);
				$modules->setModule11('Speed menu');
				$modules->setModule11prix(10);
				$modules->setModule11debut(date('25/12/2016'));
				$modules->setModule11expiration('15/01/2017');
				$modules->setModule11activation(1);				
				// $modules->setUsersociete();
				$modules->addModa($moda);
				$moda->addModule($modules);
				$em->persist($modules);
				$em->persist($moda);
				$em->flush();			
			}
		}
//Controle validit?? de tous les moduels

		$modulesuser  = $em->getRepository('BaclooCrmBundle:Modules')		
					   ->findOneByUsername($usersess);
					   
		if($modulesuser->getBbuseractivation() == 0)
		{
			// $request->getSession()
				// ->getFlashBag()
				// ->add('fail', 'Votre compte n\'a pas encore ??t?? activ?? par l\'administrateur');			
			return $this->redirect($this->generateUrl('fos_user_security_logout'));
		}
			

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
	//envoyer un mail ?? l'admin  indiquant que module d??sactiv?? faute de cr??dits 
	// R??cup??ration du service
	$mailer = $this->get('mailer');				
	
		$message = \Swift_Message::newInstance()
			->setSubject($userdetails->getPrenom(). ' : '.$comptemodarret.' modules en arr??t et '.$comptemodalerte.' modules qui s\'arr??tent dans 5 jours')
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
			->setSubject($userdetails->getPrenom(). ' : '.$comptemodarret.' modules en arr??t et '.$comptemodalerte.' modules qui s\'arr??tent dans 5 jours')
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
	//envoyer un mail ?? l'admin  indiquant que module d??sactiv?? faute de cr??dits 
	// R??cup??ration du service
	$mailer = $this->get('mailer');				
	
		$message = \Swift_Message::newInstance()
			->setSubject($userdetails->getPrenom(). ' : '.$comptemodarret.' modules en arr??t')
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
			->setSubject($userdetails->getPrenom(). ' : '.$comptemodarret.' modules en arr??t')
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
	//envoyer un mail ?? l'admin  indiquant que module d??sactiv?? faute de cr??dits 
	// R??cup??ration du service
	// $mailer = $this->get('mailer');				
	
		// $message = \Swift_Message::newInstance()
			// ->setSubject($userdetails->getPrenom(). ' : '.$comptemodalerte.' modules qui s arr??tent dans 5 jours '.$listmodalerte)
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
			// ->setSubject($userdetails->getPrenom(). ' : '.$comptemodalerte.'modules qui s arr??tent dans 5 jours '.$listmodalerte)
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
					//Lancer la requ??te
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
			//Lancer la requ??te
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

				   
		$modules  = $em->getRepository('BaclooCrmBundle:Modules')		
					   ->findOneByUsername($usersess);
		if($nbpipe > 3 && $modules->getModule2activation() == 0){$nbpipe = 3;}
		$offset = 12/$nbpipe;					   
		return $this->render('BaclooCrmBundle:Crm:accueil.html.twig', array(
						'prospot' => $i,
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
						'roleuser' => $user->getRoleuser(),
						'type' => 'accueil',
						'nbfiche' => $nbfiche					
						));							
	}
	
	public function publisharticleAction($artvue, Request $request)
	{
		$usersess = $this->get('security.context')->getToken()->getUsername(); if(empty($usersess) or !isset($usersess) or $usersess == 'anon.'){return $this->redirect($this->generateUrl('fos_user_security_login'));}//R??cup??re le nom d'utilisateur

		// On cr??e un objet Articles
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
							// R??cup??ration du service
								$mailer = $this->get('mailer');	
								$data = $form->getData();
									$message = \Swift_Message::newInstance()
										->setSubject('Bacloo : Un message a ??t?? publi?? sur la timeline')
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
		$usersess = $this->get('security.context')->getToken()->getUsername(); if(empty($usersess) or !isset($usersess) or $usersess == 'anon.'){return $this->redirect($this->generateUrl('fos_user_security_login'));}//R??cup??re le nom d'utilisateur
		$previous = $this->get('request')->server->get('HTTP_REFERER');
		// On cr??e un objet Articles
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
		$usersess = $this->get('security.context')->getToken()->getUsername(); if(empty($usersess) or !isset($usersess) or $usersess == 'anon.'){return $this->redirect($this->generateUrl('fos_user_security_login'));}//R??cup??re le nom d'utilisateur
		$previous = $this->get('request')->server->get('HTTP_REFERER');
		$today = date('Y-m-d');//echo $today;
		// On cr??e un objet Articles
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
		$usersess = $this->get('security.context')->getToken()->getUsername(); if(empty($usersess) or !isset($usersess) or $usersess == 'anon.'){return $this->redirect($this->generateUrl('fos_user_security_login'));}//R??cup??re le nom d'utilisateur
		$previous = $this->get('request')->server->get('HTTP_REFERER');
		$today = date('Y-m-d');//echo $today;
		// On cr??e un objet Articles
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
		$usersess = $this->get('security.context')->getToken()->getUsername(); if(empty($usersess) or !isset($usersess) or $usersess == 'anon.'){return $this->redirect($this->generateUrl('fos_user_security_login'));}//R??cup??re le nom d'utilisateur
			
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
		$usersess = $this->get('security.context')->getToken()->getUsername(); if(empty($usersess) or !isset($usersess) or $usersess == 'anon.'){return $this->redirect($this->generateUrl('fos_user_security_login'));}//R??cup??re le nom d'utilisateur
			
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
		$usersess = $this->get('security.context')->getToken()->getUsername(); if(empty($usersess) or !isset($usersess) or $usersess == 'anon.'){return $this->redirect($this->generateUrl('fos_user_security_login'));}//R??cup??re le nom d'utilisateur
		$previous = $this->get('request')->server->get('HTTP_REFERER');	
		$defaultData = array();
		$form = $this->createFormBuilder($defaultData)
			->add('pseudo', 'text', array('required' => false))
			->getForm();

		$form->handleRequest($request);

		if ($form->isValid()) {
				// echo 'XXXXXXXXXXXXXXXX';		
				// Les donn??es sont un tableau avec les cl??s "name", "email", et "message"
				$data = $form->getData();
					// Partie envoi du mail
					// R??cup??ration du service
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
		$usersess = $this->get('security.context')->getToken()->getUsername(); if(empty($usersess) or !isset($usersess) or $usersess == 'anon.'){return $this->redirect($this->generateUrl('fos_user_security_login'));}//R??cup??re le nom d'utilisateur
		$previous = $this->get('request')->server->get('HTTP_REFERER');
		
		$prixmodule1 = 10;
		$prixmodule2 = 40;
		$prixmodule3 = 10;
		$prixmodule4 = 10;
		$prixmodule5 = 10;
		$prixmodule6 = 10;
		$prixmodule7 = 10;
		$prixmodule8 = 10;
		$prixmodule9 = 10;
		$prixmodule10 = 10;
		$prixmodule11 = 10;
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
		//Si le user n'est pas encore pr??sent dans la table modules on en cr????e un nouveau
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

					//Si pas suffisament de cr??dits on renvoie vers la fen??tre d'alerte
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

					//Si pas suffisament de cr??dits on renvoie vers la fen??tre d'alerte
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
			// On fait le lien Requ??te <-> Formulaire
			  $form->bind($request);$data = $form->getData();
			  if ($form->isValid())	
			  {
	// echo 'ici';
				$prix = 0;
				  //Boucle recup donn??es formulaire
				  foreach ($form->get('modules')->getData() as $modulform)
				  {
	// echo 'Pour '.$modulform->getUsername();echo '  de la soci??t?? '.$modulform->getUsersociete();
					//On r??cup??re la modules correspondant en BDD
					$em = $this->getDoctrine()->getManager();
					$modulesbdd = $em->getRepository('BaclooCrmBundle:Modules')
							->findOneBy(array('username'=> $modulform->getUsername(), 'usersociete' => $societe));

						// echo 'bdd'.$modulesbdd->getModule1activation();echo '  form'.$modulform->getModule1activation();
						
						if($modulform->getBbuseractivation() == 1 && $modulesbdd->getBbuseractivation() == 0 )
						{
							$userprix = 10;
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

						$module1prix = 10;
						$module2prix = 40;
						$module3prix = 10;
						$module4prix = 10;
						$module5prix = 10;
						$module6prix = 10;
						$module7prix = 10;
						$module8prix = 10;
						$module9prix = 80;
						$module10prix = 100;
						$module11prix = 10;
						$module12prix = 10;						
						
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
		$usersess = $this->get('security.context')->getToken()->getUsername(); if(empty($usersess) or !isset($usersess) or $usersess == 'anon.'){return $this->redirect($this->generateUrl('fos_user_security_login'));}//R??cup??re le nom d'utilisateur

		$em = $this->getDoctrine()->getManager();
		
		$userdetails  = $em->getRepository('BaclooUserBundle:User')		
						   ->findOneByUsername($usersess);
						   
		$roleuser = $userdetails->getRoleuser();
		// $Usersociete = $userdetails->getUsersociete();
		if($roleuser == 'admin')
		{
			$usersess = $this->get('security.context')->getToken()->getUsername(); if(empty($usersess) or !isset($usersess) or $usersess == 'anon.'){return $this->redirect($this->generateUrl('fos_user_security_login'));}//R??cup??re le nom d'utilisateur
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
						
						//Si pas suffisament de cr??dits on renvoie vers la fen??tre d'alerte
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
		$usersess = $this->get('security.context')->getToken()->getUsername(); if(empty($usersess) or !isset($usersess) or $usersess == 'anon.'){return $this->redirect($this->generateUrl('fos_user_security_login'));}//R??cup??re le nom d'utilisateur
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
			// Les donn??es sont un tableau avec les cl??s "name", "email", et "message"
			$data = $form->getData();
				// Partie envoi du mail
				// R??cup??ration du service
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
			$modules->setBb('Bacloo personnalis??');
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
					// echo '??chec';
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
					// echo '??chec';
				}
				$fs = new Filesystem();	
				$fs->rename('b/bacloo/', 'b/'.$societe.'/');				
			}			

			// sleep(40);


			
		//On inscrit le nom de la societe dans societe.txt	

			$monfichier = fopen('b/'.$societe.'/src/Bacloo/CrmBundle/Controller/societe.php', 'w');
			$monfichier = fopen('b/'.$societe.'/src/Bacloo/CrmBundle/Controller/societe.php', 'r+');
			
			fseek($monfichier, 0); // On remet le curseur au d??but du fichier
			fputs($monfichier, '<?php $societe = "'.$society.'";?>'); // On ??crit le nouveau nom de soci??t??			 
			fclose($monfichier);

			$monfichier2 = fopen('b/'.$societe.'/src/Bacloo/UserBundle/Controller/societe.php', 'w');
			$monfichier2 = fopen('b/'.$societe.'/src/Bacloo/UserBundle/Controller/societe.php', 'r+');

			fseek($monfichier2, 0); // On remet le curseur au d??but du fichier
			fputs($monfichier2, '<?php $societe = "'.$society.'";?>'); // On ??crit le nouveau nom de soci??t??			 
			fclose($monfichier2);			
			// $file = "societe.php";
			// $fs->copy('societe.php', '../src/Bacloo/UserBundle/Controller/societe.php', true);
			// copy($file, "../src/Bacloo/UserBundle/Controller/societe.php");
			$destinataire = $userdetails;
						$mailer = $this->get('mailer');				
						
							$message = \Swift_Message::newInstance()
								->setSubject($destinataire->getPrenom(). ' : '.$usersess.' a cr????e un bacloo personnalis??')
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
					//echo '??chec';
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
					//echo '??chec';
				}
				$fs = new Filesystem();	
				$fs->rename('b/bacloo/', 'b/'.$societe);				
			}

		
	//On inscrit le nom de la societe dans societe.txt	
		
		$monfichier = fopen('../src/Bacloo/CrmBundle/Controller/societe.php', 'r+');
		$file = "societe.php";
		copy($file, "../src/Bacloo/UserBundle/Controller/societe.php");
		copy($file, "../src/Avro/CsvBundle/Import/societe.php");
		fseek($monfichier, 0); // On remet le curseur au d??but du fichier
		fputs($monfichier, '<?php $societe = "'.$societe.'";?>'); // On ??crit le nouveau nom de soci??t??
		 
		fclose($monfichier);
		
		//Include ?? ins??rer dans le controler apr??s d??compr??ssion de bacloo.zip
		// include('societe.php');

	}

	public function gdriveAction($id, request $request)
	{
		$usersess = $this->get('security.context')->getToken()->getUsername(); if(empty($usersess) or !isset($usersess) or $usersess == 'anon.'){return $this->redirect($this->generateUrl('fos_user_security_login'));}//R??cup??re le nom d'utilisateur
		$previous = $this->get('request')->server->get('HTTP_REFERER');	
		$defaultData = array();
		$form = $this->createFormBuilder($defaultData)
			->add('folder_id', 'text', array('required' => false))
			->getForm();
// echo 'dodo'.$id;
		$form->handleRequest($request);

		if ($form->isValid()) {
				// echo 'XXXXXXXXXXXXXXXX';		
				// Les donn??es sont un tableau avec les cl??s "name", "email", et "message"
				$data = $form->getData();
					// Partie envoi du mail
					// R??cup??ration du service
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
	
		//On r??cup??re les favoris niveau ALL
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
	
		//On r??cup??re les favoris niveau ALL
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
			$usersess = $this->get('security.context')->getToken()->getUsername(); if(empty($usersess) or !isset($usersess) or $usersess == 'anon.'){return $this->redirect($this->generateUrl('fos_user_security_login'));}//R??cup??re le nom d'utilisateur	

			//On r??cup??re l'id de l'utilisateur connect??
			$em = $this->getDoctrine()->getManager();
			$query = $em->createQuery(
				'SELECT u.id
				FROM BaclooUserBundle:User u
				WHERE u.username = :username'
			)->setParameter('username', $usersess);
			$uid = $query->getSingleScalarResult();
			//On regarde si l'utilisateur connect?? est d??ja entegistr?? dnas la table userpipe
			$userpipe = $em->getRepository('BaclooCrmBundle:Userpipe')
			->findOneByUserid($uid);			  
	
			//On r??cup??re les pipelines de l'utilisateur connect??
			$em2 = $this->getDoctrine()
					   ->getManager()
					   ->getRepository('BaclooCrmBundle:Pipeline');
			$pipe = $em2->findByUsername($usersess);


			//On r??cup??re les userpipe du user connect??
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
				$pipe0->setPipename('Affaires sign??es');
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
			// On fait le lien Requ??te <-> Formulaire
			  $form->bind($request);
			  if ($form->isValid()) 
			  {
				// echo 'isi';
					foreach ($form->get('pipeline')->getData() as $bee) 
					{					
						if(!isset($bee)){//echo 'iiiiiiggg';
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
									if(empty($originalBr) && !empty($rb)){//echo 'ddododod';
									// On persiste les pipeline et autres (propri??taire) maintenant que $fiche a un id
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
					$module9activation = $modules->getModule2activation();
					if($module9activation == 0)
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
						// On enregistre les prospects en base de donn??e afin d'avoir son id
						return $this->redirect($this->generateUrl('bacloocrm_showpipeline'));
	//echo 'bogo';					
				}
			}			

	//echo 'baga';
			//On r??cup??re les userpipe du user connect??
			// $em2->clear();
			$em->clear();

			
			return $this->render('BaclooCrmBundle:Crm:pipeline_list.html.twig', array(
							'form'    => $form->createView(),
							'userid' => $uid,
							'username' => $usersess,
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
		$usersess = $this->get('security.context')->getToken()->getUsername(); if(empty($usersess) or !isset($usersess) or $usersess == 'anon.'){return $this->redirect($this->generateUrl('fos_user_security_login'));}//R??cup??re le nom d'utilisateur
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
}