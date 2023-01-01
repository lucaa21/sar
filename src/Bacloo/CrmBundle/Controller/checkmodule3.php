<?php
		//les données de module3
		$expmodule3 = $modulesuser->getmodule3expiration();
		$prixmodule3 = $modulesuser->getmodule3prix();
		$module3 = $modulesuser->getmodule3();

		$var = $expmodule3;
		$date = str_replace('/', '-', $var);
		$expmodule3b = date("Y-m-d", strtotime($date));
		
		//Contournement de diff toujours positif
		$d0 = new \DateTime("2013-01-01");
		$d1 = new \DateTime("now");
		$d2 = new \DateTime($expmodule3b);
		$interval1 = $d0->diff($d1);
		$interval2 = $d0->diff($d2);
		$intA = $interval1->format('%a');
		$intB = $interval2->format('%a');
		// echo 'intA'.$intA;
		// echo 'intB'.$intB;
		
		$interval = $d1->diff($d2);

		$diffmodule3 = $interval->format('%a');

		// echo 'rrr'.$diffmodule3;
		// echo 'sss'.$expmodule3b;

		if($diffmodule3 < 1 && $modulesuser->getmodule3activation() == 1)// si module expiré
		{//echo 'expiration';
			$soldepoints = $credits - $prixmodule3;
			if($credits >= $prixmodule3)//s'il reste des points
			{
				//prolongation de l'abonnement
				$expiration = date('d/m/Y', strtotime("+30 days"));
				$modulesuser->setmodule3expiration($expiration);
				$userdetails->setCredits($soldepoints);
				$em->flush();
			}
			else //S'il n'y a pas assez de points
			{
				$modulesuser->setmodule3activation(0);
				$em->flush();

			if($listmodarret == 0)
				{
					$listmodarret = $module3;
					$comptemodarret = 1;
				}
				else
				{
					$listmodarret .= ','.$module3;
					$comptemodarret += 1;
				}
			}
		}
		elseif($credits < 5 && $modulesuser->getmodule3activation() == 1) //Nombre de points bas, envoi alerte.
		{//echo 'pas exp';
			if($listmodalerte == 0)
				{
					//echo '2';
					$listmodalerte = $module3;
					$comptemodalerte = 1;
				}
				else
				{
					//echo '3';
					$listmodalerte .= ','.$module3;
					$comptemodalerte += 1;
				}
		}
		elseif($intB < $intA && $modulesuser->getmodule3activation() == 1)//Si la date d'exp est inférieure à la date du jour, on calcule le nb de jours de retard
		{
			// echo $intA - $intB;
			$ecart = ($intA - $intB)/30;//nombre de mois de retard.
			$ecartok = round($ecart, 0, PHP_ROUND_HALF_DOWN);//nombre de mois de retard.
			$prixmodule3_2 = ($prixmodule3 * $ecartok)+$prixmodule3;
			$soldepoints = $credits - $prixmodule3_2;
			if($credits >= $prixmodule3_2)//s'il reste des points
			{
				//prolongation de l'abonnement
				$expiration = date('d/m/Y', strtotime("+30 days"));
				$modulesuser->setmodule3expiration($expiration);
				$userdetails->setCredits($soldepoints);
				$em->flush();
			}
			else //S'il n'y a pas assez de points
			{
				$modulesuser->setmodule3activation(0);
				$em->flush();

			if($listmodarret == 0)
				{
					$listmodarret = $module3;
					$comptemodarret = 1;
				}
				else
				{
					$listmodarret .= ','.$module3;
					$comptemodarret += 1;
				}
			}			
		}
		//Fin données module3
// Fin des controles du module3