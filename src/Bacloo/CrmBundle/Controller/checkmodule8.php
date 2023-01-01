<?php
		//les données de module8
		$expmodule8 = $modulesuser->getmodule8expiration();
		$prixmodule8 = $modulesuser->getmodule8prix();
		$module8 = $modulesuser->getmodule8();

		$var = $expmodule8;
		$date = str_replace('/', '-', $var);
		$expmodule8b = date("Y-m-d", strtotime($date));
		
		//Contournement de diff toujours positif
		$d0 = new \DateTime("2013-01-01");
		$d1 = new \DateTime("now");
		$d2 = new \DateTime($expmodule8b);
		$interval1 = $d0->diff($d1);
		$interval2 = $d0->diff($d2);
		$intA = $interval1->format('%a');
		$intB = $interval2->format('%a');
		// echo 'intA'.$intA;
		// echo 'intB'.$intB;
		
		$interval = $d1->diff($d2);

		$diffmodule8 = $interval->format('%a');

		// echo 'rrr'.$diffmodule8;
		// echo 'sss'.$expmodule8b;

		if($diffmodule8 < 1 && $modulesuser->getmodule8activation() == 1)// si module expiré
		{//echo 'expiration';
			$soldepoints = $credits - $prixmodule8;
			if($credits >= $prixmodule8)//s'il reste des points
			{
				//prolongation de l'abonnement
				$expiration = date('d/m/Y', strtotime("+30 days"));
				$modulesuser->setmodule8expiration($expiration);
				$userdetails->setCredits($soldepoints);
				$em->flush();
			}
			else //S'il n'y a pas assez de points
			{
				$modulesuser->setmodule8activation(0);
				$em->flush();

			if($listmodarret == 0)
				{
					$listmodarret = $module8;
					$comptemodarret = 1;
				}
				else
				{
					$listmodarret .= ','.$module8;
					$comptemodarret += 1;
				}
			}
		}
		elseif($credits < 5 && $modulesuser->getmodule8activation() == 1) //Nombre de points bas, envoi alerte.
		{//echo 'pas exp';
			if($listmodalerte == 0)
				{
					//echo '2';
					$listmodalerte = $module8;
					$comptemodalerte = 1;
				}
				else
				{
					//echo '3';
					$listmodalerte .= ','.$module8;
					$comptemodalerte += 1;
				}
		}
		elseif($intB < $intA && $modulesuser->getmodule8activation() == 1)//Si la date d'exp est inférieure à la date du jour, on calcule le nb de jours de retard
		{
			// echo $intA - $intB;
			$ecart = ($intA - $intB)/30;//nombre de mois de retard.
			$ecartok = round($ecart, 0, PHP_ROUND_HALF_DOWN);//nombre de mois de retard.
			$prixmodule8_2 = ($prixmodule8 * $ecartok)+$prixmodule8;
			$soldepoints = $credits - $prixmodule8_2;
			if($credits >= $prixmodule8_2)//s'il reste des points
			{
				//prolongation de l'abonnement
				$expiration = date('d/m/Y', strtotime("+30 days"));
				$modulesuser->setmodule8expiration($expiration);
				$userdetails->setCredits($soldepoints);
				$em->flush();
			}
			else //S'il n'y a pas assez de points
			{
				$modulesuser->setmodule8activation(0);
				$em->flush();

			if($listmodarret == 0)
				{
					$listmodarret = $module8;
					$comptemodarret = 1;
				}
				else
				{
					$listmodarret .= ','.$module8;
					$comptemodarret += 1;
				}
			}			
		}
		//Fin données module8
// Fin des controles du module8