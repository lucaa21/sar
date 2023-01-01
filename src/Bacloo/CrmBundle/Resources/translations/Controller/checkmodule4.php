<?php
		//les données de module4
		$expmodule4 = $modulesuser->getModule4expiration();
		$prixmodule4 = $modulesuser->getModule4prix();
		$module4 = $modulesuser->getModule4();

		$var = $expmodule4;
		$date = str_replace('/', '-', $var);
		$expmodule4b = date("Y-m-d", strtotime($date)); 

		$d1 = new \DateTime("now");
		$d2 = new \DateTime($expmodule4b);
		
		$interval = $d2->diff($d1);
		$diffmodule4 = $interval->format('%a');
		// echo $diffmodule4;
		if($diffmodule4 == 0 && $modulesuser->getModule4activation() == 1)// si module expiré
		{
			$soldepoints = $credits - $prixmodule4;
			if($credits >= $prixmodule4)
			{
				//prolongation de l'abonnement
				$expiration = date('d/m/Y', strtotime("+30 days"));
				$modulesuser->setModule4expiration($expiration);
				$userdetails->setCredits($soldepoints);
				$em->flush();
			}
			else //S'il n'y a pas assez de points
			{					
				$modulesuser->setModule4activation(0);
				$em->flush();
				
			if($listmodarret == 0)
				{
					$listmodarret = $module4;
					$comptemodarret = 1;
				}
				else
				{
					$listmodarret .= ','.$module4;
					$comptemodarret += 1;
				}
			}				
		}
		elseif($credits < 5 && $modulesuser->getModule4activation() == 1) //Nombre de points bas, envoi alerte.
		{//echo '1';
			if($listmodalerte == 0)
				{
					//echo '2';
					$listmodalerte = $module4;
					$comptemodalerte = 1;
				}
				else
				{
					//echo '3';
					$listmodalerte .= ','.$module4;
					$comptemodalerte += 1;
				}
		}
		//Fin données module4		
// Fin des controles du module4