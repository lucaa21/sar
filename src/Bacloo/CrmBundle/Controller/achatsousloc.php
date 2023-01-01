<?php
use Bacloo\CrmBundle\Entity\Locatafrsclone;
use Bacloo\CrmBundle\Entity\Locationsfrsclone;
use Bacloo\CrmBundle\Entity\Factures;
use Bacloo\CrmBundle\Entity\Afacturer;

echo ' jjjjj'.$locatafrss['f_fournisseur'];	
//Nombre de location total sur le contrat
$nblocs = $nbloc;
$nblocm = 0;//Pour ce mois-ci
$nblocm1 = 0;//Pour le mois dernier
$locencours = 0;
echo ' Debutloc'.$loca->getDebutloc();
echo ' finmois'.$finmois;
echo ' Finloc'.$loca->getFinloc();
echo ' debutmois'.$debutmois;
$nbitem = 0;
foreach($locatafrs->getLocationsfrs() as $loca)
{
	$nbitem++;
	if($loca->getReference() == 'location')
	{
		//m-1
		if(strtotime($loca->getDebutloc()) <= strtotime(date('Y-m-01')) and strtotime($loca->getFinloc()) >= $debutmoissecinit){$nblocm1++;}
		
		//m
		if(strtotime($loca->getDebutloc()) <= strtotime(date('Y-m-d')) and strtotime($loca->getFinloc()) >= $debutmoissecinit){$nblocm++;}

		//déterminons si loc en cours
		if(strtotime($loca->getDebutloc()) <= strtotime($finmois) && strtotime($loca->getFinloc()) >= strtotime($finmois))
		{
			echo '555';
			$locencours++;
		}	
	}
}

echo ' nbitem';echo $nbitem; 
// echo 'locata frs'.$locatafrs->getFournisseur();
//Déterminons combien de locations terminées sur le contrat
$nblocater = 0;
foreach($locatafrs->getLocationsfrs() as $loca)
{echo '111'; echo $finmois;
	if(strtotime($loca->getFinloc()) > strtotime($debutmois) && strtotime($loca->getFinloc()) < strtotime($finmois) && $loca->getReference() == 'location')
	{
		$nblocater++;
	}
}
//Nombre de loc total terminées sur le contrat
$nblocters = $nblocater;
					
foreach($locatafrs->getLocationsfrs() as $loca)
{echo '222';
	//Sommes-nous au premier mois ?
	$premiermois = 0;
	$moismilieu = 0;
	if(strtotime($loca->getDebutloc()) >= strtotime($debutmois) && strtotime($loca->getDebutloc()) <= strtotime($finmois) && ($loca->getReference() == 'location' or $loca->getReference() == 'contributionverte' or $loca->getReference() == 'assurance'))
	{
		$premiermois++;
	}
}

$nbfacterm = 0;
$nbfacterm1 = 0;

$locataclonedeja = $em->getRepository('BaclooCrmBundle:Locatafrsclone')
			->findBy(array('oldid' => $locatafrss['f_id']));
$dejafacm = 0;
$dejafacm1 = 0;
if(!empty($locataclonedeja))
{
	echo 'IL EST DEDANS';
	foreach($locataclonedeja as $locoa)
	{
		//CE MOIS-CI
		$dejafacm = 0;
		$dejafacm1 = 0;
		if(date("Y-m", strtotime($locoa->getDatemodif())) == date("Y-m"))
		{
			foreach($locoa->getLocationsfrsclone() as $loca)
			{
				// if($loca->getDef() == 1){$nbfacterm++;}
				if(date("Y-m", strtotime($loca->getFinloc())) == date("Y-m")){$dejafacm++;}
				if(date("Y-m", strtotime($loca->getFinloc())) == date('Y-m', strtotime(" -1 month"))){$dejafacm1++;}
			}
		}
		elseif(date("Y-m", strtotime($locoa->getDatemodif())) == date('Y-m', strtotime(" -1 month")))//LE MOIS DERNIER
		{
			foreach($locoa->getLocationsfrsclone() as $loca)
			{
				// if($loca->getDef() == 1){$nbfacterm1++;}
				if(date("Y-m", strtotime($loca->getDebutloc())) == date('Y-m', strtotime(" -1 month"))){$dejafacm1++;}
			}
		}
	}
}
//echo 'DDDDD'.$premiermois;echo 'debutlmois'.$debutmois;
//Les achats normaux n'ont pas de date de debut et fin donc pas possible de connaitre le premier mois par la date
//Donc faire plutot premiermois si premierinscription de ce locata

