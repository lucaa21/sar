<?php
use Bacloo\CrmBundle\Entity\Locatafrsclone;
use Bacloo\CrmBundle\Entity\Locationsfrsclone;

	foreach($locatafrs->getLocationsfrs() as $loca)
	{
		if($loca->getReference() != 'location' && $loca->getReference() != 'contributionverte' && $loca->getReference() != 'assurance')	
		{
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

			$client = $em->getRepository('BaclooCrmBundle:Fiche')
						->findOneById($locatafrs->getFournisseurid());					
			//On affecte chaque ligne à sa famille
			if($loca->getReference() == 'assurance')
			{
				$assurancelignes += $montantligne;
				$descriptionlocation[] = $loca->getDesignation();
			}
			elseif($loca->getReference() == 'piece')
			{
				$piecelignes += $montantligne;
				$descriptionpiece[] = $loca->getDesignation();
			}
			elseif($loca->getReference() == 'transport')
			{
				$transportlignes += $montantligne;
				$descriptiontransport[] = $loca->getDesignation();
			}
			elseif($loca->getReference() == 'materiel')
			{
				$materiellignes += $montantligne;
				$descriptionmateriel[] = $loca->getDesignation();
			}
			elseif($loca->getReference() == 'autre')
			{
				$autrelignes += $montantligne;
				$descriptionautre[] = $loca->getDesignation();
			}
			elseif($loca->getReference() == 'prestation')
			{
				$prestationlignes += $montantligne;
			}
			//Fin affectation ligne à sa famille
			
			$loca->setMontantht($montantligne);
			$em->persist($loca);
			$montantloc = $montantligne;
			$transportbdc = $transportlignes;
			$assurance = $assurancelignes;
			$contributionverte = 0;
	//echo '>>>>>'.$locatafrs->getId().'<<<<<';
		}
	}
	//clonage et copie locata
	$oldLocata = $locatafrs;
	$newLocata = new Locatafrsclone;
	$oldReflection = new \ReflectionObject($oldLocata);
	$newReflection = new \ReflectionObject($newLocata);
