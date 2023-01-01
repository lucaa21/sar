<?php

		//2.On génère les entêtes de colonnes à partir de la fonction createplanning
			$iStart = strtotime ($dStarta2);//Formate une date/heure locale avec la Something is wronguration locale
			$iEnd = strtotime ($dEnda2);
			if (false === $iStart || false === $iEnd) {
				return false;
			}
			$aStart = explode ('-', $dStarta2);
			$aEnd = explode ('-', $dEnda2);
			if (count ($aStart) !== 3 || count ($aEnd) !== 3) {
				return false;
			}
			if (false === checkdate ($aStart[1], $aStart[2], $aStart[0]) || false === checkdate ($aEnd[1], $aEnd[2], $aEnd[0]) || $iEnd <= $iStart) {
				// return false;
			}
			for ($i = $iStart; $i < $iEnd + 86400; $i = strtotime ('+1 day', $i) ) {
				$sDateToArra = strftime ('%Y-%m-%d', $i);
				$sYear = substr ($sDateToArra, 0, 4);
				$sMonth = substr ($sDateToArra, 5, 2);
				$aDatesa2[$sYear][$sMonth][] = $sDateToArra;
			}
			
			$nbanneea2 = 0;
			$nbmoisparanneea2 = 0;
			//Calcule le nombre de jours dans le mois
			$annee1 = date("Y", strtotime($dStart));
			$anneef = date("Y", strtotime($dStart));
			$anneefin = $anneef + 1;
			
			//Boucle parcours tableau année, mois, jours.
			//Celle-ci renvoie le nombre de  jours du premier mois m1
			$m11a2 = 1;
			foreach($aDatesa2 as $anneea2 => $moissa2)
			{
				foreach($moissa2 as $datea2 => $moisa2)
				{
					if($m11a2 == 1)//si on est en m1 on procède sinon break
					{
						foreach($moisa2 as $data)
						{						
							$m11a2++;
						}
					}
					else
					{
						break;
					}
				}
				
			}
			$m1a2 = $m11a2-1;
			//Calcul du nb total de mois $m
			$ma2 = 0;
			foreach($aDatesa2 as $anneea2 => $moissa2)
			{
				foreach($moissa2 as $datea2 => $moisa2)
				{
					$ma2++;
				}
				
			}
			
			//Calcul du nb total d'années $a
			$ana2 = 0;
			foreach($aDatesa2 as $anneea2 => $moissa2)
			{
				$ana2++;				
			}
// echo $ma;			
			//Celle-ci renvoie le nombre de jours du dernier mois mm
			$mma2 = 0;
			$compteurma2 = 1;
			foreach($aDatesa2 as $anneea2 => $moissa2)
			{
				foreach($moissa2 as $datea2 => $moisa2)
				{
					if($compteurma2 == $ma2)//si on est le dernier mois
					{
						foreach($moisa2 as $data)
						{						
							$mma2++;
						}
					}
					else
					{}
				$compteurma2++;
				}
				
			}
			
			//Celle-ci renvoie le nombre de jours de la première année $a1
			$a11a2 = 1;
			foreach($aDatesa2 as $anneea2 => $moissa2)
			{
				if($a11a2 == 1)//si on est en a1 on procède sinon break
				{
					foreach($moissa2 as $datea2 => $moisa2)
					{
						foreach($moisa2 as $data)
						{						
							$a11a2++;
						}
					}
				}
				else
				{
					break;
				}
			}
			$a1a2 = $a11a2-1;
			//Fonction qui calcule le nombre de jours dans l'année

				
			//Celle-ci renvoie le nombre de jours de la dernière année $aa
			$aaa2 = 0;
			$compteuraa2 = 1;
			foreach($aDatesa2 as $anneea2 => $moissa2)
			{
				if($compteuraa2 == $ana2)//si on est en end ernière année on calcule le nb de jours $aa
				{
					foreach($moissa2 as $datea2 => $moisa2)
					{
						foreach($moisa2 as $data)
						{						
							$aaa2++;
						}
					}
				}
				else
				{
					break;
				}
				$compteuraa2++;
			}
			// echo 'www'.$mm.'www';
			// $mma = 0; //Compteur de mois qui s'incrémente de 1 afin de faire un compte indépendant des mois.
			$nbjrparmoisa2 = 0;
			$ia2 = 1; //Compteur pour premier mois
			$aa2 = 1; //Compteur pour la première année
			$nbmoisaa2 = array();
			$nbjanneeaa2 = array();
			foreach($aDatesa2 as $anneea2 => $moissa2)
			{	
				//Calculer le nombre d'années
				// echo $anneea;
				if($aa == 1)//Si on est en première année
				{
					$nbjanneea2[] = $a1a2;//nb de jours de la première année
				}
				elseif($aa2 == $ana2)
				{
					$nbjanneea2[] = $aa2;
				}
				else
				{
					$nbjanneea2[] = cal_days_in_year($anneea2);
				}
				foreach($moissa2 as $datea2 => $moisa2)
				{
					if($ia2 == 1)//on est au premier mois
					{
						//nb jours mois courant
						$nbmoisa2[] = $m1a2;
					}
					elseif($ia2 == $ma2)//Si on est  le dernier mois de la période on met le nb de jours
					{
						//nb de jours du dernier mois
						$nbmoisa2[] = $mma2;
					}
					else
					{
						//Pour les autres mois
						$nbmoisa2[] = cal_days_in_month(CAL_GREGORIAN, $datea2, $anneea2);
					}
					$ia2++;
				}
				$aa2++;
			}