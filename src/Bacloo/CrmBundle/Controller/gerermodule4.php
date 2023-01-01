<?php
						if($modulform->getModule4activation() == 1 && $modulesbdd->getModule4activation() == 0 )
						{
							if($credits < $module4prix)
							{
								// echo 'return1';
								$grant = 'nok';				
								return $this->render('BaclooCrmBundle:Crm:buyfiche.html.twig', array(
													'previous'    => $previous,
													'credits'    => $credits,
													'prix'    => $module4prix,
													'grant'    => $grant
													));	
							}
							else
							{
								$expiration = date('d/m/Y', strtotime("+30 days"));//echo $expiration;
								$soldepoints = $credits - $module4prix;
								$userdetails->setCredits($soldepoints);
								$modulesbdd->setModule4prix($module4prix);
								$modulesbdd->setModule4debut(date('d/m/Y'));
								$modulesbdd->setModule4expiration($expiration);
								$modulesbdd->setModule4activation(1);
								$em->persist($modulesbdd);
								$em->detach($moda);
								$em->flush();							
							}
						}
						elseif($modulform->getModule4activation() == 0  && $modulesbdd->getModule4activation() == 1)
						{
								$expiration = date('d/m/Y');//echo 'tttttt'.$expiration;
								$modulesbdd->setModule4expiration($expiration);
								$modulesbdd->setModule4activation(0);
								$em->persist($modulesbdd);
								$em->detach($moda);
								$em->flush();
						}
						elseif($modulform->getModule4activation() == 1 && $modulesbdd->getModule4activation() != 1)
						{//echo 'dididididididid';
							$module4prix = 10;
							if($credits < $module4prix)
							{
								// echo 'return1';
								$grant = 'nok';				
								return $this->render('BaclooCrmBundle:Crm:buyfiche.html.twig', array(
													'previous'    => $previous,
													'credits'    => $credits,
													'prix'    => $module4prix,
													'grant'    => $grant
													));	
							}
							else
							{
								$expiration = date('d/m/Y', strtotime("+30 days"));//echo $expiration;
								$soldepoints = $credits - $module4prix;
								$userdetails->setCredits($soldepoints);
								$modulesbdd->setModule4prix($module4prix);
								$modulesbdd->setModule4debut(date('d/m/Y'));
								$modulesbdd->setModule4expiration($expiration);
								$modulesbdd->setModule4activation(1);
								$em->persist($modulesbdd);
								$em->detach($moda);
								$em->flush();							
							}
						}
						elseif($modulform->getModule4activation() == 1 && $modulesbdd->getModule4activation() == 1)
						{
							//echo 'bordel';
						}