if(empty($locataclonedeja)){$premiermois = 1;}else{$premiermois = 0;}
// if(empty($locataclonedeja)){$premiermois = 0;}else{$premiermois = 0;}
//echo '9999';echo $premiermois; echo'hhhh'; echo $loca->getReference();

echo ' premiermois'.$premiermois;
echo ' nblocm'.$nblocm;
echo ' nblocm1'.$nblocm1;
echo ' dejafacm'.$dejafacm;
echo ' dejafacm1'.$dejafacm1;
echo ' nblocater'.$nblocater;
echo ' locencours'.$locencours;

//Si on est le premier mois et que la ref n'est pas location ou contributionverte ou assurance
// if($premiermois > 0 && ($loca->getReference() != 'location' && $loca->getReference() != 'contributionverte' && $loca->getReference() != 'assurance') )
// {
	// echo '333';echo $premiermois;
	// include('achatnormalloc.php');
// }
// else// Si pas premier mois et pas achat normal
// {echo '444';echo $locatafrs->getFournisseur();	

	$go = 'XXX';
	//Si toutes les locations sont en cours et pas encore facturées ?
	if($nblocm == $locencours && ($nblocm1 - $dejafacm1) != 0 )
	{
		//Clonage moisder
		echo 'CLONE1';
		$go = 'clonage';
		if($loca->getAechoir() == 1)
		{
			$finmois = date('Y-m-t');
		}
		else
		{
			$finmois = date('Y-m-t', strtotime(" -1 month"));
		}
	}
	elseif($nblocater == $nblocm && $nblocm - $dejafacm != 0)//Si toutes les locations sont terminées et qu'elles n'ont pas été comptabilisées
	{
		//Clonage
		echo 'CLONE2';
		$go = 'clonage';
		$finmois = $loca->getFinloc();
	}
	elseif($nblocater > 0 && $nblocm > $nblocater && ($nblocater - $nblocm != $dejafacm - $nblocm))//Si une partie des loc est terminée et qu'elle n'a pas été comptabilisée
	{
		//Clonage
		echo 'CLONE3';
		$go = 'clonage';
		$finmois = $loca->getFinloc();
	}
		
