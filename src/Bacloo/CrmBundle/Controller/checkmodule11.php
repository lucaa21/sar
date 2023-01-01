<?php
		//les données de module11
		$expmodule11 = $modulesuser->getmodule11expiration();
		$prixmodule11 = $modulesuser->getmodule11prix();
		$module11 = $modulesuser->getmodule11();

		$var = $expmodule11;
		$date = str_replace('/', '-', $var);
		$expmodule11b = date("Y-m-d", strtotime($date));
		
		//Contournement de diff toujours positif
		$d0 = new \DateTime("2013-01-01");
		$d1 = new \DateTime("now");
		$d2 = new \DateTime($expmodule11b);
		$interval1 = $d0->diff($d1);
		$interval2 = $d0->diff($d2);
		$intA = $interval1->format('%a');
		$intB = $interval2->format('%a');
		// echo 'intA'.$intA;
		// echo 'intB'.$intB;
		
		$interval = $d1->diff($d2);

		$diffmodule11 = $interval->format('%a');

		// echo 'rrr'.$diffmodule11;
		// echo 'sss'.$expmodule11b;

		if($diffmodule11 < 1 && $modulesuser->getmodule11activation() == 1)// si module expiré
		{//echo 'expiration';
			$soldepoints = $credits - $prixmodule11;
			if($credits >= $prixmodule11)//s'il reste des points
			{
				//prolongation de l'abonnement
				$expiration = date('d/m/Y', strtotime("+30 days"));
				$modulesuser->setmodule11expiration($expiration);
				$userdetails->setCredits($soldepoints);
				$em->flush();
			}
			else //S'il n'y a pas assez de points
			{
				$modulesuser->setmodule11activation(0);
				$em->flush();

			if($listmodarret == 0)
				{
					$listmodarret = $module11;
					$comptemodarret = 1;
				}
				else
				{
					$listmodarret .= ','.$module11;
					$comptemodarret += 1;
				}
			}
		}
		elseif($credits < 5 && $modulesuser->getmodule11activation() == 1) //Nombre de points bas, envoi alerte.
		{//echo 'pas exp';
			if($listmodalerte == 0)
				{
					//echo '2';
					$listmodalerte = $module11;
					$comptemodalerte = 1;
				}
				else
				{
					//echo '3';
					$listmodalerte .= ','.$module11;
					$comptemodalerte += 1;
				}
		}
		elseif($intB < $intA && $modulesuser->getmodule11activation() == 1)//Si la date d'exp est inférieure à la date du jour, on calcule le nb de jours de retard
		{
			// echo $intA - $intB;
			$ecart = ($intA - $intB)/30;//nombre de mois de retard.
			$ecartok = round($ecart, 0, PHP_ROUND_HALF_DOWN);//nombre de mois de retard.
			$prixmodule11_2 = ($prixmodule11 * $ecartok)+$prixmodule11;
			$soldepoints = $credits - $prixmodule11_2;
			if($credits >= $prixmodule11_2)//s'il reste des points
			{
				//prolongation de l'abonnement
				$expiration = date('d/m/Y', strtotime("+30 days"));
				$modulesuser->setmodule11expiration($expiration);
				$userdetails->setCredits($soldepoints);
				$em->flush();
			}
			else //S'il n'y a pas assez de points
			{
				$modulesuser->setmodule11activation(0);
				$em->flush();

			if($listmodarret == 0)
				{
					$listmodarret = $module11;
					$comptemodarret = 1;
				}
				else
				{
					$listmodarret .= ','.$module11;
					$comptemodarret += 1;
				}
			}			
		}
		//Fin données module11
// Fin des controles du module11