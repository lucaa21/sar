<?php
		//les données de module12
		$expmodule12 = $modulesuser->getmodule12expiration();
		$prixmodule12 = $modulesuser->getmodule12prix();
		$module12 = $modulesuser->getmodule12();

		$var = $expmodule12;
		$date = str_replace('/', '-', $var);
		$expmodule12b = date("Y-m-d", strtotime($date));
		
		//Contournement de diff toujours positif
		$d0 = new \DateTime("2013-01-01");
		$d1 = new \DateTime("now");
		$d2 = new \DateTime($expmodule12b);
		$interval1 = $d0->diff($d1);
		$interval2 = $d0->diff($d2);
		$intA = $interval1->format('%a');
		$intB = $interval2->format('%a');
		// echo 'intA'.$intA;
		// echo 'intB'.$intB;
		
		$interval = $d1->diff($d2);

		$diffmodule12 = $interval->format('%a');

		// echo 'rrr'.$diffmodule12;
		// echo 'sss'.$expmodule12b;

		if($diffmodule12 < 1 && $modulesuser->getmodule12activation() == 1)// si module expiré
		{//echo 'expiration';
			$soldepoints = $credits - $prixmodule12;
			if($credits >= $prixmodule12)//s'il reste des points
			{
				//prolongation de l'abonnement
				$expiration = date('d/m/Y', strtotime("+30 days"));
				$modulesuser->setmodule12expiration($expiration);
				$userdetails->setCredits($soldepoints);
				$em->flush();
			}
			else //S'il n'y a pas assez de points
			{
				$modulesuser->setmodule12activation(0);
				$em->flush();

			if($listmodarret == 0)
				{
					$listmodarret = $module12;
					$comptemodarret = 1;
				}
				else
				{
					$listmodarret .= ','.$module12;
					$comptemodarret += 1;
				}
			}
		}
		elseif($credits < 5 && $modulesuser->getmodule12activation() == 1) //Nombre de points bas, envoi alerte.
		{//echo 'pas exp';
			if($listmodalerte == 0)
				{
					//echo '2';
					$listmodalerte = $module12;
					$comptemodalerte = 1;
				}
				else
				{
					//echo '3';
					$listmodalerte .= ','.$module12;
					$comptemodalerte += 1;
				}
		}
		elseif($intB < $intA && $modulesuser->getmodule12activation() == 1)//Si la date d'exp est inférieure à la date du jour, on calcule le nb de jours de retard
		{
			// echo $intA - $intB;
			$ecart = ($intA - $intB)/30;//nombre de mois de retard.
			$ecartok = round($ecart, 0, PHP_ROUND_HALF_DOWN);//nombre de mois de retard.
			$prixmodule12_2 = ($prixmodule12 * $ecartok)+$prixmodule12;
			$soldepoints = $credits - $prixmodule12_2;
			if($credits >= $prixmodule12_2)//s'il reste des points
			{
				//prolongation de l'abonnement
				$expiration = date('d/m/Y', strtotime("+30 days"));
				$modulesuser->setmodule12expiration($expiration);
				$userdetails->setCredits($soldepoints);
				$em->flush();
			}
			else //S'il n'y a pas assez de points
			{
				$modulesuser->setmodule12activation(0);
				$em->flush();

			if($listmodarret == 0)
				{
					$listmodarret = $module12;
					$comptemodarret = 1;
				}
				else
				{
					$listmodarret .= ','.$module12;
					$comptemodarret += 1;
				}
			}			
		}
		//Fin données module12
// Fin des controles du module12