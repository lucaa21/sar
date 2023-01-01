<?php
use Bacloo\CrmBundle\Entity\Afacturer;
use Bacloo\CrmBundle\Entity\Factures;
use Bacloo\CrmBundle\Entity\Locataclone;
use Bacloo\CrmBundle\Entity\Locationsclone;
use Bacloo\CrmBundle\Entity\Locationsslclone;
use Bacloo\CrmBundle\Entity\Locataventesclone;
			
			$em = $this->getDoctrine()->getManager();
			$qrcode = 0;
				//On récupère les codes contrats à facturer afin de faire une boucle
				//Pour cela on recherche les locations et locationssl avec une fin de loc > à la fin du mois
				//On les met dasn un tableau
			if($message != 'vente')
			{
				$locata = $em->getRepository('BaclooCrmBundle:Locata')
							->findOneById($codecontrat);

			//CHECK LOCATACLONE
				$locataclonedeja = $em->getRepository('BaclooCrmBundle:Locataclone')
							->findByOldid($codecontrat);
// echo $codecontrat;
// print_r($locataclonedeja);							
				if(empty($locataclonedeja) or !isset($locataclonedeja))
				{//echo '>>>>>'.$locata->getId().'<<<<<';
					//clonage et copie locata
					$oldLocata = $locata;
					$newLocata = new Locataclone();
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
					
					$totalht = 0;
					$transport = 0;
					$jour50 = 0;
					$montantcarb = 0;			
			//FIN CHECK LOCATACLONE							
							
				//On fait ensuite une boucle sur les id de locata puis à l'intérieur de celle ci
				//on fait tourner une boucle sur les locations et locationssl en reprenant le principe de
				//la facturation définitive
				
				//DEBUT DE LA FACTURATION MENSUELLE
				//Partie locations
					$premiermois = 0;
					foreach($locata->getLocations() as $loca)
					{
						//CHECK LOCATACLONE
							//clonage et copie locations	
							// $locatio  = $em->getRepository('BaclooCrmBundle:Locations')		
							   // ->findOneByCodemachineinterne($ecode);
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
							$locations->setNbjloc($loca->getNbjloc());
							$locations->setNbjlocass($loca->getNbjlocass());
							$locations->setMontantloc($loca->getMontantloc());
							$locations->setMontantcarb($loca->getMontantcarb());
							$locations->setEnergie($loca->getEnergie());
							$locations->setDatereprise($loca->getDatereprise());
							$locations->setDebutloc($loca->getDebutloc());
							$locations->setFinloc($loca->getFinloc());									
							$locations->setTransportaller($loca->getTransportaller());
							$locations->setTransportretour($loca->getTransportretour());									
							if($loca->getDebutloc() >= date('Y-m-01') && $loca->getDebutloc() <= date('Y-m-t'))
							{
								$premiermois++;
							}									
							$locations->setContributionverte($loca->getContributionverte());						
							$locations->setAssurance($loca->getAssurance());
							$locations->setJour50($loca->getJour50());
							$locations->setJour100($loca->getJour100());
							$locations->setOldid($loca->getId());
							$locations->addLocataclone($newLocata);
							$newLocata->addLocationsclone($locations);
							$em->persist($locations);	
							$em->persist($newLocata);
							$em->flush();						
						//FIN CHECK LOCATACLONE
						
							$finloc = strtotime ($loca->getFinloc());	
							$finlocsec = strtotime ($loca->getFinloc());	
							$dStart = $loca->getDebutloc();
							$dStartsec = strtotime ($loca->getDebutloc());
							$dEnd = $loca->getFinloc();
							$debutmois = $loca->getDebutloc();
							$debutmoissec = strtotime($debutmois);
							$finmois = $loca->getFinloc();
							$finmoissec = strtotime ($finmois);
							//Si date début antérieure au début du mois >> date début = début mois
							if($dStartsec <= $debutmoissec)
							{
								$dStart = $debutmois;
							}
							//Si date fin posterieure à fin du mois >> date début = début mois
							if($finlocsec >= $finmoissec)
							{
								$dEnd = $finmois;
							}
							//Si date début après début de mois alors $dstart = $dstart on ne fait rien.
							
							//1.Récupérer les données de la table Locata cf supra
								   
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

							//on calcule le nombre de jours de location
								$nbjloc = 0;
								foreach($aDates as $annee => $moiss)
								{
									foreach($moiss as $date => $mois)
									{
										foreach($mois as $dat)
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
											}	
										}
									}
								}	
								//Création du montant HT ligne par ligne
								$totalht = 0;//echo $locid;
								$totaltrspaller = 0;
								$totaltrspretour = 0;

								if(null !== $loca->getLoyerp1())
								{
									$totalht += $nbjloc * $loca->getLoyerp1();
								}
								elseif(null !== $loca->getLoyerp2())
								{
									$totalht += $nbjloc * $loca->getLoyerp2();
								}
								elseif(null !== $loca->getLoyerp3())
								{
									$totalht += $nbjloc * $loca->getLoyerp3();
								}
								elseif(null !== $loca->getLoyerp4())
								{
									$totalht += $loca->getLoyerp4();
								}
								elseif(null !== $loca->getLoyermensuel())
								{
									include('caclculnbjlocmensuelle.php');							
									$loyer = $loca->getLoyermensuel()/20;
									$totalht += $loyer * $nbjloc;
								}
								if(null !== $loca->getMontantcarb() && $loca->getMontantcarb()>0)
								{
									$montantcarb += $loca->getMontantcarb();
								}
								else
								{
									$montantcarb = 0;
								}
								if(null !== $loca->getTransportaller() && $loca->getTransportaller()>0)
								{
									$totaltrspaller += $loca->getTransportaller();
								}
								else
								{
									$totaltrspaller = 0;
								}
								if(null !== $loca->getTransportretour() && $loca->getTransportretour()>0)
								{
									$totaltrspretour += $loca->getTransportretour();
								}
								else
								{
									$totaltrspretour = 0;
								}
					}

					//Partie sous location
					foreach($locata->getLocationssl() as $loca)
					{
						//CREATION DU CLONE
							$locations = new Locationsslclone;
							$locations->setCodeclient($loca->getCodeclient());
							$locations->setEntid($loca->getCodeclient());
							$locations->setMachineid($loca->getMachineid());
							$locations->setEntreprise($loca->getEntreprise());
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
							$locations->setNbjloc($loca->getNbjloc());
							$locations->setNbjlocass($loca->getNbjlocass());
							$locations->setMontantloc($loca->getMontantloc());
							$locations->setMontantcarb($loca->getMontantcarb());
							$locations->setEnergie($loca->getEnergie());
							$locations->setDatereprise($loca->getDatereprise());
							$locations->setDebutloc($loca->getDebutloc());
							$locations->setFinloc($loca->getFinloc());									
							$locations->setTransportaller($loca->getTransportaller());
							$locations->setTransportretour($loca->getTransportretour());									
							if($loca->getDebutloc() >= date('Y-m-01') && $loca->getDebutloc() <= date('Y-m-t'))
							{
								$premiermois++;
							}	
							
							$locations->setContributionverte($loca->getContributionverte());													
							$locations->setAssurance($loca->getAssurance());
							$locations->setJour50($loca->getJour50());
							$locations->setJour100($loca->getJour100());
							$locations->setOldid($loca->getId());
							$locations->addLocataclone($newLocata);
							$newLocata->addLocationsslclone($locations);
							$em->persist($locations);	
							$em->persist($newLocata);
							$em->flush();						
						//FIN CREATION DU CLONE
						
						$finloc = strtotime ($loca->getFinloc());	
							$dStart = $loca->getDebutloc();
								$dStartsec = strtotime ($loca->getDebutloc());
								$dEnd = $loca->getFinloc();
								$debutmois = date('Y-m-01', strtotime(" -1 month"));//Debut mois précédent		
								$finmois = date('Y-m-t', strtotime(" -1 month"));//Fin mois précédent
								$debutmoissec = strtotime (date('Y-m-01'));	
							//Dans ce cas de figure la fin de loc est forcément comprise dans le mois en cours
							//Si date début antérieure au début du mois >> date début = début mois
							if($dStartsec <= $debutmoissec)
							{
								$dStart = $debutmois;
							}
							//Si date début après début de mois alors $dstart = $dstart on ne fait rien.
							
							//1.Récupérer les données de la table Locata cf supra
								   
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

							//on calcule le nombre de jours de location
								$nbjloc = 0;
								foreach($aDates as $annee => $moiss)
								{
									foreach($moiss as $date => $mois)
										{
											foreach($mois as $dat)
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
												}	
											}
										}
								}	
								//Création du montant HT ligne par ligne
								$totalht = 0;//echo $locid;
								$totaltrspaller = 0;
								$totaltrspretour = 0;

								if(null !== $loca->getLoyerp1())
								{
									$totalht += $nbjloc * $loca->getLoyerp1();
								}
								elseif(null !== $loca->getLoyerp2())
								{
									$totalht += $nbjloc * $loca->getLoyerp2();
								}
								elseif(null !== $loca->getLoyerp3())
								{
									$totalht += $nbjloc * $loca->getLoyerp3();
								}
								elseif(null !== $loca->getLoyerp4())
								{
									$totalht += $loca->getLoyerp4();
								}
								elseif(null !== $loca->getLoyermensuel())
								{
									include('caclculnbjlocmensuelle.php');							
									$loyer = $loca->getLoyermensuel()/20;
									$totalht += $loyer * $nbjloc;
								}
								if(null !== $loca->getMontantcarb() && $loca-getMontantcrab() > 0)
								{
									$totalht += $loca->getMontantcarb();
								}
								if(null !== $loca->getMontantcarb() && $loca->getMontantcarb()>0)
								{
									$montantcarb += $loca->getMontantcarb();
								}
								else
								{
									$montantcarb = 0;
								}
								if(null !== $loca->getTransportaller() && $loca->getTransportaller()>0)
								{
									$totaltrspaller += $loca->getTransportaller();
								}
								else
								{
									$totaltrspaller = 0;
								}
								if(null !== $loca->getTransportretour() && $loca->getTransportretour()>0)
								{
									$totaltrspretour += $loca->getTransportretour();
								}
								else
								{
									$totaltrspretour = 0;
								}
					}		
						if($premiermois > 0)
						{
							$montantlocaventes = 0; //Pour la vente
							$montantlocaventestot = 0;//Pour toutes les ventes							
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
						}
						else
						{
							$montantlocaventestot = 0;
						}
					
					if($locata->getRemise() > 0)
					{
						$totalht = $totalht - ($totalht * $locata->getRemise()/100);
					}
					//On vérifie si le transport aller a déjà été facturé
					$locatador = $em->getRepository('BaclooCrmBundle:Afacturer')
								->findOneBy(array('piece' => $locata->getId(), 'libelle' => 'Transport aller'));							
					
					if($locata->getAssurance() > 0)
					{ 
						$rc = $locata->getAssurance(); 
					}
					else
					{
						$rc = 0; 
					}
					
					if($locata->getContributionverte() > 0)
					{
						$ecopart = $locata->getContributionverte();
					}
					else
					{
						$ecopart = 0;						
					}

					$compteclient = '411'.$locata->getClientid();
					
					$tva20 = ($totalht + $ecopart + $rc + $totaltrspaller + $totaltrspretour + $montantcarb + $montantlocaventestot) * 0.20;
					$totalht = $totalht + $ecopart + $rc + $totaltrspaller + $totaltrspretour + $montantcarb + $montantlocaventestot;
					$totalttc = $totalht + $tva20;
					$today = date('Y-m-d');
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
						// $message = 0;
						// $afacturer = new Afacturer;
						// $afacturer->setDate($today);
						// $afacturer->setJournal('VT');
						// $afacturer->setCompte($compteclient);
						// $afacturer->setDebit($totalttc);			
						// $afacturer->setCredit(0);			
						// $afacturer->setLibelle($locata->getClient());			
						// $afacturer->setPiece($locata->getId());			
						// $afacturer->setEcheance(date('Y-m-d', strtotime("+45 days")));			
						// $afacturer->setAnalytique('Client');
						// $em->persist($afacturer);
						// $em->flush();
									
						// $client = $em->getRepository('BaclooCrmBundle:Fiche')
									// ->findOneById($locata->getClientid());
						
						// $ftotalht = new Afacturer;
						// $ftotalht->setDate($today);
						// $ftotalht->setJournal('VT');
						// if($client->getTypeclient() == 'france')
						// {
							// $ftotalht->setCompte(706100);		
						// }
						// elseif($client->getTypeclient() == 'ue')
						// {
							// $ftotalht->setCompte(706110);		
						// }
						// elseif($client->getTypeclient() == 'export')
						// {
							// $ftotalht->setCompte(706115);		
						// }else{$ftotalht->setCompte(9999999);}
						// $ftotalht->setDebit(0);			
						// $ftotalht->setCredit($totalht);			
						// $ftotalht->setLibelle('Location de matériel d\'élévation');			
						// $ftotalht->setPiece($locata->getId());				
						// $ftotalht->setEcheance(date('Y-m-d', strtotime("+45 days")));			
						// $ftotalht->setAnalytique('Loc');
						// $em->persist($ftotalht);
						// $em->flush();

						// if($montantlocaventestot > 0)
						// {
							// $ventes = new Afacturer;
							// $ventes->setDate($today);
							// $ventes->setJournal('VT');
							// if($client->getTypeclient() == 'france')
							// {
								// $ventes->setCompte(707100);		
							// }
							// elseif($client->getTypeclient() == 'ue')
							// {
								// $ventes->setCompte(707110);		
							// }
							// elseif($client->getTypeclient() == 'export')
							// {
								// $ventes->setCompte(707115);		
							// }else{$carburant->setCompte(9999999);}
							// $ventes->setDebit(0);			
							// $ventes->setCredit($montantcarb);			
							// $ventes->setLibelle('Vente de carburant');			
							// $ventes->setPiece($locata->getId());				
							// $ventes->setEcheance(date('Y-m-d', strtotime("+45 days")));			
							// $ventes->setAnalytique('Vente');
							// $em->persist($ventes);
							// $em->flush();
						// }
						
						// if($montantcarb > 0)
						// {
							// $carburant = new Afacturer;
							// $carburant->setDate($today);
							// $carburant->setJournal('VT');
							// if($client->getTypeclient() == 'france')
							// {
								// $carburant->setCompte(707100);		
							// }
							// elseif($client->getTypeclient() == 'ue')
							// {
								// $carburant->setCompte(707110);		
							// }
							// elseif($client->getTypeclient() == 'export')
							// {
								// $carburant->setCompte(707115);		
							// }else{$carburant->setCompte(9999999);}
							// $carburant->setDebit(0);			
							// $carburant->setCredit($montantcarb);			
							// $carburant->setLibelle('Vente de carburant');			
							// $carburant->setPiece($locata->getId());				
							// $carburant->setEcheance(date('Y-m-d', strtotime("+45 days")));			
							// $carburant->setAnalytique('Vente');
							// $em->persist($carburant);
							// $em->flush();
						// }
				
						// if($client->getTypeclient() == 'france')
						// {
							// $ftva = new Afacturer;
							// $ftva->setDate($today);
							// $ftva->setJournal('VT');
							// $ftva->setCompte(445710);
							// $ftva->setDebit(0);			
							// $ftva->setCredit($tva20);			
							// $ftva->setLibelle('TVA collectée');			
							// $ftva->setPiece($locata->getId());				
							// $ftva->setEcheance(date('Y-m-d', strtotime("+45 days")));			
							// $ftva->setAnalytique('Tva');
							// $em->persist($ftva);
							// $em->flush();						
						// }
						
						// if($locata->getAssurance() == 1)
						// {
							// $fassurance= new Afacturer;
							// $fassurance->setDate($today);
							// $fassurance->setJournal('VT');
							// if($client->getTypeclient() == 'france')
							// {
								// $fassurance->setCompte(706200);			
								// $fassurance->setLibelle('Assurance France');
							// }
							// elseif($client->getTypeclient() == 'ue')
							// {
								// $fassurance->setCompte(706201);			
								// $fassurance->setLibelle('Assurance UE');		
							// }
							// elseif($client->getTypeclient() == 'export')
							// {
								// $fassurance->setCompte(706202);			
								// $fassurance->setLibelle('Assurance Export');		
							// }
							// $fassurance->setDebit(0);			
							// $fassurance->setCredit($rc);			
							// $fassurance->setPiece($locata->getId());				
							// $fassurance->setEcheance(date('Y-m-d', strtotime("+45 days")));			
							// $fassurance->setAnalytique('Assurance');
							// $em->persist($fassurance);
							// $em->flush();					
						// }
						
						// if($locata->getContributionverte() == 1)
						// {
							// $fecopart = new Afacturer;
							// $fecopart->setDate($today);
							// $fecopart->setJournal('VT');
							// $fecopart->setCompte('xxxxxx'.$locata->getClientid());
							// $fecopart->setDebit(0);			
							// $fecopart->setCredit($ecopart);			
							// $fecopart->setLibelle('Frais environnementaux');			
							// $fecopart->setPiece($locata->getId());					
							// $fecopart->setEcheance(date('Y-m-d', strtotime("+45 days")));			
							// $fecopart->setAnalytique('Client');
							// $em->persist($fecopart);
							// $em->flush();					
						// }
						
					
						// if($locata->getTransportaller() > 0 && empty($locatador))
						// {
							// $taller = new Afacturer;
							// $taller->setDate($today);
							// $taller->setJournal('VT');
							// if($client->getTypeclient() == 'france')
							// {
								// $taller->setCompte(706210);			
								// $taller->setLibelle('Transport France');	
							// }
							// elseif($client->getTypeclient() == 'ue')
							// {
								// $taller->setCompte(706211);			
								// $taller->setLibelle('Transport UE');			
							// }
							// elseif($client->getTypeclient() == 'export')
							// {
								// $taller->setCompte(706212);			
								// $taller->setLibelle('Transport Export');			
							// }else{$ftotalht->setCompte(9999999);}
							// $taller->setDebit(0);			
							// $taller->setCredit($locata->getTransportaller());		
							// $taller->setPiece($locata->getId());				
							// $taller->setEcheance(date('Y-m-d', strtotime("+45 days")));			
							// $taller->setAnalytique('Transport aller');
							// $em->persist($taller);
							// $em->flush();					
						// }
						
						// if($locata->getTransportretour() > 0)
						// {
							// $tretour = new Afacturer;
							// $tretour->setDate($today);
							// $tretour->setJournal('VT');
							// if($client->getTypeclient() == 'france')
							// {
								// $tretour->setCompte(706210);			
								// $tretour->setLibelle('Transport France');	
							// }
							// elseif($client->getTypeclient() == 'ue')
							// {
								// $tretour->setCompte(706211);			
								// $tretour->setLibelle('Transport UE');			
							// }
							// elseif($client->getTypeclient() == 'export')
							// {
								// $tretour->setCompte(706212);			
								// $tretour->setLibelle('Transport Export');			
							// }else{$ftotalht->setCompte(9999999);}
							// $tretour->setDebit(0);			
							// $tretour->setCredit($locata->getTransportretour());			
							// $tretour->setPiece($locata->getId());				
							// $tretour->setEcheance(date('Y-m-d', strtotime("+45 days")));			
							// $tretour->setAnalytique('Transport retour');
							// $em->persist($tretour);
							// $em->flush();					
						}
								
							//Ajout à la table factures
								$facta = $em->getRepository('BaclooCrmBundle:Facta')
											->findOneByControle('1234');				
								$facture = new Factures;
