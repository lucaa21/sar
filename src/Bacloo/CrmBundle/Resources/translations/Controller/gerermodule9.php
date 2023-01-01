<?php
						if($modulform->getModule9activation() == 1 && $modulesbdd->getModule9activation() == 0 )
						{
							if($credits < $module9prix)
							{
								// echo 'return1';
								$grant = 'nok';				
								return $this->render('BaclooCrmBundle:Crm:buyfiche.html.twig', array(
													'previous'    => $previous,
													'credits'    => $credits,
													'prix'    => $module9prix,
													'grant'    => $grant
													));	
							}
							else
							{
								$expiration = date('d/m/Y', strtotime("+30 days"));//echo $expiration;
								$soldepoints = $credits - $module9prix;
								$userdetails->setCredits($soldepoints);
								$modulesbdd->setModule9prix($module9prix);
								$modulesbdd->setModule9debut(date('d/m/Y'));
								$modulesbdd->setModule9expiration($expiration);
								$modulesbdd->setModule9activation(1);
								$em->persist($modulesbdd);
								$em->detach($moda);
								$em->flush();							
							}
						}
						elseif($modulform->getModule9activation() == 0  && $modulesbdd->getModule9activation() == 1)
						{
								$expiration = date('d/m/Y');//echo 'tttttt'.$expiration;
								$modulesbdd->setModule9expiration($expiration);
								$modulesbdd->setModule9activation(0);
								$em->persist($modulesbdd);
								$em->detach($moda);
								$em->flush();
						}
						elseif($modulform->getModule9activation() == 1 && $modulesbdd->getModule9activation() != 1)
						{//echo 'dididididididid';
							$module9prix = 10;
							if($credits < $module9prix)
							{
								// echo 'return1';
								$grant = 'nok';				
								return $this->render('BaclooCrmBundle:Crm:buyfiche.html.twig', array(
													'previous'    => $previous,
													'credits'    => $credits,
													'prix'    => $module9prix,
													'grant'    => $grant
													));	
							}
							else
							{
								$expiration = date('d/m/Y', strtotime("+30 days"));//echo $expiration;
								$soldepoints = $credits - $module9prix;
								$userdetails->setCredits($soldepoints);
								$modulesbdd->setModule9prix($module9prix);
								$modulesbdd->setModule9debut(date('d/m/Y'));
								$modulesbdd->setModule9expiration($expiration);
								$modulesbdd->setModule9activation(1);
								$em->persist($modulesbdd);
								$em->detach($moda);
								$em->flush();							
							}
						}
						elseif($modulform->getModule9activation() == 1 && $modulesbdd->getModule9activation() == 1)
						{
							//echo 'bordel';
						}