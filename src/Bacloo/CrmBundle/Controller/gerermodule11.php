<?php
						if($modulform->getModule11activation() == 1 && $modulesbdd->getModule11activation() == 0 )
						{
							if($credits < $module11prix)
							{
								// echo 'return1';
								$grant = 'nok';				
								return $this->render('BaclooCrmBundle:Crm:buyfiche.html.twig', array(
													'previous'    => $previous,
													'credits'    => $credits,
													'prix'    => $module11prix,
													'grant'    => $grant
													));	
							}
							else
							{
								$expiration = date('d/m/Y', strtotime("+30 days"));//echo $expiration;
								$soldepoints = $credits - $module11prix;
								$userdetails->setCredits($soldepoints);
								$modulesbdd->setModule11prix($module11prix);
								$modulesbdd->setModule11debut(date('d/m/Y'));
								$modulesbdd->setModule11expiration($expiration);
								$modulesbdd->setModule11activation(1);
								$em->persist($modulesbdd);
								$em->detach($moda);
								$em->flush();							
							}
						}
						elseif($modulform->getModule11activation() == 0  && $modulesbdd->getModule11activation() == 1)
						{
								$expiration = date('d/m/Y');//echo 'tttttt'.$expiration;
								$modulesbdd->setModule11expiration($expiration);
								$modulesbdd->setModule11activation(0);
								$em->persist($modulesbdd);
								$em->detach($moda);
								$em->flush();
						}
						elseif($modulform->getModule11activation() == 1 && $modulesbdd->getModule11activation() != 1)
						{//echo 'dididididididid';
							$module11prix = 10;
							if($credits < $module11prix)
							{
								// echo 'return1';
								$grant = 'nok';				
								return $this->render('BaclooCrmBundle:Crm:buyfiche.html.twig', array(
													'previous'    => $previous,
													'credits'    => $credits,
													'prix'    => $module11prix,
													'grant'    => $grant
													));	
							}
							else
							{
								$expiration = date('d/m/Y', strtotime("+30 days"));//echo $expiration;
								$soldepoints = $credits - $module11prix;
								$userdetails->setCredits($soldepoints);
								$modulesbdd->setModule11prix($module11prix);
								$modulesbdd->setModule11debut(date('d/m/Y'));
								$modulesbdd->setModule11expiration($expiration);
								$modulesbdd->setModule11activation(1);
								$em->persist($modulesbdd);
								$em->detach($moda);
								$em->flush();							
							}
						}
						elseif($modulform->getModule11activation() == 1 && $modulesbdd->getModule11activation() == 1)
						{
							//echo 'bordel';
						}