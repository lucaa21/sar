<?php
		//les données de module1
		$expmodule1 = $modulesuser->getModule1expiration();
		$prixmodule1 = $modulesuser->getModule1prix();
		$module1 = $modulesuser->getModule1();

		$var = $expmodule1;
		$date = str_replace('/', '-', $var);
		$expmodule1b = date("Y-m-d", strtotime($date)); 

		$d1 = new \DateTime("now");
		$d2 = new \DateTime($expmodule1b);
		
		$interval = $d2->diff($d1);
		$diffmodule1 = $interval->format('%a');
		// echo $diffmodule1;
		if($diffmodule1 == 0 && $modulesuser->getModule1activation() == 1)// si module expiré
		{
			$soldepoints = $credits - $prixmodule1;
			if($credits >= $prixmodule1)
			{
				//prolongation de l'abonnement
				$expiration = date('d/m/Y', strtotime("+30 days"));
				$modulesuser->setModule1expiration($expiration);
				$userdetails->setCredits($soldepoints);
				$em->flush();
			}
			else //S'il n'y a pas assez de points
			{					
				$modulesuser->setModule1activation(0);
				$em->flush();
				
			if($listmodarret == 0)
				{
					$listmodarret = $module1;
					$comptemodarret = 1;
				}
				else
				{
					$listmodarret .= ','.$module1;
					$comptemodarret += 1;
				}
			}				
		}
		elseif($credits < 5 && $modulesuser->getModule1activation() == 1) //Nombre de points bas, envoi alerte.
		{//echo '1';
			if($listmodalerte == 0)
				{
					//echo '2';
					$listmodalerte = $module1;
					$comptemodalerte = 1;
				}
				else
				{
					//echo '3';
					$listmodalerte .= ','.$module1;
					$comptemodalerte += 1;
				}
		}
		//Fin données module1		
// Fin des controles du module1