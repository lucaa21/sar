<?php
// src/OC/PlatformBundle/Antispam/OCAntispam.php

		$em = $this->getDoctrine()->getManager();
		if ($page < 1) {
		throw new \InvalidArgumentException('L\'argument $page ne peut être inférieur à 1 (valeur : "'.$page.'").');
		}
		// On définit l'article à partir duquel commencer la liste
		$limitebasse = (($page-1) * 20);
		// La construction de la requête reste inchangée
		
		$query = $em->createQuery(
		'SELECT f
		FROM BaclooCrmBundle:Chantier f
		WHERE f.description = :description
		ORDER BY f.nom ASC')
		->setParameter('description', 1);
        // $query = $qb->getQuery();
        $query->setFirstResult($limitebasse);
        $query->setMaxResults(20);		
		$lesfiches = $query->getResult();

		$query = $em->createQuery(
		'SELECT f.id
		FROM BaclooCrmBundle:Chantier f
		WHERE f.description = :description
		ORDER BY f.nom ASC')
		->setParameter('description', 1);
        // $query = $qb->getQuery();		
		$lesfichesss = $query->getResult();		


		// Ainsi que le nombre d'articles à afficher
		//$offset  = 20;
		// Enfin, on retourne l'objet Paginator correspondant à la requête construite
		// (n'oubliez pas le use correspondant en début de fichier)
		$mesfiches = $lesfiches;
