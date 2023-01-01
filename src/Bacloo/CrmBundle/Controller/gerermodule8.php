<?php
						if($modulform->getModule8activation() == 1 && $modulesbdd->getModule8activation() == 0 )
						{
							if($credits < $module8prix)
							{
								// echo 'return1';
								$grant = 'nok';				
								return $this->render('BaclooCrmBundle:Crm:buyfiche.html.twig', array(
													'previous'    => $previous,
													'credits'    => $credits,
													'prix'    => $module8prix,
													'grant'    => $grant
													));	
							}
							else
							{
								$expiration = date('d/m/Y', strtotime("+30 days"));//echo $expiration;
								$soldepoints = $credits - $module8prix;
								$userdetails->setCredits($soldepoints);
								$modulesbdd->setModule8prix($module8prix);
								$modulesbdd->setModule8debut(date('d/m/Y'));
								$modulesbdd->setModule8expiration($expiration);
								$modulesbdd->setModule8activation(1);
								$em->persist($modulesbdd);
								$em->detach($moda);
								$em->flush();							
							}
						}
						elseif($modulform->getModule8activation() == 0  && $modulesbdd->getModule8activation() == 1)
						{
								$expiration = date('d/m/Y');//echo 'tttttt'.$expiration;
								$modulesbdd->setModule8expiration($expiration);
								$modulesbdd->setModule8activation(0);
								$em->persist($modulesbdd);
								$em->detach($moda);
								$em->flush();
						}
						elseif($modulform->getModule8activation() == 1 && $modulesbdd->getModule8activation() != 1)
						{//echo 'dididididididid';
							$module8prix = 10;
							if($credits < $module8prix)
							{
								// echo 'return1';
								$grant = 'nok';				
								return $this->render('BaclooCrmBundle:Crm:buyfiche.html.twig', array(
													'previous'    => $previous,
													'credits'    => $credits,
													'prix'    => $module8prix,
													'grant'    => $grant
													));	
							}
							else
							{
								$expiration = date('d/m/Y', strtotime("+30 days"));//echo $expiration;
								$soldepoints = $credits - $module8prix;
								$userdetails->setCredits($soldepoints);
								$modulesbdd->setModule8prix($module8prix);
								$modulesbdd->setModule8debut(date('d/m/Y'));
								$modulesbdd->setModule8expiration($expiration);
								$modulesbdd->setModule8activation(1);
								$em->persist($modulesbdd);
								$em->detach($moda);
								$em->flush();							
							}
						}
						elseif($modulform->getModule8activation() == 1 && $modulesbdd->getModule8activation() == 1)
						{
							//echo 'bordel';
						}