<?php
		//les données de module11
		$expmodule11 = $modulesuser->getModule11expiration();
		$prixmodule11 = $modulesuser->getModule11prix();
		$module11 = $modulesuser->getModule11();

		$var = $expmodule11;
		$date = str_replace('/', '-', $var);
		$expmodule11b = date("Y-m-d", strtotime($date));

		$d1 = new \DateTime("now");
		$d2 = new \DateTime($expmodule11b);

		$interval = $d2->diff($d1);
		$diffmodule11 = $interval->format('%a');
		// echo $diffmodule11;
		if($diffmodule11 == 0 && $modulesuser->getModule11activation() == 1)// si module expiré
		{
			$soldepoints = $credits - $prixmodule11;
			if($credits >= $prixmodule11)
			{
				//prolongation de l'abonnement
				$expiration = date('d/m/Y', strtotime("+30 days"));
				$modulesuser->setModule11expiration($expiration);
				$userdetails->setCredits($soldepoints);
				$em->flush();
			}
			else //S'il n'y a pas assez de points
			{
				$modulesuser->setModule11activation(0);
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
		elseif($credits < 5 && $modulesuser->getModule11activation() == 1) //Nombre de points bas, envoi alerte.
		{//echo '1';
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
		//Fin données module11
// Fin des controles du module11