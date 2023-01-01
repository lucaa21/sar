<?php	
			$em = $this->getDoctrine()->getManager();
			//On récupère le nombre de prospects de ce user
			$prospinit  = $em->getRepository('BaclooCrmBundle:Prospot')		
							 ->findByUser($usersess);
			$nbprospotinit = count($prospinit);

			$userdetails  = $em->getRepository('BaclooUserBundle:User')		
						   ->findOneByUsername($usersess);

			$splitby = array('',',',', ',' , ',' ,','de ','du ','avec ','dans ','pour ','d\'','des ','les ');
			$text    = $userdetails->getTags();
			$pattern = '/\s'.implode($splitby, '\s?|\s?').'\s?/';
			$tagsu   = preg_split($pattern, $text, -1, PREG_SPLIT_NO_EMPTY);

			//On récupère les activités visées de l'utilisateur
			$actvise   = $userdetails->getTags();
			$activisse = str_replace(", ", ",", $actvise);
			$actv	   = explode(",", $activisse);					

			//DEBUT MENAGE TABLE PROSPOT au cas ou le user a modif/suppr ses tags ou actvise
			//!!!!!Verifier s'il y a des occurences des môts clés actuels dans les prospo et virer tous les 
			//prospo qui n'ont pas d'occurence. Pour ce faire exploser les mots clés comme dnas la recherche de prospot dans fiche
			// et à chaque itération faire le remove.
			
			if(empty($tagsu) && empty($actv))//Si le user n'a pas de tags et d'activités visées
				{
					//echo 'tagsu vide';
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
				else // S'il a des tags OU des activités visées : on vire les prospot qui n'ont plus de correspondance
				{
					//echo 'tagsu pas vide';
					//On fait la même pour chacun des tags					
					foreach($prospinit as $prospi)
					{
						$p = 0;
						foreach($tagsu as $tags)
						{//echo $tags; echo ' vs '.$prospi->getBesoins();
							if(stristr($prospi->getBesoins(), $tags))//si la chaine de caractère commence pas le tag
							{
								$p = 1;
							}							
						}
						foreach($actv as $act)
						{//echo $tags; echo ' vs '.$prospi->getBesoins();
							if(stristr($prospi->getActivite(), $act))//si la chaine de caractère commence pas le tag
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
												
			//Début ajout des prospects					
				if(empty($tagsu) && empty($actv)){
					$fiche = 0;//si pas de tags alors pas de prospects
				}
				else //s'il a des tags ou des actvises => on insère
				{
					//On récupère l'array avec  les prospot
					//echo 't la';
					$fiches = $em->getRepository('BaclooCrmBundle:Fiche')
								->prospotlist($tagsu, $actv, $usersess, $nombreParPage, $page);// on obtient la liste des prospects
								
					//On slice cet array
					$nbresultats = $nbresult;
					$limitebasse = ($nbparpage*$page)-$nbparpage;echo 'limitebasse'.$limitebasse;
					$limitehaute = ($nbparpage*$page)+1;echo 'limitehaute'.$limitehaute;
					$fiche = array_slice($fiches, $limitebasse, $limitehaute);
				}					
		
				//On récupère l'id de l'utilisateur connecté
				$uid = $userdetails->getId();	

				//On regarde si l'utilisateur connecté est déja entegistré dnas la table prospects
				$em2 = $this->getDoctrine()
						   ->getManager()
						   ->getRepository('BaclooCrmBundle:Prospects');
				$prospects = $em2->findOneByUserid($uid);
				
				//On récupère les anciens prospot proposés à l'utilisateur connecté
				$em = $this->getDoctrine()
						   ->getManager()
						   ->getRepository('BaclooCrmBundle:Prospot');
				$prospotaa = $em->findByUser(array(
											'user'=>$usersess,
											'voir'=>'ok'));	
	
			if(empty($prospects))//Si utilisateur pas enregistré dans prospect
			{
				//On enregistre le userid dans prospects
				$prospects = new Prospects();
				$prospects->setUserid($uid);
				$em = $this->getDoctrine()->getManager();
				$em->persist($prospects);
		
			}
			
			//Maintenant que prospect a son uid on enregistre les prospots
			//pour chaque prospect proposé, on regarde s'il a déjà été proposé
		if(isset($fiche) && !empty($fiche))
		{
			$em2 = $this->getDoctrine()
					   ->getManager()
					   ->getRepository('BaclooCrmBundle:Prospot');
			$prospot = $em2->findByUser($usersess);
			$countprospot = count($prospot);

			// si le nombre de prospot est inférieur au nombre de résultats on insère
			if(count($fiches) > $countprospot)
			{				
				foreach($fiche as $i => $fic)// pour chaque fiche trouvée
				{
					if(isset($prospotaa) && !empty($prospotaa))// Si des prospects lui ont deja été proposés on compare aux nouveaux avant d'ajouter
					{//on cherche prospect bdd qui correspond a prospect trouvé
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
							
								//Si prospect pas encore dans la base on insere
								if(empty($prospotok) && $fic->GetUser() != $usersess) // si nouveau prospect pas dans prospot ni dans table prospects
								{//echo 'empty prospotok';
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
									$prospot->setVoir('ok');
									$prospot->addProspect($prospects);
									$prospects->addProspot($prospot);

									$em->persist($prospot);	
									$em->persist($prospects);
									$em->flush();
									$em->clear();											
																		
								}
								elseif(!empty($prospotok)) // si nouveau prospect déjà dans prospot mais user dans table prospects
								{
									if($fic->getTags() != $prospotok->getBesoins())// Si les besoins  ont été mis à jour
									{
										$prospotok->setBesoins($fic->getTags());
										$prospotok->SetVoir('ok');
									}										
									elseif($fic->getActivite() != $prospotok->getActivite())// Si les activités  ont été mises à jour
									{
										$prospotok->setActivite($fic->getActivite());
										$prospotok->SetVoir('ok');
									}										
									elseif($fic->getAVendre() != $prospotok->getAvendre())// Si statut à vendre a changé
									{
										$prospotok->setAvendre($fic->getAvendre());
										$prospotok->setPrixsscont($fic->getPrixsscont());
										$prospotok->SetVoir('ok');
									}										
									elseif($fic->getAVendrec() != $prospotok->getAvendrec())// Si statut à vendre a changé
									{
										$prospotok->setAvendrec($fic->getAvendrec());
										$prospotok->setPrixavcont($fic->getPrixavcont());
										$prospotok->SetVoir('ok');
									}
									elseif($fic->getPrixsscont() != $prospotok->getPrixsscont())// Si prix sans contact a changé
									{
										$prospotok->setPrixsscont($fic->getPrixsscont());
										$prospotok->SetVoir('ok');
									}
									elseif($fic->getPrixavcont() != $prospotok->getPrixavcont())// Si prix avec contact a changé
									{
										$prospotok->setPrixavcont($fic->getPrixavcont());
										$prospotok->SetVoir('ok');
									}										
								}

					}
					else //Si aucun prospect ne lui a été proposé précédemment cad qu'on ne trouve l'utilisateur ni dans prospects, ni dans prospot
					{		

					//on cherche prospect bdd qui correspond a prospect trouvé
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
							
							if(empty($prospotok)  && $fic->GetUser() != $usersess) // si nouveau prospect pas dans prospot ni dans table prospects
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
								$prospot->setVoir('ok');
								$prospot->addProspect($prospects);
								$prospects->addProspot($prospot);
								
								$em->persist($prospot);	
								$em->persist($prospects);	
								$em->flush();
								$em->clear();
							}			
					}
				}
			}
		}				
// FIN COTE AJOUT Prospects	

//ficherepository
	public function prospotlist($tags, $actv, $user, $nombreParPage, $page)
	{
		// On déplace la vérification du numéro de page dans cette méthode
		if ($page < 1) {
		throw new \InvalidArgumentException('L\'argument $page ne peut être inférieur à 1 (valeur : "'.$page.'").');
		}
			
		$i = 0;
		$count_tag = '';
		if(!empty($tags))
		{
			foreach($tags as $tag)
			{	
				$i++;
				if($i == 1)
				{
					$qb = $this->createQueryBuilder('f');
					$qb->where('f.user != :user')
						->setParameters(array('user' => $user, 'user' => 'x'));	
					// $qb->andwhere('f.user != :user');
					// $qb->setParameter('user', 'x');		
					$qb->andwhere('f.tags LIKE :tags');
					$qb->setParameter('tags', '%'.$tag.'%');
					$count_ta = $qb->getQuery()->getResult();
					${'array_tags'.$i} = $count_ta;
				}
				else
				{
					$qb = $this->createQueryBuilder('f');
					$qb->where('f.user != :user')
						->setParameters(array('user' => $user, 'user' => 'x'));	
					// $qb->andwhere('f.user != :user');
					// $qb->setParameter('user', 'x');		
					$qb->andwhere('f.tags LIKE :tags');
					$qb->setParameter('tags', '%'.$tag.'%');
					$count_ta = $qb->getQuery()->getResult();
					$j = $i-1;
					$array_tags = ${'array_tags'.$j};
					${'array_tags'.$i} = array_merge($array_tags,$count_ta);				
				}
			}
		}
		if($actv != 0)
		{
			foreach($actv as $act)
			{$i++;
				if($i == 1)
				{
					$qb = $this->createQueryBuilder('f');
					$qb->where('f.user != :user')
						->setParameters(array('user' => $user, 'user' => 'x'));	
					// $qb->andwhere('f.user != :user');
					// $qb->setParameter('user', 'x');		
					$qb->andwhere('f.activite LIKE :activite');
					$qb->setParameter('activite', '%'.$tag.'%');
					$count_ta = $qb->getQuery()->getResult();
					${'array_tags'.$i} = $count_ta;
				}
				else
				{		
					$qb = $this->createQueryBuilder('f');
					$qb->where('f.user != :user')
						->setParameters(array('user' => $user, 'user' => 'x'));	
					// $qb->andwhere('f.user != :user');
					// $qb->setParameter('user', 'x');		
					$qb->andwhere('f.activite LIKE :activite');
					$qb->setParameter('activite', '%'.$act.'%');
					$count_ta = $qb->getQuery()->getResult();
					$j = $i-1;
					$array_tags = ${'array_tags'.$j};
					${'array_tags'.$i} = array_merge($array_tags,$count_ta);
				}
			}
		}
		$list_fichespot = ${'array_tags'.$i};
		return $list_fichespot;	
	}
