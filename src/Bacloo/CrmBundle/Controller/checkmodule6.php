<?php
		//les données de module6
		$expmodule6 = $modulesuser->getmodule6expiration();
		$prixmodule6 = $modulesuser->getmodule6prix();
		$module6 = $modulesuser->getmodule6();

		$var = $expmodule6;
		$date = str_replace('/', '-', $var);
		$expmodule6b = date("Y-m-d", strtotime($date));
		
		//Contournement de diff toujours positif
		$d0 = new \DateTime("2013-01-01");
		$d1 = new \DateTime("now");
		$d2 = new \DateTime($expmodule6b);
		$interval1 = $d0->diff($d1);
		$interval2 = $d0->diff($d2);
		$intA = $interval1->format('%a');
		$intB = $interval2->format('%a');
		// echo 'intA'.$intA;
		// echo 'intB'.$intB;
		
		$interval = $d1->diff($d2);

		$diffmodule6 = $interval->format('%a');

		// echo 'rrr'.$diffmodule6;
		// echo 'sss'.$expmodule6b;

		if($diffmodule6 < 1 && $modulesuser->getmodule6activation() == 1)// si module expiré
		{//echo 'expiration';
			$soldepoints = $credits - $prixmodule6;
			if($credits >= $prixmodule6)//s'il reste des points
			{
				//prolongation de l'abonnement
				$expiration = date('d/m/Y', strtotime("+30 days"));
				$modulesuser->setmodule6expiration($expiration);
				$userdetails->setCredits($soldepoints);
				$em->flush();
			}
			else //S'il n'y a pas assez de points
			{
				$modulesuser->setmodule6activation(0);
				$em->flush();

			if($listmodarret == 0)
				{
					$listmodarret = $module6;
					$comptemodarret = 1;
				}
				else
				{
					$listmodarret .= ','.$module6;
					$comptemodarret += 1;
				}
			}
		}
		elseif($credits < 5 && $modulesuser->getmodule6activation() == 1) //Nombre de points bas, envoi alerte.
		{//echo 'pas exp';
			if($listmodalerte == 0)
				{
					//echo '2';
					$listmodalerte = $module6;
					$comptemodalerte = 1;
				}
				else
				{
					//echo '3';
					$listmodalerte .= ','.$module6;
					$comptemodalerte += 1;
				}
		}
		elseif($intB < $intA && $modulesuser->getmodule6activation() == 1)//Si la date d'exp est inférieure à la date du jour, on calcule le nb de jours de retard
		{
			// echo $intA - $intB;
			$ecart = ($intA - $intB)/30;//nombre de mois de retard.
			$ecartok = round($ecart, 0, PHP_ROUND_HALF_DOWN);//nombre de mois de retard.
			$prixmodule6_2 = ($prixmodule6 * $ecartok)+$prixmodule6;
			$soldepoints = $credits - $prixmodule6_2;
			if($credits >= $prixmodule6_2)//s'il reste des points
			{
				//prolongation de l'abonnement
				$expiration = date('d/m/Y', strtotime("+30 days"));
				$modulesuser->setmodule6expiration($expiration);
				$userdetails->setCredits($soldepoints);
				$em->flush();
			}
			else //S'il n'y a pas assez de points
			{
				$modulesuser->setmodule6activation(0);
				$em->flush();

			if($listmodarret == 0)
				{
					$listmodarret = $module6;
					$comptemodarret = 1;
				}
				else
				{
					$listmodarret .= ','.$module6;
					$comptemodarret += 1;
				}
			}			
		}
		//Fin données module6
// Fin des controles du module6