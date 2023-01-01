<?php

//nb jrs du mois de debutloc
$premierjour = $loca->getDebutloc();
$dernierjour = date("Y-m-t", strtotime($premierjour));
$premiermoisentier = date('Y-m-d', strtotime($dernierjour . ' +1 days'));

// $nbm = (int)abs((strtotime($premierjour) - strtotime($dernierjour))/(60*60*24*30)); echo ' MMMMM '.$nbm;

$begin = new DateTime($loca->getDebutloc());
$end = new DateTime($dernierjour );
$end = $end->modify( '+1 day' );

// $nbm = date_diff($begin, $end); echo ' MMMMM '; echo $nbm->m + ($nbm->y * 12) . ' months';

$interval = DateInterval::createFromDateString('1 day');
$period = new DatePeriod($begin, $interval, $end);
$nbjloc1 = 0;
$nbjlocass1 = 0;

foreach ($period as $dt) {
	$newformat = $dt->format("D");								
	$nbjlocass1++;
	if($newformat == 'Sat' || $newformat == 'Sun')
	{}
	else
	{
		$nbjloc1++;//echo $newformat;echo $nbjloc;
	}							
}
echo ' NBJLOCDEB '.$nbjloc;
if($nbjloc1 < 20)
{
	$nbjloc1 = $nbjloc1;
}
else
{
	$nbjloc1 = 20;
	$nbjlocass1 = 28;
}
$nbjloctot = $nbjloc1;		
//echo 'NBJLOCL'.$nbjloc1;		
//nb jours du mois de fin loc
$premierjourdm = date("Y-m-01", strtotime($loca->getFinloc()));//echo ' 1ERJDM'.date("Y-m-01", strtotime($loca->getFinloc()));;
$dernierjourdm = $loca->getFinloc();
$derniermoisentier = date('Y-m-d', strtotime($dernierjourdm . ' -1 days'));//echo $derniermoisentier;

$begin = new DateTime($premierjourdm);
$end = new DateTime($dernierjourdm );
$end = $end->modify( '+1 day' );

$interval = DateInterval::createFromDateString('1 day');
$period = new DatePeriod($begin, $interval, $end);
$nbjlocdm = 0;
$nbjlocassdm = 0;

foreach ($period as $dt) {
	$newformat = $dt->format("D");
	$nbjlocassdm++;
	if($locata->getFacturersamedi() == 1 && $newformat == 'Sat')
	{
		$nbjlocdm++;
	}
	elseif($locata->getFacturerdimanche() == 1 && $newformat == 'Sun')
	{
		$nbjlocdm++;
	}
	elseif($newformat == 'Sat' or $newformat == 'Sun')
	{}
	else
	{
		$nbjlocdm++;
	}	
}


//echo 'mbjlocDM111X'.$nbjlocdm;
if($nbjlocdm < 20)
{//echo 'iciiiiiiiiiiii';
	$nbjlocdm = $nbjlocdm;
}
else
{//echo 'laaaaaaa';
	$nbjlocdm = 20;
	$nbjlocassdm = 28;
}
//echo ' nbjlocdm'.$nbjlocdm;							
//nb de mois entier à 20 jours
$debutloc = $loca->getDebutloc();
$finloc = $loca->getFinloc();

$d1 = new DateTime(date("Y-m-01", strtotime($debutloc . ' +1 month')));//echo 'D1X'.date("Y-m-01", strtotime($debutloc . ' +1 month'));
$d2 = new DateTime(date('Y-m-t', strtotime($finloc . ' -1 month')));//echo 'D2X'.date('Y-m-t', strtotime($finloc . ' -1 month'));

$nbmois20j = $d1->diff($d2)->m + ($d1->diff($d2)->y*12)-2;
$nbj = $nbmois20j * 20;
$nbjass = $nbmois20j * 28;
//echo ' nbmois20j'.$nbmois20j;
//Total jours
if($nbjloc >= 58)
{//echo '>3';echo 'nbjloc1'.$nbjloc1;echo 'nbj'.$nbj;echo 'nbjlocdm'.$nbjlocdm;
	$nbjloc = $nbjloc1 + $nbj + $nbjlocdm;
	$nbjlocass = $nbjlocass1 + $nbjass + $nbjlocassdm;
}
elseif($nbjloc > 31 && $nbjloc < 58)
{//echo '222222222222';echo 'nbjloc1'.$nbjloc1;echo 'nbj'.$nbj;echo 'nbjlocdm'.$nbjlocdm;
	$nbjloc = $nbjloc1 + $nbjlocdm;
	$nbjlocass = $nbjlocass1 + $nbjass + $nbjlocassdm;
}
else
{//echo '11111111111';
	$nbjloc = $nbjloc1;
	$nbjlocass = $nbjlocass1 ;
	// $nbjlocass = 28;
}