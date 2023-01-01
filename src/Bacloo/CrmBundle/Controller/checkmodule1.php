<?php
		//les données de module1
		$expmodule1 = $modulesuser->getmodule1expiration();
		$prixmodule1 = $modulesuser->getmodule1prix();
		$module1 = $modulesuser->getmodule1();

		$var = $expmodule1;
		$date = str_replace('/', '-', $var);
		$expmodule1b = date("Y-m-d", strtotime($date));
		
		//Contournement de diff toujours positif
		$d0 = new \DateTime("2013-01-01");
		$d1 = new \DateTime("now");
		$d2 = new \DateTime($expmodule1b);
		$interval1 = $d0->diff($d1);
		$interval2 = $d0->diff($d2);
		$intA = $interval1->format('%a');
		$intB = $interval2->format('%a');
		// echo 'intA'.$intA;
		// echo 'intB'.$intB;
		
		$interval = $d1->diff($d2);

		$diffmodule1 = $interval->format('%a');

		// echo 'rrr'.$diffmodule1;
		// echo 'sss'.$expmodule1b;

		if($diffmodule1 < 1 && $modulesuser->getmodule1activation() == 1)// si module expiré
		{//echo 'expiration';
			$soldepoints = $credits - $prixmodule1;
			if($credits >= $prixmodule1)//s'il reste des points
			{
				//prolongation de l'abonnement
				$expiration = date('d/m/Y', strtotime("+30 days"));
				$modulesuser->setmodule1expiration($expiration);
				$userdetails->setCredits($soldepoints);
				$em->flush();
			}
			else //S'il n'y a pas assez de points
			{
				$modulesuser->setmodule1activation(0);
				$em->flush();

			if($listmodarret == 0)
				{
					$listmodarret = $module1;
					$comptemodarret = 1;
				}
				else
				{
					$listmodarret .= ','.$module1;
					$comptemodarret += 1;
				}
			}
		}
		elseif($credits < 5 && $modulesuser->getmodule1activation() == 1) //Nombre de points bas, envoi alerte.
		{//echo 'pas exp';
			if($listmodalerte == 0)
				{
					//echo '2';
					$listmodalerte = $module1;
					$comptemodalerte = 1;
				}
				else
				{
					//echo '3';
					$listmodalerte .= ','.$module1;
					$comptemodalerte += 1;
				}
		}
		elseif($intB < $intA && $modulesuser->getmodule1activation() == 1)//Si la date d'exp est inférieure à la date du jour, on calcule le nb de jours de retard
		{
			// echo $intA - $intB;
			$ecart = ($intA - $intB)/30;//nombre de mois de retard.
			$ecartok = round($ecart, 0, PHP_ROUND_HALF_DOWN);//nombre de mois de retard.
			$prixmodule1_2 = ($prixmodule1 * $ecartok)+$prixmodule1;
			$soldepoints = $credits - $prixmodule1_2;
			if($credits >= $prixmodule1_2)//s'il reste des points
			{
				//prolongation de l'abonnement
				$expiration = date('d/m/Y', strtotime("+30 days"));
				$modulesuser->setmodule1expiration($expiration);
				$userdetails->setCredits($soldepoints);
				$em->flush();
			}
			else //S'il n'y a pas assez de points
			{
				$modulesuser->setmodule1activation(0);
				$em->flush();

			if($listmodarret == 0)
				{
					$listmodarret = $module1;
					$comptemodarret = 1;
				}
				else
				{
					$listmodarret .= ','.$module1;
					$comptemodarret += 1;
				}
			}			
		}
		//Fin données module1
// Fin des controles du module1