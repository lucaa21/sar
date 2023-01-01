<?php
						if($modulform->getModule7activation() == 1 && $modulesbdd->getModule7activation() == 0 )
						{
							if($credits < $module7prix)
							{
								// echo 'return1';
								$grant = 'nok';				
								return $this->render('BaclooCrmBundle:Crm:buyfiche.html.twig', array(
													'previous'    => $previous,
													'credits'    => $credits,
													'prix'    => $module7prix,
													'grant'    => $grant
													));	
							}
							else
							{
								$expiration = date('d/m/Y', strtotime("+30 days"));//echo $expiration;
								$soldepoints = $credits - $module7prix;
								$userdetails->setCredits($soldepoints);
								$modulesbdd->setModule7prix($module7prix);
								$modulesbdd->setModule7debut(date('d/m/Y'));
								$modulesbdd->setModule7expiration($expiration);
								$modulesbdd->setModule7activation(1);
								$em->persist($modulesbdd);
								$em->detach($moda);
								$em->flush();							
							}
						}
						elseif($modulform->getModule7activation() == 0  && $modulesbdd->getModule7activation() == 1)
						{
								$expiration = date('d/m/Y');//echo 'tttttt'.$expiration;
								$modulesbdd->setModule7expiration($expiration);
								$modulesbdd->setModule7activation(0);
								$em->persist($modulesbdd);
								$em->detach($moda);
								$em->flush();
						}
						elseif($modulform->getModule7activation() == 1 && $modulesbdd->getModule7activation() != 1)
						{//echo 'dididididididid';
							$module7prix = 10;
							if($credits < $module7prix)
							{
								// echo 'return1';
								$grant = 'nok';				
								return $this->render('BaclooCrmBundle:Crm:buyfiche.html.twig', array(
													'previous'    => $previous,
													'credits'    => $credits,
													'prix'    => $module7prix,
													'grant'    => $grant
													));	
							}
							else
							{
								$expiration = date('d/m/Y', strtotime("+30 days"));//echo $expiration;
								$soldepoints = $credits - $module7prix;
								$userdetails->setCredits($soldepoints);
								$modulesbdd->setModule7prix($module7prix);
								$modulesbdd->setModule7debut(date('d/m/Y'));
								$modulesbdd->setModule7expiration($expiration);
								$modulesbdd->setModule7activation(1);
								$em->persist($modulesbdd);
								$em->detach($moda);
								$em->flush();							
							}
						}
						elseif($modulform->getModule7activation() == 1 && $modulesbdd->getModule7activation() == 1)
						{
							//echo 'bordel';
						}