<?php
use Bacloo\CrmBundle\Entity\Afacturer;
use Bacloo\CrmBundle\Entity\Factures;
use Bacloo\CrmBundle\Entity\Locataclone;
use Bacloo\CrmBundle\Entity\Locationsclone;
use Bacloo\CrmBundle\Entity\Locationsslclone;
use Bacloo\CrmBundle\Entity\Locataventesclone;

// $debutmois = new DateTime("first day of last month");
// $finmois = new DateTime("last day of last month");
// OU
// $test = new DateTime("first day of last month");
// echo date("Y-m", strtotime($test));
// print_r(new DateTime("first day of last month"));
// echo date('Y-m-01');
// echo date('Y-m-d', strtotime("-1 month"));
if($mode == 'moisder')
{
	$debutmoisinit = date('Y-m-01', strtotime(" -1 month"));//Debut mois précédent
	$debutmois = date('Y-m-01', strtotime(" -1 month"));//Debut mois précédent	
	$finmoisinit = date('Y-m-t', strtotime(" -1 month"));//Fin du mois précédent
}
elseif($mode == 'forcing')
{
	$debutmoisinit = date('Y-m-01');//Debut mois précédent
	$debutmois = date('Y-m-01');//Debut mois précédent	
	$finmoisinit = date('Y-m-t');//Fin du mois précédent	
}
else
{
	$debutmoisinit = date('Y-m-01');//Debut mois précédent
	$debutmois = date('Y-m-01');//Debut mois précédent	
	$finmoisinit = date('Y-m-d');//Fin du mois précédent	
}
echo 'MODE '.$mode;	
$moisprec = date('M', strtotime(" -1 month"));//Debut mois précédent	
// $finmois = date('Y-m-t', strtotime(" -1 month"));//Fin mois précédent
			// $debutmois = new DateTime("first day of last month");//echo $debutmois->format('Y-m-d');			

			$today = date('Y-m-d');
			$todaysec = strtotime($today);

			// $debutmois = date('Y-m-01');
			$debutmoissecinit = strtotime($debutmoisinit);
			$debutmoissec = strtotime($debutmoisinit);
			$finmoissecinit = strtotime ($finmoisinit);			
			$em = $this->getDoctrine()->getManager();
			
			$qrcode = 0;
				//On récupère les codes contrats à facturer afin de faire une boucle
				//Pour cela on recherche les locations et locationssl avec une fin de loc > à la fin du mois
				//On les met dasn un tableau
				$locatatot = $em->getRepository('BaclooCrmBundle:Locata')
							->locationsafacturer($debutmoisinit, $finmoisinit);
