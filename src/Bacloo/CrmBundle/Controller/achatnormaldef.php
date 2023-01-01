<?php

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
		$contributionverte = 0;
	}					
