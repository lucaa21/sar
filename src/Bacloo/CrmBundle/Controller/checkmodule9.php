<?php
		//les données de module9
		$expmodule9 = $modulesuser->getmodule9expiration();
		$prixmodule9 = $modulesuser->getmodule9prix();
		$module9 = $modulesuser->getmodule9();

		$var = $expmodule9;
		$date = str_replace('/', '-', $var);
		$expmodule9b = date("Y-m-d", strtotime($date));
		
		//Contournement de diff toujours positif
		$d0 = new \DateTime("2013-01-01");
		$d1 = new \DateTime("now");
		$d2 = new \DateTime($expmodule9b);
		$interval1 = $d0->diff($d1);
		$interval2 = $d0->diff($d2);
		$intA = $interval1->format('%a');
		$intB = $interval2->format('%a');
		// echo 'intA'.$intA;
		// echo 'intB'.$intB;
		
		$interval = $d1->diff($d2);

		$diffmodule9 = $interval->format('%a');

		// echo 'rrr'.$diffmodule9;
		// echo 'sss'.$expmodule9b;

		if($diffmodule9 < 1 && $modulesuser->getmodule9activation() == 1)// si module expiré
		{//echo 'expiration';
			$soldepoints = $credits - $prixmodule9;
			if($credits >= $prixmodule9)//s'il reste des points
			{
				//prolongation de l'abonnement
				$expiration = date('d/m/Y', strtotime("+30 days"));
				$modulesuser->setmodule9expiration($expiration);
				$userdetails->setCredits($soldepoints);
				$em->flush();
			}
			else //S'il n'y a pas assez de points
			{
				$modulesuser->setmodule9activation(0);
				$em->flush();

			if($listmodarret == 0)
				{
					$listmodarret = $module9;
					$comptemodarret = 1;
				}
				else
				{
					$listmodarret .= ','.$module9;
					$comptemodarret += 1;
				}
			}
		}
		elseif($credits < 5 && $modulesuser->getmodule9activation() == 1) //Nombre de points bas, envoi alerte.
		{//echo 'pas exp';
			if($listmodalerte == 0)
				{
					//echo '2';
					$listmodalerte = $module9;
					$comptemodalerte = 1;
				}
				else
				{
					//echo '3';
					$listmodalerte .= ','.$module9;
					$comptemodalerte += 1;
				}
		}
		elseif($intB < $intA && $modulesuser->getmodule9activation() == 1)//Si la date d'exp est inférieure à la date du jour, on calcule le nb de jours de retard
		{
			// echo $intA - $intB;
			$ecart = ($intA - $intB)/30;//nombre de mois de retard.
			$ecartok = round($ecart, 0, PHP_ROUND_HALF_DOWN);//nombre de mois de retard.
			$prixmodule9_2 = ($prixmodule9 * $ecartok)+$prixmodule9;
			$soldepoints = $credits - $prixmodule9_2;
			if($credits >= $prixmodule9_2)//s'il reste des points
			{
				//prolongation de l'abonnement
				$expiration = date('d/m/Y', strtotime("+30 days"));
				$modulesuser->setmodule9expiration($expiration);
				$userdetails->setCredits($soldepoints);
				$em->flush();
			}
			else //S'il n'y a pas assez de points
			{
				$modulesuser->setmodule9activation(0);
				$em->flush();

			if($listmodarret == 0)
				{
					$listmodarret = $module9;
					$comptemodarret = 1;
				}
				else
				{
					$listmodarret .= ','.$module9;
					$comptemodarret += 1;
				}
			}			
		}
		//Fin données module9
// Fin des controles du module9