// print_r($locatatot);							
				$vendatot = $em->getRepository('BaclooCrmBundle:Venda')
							->ventesafacturer($debutmoisinit, $finmoisinit);
							
				$achatstot = $em->getRepository('BaclooCrmBundle:Locatafrs')
							->achatsafacturer($debutmoisinit, $finmoisinit);
				//On fait ensuite une boucle sur les id de locata puis à l'intérieur de celle ci
				//on fait tourner une boucle sur les locations et locationssl en reprenant le principe de
				//la facturation définitive
					$touter = 0; //Toutes les loc du contrat sont terminées		
				//DEBUT DE LA FACTURATION MENSUELLE
				foreach($locatatot as $locatas)
				{	
					$go = 'XXX';echo '****';echo $locatas['f_client'];echo $locatas['f_id'];echo '****';echo 'GOOO11';echo $go;
					//Partie locations	
					// echo '**';echo $locatas['f_client'];echo '**';					
					$locata = $em->getRepository('BaclooCrmBundle:Locata')
								->findOneById($locatas['f_id']);
					// echo $locatas['f_client'];
					
					//Combien de locations sur ce contrats
					$nblocm = 0;//Pour ce mois-ci
					$nblocm1 = 0;//Pour le mois dernier
					foreach($locata->getLocations() as $loca)
					{
						//m-1
						echo ' *debutloc';echo $loca->getDebutloc();	
						echo ' *finloc';echo $loca->getFinloc();	
						if(strtotime($loca->getDebutloc()) <= strtotime(date('Y-m-01')) and strtotime($loca->getFinloc()) >= $debutmoissecinit){$nblocm1++;}
						
						//m
						if(strtotime($loca->getDebutloc()) <= strtotime(date('Y-m-d')) and strtotime($loca->getFinloc()) >= $debutmoissecinit){$nblocm++;}
					}				
					//Combien de locationssl sur ce contrats
					foreach($locata->getLocationssl() as $loca)
					{
						//m-1
						echo ' *debutloc';echo $loca->getDebutloc();	
						echo ' *finloc';echo $loca->getFinloc();
						if(strtotime($loca->getDebutloc()) <= strtotime(date('Y-m-01')) and strtotime($loca->getFinloc()) >= $debutmoissecinit){$nblocm1++;}
						
						//m
						if(strtotime($loca->getDebutloc()) <= strtotime(date('Y-m-d')) and strtotime($loca->getFinloc()) >= $debutmoissecinit){$nblocm++;}
					}
				
echo ' debutmoissecinit';echo date("Y-m-d",$debutmoissecinit) . "\n";					
echo ' finmoissecinit';echo date("Y-m-d",$finmoissecinit) . "\n";					
echo 'nblocm'; echo $nblocm;					
echo 'nblocm1'; echo $nblocm1;	
echo 'GOOO22';echo $go;					
					//Calcul du nombre de loc terminées à partir le locata
					$nblocterm = 0;//nb de locs terminées du mois m
					$nblocterm1 = 0;//nb de locs terminées du mois m
					$nblocecm = 0;//nb de locs en cours mois m
					$nblocecm1 = 0;//nb de locs en cours mois m-1
					foreach($locata->getLocations() as $loca)
					{
						if(strtotime($loca->getFinloc()) >= strtotime(date('Y-m-01')) && strtotime(($loca->getFinloc())) <= strtotime(date('Y-m-d')) && $loca->getEtatloc() == 'Location terminée'){$nblocterm++;}
						if(strtotime($loca->getFinloc()) < strtotime(date('Y-m-01')) && strtotime(($loca->getFinloc())) >= $debutmoissecinit && $loca->getEtatloc() == 'Location terminée'){$nblocterm1++;}
						if($loca->getEtatloc() == 'En location'){$nblocecm++;}
						if(strtotime($loca->getDebutloc()) < strtotime(date('Y-m-01')) && strtotime(($loca->getFinloc())) >= $debutmoissecinit){$nblocecm1++;}
					}
					foreach($locata->getLocationssl() as $loca)
					{
						if(strtotime($loca->getFinloc()) >= strtotime(date('Y-m-01')) && strtotime(($loca->getFinloc())) <= strtotime(date('Y-m-d')) && $loca->getEtatloc() == 'Location terminée'){$nblocterm++;}
						if(strtotime($loca->getFinloc()) < strtotime(date('Y-m-01')) && strtotime(($loca->getFinloc())) >= $debutmoissecinit && $loca->getEtatloc() == 'Location terminée'){$nblocterm1++;}
						if($loca->getEtatloc() == 'En location'){$nblocecm++;}
						if(strtotime($loca->getDebutloc()) < strtotime(date('Y-m-01')) && strtotime(($loca->getFinloc())) >= $debutmoissecinit){$nblocecm1++;}
					}
echo 'nblocterm'; echo $nblocterm;						
echo 'nblocterm1'; echo $nblocterm1;						
echo 'nblocecm'; echo $nblocecm;	
echo 'nblocecm1'; echo $nblocecm1;	
echo 'GOOO33';echo $go;		
echo ' LOCATAS ID '.$locatas['f_id'];			
					//Y a-t-il une facture pour ce mois-ci
					$locataclonedeja22 = $em->getRepository('BaclooCrmBundle:Locataclone')
								->findBy(array('oldid' => $locatas['f_id']));
					$nbfactm = 0;//nb de facture du mois m
					$nbfactm1 = 0;//nb de facture du mois m-1
					$nbfacterm = 0;//nb de facture terminées du mois m
					$nbfacterm1 = 0;//nb de facture terminées du mois m-1
					$dejafacm = 0;//nb de loc facturées mois m
					$dejafacm1 = 0;//nb de facture terminées du mois m-1
					$moisder = 0;
					
					//Calcul du nombre de loc commencées le mois dernier
					foreach($locata->getLocations() as $loca)
					{
						$debutmoisici = date('Y-m-01', strtotime(" -1 month"));echo 'LOCA DEBUTLOC'.$loca->getDebutloc();echo 'LOCA FINLOC'.$loca->getFinloc();echo ' DEBUT MOISDER '.$debutmoisici;
						//Si loc commencée avant début du mois courant et finit après début mois courant (loc en cours)
						if(strtotime($loca->getDebutloc()) < strtotime(date('Y-m-01')) && strtotime($loca->getFinloc()) >= strtotime($debutmoisici))
						{
							$moisder++;
							$finmois = date('Y-m-t', strtotime(" -1 month"));//Fin mois précédent
							$finmoissec = strtotime ($finmois);
						}
						elseif(strtotime($loca->getDebutloc()) >= strtotime(date('Y-m-01')) and strtotime($loca->getFinloc()) <= strtotime(date('Y-m-d')))//au moins une loc commence et finit le mois courant
						{
							// $moisder++;
							$finmois = date('Y-m-d');//Fin mois précédent
							$finmoissec = strtotime ($finmois);								
						}
					}
					foreach($locata->getLocationssl() as $loca)
					{
						$debutmoisici = date('Y-m-01', strtotime(" -1 month"));echo 'LOCA DEBUTLOC'.$loca->getDebutloc();echo 'LOCA FINLOC'.$loca->getFinloc();echo ' DEBUT MOISDER '.$debutmoisici;
						//Si loc commencée avant début du mois courant et finit après début mois courant (loc en cours)
						if(strtotime($loca->getDebutloc()) < strtotime(date('Y-m-01')) && strtotime($loca->getFinloc()) >= strtotime($debutmoisici))
						{
							$moisder++;
							$finmois = date('Y-m-t', strtotime(" -1 month"));//Fin mois précédent
							$finmoissec = strtotime ($finmois);
						}
						elseif(strtotime($loca->getDebutloc()) >= strtotime(date('Y-m-01')) and strtotime($loca->getFinloc()) <= strtotime(date('Y-m-d')))//au moins une loc commence et finit le mois courant
						{
							// $moisder++;
							$finmois = date('Y-m-d');//Fin mois précédent
							$finmoissec = strtotime ($finmois);								
						}
					}
					
					if(!empty($locataclonedeja22))
					{
						foreach($locataclonedeja22 as $locataclonedeja2)
						{
							echo 'IL EST DEDANS';
							echo 'LocatacloneID '.$locataclonedeja2->getId();
							//CE MOIS-CI
				
							foreach($locataclonedeja2->getLocationsclone() as $loca)
							{echo ' CODE MACHINE '.$loca->getCodemachineinterne();	echo 'FFIIIIIINNLOC'.date("Y-m", strtotime($loca->getFinloc()));echo 'M-1'.date('Y-m', strtotime(" -1 month"));	
								if(date('Ym',strtotime($loca->getFinloc())) == date('Ym'))
								{											
									if(date("Y-m", strtotime($loca->getFinloc())) == date("Y-m")){$dejafacm++;if($loca->getDef() == 1){$nbfacterm++;}}
								}
								else
								{
									if(date("Y-m", strtotime($loca->getFinloc())) == date('Y-m', strtotime(" -1 month"))){$dejafacm1++;if($loca->getDef() == 1){$nbfacterm1++;}}
								}
							}
							
							foreach($locataclonedeja2->getLocationsslclone() as $loca)
							{echo ' CODE MACHINESL '.$loca->getCodemachineinterne();echo 'delocym'.date('Ym',strtotime($loca->getDebutloc())); echo 'ym'.date('Ym');
								if(date('Ym',strtotime($loca->getFinloc())) == date('Ym'))
								{
									echo 'BAAXXX';echo 'YM debutloc'.date("Y-m", strtotime($loca->getDebutloc()));echo 'TM DATE'.date('Y-m', strtotime(" -1 month"));								
									if(date("Y-m", strtotime($loca->getFinloc())) == date("Y-m")){$dejafacm++;if($loca->getDef() == 1){$nbfacterm++;}}
								}
								else
								{echo 'AVANT';
									if(date("Y-m", strtotime($loca->getFinloc())) == date('Y-m', strtotime(" -1 month"))){$dejafacm1++;if($loca->getDef() == 1){$nbfacterm1++;}}	
								}
							}
	echo 'GOOO44';echo $go;	
						}
					}
					else
					{
						echo 'PAS DEDANS';
						//On verifie alors si une loc est terminée
						if($nblocterm > 0)
						{
							echo 'CLONE1';
							$go = 'clonage';
						}	
						else
						{
							if($moisder > 0 && $dejafacm1 == 0)
							{//echo 'MOOODEE'.$mode;
								if($mode == 'moisder')
								{
									//clonage moisder
									echo 'CLONE2';
									$go = 'clonage';
									$finmois = date('Y-m-t', strtotime(" -1 month"));
								}
								elseif($mode == 'forcing')
								{
									//clonage moisder
									echo 'CLONE22';
									$go = 'clonage';
									$finmois = date('Y-m-t');
								}
							}
						}
echo 'GOOO55';echo $go;						
					}
echo 'nbfactm'; echo $nbfactm;						
echo 'nbfactm1'; echo $nbfactm1;				
echo 'nbfacterm'; echo $nbfacterm;				
echo 'nbfacterm1'; echo $nbfacterm1;				
echo 'dejafacm'; echo $dejafacm;				
echo 'dejafacm1'; echo $dejafacm1;				

echo 'moisder'; echo $moisder;
echo 'GOOO66';echo $go;						
					//S'il y a une facture pour ce mois-ci
					// if($dejafacm > 0 || ($dejafacm == 0 && $nbfacterm > 0))
					if($dejafacm > 0)
					{							
						//Si nb fac terminéees < nb loc total
						if($nblocterm <= $nblocm)
						{
							//si la loc qui reste est terminée
							if($nblocterm > 0 && $nblocterm-$dejafacm > 0)
							{
								echo 'CLONE3';
								$go = 'clonage';
								//$finmois = finloc
							}
							elseif($nblocterm > 0 && $nblocterm-$dejafacm == 0 && $nblocm > $dejafacm && $mode == 'forcing')
							{
								echo 'CLONE3';
								$go = 'clonage';
								//$finmois = finloc
							}
							else
							{echo $mode;echo 'GAGOU'.$nblocm;echo $nblocecm;echo $dejafacm; echo $nblocterm;echo '===';echo $nblocm - $nblocecm; echo $dejafacm - $nblocterm;
								//Y a-t-il une facture pour le mois ddernier
								if($dejafacm1 > 0 || ($dejafacm1 == 0 && $nbfacterm1 > 0))
								{echo 'aaa';									
									//Si nb fac terminéees < nb loc total
									if($nbfacterm1 < $nblocm1)
									{
										//si la loc qui reste est en cours
										if($nblocecm1 > $dejafacm1)
										{
											//clonage moisder
											echo 'CLONE4';
											$go = 'clonage';
											$finmois = date('Y-m-t', strtotime(" -1 month"));
										}
									}
									elseif($mode == 'forcing' && $nblocecm > 0 && ($nblocm - $nblocecm) > ($dejafacm - $nblocterm))//1 > 0
									{echo 'CCCCCC';
										echo 'CLONE55';
										$go = 'clonage';
										$finmois = date('Y-m-t');
									}
								}
								elseif($moisder < $dejafacm1)
								{echo 'bbbb';
									//clonage moisder
									echo 'CLONE5';
									$go = 'clonage';
									$finmois = date('Y-m-t', strtotime(" -1 month"));
								}
								else{echo 'no no no';}
								
							}
						}
echo 'GOOO77';echo $go;						
					}
					elseif(($mode == 'forcing' && $dejafacm == 0) or ($mode != 'forcing' && $dejafacm == 0 && $nblocterm == 0))
					{echo $mode;echo 'GAGOUYY'.$nblocm;echo $nblocecm;echo $dejafacm; echo $nblocterm;echo '===';echo $nblocm - $nblocecm; echo $dejafacm - $nblocterm;
						if($moisder > 0 && $dejafacm1 < $moisder)
						{echo 'AAA';
							if($mode == 'moisder' && $dejafacm1 == 0)
							{
								//clonage moisder
								echo 'CLONE6';
								$go = 'clonage';
								$finmois = date('Y-m-t', strtotime(" -1 month"));
							}
							elseif($mode == 'forcing' && $nblocm > 0)
							{echo 'CCCCC';
								echo 'CLONE881';
								$go = 'clonage';
								$finmois = date('Y-m-t');
							}
						}
						elseif($dejafacm < $nblocterm)
						{echo 'bbbb';
							echo 'CLONE7';
							$go = 'clonage';
						}
						elseif($dejafacm1 == 0 && $nblocterm1 > 0)
						{echo 'cccc';
							echo 'CLONE8';
							$go = 'clonage';
						}
						elseif($mode == 'forcing' && $dejafacm == 0 && $nblocecm > 0)
						{echo 'eee';
							//clonage moisder
							echo 'CLONE88';
							$go = 'clonage';
							$finmois = date('Y-m-t');
						}
echo 'GOOO88';echo $go;						
					}
					elseif($dejafacm == 0 && $nblocterm > 0 && $nblocm > 0 && $mode != 'moisder')
					{
						echo 'CLONE9';
						$go = 'clonage';
					}
					elseif($dejafacm1 - $nblocecm1 != 0)
					{
						echo 'CLONE10';
						$go = 'clonage';
					}
				
echo 'dejafacmXX'; echo $dejafacm;						
echo 'nblocterXX'; echo $nblocterm;						
echo 'nblocmXX'; echo $nblocm;						
echo 'GOOO99';echo $go;					
					if($go == 'clonage')
					{
						echo 'On y va';
						//clonage et copie locata
						$oldLocata = $locata;
						$newLocata = new Locataclone;
						$oldReflection = new \ReflectionObject($oldLocata);
						$newReflection = new \ReflectionObject($newLocata);

						foreach ($oldReflection->getProperties() as $property) {
							if ($newReflection->hasProperty($property->getName())) {
								$newProperty = $newReflection->getProperty($property->getName());
								$newProperty->setAccessible(true);
								$newProperty->setValue($newLocata, $property->getValue($oldLocata));
							}
						}
						$newLocata->setOldid($oldLocata->getId());
						$em->persist($newLocata);
						$em->flush();
						
						$id = $newLocata->getId();
						$locid = $locata->getId();
						$em->clear();
						
						$newLocata = $em->getRepository('BaclooCrmBundle:Locataclone')
									->findOneById($id);	
						$locata = $em->getRepository('BaclooCrmBundle:Locata')
									->findOneById($locid);	
// echo 'AAAAAAA';echo $newLocata->getId();echo $newLocata->getMontantloc();							
						if($newLocata->getMontantloc() > 0 or $newLocata->GetTransportaller() > 0 or $newLocata->GetTransportretour() > 0)
						{
								$totalht = 0;
								$transport = 0;	
								$totaltrspaller = 0;
								$totaltrspretour = 0;
								$jour50 = 0;
								$jour100 = 0;
								$montantcarb = 0;
								$premiermois = 0;
								$contributionverte = 0;
								$assurance = 0;							
								$clonageloc = 0;
								//On clone si fin de mois et si location terminée même si une loc n'est pas terminée sur le contrat
								foreach($locata->getLocations() as $loca)
								{
									//On récupère le dernier locationsslclone
									//echo $locata->getId(); echo $loca->getCodemachineinterne();
									// $lastloc = $em->getRepository('BaclooCrmBundle:Locationsclone')
											// ->lastloc($loca->getCodemachineinterne());
											// print_r($lastlocsl);
											
									$em = $this->getDoctrine()
										   ->getManager();		
						
									$query = $em->createQuery(
										'SELECT l
										FROM BaclooCrmBundle:Locationsclone l
										WHERE l.codemachineinterne = :codemachineinterne
										AND l.oldid = :oldid
										ORDER BY l.id DESC'
									)->setMaxResults(1);
									$query->setParameter('codemachineinterne', $loca->getCodemachineinterne());
									$query->setParameter('oldid', $loca->getId());
									
									$lastloc = $query->getOneOrNullResult();	
									
		// echo 'YYYY';echo $lastlocsl->getCodemachineinterne();

									if(isset($lastloc))
									{				
										$finloc = $lastloc->getFinloc();
										$transportallerp = $lastloc->getTransportaller();
										$moisderfac = date("M", strtotime($finloc));
										$moisderfacnum = date("m", strtotime($finloc));
									}
									else
									{
										$moisderfac = 0;
										$moisderfacnum = 0;
									}	
									   
		echo 'transportallerp';$transportallerp;							
									if(($loca->getEtatloc() == 'En location' and strtotime($loca->getDebutloc()) < strtotime(date('Y-m-01')) and $moisderfacnum != date('m', strtotime(" -1 month")) or ($loca->getEtatloc() == 'En location' and strtotime($loca->getDebutloc()) <= strtotime(date('Y-m-t')) and $moisderfacnum != date('m') && $mode == 'forcing') or ($loca->getEtatloc() == 'Location terminée')))
									{
										if($loca->getEtatloc() == 'En location')
										{
											$finmois = date('Y-m-t', strtotime(" -1 month"));//Fin mois précédent
											$finmoissec = strtotime ($finmois);	
										}
										elseif($loca->getEtatloc() == 'Location terminée')
										{echo 'cloture1';
											$finmois = $loca->getFinloc();//Fin mois précédent
											$finmoissec = strtotime ($finmois);
											if(strtotime($loca->getFinloc()) > strtotime(date('Y-m-01')) && $mode == 'moisder')
											{}
											else
											{
												$loca->setCloture(1);
											}
											$em->flush();
										}
											
										if(($loca->getEtatloc() == 'En location' or ($loca->getEtatloc() == 'Location terminée' && $mode == 'moisder')) && strtotime($loca->getFinloc()) > strtotime(date('Y-m-t', strtotime(" -1 month"))))
										{
											if($mode == 'forcing')
											{
												if(strtotime($loca->getFinloc()) > strtotime(date('Y-m-t')))
												{
													$finloc = date('Y-m-t');
												}
												else
												{echo 'cloture2';
													$finloc = $loca->getFinloc();
													$loca->setCloture(1);
													$em->flush();
												}
											}
											else
											{
												$finloc = date('Y-m-t', strtotime(" -1 month"));
											}
										}
										elseif(strtotime($loca->getFinloc()) > strtotime(date('Y-m-01')) && $mode == 'moisder')
										{
											
											$finloc = date('Y-m-t', strtotime(" -1 month"));
											$em->flush();
										}
										else
										{
											$finloc = $loca->getFinloc();
										}
										
										$em = $this->getDoctrine()->getManager();
										// $query = $em->createQuery(
											// 'SELECT m.oldid
											// FROM BaclooCrmBundle:Locationsslclone m
											// WHERE m.codemachineinterne = :codemachineinterne
											// ORDER BY m.id DESC');
										// $query->setMaxResults(1);
										// $query->setParameter('codemachineinterne', $loca->getCodemachineinterne());
										// $oldid = $query->getSingleResult();
		echo 'FINLOC';echo $finloc;	echo $loca->getCodemachineinterne();echo 'oldid'.$loca->getId();echo 'CLOOOOTURE'.$loca->getCloture();				
										$locationsclonedeja = $em->getRepository('BaclooCrmBundle:Locationsclone')
											->findOneBy(array('oldid' => $loca->getId(), 'codemachineinterne' => $loca->getCodemachineinterne(), 'finloc' => $finloc));
										if(empty($locationsclonedeja) or $loca->getCloture() == 0)
										{		
											$finlocsec = strtotime ($loca->getFinloc());	
											$dStart = $loca->getDebutloc();
											$dStartsec = strtotime ($loca->getDebutloc());
											$dEnd = $loca->getFinloc();
		// echo 'xxxxxxxxxxxxxxxxx';echo $finmois; echo $loca->getFinloc();
		// echo $dStart; echo $debutmois;
		
		
		
											//Si date début antérieure au début du mois >> date début = début mois
											if($dStartsec <= $debutmoissec)
											{echo 'DIDAN';
												$dStart = $debutmois;
											}
											elseif($dStartsec < strtotime(date('Y-m-01')) && $dStartsec > $debutmoissec && $moisderfacnum == date('m', strtotime(" -1 month")))//si date début est mois dernier et dernière facturation = mois dernier.
											{echo 'DIDAN2';
												$dStart = date('Y-m-01');
												if(strtotime($dStart) > strtotime($loca->getFinloc()))
												{
													$dStart = $loca->getDebutloc();
												}
											}
											else
											{
												$dStart = $loca->getDebutloc();
											}
											//si la location terminée et la date de fin est comprise entre le début du mois courant et la date du jour
											if($loca->getEtatloc() == 'Location terminée' and $finlocsec <= $todaysec and $finlocsec >= strtotime(date('Y-m-01')))
											{echo 'CAY';
												$dEnd = $loca->getFinloc();
												if(strtotime($loca->getDebutloc()) < strtotime(date('Y-m-01')) && $moisderfacnum > 0)
												{echo 'GUY';
													if(strtotime($dStart) > strtotime($dEnd))
													{
														$dStart = $loca->getDebutloc();
													}
													if($mode == 'moisder')
													{echo 'moisderDstart';
														$dStart = $debutmoisinit;
													}
													else
													{echo 'pas moisderDstart';
														$dStart = date('Y-m-01');
													}													
												}
												else
												{echo 'STLO';
													$dStart = $loca->getDebutloc();
												}
											}
											//si la date de début est inférieur au début de mois prec
											//Si date fin posterieure à fin du mois prec >> date fin = fin mois prec
											if($finlocsec >= $finmoissec)
											{
												if($loca->getEtatloc() == 'Location terminée')
												{echo 'ici';
													$dEnd = $loca->getFinloc();
													$finmois = $loca->getFinloc();
													$finmoissec = strtotime ($finmois);

												}
												else
												{echo 'LAAAA';echo $finmois;echo 'mode'.$mode;
													if($loca->getEtatloc() == 'En location')
													{echo 'ico';
														if($mode == 'forcing' && $finlocsec >= strtotime( date('Y-m-t')))
														{
															$finmois = date('Y-m-t');//Fin mois en cours
														}
														elseif($mode == 'moisder')
														{
															$finmois = date('Y-m-t', strtotime(" -1 month"));//Fin mois en cours
														}
														else
														{echo 'cloture3';
															$finmois = $loca->getFinloc();
															$loca->setCloture(1);
															$em->flush();
														}
													}
													else
													{													
														$finmois = date('Y-m-t', strtotime(" -1 month"));//Fin mois précédent
													}
													$finmoissec = strtotime ($finmois);											
													$dEnd = $finmois;
												}
											}
																				

											//Si date début après début de mois alors $dstart = $dstart on ne fait rien. !! pas sûr !!!
			
																	
				
																							

											//on calcule le nombre de jours de location
											echo 'dtart&'.$dStart;echo 'dend&'.$dEnd;									
											// $begin = new DateTime($dStart);
											$begin = new DateTime($dStart);
											$end = new DateTime($dEnd);
											$end = $end->modify( '+1 day' ); 
		echo '*****';
		echo $begin->format('Y-m-d');
		echo $end->format('Y-m-d');
											$interval = DateInterval::createFromDateString('1 day');
											$period = new DatePeriod($begin, $interval, $end);
											$nbjloc = 0;
											$nbjlocass = 0;

											foreach ($period as $dt) {
												$newformat = $dt->format("D");						
												$nbjlocass++;
												if($locata->getFacturersamedi() == 1 && $newformat == 'Sat')
												{
													$nbjloc++;						
												}
												elseif($locata->getFacturerdimanche() == 1 && $newformat == 'Sun')
												{
													$nbjloc++;
												}
												elseif($newformat == 'Sat' or $newformat == 'Sun')
												{}
												else
												{
													$nbjloc++;
												}							
											}
											if($loca->getLoyermensuel()>0)
											{
												if($nbjloc < 20)
												{
													$loyer = $loca->getLoyermensuel()/20;
												}
												else
												{
													$nbjloc = 20;													
													$loyer = ($loca->getLoyermensuel()/20);
												}
											}
		echo 'laa';		echo 'nbjloc'.$nbjloc;					
											//clonage et copie locations	
											// $locatio  = $em->getRepository('BaclooCrmBundle:Locations')		
											   // ->findOneByCodemachineinterne($ecode);
											// $assurancela =($nbjlocass/$loca->getNbjloc())*$loca->getAssurance(); 

											$clonageloc++;
											$locations = new Locationsclone;
											$locations->setCodeclient($loca->getCodeclient());
											$locations->setEntid($loca->getCodeclient());
											$locations->setEntreprise($loca->getEntreprise());
											$locations->setMachineid($loca->getMachineid());
											$locations->setCodemachine($loca->getCodemachine());
											$locations->setCodemachine($loca->getCodemachine());
											$locations->setCodemachineinterne($loca->getCodemachineinterne());
											$locations->setTypemachine($loca->getTypemachine());
											$locations->setTypemachineinit($loca->getTypemachineinit());
											$locations->setEtatloc($loca->getEtatloc());
											$locations->setLoyerp1($loca->getLoyerp1());
											$locations->setLoyerp2($loca->getLoyerp2());
											$locations->setLoyerp3($loca->getLoyerp3());
											$locations->setLoyerp4($loca->getLoyerp4());
											$locations->setLoyermensuel($loca->getLoyermensuel());
											$locations->setNbjloc($nbjloc);
											$locations->setNbjlocass($nbjlocass);
											
											if($loca->getLoyermensuel() > 0)
											{}
											else
											{
												if(empty($loca->getNbjloc()) or $loca->getNbjloc() == 0){$locnbjloc = 1;}else{$locnbjloc = $loca->getNbjloc();}
												$loyer = ($loca->getMontantloc()/$locnbjloc);
												// $totalht += $loyer*$nbjloc;
											}
											$locations->setMontantloc(($nbjloc * $loyer) - $jour50 - $jour100);
											
											$locations->setLitrescarb($loca->getLitrescarb());
											$locations->setMontantcarb($loca->getMontantcarb());
											$locations->setEnergie($loca->getEnergie());
											$locations->setDatereprise($loca->getDatereprise());
							

							
											if($loca->getEtatloc() == 'En location' && strtotime($loca->getDebutloc()) < $debutmoissecinit && $moisderfac != date("M", strtotime($dStart)))
											{echo 'GLOC';echo $moisderfac;echo $moisprec;
												$locations->setDebutloc($debutmoisinit);
											}
											elseif($loca->getEtatloc() == 'Location terminée' && strtotime($loca->getDebutloc()) < $debutmoissecinit && strtotime($loca->getFinloc()) >= strtotime(date('Y-m-01')))
											{echo 'START';echo $moisderfac;echo $moisprec;
												if($mode == 'moisder')
												{echo 'moisder2';
													$locations->setDebutloc($debutmoisinit);
												}
												else
												{echo 'pas moisder2';
													$locations->setDebutloc(date('Y-m-01'));
												}
											}
											elseif($loca->getEtatloc() == 'Location terminée' && strtotime($loca->getDebutloc()) >= $debutmoissecinit && strtotime($loca->getFinloc()) < strtotime(date('Y-m-01')))
											{echo 'START1';echo $moisderfac;echo $moisprec;
												$locations->setDebutloc($dStart);
											}
											elseif($loca->getEtatloc() == 'Location terminée' && strtotime($loca->getDebutloc()) >= $debutmoissecinit && strtotime($loca->getFinloc()) >= strtotime(date('Y-m-01')) && $moisderfac === $moisprec)
											{echo 'START22';echo $moisderfac;echo $moisprec;
												$locations->setDebutloc(date('Y-m-01'));
											}
											else
											{echo 'DEBUTLOC';echo $moisderfac;echo $moisprec;
												$locations->setDebutloc($loca->getDebutloc());
											}
											
											if(($loca->getEtatloc() == 'En location' or ($loca->getEtatloc() == 'Location terminée' && $mode == 'moisder')) && strtotime($loca->getFinloc()) > strtotime(date('Y-m-t', strtotime(" -1 month"))))
											{	
												if($mode == 'forcing')
												{
													if(strtotime($loca->getFinloc()) > strtotime(date('Y-m-t')))
													{
														$locations->setFinloc(date('Y-m-t'));
														$finlocsel = date('Y-m-t');
													}
													else
													{
														$locations->setFinloc($loca->getFinloc());
														$finlocsel = $loca->getFinloc();
													}
												}
												elseif($mode == 'moisder')
												{echo '&&&&&&&&&';
													$locations->setFinloc(date('Y-m-t', strtotime(" -1 month")));
													$finlocsel = date('Y-m-t', strtotime(" -1 month"));
												}
												else
												{
													$locations->setFinloc($loca->getFinloc());
													$finlocsel = $loca->getFinloc();
												}
											}
											else
											{
												$locations->setFinloc($loca->getFinloc());
												$finlocsel = $loca->getFinloc();
											}								
											if($loca->getDebutloc() >= $debutmois && $loca->getDebutloc() <= $finmois && !isset($transportallersl))
											{
												$locations->setTransportaller($loca->getTransportaller());
												$totaltrspaller += $loca->getTransportaller();
											}								
											if(strtotime($loca->getDebutloc()) >= strtotime($debutmois) && strtotime($loca->getDebutloc()) <= strtotime($finmois))
											{
												$premiermois++;
											}
echo 'debutmois'.$debutmois;echo 'finmois'.$finmoisinit;
											if($mode == 'moisder'){$finmois = $finmoisinit;}
											if(strtotime($loca->getFinloc()) >= strtotime($debutmois) && strtotime($loca->getFinloc()) <= strtotime($finmois))
											{
												$locations->setTransportretour($loca->getTransportretour());
												$totaltrspretour += $loca->getTransportretour();
											}

											$locations->setContributionverte($loca->getContributionverte());
											if($loca->getContributionverte() == 1)	
											{
												$contributionverte += $loyer*$nbjloc*0.0215;

											}
											else
											{
												$contributionverte += 0;
											}
											


											$locations->setAssurance($loca->getAssurance());
											if($loca->getAssurance() == 1)
											{
												$assurance += $loyer*$nbjlocass*0.10;
											}
											else
											{
												$assurance = 0;
											}
											if($loca->getCloture() == 1){$cloture = 1;}else{$cloture = 0;}
		   
											$locations->setJour50($loca->getJour50());
											$locations->setJour100($loca->getJour100());
											$locations->setOldid($loca->getId());
											$locations->setCloture($cloture);
											$locations->addLocataclone($newLocata);
											$newLocata->addLocationsclone($locations);
											$em->persist($locations);	
											$em->persist($newLocata);
											$em->flush();

													//Création du montant HT ligne par ligne
													

													if(null !== $loca->getLoyerp1())
													{//echo '1111';
														if($loca->getJour50()>0)
														{
															$jour50 += ($loca->getLoyerp1() * $loca->getjour50())*0.5;
														}
														if($loca->getJour100()>0)
														{
															$jour100 += ($loca->getLoyerp1() * $loca->getjour100());
														}
														$totalht += ($nbjloc * $loca->getLoyerp1()) - $jour50 - $jour100;
													}
													elseif(null !== $loca->getLoyerp2())
													{//echo '2222';
														if($loca->getJour50()>0)
														{
															$jour50 += ($loca->getLoyerp2() * $loca->getjour50())*0.5;
														}
														if($loca->getJour100()>0)
														{
															$jour100 += ($loca->getLoyerp2() * $loca->getjour100());
														}
														$totalht += ($nbjloc * $loca->getLoyerp2()) - $jour50 - $jour100;
									// echo '>>>'.$nbjloc.'**'.$loca->getLoyerp2().'=='.$nbjloc*$loca->getLoyerp2();
													}
													elseif(null !== $loca->getLoyerp3())
													{//echo '3333';
			  
														if($loca->getJour50()>0)
														{
															$jour50 += ($loca->getLoyerp3() * $loca->getjour50())*0.5;
														}
														if($loca->getJour100()>0)
														{
															$jour100 += ($loca->getLoyerp3() * $loca->getjour100());
														}
														$totalht += ($nbjloc * $loca->getLoyerp3()) - $jour50 - $jour100;
													}
													elseif(null !== $loca->getLoyerp4())
													{
														if($loca->getJour50()>0)
														{
															$jour50 += ($loca->getLoyerp4() * $loca->getjour50())*0.5;
														}
														if($loca->getJour100()>0)
														{
															$jour100 += ($loca->getLoyerp4() * $loca->getjour100());
														}
														$totalht += ($nbjloc * $loca->getLoyerp4()) - $jour50 - $jour100;
													}
													elseif(null !== $loca->getLoyermensuel())
													{
														if($nbjloc < 20)
														{
															$loyer = $loca->getLoyermensuel()/20;
														}
														else
														{
															$nbjloc = 20;													
															$loyer = ($loca->getLoyermensuel()/20);
														}													
														if($loca->getJour50()>0)
														{
															$jour50 += ($loyer * $loca->getjour50())*0.5;
														}
														if($loca->getJour100()>0)
														{
															$jour100 += ($loyer * $loca->getjour100());
														}
														$totalht += ($nbjloc * $loyer) - $jour50 - $jour100;
													}

													if(null !== $loca->getMontantcarb())
													{
														$montantcarb += $loca->getMontantcarb();
													}						
													if(null !== $loca->getTransportaller() && $loca->getTransportaller()>0 && $loca->getDebutloc() >= $debutmois && $loca->getDebutloc() <= $finmois)
													{
														$transport += $loca->getTransportaller();
													}
													
													if(null !== $loca->getTransportretour() && $loca->getTransportretour()>0 && $loca->getFinloc() >= $debutmois && $loca->getFinloc() <= $finmois)
													{
														$transport += $loca->getTransportretour();
													}
										}
										else
										{
											echo 'locationsclonedeja pas vide';echo $locationsclonedeja->getId();
										}
									}
			 
									   
									if($mode == 'forcing')
									{
										if(strtotime($loca->getFinloc()) > strtotime(date('Y-m-t')))
										{
											$finlocsel = date('Y-m-t');
										}
										else
										{
											$finlocsel = $loca->getFinloc();
										}
									}
									else
									{
										$finlocsel = date('Y-m-t', strtotime(" -1 month"));
									}																	  
								}
		
								//Partie sous location
								foreach($locata->getLocationssl() as $loca)
								{echo 'CLONAGE LOCATION';echo $loca->getCodemachineinterne();
									//On récupère le dernier locationsslclone
									//echo $locata->getId(); echo $loca->getCodemachineinterne();
									// $lastloc = $em->getRepository('BaclooCrmBundle:Locataclone')
											// ->lastloc($locata->getId(), $loca->getCodemachineinterne());
								  
		   
									$em = $this->getDoctrine()
										   ->getManager();		
						
									$query = $em->createQuery(
										'SELECT l
										FROM BaclooCrmBundle:Locationsslclone l
										WHERE l.codemachineinterne = :codemachineinterne
										AND l.oldid = :oldid
										ORDER BY l.id DESC'
									)->setMaxResults(1);
									$query->setParameter('codemachineinterne', $loca->getCodemachineinterne());
									$query->setParameter('oldid', $loca->getId());
									
									$lastlocsl = $query->getOneOrNullResult();	
									
		// echo 'YYYY';echo $lastlocsl->getCodemachineinterne();

									if(isset($lastlocsl))
									{				
										$finloc = $lastlocsl->getFinloc();
										$transportallerp = $lastlocsl->getTransportaller();
										$moisderfac = date("M", strtotime($finloc));
										$moisderfacnum = date("m", strtotime($finloc));
									}
									else
									{
										$moisderfac = 0;
										$moisderfacnum = 0;
									}
echo 'moisderfacnum'.$moisderfacnum;			
		// echo 'transportallerp'.$transportallerp;								
									if(($loca->getEtatloc() == 'En location' and strtotime($loca->getDebutloc()) < strtotime(date('Y-m-01')) and $moisderfacnum != date('m', strtotime(" -1 month")) or ($loca->getEtatloc() == 'En location' and strtotime($loca->getDebutloc()) <= strtotime(date('Y-m-t')) and $moisderfacnum != date('m') && $mode == 'forcing') or ($loca->getEtatloc() == 'Location terminée' && $loca->getEtatloc() != 1)))
									{
echo 'CLONAGE LOCATION222';echo $loca->getCodemachineinterne();
										if($loca->getEtatloc() == 'En location')
										{
											$finmois = date('Y-m-t', strtotime(" -1 month"));//Fin mois précédent
											$finmoissec = strtotime ($finmois);	
										}
										elseif($loca->getEtatloc() == 'Location terminée')
										{echo 'cloture4';
											$finmois = $loca->getFinloc();//Fin mois précédent
											$finmoissec = strtotime ($finmois);
											if(strtotime($loca->getFinloc()) > strtotime(date('Y-m-01')) && $mode == 'moisder')
											{}
											else
											{
												$loca->setCloture(1);
											}
											$em->flush();
										}
											
										if(($loca->getEtatloc() == 'En location' or ($loca->getEtatloc() == 'Location terminée' && $mode == 'moisder')) && strtotime($loca->getFinloc())  > strtotime(date('Y-m-t', strtotime(" -1 month"))))
										{
											if($mode == 'forcing')
											{
												if(strtotime($loca->getFinloc()) > strtotime(date('Y-m-t')))
												{
													$finloc = date('Y-m-t');
												}
												else
												{echo 'cloture5';
													$finloc = $loca->getFinloc();
													$loca->setCloture(1);
													$em->flush();
												}
											}
											else
											{
												$finloc = date('Y-m-t', strtotime(" -1 month"));
											}
										}
										else
										{
											$finloc = $loca->getFinloc();
										}
										
										$em = $this->getDoctrine()->getManager();
										// $query = $em->createQuery(
											// 'SELECT m.oldid
											// FROM BaclooCrmBundle:Locationsslclone m
											// WHERE m.codemachineinterne = :codemachineinterne
											// ORDER BY m.id DESC');
										// $query->setMaxResults(1);
										// $query->setParameter('codemachineinterne', $loca->getCodemachineinterne());
										// $oldid = $query->getSingleResult();
		echo 'FINLOCsl';echo $finloc;	echo $loca->getCodemachineinterne();					
										$locationsclonedeja = $em->getRepository('BaclooCrmBundle:Locationsslclone')
											->findOneBy(array('oldid' => $loca->getId(), 'codemachineinterne' => $loca->getCodemachineinterne(), 'finloc' => $finloc));						

										if(empty($locationsclonedeja) or $loca->getCloture() == 0)
										{
echo 'CLONAGE LOCATION333';echo $loca->getCodemachineinterne();							
											$finlocsec = strtotime ($loca->getFinloc());	
											$dStart = $loca->getDebutloc();
											$dStartsec = strtotime ($loca->getDebutloc());
											$dEnd = $loca->getFinloc();
		// echo 'xxxxxxxxxxxxxxxxx';echo $finmois; echo $loca->getFinloc();
								   
  
  
  
											//Si date début antérieure au début du mois >> date début = début mois
											if($dStartsec <= $debutmoissec)
											{echo 'DIDAN';
												$dStart = $debutmois;
											}
											elseif($dStartsec < strtotime(date('Y-m-01')) && $dStartsec > $debutmoissec && $moisderfacnum == date('m', strtotime(" -1 month")))//si date début est mois dernier et dernière facturation = mois dernier.
											{echo 'DIDAN2';
												$dStart = date('Y-m-01');
												if(strtotime($dStart) > strtotime($loca->getFinloc()))
												{
													$dStart = $loca->getDebutloc();
												}
											}
											else
											{
												$dStart = $loca->getDebutloc();
											}
											//Si date fin posterieure à fin du mois >> date fin = fin mois
											if($loca->getEtatloc() == 'Location terminée' and $finlocsec <= $todaysec and $finlocsec >= strtotime(date('Y-m-01')))
											{echo 'CAY2';
												$dEnd = $loca->getFinloc();
												if(strtotime($loca->getDebutloc()) < strtotime(date('Y-m-01')) && $moisderfacnum > 0)
												{echo 'GUY2';
													if(strtotime($dStart) > strtotime($dEnd))
													{
														$dStart = $loca->getDebutloc();
													}
													if($mode == 'moisder')
													{echo 'moisderDstart';
														$dStart = $debutmoisinit;
													}
													else
													{echo 'pas moisderDstart';
														$dStart = date('Y-m-01');
													}	
												}
												else
												{echo 'STLO';
													$dStart = $loca->getDebutloc();
												}
											}
											//si la date de début est supérieur à la fin du mois de facturation m-1 
																					
											if($finlocsec >= $finmoissec)
											{
												if($loca->getEtatloc() == 'Location terminée')
												{echo 'cloture6';
													$dEnd = $loca->getFinloc();
													$finmois = $loca->getFinloc();
													$finmoissec = strtotime ($finmois);
													if(strtotime($loca->getFinloc()) > strtotime(date('Y-m-01')) && $mode == 'moisder')
													{}
													else
													{
														$loca->setCloture(1);
													}
													$em->flush();

												}
												else
												{
													if($loca->getEtatloc() == 'En location')
													{
														if($mode == 'forcing')
														{
															$finmois = date('Y-m-t');//Fin mois précédent
															$finmoissec = strtotime ($finmois);
														}
														else
														{
															$finmois = date('Y-m-t', strtotime(" -1 month"));//Fin mois précédent
															$finmoissec = strtotime ($finmois);
														}
													}		
													$dEnd = $finmois;
												}
											}
echo ' MOOOODE'.$mode; echo 'finloc'.$finloc;  echo ' debutmois'.$debutmoisinit; echo ' debutloc'.$loca->getDebutloc(); echo ' finmois'.$finmoissec;
											//En mode focing on détermine l'intervalle pour le caclul de nbjloc
											if($finlocsec >= $debutmoissec && strtotime($loca->getDebutloc()) <= $finmoissec && $loca->getEtatloc() == 'En location' && $mode == 'forcing')
											{echo 'DTART FORCING';
												//Détermination dStart
												if(strtotime($loca->getDebutloc())< strtotime(date('Y-m-01')))
												{echo 'debut111';
													$dStart = date('Y-m-01');
												}
												elseif(strtotime($loca->getDebutloc()) >= strtotime(date('Y-m-01')) && strtotime($loca->getDebutloc()) <= strtotime(date('Y-m-t')))
												{echo 'debut222';
													$dStart = $loca->getDebutloc();
												}
												//Détermination dEnd
												if(strtotime($loca->getFinloc()) > strtotime(date('Y-m-t')))
												{echo 'debut333';
													$dEnd = date('Y-m-t');
													$finmois = date('Y-m-t');
													$finmoissec = strtotime ($finmois);
												}
												elseif(strtotime($loca->getFinloc()) >= strtotime(date('Y-m-01')) && strtotime($loca->getFinloc()) <= strtotime(date('Y-m-t')))
												{
													$dEnd = $loca->getFinloc();
													$finmois = $loca->getFinloc();
													$finmoissec = strtotime ($finmois);
												}
											}												
											//Si date fin posterieure à fin du mois >> date début = début mois

												//Si date début après début de mois alors $dstart = $dstart on ne fait rien.
												
												//1.Récupérer les données de la table Locata cf supra
													   
												//2.On génère les entêtes de colonnes à partir de la fonction createplanning

												//on calcule le nombre de jours de location
												// echo $loca->getEntreprise();//echo $dStart;echo $dEnd;									
												$begin = new DateTime($dStart);
										  
												$end = new DateTime($dEnd);
												$end = $end->modify( '+1 day' ); 
												$interval = DateInterval::createFromDateString('1 day');
												$period = new DatePeriod($begin, $interval, $end);
												$nbjloc = 0;
												$nbjlocass = 0;   

												foreach ($period as $dt) {
													$newformat = $dt->format("D");
													$nbjlocass++;
													if($locata->getFacturersamedi() == 1 && $newformat == 'Sat')
													{
														$nbjloc++;
													}
													elseif($locata->getFacturerdimanche() == 1 && $newformat == 'Sun')
													{
														$nbjloc++;
													}
													elseif($newformat == 'Sat' or $newformat == 'Sun')
													{}
													else
													{
														$nbjloc++;
													}							
												}																
											
												if($loca->getLoyermensuel()>0)
												{
													if($nbjloc < 20)
													{
														$loyer = $loca->getLoyermensuel()/20;
													}
													else
													{
														$nbjloc = 20;													
														$loyer = ($loca->getLoyermensuel()/20);
													}
												}										
										
											// $locationsclonedeja = $em->getRepository('BaclooCrmBundle:Locationsslclone')
											// ->findOneBy(array('oldid' => $loca->getId(), 'etatloc' => 'Location terminée', 'codemachineinterne' => $loca->getCodemachineinterne(), 'finloc' => $loca->getFinloc()));						
										


											$locations = new Locationsslclone;
											$locations->setCodeclient($loca->getCodeclient());
											$locations->setEntid($loca->getCodeclient());
											$locations->setEntreprise($loca->getEntreprise());
											$locations->setMachineid($loca->getMachineid());
											$locations->setCodemachine($loca->getCodemachine());
											$locations->setCodemachine($loca->getCodemachine());
											$locations->setCodemachineinterne($loca->getCodemachineinterne());
											$locations->setTypemachine($loca->getTypemachine());
											$locations->setTypemachineinit($loca->getTypemachineinit());
											$locations->setEtatloc($loca->getEtatloc());
											$locations->setLoyerp1($loca->getLoyerp1());
											$locations->setLoyerp2($loca->getLoyerp2());
											$locations->setLoyerp3($loca->getLoyerp3());
											$locations->setLoyerp4($loca->getLoyerp4());
											$locations->setLoyermensuel($loca->getLoyermensuel());
											$locations->setNbjloc($nbjloc);
											$locations->setNbjlocass($nbjlocass);
											
											if(empty($loca->getNbjloc()) or $loca->getNbjloc() == 0){$locnbjloc = 1;}else{$locnbjloc = $loca->getNbjloc();}
											$loyer = ($loca->getMontantloc()/$locnbjloc);
											// $totalht += $loyer*$nbjloc;
											$locations->setMontantloc(($nbjloc * $loyer) - $jour50 - $jour100);
											
											$locations->setLitrescarb($loca->getLitrescarb());
											$locations->setMontantcarb($loca->getMontantcarb());
											$locations->setEnergie($loca->getEnergie());
											$locations->setDatereprise($loca->getDatereprise());
echo ' DEBLOC '; echo $loca->getDebutloc();
echo ' Debutmois ';echo $debutmoisinit;
echo ' FINLOCA '; echo $loca->getFinloc();
echo ' YM01 ';echo date('Y-m-01');											

	   
											if($loca->getEtatloc() == 'En location' && strtotime($loca->getDebutloc()) < $debutmoissecinit && $moisderfac != date("M", strtotime($dStart)))
											{echo 'GLOC';echo $moisderfac;echo $moisprec;
												$locations->setDebutloc($debutmoisinit);
											}
											elseif($loca->getEtatloc() == 'Location terminée' && strtotime($loca->getDebutloc()) < $debutmoissecinit && strtotime($loca->getFinloc()) >= strtotime(date('Y-m-01')))
											{echo 'START01';echo $moisderfac;echo $moisprec;
												if($mode == 'moisder')
												{echo 'moisder';
													$locations->setDebutloc($debutmoisinit);
												}
												else
												{echo 'pas moisder';
													$locations->setDebutloc(date('Y-m-01'));
												}
											}
											elseif($loca->getEtatloc() == 'Location terminée' && strtotime($loca->getDebutloc()) < $debutmoissecinit && strtotime($loca->getFinloc()) < strtotime(date('Y-m-01')))
											{echo 'STARTac';echo $moisderfac;echo $moisprec;
												$locations->setDebutloc($debutmoisinit);
											}
											elseif($loca->getEtatloc() == 'Location terminée' && strtotime($loca->getDebutloc()) >= $debutmoissecinit && strtotime($loca->getFinloc()) < strtotime(date('Y-m-01')))
											{echo 'START4';echo $moisderfac;echo $moisprec;
												$locations->setDebutloc($dStart);
											}
											elseif($loca->getEtatloc() == 'Location terminée' && strtotime($loca->getDebutloc()) >= $debutmoissecinit && strtotime($loca->getFinloc()) >= strtotime(date('Y-m-01')) && $moisderfac === $moisprec)
											{echo 'START23';echo $moisderfac;echo $moisprec;
												$locations->setDebutloc(date('Y-m-01'));
											}
											else
											{echo 'DEBUTLOC';echo $moisderfac;echo $moisprec;
												$locations->setDebutloc($loca->getDebutloc());
											}
echo 'mooooooodddddde'.$mode;											
											if(($loca->getEtatloc() == 'En location' or ($loca->getEtatloc() == 'Location terminée' && $mode == 'moisder')) && strtotime($loca->getFinloc())  > strtotime(date('Y-m-t', strtotime(" -1 month"))))
											{
												if($mode == 'forcing')
												{
													if(strtotime($loca->getFinloc()) > strtotime(date('Y-m-t')))
													{
														$locations->setFinloc(date('Y-m-t'));
														$finlocsel = date('Y-m-t');
													}
													else
													{
														$locations->setFinloc($loca->getFinloc());
														$finlocsel = $loca->getFinloc();
													}
												}
												else
												{
													if($mode != 'forcing' && $mode != 'moisder')
													{echo 'éééééééééé';
														$locations->setFinloc($loca->getFinloc());
														$finlocsel = $loca->getFinloc();
													}
													else
													{echo 'yyyyyyyyy';
														$locations->setFinloc(date('Y-m-t', strtotime(" -1 month")));
														$finlocsel = date('Y-m-t', strtotime(" -1 month"));
													}
												}
											}
											else
											{
												$locations->setFinloc($loca->getFinloc());
												$finlocsel = $loca->getFinloc();
											}
											
											if($loca->getDebutloc() >= $debutmois && $loca->getDebutloc() <= $finmois && !isset($transportallersl))
											{
												$locations->setTransportaller($loca->getTransportaller());
												$totaltrspaller += $loca->getTransportaller();
											}								
											if(strtotime($loca->getDebutloc()) >= strtotime($debutmois) && strtotime($loca->getDebutloc()) <= strtotime($finmois))
											{
												$premiermois++;
											}
											if($mode == 'moisder'){$finmois = $finmoisinit;}											
											if(strtotime($loca->getFinloc()) >= strtotime($debutmois) && strtotime($loca->getFinloc()) <= strtotime($finmois))
											{
												$locations->setTransportretour($loca->getTransportretour());
												$totaltrspretour += $loca->getTransportretour();
											}
											
											$locations->setContributionverte($loca->getContributionverte());
											if($loca->getContributionverte() == 1)
											{
												$contributionverte += $loyer*$nbjloc*0.0215;
											}
											else
											{
												$contributionverte += 0;
											}
											


											$locations->setAssurance($loca->getAssurance());
											if($loca->getAssurance() == 1)
											{
												$assurance += $loyer*$nbjlocass*0.10;
											}
											else
											{
												$assurance = 0;
											}
											if($loca->getCloture() == 1){$cloture = 1;}else{$cloture = 0;}
											
											$locations->setJour50($loca->getJour50());
											$locations->setJour100($loca->getJour100());
											$locations->setOldid($loca->getId());
											$locations->setCloture($cloture);
											$locations->addLocataclone($newLocata);
											$newLocata->addLocationsslclone($locations);
											$em->persist($locations);	
											$em->persist($newLocata);
											$em->flush();

													//Création du montant HT ligne par ligne
													// $totalht = 0;//echo $locid;

													if(null !== $loca->getLoyerp1())
													{
														if($loca->getJour50()>0)
														{
															$jour50 += ($loca->getLoyerp1() * $loca->getjour50())*0.5;
														}
														if($loca->getJour100()>0)
														{
															$jour100 += ($loca->getLoyerp1() * $loca->getjour100());
														}
														$totalht += ($nbjloc * $loca->getLoyerp1()) - $jour50 - $jour100;
													}
													elseif(null !== $loca->getLoyerp2())
													{
														if($loca->getJour50()>0)
														{
															$jour50 += ($loca->getLoyerp2() * $loca->getjour50())*0.5;
														}
														if($loca->getJour100()>0)
														{
															$jour100 += ($loca->getLoyerp2() * $loca->getjour100());
														}
														$totalht += ($nbjloc * $loca->getLoyerp2()) - $jour50 - $jour100;
																						 
													}
													elseif(null !== $loca->getLoyerp3())

													{
														if($loca->getJour50()>0)
														{
															$jour50 += ($loca->getLoyerp3() * $loca->getjour50())*0.5;
														}
														if($loca->getJour100()>0)
														{
															$jour100 += ($loca->getLoyerp3() * $loca->getjour100());
														}
														$totalht += ($nbjloc * $loca->getLoyerp3()) - $jour50 - $jour100;
													}
													elseif(null !== $loca->getLoyerp4())
													{
														if($loca->getJour50()>0)
														{
															$jour50 += ($loca->getLoyerp4() * $loca->getjour50())*0.5;
														}
														if($loca->getJour100()>0)
														{
															$jour100 += ($loca->getLoyerp4() * $loca->getjour100());
														}
														$totalht += ($nbjloc * $loca->getLoyerp4()) - $jour50 - $jour100;
													}
													elseif(null !== $loca->getLoyermensuel())
													{
														if($nbjloc < 20)
														{
															$loyer = $loca->getLoyermensuel()/20;
														}
														else
														{
															$nbjloc = 20;													
															$loyer = ($loca->getLoyermensuel()/20);
														}													
														if($loca->getJour50()>0)
														{
															$jour50 += ($loyer * $loca->getjour50())*0.5;
														}
														if($loca->getJour100()>0)
														{
															$jour100 += ($loyer * $loca->getjour100());
														}
														$totalht += ($nbjloc * $loyer) - $jour50 - $jour100;
													}
			 
													if(null !== $loca->getMontantcarb())
													{
														$montantcarb += $loca->getMontantcarb();
													}						
													if(null !== $loca->getTransportaller() && $loca->getTransportaller()>0 && $loca->getDebutloc() >= $debutmois && $loca->getDebutloc() <= $finmois)
													{
														$transport += $loca->getTransportaller();
													}
													
													if(null !== $loca->getTransportretour() && $loca->getTransportretour()>0 && $loca->getFinloc() >= $debutmois && $loca->getFinloc() <= $finmois)
													{
														$transport += $loca->getTransportretour();
													}
											$aremove = 0;
										}
										else
										{
											echo 'pas empty locataclonedeja';echo 'GOREMOVE111111';echo $newLocata->getId();
											if($clonageloc == 0){$em->remove($newLocata);}
											$em->flush();
											$aremove = 1;											
										}
			  
		   
											  
		   
									}
									else
									{}//echo 'pas enregistré sl';
									// echo 'xxx'.$nbjloc.'-'.$nbjloc*$loyer.'-'.$totalht.'xxx';
									if($mode == 'forcing')
									{
										if(strtotime($loca->getFinloc()) > strtotime(date('Y-m-t')))
										{
											$finlocsel = date('Y-m-t');
										}
										else
										{
											$finlocsel = $loca->getFinloc();
										}
									}
									else
									{
										$finlocsel = date('Y-m-t', strtotime(" -1 month"));
									}										
								}
								//Si on est sur la première facture on clone les locataventes pour les facturer
								//Car les vente ne doivent êrte facturées qu'ne fois
								$montantlocaventes = 0; //Pour la vente
								$montantlocaventestot = 0 + $montantcarb;//Pour toutes les ventes
								if($premiermois > 0)
								{//echo 'premier mois locavente';
									foreach($locata->getLocataventes() as $ven)
									{
										//ici on clone les locataventes si on est le premier mois
										$locataventes = new Locataventesclone;
										$locataventes->setDate($ven->getDate());
										$locataventes->setRefarticle($ven->getRefarticle());
										$locataventes->setDescription($ven->getDescription());
										$locataventes->setQuantite($ven->getQuantite());
										$locataventes->setPu($ven->getPu());
										$locataventes->setMontantvente($ven->getMontantvente());
										$locataventes->setUser($ven->getUser());
										$locataventes->setCodifvente($ven->getCodifvente());
										$locataventes->addLocataclone($newLocata);
										$newLocata->addLocataventesclone($locataventes);
										$em->persist($locataventes);	
										$em->persist($newLocata);
										$em->flush();
										
										//Faut établir un montant global des ventes pour la facturation
										$montantlocaventestot += $ven->getMontantvente();//Pour toutes les ventes
										
									}
								}else{}//echo 'pas premier mois locavente';
			
								//Nous actualisons le locataclone avec les nouvelles données
								$newLocata->setMontantloc($totalht);//echo 'totalhtcomplet'.$totalht;
								$newLocata->setMontantlocavente($montantlocaventestot);//echo 'ventes'.$montantlocaventestot;
								$newLocata->setTransportaller($totaltrspaller);//echo 'transportaller'.$totaltrspaller;
								$newLocata->setTransportretour($totaltrspretour);//echo 'transportaller'.$totaltrspretour;
								$newLocata->setContributionverte($contributionverte);//echo 'contributionverte'.$contributionverte;
								$newLocata->setAssurance($assurance);//echo 'assurance'.$assurance;
								$em->persist($newLocata);
								$em->flush();
								
								if($newLocata->getRemise() > 0)
								{
									$totalht = $totalht - ($totalht * $newLocata->getRemise()/100);
								}
								//On vérifie si le transport aller a déjà été facturé
								$locatador = $em->getRepository('BaclooCrmBundle:Afacturer')
											->findOneBy(array('piece' => $locata->getId(), 'libelle' => 'Transport aller'));							
								
								if($newLocata->getAssurance() > 0)
								{ 
									$rc = $newLocata->getAssurance(); 
								}
								else
								{
									$rc = 0; 
								}
								
								if($newLocata->getContributionverte() > 0)
								{
									$ecopart = $newLocata->getContributionverte();
								}
								else
								{
									$ecopart = 0;						
								}

								$compteclient = '411'.$newLocata->getClientid();
								// echo 'montantcarb!!!';echo $montantcarb;
								if($newLocata->getRemise() > 0){$montantremise = $newLocata->getMontantloc() * $newLocata->getRemise()/100;}else{$montantremise = 0;}																																			 
								$totalhtfac = $newLocata->getMontantloc() + $newLocata->getTransportaller() + $newLocata->getTransportretour() + $newLocata->getContributionverte() + $newLocata->getAssurance() + $newLocata->getMontantlocavente() + $newLocata->getMontantcarb() - $montantremise;
								$client = $em->getRepository('BaclooCrmBundle:Fiche')		
								 ->findOneById($newLocata->getClientid());
								if($client->getTypeclient() != 'export')
								{
									$tva20 = $totalhtfac * 0.20;
								}
								else
								{
									$tva20 = 0;
								}

								$totalttc = $totalhtfac + $tva20;//echo 'totalhtfac'.$totalhtfac;
								// echo $compteclient;echo '----'.$totalttc;echo '------'.$locata->getId().'****';
								$journalori = $em->getRepository('BaclooCrmBundle:Afacturer')
												->findOneBy(array('compte'=>$compteclient, 'debit'=>$totalttc, 'piece'=>$locata->getId()));
								if(isset($journalori))
								{
									$message = 1;
									$date = $journalori->getDate();
								}
								else
								{
									$message = 0;
									//Fin ajout table factures
								}	
										//Ajout à la table factures
										echo 'gofacture';
											$facta = $em->getRepository('BaclooCrmBundle:Facta')
														->findOneByControle('1234');											
											$facture = new Factures;
											
											$query = $em->createQuery(
												'SELECT b.compteurfac
												FROM BaclooCrmBundle:Factures b
												WHERE b.typedoc != :typedoc
												ORDER BY b.id DESC'
											)->setMaxResults(1);
											$query->setParameter('typedoc', 'bon de commande');
											// $lastnumfact = $query->getResult();
											// if(empty($lastnumfact)){$lastnum = 0;}
											// else{foreach($lastnumfact as $last){$lastnum = $last['id'];}}
											$lastnumfact = $query->getOneOrNullResult();
											if(empty($lastnumfact) or !isset($lastnumfact) or $lastnumfact == null)
											{
												$lastnumfact = 0;//echo 'vide';
											}
											else
											{
												$lastnumfact = $query->getSingleScalarResult();//echo 'pas vide';
											}
											$numfacture = date('Y').($lastnumfact++);
											
											$client = $em->getRepository('BaclooCrmBundle:Fiche')		
											 ->findOneById($locata->getClientid());
											if($client->getDelaireglement() == 1)
											{
												$next45 = $today;
											}
											elseif($client->getDelaireglement() == 2)
											{
												$next45a = date('Y-m-d', strtotime('+45 days'));
												$next45 = date('Y-m-t', strtotime($next45a));
											}
											elseif($client->getDelaireglement() == 3)
											{
												$next45a = date('Y-m-d', strtotime('+45 days'));
												$next45 = date('Y-m-t', strtotime($next45a));
											}
											else
											{
												$next45 = $today;
											}						
											
											$facture->setNumfacture($numfacture);
											$facture->setCodelocata($locata->getId());
											$facture->setClientid($locata->getClientid());
											$facture->setClient($locata->getClient());
											$facture->setTotalht($totalhtfac);
											if($client->getTypeclient() == 'export')
											{
												$facture->setTotalttc($totalhtfac);
											}
											else
											{
												$facture->setTotalttc($totalttc);
											}
											$facture->setEcheance($next45);
											// $facture->setDebutloc($locata->getDebutloc());
											// $facture->setFinloc($locata->getFinloc());
											$facture->setChantier($locata->getNomchantier());
											$facture->setReglement(0);
											$facture->setDatepaiement('');
											$facture->setModepaiement('');
											$facture->setTypedoc('facture');
											if($mode == 'forcing')
											{
												$facture->setDatecrea(date('Y-m-t'));
											}
											else
											{
												$facture->setDatecrea(date('Y-m-d'));
											}
											$facture->setCompteurfac($lastnumfact);
											$facture->setUser($locata->getUser());
											$facture->setLocatacloneid($newLocata->getId());
											$facture->setAnnee(date('Y'));
											// $facture->addFactum($facta);
											// $facta->addFacture($facture);
											$em->persist($facture);
											$em->flush();
											//Fin ajout table factures	
						}
						else
						{
							echo 'GOREMOVE22222';echo $newLocata->getId();
							$em->remove($newLocata);
							$em->flush();
						}					
					}else{echo 'on n y va pas';}
				}
			
				//Partie ventes
			
				foreach($vendatot as $vendas)
				{
					$venda = $em->getRepository('BaclooCrmBundle:Venda')
								->findOneById($vendas['f_id']);						
					$codecontrat = 'V-'.$venda->getId();
					$facturemois = $em->getRepository('BaclooCrmBundle:Factures')
								->facturesmois($codecontrat);
//echo $codecontrat;
// print_r($facturemois);
					$totalht = 0;//echo $locid;			
					$venteslignes = 0;			
					$entretienlignes = 0;			
					$transportlignes = 0;			
					$annexeslignes = 0;			
					$assurancelignes = 0;			
					$descriptionvente = array();			
					$descriptionentretien = array();			
					$descriptiontransport = array();			
					$descriptionannexe = array();
				
					if(empty($facturemois) && $venda->getBdcrecu() == 1)
					{
						foreach($venda->getVentes() as $loca)
						{
							//Nous récupérons et formatons les différentes dates
							// $finloc = strtotime ($loca->getFinloc());	
							// $finlocsec = strtotime ($loca->getFinloc());	
							// $dStart = $loca->getDebutloc();
							// $dStartsec = strtotime ($loca->getDebutloc());
							// $dEnd = $loca->getFinloc();

							//Si date début antérieure au début du mois >> date début = début mois
							// if($dStartsec <= $debutmoissec)
							// {
								// $dStart = $debutmois;
							// }
							//Si date fin posterieure à fin du mois >> date début = début mois
							// if($finlocsec >= $finmoissec)
							// {
								// $dEnd = $finmois;
							// }
							//Création du montant HT de la ligne
							if(null == $loca->getQuantite())
							{
								$quantite = 1;
							}
							else
							{
								$quantite = $loca->getQuantite();
							}
							$montantligne = $loca->getPu() * $quantite;
							$totalht += $montantligne;
					
							//On affecte chaque ligne à sa famille
							if($loca->getCodifvente() == 'vente')
							{
								$venteslignes += $montantligne;
								$descriptionvente[] = $loca->getDescription();
							}
							elseif($loca->getCodifvente() == 'entretien')
							{
								$entretienlignes += $montantligne;
								$descriptionentretien[] = $loca->getDescription();
							}
							elseif($loca->getCodifvente() == 'transport')
							{
								$transportlignes += $montantligne;
								$descriptiontransport[] = $loca->getDescription();
							}
							elseif($loca->getCodifvente() == 'annexes')
							{
								$annexeslignes += $montantligne;
								$descriptionannexe[] = $loca->getDescription();
							}
							elseif($loca->getCodifvente() == 'remise')
							{
							}
							elseif($loca->getCodifvente() == 'assurance')
							{
								$assurancelignes += $montantligne;
							}
							//Fin affectation ligne à sa famille
							
							$loca->setMontantvente($montantligne);
							$em->persist($loca);

						}					
						$compteclient = '411'.$venda->getClientid();

						$client = $em->getRepository('BaclooCrmBundle:Fiche')
									->findOneById($venda->getClientid());
						if($client->getTypeclient() != 'export')
						{
							$tva20 = $venda->getMontantvente() * 0.20;
						}
						else
						{
							$tva20 = 0;
						}
						
						$totalhtfac = $venda->getMontantvente();
						$totalttc = $totalhtfac + $tva20;

						//Avant de saisir les écritures on vérifie qu'elle n'aient pas déjà été saisies
						$journalori = $em->getRepository('BaclooCrmBundle:Afacturer')
										->findOneBy(array('compte'=>$compteclient, 'debit'=>$totalttc, 'piece'=>$venda->getId()));
						if(isset($journalori))
						{
							$message = 1;
							$date = $journalori->getDate();
						}
						else
						{
							$message = 0;										
							$client = $em->getRepository('BaclooCrmBundle:Fiche')
										->findOneById($venda->getClientid());
						
						$v = 0;
						$e = 0;
						$t = 0;
						$ass = 0;
						$ann = 0;
							
								//Ajout à la table factures
									// $facta = $em->getRepository('BaclooCrmBundle:Facta')
												// ->findOneByControle('1234');				
									$facture = new Factures;
									
									$query = $em->createQuery(
										'SELECT b.compteurfac
										FROM BaclooCrmBundle:Factures b
										WHERE b.typedoc = :typedoc
										ORDER BY b.id DESC'
									)->setMaxResults(1);
									$query->setParameter('typedoc', 'facture');
									$lastnumfact = $query->getOneOrNullResult();
									if(empty($lastnumfact) or !isset($lastnumfact) or $lastnumfact == null)
									{
										$lastnumfact = 0;//echo 'vide';
									}
									else
									{
										$lastnumfact = $query->getSingleScalarResult();//echo 'pas vide';
									}
									$numfacture = date('Y').'V'.$lastnumfact++;
												
									$client = $em->getRepository('BaclooCrmBundle:Fiche')		
									 ->findOneById($venda->getClientid());
									if($client->getDelaireglement() == 1)
									{
										$next45 = $today;
									}
									elseif($client->getDelaireglement() == 2)
									{
										$next45a = date('Y-m-d', strtotime('+45 days'));
										$next45 = date('Y-m-t', strtotime($next45a));
									}
									elseif($client->getDelaireglement() == 3)
									{
										$next45a = date('Y-m-d', strtotime('+45 days'));
										$next45 = date('Y-m-t', strtotime($next45a));
									}
									else
									{
										$next45 = $today;
									}
									
									$facture->setNumfacture($numfacture);
									$facture->setDatecrea(date('Y-m-d'));
									$facture->setCodelocata('V-'.$venda->getId());
									$facture->setClientid($venda->getClientid());
									$facture->setClient($venda->getClient());
									$facture->setTotalht($totalhtfac);
									if($client->getTypeclient() == 'export')
									{
										$facture->setTotalttc($totalhtfac);
									}
									else
									{
										$facture->setTotalttc($totalttc);
									}
									$facture->setEcheance($next45);
									$facture->setChantier($venda->getClient());
									$facture->setReglement(0);
									$facture->setDatepaiement('');
									$facture->setModepaiement('');
									$facture->setTypedoc('facture');
									if($mode == 'forcing')
									{
										$facture->setDatecrea(date('Y-m-t'));
									}
									else
									{
										$facture->setDatecrea(date('Y-m-d'));
									}
									$facture->setCompteurfac($lastnumfact);
									$facture->setUser($venda->getUser());
									$facture->setLocatacloneid($venda->getId());
									$facture->setAnnee(date('Y'));
									// $facture->addFactum($facta);
									// $facta->addFacture($facture);
									$em->persist($facture);
									$em->flush();
								//Fin ajout table factures					
						}			
					}
					else{echo 'faut pas enregistrer les ventes';}
				}
				//Fin partie ventes

				

		//FIN FACTURATION MENSUELLE