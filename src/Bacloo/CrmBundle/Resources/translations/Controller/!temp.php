<?php
 public function voirAction($id, $mode, Request $request)
  {
	$objUser = $this->get('security.context')->getToken()->getUsername(); 
	$userid = $this->get('security.context')->getToken()->GetUser()->getId(); 
	if(empty($objUser) or !isset($objUser) or $objUser == 'anon.')
	{
		return $this->redirect($this->generateUrl('fos_user_security_login'));
	}	

			$session = new Session();
			$session = $request->getSession();
// echo 'iidddddooo'.$session->get('id');
			// définit et récupère des attributs de session
			$session->set('idfiche', $id);
			$session->set('init', '1');//on est en recherche
// echo 'view session'.$session->get('view');			
			$vue = $session->get('vue');
			$pid = $session->get('id');
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

			$em = $this->getDoctrine()->getManager();
			$fiche_sel  = $em->getRepository('BaclooCrmBundle:Fiche')		
						   ->find($id);

			$listfichesvendables  = $em->getRepository('BaclooCrmBundle:Fichesvendables')		
						   ->findByFicheid($id);	

			$listintfiche2  = $em->getRepository('BaclooCrmBundle:interresses')		
						   ->findByFicheid($id);					   
		//Partie fiche interressante   
// echo 'fonctionne';
			$tagsfiche  = $em->getRepository('BaclooCrmBundle:Fiche')		
						   ->besoinsfiche($id);	
						   
			$tabact = array(' de ',' du ',' avec ',' dans ',' pour ',' des ',' les ', ' et ', ' à ', ' au ', ' & ', ' en ', 'd\'');
			// $tabact2 = str_replace($tabact, '', $tagsfiche);
			// $splitby = array('',',');
			// $text = $tabact2;
			// $pattern = '/\s'.implode($splitby, '\s?|\s?').'\s?/';
			// $besoins = preg_split($pattern, $text, -1, PREG_SPLIT_NO_EMPTY);

			$tabactivite  = $em->getRepository('BaclooCrmBundle:Fiche')		
						   ->activitefiche($id);

			// $tabact2 = str_replace($tabact, ' ', $tabactivite);
			// $splitby = array(',');
			// $text = $tabact2;
			// echo 'text'.$text.'   ppppppp ';
			// $pattern = '/\s'.implode($splitby, '\s?|\s?').'\s?/';
			// $activite = preg_split($pattern, $text, -1, PREG_SPLIT_NO_EMPTY);		
			// $activite = explode(', ', $text);
			// print_r($activite);					   
						   
			//$besoins = preg_split("/\s|[\s,]+|\s?de\s?|\s?du\s?|\s?avec\s?|\s?dans\s?|\s?pour\s?|\s?des\s?|\s?les\s?/", $tagsfiche);
			// print_r($besoins);
			//Partie liste besoins
				if(empty($tagsfiche) && empty($tabactivite))//Si cette fiche n'a pas de besoins
				{
				//On la vire des fiches vendables
				$listintfiche  = $listfichesvendables;		
				// $listintfiche  = $em->getRepository('BaclooCrmBundle:Fichesvendables')		
							   // ->findOneByFicheid($id);

					if(isset($listintfiche))
					{echo'aaa';
						$em->remove($listintfiche);
						$em->flush();	
					}
					//On la vire des interresses
					// $listintfiche2  = $em->getRepository('BaclooCrmBundle:interresses')		
								   // ->findByFicheid($id);
					foreach($listintfiche2 as $list2)
					{echo'bbb';
					$em->remove($list2);
					$em->flush();
					}
					//On la vire des fiches prospot 
					$listintfiche3  = $em->getRepository('BaclooCrmBundle:Prospot')		
								   ->findByFicheid($id);
					foreach($listintfiche3 as $list3)
					{echo'ccc';
					$em->remove($list3);
					$em->flush();
					}
				}
				elseif(!empty($tagsfiche))//Si la fiche a des besoins renseignés
				{
					//Ménage si tags actualisés
					//echo 'adada';
					// $tagsfiche  = $em->getRepository('BaclooCrmBundle:Fiche')		
								   // ->findOneById($id);				
					//On compare avec les tags fvd
					$tagsfdv  = $listfichesvendables;
					//echo 'les tags'.$tagsfiche;
					// echo 'tag original'.$tagsfiche->getTags();
					if(isset($tagsfdv) && !empty($tagsfdv))// si la fiche est déjà dans les fiches vendables
					{
						//echo 'tag fvd'.$tagsfdv->getBesoins();
						
						if($tagsfiche != $tagsfdv->getBesoins())//les tags sont differents, on supprime la fiche des fiches vendables
						{
							if(isset($tagsfdv) && !empty($tagsfdv))//on supprime la fiche des fiches vendables
							// {//echo 'dapa';					
								$em->remove($tagsfdv);
								$em->flush();
							}

							//On la vire des interresses
							// $listintfiche2  = $em->getRepository('BaclooCrmBundle:interresses')		
										   // ->findByFicheid($id);
							if(isset($listintfiche2))
							{
								foreach($listintfiche2 as $list2)
								{									
									echo 'dapé';
										$em->remove($list2);
										$em->flush();
								}
							}
							//On la vire des fiches prospot 
							$listintfiche3  = $em->getRepository('BaclooCrmBundle:Prospot')		
										   ->findByFicheid($id);
							// print_r($listintfiche3);
							if(isset($listintfiche3))
							{							
								foreach($listintfiche3 as $list3)
								{
									echo 'dapo';	
									$em->remove($list3);
									$em->flush();
								}
							}
						}
						$listintfiche  = $em->getRepository('BaclooCrmBundle:interresses')		
						->listintfiche($id);		
					}
					else // si la fiche n'est pas déjà dans les fiches vendables
					{
						//echo '   pas de '.$tagsfiche.' dans fichesvendables '.$id;
						$listintfiche  = $em->getRepository('BaclooCrmBundle:interresses')	// affiche la liste des utilisateurs intéressés par cette fiche	
						->listintfiche($id);	
					}					
				}
				elseif(!empty($tabactivite))//Si la fiche a bien des activités renseignés
				{
					//Ménage si tags actualisés
					//echo 'adadaooooooo';
					// $tagsfiche  = $em->getRepository('BaclooCrmBundle:Fiche')		
								   // ->findOneById($id);				
					//On compare avec les tags fvd
					$tagsfdv  = $listfichesvendables;
					//echo 'les tags'.$tabactivite;
					// echo 'tag original'.$tagsfiche->getTags();
					if(isset($tagsfdv) && !empty($tagsfdv))//si la fiche est déjà dans les fiches vendables
					{
						//echo 'activite fvd'.$tagsfdv->getActivite();
						
						if($tabactivite != $tagsfdv->getActivite())//les Activités sont differents, on supprime
						{
							if(isset($tagsfdv) && !empty($tagsfdv))
							{echo 'dapa';					
								$em->remove($tagsfdv);
								$em->flush();
							}

							//On la vire des interresses
							// $listintfiche2  = $em->getRepository('BaclooCrmBundle:interresses')		
										   // ->findByFicheid($id);
							if(isset($listintfiche2))
							{
								foreach($listintfiche2 as $list2)
								{									
									echo 'dapé';
										$em->remove($list2);
										$em->flush();
								}
							}
							//On la vire des fiches prospot 
							$listintfiche3  = $em->getRepository('BaclooCrmBundle:Prospot')		
										   ->findByFicheid($id);
							// print_r($listintfiche3);
							if(isset($list3))
							{							
								foreach($listintfiche3 as $list3)
								{
									echo 'dapo';	
									$em->remove($list3);
									$em->flush();
								}
							}
						}
						$listintfiche  = $em->getRepository('BaclooCrmBundle:interresses')		
						->listintfiche($id);		
					}
					else
					{
						// echo '   pas de '.$tagsfiche->getTags().' dans fichesvendables '.$id;
					}					
				}
				else
				{
					//echo 'DODODODODOD'.$id;
					$listintfiche  = $em->getRepository('BaclooCrmBundle:interresses')		
								   ->listintfiche($id);						
				}
			

			
