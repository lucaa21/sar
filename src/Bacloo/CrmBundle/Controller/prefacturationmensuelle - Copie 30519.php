<?php
use Bacloo\CrmBundle\Entity\Afacturer;
use Bacloo\CrmBundle\Entity\Factures;
use Bacloo\CrmBundle\Entity\Locataclone;
use Bacloo\CrmBundle\Entity\Locationsclone;
use Bacloo\CrmBundle\Entity\Locationsslclone;
use Bacloo\CrmBundle\Entity\Locataventesclone;

// $debutmois = new DateTime("first day of last month");
// $finmois = new DateTime("last day of last month");
// OU
$debutmoisinit = date('Y-m-01', strtotime(" -1 month"));//Debut mois précédent	
$debutmois = date('Y-m-01', strtotime(" -1 month"));//Debut mois précédent	
$moisprec = date('M', strtotime(" -1 month"));//Debut mois précédent	
// $finmois = date('Y-m-t', strtotime(" -1 month"));//Fin mois précédent
			// $debutmois = new DateTime("first day of last month");//echo $debutmois->format('Y-m-d');			
			$finmoisinit = date('Y-m-d');
			$today = date('Y-m-d');
			$todaysec = strtotime($today);

			// $debutmois = date('Y-m-01');
			$debutmoissecinit = strtotime($debutmoisinit);
			$debutmoissec = strtotime($debutmoisinit);
			$finmoissecinit = strtotime ($finmoisinit);			
			$em = $this->getDoctrine()->getManager();
			
			$qrcode = 0;
				//On récupère les codes contrats à facturer afin de faire une boucle
				//Pour cela on recherche les locations et locationssl avec une fin de loc > à la fin du mois
				//On les met dasn un tableau
				$locatatot = $em->getRepository('BaclooCrmBundle:Locata')
							->locationsafacturer($debutmoisinit, $finmoisinit);
