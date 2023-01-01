<?php

/**
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Avro\CsvBundle\Import;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

use Avro\CaseBundle\Util\CaseConverter;
use Avro\CsvBundle\Annotation\Exclude;
use Avro\CsvBundle\Event\RowAddedEvent;
use Avro\CsvBundle\Util\Reader;

use Doctrine\Common\Persistence\ObjectManager;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Import csv to doctrine entity/document
 *
 * @author Joris de Wit <joris.w.dewit@gmail.com>
 */
class Importer
{
    protected $fields;
    protected $metadata;
    protected $reader;
    protected $batchSize = 20;
    protected $importCount = 1;
    protected $caseConverter;
    protected $objectManager;

    /**
     * @param CsvReader     $reader        The csv reader
     * @param Dispatcher    $dispatcher    The event dispatcher
     * @param CaseConverter $caseConverter The case Converter
     * @param ObjectManager $objectManager The Doctrine Object Manager
     * @param int           $batchSize     The batch size before flushing & clearing the om
     */
    public function __construct(Reader $reader, EventDispatcherInterface $dispatcher, CaseConverter $caseConverter, ObjectManager $objectManager, $batchSize)
    {
        $this->reader = $reader;
        $this->dispatcher = $dispatcher;
        $this->caseConverter = $caseConverter;
        $this->objectManager = $objectManager;
        $this->batchSize = $batchSize;
    }

    /**
     * Import a file
     *
     * @param File   $file         The csv file
     * @param string $class        The class name of the entity
     * @param string $delimiter    The csv's delimiter
     * @param string $headerFormat The header case format
     *
     * @return boolean true if successful
     */
    public function init($file, $class, $delimiter = ',', $headerFormat = 'title')
    {
        $this->reader->open($file, $delimiter);
        $this->class = $class;
        $this->metadata = $this->objectManager->getClassMetadata($class);
        $this->headers = $this->caseConverter->convert($this->reader->getHeaders(), $headerFormat);
    }

    /**
     * Import the csv and persist to database
     *
     * @param array $fields The fields to persist
     *
     * @return true if successful
     */
    public function import($fields, $user, $alias, $id,  Request $request)
    {//echo $id;
	// ini_set('max_execution_time', 400);
// echo 'array0';print_r($fields);
        $fields = array_unique($this->caseConverter->toPascalCase($fields));
// echo 'array1';print_r($fields);
        while ($row = $this->reader->getRow()) {
            if (($this->importCount % $this->batchSize) == 0) {
                $pi = $this->addRow($row, $user, $alias, $id, $fields, true);//echo '&1&'.$pi;;
            } else {
                $pi = $this->addRow($row, $user, $alias, $id, $fields, false);//echo  '&2&';
            }
            $this->importCount++;
        }
			if ($pi == 'pok')
			{//echo 'sess';
			$session = new Session();
			$session = $request->getSession();

			// définit et récupère des attributs de session
			$session->set('pi', $pi);			
			}		
		// echo '>'.$this->importCount.'<';
        // one last flush to make sure no persisted objects get left behind
        $this->objectManager->flush();

        return true;
    }

	public function convert( $str ) {
		foreach(array_keys($str) as $key){
			$str[$key] = iconv("Windows-1252", "UTF-8", $str[$key]);
		} 
		return $str;
	}	
	
