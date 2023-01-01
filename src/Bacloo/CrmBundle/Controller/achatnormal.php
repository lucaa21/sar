<?php
use Bacloo\CrmBundle\Entity\Factures;
use Bacloo\CrmBundle\Entity\Afacturer;

	foreach($locatafrs->getLocationsfrs() as $loca)
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
		$totalhtfac = $montantloc + $transportbdc + $assurance;
		$totalttc = $totalhtfac*1.2;
		$contributionverte = 0;
		
		$loca->setCloture(1);
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
		if(isset($locatafrs)){$id = $locatafrs->getId();}else{$id = 0;} 
		$facture->setNumfacture($locatafrs->getNumbdc());
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
		$facture->setCompteurfac($lastnumfact);
		$facture->setUser($locatafrs->getUser());
		// $facture->addFactum($facta);
		$facta->addFacture($facture);
		$em->persist($facture);
		$em->flush();
		
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
echo '$comptefrs'.$locatafrs->getFournisseurid(); echo 'codelocata'.'H-'.$locatafrs->getId();  	echo 'ii'.$ii;	
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
		
		if($ii == 0)
		{//echo '?????';							

				//Ajout à la table factures
					$facta = $em->getRepository('BaclooCrmBundle:Facta')
								->findOneByControle('1234');				
					$facture = new Factures;
								
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
					$facture->setNumfacture($newLocata->getNumbdc());
					$facture->setCodelocata('H-'.$locatafrs->getId());
					$facture->setClientid($locatafrs->getFournisseurid());
					$facture->setClient($locatafrs->getFournisseur());
					$facture->setTotalht($totalhtfac);
					$facture->setTotalttc($totalttc);
					$facture->setEcheance($next45);
					$facture->setChantier($locatafrs->getFournisseur());
					$facture->setReglement(0);
					$facture->setEmcompta(1);
					$facture->setDatepaiement('');
					$facture->setModepaiement('');
					$facture->setTypedoc('bon de commande');
					$facture->setLocatacloneid($id);
					$facture->setDatecrea($today);
					// $facture->addFactum($facta);
					$facta->addFacture($facture);
					$em->persist($facture);
					$em->flush();
				//Fin ajout table factures					
		}
						