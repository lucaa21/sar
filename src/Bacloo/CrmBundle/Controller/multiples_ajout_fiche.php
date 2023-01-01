<?php


						$query = $em->createQuery(
							'SELECT u 
							FROM BaclooUserBundle:User u
							WHERE u.username != :username
							Group By u.id'
						);
						$query->setParameter('username', $objUser);
						$list_fichespot = $query->getResult();					

					$i = 0;
					foreach($list_fichespot as $user)
					{// on sort la liste des utilisateurs interresses par cette fiche a partir de la table interresses
					
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
																																			 'activite'	=> 'nok',
																																			 'besoin'	=> $tag,
																																			 'diff'	=> $diff
																																			  )))
																;
																$mailer->send($message);
																
															$mailer = $this->get('mailer');				
															
																$message = \Swift_Message::newInstance()
																	->setSubject('Bacloo : Nouveau prospect détecté')
																	->setFrom(array('bacloo@bacloo.fr' => 'Bacloo CRM'))
																	->setTo('ringuetjm@gmail.com')
																	->setBody($this->renderView('BaclooCrmBundle:Crm:new_opp.html.twig', array('dest_prenom'	=> $destinataire->getPrenom(),
																																			 'activite'	=> 'nok',
																																			 'besoin'	=> $tag,
																																			 'diff'	=> $diff
																																			  )))
																;
																$mailer->send($message);

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
											foreach($list_fichespot as $user)
											{
													$fichecheck  = $em->getRepository('BaclooCrmBundle:interresses')		
																 ->findOneBy(array('ficheid'=> $id, 'username' => $user->GetUsername()));
																 
													$fichecheck2  = $em->getRepository('BaclooCrmBundle:Prospot')		
																 ->findOneBy(array('ficheid'=> $id, 'user' => $user->GetUsername()));									

													if(!isset($fichecheck) && !isset($fichecheck2))
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
																																			 'activite'	=> 'nok',
																																			 'besoin'	=> $tag,
																																			 'diff'	=> $diff
																																			  )))
															;
															$mailer->send($message);
															
														$mailer = $this->get('mailer');				
														
																$message = \Swift_Message::newInstance()
																	->setSubject('Bacloo : Nouveau prospect détecté')
																	->setFrom(array('bacloo@bacloo.fr' => 'Bacloo CRM'))
																	->setTo('ringuetjm@gmail.com')
																	->setBody($this->renderView('BaclooCrmBundle:Crm:new_opp.html.twig', array('dest_prenom'	=> $destinataire->getPrenom(),
																																			 'activite'	=> 'nok',
																																			 'besoin'	=> $tag,
																																			 'diff'	=> $diff
																																			  )))
															;
															$mailer->send($message);

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
													$interresses->setProprio($objUser);
													$em = $this->getDoctrine()->getManager();
													$em->persist($interresses);
													$em->flush();
													}

											}				
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

					$i = 0;
					foreach($list_fichespot as $user)
					{// on sort la liste des utilisateurs interresses par cette fiche a partir de la table interresses
					
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
														// echo 'gooooo';
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
																																			 'activite'	=> $tag,
																																			 'besoin'	=> 'nok',
																																			 'diff'	=> $diff
																																			  )))
																;
																$mailer->send($message);
																
															$mailer = $this->get('mailer');				
															
																$message = \Swift_Message::newInstance()
																	->setSubject('Bacloo : Nouveau prospect détecté')
																	->setFrom(array('bacloo@bacloo.fr' => 'Bacloo CRM'))
																	->setTo('ringuetjm@gmail.com')
																	->setBody($this->renderView('BaclooCrmBundle:Crm:new_opp.html.twig', array('dest_prenom'	=> $destinataire->getPrenom(),
																																			 'activite'	=> $tag,
																																			 'besoin'	=> 'nok',
																																			 'diff'	=> $diff
																																			  )))
																;
																$mailer->send($message);
	// echo 'diiiiiiiiiiii';
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
														$destinataire  = $user;			
														$diff = '1';
														$dejaajoute = 'oui';
														// Partie envoi du mail
														// Récupération du service
														$mailer = $this->get('mailer');				
														
															$message = \Swift_Message::newInstance()
																->setSubject('Bacloo : Nouveau prospect détecté')
																	->setFrom(array('bacloo@bacloo.fr' => 'Bacloo CRM'))
																	->setTo($destinataire->getEmail())
																	->setBody($this->renderView('BaclooCrmBundle:Crm:new_opp.html.twig', array('dest_prenom'	=> $destinataire->getPrenom(),
																																			 'activite'	=> $tag,
																																			 'besoin'	=> 'nok',
																																			 'diff'	=> $diff
																																			  )))
															;
															$mailer->send($message);
															
														$mailer = $this->get('mailer');				
														
															$message = \Swift_Message::newInstance()
																->setSubject('Bacloo : Nouveau prospect détecté')
																	->setFrom(array('bacloo@bacloo.fr' => 'Bacloo CRM'))
																	->setTo('ringuetjm@gmail.com')
																	->setBody($this->renderView('BaclooCrmBundle:Crm:new_opp.html.twig', array('dest_prenom'	=> $destinataire->getPrenom(),
																																			 'activite'	=> $tag,
																																			 'besoin'	=> 'nok',
																																			 'diff'	=> $diff
																																			  )))
															;
															$mailer->send($message);
	echo 'daaaaaaaaaaaaa'.$id;
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
										$tagsfdv  = $em->getRepository('BaclooCrmBundle:Fichesvendables')		
													   ->findOneByFicheid($id);
										// echo 'les tags'.$tagsfiche->getActivite();
										// echo 'tag original'.$tagsfiche->getActivite();
										if(isset($tagsfdv))
										{
											// echo 'tag fvd'.$tagsfdv->getActivite();
											
											if($tabactivite != $tagsfdv->getActivite())//les tags sont differents, on supprime
											{
												if(isset($tagsfdv))
												{//echo 'dapa';					
													$em->remove($tagsfdv);
													$em->flush();
												}
											}
												//On la vire des interresses
												$listintfiche2  = $em->getRepository('BaclooCrmBundle:interresses')		
															   ->findByFicheid($id);
												if(isset($listintfiche2))
												{
													foreach($listintfiche2 as $list2)
													{									
														// echo 'dapé';
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
														// echo 'dapo';	
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
			$tabactivite  = $em->getRepository('BaclooCrmBundle:Fiche')		
						   ->activitefiche($id);

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