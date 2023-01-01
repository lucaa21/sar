<?php
		//les données de module12
		$expmodule12 = $modulesuser->getModule12expiration();
		$prixmodule12 = $modulesuser->getModule12prix();
		$module12 = $modulesuser->getModule12();

		$var = $expmodule12;
		$date = str_replace('/', '-', $var);
		$expmodule12b = date("Y-m-d", strtotime($date));

		$d1 = new \DateTime("now");
		$d2 = new \DateTime($expmodule12b);

		$interval = $d2->diff($d1);
		$diffmodule12 = $interval->format('%a');
		// echo $diffmodule12;
		if($diffmodule12 == 0 && $modulesuser->getModule12activation() == 1)// si module expiré
		{
			$soldepoints = $credits - $prixmodule12;
			if($credits >= $prixmodule12)
			{
				//prolongation de l'abonnement
				$expiration = date('d/m/Y', strtotime("+30 days"));
				$modulesuser->setModule12expiration($expiration);
				$userdetails->setCredits($soldepoints);
				$em->flush();
			}
			else //S'il n'y a pas assez de points
			{
				$modulesuser->setModule12activation(0);
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
		elseif($credits < 5 && $modulesuser->getModule12activation() == 1) //Nombre de points bas, envoi alerte.
		{
			if($listmodalerte == 0)
				{
					// //echo '2';
					$listmodalerte = $module12;
					$comptemodalerte = 1;
				}
				else
				{
					// //echo '3';
					$listmodalerte .= ','.$module12;
					$comptemodalerte += 1;
				}
		}
		//Fin données module12
// Fin des controles du module12