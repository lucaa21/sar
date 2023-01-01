<?php
						if($modulform->getModule2activation() == 1 && $modulesbdd->getModule2activation() == 0 )
						{
							if($credits < $module2prix)
							{
								// echo 'return1';
								$grant = 'nok';				
								return $this->render('BaclooCrmBundle:Crm:buyfiche.html.twig', array(
													'previous'    => $previous,
													'credits'    => $credits,
													'prix'    => $module2prix,
													'grant'    => $grant
													));	
							}
							else
							{
								$expiration = date('d/m/Y', strtotime("+30 days"));//echo $expiration;
								$soldepoints = $credits - $module2prix;
								$userdetails->setCredits($soldepoints);
								$modulesbdd->setModule2prix($module2prix);
								$modulesbdd->setModule2debut(date('d/m/Y'));
								$modulesbdd->setModule2expiration($expiration);
								$modulesbdd->setModule2activation(1);
								$em->persist($modulesbdd);
								$em->detach($moda);
								$em->flush();							
							}
						}
						elseif($modulform->getModule2activation() == 0  && $modulesbdd->getModule2activation() == 1)
						{
								$expiration = date('d/m/Y');//echo 'tttttt'.$expiration;
								$modulesbdd->setModule2expiration($expiration);
								$modulesbdd->setModule2activation(0);
								$em->persist($modulesbdd);
								$em->detach($moda);
								$em->flush();
						}
						elseif($modulform->getModule2activation() == 1 && $modulesbdd->getModule2activation() != 1)
						{//echo 'dididididididid';
							$module2prix = 10;
							if($credits < $module2prix)
							{
								// echo 'return1';
								$grant = 'nok';				
								return $this->render('BaclooCrmBundle:Crm:buyfiche.html.twig', array(
													'previous'    => $previous,
													'credits'    => $credits,
													'prix'    => $module2prix,
													'grant'    => $grant
													));	
							}
							else
							{
								$expiration = date('d/m/Y', strtotime("+30 days"));//echo $expiration;
								$soldepoints = $credits - $module2prix;
								$userdetails->setCredits($soldepoints);
								$modulesbdd->setModule2prix($module2prix);
								$modulesbdd->setModule2debut(date('d/m/Y'));
								$modulesbdd->setModule2expiration($expiration);
								$modulesbdd->setModule2activation(1);
								$em->persist($modulesbdd);
								$em->detach($moda);
								$em->flush();							
							}
						}
						elseif($modulform->getModule2activation() == 1 && $modulesbdd->getModule2activation() == 1)
						{
							//echo 'bordel';
						}