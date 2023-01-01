<?php
		//les données de module7
		$expmodule7 = $modulesuser->getModule7expiration();
		$prixmodule7 = $modulesuser->getModule7prix();
		$module7 = $modulesuser->getModule7();

		$var = $expmodule7;
		$date = str_replace('/', '-', $var);
		$expmodule7b = date("Y-m-d", strtotime($date));

		$d1 = new \DateTime("now");
		$d2 = new \DateTime($expmodule7b);

		$interval = $d2->diff($d1);
		$diffmodule7 = $interval->format('%a');
		// echo $diffmodule7;
		if($diffmodule7 == 0 && $modulesuser->getModule7activation() == 1)// si module expiré
		{
			$soldepoints = $credits - $prixmodule7;
			if($credits >= $prixmodule7)
			{
				//prolongation de l'abonnement
				$expiration = date('d/m/Y', strtotime("+30 days"));
				$modulesuser->setModule7expiration($expiration);
				$userdetails->setCredits($soldepoints);
				$em->flush();
			}
			else //S'il n'y a pas assez de points
			{
				$modulesuser->setModule7activation(0);
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
		elseif($credits < 5 && $modulesuser->getModule7activation() == 1) //Nombre de points bas, envoi alerte.
		{//echo '1';
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
		//Fin données module7
// Fin des controles du module7