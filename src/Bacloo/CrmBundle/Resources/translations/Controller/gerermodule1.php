<?php
						if($modulform->getModule1activation() == 1 && $modulesbdd->getModule1activation() == 0 )
						{
							if($credits < $module1prix)
							{
								// echo 'return1';
								$grant = 'nok';				
								return $this->render('BaclooCrmBundle:Crm:buyfiche.html.twig', array(
													'previous'    => $previous,
													'credits'    => $credits,
													'prix'    => $module1prix,
													'grant'    => $grant
													));	
							}
							else
							{
								$expiration = date('d/m/Y', strtotime("+30 days"));//echo $expiration;
								$soldepoints = $credits - $module1prix;
								$userdetails->setCredits($soldepoints);
								$modulesbdd->setModule1prix($module1prix);
								$modulesbdd->setModule1debut(date('d/m/Y'));
								$modulesbdd->setModule1expiration($expiration);
								$modulesbdd->setModule1activation(1);
								$em->persist($modulesbdd);
								$em->detach($moda);
								$em->flush();							
							}
						}
						elseif($modulform->getModule1activation() == 0  && $modulesbdd->getModule1activation() == 1)
						{
								$expiration = date('d/m/Y');//echo 'tttttt'.$expiration;
								$modulesbdd->setModule1expiration($expiration);
								$modulesbdd->setModule1activation(0);
								$em->persist($modulesbdd);
								$em->detach($moda);
								$em->flush();
						}
						elseif($modulform->getModule1activation() == 1 && $modulesbdd->getModule1activation() != 1)
						{//echo 'dididididididid';
							$module1prix = 10;
							if($credits < $module1prix)
							{
								// echo 'return1';
								$grant = 'nok';				
								return $this->render('BaclooCrmBundle:Crm:buyfiche.html.twig', array(
													'previous'    => $previous,
													'credits'    => $credits,
													'prix'    => $module1prix,
													'grant'    => $grant
													));	
							}
							else
							{
								$expiration = date('d/m/Y', strtotime("+30 days"));//echo $expiration;
								$soldepoints = $credits - $module1prix;
								$userdetails->setCredits($soldepoints);
								$modulesbdd->setModule1prix($module1prix);
								$modulesbdd->setModule1debut(date('d/m/Y'));
								$modulesbdd->setModule1expiration($expiration);
								$modulesbdd->setModule1activation(1);
								$em->persist($modulesbdd);
								$em->detach($moda);
								$em->flush();							
							}
						}
						elseif($modulform->getModule1activation() == 1 && $modulesbdd->getModule1activation() == 1)
						{
							//echo 'bordel';
						}