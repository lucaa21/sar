<?php
						if($modulform->getModule12activation() == 1 && $modulesbdd->getModule12activation() == 0 )
						{
							if($credits < $module12prix)
							{
								// echo 'return1';
								$grant = 'nok';				
								return $this->render('BaclooCrmBundle:Crm:buyfiche.html.twig', array(
													'previous'    => $previous,
													'credits'    => $credits,
													'prix'    => $module12prix,
													'grant'    => $grant
													));	
							}
							else
							{
								$expiration = date('d/m/Y', strtotime("+30 days"));//echo $expiration;
								$soldepoints = $credits - $module12prix;
								$userdetails->setCredits($soldepoints);
								$modulesbdd->setModule12prix($module12prix);
								$modulesbdd->setModule12debut(date('d/m/Y'));
								$modulesbdd->setModule12expiration($expiration);
								$modulesbdd->setModule12activation(1);
								$em->persist($modulesbdd);
								$em->detach($moda);
								$em->flush();							
							}
						}
						elseif($modulform->getModule12activation() == 0  && $modulesbdd->getModule12activation() == 1)
						{
								$expiration = date('d/m/Y');//echo 'tttttt'.$expiration;
								$modulesbdd->setModule12expiration($expiration);
								$modulesbdd->setModule12activation(0);
								$em->persist($modulesbdd);
								$em->detach($moda);
								$em->flush();
						}
						elseif($modulform->getModule12activation() == 1 && $modulesbdd->getModule12activation() != 1)
						{//echo 'dididididididid';
							$module12prix = 10;
							if($credits < $module12prix)
							{
								// echo 'return1';
								$grant = 'nok';				
								return $this->render('BaclooCrmBundle:Crm:buyfiche.html.twig', array(
													'previous'    => $previous,
													'credits'    => $credits,
													'prix'    => $module12prix,
													'grant'    => $grant
													));	
							}
							else
							{
								$expiration = date('d/m/Y', strtotime("+30 days"));//echo $expiration;
								$soldepoints = $credits - $module12prix;
								$userdetails->setCredits($soldepoints);
								$modulesbdd->setModule12prix($module12prix);
								$modulesbdd->setModule12debut(date('d/m/Y'));
								$modulesbdd->setModule12expiration($expiration);
								$modulesbdd->setModule12activation(1);
								$em->persist($modulesbdd);
								$em->detach($moda);
								$em->flush();							
							}
						}
						elseif($modulform->getModule12activation() == 1 && $modulesbdd->getModule12activation() == 1)
						{
							//echo 'bordel';
						}