// echo '  décollage';
	// On récupère l'EntityManager
	$em = $this->getDoctrine()
			   ->getManager();
	// On récupère la fiche qui nous intéresse
				// $query = $em->createQuery(
					// 'SELECT f
					// FROM BaclooCrmBundle:Fiche f
					// WHERE f.id = :id'
				// );
				// $query->setParameter('id', $id);	
				
				// $fichecheck = $query->getSingleResult();
				$fichecheck = $fiche_sel;

				//On récupère les favoris niveau ALL
				$em = $this->getDoctrine()->getManager();
				$query = $em->createQuery(
						'SELECT f.favusername
						FROM BaclooCrmBundle:Favoris f
						WHERE f.favusername = :favusername
						AND f.toutpart = :toutpart'
					)->setParameter('favusername', $objUser);
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
										   ->findOneByFavusername($objUser);						
							${'choix'.$i++} = $favor->getUsername();
						}
					}
					//echo 'choix1'.$choix1;
					$critere = array($objUser);
					
					for($j=1;$j<$i;$j++)
					{
						${'critere'.$j} = array(${"choix".$j});
						$critere = array_merge(${'critere'.$j},$critere);
					}
					
				}
				else
				{
					$critere = array($objUser);
				}
				foreach($critere as $listuser)
				{
					if($fichecheck->getUser() == $listuser)
					{
						$autorisation = 'ok';
					}
				}	
				if($autorisation == 'ok')
				{
					// $query = $em->createQuery(
						// 'SELECT f
						// FROM BaclooCrmBundle:Fiche f
						// WHERE f.id = :id'
					// );
					// $query->setParameter('id', $id);	
					
					// $fiche = $query->getSingleResult();
					$fiche = $fiche_sel;
					
					$statut = 'proprio';
				}
				else
				{
					$alteruser = $em->getRepository('BaclooCrmBundle:Alteruser')		
					 ->findByFicheid($id);				
					foreach($alteruser as $ua) 
					{
						if($ua->getUsername() == $objUser)
						{			
							// $query = $em->createQuery(
								// 'SELECT f
								// FROM BaclooCrmBundle:Fiche f
								// WHERE f.id = :id'
							// );
							// $query->setParameter('id', $id);
							
							// $fiche = $query->getSingleResult();
							$fiche = $fiche_sel;
							$statut = 'collegue';
						}
						else
						{//echo 'palter';
							return $this->redirect($this->generateUrl('bacloocrm_search', array()));				
						}
					}
				}
				

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

    // On créé le formulaire
    $form = $this->createForm(new FicheType($userid), $fiche);
    $request = $this->getRequest();
    if ($request->getMethod() == 'POST') {
// echo 'pos';
		$form->bind($request);
		if ($form->isValid()) {
		//echo '  form valide';
	  if($form['memo']['texte']->getData() == 'ezmemeo')
	  {
		// echo 'eureka';
	  }
	  else
	  {
		//echo 'pok';
	  }
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
        // --- Comme on a des manytomany imbriqués dans le formulaire - 3/3 ---

		
        // on persiste que si brappels pas dans bdd
        foreach ($listeBr as $originalBr) {//echo 'compar brappels';
          foreach ($form->get('brappels')->getData() as $rb) {
			// Si pas de rappel en bdd et rb existe: On persist
			if(empty($originalBr) && !empty($rb)){
			// On persiste les brappels et autres (propriétaire) maintenant que $fiche a un id
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
			foreach ($form->get('alteruser')->getData() as $ua) {//chaque alteruser envoyé par le formulaire
// echo 'foreach alter';			//Début partie contrôle insertion
				if(isset($ua))
				{
					// echo ' ua estset '.$ua->getUsername();		
					//On contrôle alteruser popsté pas présent en bdd Alter user
					$controlealteruser = $em->getRepository('BaclooCrmBundle:Alteruser')		
					 ->findOneByUsername($ua->getUsername());
					 
					//On regarde s'il fait parti des favoris
					$controlefavori = $em->getRepository('BaclooCrmBundle:Favoris')		
					 ->findOneByfavusername($ua->getUsername());		 

					 //si new alter user pas dans table alteruser mais pas dans favoris
					if(!isset($controlefavori))
					{echo 'user pas dans favoris';
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
						// Récupération du service
						$mailer = $this->get('mailer');				
						
							$message = \Swift_Message::newInstance()
								->setSubject($destinataire->getPrenom(). ' : '.$objUser.' a partagé un de ses prospects qualifié avec vous')
								->setFrom(array('bacloo@bacloo.fr' => 'Bacloo CRM'))
								->setTo('toto@toto.com')
								->setBody($this->renderView('BaclooCrmBundle:Crm:new_fichepartage.html.twig', array('nom' 		=> $expediteur->getNom(), 
																										 'prenom'	=> $expediteur->getPrenom(),
																										 'societe'	=> $fichecheck->getRaisonSociale(),
																										 'dest_prenom'	=> $destinataire->getPrenom()
																										  )))
							;
							$mailer->send($message);
							
						$mailer = $this->get('mailer');				
						
							$message = \Swift_Message::newInstance()
								->setSubject($destinataire->getPrenom(). ' : '.$objUser.' a partagé un de ses prospects qualifié avec vous')
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
				//Fin partie contrôle insertion	
// $em->flush();
				//Début Partie suppression
				
			

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
														  
								// $em->remove($controlealteruser);	//Ce remove enlève l'alteruser de la bdd				
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
							// $em->remove($ba);	//Ce remove enlève l'alteruser de la bdd				
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

		//Partie fiche interressante   
// echo 'fonctionne';
			//$tagsfiche  = $em->getRepository('BaclooCrmBundle:Fiche')//Récupère les tags de la fiche	
			//			   ->besoinsfiche($id);	
						   
	
						   
			$tabact = array(' de ',' du ',' avec ',' dans ',' pour ',' des ',' les ', ' et ', ' à ', ' au ', ' & ', ' en ', 'd\'');
			// $tabact2 = str_replace($tabact, '', $tagsfiche);
			// $splitby = array('',',');
			// $text = $tabact2;
			// $pattern = '/\s'.implode($splitby, '\s?|\s?').'\s?/';
			// $besoins = preg_split($pattern, $text, -1, PREG_SPLIT_NO_EMPTY);

			// $tabactivite  = $em->getRepository('BaclooCrmBundle:Fiche')	//Récupère l'activité de la fiche		
						   // ->activitefiche($id);

			// $tabact2 = str_replace($tabact, ' ', $tabactivite);
			// $splitby = array(',');
			// $text = $tabact2;
			// echo 'text'.$text.'   ppppppp ';
			// $pattern = '/\s'.implode($splitby, '\s?|\s?').'\s?/';
			// $activite = preg_split($pattern, $text, -1, PREG_SPLIT_NO_EMPTY);		
			// $activite = explode(', ', $text);
			// print_r($activite);					   
						   
			//$besoins = preg_split("/\s|[\s,]+|\s?de\s?|\s?du\s?|\s?avec\s?|\s?dans\s?|\s?pour\s?|\s?des\s?|\s?les\s?/", $tagsfiche);
			// print_r($besoins);
			//Partie liste besoins

				
						$query = $em->createQuery(
							'SELECT u 
							FROM BaclooUserBundle:User u
							WHERE u.username != :username
							AND u.tags is not null
							Group By u.id'
						);
						$query->setParameter('username', $objUser);
						$list_fichespot = $query->getResult();//récupère la liste des utilisateurs autres que l'utilisateur connecté				

					$i = 0;
					foreach($list_fichespot as $user)
					{// on sort la liste des utilisateurs interresses par cette fiche a partir de la table interresses
					// echo '1';
						$tagsuser = $user->getTags();//récupère les tags du user
						$tabact2 = str_replace($tabact, ' ', $tagsuser);

						$text = $tabact2;		
						$tags = explode(', ', $text);
						if (!empty($tagsuser) && isset($tagsuser))//Si l'utilisateur a bien des tags
						{
							foreach($tags as $tag)//Pour chacun des tags
								{
									//On regarde si un des tags du user corrspond à au moins un des tags de la fiche
									$findme    = $tag;//echo 'taguser'.$findme;
									$findme2    = ' '.$tag;
									$mystring1 = $tagsfiche;//echo 'tagfiche'.$mystring1;
									$pos1 = stripos($mystring1, $findme);
									$pos2 = stripos($mystring1, $findme2);
									//var_dump($pos1);
									if ($pos1 !== false && $pos2 !== false || stripos(trim($mystring1), $findme) === 0)
									{					
									// print_r($activite);						
									$i++;
									//liste des users ayant les tags de cette fiche					
									//print_r($list_fichespot);
										if(!empty($listintfiche))//si il y a des interresses dans la table interresses
										{
										//echo 'loooooooooooooooo';
											foreach($listintfiche as $lif)//Pour chaque utilisateur avec les tags de la fiche
											{
													//echo 'liiiiiiiiiiiiiiiiixxxxx';echo $id; echo $user->GetUsername();
													$fichecheck  = $em->getRepository('BaclooCrmBundle:interresses')		
																 ->findOneBy(array('ficheid'=> $id, 'username' => $user->GetUsername()));													
																 
													$fichecheck2  = $em->getRepository('BaclooCrmBundle:Prospot')		
																 ->findOneBy(array('ficheid'=> $id, 'user' => $user->GetUsername()));									

													if(!isset($fichecheck) && !isset($fichecheck2))
														{
															$today = date('Y-m-d');
															$em = $this->getDoctrine()->getManager();
															$query = $em->createQuery(
																'SELECT u
																FROM BaclooCrmBundle:interresses u
																WHERE u.username = :username
																AND u.datedeclar = :datedeclar'
															);
															$query->setParameter('datedeclar', $today);
															$query->setParameter('username', $user->GetUsername());
															$fichecheck22 = $query->getResult();
																		 
															if(empty($fichecheck22))
															{
																//echo 'laaaaaaaaaaaaaa';
																$destinataire  = $user;					
																$diff = '1';
																// Partie envoi du mail
																// Récupération du service
																$mailer = $this->get('mailer');				
																
																	$message = \Swift_Message::newInstance()
																		->setSubject('Bacloo : Nouveau prospect détecté')
																		->setFrom(array('bacloo@bacloo.fr' => 'Bacloo CRM'))
																		->setTo('toto@toto.com')
																		->setBody($this->renderView('BaclooCrmBundle:Crm:new_opp.html.twig', array('dest_prenom'	=> $destinataire->getPrenom(),
																																				 'activite'	=> 'nok',
																																				 'besoin'	=> $tag,
																																				 'diff'	=> $diff
																																				  )))
																	;
																	$mailer->send($message);
																	
																$mailer = $this->get('mailer');				
																
																	$message = \Swift_Message::newInstance()
																		->setSubject('Bacloo : Nouveau prospect détecté1')
																		->setFrom(array('bacloo@bacloo.fr' => 'Bacloo CRM'))
																		->setTo('ringuetjm@gmail.com')
																		->setBody($this->renderView('BaclooCrmBundle:Crm:new_opp.html.twig', array('dest_prenom'	=> $destinataire->getPrenom(),
																																				 'activite'	=> 'nok',
																																				 'besoin'	=> $tag,
																																				 'diff'	=> $diff
																																				  )))
																	;
																	$mailer->send($message);
															}
																//echo 'aquiiiiiiiiiiiiii';
															// Fin partie envoi mail
																$interresses = new interresses();
																$interresses->setFicheid($id);
																$interresses->setNom($user->GetNom());
																$interresses->setPrenom($user->GetPrenom());
																$interresses->setUsername($user->GetUsername());
																$interresses->setActivite($user->GetActivite());
																$interresses->setDescRech($user->GetDescRech());
																$interresses->setTags($user->GetTags());	
																$interresses->setActvise($user->GetActvise());	
																$interresses->setDatedeclar($today);
																$interresses->setProprio($objUser);	
																$em = $this->getDoctrine()->getManager();
																$em->persist($interresses);
																$em->flush();																		
														}
														else
														{
															// echo 'meeeeeeeeeeeeeeeeeeeerde';
														}
											}
										}
										else // si pas d'interressés dans la table
										{
										//echo 'la';
										//si pas encore d'interresses dans la table interresses
											// foreach($list_fichespot as $user)//Pour chaque utilisateur de la base
											// {
													//On regarde si l'utilisateur est présent dans la table intéressé
													$fichecheck  = $em->getRepository('BaclooCrmBundle:interresses')		
																 ->findOneBy(array('ficheid'=> $id, 'username' => $user->GetUsername()));
													
													//On regarde si la fiche a déjà été proposée à cet utilisateur													
													$fichecheck2  = $em->getRepository('BaclooCrmBundle:Prospot')		
																 ->findOneBy(array('ficheid'=> $id, 'user' => $user->GetUsername()));									

													if(!isset($fichecheck) && !isset($fichecheck2))//si cette fiche n'a jamais été proposée
													{
													//On check si un mail n'a pas déjà été envoyé à cet utilisateur aujourd'hui
													$today = date('Y-m-d');
													$em = $this->getDoctrine()->getManager();
													$query = $em->createQuery(
														'SELECT u
														FROM BaclooCrmBundle:interresses u
														WHERE u.username = :username
														AND u.datedeclar = :datedeclar'
													);
													$query->setParameter('datedeclar', $today);
													$query->setParameter('username', $user->GetUsername());
													$fichecheck22 = $query->getResult();
													
													//Si aucun mail n'a été envoyé à l'utilisaeur aujourd'hui >>> GO !!!													
													if(empty($fichecheck22))
													{											
														$destinataire  = $user;					
														$diff = '1';
														// Partie envoi du mail
														// Récupération du service
														$mailer = $this->get('mailer');				
														
																$message = \Swift_Message::newInstance()
																	->setSubject('Bacloo : Nouveau prospect détecté')
																	->setFrom(array('bacloo@bacloo.fr' => 'Bacloo CRM'))
																	->setTo('toto@toto.com')
																	->setBody($this->renderView('BaclooCrmBundle:Crm:new_opp.html.twig', array('dest_prenom'	=> $destinataire->getPrenom(),
																																			 'activite'	=> 'nok',
																																			 'besoin'	=> $tag,
																																			 'diff'	=> $diff
																																			  )))
															;
															$mailer->send($message);
															
														$mailer = $this->get('mailer');				
														
																$message = \Swift_Message::newInstance()
																	->setSubject('Bacloo : Nouveau prospect détecté2')
																	->setFrom(array('bacloo@bacloo.fr' => 'Bacloo CRM'))
																	->setTo('ringuetjm@gmail.com')
																	->setBody($this->renderView('BaclooCrmBundle:Crm:new_opp.html.twig', array('dest_prenom'	=> $destinataire->getPrenom(),
																																			 'activite'	=> 'nok',
																																			 'besoin'	=> $tag,
																																			 'diff'	=> $diff
																																			  )))
															;
															$mailer->send($message);
													}
														// Fin partie envoi mail
													//echo 'liiiiiiiiiiiiiii';
													$interresses = new interresses();
													$interresses->setFicheid($id);
													$interresses->setNom($user->GetNom());
													$interresses->setPrenom($user->GetPrenom());
													$interresses->setUsername($user->GetUsername());
													$interresses->setActivite($user->GetActivite());
													$interresses->setDescRech($user->GetDescRech());
													$interresses->setTags($user->GetTags());	
													$interresses->setActvise($user->GetActvise());	
													$interresses->setDatedeclar($today);		
													$interresses->setProprio($objUser);
													$em = $this->getDoctrine()->getManager();
													$em->persist($interresses);
													$em->flush();
													}

											//}				
										}
									}
								}
							}
					}
					
						



			//Fin partie liste
			
			//Partie liste activite
				if(!empty($tabactivite))//Si cette fiche a une activite
				{
					$listintfiche  = $em->getRepository('BaclooCrmBundle:interresses')		
								   ->listintfiche($id);	
								   
						$query = $em->createQuery(
							'SELECT u 
							FROM BaclooUserBundle:User u
							WHERE u.username != :username
							AND u.actvise is not null
							Group By u.id'
						);
						$query->setParameter('username', $objUser);
						$list_fichespot = $query->getResult();					

					$i = 0;
					foreach($list_fichespot as $user)
					{// on sort la liste des utilisateurs interresses par cette fiche a partir de la table interresses
					// echo '2';
						$tagsuser = $user->getActvise();
						$tabact2 = str_replace($tabact, ' ', $tagsuser);

						$text = $tabact2;		
						$tags = explode(', ', $text);
						if (!empty($tagsuser) && isset($tagsuser))
						{
							foreach($tags as $tag)
								{
								
									$findme    = $tag;
									$findme2    = ' '.$tag;
									$mystring1 = $tabactivite;
									$pos1 = stripos($mystring1, $findme);
									$pos2 = stripos($mystring1, $findme2);
									//var_dump($pos1);
									if ($pos1 !== false && $pos2 !== false || stripos(trim($mystring1), $findme) === 0)
									{					
									// print_r($activite);						
									$i++;//echo 'ajoutttt';
									//liste des users ayant les tags de cette fiche					
									//print_r($list_fichespot);
										if(!empty($listintfiche))//si il y a des interresses dans la table interresses
										{
												foreach($listintfiche as $lif)//ON regarde s'il est présent dans la table interresses
												{//echo 'addd';
													$fichecheck  = $em->getRepository('BaclooCrmBundle:interresses')		
																 ->findOneBy(array('ficheid'=> $id, 'username' => $user->GetUsername()));
													// if(isset($fichecheck)){echo 'seeeeet';}else{echo 'pas issset';}			 
													$fichecheck2  = $em->getRepository('BaclooCrmBundle:Prospot')		
																 ->findOneBy(array('ficheid'=> $id, 'user' => $user->GetUsername()));									
													// echo $tag.'1';										
													// if(isset($fichecheck2)){echo 'seeeeet2';}else{echo 'pas issset2';}	
													if(!isset($fichecheck) && !isset($fichecheck2))
														{
															$today = date('Y-m-d');
															$em = $this->getDoctrine()->getManager();
															$query = $em->createQuery(
																'SELECT u
																FROM BaclooCrmBundle:interresses u
																WHERE u.username = :username
																AND u.datedeclar = :datedeclar'
															);
															$query->setParameter('datedeclar', $today);
															$query->setParameter('username', $user->GetUsername());
															$fichecheck22 = $query->getResult();
																		 
															if(empty($fichecheck22))
															{												
															// echo 'gooooo';
																$destinataire  = $user;					
																$diff = '1';
																// Partie envoi du mail
																// Récupération du service
																$mailer = $this->get('mailer');				
																
																	$message = \Swift_Message::newInstance()
																		->setSubject('Bacloo : Nouveau prospect détecté')
																		->setFrom(array('bacloo@bacloo.fr' => 'Bacloo CRM'))
																		->setTo('toto@toto.com')
																		->setBody($this->renderView('BaclooCrmBundle:Crm:new_opp.html.twig', array('dest_prenom'	=> $destinataire->getPrenom(),
																																				 'activite'	=> $tag,
																																				 'besoin'	=> 'nok',
																																				 'diff'	=> $diff
																																				  )))
																	;
																	$mailer->send($message);
																	
																$mailer = $this->get('mailer');				
																
																	$message = \Swift_Message::newInstance()
																		->setSubject('Bacloo : Nouveau prospect détecté3')
																		->setFrom(array('bacloo@bacloo.fr' => 'Bacloo CRM'))
																		->setTo('ringuetjm@gmail.com')
																		->setBody($this->renderView('BaclooCrmBundle:Crm:new_opp.html.twig', array('dest_prenom'	=> $destinataire->getPrenom(),
																																				 'activite'	=> $tag,
																																				 'besoin'	=> 'nok',
																																				 'diff'	=> $diff
																																				  )))
																	;
																	$mailer->send($message);
															}
	//echo 'diiiiiiiiiiii';
															// Fin partie envoi mail
																$interresses = new interresses();
																$interresses->setFicheid($id);
																$interresses->setNom($user->GetNom());
																$interresses->setPrenom($user->GetPrenom());
																$interresses->setUsername($user->GetUsername());
																$interresses->setActivite($user->getActivite());
																$interresses->setDescRech($user->GetDescRech());
																$interresses->setTags($user->getTags());	
																$interresses->setActvise($user->GetActvise());		
																$interresses->setProprio($objUser);	
																$interresses->setDatedeclar($today);	
																$em = $this->getDoctrine()->getManager();
																$em->persist($interresses);
																$em->flush();																		
														}
													
												}
											
										}
										else
										{
										//si pas encore d'interresses dnas la table interresses
													$fichecheck  = $em->getRepository('BaclooCrmBundle:interresses')		
																 ->findOneBy(array('ficheid'=> $id, 'username' => $user->GetUsername()));
													// if(isset($fichecheck)){echo 'seeeeet3';}else{echo 'pas issset3';}			 
													$fichecheck2  = $em->getRepository('BaclooCrmBundle:Prospot')		
																 ->findOneBy(array('ficheid'=> $id, 'user' => $user->GetUsername()));									
													// if(isset($fichecheck2)){echo 'seeeeet4';}else{echo 'pas issset4';}											
	// echo $tag.'2 ';
													if(!isset($fichecheck) && !isset($fichecheck2))
													{
															$today = date('Y-m-d');
															$em = $this->getDoctrine()->getManager();
															$query = $em->createQuery(
																'SELECT u
																FROM BaclooCrmBundle:interresses u
																WHERE u.username = :username
																AND u.datedeclar = :datedeclar'
															);
															$query->setParameter('datedeclar', $today);
															$query->setParameter('username', $user->GetUsername());
															$fichecheck22 = $query->getResult();
																 
														if(empty($fichecheck22))
														{													
															$destinataire  = $user;			
															$diff = '1';
															$dejaajoute = 'oui';
															// Partie envoi du mail
															// Récupération du service
															$mailer = $this->get('mailer');				
															
																$message = \Swift_Message::newInstance()
																	->setSubject('Bacloo : Nouveau prospect détecté')
																		->setFrom(array('bacloo@bacloo.fr' => 'Bacloo CRM'))
																		->setTo('toto@toto.com')
																		->setBody($this->renderView('BaclooCrmBundle:Crm:new_opp.html.twig', array('dest_prenom'	=> $destinataire->getPrenom(),
																																				 'activite'	=> $tag,
																																				 'besoin'	=> 'nok',
																																				 'diff'	=> $diff
																																				  )))
																;
																$mailer->send($message);
																
															$mailer = $this->get('mailer');				
															
																$message = \Swift_Message::newInstance()
																	->setSubject('Bacloo : Nouveau prospect détecté5')
																		->setFrom(array('bacloo@bacloo.fr' => 'Bacloo CRM'))
																		->setTo('ringuetjm@gmail.com')
																		->setBody($this->renderView('BaclooCrmBundle:Crm:new_opp.html.twig', array('dest_prenom'	=> $destinataire->getPrenom(),
																																				 'activite'	=> $tag,
																																				 'besoin'	=> 'nok',
																																				 'diff'	=> $diff
																																				  )))
																;
																$mailer->send($message);
														}
														//echo 'daaaaaaaaaaaaa'.$id;
														// Fin partie envoi mail
													// $em = $this->getDoctrine()->getManager();														
													$interresses = new interresses();
													$interresses->setFicheid($id);
													$interresses->setNom($user->GetNom());
													$interresses->setPrenom($user->GetPrenom());
													$interresses->setUsername($user->GetUsername());
													$interresses->setActivite($user->getActivite());
													$interresses->setDescRech($user->GetDescRech());
													$interresses->setTags($user->getTags());	
													$interresses->setActvise($user->GetActvise());	
													$interresses->setDatedeclar($today);		
													$interresses->setProprio($objUser);
													$em = $this->getDoctrine()->getManager();
													$em->persist($interresses);
													$em->flush();
													}

	// echo 'tag bingo'.$tag;													
										}
								}

								
							}
						}
					}
				}

			//Fin partie liste	
	
//!!!!!Coté fiche vendable !!!

// echo 'coté fvd';echo '$objUser'.$objUser;
//on recup fiches user co avec user interresses
$query = $em->createQuery(
	'SELECT f 
	FROM BaclooCrmBundle:interresses f
	WHERE f.proprio = :proprio
	Group By f.ficheid'
);
$query->setParameter('proprio', $objUser);	
$idficheint = $query->getResult();
// print_r($idficheint);		
	//Pour chaque id on sort la fiche
if(isset($idficheint))
{
// {echo '  nfvd isset';	
// on a notre tableau de fiches vendables
		foreach($idficheint as $idfiche)
		{				
			//echo 'listefvd';
			//On récupère les fiches de l'utilisateur co qui sont dans Fichesvendables
			$em = $this->getDoctrine()->getManager();
			$query = $em->createQuery(
				'SELECT f
				FROM BaclooCrmBundle:Fichesvendables f
				WHERE f.vendeur = :vendeur'
			)->setParameter('vendeur', $objUser);
			$fichesvendablesuco = $query->getResult();	
					
							if(!empty($fichesvendablesuco))//si le user a des fiches dans fiche vendables
							{		//echo'fvd plein';	

			$fiche2 = $em->getRepository('BaclooCrmBundle:Fiche')		
								 ->findById($idfiche->getFicheid());
			// if(!empty($fichesvendables)){echo'ok';}else{echo'nok';}echo $idfiche->getFicheid();														 
						
								foreach($fiche2 as $fic2)// pour chaque fiche vendables
								{//echo'$fic2->GetUser()'.$fic2->GetUser();
								// on récup l'email du user pour l'insérer dans fichesvendables
								$em = $this->getDoctrine()
										   ->getManager();		
										$query = $em->createQuery(
											'SELECT u.email
											FROM BaclooUserBundle:User u
											WHERE u.username = :username'
										)->setParameter('username', $fic2->GetUser());
										$mail = $query->getSingleScalarResult();
								
									foreach($fichesvendablesuco as $fichesvendable)
									{//if 1.si nouvelle fiche vendable déjà dans la table fichesvendables et besoins différents
										 //else 2.si nouvelle fiche vendable pas dans la table fichesvendables
										if($fic2->getTags() != $fichesvendable->getBesoins() && $fic2->getRaisonSociale() == $fichesvendable->getRaisonsociale() && $fic2->getUser() == $fichesvendable->getVendeur())// Si les besoins ,la rs et le vendeur de la nouvelle fiche correspond à une fiche dejà enregistrée
										{//on cherche prospect table Fichesvendables qui correspond à cette fiche trouvée
										
											$em = $this->getDoctrine()
													   ->getManager()
													   ->getRepository('BaclooCrmBundle:Fichesvendables');
											$ficheacorriger = $em->findOneBy(array('raisonsociale' => $fichesvendable->GetRaisonsociale(), 'vendeur'=>$fichesvendable->getVendeur()));
											
											$ficheacorriger->setBesoins($fic2->getTags());
											$ficheacorriger->setActivite($fic2->getActivite());
											$em = $this->getDoctrine()->getManager();
											$em->flush();
										}

										$em = $this->getDoctrine()->getManager();


										// $query = $em->createQuery(
											// 'SELECT f
											// FROM BaclooCrmBundle:Fiche f
											// WHERE f.tags = :tags
											// AND f.id = : id'
										// );
										// $query->setParameter('tags', '');
										// $query->setParameter('id', $fichesvendable->getId());
										// $ficheasuppr = $query->getSingleScalarResult();			
										// if(empty($ficheasuppr))// Si les besoins ,la rs et le vendeur de la nouvelle fiche correspond à une fiche dejà enregistrée
										// {//on cherche prospect table Fichesvendables qui correspond à cette fiche trouvée
										// echo 'doit etre la';
											// $em = $this->getDoctrine()
													   // ->getManager()
													   // ->getRepository('BaclooCrmBundle:Fichesvendables');
											// $ficheasuppr = $em->findOneBy(array('raisonsociale' => $fichesvendable->GetRaisonsociale(), 'vendeur'=>$fichesvendable->getVendeur()));
											
											// $em = $this->getDoctrine()->getManager();
											// $em->remove($ficheasuppr);
											// $em->flush();
										// }

										$em = $this->getDoctrine()->getManager();
										$query = $em->createQuery(
											'SELECT f
											FROM BaclooCrmBundle:Fichesvendables f
											WHERE f.raisonsociale = :raisonsociale'
										)->setParameter('raisonsociale', $fic2->getRaisonsociale());
										$compar_fichesvendablesuco = $query->getResult();									
										
										if(empty($compar_fichesvendablesuco)) // on rajoute
										{


																//On enregistre la fiche dans Fichesvendables
																$fichesvendables = new fichesvendables();
																$fichesvendables->setRaisonsociale($fic2->GetRaisonSociale());
																$fichesvendables->setActivite($fic2->GetActivite());
																$fichesvendables->setBesoins($fic2->GetTags());
																$fichesvendables->setCp($fic2->GetCp());
																$fichesvendables->setVille($fic2->GetVille());
																$fichesvendables->setVendeur($fic2->GetUser());
																$fichesvendables->setVemail($mail);										
																$fichesvendables->setFicheid($fic2->GetId());												
																
																	$em->persist($fichesvendables);	
																	$em->flush();												
										}
									}
								}
								
		//Suppression des fichesvendables sans tags

											 
		//On boucle sur les fiches avec une recherche par ID


					// $ficheasuppr  = $em->getRepository('BaclooCrmBundle:interresses')		
											 // ->findOneByFicheid($fichesvendable->getId());
											 // print_r($ficheasuppr);echo 'gouda'.$ficheasuppr;
							
								// foreach($fichesvendablesuco as $fichesvendable)//Requête suppression
								// {
									// foreach($fiche2 as $fic2)
									// {
									// if(isset($fic2->getId))
										// {
											// $em = $this->getDoctrine()
													   // ->getManager()
													   // ->getRepository('BaclooCrmBundle:Fichesvendables');
											// $ficheasuppr = $em->find($fic2->GetId);
																
											// $em->remove($ficheasuppr);
											
											// $em->flush;
										// }

									// }
								// }
							}
							else
							{//echo 'fvd vierge';
			$fiche2 = $em->getRepository('BaclooCrmBundle:Fiche')		
								 ->findById($idfiche->getFicheid());
			// if(!empty($fichesvendables)){echo'ok';}else{echo'nok';}echo $idfiche->getFicheid();														 
						
								foreach($fiche2 as $fic2)// pour chaque fiche vendables
								{
									//recup email pour plus tard
											$em = $this->getDoctrine()
													   ->getManager();		
													$query = $em->createQuery(
														'SELECT u.email
														FROM BaclooUserBundle:User u
														WHERE u.username = :username'
													)->setParameter('username', $fic2->GetUser());
													$mail = $query->getSingleScalarResult();							
									
											$em = $this->getDoctrine()->getManager();

																	//On enregistre la fiche dans Fichesvendables
																	$fichesvendables = new fichesvendables();
																	$fichesvendables->setRaisonsociale($fic2->GetRaisonSociale());
																	$fichesvendables->setActivite($fic2->GetActivite());
																	$fichesvendables->setBesoins($fic2->GetTags());
																	$fichesvendables->setCp($fic2->GetCp());
																	$fichesvendables->setVille($fic2->GetVille());
																	$fichesvendables->setVendeur($fic2->GetUser());
																	$fichesvendables->setVemail($mail);										
																	$fichesvendables->setFicheid($fic2->GetId());												
																	
																		$em->persist($fichesvendables);	
																		$em->flush();												
								}

							}
	}						
}			
//Fin ajout FICHE VENDABLE	


			
//Début partie suggestion de tags
			// $tabactivite  = $em->getRepository('BaclooCrmBundle:Fiche')		
						   // ->activitefiche($id);

			$tabact = array('',',',' de',' du',' avec',' dans',' pour',' des',' les', ' et', ' à', ' au', '&', ' en', 'd\'');
			$tabact2 = str_replace($tabact, '', $tabactivite);
			$splitby = array('',',');
			$text = $tabact2;
			$pattern = '/\s'.implode($splitby, '\s?|\s?').'\s?/';
			$activite = preg_split($pattern, $text, -1, PREG_SPLIT_NO_EMPTY);	
						   
			// $activite = preg_split("/[\s,]+/", $tabactivite);// éclate la liste des activités de la fiche en tableau
		
		if(!empty($tabactivite) || isset($tabactivite))//si la fiche contient au moins une activité
		{
			$i = 0;
			$listactoa1 = '';
			$listas = '';
					foreach($activite as $activit)// pour chaque activité de la fiche
					{
						$query = $em->createQuery(
							'SELECT u.tags
							FROM BaclooCrmBundle:Partenaires u
							WHERE u.partactvise LIKE :partactvise
							AND u.username = :username'
						);
						$query->setParameter('partactvise', '%'.$activit.'%');				
						$query->setParameter('username', $objUser);				
						$listag = $query->getResult();//On sort la liste des tags des users correspondant à l'activité  de la fiche
						$l = 0;
						foreach($listag as $lista)//Pour chacun des tags des utilisateurs
						{//On va reconstituer une chaine de tags à partir du tableau $listag en les séparant par une virgule
						//afin de s'assurer que chaque tag soit séparé par une virgule
						if($l == 0)
							{
							$listas .= implode(',', $lista);
							$l++;
							}
							else
							{
							$listas .= ','.implode(',', $lista);
							}
						}
						$m = 0;//echo 'listas'.$listas;
						$tagss = str_replace(", ", ",", $listas);					
						$list = explode(",", $tagss);//on transforme cette chaine en tableau
						foreach($list as $lis)//Pour chaque tag des users qui visent cette activité
						{//On récupère les tags des utilisateurs sans doublons cette fois
							$i++;//echo 'tag user'.$lis;
							${'listactoa'.$i} = '';
							$query = $em->createQuery(
								'SELECT u.tags
								FROM BaclooCrmBundle:Partenaires u
								WHERE u.partactvise LIKE :partactvise and u.tags != :tags and u.username = :username'
							);
							$query->setParameter('partactvise', '%'.$activit.'%');				
							$query->setParameter('tags', $lis);				
							$query->setParameter('username', $objUser);				
							$listact = $query->getResult(); //var_dump($listact);//liste des tags des utilisateurs visant cette activité (tableau)					
							foreach($listact as $listacto){
								if($m == 0)
									{
									${'listactoa'.$i} .= implode(',', $listacto);
									$m++;
									}
									else
									{
									${'listactoa'.$i} .= ','.implode(',', $listacto);
									}
							}//On créée une chaine de tags et plusieur listactoaX numérotés
							
							
						}
					}
					//echo 'listact2'.$listactoa1.'xxx';			//On cherche à savoir quels sont les besoins présents sur la fiche en faisant défilé chaque listactoa
								$b = 2;
			// $tagsfiches = $tagsfiche->getTags();
			// if(is_string($tagsfiche)){$tagsfiches = $tagsfiche;}else{$tagsfiches = $tagsfiche->getActivite();}
			$tabact2 = str_replace($tabact,'',$tagsfiche);
			$splitby = array('',',');
			$text = $tabact2;
			$pattern = '/\s'.implode($splitby, '\s?|\s?').'\s?/';
			$besoins = preg_split($pattern, $text, -1, PREG_SPLIT_NO_EMPTY);								
								$listactoa1 = $listactoa1;//echo 'listact'.$listactoa1;
								foreach($besoins as $beso){//pour chaque besoin de la fiche
									$c = $b-1;//echo 'beso:'.$beso.' ';
									$base = ${'listactoa'.$c};//echo 'base1'.$base;//Chaine des tags								
									${'listactoa'.$b} = str_replace(','.$beso, "", $base);//On remplace ", besoin" par ""
									$base = ${'listactoa'.$b};//echo 'base2'.$base;
									${'listactoa'.$b} = str_replace($beso.',', "", ${'listactoa'.$b});//On remplace "besoin, " par ""
									$base = ${'listactoa'.$b};//echo 'base3'.$base;
									${'listactoa'.$b} = str_replace(' '.$beso, "", $base);//On remplace "besoin, " par ""
									$base = ${'listactoa'.$b};//echo 'base4'.$base;
									${'listactoa'.$b} = str_replace($beso, "", $base);//On remplace "besoin, " par ""									
									$b++;//echo 'basetot'.$base;
									$e = $b-1;
									//On a viré les besoins de la fiche des besoins à suggérer
			
									$brutal = ${'listactoa'.$e};//La nouvelle chaine de tags sans les besoins du user
//echo ' brutal:'.$brutal;
									}					
					if(empty($brutal))
					{
						$list_tags = 'nok';
					}
					else
					{
						$tagss = str_replace(", ", ",", $brutal);
						$list_tags = explode(",",$tagss);//var_dump($list_tags);
					}
		}	
		else
		{
		$list_tags = 'nok';
		}
			//Fin partie suggestion de tags
			
			//Début partie compte interressés
			
				if(empty($tagsfiche) && empty($tabactivite))
				{
				$countinter = 0;	
				}
				else{
				$i = 0;
				$listinter = '';
				$query = $em->createQuery(
					'SELECT COUNT(i.id) as nbtags
					FROM BaclooCrmBundle:interresses i
					WHERE i.ficheid = :ficheid'
				);
				$query->setParameter('ficheid', $id);
		
				$countinter = $query->getSingleScalarResult();//compte des users interressé par cettee fiche				
				}
// echo 'xxxxxxxxxxxxxxxxxxxx'.$countinter;			
			//Fin partie compte interressés
//Fin Partie fiche interressante  
	   
        // --- Fin du cas 3/3 ---
		// nous préparons les paramètres pour le formulaire afin de savoir si le formulaire est vide ou pas
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
				
        // On définit un message flash
		
		$modules  = $em->getRepository('BaclooCrmBundle:Modules')		
					   ->findOneByUsername($objUser);
        
	  return $this->render('BaclooCrmBundle:Crm:voir.html.twig', array(
      'form'    => $form->createView(),
	  'countinter' => $countinter,
	  'list_tags' => $list_tags,
	  'id' => $fiche->getId(),
	  'societe' => $fiche->getRaisonSociale(),
      'fiche' => $fiche,
      'vue' => $vue,
	  'page' => $page,
	  'pid'	=> $pid,
	  'view' => $view,
	  'init' => $init,
	  'date' => $today,
	  'user' => $objUser,
	  'statut' => $statut,
	  'mode' => $mode,
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

// nous préparons les paramètres pour le formulaire afin de savoir si le formulaire est vide ou pas
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
							AND u.tags is not null
							Group By u.id'
						);
						$query->setParameter('username', $objUser);
						$list_fichespot = $query->getResult();					

					$i = 0;
					foreach($list_fichespot as $user)
					{// on sort la liste des utilisateurs interresses par cette fiche a partir de la table interresses
					// echo '3';
						$tagsuser = $user->getTags();
						$tabact2 = str_replace($tabact, ' ', $tagsuser);

						$text = $tabact2;		
						$tags = explode(', ', $text);
						if (!empty($tagsuser) && isset($tagsuser))
						{
							foreach($tags as $tag)
								{
									$findme    = $tag;
									$findme2    = ' '.$tag;
									$mystring1 = $tagsfiche;
									$pos1 = stripos($mystring1, $findme);
									$pos2 = stripos($mystring1, $findme2);
									$pos3 = stripos($mystring1, $findme, 0);
									//var_dump($pos1);
									if ($pos1 !== false && $pos2 !== false || $pos3 !== false)
									{					
									// print_r($activite);						
									$i++;
									//liste des users ayant les tags de cette fiche					
									//print_r($list_fichespot);
										if(isset($listintfiche))//si il y a des interresses dans la table interresses
										{//echo 'lo';
											foreach($listintfiche as $lif)//Pour chaque utilisateur avec les tags de la fiche
											{

													$fichecheck  = $em->getRepository('BaclooCrmBundle:interresses')		
																 ->findOneBy(array('ficheid'=> $id, 'username' => $user->GetUsername()));
																 
													$fichecheck2  = $em->getRepository('BaclooCrmBundle:Prospot')		
																 ->findOneBy(array('ficheid'=> $id, 'user' => $user->GetUsername()));									

													if(!isset($fichecheck) && !isset($fichecheck2))
														{
															$today = date('Y-m-d');
															$em = $this->getDoctrine()->getManager();
															$query = $em->createQuery(
																'SELECT u
																FROM BaclooCrmBundle:interresses u
																WHERE u.username = :username
																AND u.datedeclar = :datedeclar'
															);
															$query->setParameter('datedeclar', $today);
															$query->setParameter('username', $user->GetUsername());
															$fichecheck22 = $query->getResult();
																		 
															if(empty($fichecheck22))
															{														
																$destinataire  = $user;					
																$diff = '1';
																// Partie envoi du mail
																// Récupération du service
																$mailer = $this->get('mailer');				
																
																	$message = \Swift_Message::newInstance()
																		->setSubject('Bacloo : Nouveau prospect détecté')
																		->setFrom(array('bacloo@bacloo.fr' => 'Bacloo CRM'))
																		->setTo('toto@toto.com')
																		->setBody($this->renderView('BaclooCrmBundle:Crm:new_opp.html.twig', array('dest_prenom'	=> $destinataire->getPrenom(),
																																				 'activite'	=> 'nok',
																																				 'besoin'	=> $tag,
																																				 'diff'	=> $diff
																																				  )))
																	;
																	$mailer->send($message);
																	
																$mailer = $this->get('mailer');				
																
																	$message = \Swift_Message::newInstance()
																		->setSubject('Bacloo : Nouveau prospect détecté6')
																		->setFrom(array('bacloo@bacloo.fr' => 'Bacloo CRM'))
																		->setTo('ringuetjm@gmail.com')
																		->setBody($this->renderView('BaclooCrmBundle:Crm:new_opp.html.twig', array('dest_prenom'	=> $destinataire->getPrenom(),
																																				 'activite'	=> 'nok',
																																				 'besoin'	=> $tag,
																																				 'diff'	=> $diff
																																				  )))
																	;
																	$mailer->send($message);
															}
																// echo 'aquiiiiiiiiiiiiii';
															// Fin partie envoi mail
																$interresses = new interresses();
																$interresses->setFicheid($id);
																$interresses->setNom($user->GetNom());
																$interresses->setPrenom($user->GetPrenom());
																$interresses->setUsername($user->GetUsername());
																$interresses->setActivite($user->GetActivite());
																$interresses->setDescRech($user->GetDescRech());
																$interresses->setTags($user->GetTags());	
																$interresses->setActvise($user->GetActvise());	
																$interresses->setDatedeclar($today);	
																$interresses->setProprio($objUser);	
																$em = $this->getDoctrine()->getManager();
																$em->persist($interresses);
																$em->flush();																		
														}
											}
										}
										else
										{//echo 'la';
										//si pas encore d'interresses dnas la table interresses
											// foreach($list_fichespot as $user)
											// {
													$fichecheck  = $em->getRepository('BaclooCrmBundle:interresses')		
																 ->findOneBy(array('ficheid'=> $id, 'username' => $user->GetUsername()));
																 
													$fichecheck2  = $em->getRepository('BaclooCrmBundle:Prospot')		
																 ->findOneBy(array('ficheid'=> $id, 'user' => $user->GetUsername()));									

													if(!isset($fichecheck) && !isset($fichecheck2))
													{
														$today = date('Y-m-d');
														$em = $this->getDoctrine()->getManager();
														$query = $em->createQuery(
															'SELECT u
															FROM BaclooCrmBundle:interresses u
															WHERE u.username = :username
															AND u.datedeclar = :datedeclar'
														);
														$query->setParameter('datedeclar', $today);
														$query->setParameter('username', $user->GetUsername());
														$fichecheck22 = $query->getResult();
																	 
														if(empty($fichecheck22))
														{													
															$destinataire  = $user;					
															$diff = '1';
															// Partie envoi du mail
															// Récupération du service
															$mailer = $this->get('mailer');				
															
																	$message = \Swift_Message::newInstance()
																		->setSubject('Bacloo : Nouveau prospect détecté')
																		->setFrom(array('bacloo@bacloo.fr' => 'Bacloo CRM'))
																		->setTo('toto@toto.com')
																		->setBody($this->renderView('BaclooCrmBundle:Crm:new_opp.html.twig', array('dest_prenom'	=> $destinataire->getPrenom(),
																																				 'activite'	=> 'nok',
																																				 'besoin'	=> $tag,
																																				 'diff'	=> $diff
																																				  )))
																;
																$mailer->send($message);
																
															$mailer = $this->get('mailer');				
															
																	$message = \Swift_Message::newInstance()
																		->setSubject('Bacloo : Nouveau prospect détecté7')
																		->setFrom(array('bacloo@bacloo.fr' => 'Bacloo CRM'))
																		->setTo('ringuetjm@gmail.com')
																		->setBody($this->renderView('BaclooCrmBundle:Crm:new_opp.html.twig', array('dest_prenom'	=> $destinataire->getPrenom(),
																																				 'activite'	=> 'nok',
																																				 'besoin'	=> $tag,
																																				 'diff'	=> $diff
																																				  )))
																;
																$mailer->send($message);
														}
														// Fin partie envoi mail
											
														$interresses = new interresses();
														$interresses->setFicheid($id);
														$interresses->setNom($user->GetNom());
														$interresses->setPrenom($user->GetPrenom());
														$interresses->setUsername($user->GetUsername());
														$interresses->setActivite($user->GetActivite());
														$interresses->setDescRech($user->GetDescRech());
														$interresses->setTags($user->GetTags());	
														$interresses->setActvise($user->GetActvise());	
														$interresses->setDatedeclar($today);		
														$interresses->setProprio($objUser);
														$em = $this->getDoctrine()->getManager();
														$em->persist($interresses);
														$em->flush();
													}

											// }				
										}
									}
								}
							}
					}
					
						



			//Fin partie liste
			
			//Partie liste activite
				if(!empty($tabactivite))//Si cette fiche a une activite
				{
					$listintfiche  = $em->getRepository('BaclooCrmBundle:interresses')		
								   ->listintfiche($id);	
								   
						$query = $em->createQuery(
							'SELECT u 
							FROM BaclooUserBundle:User u
							WHERE u.username != :username
							Group By u.id'
						);
						$query->setParameter('username', $objUser);
						$list_fichespot = $query->getResult();					


				}

			//Fin partie liste	
	
//!!!!!Coté fiche vendable !!!

// echo 'coté fvd';echo '$objUser'.$objUser;
//on recup fiches user co avec user interresses
$query = $em->createQuery(
	'SELECT f 
	FROM BaclooCrmBundle:interresses f
	WHERE f.proprio = :proprio
	Group By f.ficheid'
);
$query->setParameter('proprio', $objUser);	
$idficheint = $query->getResult();
// print_r($idficheint);		
	//Pour chaque id on sort la fiche
if(isset($idficheint))
{
// {echo '  nfvd isset';	
// on a notre tableau de fiches vendables
		foreach($idficheint as $idfiche)
		{				
			//echo 'listefvd';
			//On récupère les fiches de l'utilisateur co qui sont dans Fichesvendables
			$em = $this->getDoctrine()->getManager();
			$query = $em->createQuery(
				'SELECT f
				FROM BaclooCrmBundle:Fichesvendables f
				WHERE f.vendeur = :vendeur'
			)->setParameter('vendeur', $objUser);
			$fichesvendablesuco = $query->getResult();	
					
							if(!empty($fichesvendablesuco))//si le user a des fiches dans fiche vendables
							{		//echo'fvd plein';	

			$fiche2 = $em->getRepository('BaclooCrmBundle:Fiche')		
								 ->findById($idfiche->getFicheid());
			// if(!empty($fichesvendables)){echo'ok';}else{echo'nok';}echo $idfiche->getFicheid();														 
						
								foreach($fiche2 as $fic2)// pour chaque fiche vendables
								{//echo'$fic2->GetUser()'.$fic2->GetUser();
								// on récup l'email du user pour l'insérer dans fichesvendables
								$em = $this->getDoctrine()
										   ->getManager();		
										$query = $em->createQuery(
											'SELECT u.email
											FROM BaclooUserBundle:User u
											WHERE u.username = :username'
										)->setParameter('username', $fic2->GetUser());
										$mail = $query->getSingleScalarResult();
								
									foreach($fichesvendablesuco as $fichesvendable)
									{//if 1.si nouvelle fiche vendable déjà dans la table fichesvendables et besoins différents
										 //else 2.si nouvelle fiche vendable pas dans la table fichesvendables
										if($fic2->getTags() != $fichesvendable->getBesoins() && $fic2->getRaisonSociale() == $fichesvendable->getRaisonsociale() && $fic2->getUser() == $fichesvendable->getVendeur())// Si les besoins ,la rs et le vendeur de la nouvelle fiche correspond à une fiche dejà enregistrée
										{//on cherche prospect table Fichesvendables qui correspond à cette fiche trouvée
										
											$em = $this->getDoctrine()
													   ->getManager()
													   ->getRepository('BaclooCrmBundle:Fichesvendables');
											$ficheacorriger = $em->findOneBy(array('raisonsociale' => $fichesvendable->GetRaisonsociale(), 'vendeur'=>$fichesvendable->getVendeur()));
											
											$ficheacorriger->setBesoins($fic2->getTags());
											$ficheacorriger->setActivite($fic2->getActivite());
											$em = $this->getDoctrine()->getManager();
											$em->flush();
										}

										$em = $this->getDoctrine()->getManager();


										// $query = $em->createQuery(
											// 'SELECT f
											// FROM BaclooCrmBundle:Fiche f
											// WHERE f.tags = :tags
											// AND f.id = : id'
										// );
										// $query->setParameter('tags', '');
										// $query->setParameter('id', $fichesvendable->getId());
										// $ficheasuppr = $query->getSingleScalarResult();			
										// if(empty($ficheasuppr))// Si les besoins ,la rs et le vendeur de la nouvelle fiche correspond à une fiche dejà enregistrée
										// {//on cherche prospect table Fichesvendables qui correspond à cette fiche trouvée
										// echo 'doit etre la';
											// $em = $this->getDoctrine()
													   // ->getManager()
													   // ->getRepository('BaclooCrmBundle:Fichesvendables');
											// $ficheasuppr = $em->findOneBy(array('raisonsociale' => $fichesvendable->GetRaisonsociale(), 'vendeur'=>$fichesvendable->getVendeur()));
											
											// $em = $this->getDoctrine()->getManager();
											// $em->remove($ficheasuppr);
											// $em->flush();
										// }

										$em = $this->getDoctrine()->getManager();
										$query = $em->createQuery(
											'SELECT f
											FROM BaclooCrmBundle:Fichesvendables f
											WHERE f.raisonsociale = :raisonsociale'
										)->setParameter('raisonsociale', $fic2->getRaisonsociale());
										$compar_fichesvendablesuco = $query->getResult();									
										
										if(empty($compar_fichesvendablesuco)) // on rajoute
										{


																//On enregistre la fiche dans Fichesvendables
																$fichesvendables = new fichesvendables();
																$fichesvendables->setRaisonsociale($fic2->GetRaisonSociale());
																$fichesvendables->setActivite($fic2->GetActivite());
																$fichesvendables->setBesoins($fic2->GetTags());
																$fichesvendables->setCp($fic2->GetCp());
																$fichesvendables->setVille($fic2->GetVille());
																$fichesvendables->setVendeur($fic2->GetUser());
																$fichesvendables->setVemail($mail);										
																$fichesvendables->setFicheid($fic2->GetId());												
																
																	$em->persist($fichesvendables);	
																	$em->flush();												
										}
									}
								}
								
		//Suppression des fichesvendables sans tags

											 
		//On boucle sur les fiches avec une recherche par ID


					// $ficheasuppr  = $em->getRepository('BaclooCrmBundle:interresses')		
											 // ->findOneByFicheid($fichesvendable->getId());
											 // print_r($ficheasuppr);echo 'gouda'.$ficheasuppr;
							
								// foreach($fichesvendablesuco as $fichesvendable)//Requête suppression
								// {
									// foreach($fiche2 as $fic2)
									// {
									// if(isset($fic2->getId))
										// {
											// $em = $this->getDoctrine()
													   // ->getManager()
													   // ->getRepository('BaclooCrmBundle:Fichesvendables');
											// $ficheasuppr = $em->find($fic2->GetId);
																
											// $em->remove($ficheasuppr);
											
											// $em->flush;
										// }

									// }
								// }
							}
							else
							{//echo 'fvd vierge';
			$fiche2 = $em->getRepository('BaclooCrmBundle:Fiche')		
								 ->findById($idfiche->getFicheid());
			// if(!empty($fichesvendables)){echo'ok';}else{echo'nok';}echo $idfiche->getFicheid();														 
						
								foreach($fiche2 as $fic2)// pour chaque fiche vendables
								{
									//recup email pour plus tard
											$em = $this->getDoctrine()
													   ->getManager();		
													$query = $em->createQuery(
														'SELECT u.email
														FROM BaclooUserBundle:User u
														WHERE u.username = :username'
													)->setParameter('username', $fic2->GetUser());
													$mail = $query->getSingleScalarResult();							
									
											$em = $this->getDoctrine()->getManager();

																	//On enregistre la fiche dans Fichesvendables
																	$fichesvendables = new fichesvendables();
																	$fichesvendables->setRaisonsociale($fic2->GetRaisonSociale());
																	$fichesvendables->setActivite($fic2->GetActivite());
																	$fichesvendables->setBesoins($fic2->GetTags());
																	$fichesvendables->setCp($fic2->GetCp());
																	$fichesvendables->setVille($fic2->GetVille());
																	$fichesvendables->setVendeur($fic2->GetUser());
																	$fichesvendables->setVemail($mail);										
																	$fichesvendables->setFicheid($fic2->GetId());												
																	
																		$em->persist($fichesvendables);	
																		$em->flush();												
								}

							}
	}						
}			
//Fin ajout FICHE VENDABLE	

									if(empty($tabactivite))//Si la fiche a des activite renseignés
									{//echo 'adada';
									// $query = $em->createQuery(
										// 'SELECT u.tags
										// FROM BaclooCrmBundle:Fiche u
										// WHERE u.id = :id'
									// );				
									// $query->setParameter('id', $id);				
									// $tagsfiche = $query->getResult();									
										// $tagsfiche  = $em->getRepository('BaclooCrmBundle:Fiche')		
													   // ->findOneById($id);				
										//On compare avec les tags fvd
										$tagsfdv  = $listintfiche;
										// echo 'les tags'.$tagsfiche->getActivite();
										// echo 'tag original'.$tagsfiche->getActivite();
										if(isset($tagsfdv) && !empty($tagsfdv))
										{
											// echo 'tag fvd'.$tagsfdv->getActivite();
											
											if($tabactivite != $tagsfdv->getActivite())//les tags sont differents, on supprime
											{
												if(isset($tagsfdv) && !empty($tagsfdv))
												{echo 'dapa';					
													$em->remove($tagsfdv);
													$em->flush();
												}
											}
												//On la vire des interresses
												// $listintfiche2  = $em->getRepository('BaclooCrmBundle:interresses')		
															   // ->findByFicheid($id);
												if(isset($listintfiche2))
												{
													foreach($listintfiche2 as $list2)
													{									
														echo 'dapé';
															$em->remove($list2);
															$em->flush();
													}
												}
												//On la vire des fiches prospot 
												$listintfiche3  = $em->getRepository('BaclooCrmBundle:Prospot')		
															   ->findByFicheid($id);
												// print_r($listintfiche3);
												if(isset($list3))
												{							
													foreach($listintfiche3 as $list3)
													{
														echo 'dapo';	
														$em->remove($list3);
														$em->flush();
													}
												}
											
										}
										else
										{
											// echo '   pas de '.$tagsfiche->getActivite().' dans fichesvendables '.$id;
										}
									}
			
//Début partie suggestion de tags
			// $tabactivite  = $em->getRepository('BaclooCrmBundle:Fiche')		
						   // ->activitefiche($id);

			$tabact = array('',',',' de',' du',' avec',' dans',' pour',' des',' les', ' et', ' à', ' au', '&', ' en', 'd\'');
			$tabact2 = str_replace($tabact, '', $tabactivite);
			$splitby = array('',',');
			$text = $tabact2;
			$pattern = '/\s'.implode($splitby, '\s?|\s?').'\s?/';
			$activite = preg_split($pattern, $text, -1, PREG_SPLIT_NO_EMPTY);	
						   
			// $activite = preg_split("/[\s,]+/", $tabactivite);// éclate la liste des activités de la fiche en tableau
		
		if(!empty($tabactivite) || isset($tabactivite))//si la fiche contient au moins une activité
		{
			$i = 0;
			$listactoa1 = '';
			$listas = '';
					foreach($activite as $activit)// pour chaque activité de la fiche
					{
						$query = $em->createQuery(
							'SELECT u.tags
							FROM BaclooCrmBundle:Partenaires u
							WHERE u.partactvise LIKE :partactvise
							AND u.username = :username'
						);
						$query->setParameter('partactvise', '%'.$activit.'%');				
						$query->setParameter('username', $objUser);				
						$listag = $query->getResult();//On sort la liste des tags des users correspondant à l'activité  de la fiche
						$l = 0;
						foreach($listag as $lista)//Pour chacun des tags des utilisateurs
						{//On va reconstituer une chaine de tags à partir du tableau $listag en les séparant par une virgule
						//afin de s'assurer que chaque tag soit séparé par une virgule
						if($l == 0)
							{
							$listas .= implode(',', $lista);
							$l++;
							}
							else
							{
							$listas .= ','.implode(',', $lista);
							}
						}
						$m = 0;//echo 'listas'.$listas;
						$tagss = str_replace(", ", ",", $listas);					
						$list = explode(",", $tagss);//on transforme cette chaine en tableau
						foreach($list as $lis)//Pour chaque tag des users qui visent cette activité
						{//On récupère les tags des utilisateurs sans doublons cette fois
							$i++;//echo 'tag user'.$lis;
							${'listactoa'.$i} = '';
							$query = $em->createQuery(
								'SELECT u.tags
								FROM BaclooCrmBundle:Partenaires u
								WHERE u.partactvise LIKE :partactvise and u.tags != :tags and u.username = :username'
							);
							$query->setParameter('partactvise', '%'.$activit.'%');				
							$query->setParameter('tags', $lis);				
							$query->setParameter('username', $objUser);				
							$listact = $query->getResult(); //var_dump($listact);//liste des tags des utilisateurs visant cette activité (tableau)					
							foreach($listact as $listacto){
								if($m == 0)
									{
									${'listactoa'.$i} .= implode(',', $listacto);
									$m++;
									}
									else
									{
									${'listactoa'.$i} .= ','.implode(',', $listacto);
									}
							}//On créée une chaine de tags et plusieur listactoaX numérotés
							
							
						}
					}
					//echo 'listact2'.$listactoa1.'xxx';			//On cherche à savoir quels sont les besoins présents sur la fiche en faisant défilé chaque listactoa
								$b = 2;
			// $tagsfiches = $tagsfiche->getTags();
			// if(is_string($tagsfiche)){$tagsfiches = $tagsfiche;}else{$tagsfiches = $tagsfiche->getActivite();}
			$tabact2 = str_replace($tabact,'',$tagsfiche);
			$splitby = array('',',');
			$text = $tabact2;
			$pattern = '/\s'.implode($splitby, '\s?|\s?').'\s?/';
			$besoins = preg_split($pattern, $text, -1, PREG_SPLIT_NO_EMPTY);								
								$listactoa1 = $listactoa1;//echo 'listact'.$listactoa1;
								foreach($besoins as $beso){//pour chaque besoin de la fiche
									$c = $b-1;//echo 'beso:'.$beso.' ';
									$base = ${'listactoa'.$c};//echo 'base1'.$base;//Chaine des tags								
									${'listactoa'.$b} = str_replace(','.$beso, "", $base);//On remplace ", besoin" par ""
									$base = ${'listactoa'.$b};//echo 'base2'.$base;
									${'listactoa'.$b} = str_replace($beso.',', "", ${'listactoa'.$b});//On remplace "besoin, " par ""
									$base = ${'listactoa'.$b};//echo 'base3'.$base;
									${'listactoa'.$b} = str_replace(' '.$beso, "", $base);//On remplace "besoin, " par ""
									$base = ${'listactoa'.$b};//echo 'base4'.$base;
									${'listactoa'.$b} = str_replace($beso, "", $base);//On remplace "besoin, " par ""									
									$b++;//echo 'basetot'.$base;
									$e = $b-1;
									//On a viré les besoins de la fiche des besoins à suggérer
			
									$brutal = ${'listactoa'.$e};//La nouvelle chaine de tags sans les besoins du user
//echo ' brutal:'.$brutal;
									}					
					if(!empty($brutal))
					{
						$tagss = str_replace(", ", ",", $brutal);
						$list_tags = explode(",",$tagss);//var_dump($list_tags);
					}
					else
					{
						$list_tags = 'nok';
					}
		}	
		else
		{
		$list_tags = 'nok';
		}
			//Fin partie suggestion de tags
			
			//Début partie compte interressés
			
				if(empty($tagsfiche) && empty($tabactivite))
				{
				$countinter = 0;	
				}
				else{
				$i = 0;
				$listinter = '';
				$query = $em->createQuery(
					'SELECT COUNT(i.id) as nbtags
					FROM BaclooCrmBundle:interresses i
					WHERE i.ficheid = :ficheid'
				);
				$query->setParameter('ficheid', $id);
		
				$countinter = $query->getSingleScalarResult();//compte des users interressé par cettee fiche				
				}
// echo 'xxxxxxxxxxxxxxxxxxxx'.$countinter;			
			//Fin partie compte interressés
//Fin Partie fiche interressante	
		
		$modules  = $em->getRepository('BaclooCrmBundle:Modules')		
					   ->findOneByUsername($objUser);	
	
    return $this->render('BaclooCrmBundle:Crm:voir.html.twig', array(
      'form'    => $form->createView(),
	  'countinter' => $countinter,
	  'list_tags' => $list_tags,
	  'id' => $fiche->getId(),
	  'societe' => $fiche->getRaisonSociale(),
      'fiche' => $fiche,
      'vue' => $vue,
	  'page' => $page,
	  'pid'	=> $pid,
	  'view' => $view,
	  'init' => $init,
	  'date' => $today,
	  'statut' => $statut,
	  'mode' => $mode,
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