// print_r($locatatot);							
				$vendatot = $em->getRepository('BaclooCrmBundle:Venda')
							->ventesafacturer($debutmoisinit, $finmoisinit);
							
				$achatstot = $em->getRepository('BaclooCrmBundle:Locatafrs')
							->achatsafacturer($debutmoisinit, $finmoisinit);
				//On fait ensuite une boucle sur les id de locata puis à l'intérieur de celle ci
				//on fait tourner une boucle sur les locations et locationssl en reprenant le principe de
				//la facturation définitive
					$moisder = 0;
					$touter = 0; //Toutes les loc du contrat sont terminées				
				//DEBUT DE LA FACTURATION MENSUELLE
				foreach($locatatot as $locatas)
				{echo '****';echo $locatas['f_client'];echo $locatas['f_id'];echo '****';
					//Partie locations	
					// echo '**';echo $locatas['f_client'];echo '**';					
					$locata = $em->getRepository('BaclooCrmBundle:Locata')
								->findOneById($locatas['f_id']);
					// echo $locatas['f_client'];
					//Combien de locations sur ce contrats
					$nbloca = 0;
					foreach($locata->getLocations() as $loca)
					{
						$nbloca++;
					}
					//Combien de locationssl sur ce contrats
					$nblocasl = 0;
					foreach($locata->getLocationssl() as $loca)
					{
						$nblocasl++;
					}
					//Nombre de location total sur le contrat
					$nblocs = $nbloca + $nblocasl;
					
					//Déterminons combien de locations terminées sur le contrat
					$nblocater = 0;
					$nblocaterclot = 0;//loc terminées et cloturées
					foreach($locata->getLocations() as $loca)
					{
						if($loca->getEtatloc() == 'Location terminée')
						{
							$nblocater++;
							if($loca->getCloture() == 1)
							{
								$nblocaterclot++;
							}
							//On calcule les loc ter ce mois ci et le mois dernier afin de comparer
						}
					}
					//Combien de locationssl teminées sur ce contrats
					$nblocatersl = 0;
					$nblocaterslclot = 0;
					foreach($locata->getLocationssl() as $loca)
					{
						if($loca->getEtatloc() == 'Location terminée')
						{
							$nblocatersl++;
							if($loca->getCloture() == 1)
							{
								$nblocaterslclot++;
							}
						}
					}
					//Nombre de loc total terminées sur le contrat
					$nblocters = $nblocater + $nblocatersl;
					$nblocaclot = $nblocaterclot + $nblocaterslclot;
echo ' locter'.$nblocters;
echo ' nblocs'.$nblocs;
					if($nblocters == $nblocs)//Si le nb de lcoations terminées est = au nb de lcoations total du contrat on peut facturer tout
					{echo 'LOLO4';
						$touter = 1;
						$finmois = date('Y-m-d');//echo $finmois;
						$finmoissec = strtotime($finmois);
					}
					else //Si loc total différent de loc terminées total
					{echo 'LOLO5';
						$touter = 0;
						//on vérifie alors si des loc et locsl en cours ont démarrées le mois dernier
						//S'il y en a pas, attendre la fin du mois pour la compta ou que la loc soit terminée
						//On créée la variable $moider
						//Si celle-ci est au moins égale à 1 alors il y a au moins une location qui a commencé le mois dernier
						
						foreach($locata->getLocations() as $loca)
						{
							//Si loc commencée avant début du mois courant et finit après début mois courant (loc en cours)
							if(strtotime($loca->getDebutloc()) < strtotime(date('Y-m-01')) and strtotime($loca->getFinloc()) > strtotime(date('Y-m-01')))
							{
								$moisder++;
								$finmois = date('Y-m-t', strtotime(" -1 month"));//Fin mois précédent
								$finmoissec = strtotime ($finmois);
							}
							elseif(strtotime($loca->getDebutloc()) >= strtotime(date('Y-m-01')) and strtotime($loca->getFinloc()) <= strtotime(date('Y-m-d')))//au moins une loc commence et finit le mois courant
							{
								$moisder++;
								$finmois = date('Y-m-d');//Fin mois précédent
								$finmoissec = strtotime ($finmois);								
							}
						}
						foreach($locata->getLocationssl() as $loca)
						{
							if(strtotime($loca->getDebutloc()) < strtotime(date('Y-m-01')) and strtotime($loca->getFinloc()) > strtotime(date('Y-m-01')))
							{
								$moisder++;
								$finmois = date('Y-m-t', strtotime(" -1 month"));//Fin mois précédent
								$finmoissec = strtotime ($finmois);
							}
							elseif(strtotime($loca->getDebutloc()) >= strtotime(date('Y-m-01')) and strtotime($loca->getFinloc()) <= strtotime(date('Y-m-d')))//au moins une loc commence et finit le mois courant
							{
								$moisder++;
								$finmois = date('Y-m-d');//Fin mois précédent
								$finmoissec = strtotime ($finmois);								
							}
						}
						echo 'moisder'.$moisder;
					}	

					$locataclonedeja = $em->getRepository('BaclooCrmBundle:Locataclone')
								->findBy(array('oldid' => $locatas['f_id']));
					$ii = 0;//Si à 1 = deja cloné
					foreach($locataclonedeja as $loco)
					{
						$time=strtotime($loco->getDatemodif());
						$moisclone=date("F",$time);
						$anneeclone=date("Y",$time);
						
						$moiscourant=date("F");
						$anneecourante=date("Y");
						if($moisclone == $moiscourant && $anneeclone == $anneecourante)
						{
							$ii++;
						}
					}

	
					// $totalhtfacture = $locata->getMontantloc() + $locata->getTransportaller() + $locata->getTransportretour() + $locata->getContributionverte() + $locata->getAssurance() + $locata->getMontantlocavente() + $locata->getMontantcarb();
					//On récupère tous les locataclone liés à ce contrat
					//Ensuite on garde celui qui date de ce mois-ci ou du mois dernier
					$locataclonedeja2 = $em->getRepository('BaclooCrmBundle:Locataclone')
								->findBy(array('oldid' => $locatas['f_id']));
					$dejafac = 0;//déjà fac mois courant
					$dejafacm1 = 0;//déjà fac mois précédent
					$nblocsfact = 0;
					$nblocsfactm1 = 0;
					$nblocsterm1 = 0;
					if(!empty($locataclonedeja2)){echo 'IL EST DEDANS';}else{echo 'PAS DEDANS';}
					foreach($locataclonedeja2 as $locoa)
					{
						if(date("Y-m", strtotime($locoa->getDatemodif())) == date("Y-m"))//CE MOIS-CI
						{
							$dejafac++;
							foreach($locoa->getLocationsclone() as $loca){if($loca->getMontantloc() > 0){$nblocsfact++;}}
							foreach($locoa->getLocationsslclone() as $loca){if($loca->getMontantloc() > 0){$nblocsfact++;}}
						}
						elseif(date("Y-m", strtotime($locoa->getDatemodif())) == date('Y-m', strtotime(" -1 month")))//LE MOIS DERNIER
						{
							$dejafacm1++;
							foreach($locoa->getLocationsclone() as $loca){if($loca->getEtatloc() == 'Location terminée'){$nblocsterm1++;}}
							foreach($locoa->getLocationsslclone() as $loca){if($loca->getEtatloc() == 'Location terminée'){$nblocsterm1++;}}
							foreach($locoa->getLocationsclone() as $loca){if($loca->getDef() == 1){$nblocsfactm1++;}}
							foreach($locoa->getLocationsslclone() as $loca){if($loca->getDef() == 1){$nblocsfactm1++;}}
						}
					}
// echo 'NBLOCFACT'; echo $nblocsfact; echo $nblocsfactm1; echo 'nblocsterm1'.$nblocsterm1;echo $nblocs;echo date("Y-m", strtotime($locoa->getDatemodif()));echo date('Y-m', strtotime(" -1 month"));echo $loca->getEtatloc();					
					if($dejafac > 0 && $nblocaclot != $nblocters && $nblocsfact != $nblocs)
					{
						echo 'GOTAM';
						$dejafac = 0;
					}
					//si deja fac mois courant voir si la loc
					
					// en fzait MES24 réuni ces conditions mais n'est pas le seul
					// il faudrait donc trouver une autre condition pour mieux filtrer. Machine ? 
					
					elseif($dejafac > 0 && $nblocaclot == $nblocters && ($nblocs != $nblocsfact || $nblocs != $nblocsterm1))
					{
						echo 'GOTAM2';
						$dejafac = 0;
					}
					//A partir de là on va commencer le process de clonage uniquement si
					//locata pas cloné et au moins une loc démarrée le mois dernier et si pas encore factu (double sécu de gros parano
					// OU
					//Si pas déjà cloné et si toutes les loc sont terminées
					
					//CLONAGE
echo ' dejafac'.$dejafac;
echo ' dejafacM1'.$dejafacm1;
echo ' nblocaclot'.$nblocaclot;
echo ' finmois'.$finmois;
echo ' loca->getFinloc()'.$loca->getFinloc();
if(($dejafac == 0 && $nblocters > 0)){echo $locatas['f_client'];echo $locatas['f_id']; echo 'cas 1';} if($dejafac == 0 && $touter == 1){echo $locatas['f_client']; echo 'cas 2';echo $dejafac;echo $touter;echo $locatas['f_client'];}
if($nblocaclot != $nblocs && $dejafac == 1 && $nblocters > 0 && $moisder > 0 && $finmois == date('Y-m-t', strtotime(" -1 month") && strtotime($loca->getFinloc()) > $finmoissec)){echo $locatas['f_client'];echo 'cas 3';}					
if(($dejafac == 0 && $nblocters > 0) || ($dejafac == 0 && $touter == 1) || ($nblocaclot != $nblocs && $dejafac == 1 && $nblocters > 0 && $moisder > 0 && $finmois == date('Y-m-t', strtotime(" -1 month") && strtotime($loca->getFinloc()) > $finmoissec))){echo $locatas['f_client'];echo $moisder; echo $moisprec; echo $nblocatersl;echo 'clonage';}else{echo $locatas['f_client']; echo 'pas clonage';}				
					if(($dejafac == 0 && $nblocters > 0 && $nblocsfactm1 != $nblocs) || ($dejafac == 0 && $touter == 1 && $nblocsfactm1 != $nblocs) || ($dejafac == 0 && $nblocters == 0))//si au moins une loc démarrée mois dernier et pas de cloone pour ce mois-ci
					{
						echo 'On y va';
						//clonage et copie locata
						$oldLocata = $locata;
						$newLocata = new Locataclone;
						$oldReflection = new \ReflectionObject($oldLocata);
						$newReflection = new \ReflectionObject($newLocata);

						foreach ($oldReflection->getProperties() as $property) {
							if ($newReflection->hasProperty($property->getName())) {
								$newProperty = $newReflection->getProperty($property->getName());
								$newProperty->setAccessible(true);
								$newProperty->setValue($newLocata, $property->getValue($oldLocata));
							}
						}
						$newLocata->setOldid($oldLocata->getId());
						$em->persist($newLocata);
						$em->flush();
$id = $newLocata->getId();
$locid = $locata->getId();
$em->clear();
					$newLocata = $em->getRepository('BaclooCrmBundle:Locataclone')
								->findOneById($id);	
					$locata = $em->getRepository('BaclooCrmBundle:Locata')
								->findOneById($locid);	
echo 'AAAAAAA';echo $newLocata->getId();echo $newLocata->getMontantloc();							
						if($newLocata->getMontantloc() > 0)
						{
								$totalht = 0;
								$transport = 0;	
								$totaltrspaller = 0;
								$totaltrspretour = 0;
								$jour50 = 0;
								$jour100 = 0;
								$montantcarb = 0;
								$premiermois = 0;
								$contributionverte = 0;
								$assurance = 0;	
								//On clone si fin de mois et si location terminée même si une loc n'est pas terminée sur le contrat
								foreach($locata->getLocations() as $loca)
								{
									//On récupère le dernier locationsslclone
									//echo $locata->getId(); echo $loca->getCodemachineinterne();
									// $lastloc = $em->getRepository('BaclooCrmBundle:Locationsclone')
											// ->lastloc($loca->getCodemachineinterne());
											// print_r($lastlocsl);
											
									$em = $this->getDoctrine()
										   ->getManager();		
						
									$query = $em->createQuery(
										'SELECT l
										FROM BaclooCrmBundle:Locationsclone l
										WHERE l.codemachineinterne = :codemachineinterne
										ORDER BY l.id DESC'
									)->setMaxResults(1);
									$query->setParameter('codemachineinterne', $loca->getCodemachineinterne());
									
									$lastloc = $query->getOneOrNullResult();	
									
		// echo 'YYYY';echo $lastlocsl->getCodemachineinterne();

									if(isset($lastloc))
									{				
										$finloc = $lastloc->getFinloc();
										$transportallerp = $lastloc->getTransportaller();
										$moisderfac = date("M", strtotime($finloc));
										$moisderfacnum = date("m", strtotime($finloc));
									}
									else
									{
										$moisderfac = 0;
										$moisderfacnum = 0;
									}	
		echo 'transportallerp';$transportallerp;							
									if(($loca->getEtatloc() == 'En location' and strtotime($loca->getDebutloc()) < strtotime(date('Y-m-01')) and $moisderfacnum != date('m', strtotime(" -1 month")) or ($loca->getEtatloc() == 'Location terminée' && $loca->getEtatloc() != 1)))
									{
										if($loca->getEtatloc() == 'En location')
										{
											$finmois = date('Y-m-t', strtotime(" -1 month"));//Fin mois précédent
											$finmoissec = strtotime ($finmois);	
										}
										elseif($loca->getEtatloc() == 'Location terminée')
										{
											$finmois = $loca->getFinloc();//Fin mois précédent
											$finmoissec = strtotime ($finmois);
											$loca->setCloture(1);
											$em->flush();
										}
											
										if($loca->getEtatloc() == 'En location' && strtotime($loca->getFinloc()) >= date('Y-m-01'))
										{
											$finloc = date('Y-m-t', strtotime(" -1 month"));
										}
										else
										{
											$finloc = $loca->getFinloc();
										}
										
										$em = $this->getDoctrine()->getManager();
										$query = $em->createQuery(
											'SELECT m.id
											FROM BaclooCrmBundle:Locationsclone m
											WHERE m.codemachineinterne = :codemachineinterne
											ORDER BY m.id DESC');
										$query->setMaxResults(1);
										$query->setParameter('codemachineinterne', $loca->getCodemachineinterne());
										$oldid = $query->getOneOrNullResult();
		// echo '555';								
										$locationsclonedeja = $em->getRepository('BaclooCrmBundle:Locationsclone')
											->findOneBy(array('oldid' => $loca->getId(), 'etatloc' => 'Location terminée', 'codemachineinterne' => $loca->getCodemachineinterne()));								
										
										if(!empty($locationsclonedeja))
										{echo 'ON NE FAIT RIEN';}
										else
										{echo 'FOFO';	
											$finlocsec = strtotime ($loca->getFinloc());	
											$dStart = $loca->getDebutloc();
											$dStartsec = strtotime ($loca->getDebutloc());
											$dEnd = $loca->getFinloc();
		// echo 'xxxxxxxxxxxxxxxxx';echo $finmois; echo $loca->getFinloc();
		// echo $dStart; echo $debutmois;
											//Si date début antérieure au début du mois >> date début = début mois
											if($dStartsec <= $debutmoissec)
											{echo 'DIDAN';
												$dStart = $debutmois;
											}
											elseif($dStartsec < strtotime(date('Y-m-01')) && $dStartsec > $debutmoissec && $moisderfacnum == date('m', strtotime(" -1 month")))//si date début est mois dernier et dernière facturation = mois dernier.
											{echo 'DIDAN2';
												$dStart = date('Y-m-01');
											}
											else
											{
												$dStart = $loca->getDebutloc();
											}
											//si la location terminée et la date de fin est comprise entre le début du mois courant et la date du jour
											if($loca->getEtatloc() == 'Location terminée' and $finlocsec <= $todaysec and $finlocsec >= strtotime(date('Y-m-01')))
											{echo 'CAY';
												$dEnd = $loca->getFinloc();
												if(strtotime($loca->getDebutloc()) < strtotime(date('Y-m-01')))
												{echo 'GUY';
													$dStart = date('Y-m-01');
													if(strtotime($dStart) > strtotime($dEnd))
													{
														$dStart = $loca->getDebutloc();
													}
												}
												else
												{echo 'STLO';
													$dStart = $loca->getDebutloc();
												}
											}
											//si la date de début est inférieur au début de mois prec
											//Si date fin posterieure à fin du mois prec >> date fin = fin mois prec
											if($finlocsec >= $finmoissec)
											{
												if($loca->getEtatloc() == 'Location terminée')
												{echo 'ici';
													$dEnd = $loca->getFinloc();
													$finmois = $loca->getFinloc();
													$finmoissec = strtotime ($finmois);
												}
												else
												{echo 'LAAAA';
													if($loca->getEtatloc() == 'En location')
													{
														$finmois = date('Y-m-t', strtotime(" -1 month"));//Fin mois précédent
														$finmoissec = strtotime ($finmois);
													}											
													$dEnd = $finmois;
												}
											}

											//Si date début après début de mois alors $dstart = $dstart on ne fait rien. !! pas sûr !!!

											//on calcule le nombre de jours de location
											// echo $loca->getEntreprise();//echo $dStart;echo $dEnd;									
											// $begin = new DateTime($dStart);
											$begin = new DateTime($dStart);
											$end = new DateTime($dEnd);
											$end = $end->modify( '+1 day' ); 
		// echo '*****';
		// echo $begin->format('Y-m-d');
		// echo $end->format('Y-m-d');
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

		// echo 'laa';		echo 'nbjloc'.$nbjloc;					
											//clonage et copie locations	
											// $locatio  = $em->getRepository('BaclooCrmBundle:Locations')		
											   // ->findOneByCodemachineinterne($ecode);
											// $assurancela =($nbjlocass/$loca->getNbjloc())*$loca->getAssurance(); 


											$locations = new Locationsclone;
											$locations->setCodeclient($loca->getCodeclient());
											$locations->setEntid($loca->getCodeclient());
											$locations->setEntreprise($loca->getEntreprise());
											$locations->setMachineid($loca->getMachineid());
											$locations->setCodemachine($loca->getCodemachine());
											$locations->setCodemachine($loca->getCodemachine());
											$locations->setCodemachineinterne($loca->getCodemachineinterne());
											$locations->setTypemachine($loca->getTypemachine());
											$locations->setTypemachineinit($loca->getTypemachineinit());
											$locations->setEtatloc($loca->getEtatloc());
											$locations->setLoyerp1($loca->getLoyerp1());
											$locations->setLoyerp2($loca->getLoyerp2());
											$locations->setLoyerp3($loca->getLoyerp3());
											$locations->setLoyerp4($loca->getLoyerp4());
											$locations->setLoyermensuel($loca->getLoyermensuel());
											$locations->setNbjloc($nbjloc);
											$locations->setNbjlocass($nbjlocass);
											
											if(empty($loca->getNbjloc()) or $loca->getNbjloc() == 0){$locnbjloc = 1;}else{$locnbjloc = $loca->getNbjloc();}
											$loyer = ($loca->getMontantloc()/$locnbjloc);
											// $totalht += $loyer*$nbjloc;
											$locations->setMontantloc($loyer*$nbjloc);
											
											$locations->setLitrescarb($loca->getLitrescarb());
											$locations->setMontantcarb($loca->getMontantcarb());
											$locations->setEnergie($loca->getEnergie());
											$locations->setDatereprise($loca->getDatereprise());
							
			//On récupère le dernier locationsslclone
									$em = $this->getDoctrine()
										   ->getManager();		
						
									$query = $em->createQuery(
										'SELECT l
										FROM BaclooCrmBundle:Locationsslclone l
										WHERE l.codemachineinterne = :codemachineinterne
										ORDER BY l.id DESC'
									)->setMaxResults(1);
									$query->setParameter('codemachineinterne', $loca->getCodemachineinterne());
									
									$lastlocsl = $query->getOneOrNullResult();	
									
		// echo 'YYYY';echo $lastlocsl->getCodemachineinterne();

									if(isset($lastlocsl))
									{				
										$finloc = $lastlocsl->getFinloc();
										$transportallerp = $lastlocsl->getTransportaller();
										$moisderfac = date("M", strtotime($finloc));
										$moisderfacnum = date("m", strtotime($finloc));
									}
									else
									{
										$moisderfac = 0;
										$moisderfacnum = 0;
									}
							
											if(($loca->getEtatloc() == 'En location' or $loca->getEtatloc() == 'Location terminée') && strtotime($loca->getDebutloc()) < $debutmoissecinit && $moisderfac != date("M", strtotime($dStart)))
											{echo 'GLOC';echo $moisderfac;echo $moisprec;
												$locations->setDebutloc($debutmoisinit);
											}
											elseif($loca->getEtatloc() == 'Location terminée' && strtotime($loca->getDebutloc()) > $debutmoissecinit && $moisderfac == $moisprec)
											{echo 'START';echo $moisderfac;echo $moisprec;
												$locations->setDebutloc($dStart);
											}
											else
											{echo 'DEBUTLOC';echo $moisderfac;echo $moisprec;
												$locations->setDebutloc($loca->getDebutloc());
											}
											
											if($loca->getEtatloc() == 'En location' && strtotime($loca->getFinloc()) >= date('Y-m-01'))
											{
												$locations->setFinloc(date('Y-m-t', strtotime(" -1 month")));
											}
											else
											{
												$locations->setFinloc($loca->getFinloc());
											}								
											if($loca->getDebutloc() >= $debutmois && $loca->getDebutloc() <= $finmois && empty($transportallerp))
											{
												$locations->setTransportaller($loca->getTransportaller());
												$totaltrspaller += $loca->getTransportaller();
												$premiermois++;
											}
											
											if($loca->getFinloc() >= $debutmois && $loca->getFinloc() <= $finmois)
											{
												$locations->setTransportretour($loca->getTransportretour());
												$totaltrspretour += $loca->getTransportretour();
											}

											$locations->setContributionverte($loca->getContributionverte());
											if($loca->getContributionverte() == 1)	
											{
												$contributionverte += $loyer*$nbjloc*0.0215;
											}
											else
											{
												$contributionverte += 0;
											}
											


											$locations->setAssurance($loca->getAssurance());
											if($loca->getAssurance() == 1)
											{
												$assurance += $loyer*$nbjlocass*0.10;
											}
											else
											{
												$assurance = 0;
											}
											
											$locations->setJour50($loca->getJour50());
											$locations->setJour100($loca->getJour100());
											$locations->setOldid($loca->getId());
											$locations->setCloture($loca->getCloture());
											$locations->addLocataclone($newLocata);
											$newLocata->addLocationsclone($locations);
											$em->persist($locations);	
											$em->persist($newLocata);
											$em->flush();

													//Création du montant HT ligne par ligne
													
													if(null !== $loca->getLoyerp1())
													{//echo '1111';
														if($loca->getJour50()>0)
														{
															$jour50 += ($loca->getLoyerp1() * $loca->getjour50())*0.5;
														}
														if($loca->getJour100()>0)
														{
															$jour100 += ($loca->getLoyerp1() * $loca->getjour100());
														}
														$totalht += $nbjloc * $loca->getLoyerp1() - $jour50 - $jour100;
													}
													elseif(null !== $loca->getLoyerp2())
													{//echo '2222';
														if($loca->getJour50()>0)
														{
															$jour50 += ($loca->getLoyerp2() * $loca->getjour50())*0.5;
														}
														if($loca->getJour100()>0)
														{
															$jour100 += ($loca->getLoyerp2() * $loca->getjour100());
														}
														$totalht += $nbjloc * $loca->getLoyerp2() - $jour50 - $jour100;
									// echo '>>>'.$nbjloc.'**'.$loca->getLoyerp2().'=='.$nbjloc*$loca->getLoyerp2();
													}
													elseif(null !== $loca->getLoyerp3())
													{//echo '3333';
														if($loca->getJour50()>0)
														{
															$jour50 += ($loca->getLoyerp3() * $loca->getjour50())*0.5;
														}
														if($loca->getJour100()>0)
														{
															$jour100 += ($loca->getLoyerp3() * $loca->getjour100());
														}
														$totalht += ($nbjloc * $loca->getLoyerp3()) - $jour50 - $jour100;
													}
													elseif(null !== $loca->getLoyerp4())
													{
														if($loca->getJour50()>0)
														{
															$jour50 += ($loca->getLoyerp4() * $loca->getjour50())*0.5;
														}
														if($loca->getJour100()>0)
														{
															$jour100 += ($loca->getLoyerp4() * $loca->getjour100());
														}
														$totalht += ($nbjloc * $loca->getLoyerp4()) - $jour50 - $jour100;
													}
													elseif(null !== $loca->getLoyermensuel())
													{
														if($nbjloc < 20)
														{
															$loyer = $loca->getLoyermensuel()/$nbjloc;
														}
														else
														{
															$nbjloc = 20;													
															$loyer = ($loca->getLoyermensuel()/20);
														}													
														if($loca->getJour50()>0)
														{
															$jour50 += ($loyer * $loca->getjour50())*0.5;
														}
														if($loca->getJour100()>0)
														{
															$jour100 += ($loyer * $loca->getjour100());
														}
														$totalht += ($nbjloc * $loyer) - $jour50 - $jour100;
													}
				// echo '++++'.$totalht.'+++';	echo $loca->getEntreprise();									
													if(null !== $loca->getMontantcarb())
													{
														$montantcarb += $loca->getMontantcarb();
													}						
													if(null !== $loca->getTransportaller() && $loca->getTransportaller()>0 && $loca->getDebutloc() >= $debutmois && $loca->getDebutloc() <= $finmois)
													{
														$transport += $loca->getTransportaller();
													}
													
													if(null !== $loca->getTransportretour() && $loca->getTransportretour()>0 && $loca->getFinloc() >= $debutmois && $loca->getFinloc() <= $finmois)
													{
														$transport += $loca->getTransportretour();
													}
										}
								
									}
								}
								//Partie sous location
								foreach($locata->getLocationssl() as $loca)
								{
									//On récupère le dernier locationsslclone
									//echo $locata->getId(); echo $loca->getCodemachineinterne();
									// $lastloc = $em->getRepository('BaclooCrmBundle:Locataclone')
											// ->lastloc($locata->getId(), $loca->getCodemachineinterne());
									$em = $this->getDoctrine()
										   ->getManager();		
						
									$query = $em->createQuery(
										'SELECT l
										FROM BaclooCrmBundle:Locationsslclone l
										WHERE l.codemachineinterne = :codemachineinterne
										ORDER BY l.id DESC'
									)->setMaxResults(1);
									$query->setParameter('codemachineinterne', $loca->getCodemachineinterne());
									
									$lastlocsl = $query->getOneOrNullResult();	
									
		// echo 'YYYY';echo $lastlocsl->getCodemachineinterne();

									if(isset($lastlocsl))
									{				
										$finloc = $lastlocsl->getFinloc();
										$transportallerp = $lastlocsl->getTransportaller();
										$moisderfac = date("M", strtotime($finloc));
										$moisderfacnum = date("m", strtotime($finloc));
									}
									else
									{
										$moisderfac = 0;
										$moisderfacnum = 0;
									}
			
		// echo 'transportallerp'.$transportallerp;								
									if(($loca->getEtatloc() == 'En location' and strtotime($loca->getDebutloc()) < strtotime(date('Y-m-01')) and $moisderfacnum != date('m', strtotime(" -1 month")) or ($loca->getEtatloc() == 'Location terminée' && $loca->getEtatloc() != 1)))
									{
										if($loca->getEtatloc() == 'En location')
										{
											$finmois = date('Y-m-t', strtotime(" -1 month"));//Fin mois précédent
											$finmoissec = strtotime ($finmois);	
										}
										elseif($loca->getEtatloc() == 'Location terminée')
										{
											$finmois = $loca->getFinloc();//Fin mois précédent
											$finmoissec = strtotime ($finmois);
											$loca->setCloture(1);
											$em->flush();
										}
											
										if($loca->getEtatloc() == 'En location' && strtotime($loca->getFinloc()) >= date('Y-m-01'))
										{
											$finloc = date('Y-m-t', strtotime(" -1 month"));
										}
										else
										{
											$finloc = $loca->getFinloc();
										}
										
										$em = $this->getDoctrine()->getManager();
										// $query = $em->createQuery(
											// 'SELECT m.oldid
											// FROM BaclooCrmBundle:Locationsslclone m
											// WHERE m.codemachineinterne = :codemachineinterne
											// ORDER BY m.id DESC');
										// $query->setMaxResults(1);
										// $query->setParameter('codemachineinterne', $loca->getCodemachineinterne());
										// $oldid = $query->getSingleResult();
		echo 'FINLOC';echo $finloc;	echo $loca->getCodemachineinterne();					
										$locationsclonedeja = $em->getRepository('BaclooCrmBundle:Locationsslclone')
											->findOneBy(array('oldid' => $loca->getId(), 'codemachineinterne' => $loca->getCodemachineinterne(), 'finloc' => $finloc));						

										if(empty($locationsclonedeja))
										{							
											$finlocsec = strtotime ($loca->getFinloc());	
											$dStart = $loca->getDebutloc();
											$dStartsec = strtotime ($loca->getDebutloc());
											$dEnd = $loca->getFinloc();
		// echo 'xxxxxxxxxxxxxxxxx';echo $finmois; echo $loca->getFinloc();
											//Si date début antérieure au début du mois >> date début = début mois
											if($dStartsec <= $debutmoissec)
											{echo 'DIDAN';
												$dStart = $debutmois;
											}
											elseif($dStartsec < strtotime(date('Y-m-01')) && $dStartsec > $debutmoissec && $moisderfacnum == date('m', strtotime(" -1 month")))//si date début est mois dernier et dernière facturation = mois dernier.
											{echo 'DIDAN2';
												$dStart = date('Y-m-01');
												if(strtotime($dStart) > strtotime($loca->getFinloc()))
												{
													$dStart = $loca->getDebutloc();
												}
											}
											else
											{
												$dStart = $loca->getDebutloc();
											}
											//Si date fin posterieure à fin du mois >> date fin = fin mois
											if($loca->getEtatloc() == 'Location terminée' and $finlocsec <= $todaysec and $finlocsec >= strtotime(date('Y-m-01')))
											{echo 'CAY';
												$dEnd = $loca->getFinloc();
												if(strtotime($loca->getDebutloc()) < strtotime(date('Y-m-01')))
												{echo 'GUY';
													$dStart = date('Y-m-01');
													if(strtotime($dStart) > strtotime($dEnd))
													{
														$dStart = $loca->getDebutloc();
													}
												}
												else
												{echo 'STLO';
													$dStart = $loca->getDebutloc();
												}
											}
											//si la date de début est supérieur à la fin du mois de facturation m-1 
											if($finlocsec >= $finmoissec)
											{
												if($loca->getEtatloc() == 'Location terminée')
												{//echo 'ici';
													$dEnd = $loca->getFinloc();
													$finmois = $loca->getFinloc();
													$finmoissec = strtotime ($finmois);

												}
												else
												{
													if($loca->getEtatloc() == 'En location')
													{
														$finmois = date('Y-m-t', strtotime(" -1 month"));//Fin mois précédent
														$finmoissec = strtotime ($finmois);
													}		
													$dEnd = $finmois;
												}
											}
											//Si date fin posterieure à fin du mois >> date début = début mois

												//Si date début après début de mois alors $dstart = $dstart on ne fait rien.
												
												//1.Récupérer les données de la table Locata cf supra
													   
												//2.On génère les entêtes de colonnes à partir de la fonction createplanning

												//on calcule le nombre de jours de location
												// echo $loca->getEntreprise();//echo $dStart;echo $dEnd;									
												$begin = new DateTime($dStart);
												$end = new DateTime($dEnd);
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
											
										
											// $locationsclonedeja = $em->getRepository('BaclooCrmBundle:Locationsslclone')
											// ->findOneBy(array('oldid' => $loca->getId(), 'etatloc' => 'Location terminée', 'codemachineinterne' => $loca->getCodemachineinterne(), 'finloc' => $loca->getFinloc()));						
										
											$locations = new Locationsslclone;
											$locations->setCodeclient($loca->getCodeclient());
											$locations->setEntid($loca->getCodeclient());
											$locations->setEntreprise($loca->getEntreprise());
											$locations->setMachineid($loca->getMachineid());
											$locations->setCodemachine($loca->getCodemachine());
											$locations->setCodemachine($loca->getCodemachine());
											$locations->setCodemachineinterne($loca->getCodemachineinterne());
											$locations->setTypemachine($loca->getTypemachine());
											$locations->setTypemachineinit($loca->getTypemachineinit());
											$locations->setEtatloc($loca->getEtatloc());
											$locations->setLoyerp1($loca->getLoyerp1());
											$locations->setLoyerp2($loca->getLoyerp2());
											$locations->setLoyerp3($loca->getLoyerp3());
											$locations->setLoyerp4($loca->getLoyerp4());
											$locations->setLoyermensuel($loca->getLoyermensuel());
											$locations->setNbjloc($nbjloc);
											$locations->setNbjlocass($nbjlocass);
											
											if(empty($loca->getNbjloc()) or $loca->getNbjloc() == 0){$locnbjloc = 1;}else{$locnbjloc = $loca->getNbjloc();}
											$loyer = ($loca->getMontantloc()/$locnbjloc);
											// $totalht += $loyer*$nbjloc;
											$locations->setMontantloc($loyer*$nbjloc);
											
											$locations->setLitrescarb($loca->getLitrescarb());
											$locations->setMontantcarb($loca->getMontantcarb());
											$locations->setEnergie($loca->getEnergie());
											$locations->setDatereprise($loca->getDatereprise());
											
											if(($loca->getEtatloc() == 'En location' or $loca->getEtatloc() == 'Location terminée') && strtotime($loca->getDebutloc()) < $debutmoissecinit && $moisderfac != date("M", strtotime($dStart)))
											{echo 'BOOM';echo $moisderfac;echo $moisprec;echo $loca->getDebutloc();echo $debutmoisinit;echo $loca->getEtatloc();
												$locations->setDebutloc($debutmoisinit);
											}
											elseif($loca->getEtatloc() == 'Location terminée' && strtotime($loca->getDebutloc()) > $debutmoissecinit && $moisderfac == $moisprec)
											{echo 'START';echo $moisderfac;echo $moisprec;echo $loca->getDebutloc();echo $debutmoisinit;echo $loca->getEtatloc();
												$locations->setDebutloc($dStart);
											}
											else
											{echo 'DEBUTLOC';echo $moisderfac;echo $moisprec;echo $loca->getDebutloc();echo $debutmoisinit;echo $loca->getEtatloc();
												$locations->setDebutloc($loca->getDebutloc());
											}
											
											if($loca->getEtatloc() == 'En location' && strtotime($loca->getFinloc()) >= date('Y-m-01'))
											{
												$locations->setFinloc(date('Y-m-t', strtotime(" -1 month")));
											}
											else
											{
												$locations->setFinloc($loca->getFinloc());
											}								
											if($loca->getDebutloc() >= $debutmois && $loca->getDebutloc() <= $finmois && !isset($transportallersl))
											{
												$locations->setTransportaller($loca->getTransportaller());
												$totaltrspaller += $loca->getTransportaller();
												$premiermois++;
											}
											
											if($loca->getFinloc() >= $debutmois && $loca->getFinloc() <= $finmois)
											{
												$locations->setTransportretour($loca->getTransportretour());
												$totaltrspretour += $loca->getTransportretour();
											}
											
											$locations->setContributionverte($loca->getContributionverte());
											if($loca->getContributionverte() == 1)
											{
												$contributionverte += $loyer*$nbjloc*0.0215;
											}
											else
											{
												$contributionverte += 0;
											}
											
											$locations->setAssurance($loca->getAssurance());
											if($loca->getAssurance() == 1)
											{
												$assurance += $loyer*$nbjlocass*0.10;
											}
											else
											{
												$assurance = 0;
											}
											
											$locations->setJour50($loca->getJour50());
											$locations->setJour100($loca->getJour100());
											$locations->setOldid($loca->getId());
											$locations->setCloture($loca->getCloture());
											$locations->addLocataclone($newLocata);
											$newLocata->addLocationsslclone($locations);
											$em->persist($locations);	
											$em->persist($newLocata);
											$em->flush();

													//Création du montant HT ligne par ligne
													// $totalht = 0;//echo $locid;

													if(null !== $loca->getLoyerp1())
													{
														if($loca->getJour50()>0)
														{
															$jour50 += ($loca->getLoyerp1() * $loca->getjour50())*0.5;
														}
														if($loca->getJour100()>0)
														{
															$jour100 += ($loca->getLoyerp1() * $loca->getjour100());
														}
														$totalht += ($nbjloc * $loca->getLoyerp1()) - $jour50 - $jour100;
													}
													elseif(null !== $loca->getLoyerp2())
													{
														if($loca->getJour50()>0)
														{
															$jour50 += ($loca->getLoyerp2() * $loca->getjour50())*0.5;
														}
														if($loca->getJour100()>0)
														{
															$jour100 += ($loca->getLoyerp2() * $loca->getjour100());
														}
														$totalht += ($nbjloc * $loca->getLoyerp2()) - $jour50 - $jour100;
													}
													elseif(null !== $loca->getLoyerp3())

													{
														if($loca->getJour50()>0)
														{
															$jour50 += ($loca->getLoyerp3() * $loca->getjour50())*0.5;
														}
														if($loca->getJour100()>0)
														{
															$jour100 += ($loca->getLoyerp3() * $loca->getjour100());
														}
														$totalht += ($nbjloc * $loca->getLoyerp3()) - $jour50 - $jour100;
													}
													elseif(null !== $loca->getLoyerp4())
													{
														if($loca->getJour50()>0)
														{
															$jour50 += ($loca->getLoyerp4() * $loca->getjour50())*0.5;
														}
														if($loca->getJour100()>0)
														{
															$jour100 += ($loca->getLoyerp4() * $loca->getjour100());
														}
														$totalht += ($nbjloc * $loca->getLoyerp4()) - $jour50 - $jour100;
													}
													elseif(null !== $loca->getLoyermensuel())
													{
														if($nbjloc < 20)
														{
															$loyer = $loca->getLoyermensuel()/$nbjloc;
														}
														else
														{
															$nbjloc = 20;													
															$loyer = ($loca->getLoyermensuel()/20);
														}													
														if($loca->getJour50()>0)
														{
															$jour50 += ($loyer * $loca->getjour50())*0.5;
														}
														if($loca->getJour100()>0)
														{
															$jour100 += ($loyer * $loca->getjour100());
														}
														$totalht += ($nbjloc * $loyer) - $jour50 - $jour100;
													}
													if(null !== $loca->getMontantcarb())
													{											
														// $totalht += $loca->getMontantcarb();
													}
													if(null !== $loca->getMontantcarb())
													{
														$montantcarb += $loca->getMontantcarb();
													}						
													if(null !== $loca->getTransportaller() && $loca->getTransportaller()>0 && $loca->getDebutloc() >= $debutmois && $loca->getDebutloc() <= $finmois)
													{
														$transport += $loca->getTransportaller();
													}
													
													if(null !== $loca->getTransportretour() && $loca->getTransportretour()>0 && $loca->getFinloc() >= $debutmois && $loca->getFinloc() <= $finmois)
													{
														$transport += $loca->getTransportretour();
													}
										}
									}
									else
									{}//echo 'pas enregistré sl';
									// echo 'xxx'.$nbjloc.'-'.$nbjloc*$loyer.'-'.$totalht.'xxx';	
								}
								//Si on est sur la première facture on clone les locataventes pour les facturer
								//Car les vente ne doivent êrte facturées qu'ne fois
								$montantlocaventes = 0; //Pour la vente
								$montantlocaventestot = 0 + $montantcarb;//Pour toutes les ventes
								if($premiermois > 0)
								{//echo 'premier mois locavente';
									foreach($locata->getLocataventes() as $ven)
									{
										//ici on clone les locataventes si on est le premier mois
										$locataventes = new Locataventesclone;
										$locataventes->setDate($ven->getDate());
										$locataventes->setRefarticle($ven->getRefarticle());
										$locataventes->setDescription($ven->getDescription());
										$locataventes->setQuantite($ven->getQuantite());
										$locataventes->setPu($ven->getPu());
										$locataventes->setMontantvente($ven->getMontantvente());
										$locataventes->setUser($ven->getUser());
										$locataventes->setCodifvente($ven->getCodifvente());
										$locataventes->addLocataclone($newLocata);
										$newLocata->addLocataventesclone($locataventes);
										$em->persist($locataventes);	
										$em->persist($newLocata);
										$em->flush();
										
										//Faut établir un montant global des ventes pour la facturation
										$montantlocaventestot += $ven->getMontantvente();//Pour toutes les ventes
										
									}
								}else{}//echo 'pas premier mois locavente';
			
								//Nous actualisons le locataclone avec les nouvelles données
								$newLocata->setMontantloc($totalht);//echo 'totalhtcomplet'.$totalht;
								$newLocata->setMontantlocavente($montantlocaventestot);//echo 'ventes'.$montantlocaventestot;
								$newLocata->setTransportaller($totaltrspaller);//echo 'transportaller'.$totaltrspaller;
								$newLocata->setTransportretour($totaltrspretour);//echo 'transportaller'.$totaltrspretour;
								$newLocata->setContributionverte($contributionverte);//echo 'contributionverte'.$contributionverte;
								$newLocata->setAssurance($assurance);//echo 'assurance'.$assurance;
								$em->persist($newLocata);
								$em->flush();
								
								if($newLocata->getRemise() > 0)
								{
									$totalht = $totalht - ($totalht * $newLocata->getRemise()/100);
								}
								//On vérifie si le transport aller a déjà été facturé
								$locatador = $em->getRepository('BaclooCrmBundle:Afacturer')
											->findOneBy(array('piece' => $locata->getId(), 'libelle' => 'Transport aller'));							
								
								if($newLocata->getAssurance() > 0)
								{ 
									$rc = $newLocata->getAssurance(); 
								}
								else
								{
									$rc = 0; 
								}
								
								if($newLocata->getContributionverte() > 0)
								{
									$ecopart = $newLocata->getContributionverte();
								}
								else
								{
									$ecopart = 0;						
								}

								$compteclient = '411'.$newLocata->getClientid();
								// echo 'montantcarb!!!';echo $montantcarb;
								$totalhtfac = $newLocata->getMontantloc() + $newLocata->getTransportaller() + $newLocata->getTransportretour() + $newLocata->getContributionverte() + $newLocata->getAssurance() + $newLocata->getMontantlocavente() + $newLocata->getMontantcarb();
								$tva20 = $totalhtfac * 0.20;



								$totalttc = $totalhtfac + $tva20;//echo 'totalhtfac'.$totalhtfac;
								// echo $compteclient;echo '----'.$totalttc;echo '------'.$locata->getId().'****';
								$journalori = $em->getRepository('BaclooCrmBundle:Afacturer')
												->findOneBy(array('compte'=>$compteclient, 'debit'=>$totalttc, 'piece'=>$locata->getId()));
								if(isset($journalori))
								{
									$message = 1;
									$date = $journalori->getDate();
								}
								else
								{
									$message = 0;
									//Fin ajout table factures
								}	
										//Ajout à la table factures
											$facta = $em->getRepository('BaclooCrmBundle:Facta')
														->findOneByControle('1234');				
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
											
											$client = $em->getRepository('BaclooCrmBundle:Fiche')		
											 ->findOneById($locata->getClientid());
											if($client->getDelaireglement() == 1)
											{
												$next45 = $today;
											}
											elseif($client->getDelaireglement() == 2)
											{
												$next45 = date('Y-m-d', strtotime($today . '+45 days'));
											}
											elseif($client->getDelaireglement() == 3)
											{
												$next45 = date('Y-m-d', strtotime($today . '+30 days'));
											}
											else
											{
												$next45 = $today;
											}						
											
											$facture->setNumfacture($numfacture);
											$facture->setCodelocata($locata->getId());
											$facture->setClientid($locata->getClientid());
											$facture->setClient($locata->getClient());
											$facture->setTotalht($totalhtfac);
											$facture->setTotalttc($totalttc);
											$facture->setEcheance($next45);
											// $facture->setDebutloc($locata->getDebutloc());
											// $facture->setFinloc($locata->getFinloc());
											$facture->setChantier($locata->getNomchantier());
											$facture->setReglement(0);
											$facture->setDatepaiement('');
											$facture->setModepaiement('');
											$facture->setTypedoc('facture');
											$facture->setDatecrea($today);
											$facture->setLocatacloneid($newLocata->getId());
											$facture->addFactum($facta);
											$facta->addFacture($facture);
											$em->persist($facture);
											$em->flush();
											//Fin ajout table factures	
						}
						else
						{
							$em->remove($newLocata);
							$em->flush();
						}					
					}else{echo 'on n y va pas';}
				}
			
				//Partie ventes
			
				foreach($vendatot as $vendas)
				{
					$venda = $em->getRepository('BaclooCrmBundle:Venda')
								->findOneById($vendas['f_id']);						
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
				
					if(empty($facturemois) && $venda->getBdcrecu() == 1)
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

							$client = $em->getRepository('BaclooCrmBundle:Venda')
										->findOneById($venda->getClientid());					
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

						}					
						$compteclient = '411'.$venda->getClientid();
						
						$tva20 = $venda->getMontantvente() * 0.20;
						$totalhtfac = $venda->getMontantvente();
						$totalttc = $totalhtfac + $tva20;

						//Avant de saisir les écritures on vérifie qu'elle n'aient pas déjà été saisies
						$journalori = $em->getRepository('BaclooCrmBundle:Afacturer')
										->findOneBy(array('compte'=>$compteclient, 'debit'=>$totalttc, 'piece'=>$venda->getId()));
						if(isset($journalori))
						{
							$message = 1;
							$date = $journalori->getDate();
						}
						else
						{
							$message = 0;
							$afacturer2 = new Afacturer;
							$afacturer2->setDate($today);
							$afacturer2->setJournal('VT');
							$afacturer2->setCompte($compteclient);
							$afacturer2->setDebit($totalttc);			
							$afacturer2->setCredit(0);			
							$afacturer2->setLibelle($venda->getClient());			
							$afacturer2->setPiece('V-'.$venda->getId());			
							$afacturer2->setEcheance(date('Y-m-d', strtotime("+45 days")));			
							$afacturer2->setAnalytique('Client');
							$em->persist($afacturer2);
							$em->flush();
										
							$client = $em->getRepository('BaclooCrmBundle:Fiche')
										->findOneById($venda->getClientid());
						
						$v = 0;
						$e = 0;
						$t = 0;
						$ass = 0;
						$ann = 0;
						
						foreach($venda->getVentes() as $vente)
						{
							if($vente->getCodifvente() == 'vente' && $v == 0)
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
								$ventes->setDebit(0);			
								$ventes->setCredit($venteslignes);			
								$ventes->setLibelle($venda->getClient());			
								$ventes->setPiece('V-'.$venda->getId());				
								$ventes->setEcheance(date('Y-m-d', strtotime("+45 days")));			
								$ventes->setAnalytique('Vente');
								$em->persist($ventes);
								$em->flush();
								$v++;
							}
							elseif($vente->getCodifvente() == 'entretien' && $e == 0)
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
								$entretien->setDebit(0);			
								$entretien->setCredit($entretienlignes);			
								$entretien->setLibelle($venda->getClient());			
								$entretien->setPiece('V-'.$venda->getId());				
								$entretien->setEcheance(date('Y-m-d', strtotime("+45 days")));			
								$entretien->setAnalytique('Entretien');
								$em->persist($entretien);
								$em->flush();	
								$e++;
							}
							elseif($vente->getCodifvente() == 'transport' && $t == 0)
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
								$transport->setDebit(0);			
								$transport->setCredit($transportlignes);			
								$transport->setLibelle($venda->getClient());			
								$transport->setPiece('V-'.$venda->getId());				
								$transport->setEcheance(date('Y-m-d', strtotime("+45 days")));			
								$transport->setAnalytique('transport');
								$em->persist($transport);
								$em->flush();
								$t++;
							}
							elseif($vente->getCodifvente() == 'assurance' && $ass == 0)
							{
								$assurance = new Afacturer;
								$assurance->setDate($today);
								$assurance->setJournal('VT');
								if($client->getTypeclient() == 'france')
								{
									$assurance->setCompte(706200);		
								}
								elseif($client->getTypeclient() == 'ue')
								{
									$assurance->setCompte(706201);		
								}
								elseif($client->getTypeclient() == 'export')
								{
									$assurance->setCompte(706202);		
								}else{$assurance->setCompte(9999999);}
								$assurance->setDebit(0);			
								$assurance->setCredit($vente->getMontantvente());			
								$assurance->setLibelle($venda->getClient());			
								$assurance->setPiece('V-'.$venda->getId());				
								$assurance->setEcheance(date('Y-m-d', strtotime("+45 days")));			
								$assurance->setAnalytique('assurance');
								$em->persist($assurance);
								$em->flush();
								$ass++;								
							}
							elseif($vente->getCodifvente() == 'annexes' && $ann == 0)
							{
								$annexes = new Afacturer;
								$annexes->setDate($today);
								$annexes->setJournal('VT');
								if($client->getTypeclient() == 'france')
								{
									$annexes->setCompte(708000);		
								}
								elseif($client->getTypeclient() == 'ue')
								{
									$annexes->setCompte(708000);		
								}
								elseif($client->getTypeclient() == 'export')
								{
									$annexes->setCompte(708000);		
								}else{$annexes->setCompte(9999999);}
								$annexes->setDebit(0);			
								$annexes->setCredit($annexeslignes);			
								$annexes->setLibelle($venda->getClient());			
								$annexes->setPiece('V-'.$venda->getId());				
								$annexes->setEcheance(date('Y-m-d', strtotime("+45 days")));			
								$annexes->setAnalytique('annexes');
								$em->persist($annexes);
								$em->flush();
								$ann++;
							}
						}
							
							if($client->getTypeclient() == 'france')
							{
								$ftva = new Afacturer;
								$ftva->setDate($today);
								$ftva->setJournal('VT');
								$ftva->setCompte(445710);
								$ftva->setDebit(0);			
								$ftva->setCredit($tva20);			
								$ftva->setLibelle('TVA collectee');			
								$ftva->setPiece('V-'.$venda->getId());				
								$ftva->setEcheance(date('Y-m-d', strtotime("+45 days")));			
								$ftva->setAnalytique('Tva');
								$em->persist($ftva);
								$em->flush();						
							}
								//Ajout à la table factures
									$facta = $em->getRepository('BaclooCrmBundle:Facta')
												->findOneByControle('1234');				
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
										$next45 = date('Y-m-d', strtotime($venda->getDate() . '+30 days'));
									}
									else
									{
										$next45 = $venda->getDate();
									}
									
									$facture->setNumfacture($numfacture);
									$facture->setCodelocata('V-'.$venda->getId());
									$facture->setClientid($venda->getClientid());
									$facture->setClient($venda->getClient());
									$facture->setTotalht($totalhtfac);
									$facture->setTotalttc($totalttc);
									$facture->setEcheance($next45);
									$facture->setChantier($venda->getClient());
									$facture->setReglement(0);
									$facture->setDatepaiement('');
									$facture->setModepaiement('');
									$facture->setTypedoc('facture');
									$facture->setDatecrea($today);
									$facture->setLocatacloneid($venda->getId());
									$facture->addFactum($facta);
									$facta->addFacture($facture);
									$em->persist($facture);
									$em->flush();
								//Fin ajout table factures					
						}			
					}
					else{echo 'faut pas enregistrer les ventes';}
				}
				//Fin partie ventes
				
				//Partie achat
				$debutmois = date('Y-m-01', strtotime(" -1 month"));//Debut mois précédent	
				$finmois = date('Y-m-d');//Fin mois précédent			
