<?php
		//les données de module7
		$expmodule7 = $modulesuser->getmodule7expiration();
		$prixmodule7 = $modulesuser->getmodule7prix();
		$module7 = $modulesuser->getmodule7();

		$var = $expmodule7;
		$date = str_replace('/', '-', $var);
		$expmodule7b = date("Y-m-d", strtotime($date));
		
		//Contournement de diff toujours positif
		$d0 = new \DateTime("2013-01-01");
		$d1 = new \DateTime("now");
		$d2 = new \DateTime($expmodule7b);
		$interval1 = $d0->diff($d1);
		$interval2 = $d0->diff($d2);
		$intA = $interval1->format('%a');
		$intB = $interval2->format('%a');
		// echo 'intA'.$intA;
		// echo 'intB'.$intB;
		
		$interval = $d1->diff($d2);

		$diffmodule7 = $interval->format('%a');

		// echo 'rrr'.$diffmodule7;
		// echo 'sss'.$expmodule7b;

		if($diffmodule7 < 1 && $modulesuser->getmodule7activation() == 1)// si module expiré
		{//echo 'expiration';
			$soldepoints = $credits - $prixmodule7;
			if($credits >= $prixmodule7)//s'il reste des points
			{
				//prolongation de l'abonnement
				$expiration = date('d/m/Y', strtotime("+30 days"));
				$modulesuser->setmodule7expiration($expiration);
				$userdetails->setCredits($soldepoints);
				$em->flush();
			}
			else //S'il n'y a pas assez de points
			{
				$modulesuser->setmodule7activation(0);
				$em->flush();

			if($listmodarret == 0)
				{
					$listmodarret = $module7;
					$comptemodarret = 1;
				}
				else
				{
					$listmodarret .= ','.$module7;
					$comptemodarret += 1;
				}
			}
		}
		elseif($credits < 5 && $modulesuser->getmodule7activation() == 1) //Nombre de points bas, envoi alerte.
		{//echo 'pas exp';
			if($listmodalerte == 0)
				{
					//echo '2';
					$listmodalerte = $module7;
					$comptemodalerte = 1;
				}
				else
				{
					//echo '3';
					$listmodalerte .= ','.$module7;
					$comptemodalerte += 1;
				}
		}
		elseif($intB < $intA && $modulesuser->getmodule7activation() == 1)//Si la date d'exp est inférieure à la date du jour, on calcule le nb de jours de retard
		{
			// echo $intA - $intB;
			$ecart = ($intA - $intB)/30;//nombre de mois de retard.
			$ecartok = round($ecart, 0, PHP_ROUND_HALF_DOWN);//nombre de mois de retard.
			$prixmodule7_2 = ($prixmodule7 * $ecartok)+$prixmodule7;
			$soldepoints = $credits - $prixmodule7_2;
			if($credits >= $prixmodule7_2)//s'il reste des points
			{
				//prolongation de l'abonnement
				$expiration = date('d/m/Y', strtotime("+30 days"));
				$modulesuser->setmodule7expiration($expiration);
				$userdetails->setCredits($soldepoints);
				$em->flush();
			}
			else //S'il n'y a pas assez de points
			{
				$modulesuser->setmodule7activation(0);
				$em->flush();

			if($listmodarret == 0)
				{
					$listmodarret = $module7;
					$comptemodarret = 1;
				}
				else
				{
					$listmodarret .= ','.$module7;
					$comptemodarret += 1;
				}
			}			
		}
		//Fin données module7
// Fin des controles du module7