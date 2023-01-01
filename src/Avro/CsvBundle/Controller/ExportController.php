<?php

/**
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Avro\CsvBundle\Controller;

use Doctrine\Orm\Query;
use DoctrineExtensions\Query\Mysql\Month;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\DependencyInjection\ContainerAware;

use Avro\CsvBundle\Event\ExportEvent;
use Avro\CsvBundle\Event\ExportedEvent;

/**
 * CSV Export controller.
 *
 * @author Joris de Wit <joris.w.dewit@gmail.com>
 */
class ExportController extends ContainerAware
{
    /**
     * Export a db table.
     *
     * @param string $alias The objects alias
     *
     * @return View
     */
    public function exportAction($alias, $user, $dstart, $dend, $id)
    {
        $class = $this->container->getParameter(sprintf('avro_csv.objects.%s.class', $alias));
		
        $exporter = $this->container->get('avro_csv.exporter');
        $exporter->init($class);
	
        // customize the query
        $qb = $exporter->getQueryBuilder();

		// $user = $this->container->get('security.context')->getToken()->getUser();		

		if($alias == 'afacturer')
		{
			$debutmois = date('Y-m-01', strtotime(" -1 month"));//Debut mois précédent	
			// $debutmois = '2019-10-01';//En cas de choix de la date
			$finmois = date('Y-m-d');//Fin mois précédent
			// $finmois = date('Y-m-d');//Date du jour
			$qb->Where('o.date >= :dated')->setParameter('dated', $debutmois);
			$qb->andWhere('o.date <= :datef')->setParameter('datef', $finmois);
			$qb->andWhere('o.journal = :journal')->setParameter('journal', $user);
		}
		elseif($alias == 'ca')
		{
			$qb->select('YEARMONTH(o.datecrea) as datecrea, SUM(o.totalht) as careal'); 
			$qb->where('YEARMONTH(o.datecrea) <= :today')
				   ->setParameter('today', date('Ym',strtotime($dend)))
				   ->andWhere('YEARMONTH(o.datecrea) >= :dtsart')
				   ->setParameter('dtsart', date('Ym',strtotime($dstart)))
				   ->andWhere('o.typedoc = :typedoc')
				   ->setParameter('typedoc', 'facture')
				   ->groupBy('datecrea')
				   ->orderBy('datecrea');
		}
		elseif($alias == 'calocdet')
		{
			$qb->select('SUM(o.montantloc) as montantloc, SUM(o.assurance) as assurance, SUM(o.contributionverte) as contributionverte, (SUM(o.transportaller)+SUM(o.transportretour)) as transport, SUM(o.montantcarb) as carburant, SUM(o.montantlocavente) as ventes_annexes, YEARMONTH(o.datemodif) as datecrea'); 
			$qb->where('YEARMONTH(o.datemodif) <= :today')
			   ->setParameter('today', date('Ym',strtotime($dend)))
			   ->andWhere('YEARMONTH(o.datemodif) >= :dtsart')
			   ->setParameter('dtsart', date('Ym',strtotime($dstart)))
			   ->groupBy('datecrea')
			   ->orderBy('datecrea');
		}
		elseif($alias == 'cavente')
		{
			$qb->select('SUM(o.totalht) as careal, YEARMONTH(o.datecrea) as datecrea'); 
			$qb->where('YEARMONTH(o.datecrea) <= :today')
			   ->setParameter('today', date('Ym',strtotime($dend)))
			   ->andWhere('YEARMONTH(o.datecrea) >= :dtsart')
			   ->setParameter('dtsart', date('Ym',strtotime($dstart)))
			   ->andWhere('o.codelocata LIKE :codelocata')
			   ->setParameter('codelocata', '%V%')
			   ->andWhere('o.typedoc = :typedoc')
			   ->setParameter('typedoc', 'facture')
			   ->groupBy('datecrea')
			   ->orderBy('datecrea');
		}
		elseif($alias == 'avoirs')
		{
			$qb->select('SUM(o.totalht) as careal, YEARMONTH(o.datecrea) as datecrea'); 
			$qb->where('YEARMONTH(o.datecrea) <= :today')
			   ->setParameter('today', date('Ym',strtotime($dend)))
			   ->andWhere('YEARMONTH(o.datecrea) >= :dtsart')
			   ->setParameter('dtsart', date('Ym',strtotime($dstart)))
			   ->andWhere('o.typedoc = :typedoc')
			   ->setParameter('typedoc', 'avoir')
			   ->groupBy('datecrea')
			   ->orderBy('datecrea');
		}
		elseif($alias == 'avoirsparcom')
		{
			$qb->select('o.totalht as careal, o.user, YEARMONTH(o.datecrea) as datecrea'); 
			$qb->where('YEARMONTH(o.datecrea) <= :today')
			   ->setParameter('today', date('Ym',strtotime($dend)))
			   ->andWhere('YEARMONTH(o.datecrea) >= :dtsart')
			   ->setParameter('dtsart', date('Ym',strtotime($dstart)))
			   ->andWhere('o.typedoc = :typedoc')
			   ->setParameter('typedoc', 'avoir')
			   ->orderBy('datecrea');
		}
		elseif($alias == 'cacom')
		{
			$qb->select('o.totalht as careal, o.user, YEARMONTH(o.datecrea) as datecrea'); 
			$qb->where('YEARMONTH(o.datecrea) <= :today')
			   ->setParameter('today', date('Ym',strtotime($dend)))
			   ->andWhere('YEARMONTH(o.datecrea) >= :dtsart')
			   ->setParameter('dtsart', date('Ym',strtotime($dstart)))
			   ->andWhere('o.typedoc = :typedoc')
			   ->setParameter('typedoc', 'facture')
			   ->orderBy('datecrea');
		}
		elseif($alias == 'camensuelclients')
		{
			$qb->select('o.client, o.montantloc, o.montantcarb, o.transportaller, o.transportretour, o.contributionverte, o.assurance, o.montantlocavente, YEARMONTH(o.datemodif) as Ca_Loc'); 
			$qb->where('YEARMONTH(o.datemodif) <= :today')
			   ->setParameter('today', date('Ym',strtotime($dend)))
			   ->andWhere('YEARMONTH(o.datemodif) >= :dtsart')
			   ->setParameter('dtsart', date('Ym',strtotime($dstart)))
			   ->orderBy('o.client');
		}
		elseif($alias == 'camensuelmachines')
		{
			$qb->select('o.codemachineinterne, o.montantloc as Ca_Loc'); 
			$qb->where('YEARMONTH(o.debutloc) <= :today')
			   ->setParameter('today', date('Ym',strtotime($dend)))
			   ->andWhere('YEARMONTH(o.debutloc) >= :dtsart')
			   ->setParameter('dtsart', date('Ym',strtotime($dstart)))
			   ->orderBy('o.codemachineinterne');
		}
		elseif($alias == 'camensueltypemachines')
		{
			$qb->select('o.codemachine, o.montantloc as Ca_Loc'); 
			$qb->where('YEARMONTH(o.debutloc) <= :today')
			   ->setParameter('today', date('Ym',strtotime($dend)))
			   ->andWhere('YEARMONTH(o.debutloc) >= :dtsart')
			   ->setParameter('dtsart', date('Ym',strtotime($dstart)))
			   ->orderBy('o.codemachine');
		}
		elseif($alias == 'camensueltypemachinessl')
		{
			$qb->select('o.codemachine, o.montantloc as Ca_Loc'); 
			$qb->where('YEARMONTH(o.debutloc) <= :today')
			   ->setParameter('today', date('Ym',strtotime($dend)))
			   ->andWhere('YEARMONTH(o.debutloc) >= :dtsart')
			   ->setParameter('dtsart', date('Ym',strtotime($dstart)))
			   ->orderBy('o.codemachine');
		}
		elseif($alias == 'extraitcompteclient')
		{
			$qb->select('o.numfacture, o.datecrea, o.client, o.echeance, o.totalht, o.totalttc, o.chantier, o.reglement, o.datepaiement, o.modepaiement, o.typedoc'); 
			$qb->where('o.clientid = :id')
			   ->setParameter('id', $id)
			   ->orderBy('o.datecrea');
		}
		elseif($alias == 'caclientsdetaille')
		{
			$qb->select('o.client, SUM(o.montantloc) as montantloc, SUM(o.assurance) as assurance, SUM(o.contributionverte) as contributionverte, (SUM(o.transportaller)+SUM(o.transportretour)) as transport, SUM(o.montantcarb) as carburant, SUM(o.montantlocavente) as ventes_annexes'); 
			$qb->where('YEARMONTH(o.datemodif) <= :today')
			   ->setParameter('today', date('Ym',strtotime($dend)))
			   ->andWhere('YEARMONTH(o.datemodif) >= :dtsart')
			   ->setParameter('dtsart', date('Ym',strtotime($dstart)))
			   ->groupBy('o.client')
			   ->orderBy('o.client');
		}
		elseif($alias == 'avoirsparclients')
		{
			$qb->select('c.client, c.totalht as avoirtht'); 
			$qb->where('YEARMONTH(c.datecrea) <= :today')
			   ->setParameter('today', date('Ym',strtotime($dEnd)))
			   ->andWhere('c.typedoc = :typedoc')
			   ->setParameter('typedoc', 'avoir')
			   ->groupBy('c.client')
			   ->orderBy('c.client', 'ASC');			   
		}
		else
		{
			$qb->where('o.user = :user')->setParameter('user', $user);			
		}

        $content = $exporter->getContent();


			$response = new Response($content);
			$response->headers->set('Content-Type', 'application/csv');
			$response->headers->set('Content-Disposition', sprintf('attachment; filename="%s.csv"', $alias));

			return $response;		

        // $dispatcher = $this->container->get('event_dispatcher');
        // $dispatcher->dispatch('avro_csv.exporter_export', new ExportEvent($exporter));

        // $content = $exporter->getContent();

        // $dispatcher->dispatch('avro_csv.exporter_exported', new ExportedEvent($exporter));

        // $response = new Response($content);
        // $response->headers->set('Content-Type', 'application/csv');
        // $response->headers->set('Content-Disposition', sprintf('attachment; filename="%s.csv"', $alias));

        // return $response;
    }
}

