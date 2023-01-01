<?php
		//les données de module2
		$expmodule2 = $modulesuser->getmodule2expiration();
		$prixmodule2 = $modulesuser->getmodule2prix();
		$module2 = $modulesuser->getmodule2();

		$var = $expmodule2;
		$date = str_replace('/', '-', $var);
		$expmodule2b = date("Y-m-d", strtotime($date));
		
		//Contournement de diff toujours positif
		$d0 = new \DateTime("2013-01-01");
		$d1 = new \DateTime("now");
		$d2 = new \DateTime($expmodule2b);
		$interval1 = $d0->diff($d1);
		$interval2 = $d0->diff($d2);
		$intA = $interval1->format('%a');
		$intB = $interval2->format('%a');
		// echo 'intA'.$intA;
		// echo 'intB'.$intB;
		
		$interval = $d1->diff($d2);

		$diffmodule2 = $interval->format('%a');

		// echo 'rrr'.$diffmodule2;
		// echo 'sss'.$expmodule2b;

		if($diffmodule2 < 1 && $modulesuser->getmodule2activation() == 1)// si module expiré
		{//echo 'expiration';
			$soldepoints = $credits - $prixmodule2;
			if($credits >= $prixmodule2)//s'il reste des points
			{
				//prolongation de l'abonnement
				$expiration = date('d/m/Y', strtotime("+30 days"));
				$modulesuser->setmodule2expiration($expiration);
				$userdetails->setCredits($soldepoints);
				$em->flush();
			}
			else //S'il n'y a pas assez de points
			{
				$modulesuser->setmodule2activation(0);
				$em->flush();

			if($listmodarret == 0)
				{
					$listmodarret = $module2;
					$comptemodarret = 1;
				}
				else
				{
					$listmodarret .= ','.$module2;
					$comptemodarret += 1;
				}
			}
		}
		elseif($credits < 5 && $modulesuser->getmodule2activation() == 1) //Nombre de points bas, envoi alerte.
		{//echo 'pas exp';
			if($listmodalerte == 0)
				{
					//echo '2';
					$listmodalerte = $module2;
					$comptemodalerte = 1;
				}
				else
				{
					//echo '3';
					$listmodalerte .= ','.$module2;
					$comptemodalerte += 1;
				}
		}
		elseif($intB < $intA && $modulesuser->getmodule2activation() == 1)//Si la date d'exp est inférieure à la date du jour, on calcule le nb de jours de retard
		{
			// echo $intA - $intB;
			$ecart = ($intA - $intB)/30;//nombre de mois de retard.
			$ecartok = round($ecart, 0, PHP_ROUND_HALF_DOWN);//nombre de mois de retard.
			$prixmodule2_2 = ($prixmodule2 * $ecartok)+$prixmodule2;
			$soldepoints = $credits - $prixmodule2_2;
			if($credits >= $prixmodule2_2)//s'il reste des points
			{
				//prolongation de l'abonnement
				$expiration = date('d/m/Y', strtotime("+30 days"));
				$modulesuser->setmodule2expiration($expiration);
				$userdetails->setCredits($soldepoints);
				$em->flush();
			}
			else //S'il n'y a pas assez de points
			{
				$modulesuser->setmodule2activation(0);
				$em->flush();

			if($listmodarret == 0)
				{
					$listmodarret = $module2;
					$comptemodarret = 1;
				}
				else
				{
					$listmodarret .= ','.$module2;
					$comptemodarret += 1;
				}
			}			
		}
		//Fin données module2
// Fin des controles du module2