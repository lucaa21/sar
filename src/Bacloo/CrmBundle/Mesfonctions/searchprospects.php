<?php
// src/OC/PlatformBundle/Antispam/OCAntispam.php
function searchfiche($page, $critere, 'prospect')
	{
		$em = $this->getDoctrine()->getManager();
		if ($page < 1) {
		throw new \InvalidArgumentException('L\'argument $page ne peut être inférieur à 1 (valeur : "'.$page.'").');
		}
		// La construction de la requête reste inchangée
		
		$query = $em->createQuery(
		'SELECT f
		FROM BaclooCrmBundle:Fiche f
		WHERE f.user in (:user)
		AND f.typefiche = :typefiche
		ORDER BY f.raisonSociale ASC')
		->setParameter('user', $critere)	
		->setParameter('typefiche', $typefiche);					
		$lesfiches = $query->getResult();		

		// On définit l'article à partir duquel commencer la liste
		$limitebasse = ($page-1) * 20;
		// Ainsi que le nombre d'articles à afficher
		//$offset  = 20;
		// Enfin, on retourne l'objet Paginator correspondant à la requête construite
		// (n'oubliez pas le use correspondant en début de fichier)
		$mesfiches = array_slice($lesfiches, $limitebasse, 20);
		
		return $mesfiches;
	}