<?php
		//les données de module6
		$expmodule6 = $modulesuser->getModule6expiration();
		$prixmodule6 = $modulesuser->getModule6prix();
		$module6 = $modulesuser->getModule6();

		$var = $expmodule6;
		$date = str_replace('/', '-', $var);
		$expmodule6b = date("Y-m-d", strtotime($date));

		$d1 = new \DateTime("now");
		$d2 = new \DateTime($expmodule6b);

		$interval = $d2->diff($d1);
		$diffmodule6 = $interval->format('%a');
		// echo $diffmodule6;
		if($diffmodule6 == 0 && $modulesuser->getModule6activation() == 1)// si module expiré
		{
			$soldepoints = $credits - $prixmodule6;
			if($credits >= $prixmodule6)
			{
				//prolongation de l'abonnement
				$expiration = date('d/m/Y', strtotime("+30 days"));
				$modulesuser->setModule6expiration($expiration);
				$userdetails->setCredits($soldepoints);
				$em->flush();
			}
			else //S'il n'y a pas assez de points
			{
				$modulesuser->setModule6activation(0);
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
		elseif($credits < 5 && $modulesuser->getModule6activation() == 1) //Nombre de points bas, envoi alerte.
		{//echo '1';
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
		//Fin données module6
// Fin des controles du module6