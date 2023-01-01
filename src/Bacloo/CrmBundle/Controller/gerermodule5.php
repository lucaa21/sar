<?php
						if($modulform->getModule5activation() == 1 && $modulesbdd->getModule5activation() == 0 )
						{
							if($credits < $module5prix)
							{
								// echo 'return1';
								$grant = 'nok';				
								return $this->render('BaclooCrmBundle:Crm:buyfiche.html.twig', array(
													'previous'    => $previous,
													'credits'    => $credits,
													'prix'    => $module5prix,
													'grant'    => $grant
													));	
							}
							else
							{
								$expiration = date('d/m/Y', strtotime("+30 days"));//echo $expiration;
								$soldepoints = $credits - $module5prix;
								$userdetails->setCredits($soldepoints);
								$modulesbdd->setModule5prix($module5prix);
								$modulesbdd->setModule5debut(date('d/m/Y'));
								$modulesbdd->setModule5expiration($expiration);
								$modulesbdd->setModule5activation(1);
								$em->persist($modulesbdd);
								$em->detach($moda);
								$em->flush();							
							}
						}
						elseif($modulform->getModule5activation() == 0  && $modulesbdd->getModule5activation() == 1)
						{
								$expiration = date('d/m/Y');//echo 'tttttt'.$expiration;
								$modulesbdd->setModule5expiration($expiration);
								$modulesbdd->setModule5activation(0);
								$em->persist($modulesbdd);
								$em->detach($moda);
								$em->flush();
						}
						elseif($modulform->getModule5activation() == 1 && $modulesbdd->getModule5activation() != 1)
						{//echo 'dididididididid';
							$module5prix = 10;
							if($credits < $module5prix)
							{
								// echo 'return1';
								$grant = 'nok';				
								return $this->render('BaclooCrmBundle:Crm:buyfiche.html.twig', array(
													'previous'    => $previous,
													'credits'    => $credits,
													'prix'    => $module5prix,
													'grant'    => $grant
													));	
							}
							else
							{
								$expiration = date('d/m/Y', strtotime("+30 days"));//echo $expiration;
								$soldepoints = $credits - $module5prix;
								$userdetails->setCredits($soldepoints);
								$modulesbdd->setModule5prix($module5prix);
								$modulesbdd->setModule5debut(date('d/m/Y'));
								$modulesbdd->setModule5expiration($expiration);
								$modulesbdd->setModule5activation(1);
								$em->persist($modulesbdd);
								$em->detach($moda);
								$em->flush();							
							}
						}
						elseif($modulform->getModule5activation() == 1 && $modulesbdd->getModule5activation() == 1)
						{
							//echo 'bordel';
						}