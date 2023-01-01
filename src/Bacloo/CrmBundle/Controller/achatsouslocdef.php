<?php
use Bacloo\CrmBundle\Entity\Locatafrsclone;
use Bacloo\CrmBundle\Entity\Locationsfrsclone;

// echo 'jjjjj'.$locatafrss['f_fournisseur'];	
//Nombre de location total sur le contrat
$nblocs = $nbloc;
// echo 'locata frs'.$locatafrs->getFournisseur();
//Déterminons combien de locations terminées sur le contrat
$nblocater = 0;
foreach($locatafrs->getLocationsfrsclone() as $loca)
{//echo '111'; echo $finmois;
	if(strtotime($loca->getFinloc()) > strtotime($debutmois) && strtotime($loca->getFinloc()) < strtotime($finmois) && $loca->getReference() == 'location')
	{
		$nblocater++;
	}
}
//Nombre de loc total terminées sur le contrat
$nblocters = $nblocater;
					
foreach($locatafrs->getLocationsfrsclone() as $loca)
{//echo '222';
	//Sommes-nous au premier mois ?
	$premiermois = 0;
	$moismilieu = 0;
	if(strtotime($loca->getDebutloc()) >= strtotime($debutmois) && strtotime($loca->getDebutloc()) <= strtotime($finmois) && ($loca->getReference() == 'location' or $loca->getReference() == 'contributionverte' or $loca->getReference() == 'assurance'))
	{
		$premiermois++;
	}
}
//echo 'DDDDD'.$premiermois;echo 'debutlmois'.$debutmois;
//Les achats normaux n'ont pas de date de debut et fin donc pas possible de connaitre le premier mois par la date
//Donc faire plutot premiermois si premierinscription de ce locata
$locataclonedeja = $em->getRepository('BaclooCrmBundle:Locatafrsclone')
			->findBy(array('oldid' => $locatafrs->getID()));

if(empty($locataclonedeja)){$premiermois = 1;}else{$premiermois = 0;}
// if(empty($locataclonedeja)){$premiermois = 0;}else{$premiermois = 0;}
//echo '9999';echo $premiermois; echo'hhhh'; echo $loca->getReference();

if($premiermois > 0 && ($loca->getReference() != 'location' && $loca->getReference() != 'contributionverte' && $loca->getReference() != 'assurance') )
{
	echo '333';echo $premiermois;
	include('achatnormallocdef.php');
}
else
{//echo '444';echo $locatafrs->getFournisseur();	
	//Soit premier mois et certaines loc terminées
	//Soit premier mois et aucune loc terminée
	//Soit premier mois et toutes les locs sont terminées
//echo 'UUUUUU'.$premiermois;
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
	
		foreach($locatafrs->getLocationsfrsclone() as $loca)
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
	}else{//echo 'x319x';
	}	

	$ii = 0;//Si à 0 la l'achat n'a pas été facturé
	if(isset($locataclonedeja))//Si le bdc a deja été cloné on regarde si les locations du mois l'ont été
	{
		foreach($locataclonedeja as $loco)
		{//echo 'BBBBBBBB';
			$time=strtotime($loco->getDatemodif());
			$moisclone=date("F",$time);
			$anneeclone=date("Y",$time);
			
			$moiscourant=date("F");
			$anneecourante=date("Y");
			if($moisclone == $moiscourant && $anneeclone == $anneecourante)
			{
				$ii++;//existe deja
			}
		}
		// $locataclonedeja2 = $em->getRepository('BaclooCrmBundle:Locatafrsclone')
					// ->findBy(array('fournisseur' => $locatafrs->getFournisseur(),'oldid' => $locatafrss['f_id'], 'datemodif' => $locatafrss['f_datemodif']));			
	}
	else
	{
		$ii = 0;
	}	

		$newLocata = $locatafrs;

// echo '22222';
// echo '33333';						
	// }
		$totalht = 0;
		$transportbdc = 0;	
		$totaltrspaller = 0;
		$totaltrspretour = 0;
		$jour50 = 0;
		$jour100 = 0;
		$montantcarb = 0;
		$premiermois = 0;
		$contributionverte = 0;
		$assurance = 0;	

		foreach($locatafrs->getLocationsfrsclone() as $loca)
		{
			//echo '>>>fournissseur<<<'.$loca->getFournisseurid();
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
				elseif(empty($locationsclonedeja) && ($loca->getReference() == 'location' || $loca->getReference() == 'contributionverte' || $loca->getReference() == 'assurance'))
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

//echo 'laa';		echo 'nbjloc'.$nbjloc;					
					//clonage et copie locations	
					// $locatio  = $em->getRepository('BaclooCrmBundle:Locations')		
					   // ->findOneByCodemachineinterne($ecode);
					// $assurancela =($nbjlocass/$loca->getNbjloc())*$loca->getAssurance(); 
					$fournisseur = $em->getRepository('BaclooCrmBundle:Fiche')
						->findOneById($loca->getFournisseurid());

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
					}							
					else//Si Loyer pas mensuel
					{//echo 'PAS MENSUEL';echo $loca->getPu();echo 'nbjloc';echo $nbjloc;
						// if(strtotime($loca->getDebutloc()) >= strtotime($debutmois) && strtotime($loca->getDebutloc()) <= strtotime($finmois))
						// {
							$montantloc = $loca->getPu()*$nbjloc;
							
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
						// }
					}


					//Création du montant HT ligne par ligne
					
					$totalht += $montantloc + $contributionverte;
										
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
// echo 'totalht'.$totalht;
		$montantloc = $totalht;
	
	// elseif(($ii == 0 && $moisder == 0) || $touter == 1)
	// {
		// echo '******';echo $locatafrs->getFournisseur();echo $loca->getReference();
		// }	
}	