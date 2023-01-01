<?php
						if($modulform->getModule3activation() == 1 && $modulesbdd->getModule3activation() == 0 )
						{
							if($credits < $module3prix)
							{
								// echo 'return1';
								$grant = 'nok';				
								return $this->render('BaclooCrmBundle:Crm:buyfiche.html.twig', array(
													'previous'    => $previous,
													'credits'    => $credits,
													'prix'    => $module3prix,
													'grant'    => $grant
													));	
							}
							else
							{
								$expiration = date('d/m/Y', strtotime("+30 days"));//echo $expiration;
								$soldepoints = $credits - $module3prix;
								$userdetails->setCredits($soldepoints);
								$modulesbdd->setModule3prix($module3prix);
								$modulesbdd->setModule3debut(date('d/m/Y'));
								$modulesbdd->setModule3expiration($expiration);
								$modulesbdd->setModule3activation(1);
								$em->persist($modulesbdd);
								$em->detach($moda);
								$em->flush();							
							}
						}
						elseif($modulform->getModule3activation() == 0  && $modulesbdd->getModule3activation() == 1)
						{
								$expiration = date('d/m/Y');//echo 'tttttt'.$expiration;
								$modulesbdd->setModule3expiration($expiration);
								$modulesbdd->setModule3activation(0);
								$em->persist($modulesbdd);
								$em->detach($moda);
								$em->flush();
						}
						elseif($modulform->getModule3activation() == 1 && $modulesbdd->getModule3activation() != 1)
						{//echo 'dididididididid';
							$module3prix = 10;
							if($credits < $module3prix)
							{
								// echo 'return1';
								$grant = 'nok';				
								return $this->render('BaclooCrmBundle:Crm:buyfiche.html.twig', array(
													'previous'    => $previous,
													'credits'    => $credits,
													'prix'    => $module3prix,
													'grant'    => $grant
													));	
							}
							else
							{
								$expiration = date('d/m/Y', strtotime("+30 days"));//echo $expiration;
								$soldepoints = $credits - $module3prix;
								$userdetails->setCredits($soldepoints);
								$modulesbdd->setModule3prix($module3prix);
								$modulesbdd->setModule3debut(date('d/m/Y'));
								$modulesbdd->setModule3expiration($expiration);
								$modulesbdd->setModule3activation(1);
								$em->persist($modulesbdd);
								$em->detach($moda);
								$em->flush();							
							}
						}
						elseif($modulform->getModule3activation() == 1 && $modulesbdd->getModule3activation() == 1)
						{
							//echo 'bordel';
						}