// print_r($achatstot);
				foreach($achatstot as $locatafrss)
				{//echo 'rrrrrrr'.$locatafrss['f_id'];
					//On recupère le locatafrs pour le bdc sélectionné
					$locatafrs = $em->getRepository('BaclooCrmBundle:Locatafrs')
								->findOneById($locatafrss['f_id']);	

					//On reconstitue  le code bdc			
					$codecontrat = 'H-'.$locatafrs->getId();
					
					//Sur ce BDC à facturer y a-t-il des locations
					$nbloc = 0;//Nombre de loc
					$nbautresachats = 0;//Nombre d'autres achats
					
					//On boucle pour récupérer chaque ligne du BDC
					foreach($locatafrs->getLocationsfrs() as $loca)
					{
						//S'il s'agit d'un location on monte le compteur de 1 
						if($loca->getReference() == 'location')
						{
							$nbloc++;
						}
						else //SI c'est un achat autre on montre le compteur de 1
						{
							$nbautresachats++; 
						}
					}
					//On récupère les factures ayant ce code bdc
					$facturemois = $em->getRepository('BaclooCrmBundle:Factures')
								->facturesmois($codecontrat);
					
					//Initialisation des compteurs et tableaux
					$totalht = 0;//echo $locid;			
					$locationlignes = 0;			
					$assurancelignes = 0;		
					$contrubutionvertelignes = 0;		
					$piecelignes = 0;			
					$transportlignes = 0;			
					$materiellignes = 0;			
					$prestationlignes = 0;			
					$autrelignes = 0;			
					$descriptionvente = array();			
					$descriptionpiece = array();			
					$descriptiontransport = array();			
					$descriptionannexe = array();
					$descriptionautre = array();
// echo 'nbloc'.$nbloc;echo 'etatbdc'.$locatafrs->getEtatbdc();				
					//Point 1 : pas de loc
					//S'il 'n ya pas de factures avec ce n°de bdc et que le bdc à facturer a été validé
					//et qu'il n'y a pas de location dessus et au moins 1 autre achat, on gènère la facturation
					if(empty($facturemois) && $locatafrs->getEtatbdc() == 1 && $nbloc == 0 && $nbautresachats > 0)
					{//echo 'point1';
						include('achatnormal.php');					
					}//S'il y a un mélange de Locations et d'achats					
					elseif($nbloc > 0 && $nbautresachats > 0)//Point 2 : Loc + autres achats
					{//echo 'point2';
						include('achatsousloc.php');	
					}//S'il n'y a que des locations				
					elseif($nbloc > 0 && $nbautresachats == 0)//Point 3 : 100% Loc
					{//echo 'point3';
						include('achatsousloc.php');	
					}
					else{}
						$comptefrs = '401'.$locatafrs->getFournisseurid();
						
						$totalhtfac = $montantloc + $transportbdc + $contributionverte + $assurance;
						$tva20 = $totalhtfac * 0.20;
						$totalttc = $totalhtfac + $tva20;//echo 'totalhtfac'.$totalhtfac;	
					
						//Avant de saisir les écritures on vérifie qu'elle n'aient pas déjà été saisies
						$journalori = $em->getRepository('BaclooCrmBundle:Factures')
										->findOneBy(array('clientid'=>$locatafrs->getFournisseurid(), 'codelocata'=>'H-'.$locatafrs->getId()));

						$ii = 0;
						if(isset($journalori))//Si le bdc a deja été cloner on regarde si les locations du mois l'ont été
						{//echo 'ori set';
							// foreach($journalori as $loco)//PAS DE FOREACH ICI CAR ON EST SUR UN OBKET
							// {echo 'BBBBBBBB';
								$time=strtotime($journalori->getDatecrea());
								$moisclone=date("F",$time);
								$anneeclone=date("Y",$time);
//echo '$moiscourant'.$moiscourant;echo ' vs $moisclone'.$moisclone;						
								$moiscourant=date("F");
								$anneecourante=date("Y");
								if($moisclone == $moiscourant && $anneeclone == $anneecourante)
								{
									$ii++;//existe deja
								}
							// }		
						}
						else
						{//echo 'ori pas set';
							$ii = 0;
						}	
// echo '$comptefrs'.$locatafrs->getFournisseurid(); echo 'codelocata'.'H-'.$locatafrs->getId();  	echo 'ii'.$ii;						
						if($ii == 0)
						{//echo '?????';							
							$message = 0;
							$afacturer2 = new Afacturer;
							$afacturer2->setDate($today);
							$afacturer2->setJournal('ACH');
							$afacturer2->setCompte($comptefrs);
							$afacturer2->setDebit(0);			
							$afacturer2->setCredit($totalttc);			
							$afacturer2->setLibelle($locatafrs->getFournisseur());			
							$afacturer2->setPiece('H-'.$locatafrs->getId());			
							$afacturer2->setEcheance(date($today));			
							$afacturer2->setAnalytique('Fournisseur '.$locatafrs->getFournisseur());
							$em->persist($afacturer2);
							$em->flush();
										
							$client = $em->getRepository('BaclooCrmBundle:Fiche')
										->findOneById($locatafrs->getFournisseurid());
						
							$v = 0;
							$e = 0;
							$t = 0;
							$ass = 0;
							$ann = 0;
						
							foreach($locatafrs->getLocationsfrs() as $locationsfrs)
							{
								if($locationsfrs->getReference() == 'location' && $v == 0)
								{
									$location = new Afacturer;
									$location->setDate($today);
									$location->setJournal('ACH');
									$location->setCompte(6135);										
									$location->setDebit($totalhtfac);			
									$location->setCredit(0);			
									$location->setLibelle($locatafrs->getFournisseur());			
									$location->setPiece('H-'.$locatafrs->getId());				
									$location->setEcheance(date($today));			
									$location->setAnalytique('Achat - Location de materiel');
									$em->persist($location);
									$em->flush();
									$v++;
								}
								elseif($locationsfrs->getReference() == 'piece' && $e == 0)
								{
									$piece = new Afacturer;
									$piece->setDate($today);
									$piece->setJournal('ACH');
									$piece->setCompte(615);										
									$piece->setDebit($piecelignes);			
									$piece->setCredit(0);			
									$piece->setLibelle($locatafrs->getFournisseur());			
									$piece->setPiece('H-'.$locatafrs->getId());				
									$piece->setEcheance(date($today));			
									$piece->setAnalytique('Achat - Piece');
									$em->persist($piece);
									$em->flush();	
									$e++;
								}
								// elseif(($locationsfrs->getReference() == 'transport' or $locationsfrs->getReference() == 'transportaller' or $locationsfrs->getReference() == 'transportretour') && $t == 0)
								elseif($locationsfrs->getReference() == 'transport' or $locationsfrs->getReference() == 'transportaller' or $locationsfrs->getReference() == 'transportretour')
								{
									$transport = new Afacturer;
									$transport->setDate($today);
									$transport->setJournal('ACH');
									$transport->setCompte(6241);		
									$transportlignes += $locationsfrs->getMontantht();
									$transport->setDebit($transportlignes);			
									$transport->setCredit(0);			
									$transport->setLibelle($locatafrs->getFournisseur());			
									$transport->setPiece('H-'.$locatafrs->getId());				
									$transport->setEcheance(date($today));			
									$transport->setAnalytique('Achat Transport');
									$em->persist($transport);
									$em->flush();
									$t++;
								}
								elseif($locationsfrs->getReference() == 'prestation' && $ass == 0)
								{
									$prestation = new Afacturer;
									$prestation->setDate($today);
									$prestation->setJournal('ACH');
									$prestation->setCompte(604);		
									
									$prestation->setDebit($locationsfrs->getMontantht());			
									$prestation->setCredit(0);			
									$prestation->setLibelle($locatafrs->getFournisseur());			
									$prestation->setPiece('H-'.$locatafrs->getId());				
									$prestation->setEcheance(date($today));			
									$prestation->setAnalytique('Achat - Prestation de services');
									$em->persist($prestation);
									$em->flush();
									$ass++;								
								}
								elseif($locationsfrs->getReference() == 'autre' && $ann == 0)
								{
									$materiel = new Afacturer;
									$materiel->setDate($today);
									$materiel->setJournal('ACH');
									$materiel->setCompte(607);		
									
									$materiel->setDebit(0);			
									$materiel->setCredit($materiellignes);			
									$materiel->setLibelle($locatafrs->getFournisseur());			
									$materiel->setPiece('H-'.$locatafrs->getId());				
									$materiel->setEcheance(date($today));			
									$materiel->setAnalytique('Autres achats');
									$em->persist($materiel);
									$em->flush();
									$ann++;
								}
							}
							
							if($client->getTypeclient() == 'france')
							{
								$ftva = new Afacturer;
								$ftva->setDate($today);
								$ftva->setJournal('ACH');
								$ftva->setCompte(44566);
								$ftva->setDebit($tva20);			
								$ftva->setCredit(0);			
								$ftva->setLibelle('TVA collectee');			
								$ftva->setPiece('H-'.$locatafrs->getId());				
								$ftva->setEcheance(date($today));			
								$ftva->setAnalytique('Tva');
								$em->persist($ftva);
								$em->flush();						
							}
								//Ajout à la table factures
									$facta = $em->getRepository('BaclooCrmBundle:Facta')
												->findOneByControle('1234');				
									$facture = new Factures;
									
									$query = $em->createQuery(
										'SELECT b.id
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
									$numfacture = date('Y').'H'.($lastnumfact++);
												
									$client = $em->getRepository('BaclooCrmBundle:Fiche')		
									 ->findOneById($locatafrs->getFournisseurid());
									if($client->getDelaireglement() == 1)
									{
										$next45 = $today;
									}
									elseif($client->getDelaireglement() == 2)
									{
										$next45 = date('Y-m-d', strtotime($today . '+45 days'));
									}
									elseif($client->getDelaireglement() == 3)
									{
										$next45 = date('Y-m-d', strtotime($today . '+30 days'));
									}
									else
									{
										$next45 = $today;
									}
									if(isset($newLocata)){$id = $newLocata->getId();}else{$id = 0;} 
									$facture->setNumfacture($numfacture);
									$facture->setCodelocata('H-'.$locatafrs->getId());
									$facture->setClientid($locatafrs->getFournisseurid());
									$facture->setClient($locatafrs->getFournisseur());
									$facture->setTotalht($totalhtfac);
									$facture->setTotalttc($totalttc);
									$facture->setEcheance($next45);
									$facture->setChantier($locatafrs->getFournisseur());
									$facture->setReglement(0);
									$facture->setDatepaiement('');
									$facture->setModepaiement('');
									$facture->setTypedoc('bon de commande');
									$facture->setLocatacloneid($id);
									$facture->setDatecrea($today);
									$facture->addFactum($facta);
									$facta->addFacture($facture);
									$em->persist($facture);
									$em->flush();
								//Fin ajout table factures					
						}
				}
				//Fin partie achat
		//FIN FACTURATION MENSUELLE