echo 'FACTURE';								
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

								$numfacture = date('Y').($lastnumfact++);
								
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
								else
								{
									$next45 = $locata->getDatemodif();
								}	
								
								$facture->setNumfacture($numfacture);
								$facture->setCodelocata($locata->getId());
								$facture->setClientid($locata->getClientid());
								$facture->setClient($locata->getClient());
								$facture->setTotalht($totalht);
								$facture->setTotalttc($totalttc);
								$facture->setEcheance($next45);
								$facture->setSelection(0);
								$facture->setEncompta(0);
								// $facture->setDebutloc($locata->getDebutloc());
								// $facture->setFinloc($locata->getFinloc());
								$facture->setChantier($locata->getNomchantier());
								$facture->setReglement(0);
								$facture->setDatepaiement('');
								$facture->setModepaiement('');
								$facture->setTypedoc('facture');
								$facture->setDatecrea(date('Y-m-d'));
								$facture->setCompteurfac($lastnumfact);
								$facture->setUser($locata->getUser());
								$facture->setLocatacloneid($newLocata->getId());
								$facture->addFactum($facta);
								$facta->addFacture($facture);
								$em->persist($facture);
								$em->flush();
								//Fin ajout table factures
					}				
					else{ echo 'xxxxxxxxxxxxxxxxxxxx';}
			}
			else
			{
				// $facture = new Factures;

				// $query = $em->createQuery(
					// 'SELECT b.compteurfac
					// FROM BaclooCrmBundle:Factures b
					// ORDER BY b.id DESC'
				// )->setMaxResults(1);
				// $lastnumfact = $query->getOneOrNullResult();
				// if(empty($lastnumfact) or !isset($lastnumfact) or $lastnumfact == null)
				// {
					// $lastnumfact = 0;//echo 'vide';
				// }
				// else
				// {
					// $lastnumfact = $query->getSingleScalarResult();//echo 'pas vide';
				// }

				// $numfacture = date('Y').($lastnumfact++);
				
				// $client = $em->getRepository('BaclooCrmBundle:Fiche')		
				 // ->findOneById($locata->getClientid());
				// if($client->getDelaireglement() == 1)
				// {
					// $next45 = $locata->getDatemodif();
				// }
				// elseif($client->getDelaireglement() == 2)
				// {
					// $next45 = date('Y-m-d', strtotime($locata->getDatemodif() . '+45 days'));
				// }
				// elseif($client->getDelaireglement() == 3)
				// {
					// $next45 = date('Y-m-d', strtotime($locata->getDatemodif() . '+30 days'));
				// }
				// else
				// {
					// $next45 = $locata->getDatemodif();
				// }	
				
				// $facture->setNumfacture($numfacture);
				// $facture->setCodelocata($locata->getId());
				// $facture->setClientid($locata->getClientid());
				// $facture->setClient($locata->getClient());
				// $facture->setTotalht($totalht);
				// $facture->setTotalttc($totalttc);
				// $facture->setEcheance($next45);
				// $facture->setSelection(0);
				// $facture->setEncompta(0);
				// $facture->setChantier($locata->getClient());
				// $facture->setReglement(0);
				// $facture->setDatepaiement('');
				// $facture->setModepaiement('');
				// $facture->setTypedoc('facture');
				// $facture->setDatecrea($today);
				// $facture->setCompteurfac($lastnumfact);
				// $facture->setUser($locata->getUser());
				// $facture->setLocatacloneid($vendaid);
				// $em->persist($facture);
				// $em->flush();
			}	

		//FIN FACTURATION COMPTANT