<?php
		//les données de module10
		$expmodule10 = $modulesuser->getModule10expiration();
		$prixmodule10 = $modulesuser->getModule10prix();
		$module10 = $modulesuser->getModule10();

		$var = $expmodule10;
		$date = str_replace('/', '-', $var);
		$expmodule10b = date("Y-m-d", strtotime($date));
		
		//Contournement de diff toujours positif
		$d0 = new \DateTime("2013-01-01");
		$d1 = new \DateTime("now");
		$d2 = new \DateTime($expmodule10b);
		$interval1 = $d0->diff($d1);
		$interval2 = $d0->diff($d2);
		$intA = $interval1->format('%a');
		$intB = $interval2->format('%a');
		// echo 'intA'.$intA;
		// echo 'intB'.$intB;
		
		$interval = $d1->diff($d2);

		$diffmodule10 = $interval->format('%a');

		// echo 'rrr'.$diffmodule10;
		// echo 'sss'.$expmodule10b;

		if($diffmodule10 < 1 && $modulesuser->getModule10activation() == 1)// si module expiré
		{//echo 'expiration';
			$soldepoints = $credits - $prixmodule10;
			if($credits >= $prixmodule10)//s'il reste des points
			{
				//prolongation de l'abonnement
				$expiration = date('d/m/Y', strtotime("+30 days"));
				$modulesuser->setModule10expiration($expiration);
				$userdetails->setCredits($soldepoints);
				$em->flush();
			}
			else //S'il n'y a pas assez de points
			{
				$modulesuser->setModule10activation(0);
				$em->flush();

			if($listmodarret == 0)
				{
					$listmodarret = $module10;
					$comptemodarret = 1;
				}
				else
				{
					$listmodarret .= ','.$module10;
					$comptemodarret += 1;
				}
			}
		}
		elseif($credits < 5 && $modulesuser->getModule10activation() == 1) //Nombre de points bas, envoi alerte.
		{//echo 'pas exp';
			if($listmodalerte == 0)
				{
					//echo '2';
					$listmodalerte = $module10;
					$comptemodalerte = 1;
				}
				else
				{
					//echo '3';
					$listmodalerte .= ','.$module10;
					$comptemodalerte += 1;
				}
		}
		elseif($intB < $intA && $modulesuser->getModule10activation() == 1)//Si la date d'exp est inférieure à la date du jour, on calcule le nb de jours de retard
		{
			// echo $intA - $intB;
			$ecart = ($intA - $intB)/30;//nombre de mois de retard.
			$ecartok = round($ecart, 0, PHP_ROUND_HALF_DOWN);//nombre de mois de retard.
			$prixmodule10_2 = ($prixmodule10 * $ecartok)+$prixmodule10;
			$soldepoints = $credits - $prixmodule10_2;
			if($credits >= $prixmodule10_2)//s'il reste des points
			{
				//prolongation de l'abonnement
				$expiration = date('d/m/Y', strtotime("+30 days"));
				$modulesuser->setModule10expiration($expiration);
				$userdetails->setCredits($soldepoints);
				$em->flush();
			}
			else //S'il n'y a pas assez de points
			{
				$modulesuser->setModule10activation(0);
				$em->flush();

			if($listmodarret == 0)
				{
					$listmodarret = $module10;
					$comptemodarret = 1;
				}
				else
				{
					$listmodarret .= ','.$module10;
					$comptemodarret += 1;
				}
			}			
		}
		//Fin données module10
// Fin des controles du module10