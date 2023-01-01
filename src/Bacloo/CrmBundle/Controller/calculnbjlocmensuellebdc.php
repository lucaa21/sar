<?php

//nb jrs du mois de debutloc
$premierjour = $loc->getDebutloc();
$dernierjour = date("Y-m-t", strtotime($premierjour));
$premiermoisentier = date('Y-m-d', strtotime($dernierjour . ' +1 days'));

// $nbm = (int)abs((strtotime($premierjour) - strtotime($dernierjour))/(60*60*24*30)); echo ' MMMMM '.$nbm;

$begin = new DateTime($loc->getDebutloc());
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
echo 'NBJLOCL'.$nbjloc1;		
//nb jours du mois de fin loc
$premierjourdm = date("Y-m-01", strtotime($loc->getFinloc()));echo ' 1ERJDM'.date("Y-m-01", strtotime($loc->getFinloc()));;
$dernierjourdm = $loc->getFinloc();
$derniermoisentier = date('Y-m-d', strtotime($premierjourdm . ' -1 days'));//echo $derniermoisentier;

$begin = new DateTime($loc->getDebutloc());
$end = new DateTime($dernierjourdm );
$end = $end->modify( '+1 day' );

$interval = DateInterval::createFromDateString('1 day');
$period = new DatePeriod($begin, $interval, $end);
$nbjlocdm = 0;
$nbjlocassdm = 0;

foreach ($period as $dt) {
	$newformat = $dt->format("D");
	$nbjlocassdm++;
	if($loc->getFacturersamedi() == 1 && $newformat == 'Sat')
	{
		$nbjlocdm++;
	}
	elseif($loc->getFacturerdimanche() == 1 && $newformat == 'Sun')
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



if($nbjlocdm < 20)
{
	$nbjlocdm = $nbjloc1;
}
else
{
	$nbjlocdm = 20;
	$nbjlocassdm = 28;
}
echo ' nbjlocdm'.$nbjlocdm;							
//nb de mois entier à 20 jours
$d1 = new DateTime($premierjour);echo  ' D1'.date('Y-m-d', strtotime($premierjour));
$d2 = new DateTime($derniermoisentier);echo 'D2'.$derniermoisentier;

$nbmois20j = $d1->diff($d2)->m + ($d1->diff($d2)->y*12);
// $nbmois20j = abs((date('Y', $derniermoisentier) - date('Y', $premiermoisentier))*12 + (date('m', $derniermoisentier) - date('m', $premiermoisentier)));
// $numberOfMonths = abs((date('Y', $endDate) - date('Y', $startDate))*12 + (date('m', $endDate) - date('m', $startDate)))+1;
$nbj = $nbmois20j * 20;
$nbjass = $nbmois20j * 28;
echo ' nbmois20j'.$nbmois20j;
//Total jours
if($nbjloc > 20)
{
	$nbjloc = $nbjloc1 + $nbj + $nbjlocdm;
	$nbjlocass = $nbjlocass1 + $nbjass + $nbjlocassdm;
}
else
{
	$nbjloc = 20;
	$nbjlocass = 28;
}