// echo '11111';

	foreach ($oldReflection->getProperties() as $property)
	{
		if ($newReflection->hasProperty($property->getName())) {
			$newProperty = $newReflection->getProperty($property->getName());
			$newProperty->setAccessible(true);
			$newProperty->setValue($newLocata, $property->getValue($oldLocata));
		}
	}
	$newLocata->setOldid($oldLocata->getId());
	$em->persist($newLocata);
	$em->flush();
	
	$fournisseur = $em->getRepository('BaclooCrmBundle:Fiche')
		->findOneById($loca->getFournisseurid());

	foreach($locatafrs->getLocationsfrs() as $loca)
	{
		if($loca->getReference() != 'location' && $loca->getReference() != 'contributionverte' && $loca->getReference() != 'assurance')	
		{	
			$locations = new Locationsfrsclone;
			$locations->setCodeclient($loca->getCodeclient());
			$locations->setFournisseurid($loca->getFournisseurid());
			$locations->setFournisseur($loca->getFournisseur());
			$locations->setReference($loca->getReference());
			$locations->setDebutloc($loca->getDebutloc());
			$locations->setFinloc($loca->getFinloc());										
			$locations->setMensuel($loca->getMensuel());
			$locations->setDesignation($loca->getDesignation());
			$locations->setMontantht($loca->getMontantht());
			$locations->setPu($loca->getPu());
			$locations->setQuantite($loca->getQuantite());
			$locations->setCodelocationsl($loca->getCodelocationsl());
			$locations->setFacturersamedi($loca->getFacturersamedi());
			$locations->setFacturerdimanche($loca->getFacturerdimanche());
			$locations->setOldid($loca->getId());
			if($loca->getCloture() == 1){$cloture = 1;}else{$cloture = 0;}
			$locations->setCloture($cloture);
			$locations->addLocatafrsclone($newLocata);
			$newLocata->addLocationsfrsclone($locations);
			$em->persist($locations);	
			$em->persist($newLocata);
			$em->flush();
		}
	}
	foreach($locatafrs->getLocationsfrs() as $loca)
	{	
		if($loca->getReference() == 'location' || $loca->getReference() == 'contributionverte' || $loca->getReference() == 'assurance')	
		{
			// echo 'normalsl';echo $locatafrs->getFournisseur();	
			//Soit premier mois et certaines loc terminées
			//Soit premier mois et aucune loc terminée
			//Soit premier mois et toutes les locs sont terminées

			//On fixe la date de fin de mois	
			$moisder = 0;//Si a 0 pas de loc commencée le mois précédent
			$touter = 0; //Toutes les loc du contrat sont terminées si éhal à 1
			if($nblocters == $nblocs)//Si le nb de locations terminées est = au nb de lcoations total du contrat on peut facturer tout car toutes les loc sont terminées
			{
				//echo 'ttes loc terminées';
				$touter = 1;
				$finmois = date('Y-m-d');//echo $finmois;
				$finmoissec = strtotime($finmois);
			}
			elseif($premiermois > 0 && $nblocters == 0)//premier mois mais pas de loc terminée
			{
				//echo 'premier mois mais pas de loc terminée';
				$touter = 0;
				$premiermois = 1;
				$moisder = 1;
				$finmois = date('Y-m-t', strtotime(" -1 month"));//echo $finmois;
				$finmoissec = strtotime($finmois);
			}
			elseif($premiermois == 0 && $nblocters == 0)//pas premier mois mais pas de loc terminée
			{
				//echo 'pas premier mois mais pas de loc terminées';
				$touter = 0;
				$premiermois = 0;
				$finmois = date('Y-m-t', strtotime(" -1 month"));//echo $finmois;
				$finmoissec = strtotime($finmois);
			}
			elseif($nblocters != $nblocs) //Si loc total différent de loc terminées total
			{
				//on vérifie alors si des loc et locsl en cours ont démarrées le mois dernier
				//S'il y en a pas, attendre la fin du mois pour la compta ou que la loc soit terminée
			
				foreach($locatafrs->getLocationsfrs() as $loca)
				{//echo 'x fournissseur x'.$loca->getFournisseur();echo '666';
					if(strtotime($loca->getDebutloc()) < strtotime(date('Y-m-01')) and strtotime($loca->getFinloc()) > strtotime(date('Y-m-01')) )//loc commencée mois précédent mais pas finie
					{//echo '99999';
						$moisder++;
						$finmois = date('Y-m-t', strtotime(" -1 month"));//Fin mois précédent
						$finmoissec = strtotime ($finmois);
					}
					// elseif(strtotime($loca->getDebutloc()) < strtotime(date('Y-m-01')) and strtotime($loca->getFinloc()) < strtotime(date('Y-m-01')) )//loc commencée mois précédent mais finie
					// {echo '88888';
						// $moisder++;
						// $finmois = $loca->getFinloc();;//Fin mois précédent
						// $finmoissec = strtotime ($finmois);				
					// }
					// else
					// {
						// echo 'XXXXXXXX';echo date('Y-m-01');echo $loca->getDebutloc();
					// }
				}
			}
		}
	}
	
	$transportbdc = 0;	
	$totaltrspaller = 0;
	$totaltrspretour = 0;
	$jour50 = 0;
	$jour100 = 0;
	$montantcarb = 0;
	$premiermois = 0;
	$contributionverte = 0;
	$assurance = 0;	

	foreach($locatafrs->getLocationsfrs() as $loca)
	{
		if($loca->getReference() == 'location' || $loca->getReference() == 'contributionverte' || $loca->getReference() == 'assurance')	
		{
			// echo 'LOOOOOOOOOOOL';
			//déterminons si loc terminée
			$nblocters = 0;
			if(strtotime($loca->getFinloc()) > strtotime($debutmois) && strtotime($loca->getFinloc()) < strtotime($finmois))
			{
				$nblocters++;
			}
			//déterminons si loc en cours
			$locencours = 0;
			if(strtotime($loca->getDebutloc()) < strtotime($finmois) && strtotime($loca->getFinloc()) > strtotime($finmois))
			{
				//echo '555';
				$locencours++;
			}							
			if($locencours > 0 or $nblocters > 0)//si loc en cours ou loc terminée
			{
				$finloc = strtotime ($loca->getFinloc());	
				$finlocsec = strtotime ($loca->getFinloc());	
				$dStart = $loca->getDebutloc();
				$dStartsec = strtotime ($loca->getDebutloc());
				$dEnd = $finmois;
// echo 'xxxxxxxxxxxxxxxxx';echo $finmois; echo $loca->getFinloc();

				//Si date début antérieure au début du mois >> date début = début mois
				if($dStartsec <= $debutmoissec)
				{
					$dStart = $debutmois;
				}
				else
				{
					//si premier mois
					$premiermois = 0;
					if($dStartsec > $debutmoissec && $dStartsec <= $finmoissec  && ($loca->getReference() == 'location' or $loca->getReference() == 'contributionverte' or $loca->getReference() == 'assurance'))
					{
						$premiermois++;
						$dStart = $loca->getDebutloc();
					}
				}
				//Si date fin posterieure à fin du mois >> date fin = fin mois
				if($finlocsec >= $finmoissec)
				{					
					$finmois = date('Y-m-t', strtotime(" -1 month"));//Fin mois précédent
					$finmoissec = strtotime ($finmois);
				}
				$begin = new DateTime($dStart);
				$end = new DateTime($dEnd);
				$end = $end->modify( '+1 day' ); 
					
				$locationsclonedeja = $em->getRepository('BaclooCrmBundle:Locationsfrsclone')
					->findOneBy(array('fournisseurid' => $loca->getFournisseurid(), 'oldid' => $loca->getId(), 'debutloc' => $dStart, 'finloc' => $dEnd));
//echo '*fournissseur*'.$loca->getFournisseur();//echo 	' oldid'.$loca->getId(); 
// echo ' debutloc'.$dStart; echo 'finloc'.$dEnd;
				if(!empty($locationsclonedeja))//si loc déjà enregistrée
				{
					//echo 'loc clone déjà enregistrée';
				}
				else
				{//echo 'empty locationsclonedeja';
					$interval = DateInterval::createFromDateString('1 day');
					$period = new DatePeriod($begin, $interval, $end);
					$nbjloc = 0;
					$nbjlocass = 0;

					foreach($period as $dt)
					{
						$newformat = $dt->format("D");
						$nbjlocass++;
						if($loca->getFacturersamedi() == 1 && $newformat == 'Sat')
						{
							$nbjloc++;

						}
						elseif($loca->getFacturerdimanche() == 1 && $newformat == 'Sun')
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
					$fournisseur = $em->getRepository('BaclooCrmBundle:Fiche')
						->findOneById($loca->getFournisseurid());

					$locations = new Locationsfrsclone;
					$locations->setCodeclient($loca->getCodeclient());
					$locations->setFournisseurid($loca->getFournisseurid());
					$locations->setFournisseur($loca->getFournisseur());
					$locations->setReference($loca->getReference());
					if($locencours > 0 && strtotime($loca->getDebutloc()) < $debutmoissecinit)
					{
						$locations->setDebutloc($debutmoisinit);
					}
					else
					{
						$locations->setDebutloc($loca->getDebutloc());
					}
					
					if($locencours > 0 && strtotime($loca->getFinloc()) >= date('Y-m-01'))
					{
						$locations->setFinloc(date('Y-m-t', strtotime(" -1 month")));
					}
					else
					{
						$locations->setFinloc($loca->getFinloc());
					}										
					$locations->setMensuel($loca->getMensuel());
					$locations->setDesignation($loca->getDesignation());
					//Calcul montantloc
					if($loca->getMensuel() == 1)
					{
						if($loca->getDebutloc() >= $debutmois && $loca->getDebutloc() <= $finmois)
						{
							$premiermois++;
						}
						
						if($nbjloc < 20)
						{
							$montantloc = ($loca->getPu()/20)*$nbjloc;
						}
						else
						{
							$montantloc = $loca->getPu();
							$nbjloc = 20;
							$nbjlocass = 28;
						}
						//calcul de l'ecoparticiaption
						if($fournisseur->getFrseco() == 1)
						{
							if($fournisseur->getUniteeco() == '%')
							{
								$ecopartunite = $montantloc * $fournisseur->getMontanteco()/100;
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
						$locations->setMontantht($montantloc + $contributionverte);

						//calcul de l'assurance
						if($fournisseur->getFrsrc() == 1)
						{
							if($fournisseur->getUniterc() == '%')
							{
								$assuranceunite = $montantloc * $fournisseur->getMontantrc()/100;
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
					{
						if($loca->getDebutloc() >= $debutmois && $loca->getDebutloc() <= $finmois)
						{
							$montantloc = $loca->getPu()*$nbjloc;
							
							//calcul de l'ecoparticiaption
							if($fournisseur->getFrseco() == 1)
							{
								if($fournisseur->getUniteeco() == '%')
								{
									$ecopartunite = $montantloc * $fournisseur->getMontanteco()/100;
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
							$locations->setMontantht($montantloc + $contributionverte);
							$totalht += $montantloc + $contributionverte;
							$locations->setPu($loca->getPu());
							if($loca->getReference() == 'assurance')
							{
								$locations->setQuantite($nbjlocass);
							}
							elseif($loca->getReference() == 'contributionverte')
							{
								$locations->setQuantite($nbjloceco);
							}
							else
							{
								$locations->setQuantite($nbjloc);
							}
							//calcul de l'assurance
							if($fournisseur->getFrsrc() == 1)
							{
								if($fournisseur->getUniterc() == '%')
								{
									$assuranceunite = $montantloc * $fournisseur->getMontantrc()/100;
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
					}
					$locations->setCodelocationsl($loca->getCodelocationsl());
					$locations->setFacturersamedi($loca->getFacturersamedi());
					$locations->setFacturerdimanche($loca->getFacturerdimanche());

//Calculer l'assurance pour le clone comme l'eco

					$locations->setOldid($loca->getId());
					$locations->addLocatafrsclone($newLocata);
					$newLocata->addLocationsfrsclone($locations);
					$em->persist($locations);	
					$em->persist($newLocata);
					$em->flush();

					//Création du montant HT ligne par ligne
										
					if($loca->getReference() == 'transportaller' && $loca->getMontantht()>0 && $loca->getDebutloc() >= $debutmois && $loca->getDebutloc() <= $finmois)
					{
						$transportbdc += $loca->getMontantht();
					}
					
					if($loca->getReference() == 'transportretour' && $loca->getTransportretour()>0 && $loca->getFinloc() >= $debutmois && $loca->getFinloc() <= $finmois)
					{
						$transportbdc += $loca->getMontantht();
					}
				}
			}
			else
			{}//echo 'pas enregistré parc';
			// echo '***'.$nbjloc.'-'.$nbjloc*$loyer.'-'.$totalht.'***';
		}

		//Nous actualisons le locataclone avec les nouvelles données
		$newLocata->setMontantloc($totalht);//echo 'totalhtcomplet'.$totalht;
		$em->persist($newLocata);
		$em->flush();	
// echo 'XXXXXXXXXXXXtotalht'.$totalht;
		$montantloc = $totalht;

	}