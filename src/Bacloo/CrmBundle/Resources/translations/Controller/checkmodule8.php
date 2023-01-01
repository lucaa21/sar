<?php
		//les données de module8
		$expmodule8 = $modulesuser->getModule8expiration();
		$prixmodule8 = $modulesuser->getModule8prix();
		$module8 = $modulesuser->getModule8();

		$var = $expmodule8;
		$date = str_replace('/', '-', $var);
		$expmodule8b = date("Y-m-d", strtotime($date));

		$d1 = new \DateTime("now");
		$d2 = new \DateTime($expmodule8b);

		$interval = $d2->diff($d1);
		$diffmodule8 = $interval->format('%a');
		// echo $diffmodule8;
		if($diffmodule8 == 0 && $modulesuser->getModule8activation() == 1)// si module expiré
		{
			$soldepoints = $credits - $prixmodule8;
			if($credits >= $prixmodule8)
			{
				//prolongation de l'abonnement
				$expiration = date('d/m/Y', strtotime("+30 days"));
				$modulesuser->setModule8expiration($expiration);
				$userdetails->setCredits($soldepoints);
				$em->flush();
			}
			else //S'il n'y a pas assez de points
			{
				$modulesuser->setModule8activation(0);
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
		elseif($credits < 5 && $modulesuser->getModule8activation() == 1) //Nombre de points bas, envoi alerte.
		{//echo '1';
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
		//Fin données module8
// Fin des controles du module8