echo 'GOOOOO'.$go;	
	if($go == 'clonage')
	{		
		//clonage et copie locata
		$oldLocata = $locatafrs;
		$newLocata = new Locatafrsclone;
		$oldReflection = new \ReflectionObject($oldLocata);
		$newReflection = new \ReflectionObject($newLocata);
echo '11111';

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
echo '22222';
// echo '33333';						
	// }
		$totalht = 0;
		$transportbdc = 0;	
		$totaltrspaller = 0;
		$totaltrspretour = 0;
		$jour50 = 0;
		$jour100 = 0;
		$montantcarb = 0;
		$contributionverte = 0;
		$assurance = 0;	

		foreach($locatafrs->getLocationsfrs() as $loca)
		{echo 'PUUUU'.$loca->getPu();
			//echo '>>>fournissseur<<<'.$loca->getFournisseurid();
			//déterminons si loc terminée
			$nblocters = 0;
			if(strtotime($loca->getFinloc()) > strtotime($debutmois) && strtotime($loca->getFinloc()) < strtotime($finmois))
			{
				$nblocters++;
			}
echo ' Reference'.$loca->getReference();
echo ' nblocater'.$nblocater;
echo ' locencours'.$locencours;							
			if($locencours > 0 or $nblocater > 0 or ($premiermois > 0 && ($loca->getReference() != 'location' or $loca->getReference() != 'contributionverte' or $loca->getReference() != 'assurance')))//si loc en cours ou loc terminée
			{
				$finloc = strtotime ($loca->getFinloc());	
				$finlocsec = strtotime ($loca->getFinloc());	
				$dStart = $loca->getDebutloc();
				$dStartsec = strtotime ($loca->getDebutloc());
				$dEnd = $finmois;
echo 'xxxxxxxxxxxxxxxxx';//echo $finmois; echo $loca->getFinloc();
				$finmoissec = strtotime($finmois);
				//Si date début antérieure au début du mois >> date début = début mois
				if($dStartsec <= $debutmoissec)
				{
					$dStart = $debutmois;
				}
				else
				{
					//si premier mois
					if($dStartsec > $debutmoissec && $dStartsec <= $finmoissec  && ($loca->getReference() == 'location' or $loca->getReference() == 'contributionverte' or $loca->getReference() == 'assurance'))
					{
						$dStart = $loca->getDebutloc();
					}
				}
				//Si date fin posterieure à fin du mois >> date fin = fin mois
				if($finlocsec >= $finmoissec)
				{					
					$finmois = date('Y-m-t', strtotime(" -1 month"));//Fin mois précédent
					$finmoissec = strtotime($finmois);
				}
				else
				{
					$finmois = date('Y-m-d');
					$finmoissec = strtotime($finmois);
				}
				$begin = new DateTime($dStart);
				$end = new DateTime($dEnd);
				$end = $end->modify( '+1 day' );
					
				$locationsclonedeja = $em->getRepository('BaclooCrmBundle:Locationsfrsclone')
					->findOneBy(array('fournisseurid' => $loca->getFournisseurid(), 'oldid' => $loca->getId(), 'debutloc' => $dStart, 'finloc' => $dEnd, 'designation' => $loca->getDesignation(), 'def' => 1));
//echo '*fournissseur*'.$loca->getFournisseur();//echo 	' oldid'.$loca->getId(); 
echo ' debutloc'.$dStart; echo 'finloc'.$dEnd;
				if(!empty($locationsclonedeja))//si loc déjà enregistrée
				{
					echo 'loc clone déjà enregistrée';
				}// elseif(empty($locationsclonedeja) && ($loca->getReference() == 'location' || $loca->getReference() == 'contributionverte' || $loca->getReference() == 'assurance'))				
				elseif(empty($locationsclonedeja))
				{echo 'empty locationsclonedeja';
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

echo 'laa';		
echo 'nbjloc'.$nbjloc;					
					//clonage et copie locations	
					// $locatio  = $em->getRepository('BaclooCrmBundle:Locations')		
					   // ->findOneByCodemachineinterne($ecode);
					// $assurancela =($nbjlocass/$loca->getNbjloc())*$loca->getAssurance(); 
					
					$fournisseur = $em->getRepository('BaclooCrmBundle:Fiche')
						->findOneById($loca->getFournisseurid());
echo 'PREMIERMOIS2'.$premiermois;
echo 'REFERENCE2'.$loca->getReference();
					if($premiermois > 0 && ($loca->getReference() != 'location' && $loca->getReference() != 'contributionverte' && $loca->getReference() != 'assurance') )
					{echo 'CLONAGE PAS LOC';echo $loca->getReference();
						$locations = new Locationsfrsclone;
						$locations->setCodeclient($loca->getCodeclient());
						$locations->setFournisseurid($loca->getFournisseurid());
						$locations->setFournisseur($loca->getFournisseur());
						$locations->setReference($loca->getReference());
						$locations->setDebutloc('');					
						$locations->setFinloc('');							
						$locations->setMensuel($loca->getMensuel());
						$locations->setDesignation($loca->getDesignation());
						$locations->setCodelocationsl($loca->getCodelocationsl());
						$locations->setFacturersamedi($loca->getFacturersamedi());
						$locations->setFacturerdimanche($loca->getFacturerdimanche());
						$locations->setQuantite($loca->getQuantite());
						$locations->setPu($loca->getPu());
						$locations->setMontantht($loca->getMontantht());
						$locations->setOldid($loca->getId());
						if($loca->getCloture() == 1){$cloture = 1;}else{$cloture = 0;}
						$locations->setCloture($cloture);
						$locations->addLocatafrsclone($newLocata);
						$newLocata->addLocationsfrsclone($locations);
						$em->persist($locations);	
						$em->persist($newLocata);
						$em->flush();
						$totalht += $loca->getMontantht();						
					}
					elseif($loca->getReference() == 'location' or $loca->getReference() == 'contributionverte' or $loca->getReference() == 'assurance')
					{echo 'CLONAGE LOC';echo $loca->getReference();
						$locations = new Locationsfrsclone;
						$locations->setCodeclient($loca->getCodeclient());
						$locations->setFournisseurid($loca->getFournisseurid());
						$locations->setFournisseur($loca->getFournisseur());
						$locations->setReference($loca->getReference());
						if($locencours > 0 && strtotime($loca->getDebutloc()) < strtotime(date('Y-m-01')) && strtotime($loca->getDebutloc()) >= strtotime(date('Y-m-01', strtotime(" -1 month"))))
						{echo 'DEBUTLOC221X';echo $debutmoisinit;
							$locations->setDebutloc($loca->getDebutloc());
						}
						elseif($locencours > 0 && strtotime($loca->getDebutloc()) < strtotime(date('Y-m-01', strtotime(" -1 month"))))
						{echo 'DEBUTLOC222X';echo $debutmoisinit;
							$locations->setDebutloc(date('Y-m-01', strtotime(" -1 month")));
						}
						elseif($locencours == 0 && strtotime($loca->getDebutloc()) < strtotime(date('Y-m-01')))
						{echo 'DEBUTLOC223X';echo $debutmoisinit;
							$locations->setDebutloc(date('Y-m-01'));
						}
						else
						{echo 'DEBUTLOC33X';echo $debutmoisinit;
							$locations->setDebutloc($loca->getDebutloc());
						}
						
						if($locencours > 0 && strtotime($loca->getFinloc()) > strtotime(date('Y-m-d')))
						{echo 'FINLOC MOISPREC';
							if($loca->getaechoir() == 1)
							{
								$locations->setFinloc(date('Y-m-t'));
							}
							else
							{
								$locations->setFinloc(date('Y-m-t', strtotime(" -1 month")));
							}
						}
						else
						{echo 'FINLOC MOISCOURANT';
							$locations->setFinloc($loca->getFinloc());
						}										
						$locations->setMensuel($loca->getMensuel());
						$locations->setDesignation($loca->getDesignation());
						//Calcul montantloc
						if($loca->getMensuel() == 1)
						{
							if(strtotime($loca->getDebutloc()) >= strtotime($debutmois) && strtotime($loca->getDebutloc()) <= strtotime($finmois))
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
								if($fournisseur->getBasecalculeco() == 1 && $premiermois > 0)
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
							$locations->setContributionverte($contributionverte);

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
								if($fournisseur->getBasecalculrc() == 1 && $premiermois > 0)
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
							$locations->setAssurance($assurance);
							$locations->setQuantite(1);
							$locations->setPu($loca->getPu());
							$locations->setMontantht($montantloc + $assurance + $contributionverte);						
						}							
						else//Si Loyer pas mensuel
						{//echo 'PAS MENSUEL';echo $loca->getPu();echo 'nbjloc';echo $nbjloc;
							// if(strtotime($loca->getDebutloc()) >= strtotime($debutmois) && strtotime($loca->getDebutloc()) <= strtotime($finmois))
							// {
								$montantloc = $loca->getPu()*$nbjloc;
								echo 'ttttttttttttttttt';
								//calcul de l'ecoparticiaption
								if($fournisseur->getFrseco() == 1)
								{//echo '///';
									if($fournisseur->getUniteeco() == '%')
									{
										$ecopartunite = $montantloc * $fournisseur->getMontanteco()/100;
									}
									else
									{
										$ecopartunite = $fournisseur->getMontanteco();
									}
									if($fournisseur->getBasecalculeco() == 1 && $premiermois > 0)
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
									else
									{
										$nbjloceco = 0;	
									}									
								}
								else//si pas d'eco
								{
									$contributionverte = 0;
									$nbjloceco = 0;
								}
								$locations->setContributionverte($contributionverte);
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
									if($fournisseur->getBasecalculrc() == 1 && $premiermois > 0)
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
								$locations->setAssurance($assurance);
								$locations->setMontantht($montantloc + $assurance + $contributionverte);							
							// }
						}
						$locations->setCodelocationsl($loca->getCodelocationsl());
						$locations->setFacturersamedi($loca->getFacturersamedi());
						$locations->setFacturerdimanche($loca->getFacturerdimanche());

	//Calculer l'assurance pour le clone comme l'eco

						$locations->setOldid($loca->getId());
						if($loca->getCloture() == 1){$cloture = 1;}else{$cloture = 0;}
						$locations->setCloture($cloture);
						$locations->addLocatafrsclone($newLocata);
						$newLocata->addLocationsfrsclone($locations);
						$em->persist($locations);	
						$em->persist($newLocata);
						$em->flush();
						$totalht += $montantloc;
					}
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
			{echo 'PAS CLONE NON LOC';}//echo 'pas enregistré parc';
			// echo '***'.$nbjloc.'-'.$nbjloc*$loyer.'-'.$totalht.'***';
			if(strtotime($loca->getfinloc()) <= strtotime(date('Y-m-d')))
			{
				$loca->setCloture(1);
			}
		}
		//Nous actualisons le locataclone avec les nouvelles données
		$newLocata->setMontantloc($totalht);//echo 'totalhtcomplet'.$totalht;
		$em->persist($newLocata);
		$em->flush();	
echo 'totalht'.$totalht;echo 'transport'.$transportbdc;echo 'assurance'.$assurance;
		$montantloc = $totalht;
		$totalhtfac = $montantloc + $transportbdc + $assurance + $contributionverte;
		$tva20 = $totalhtfac * 0.20;
		$totalttc = $totalhtfac + $tva20;//echo 'totalhtfac'.$totalhtfac;		
	//Ajout à la table factures
		// $facta = $em->getRepository('BaclooCrmBundle:Facta')
					// ->findOneByControle('1234');				
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
		if($client->getTypeclient() == 'export')
		{
			$facture->setTotalttc($totalhtfac);
		}
		else
		{
			$facture->setTotalttc($totalttc);
		}
		$facture->setEcheance($next45);
		$facture->setChantier($locatafrs->getFournisseur());
		$facture->setReglement(0);
		$facture->setDatepaiement('');
		$facture->setModepaiement('');
		$facture->setTypedoc('bon de commande');
		$facture->setLocatacloneid($id);
		$facture->setDatecrea($today);
		$facture->setCompteurfac($lastnumfact);
		$facture->setUser($locatafrs->getUser());
		// $facture->addFactum($facta);
		// $facta->addFacture($facture);
		$em->persist($facture);
		$em->flush();
		
		$comptefrs = '401'.$locatafrs->getFournisseurid();
		
		$totalhtfac = $montantloc + $transportbdc + $contributionverte + $assurance;
		if($client->getTypeclient() == 'france')
		{
			$tva20 = $totalhtfac * 0.20;
			$totalttc = $totalhtfac + $tva20;//echo 'totalhtfac'.$totalhtfac;	
		}
		else
		{
			$tva20 = 0;
			$totalttc = $totalhtfac;//echo 'totalhtfac'.$totalhtfac;	
		}
			
	}
	// echo 'zzzzzzzzzzz'.$contributionverte;