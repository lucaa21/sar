<?php
		//les données de module2
		$expmodule2 = $modulesuser->getModule2expiration();
		$prixmodule2 = $modulesuser->getModule2prix();
		$module2 = $modulesuser->getModule2();

		$var = $expmodule2;
		$date = str_replace('/', '-', $var);
		$expmodule2b = date("Y-m-d", strtotime($date)); 

		$d1 = new \DateTime("now");
		$d2 = new \DateTime($expmodule2b);
		
		$interval = $d2->diff($d1);
		$diffmodule2 = $interval->format('%a');
		// echo $diffmodule2;
		if($diffmodule2 == 0 && $modulesuser->getModule2activation() == 1)// si module expiré
		{
			$soldepoints = $credits - $prixmodule2;
			if($credits >= $prixmodule2)
			{
				//prolongation de l'abonnement
				$expiration = date('d/m/Y', strtotime("+30 days"));
				$modulesuser->setModule2expiration($expiration);
				$userdetails->setCredits($soldepoints);
				$em->flush();
			}
			else //S'il n'y a pas assez de points
			{					
				$modulesuser->setModule2activation(0);
				$em->flush();
				
			if($listmodarret == 0)
				{
					$listmodarret = $module2;
					$comptemodarret = 1;
				}
				else
				{
					$listmodarret .= ','.$module2;
					$comptemodarret += 1;
				}
			}				
		}
		elseif($credits < 5 && $modulesuser->getModule2activation() == 1) //Nombre de points bas, envoi alerte.
		{//echo '1';
			if($listmodalerte == 0)
				{
					//echo '2';
					$listmodalerte = $module2;
					$comptemodalerte = 1;
				}
				else
				{
					//echo '3';
					$listmodalerte .= ','.$module2;
					$comptemodalerte += 1;
				}
		}
		//Fin données module2		
// Fin des controles du module2