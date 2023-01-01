<?php
						if($modulform->getModule6activation() == 1 && $modulesbdd->getModule6activation() == 0 )
						{
							if($credits < $module6prix)
							{
								// echo 'return1';
								$grant = 'nok';				
								return $this->render('BaclooCrmBundle:Crm:buyfiche.html.twig', array(
													'previous'    => $previous,
													'credits'    => $credits,
													'prix'    => $module6prix,
													'grant'    => $grant
													));	
							}
							else
							{
								$expiration = date('d/m/Y', strtotime("+30 days"));//echo $expiration;
								$soldepoints = $credits - $module6prix;
								$userdetails->setCredits($soldepoints);
								$modulesbdd->setModule6prix($module6prix);
								$modulesbdd->setModule6debut(date('d/m/Y'));
								$modulesbdd->setModule6expiration($expiration);
								$modulesbdd->setModule6activation(1);
								$em->persist($modulesbdd);
								$em->detach($moda);
								$em->flush();							
							}
						}
						elseif($modulform->getModule6activation() == 0  && $modulesbdd->getModule6activation() == 1)
						{
								$expiration = date('d/m/Y');//echo 'tttttt'.$expiration;
								$modulesbdd->setModule6expiration($expiration);
								$modulesbdd->setModule6activation(0);
								$em->persist($modulesbdd);
								$em->detach($moda);
								$em->flush();
						}
						elseif($modulform->getModule6activation() == 1 && $modulesbdd->getModule6activation() != 1)
						{//echo 'dididididididid';
							$module6prix = 10;
							if($credits < $module6prix)
							{
								// echo 'return1';
								$grant = 'nok';				
								return $this->render('BaclooCrmBundle:Crm:buyfiche.html.twig', array(
													'previous'    => $previous,
													'credits'    => $credits,
													'prix'    => $module6prix,
													'grant'    => $grant
													));	
							}
							else
							{
								$expiration = date('d/m/Y', strtotime("+30 days"));//echo $expiration;
								$soldepoints = $credits - $module6prix;
								$userdetails->setCredits($soldepoints);
								$modulesbdd->setModule6prix($module6prix);
								$modulesbdd->setModule6debut(date('d/m/Y'));
								$modulesbdd->setModule6expiration($expiration);
								$modulesbdd->setModule6activation(1);
								$em->persist($modulesbdd);
								$em->detach($moda);
								$em->flush();							
							}
						}
						elseif($modulform->getModule6activation() == 1 && $modulesbdd->getModule6activation() == 1)
						{
							//echo 'bordel';
						}