<?php
		//les données de module9
		$expmodule9 = $modulesuser->getModule9expiration();
		$prixmodule9 = $modulesuser->getModule9prix();
		$module9 = $modulesuser->getModule9();

		$var = $expmodule9;
		$date = str_replace('/', '-', $var);
		$expmodule9b = date("Y-m-d", strtotime($date));

		$d1 = new \DateTime("now");
		$d2 = new \DateTime($expmodule9b);

		$interval = $d2->diff($d1);
		$diffmodule9 = $interval->format('%a');
		// echo $diffmodule9;
		if($diffmodule9 == 0 && $modulesuser->getModule9activation() == 1)// si module expiré
		{
			$soldepoints = $credits - $prixmodule9;
			if($credits >= $prixmodule9)
			{
				//prolongation de l'abonnement
				$expiration = date('d/m/Y', strtotime("+30 days"));
				$modulesuser->setModule9expiration($expiration);
				$userdetails->setCredits($soldepoints);
				$em->flush();
			}
			else //S'il n'y a pas assez de points
			{
				$modulesuser->setModule9activation(0);
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
		elseif($credits < 5 && $modulesuser->getModule9activation() == 1) //Nombre de points bas, envoi alerte.
		{//echo '1';
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
		//Fin données module9
// Fin des controles du module9