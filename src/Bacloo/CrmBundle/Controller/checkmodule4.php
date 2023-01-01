<?php
		//les données de module4
		$expmodule4 = $modulesuser->getmodule4expiration();
		$prixmodule4 = $modulesuser->getmodule4prix();
		$module4 = $modulesuser->getmodule4();

		$var = $expmodule4;
		$date = str_replace('/', '-', $var);
		$expmodule4b = date("Y-m-d", strtotime($date));
		
		//Contournement de diff toujours positif
		$d0 = new \DateTime("2013-01-01");
		$d1 = new \DateTime("now");
		$d2 = new \DateTime($expmodule4b);
		$interval1 = $d0->diff($d1);
		$interval2 = $d0->diff($d2);
		$intA = $interval1->format('%a');
		$intB = $interval2->format('%a');
		// echo 'intA'.$intA;
		// echo 'intB'.$intB;
		
		$interval = $d1->diff($d2);

		$diffmodule4 = $interval->format('%a');

		// echo 'rrr'.$diffmodule4;
		// echo 'sss'.$expmodule4b;

		if($diffmodule4 < 1 && $modulesuser->getmodule4activation() == 1)// si module expiré
		{//echo 'expiration';
			$soldepoints = $credits - $prixmodule4;
			if($credits >= $prixmodule4)//s'il reste des points
			{
				//prolongation de l'abonnement
				$expiration = date('d/m/Y', strtotime("+30 days"));
				$modulesuser->setmodule4expiration($expiration);
				$userdetails->setCredits($soldepoints);
				$em->flush();
			}
			else //S'il n'y a pas assez de points
			{
				$modulesuser->setmodule4activation(0);
				$em->flush();

			if($listmodarret == 0)
				{
					$listmodarret = $module4;
					$comptemodarret = 1;
				}
				else
				{
					$listmodarret .= ','.$module4;
					$comptemodarret += 1;
				}
			}
		}
		elseif($credits < 5 && $modulesuser->getmodule4activation() == 1) //Nombre de points bas, envoi alerte.
		{//echo 'pas exp';
			if($listmodalerte == 0)
				{
					//echo '2';
					$listmodalerte = $module4;
					$comptemodalerte = 1;
				}
				else
				{
					//echo '3';
					$listmodalerte .= ','.$module4;
					$comptemodalerte += 1;
				}
		}
		elseif($intB < $intA && $modulesuser->getmodule4activation() == 1)//Si la date d'exp est inférieure à la date du jour, on calcule le nb de jours de retard
		{
			// echo $intA - $intB;
			$ecart = ($intA - $intB)/30;//nombre de mois de retard.
			$ecartok = round($ecart, 0, PHP_ROUND_HALF_DOWN);//nombre de mois de retard.
			$prixmodule4_2 = ($prixmodule4 * $ecartok)+$prixmodule4;
			$soldepoints = $credits - $prixmodule4_2;
			if($credits >= $prixmodule4_2)//s'il reste des points
			{
				//prolongation de l'abonnement
				$expiration = date('d/m/Y', strtotime("+30 days"));
				$modulesuser->setmodule4expiration($expiration);
				$userdetails->setCredits($soldepoints);
				$em->flush();
			}
			else //S'il n'y a pas assez de points
			{
				$modulesuser->setmodule4activation(0);
				$em->flush();

			if($listmodarret == 0)
				{
					$listmodarret = $module4;
					$comptemodarret = 1;
				}
				else
				{
					$listmodarret .= ','.$module4;
					$comptemodarret += 1;
				}
			}			
		}
		//Fin données module4
// Fin des controles du module4