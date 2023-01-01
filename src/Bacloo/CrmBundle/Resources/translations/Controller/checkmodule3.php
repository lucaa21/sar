<?php
		//les données de module3
		$expmodule3 = $modulesuser->getModule3expiration();
		$prixmodule3 = $modulesuser->getModule3prix();
		$module3 = $modulesuser->getModule3();

		$var = $expmodule3;
		$date = str_replace('/', '-', $var);
		$expmodule3b = date("Y-m-d", strtotime($date)); 

		$d1 = new \DateTime("now");
		$d2 = new \DateTime($expmodule3b);
		
		$interval = $d2->diff($d1);
		$diffmodule3 = $interval->format('%a');
		// echo $diffmodule3;
		if($diffmodule3 == 0 && $modulesuser->getModule3activation() == 1)// si module expiré
		{
			$soldepoints = $credits - $prixmodule3;
			if($credits >= $prixmodule3)
			{
				//prolongation de l'abonnement
				$expiration = date('d/m/Y', strtotime("+30 days"));
				$modulesuser->setModule3expiration($expiration);
				$userdetails->setCredits($soldepoints);
				$em->flush();
			}
			else //S'il n'y a pas assez de points
			{					
				$modulesuser->setModule3activation(0);
				$em->flush();
				
			if($listmodarret == 0)
				{
					$listmodarret = $module3;
					$comptemodarret = 1;
				}
				else
				{
					$listmodarret .= ','.$module3;
					$comptemodarret += 1;
				}
			}				
		}
		elseif($credits < 5 && $modulesuser->getModule3activation() == 1) //Nombre de points bas, envoi alerte.
		{//echo '1';
			if($listmodalerte == 0)
				{
					//echo '2';
					$listmodalerte = $module3;
					$comptemodalerte = 1;
				}
				else
				{
					//echo '3';
					$listmodalerte .= ','.$module3;
					$comptemodalerte += 1;
				}
		}
		//Fin données module3		
// Fin des controles du module3