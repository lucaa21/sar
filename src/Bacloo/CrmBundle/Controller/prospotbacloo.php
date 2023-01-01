<?php

//Recherche de Prospects	
 	public function searchbaclooAction($mode)
		{	
		$page=1;
		if(!isset($page) || $page == 0){$page =1;}
		$usersess = $this->get('security.context')->getToken()->getUsername(); if(empty($usersess) or !isset($usersess) or $usersess == 'anon.'){return $this->redirect($this->generateUrl('fos_user_security_login'));}//Récupère le nom d'utilisateur
		$em = $this->getDoctrine()->getManager();

		$query = $em->createQuery(
			'SELECT u.id
			FROM BaclooUserBundle:User u
			WHERE u.username = :username'
		)->setParameter('username', $usersess);
		$uid = $query->getSingleScalarResult();		

				// echo 'on efface';
				//On réinitialise la recherche
				$em = $this->getDoctrine()
						   ->getManager()
						   ->getRepository('BaclooCrmBundle:Prospotbacloo');
				$prospotaa = $em->findByUser(array(
											'user'=>$usersess));			

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
			if ($request->getMethod() == 'POST') {
			  $form->bind($request);
				  if ($form->isValid()) {
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
		{//echo 'find';echo 'mode'.$mode;echo 'letoc'.$this->getRequest()->request->get('pagination');
		$nbparpage = 20;
		$usersess = $this->get('security.context')->getToken()->getUsername(); if(empty($usersess) or !isset($usersess) or $usersess == 'anon.'){return $this->redirect($this->generateUrl('fos_user_security_login'));}
			// On récupère l'EntityManager
			$em = $this->getDoctrine()
					   ->getManager();
			// On récupere l'id de la recherche	puis les paramètres dela recherche   
			$search = $em->getRepository('BaclooCrmBundle:Search')->find($id);
			$besoin = $search->getBesoins();
			$activite = $search->getRaisonSociale();
			$departement = $search->getNom();
			//$usersess = 'jmr';
			//echo $departement;
			//$fiche = new Fiche;
			
		if($toc != 1)
		{
							$session = $request->getSession();//echo '1';
							$session->remove('controle2');//echo '2';		
							$session = new Session();//echo '3';
							$session->set('controle2', '0');//echo '4';	
			// On récupère les fiches correspondantes aux résultats de recherche
			$em = $this->getDoctrine()->getManager();
			
			//Partie qui compte le nombre de résultats
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
			
			//Fin partie qui compte les résultats

			$fiche = $em->getRepository('BaclooCrmBundle:Fiche')
						->searchfichebacloo2($besoin, $activite, $departement, $nbparpage, $page, $usersess, $mode);
			
			//S'il y a des fiches correspondantes à la recherche
			if(!empty($fiche )){
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
				$prospotbacloo = $em2->findOneByUser($usersess);
				
				//Si utilisateur pas enregistré dans prospectsbacloo on l'insère
				if(empty($prospectsbacloo))
				{//echo 'empty prosp';
					//On enregistre le userid dans prospectsbacloo
					$prospectsbacloo = new Prospectsbacloo();
					$prospectsbacloo->setUserid($uid);
					$em->persist($prospectsbacloo);	
				}

				//S'il n'y a pas encore de prospot dans la table prosppotbacloo
				if(empty($prospotbacloo))
				{$i=0;
				// Pour chaque fiche trouvée on l'insère dans la table prospot
					foreach($fiche as $fic)
					{$i++;
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
						
						$ficheuser = $em->getRepository('BaclooCrmBundle:Fiche')
						->findBy(array('user' => $usersess, 'raisonSociale' => $fic->GetRaisonSociale(), 'ville' => $fic->GetVille()));
						//echo 'nb resultatfind'.ceil(count($fiche));
						if(empty($ficheuser))
						{//echo 'ficheuserempty3';
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
							//echo 'ficheuser plein3'.$fic->GetRaisonSociale();
						}
					}
						$em->flush();				
				}//echo 'iiiiiiiiiiiiiiii'.$i;				
				// On crée un objet Search
				$search = $em->getRepository('BaclooCrmBundle:Search')->find($id);//echo 'bbbbbbbbbb';
				$form = $this->createForm(new SearchType(), $search);
				$request = $this->getRequest();
				// Dans le cas ou le formulaire a été posté
					if ($request->getMethod() == 'POST') 
					{
						// echo 'post';
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
				// echo 'pas post';
				if(!isset($insert)){$insert = 'ok';}
				if(!isset($find)){$find = 'nok';}
				return $this->render('BaclooCrmBundle:Crm:searchbacloo.html.twig', array(
						'id' => $id,
						'insert' => $insert,
						'find' => $find,
						'toc' => $toc,
						'mode' => $mode,
						'page' => $page,
						'nombrePage' => ceil(count($fiche)/$nbparpage),
						'resultats' => $fiche,
						'form' => $form->createView()
				));
			}
		
			else{//echo 'resultat vide';
				// On crée un objet Search
				$search = new Search;//echo 'ccccccccccccccc';
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
							
							// On redirige vers la page de visualisation de recherche
							return $this->redirect($this->generateUrl('bacloocrm_find', array('id' => $search->getFicheid())));
						}
					}
				return $this->render('BaclooCrmBundle:Crm:searchbacloo.html.twig', array('form' => $form->createView(), 'resultats' => 'rien',));			
			}
		}		
		else
		{
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
			// echo $c;
				$search = $em->getRepository('BaclooCrmBundle:Search')->find($id);//echo 'bbbbbbbbbb';
				$form = $this->createForm(new SearchType(), $search);
				$request = $this->getRequest();
				// Dans le cas ou le formulaire a été posté
					if ($request->getMethod() == 'POST') 
					{
						// echo 'post';
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
				// echo 'pas post';
				if(!isset($insert)){$insert = 'ok';}
				if(!isset($find)){$find = 'nok';}
				return $this->render('BaclooCrmBundle:Crm:searchbacloo.html.twig', array(
						'id' => $id,
						'insert' => $insert,
						'find' => $find,
						'toc' => $toc,
						'mode' => $mode,
						'page' => $page,
						'nombrePage' => ceil(count($fiche)/$nbparpage),
						'resultats' => $fiche,
						'form' => $form->createView()
				));			
		}
			
	}

 	public function showbacloolistAction($id, $mode, $page, $toc, $find, $insert, Request $request)
	{//echo 'le show';
	//echo 'findxxxxxxxxxxxx'.$find;
	$usersess = $this->get('security.context')->getToken()->getUsername(); if(empty($usersess) or !isset($usersess) or $usersess == 'anon.'){return $this->redirect($this->generateUrl('fos_user_security_login'));}//Récupère le nom d'utilisateur
	//echo 'la page'.$page;
	$nbparpage = 20;
	ini_set('max_execution_time', 300);
	if($this->getRequest()->request->get('pagination') > 0)
	{
		$page = $this->getRequest()->request->get('pagination');
		//echo 'la page2'.$page;
	}

	$em = $this->getDoctrine()
			   ->getManager();
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
		$em = $this->getDoctrine()->getManager();
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
		
		$em2 = $this->getDoctrine()
				   ->getManager()
				   ->getRepository('BaclooCrmBundle:Prospectsbacloo');
		$prospota2 = $em2->findOneByUserid($uid);		
//echo 'countprospoota2'.count($prospota2);		
			// On créé le formulaire	
			$form = $this->createForm(new ProspectsbaclooType(), $prospota2);
			// on soumet la requete
			$request = $this->getRequest();
				
if ($this->getRequest()->request->get('acheter') == 'Acheter')
{//echo 'acheter';
	$previous = $this->get('request')->server->get('HTTP_REFERER');
	if ($request->getMethod() == 'POST') {//echo '6';
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
				$prospotbacloo  = $em->getRepository('BaclooCrmBundle:Prospotbacloo')		
							   ->findOneByFicheid($ficheid);						

				$today = date('Y-m-d');
				$form = $this->createForm(new ProspotbaclooType(), $prospotbacloo);
				// on soumet la requete		
				$request = $this->getRequest();
				if ($request->getMethod() == 'POST') 
				{		 		
					$vente = 'ok';
					//echo '9';
					$session = $request->getSession();//echo '2';
					$controle2 = $session->get('controle2');//echo '4';
					//echo 'controle--- = '.$controle2.'   ';				
						$controle2++;		
					//echo 'controle2 = '.$controle2.'   ';		
					if($controle2 == 1)
					{
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
						$em->detach($prospotbacloo);
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

						// Fin partie envoi mail
						
						//FIN CLONAGE
			//FIN DE BOUCLE
						$controle2++;//echo 'return2';
						$session->set('controle2', $controle2);//echo '4';									   
						return $this->render('BaclooCrmBundle:Crm:buyfiche.html.twig', array(
										'previous' => $previous,
										'grant'    => $grant,
										'vente'    => 'bacloo',
										'nbfiche'  => $nbfiche
										));							
					}
					else
					{//echo 'zarb';
						$search = new Search;// 'dddddddddddddddddddd';
						$form = $this->createForm(new SearchType(), $search);//echo 'return3';
						return $this->render('BaclooCrmBundle:Crm:searchbacloo.html.twig', array('form' => $form->createView()));
					}
				}			
			}
		  }
		//echo 'iiiiiiiiiiiiiiiii'.$i;		
		}
	  }		
	}
}
elseif ($this->getRequest()->request->get('pagination') == $page || $this->getRequest()->request->get('pagination') == 'Tout cocher' || $this->getRequest()->request->get('pagination') == 'Tout décocher' || $toc = 1)
{
	//echo 'pagination'.$request->getMethod();
	// 1. On update les données de la page précédente dans la table
	$toc = 1;
	if ($request->getMethod() == 'POST') 
	{//echo '6';
	  $form->bind($request);//echo $form->isValid();
	  if ($form->isValid())
		{
			foreach ($form->get('prospotbacloo')->getData() as $pr)
			{//echo '8'.$pr->getRaisonSociale();
				$em->clear();
				$em2 = $this->getDoctrine()
						   ->getManager()
						   ->getRepository('BaclooCrmBundle:Prospectsbacloo');
				$prospota2 = $em2->findOneByUserid($uid);		  
				$em3 = $this->getDoctrine()
						   ->getManager()
						   ->getRepository('BaclooCrmBundle:Prospotbacloo');
				$prospo2 = $em3->findOneByRaisonSociale($pr->getRaisonsociale());
				// echo 'ph1'.$prospo2->getAcheter();
				// echo 'ph2'.$pr->getAcheter();
				if(isset($prospo2) && !empty($prospo2) && $prospo2->getRaiSonsociale() == $pr->getRaisonSociale() && $prospo2->getVille() == $pr->getVille())
				{
					if($this->getRequest()->request->get('pagination') == 'Tout cocher')
					{
						if(isset($prospo2) && !empty($prospo2))
						{
						$prospo2->setAcheter('1');
						$insert = 'nok';//echo 'toc=1';
						}
					}
					elseif($this->getRequest()->request->get('pagination') == 'Tout décocher')
					{
						if(isset($prospo2) && !empty($prospo2))
						{
						$prospo2->setAcheter('0');
						$insert = 'nok';//echo 'toc=2';
						}											
					}
					else
					{
						if(isset($prospo2) && !empty($prospo2) && $prospo2->getRaiSonsociale() == $pr->getRaisonSociale())
						{
						$prospo2->setAcheter($pr->getAcheter());
						$insert = 'ok';//echo 'toc=null';
						}											
					}
					// $em->remove($pr);
					// $em->persist($pr);
					$em->flush();
					
					//Comme cette condition est réalisée on ne fait pas d'insertion
					
				}
// echo 'lolorrrr';
	// 2. On récupère les données de la page suivante pour les affichées
		    }//echo 'insertpag'.$insert;
			if(!isset($insert)){$insert = 'ok';}
			if(isset($insert) && $insert == 'nok')
			{
			return $this->redirect($this->generateUrl('bacloocrm_findbacloo', array(
							'toc'=> $toc,
							'insert'=> $insert,
							'id' => $id,
							'mode' => $mode, 
							'page' => $page )));			
			}
			else
			{
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
			// echo $c;
// echo 'countfiche'.count($fiche);
			//S'il y a des fiches correspondantes à la recherche
			if(!empty($fiche )){
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
				if(count($fiche)> $countprospotbacloo && $insert == 'nok')
				{
				//S'il n'y a pas encore de prospot dans la table prosppotbacloo
				$i=0;
				// Pour chaque fiche trouvée on l'insère dans la table prospot
					foreach($fiche as $fic)
					{$i++;
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
						{//echo 'ficheuserempty2';
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
				//echo 'iiiiiiiiiiiiiiii'.$i;				
				// On crée un objet Search
									
				//echo 'pas post';
				// return $this->render('BaclooCrmBundle:Crm:searchbacloo.html.twig', array(
						// 'id' => $id,
						// 'toc' => $toc,
						// 'mode' => $mode,
						// 'page' => $page,
						// 'nombrePage' => ceil(count($fiche)/$nbparpage),
						// 'resultats' => $fiche,
						// 'form' => $form->createView()
				// ));
//echo 'lalarrrrrrr';	
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
//echo 'return5';	
return $this->render('BaclooCrmBundle:Crm:showbacloo_list.html.twig', array(
				'form'    		  => $form->createView(),
				'id'	  	      => $id,
				'countselect'	  => $countselect,
				'nbresultats'	  => $nbresultats,
				'mode'	  		  => $mode,
				'limitebasse'	  => $limitebasse,
				'limitehaute'	  => $limitehaute,
				'nombrePage' 	  => ceil(count($fiche)/$nbparpage),
				'page'	  	 	  => $page,
				'grant'	  		  => $grant));		
	

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
// echo 'countfiche'.count($fiche);
			//S'il y a des fiches correspondantes à la recherche
			//if($this->getRequest()->request->get('pagination') == ''){echo 'égalité';}else{echo'pas égalité';}echo'findzzzzzzzzz'.$find.'insert'.$insert;
		if($find == 'nok' && $insert =='ok')
		{
			if(!empty($fiche)){
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
					{$i++;
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
						//echo 'nb resultatfind'.ceil(count($fiche));
						if(empty($ficheuser))
						{//echo 'ficheuserempty1';
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
				// On crée un objet Search
									
				//echo 'pas post';
				// return $this->render('BaclooCrmBundle:Crm:searchbacloo.html.twig', array(
						// 'id' => $id,
						// 'toc' => $toc,
						// 'mode' => $mode,
						// 'page' => $page,
						// 'nombrePage' => ceil(count($fiche)/$nbparpage),
						// 'resultats' => $fiche,
						// 'form' => $form->createView()
				// ));
// echo 'lalarrrrrrr';	
			
			}
		}
$grant = 'nok';	//echo 'besoin2'.$besoin;echo 'activite'.$activite;echo 'departement'.$departement;
$em3 = $this->getDoctrine()
		    ->getManager()
		    ->getRepository('BaclooCrmBundle:Prospotbacloo');
$prospo2 = $em3->findByAcheter('1');$em->clear();
$countselect =count($prospo2); //echo '$countselect'.$countselect;  
$nbresultats = $c;//echo 'nbresult'.$nbresultats;
$limitebasse = ($nbparpage*$page)-$nbparpage;//echo 'limitebasse'.$limitebasse;
$limitehaute = ($nbparpage*$page)+1;//echo 'limitehaute'.$limitehaute;
		$em2 = $this->getDoctrine()
				   ->getManager()
				   ->getRepository('BaclooCrmBundle:Prospectsbacloo');
		$prospota2 = $em2->findOneByUserid($uid);		
//echo 'countprospoota2'.count($prospota2);		
			// On créé le formulaire	
			$form = $this->createForm(new ProspectsbaclooType(), $prospota2);
echo 'return5';	
return $this->render('BaclooCrmBundle:Crm:showbacloo_list.html.twig', array(
				'form'    		  => $form->createView(),
				'id'	  	      => $id,
				'countselect'	  => $countselect,
				'nbresultats'	  => $nbresultats,
				'mode'	  		  => $mode,
				'limitebasse'	  => $limitebasse,
				'limitehaute'	  => $limitehaute,
				'nombrePage' 	  => ceil(count($fiche)/$nbparpage),
				'page'	  	 	  => $page,
				'grant'	  		  => $grant));
									

	}
