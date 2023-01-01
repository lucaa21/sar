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
echo 'MODEachat '.$mode;	
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
				
				//Partie achat
				$debutmois = date('Y-m-01', strtotime(" -1 month"));//Debut mois précédent	
				$finmois = date('Y-m-d');//Fin mois précédent			
// print_r($achatstot);
				foreach($achatstot as $locatafrss)
				{echo 'rrrrrrr'.$locatafrss['f_id'];
					$go = 'XXX';echo '****';echo $locatafrss['f_fournisseur'];echo $locatafrss['f_id'];echo '****';echo 'GOOO11';echo $go;
					//On recupère le locatafrs pour le bdc sélectionné
					$locatafrs = $em->getRepository('BaclooCrmBundle:Locatafrs')
								->findOneById($locatafrss['f_id']);	

					//On reconstitue  le code bdc			
					$codecontrat = 'H-'.$locatafrs->getId();
					
					//Sur ce BDC à facturer y a-t-il des locations
					$nbloc = 0;//Nombre de loc
					$nbautresachats = 0;//Nombre d'autres achats
					
					//On boucle pour récupérer chaque ligne du BDC
					foreach($locatafrs->getLocationsfrs() as $loca)
					{
						//S'il s'agit d'un location on monte le compteur de 1 
						if($loca->getReference() == 'location')
						{
							$nbloc++;
						}
						else //SI c'est un achat autre on montre le compteur de 1
						{
							$nbautresachats++; 
						}
					}
					//On récupère les factures ayant ce code bdc
					$facturemois = $em->getRepository('BaclooCrmBundle:Factures')
								->facturesmois($codecontrat);
					
					//Initialisation des compteurs et tableaux
					$totalht = 0;//echo $locid;			
					$locationlignes = 0;			
					$assurancelignes = 0;		
					$contrubutionvertelignes = 0;		
					$piecelignes = 0;			
					$transportlignes = 0;			
					$materiellignes = 0;			
					$prestationlignes = 0;			
					$autrelignes = 0;			
					$descriptionvente = array();			
					$descriptionpiece = array();			
					$descriptiontransport = array();			
					$descriptionannexe = array();
					$descriptionautre = array();
// echo 'nbloc'.$nbloc;echo 'etatbdc'.$locatafrs->getEtatbdc();				
					//Point 1 : pas de loc
					//S'il 'n ya pas de factures avec ce n°de bdc et que le bdc à facturer a été validé
					//et qu'il n'y a pas de location dessus et au moins 1 autre achat, on gènère la facturation
					if(empty($facturemois) && $locatafrs->getEtatbdc() == 1 && $nbloc == 0 && $nbautresachats > 0)
					{echo 'point1';
						include('achatnormal.php');					
					}//S'il y a un mélange de Locations et d'achats					
					elseif($nbloc > 0 && $nbautresachats > 0)//Point 2 : Loc + autres achats
					{echo 'point2';
						include('achatsousloc.php');	
					}//S'il n'y a que des locations				
					elseif($nbloc > 0 && $nbautresachats == 0)//Point 3 : 100% Loc
					{echo 'point3';
						include('achatsousloc.php');	
					}
					else{}
				}
				//Fin partie achat
				

		//FIN FACTURATION MENSUELLE