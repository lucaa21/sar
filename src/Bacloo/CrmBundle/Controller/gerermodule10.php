<?php
						if($modulform->getModule10activation() == 1 && $modulesbdd->getModule10activation() == 0 )
						{
							if($credits < $module10prix)
							{
								// echo 'return1';
								$grant = 'nok';				
								return $this->render('BaclooCrmBundle:Crm:buyfiche.html.twig', array(
													'previous'    => $previous,
													'credits'    => $credits,
													'prix'    => $module10prix,
													'grant'    => $grant
													));	
							}
							else
							{
								$expiration = date('d/m/Y', strtotime("+30 days"));//echo $expiration;
								$soldepoints = $credits - $module10prix;
								$userdetails->setCredits($soldepoints);
								$modulesbdd->setModule10prix($module10prix);
								$modulesbdd->setModule10debut(date('d/m/Y'));
								$modulesbdd->setModule10expiration($expiration);
								$modulesbdd->setModule10activation(1);
								$em->persist($modulesbdd);
								$em->detach($moda);
								$em->flush();							
							}
						}
						elseif($modulform->getModule10activation() == 0  && $modulesbdd->getModule10activation() == 1)
						{
								$expiration = date('d/m/Y');//echo 'tttttt'.$expiration;
								$modulesbdd->setModule10expiration($expiration);
								$modulesbdd->setModule10activation(0);
								$em->persist($modulesbdd);
								$em->detach($moda);
								$em->flush();
						}
						elseif($modulform->getModule10activation() == 1 && $modulesbdd->getModule10activation() != 1)
						{//echo 'dididididididid';
							$module10prix = 10;
							if($credits < $module10prix)
							{
								// echo 'return1';
								$grant = 'nok';				
								return $this->render('BaclooCrmBundle:Crm:buyfiche.html.twig', array(
													'previous'    => $previous,
													'credits'    => $credits,
													'prix'    => $module10prix,
													'grant'    => $grant
													));	
							}
							else
							{
								$expiration = date('d/m/Y', strtotime("+30 days"));//echo $expiration;
								$soldepoints = $credits - $module10prix;
								$userdetails->setCredits($soldepoints);
								$modulesbdd->setModule10prix($module10prix);
								$modulesbdd->setModule10debut(date('d/m/Y'));
								$modulesbdd->setModule10expiration($expiration);
								$modulesbdd->setModule10activation(1);
								$em->persist($modulesbdd);
								$em->detach($moda);
								$em->flush();							
							}
						}
						elseif($modulform->getModule10activation() == 1 && $modulesbdd->getModule10activation() == 1)
						{
							//echo 'bordel';
						}