<?php
		//les données de module10
		$expmodule10 = $modulesuser->getModule10expiration();
		$prixmodule10 = $modulesuser->getModule10prix();
		$module10 = $modulesuser->getModule10();

		$var = $expmodule10;
		$date = str_replace('/', '-', $var);
		$expmodule10b = date("Y-m-d", strtotime($date));

		$d1 = new \DateTime("now");
		$d2 = new \DateTime($expmodule10b);

		$interval = $d2->diff($d1);
		$diffmodule10 = $interval->format('%a');
		// echo $diffmodule10;
		if($diffmodule10 == 0 && $modulesuser->getModule10activation() == 1)// si module expiré
		{
			$soldepoints = $credits - $prixmodule10;
			if($credits >= $prixmodule10)
			{
				//prolongation de l'abonnement
				$expiration = date('d/m/Y', strtotime("+30 days"));
				$modulesuser->setModule10expiration($expiration);
				$userdetails->setCredits($soldepoints);
				$em->flush();
			}
			else //S'il n'y a pas assez de points
			{
				$modulesuser->setModule10activation(0);
				$em->flush();

			if($listmodarret == 0)
				{
					$listmodarret = $module10;
					$comptemodarret = 1;
				}
				else
				{
					$listmodarret .= ','.$module10;
					$comptemodarret += 1;
				}
			}
		}
		elseif($credits < 5 && $modulesuser->getModule10activation() == 1) //Nombre de points bas, envoi alerte.
		{//echo '1';
			if($listmodalerte == 0)
				{
					//echo '2';
					$listmodalerte = $module10;
					$comptemodalerte = 1;
				}
				else
				{
					//echo '3';
					$listmodalerte .= ','.$module10;
					$comptemodalerte += 1;
				}
		}
		//Fin données module10
// Fin des controles du module10