    /**
     * Add Csv row to db
     *
     * @param array   $row      An array of data
     * @param array   $fields   An array of the fields to import
     * @param boolean $andFlush Flush the ObjectManager
     */
    private function addRow($rowo, $user, $alias, $id, $fields, $andFlush = true)
    {
	ini_set('max_execution_time', 400);
	// print_r($rowo);
		include('societe.php');
		$row = $this->convert($rowo);
	// print_r($row);
		
        // Create new entity
        $entity = new $this->class();

        if (in_array('Id', $fields)) {
            $key = array_search('Id', $fields);
            if ($this->metadata->hasField('legacyId')) {
                $entity->setLegacyId($row[$key]);
            }
            unset($fields[$key]);
        }
// echo 'array2';print_r($fields);
        // loop through fields and set to row value
        foreach ($fields as $k => $v) {// echo $k.$v;
            if ($this->metadata->hasField(lcfirst($v))) {
				if (isset($row[$k]))
				{
					$entity->{'set'.$fields[$k]}($row[$k]);
					$i = 'ok';
					//echo 'jo';
				}
				else
				{
					$i = 'pok';
					//echo 'panne';
				}
            } else if ($this->metadata->hasAssociation(lcfirst($v))) {
                $association = $this->metadata->associationMappings[lcfirst($v)];
                switch ($association['type']) {
                    case '1': // oneToOne
                        //Todo:
                        break;
                    case '2': // manyToOne
                        continue;
                        // still needs work
                        $joinColumnId = $association['joinColumns'][0]['name'];
                        $legacyId = $row[array_search($this->caseConverter->toCamelCase($joinColumnId), $this->headers)];
                        if ($legacyId) {
                            try {
                                $criteria = array('legacyId' => $legacyId);
                                if ($this->useOwner) {
                                    $criteria['owner'] = $this->owner->getId();
                                }

                                $associationClass = new \ReflectionClass($association['targetEntity']);
                                if ($associationClass->hasProperty('legacyId')) {
                                    $relation = $this->objectManager->getRepository($association['targetEntity'])->findOneBy($criteria);
                                    if ($relation) {
                                        $entity->{'set'.ucfirst($association['fieldName'])}($relation);
                                    }
                                }
                            } catch(\Exception $e) {
                                // legacyId does not exist
                                // fail silently
                            }
                        }
                        break;
                    case '4': // oneToMany
                        //TODO:
                        break;
                    case '8': // manyToMany
                        //TODO:
                        break;
                }
            }
        }
// echo '>$i'.$i.'<';
// echo 'alias='.$alias;
        $this->dispatcher->dispatch('avro_csv.row_added', new RowAddedEvent($entity, $row, $fields));
		if($alias == 'fiche' && $i == 'ok')
		{
			$today = date_create(date('Y-m-d'));
			$entity->setUser($user->getUsername());
			$entity->setUseremail($user->getEmail());
			$entity->setTypefiche('prospect');
			$entity->setUsersociete($societe);
			$entity->setLastmodif($today);
			$this->objectManager->persist($entity);
		}
		elseif($alias == 'contact' && $i == 'ok')
		{
		// echo '>$i'.$i.'<';
		// Récupérer la fiche avec cette raison sociale et ce pseudo pour y insérer le contact
			// echo $entity->GetCivilite();
				// echo $user;
				$criteres = array('user' => $user->getUsername(), 'raisonSociale' => $entity->GetEntreprise(), 'cp' => $entity->GetCp());
					$fiche  = $this->objectManager->getRepository('BaclooCrmBundle:Fiche')		
								->findOneBy($criteres);
				$criteres2 = array('user' => $user->getUsername(), 'entreprise' => $entity->GetEntreprise(), 'nom' => $entity->GetNom(), 'prenom' => $entity->GetPrenom(), 'cp' => $entity->GetCp());
					$contact  = $this->objectManager->getRepository('BaclooCrmBundle:Bcontacts')		
								->findOneBy($criteres2);
					if(isset($fiche) && empty($contact))
					{
						// echo '1';
						$today = date_create(date('Y-m-d'));
						$entity->setDateCrea($today);
						$entity->setUser($user->getUsername());
						$fiche->addBcontact($entity);
						$this->objectManager->persist($entity);
					}

					
			if ($andFlush) {
				$this->objectManager->flush();
				$this->objectManager->clear($this->class);				
				$this->objectManager->clear($contact);				
			}				
		}
		elseif($alias == 'event' && $i == 'ok')
		{
// echo 'lodarr';echo $user->getUsername();echo $entity->GetEntreprise(); echo $entity->GetCp();
				$criteres = array('user' => $user->getUsername(), 'raisonSociale' => $entity->GetEntreprise(), 'cp' => $entity->GetCp());
					$fiche  = $this->objectManager->getRepository('BaclooCrmBundle:Fiche')		
								->findOneBy($criteres);
				$criteres2 = array('user' => $user->getUsername(), 'entreprise' => $entity->GetEntreprise(), 'eventDate' => $entity->GetEventDate(), 'eventComment' => $entity->GetEventComment(), 'cp' => $entity->GetCp());
					$event  = $this->objectManager->getRepository('BaclooCrmBundle:Event')		
								->findOneBy($criteres2);

					if(isset($fiche) && empty($event))
					{//echo 'ladder';
						// echo $fiche->GetUser();
						// $today = date_create(date('Y-m-d'));
						// $entity->setEventDate($today);
						$entity->setUser($user->getUsername());
						$fiche->addEvent($entity);
						$this->objectManager->persist($entity);
					}
			if ($andFlush) {
				$this->objectManager->flush();
				$this->objectManager->clear($this->class);				
				$this->objectManager->clear($event);				
			}	

		}
		elseif($alias == 'rappels' && $i == 'ok')
		{
		// Récupérer la fiche avec cette raison sociale et ce pseudo pour y insérer le rappel
			// echo $entity->GetEntreprise();
				// echo $user;
				$criteres = array('user' => $user->getUsername(), 'raisonSociale' => $entity->GetEntreprise(), 'cp' => $entity->GetCp());
					$fiche  = $this->objectManager->getRepository('BaclooCrmBundle:Fiche')		
								->findOneBy($criteres);
				$criteres2 = array('user' => $user->getUsername(), 'entreprise' => $entity->GetEntreprise(), 'date' => $entity->GetDate(), 'rapTexte' => $entity->GetRapTexte(), 'cp' => $entity->GetCp());
					$rappels  = $this->objectManager->getRepository('BaclooCrmBundle:Brappels')		
								->findOneBy($criteres2);
					if(isset($fiche) && empty($rappels))
					{
						// echo $fiche->GetUser();
						$entity->setUser($user->getUsername());
						$fiche->addBrappel($entity);							
						$entity->addFiche($fiche);							
						$this->objectManager->persist($entity);
					}
			if ($andFlush) {
				$this->objectManager->flush();
				$this->objectManager->clear($this->class);				
				$this->objectManager->clear($rappels);				
				
			}	

		}
		elseif($alias == 'grille' && $i == 'ok')
		{
		// Récupérer la fiche avec cette raison sociale et ce pseudo pour y insérer le contact
			// echo $entity->GetEntreprise();
				// echo $id;
				$criteres = array('id' => $id);
					$fiche  = $this->objectManager->getRepository('BaclooCrmBundle:Fiche')		
								->findOneBy(array('id' => $id));
// print_r($fiche);								
				$criteres2 = array('codeclient' => $id, 'codemachineinterne' => $entity->GetCodemachineinterne(), 'typemachine' => $entity->GetTypemachine());
					$grille  = $this->objectManager->getRepository('BaclooCrmBundle:Grille')		
								->findOneBy($criteres2);
					if(!empty($grille))
					{
						$this->objectManager->remove($grille);
						$this->objectManager->flush();
					}
					$grille  = $this->objectManager->getRepository('BaclooCrmBundle:Grille')		
								->findOneBy($criteres2);					
					if(isset($fiche) && empty($grille))
					{
						// echo $fiche->GetUser();
						$entity->setCodeclient($id);
						$fiche->addGrille($entity);							
						$entity->addFiche($fiche);								
						$this->objectManager->persist($entity);
					}
			if ($andFlush) {
				$this->objectManager->flush();
				$this->objectManager->clear($this->class);				
				$this->objectManager->clear($grille);
			}
		}
		elseif($alias == 'grillesl' && $i == 'ok')
		{
		// Récupérer la fiche avec cette raison sociale et ce pseudo pour y insérer le contact
			// echo $entity->GetEntreprise();
				// echo $id;
				$criteres = array('id' => $id);
					$fiche  = $this->objectManager->getRepository('BaclooCrmBundle:Fiche')		
								->findOneBy(array('id' => $id));
// print_r($fiche);								
				$criteres2 = array('codeclient' => $id, 'codemachineinterne' => $entity->GetCodemachineinterne(), 'typemachine' => $entity->GetTypemachine());
					$grille  = $this->objectManager->getRepository('BaclooCrmBundle:Grillesl')		
								->findOneBy($criteres2);
					if(!empty($grille))
					{
						$this->objectManager->remove($grille);
						$this->objectManager->flush();
					}
					$grille  = $this->objectManager->getRepository('BaclooCrmBundle:Grille')		
								->findOneBy($criteres2);					
					if(isset($fiche) && empty($grille))
					{
						// echo $fiche->GetUser();
						$entity->setCodeclient($id);
						$fiche->addGrillesl($entity);							
						$entity->addFiche($fiche);								
						$this->objectManager->persist($entity);
					}
			if ($andFlush) {
				$this->objectManager->flush();
				$this->objectManager->clear($this->class);				
				$this->objectManager->clear($grille);
			}
		}				
			// echo '$iiiiiiii'.$i;
	
	return $i;
		        // $this->objectManager->persist($entity);
    }

    /**
     * Get import count
     *
     * @return int
     */
    public function getImportCount()
    {
        return $this->importCount;
    }
}
