<?php

namespace Bacloo\UserBundle\Entity;
use FOS\UserBundle\Entity\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * User
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 * @ORM\Entity(repositoryClass="Bacloo\UserBundle\Entity\UserRepository")
 */

class User extends BaseUser
{
	 /**
     * @ORM\Column(name="usersociete", type="string", length=255, nullable=true)
     *
     */
    protected $usersociete;	
	
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(name="nom", type="string", length=255, nullable=true)
     *
     */
    protected $nom;	

    /**
     * @ORM\Column(name="prenom", type="string", length=255, nullable=true)
     */
    protected $prenom;	

    /**
     * @ORM\Column(name="activite", type="string", length=255, nullable=true)
     */
    protected $activite;

    /**
     * @ORM\Column(name="desc_rech", type="string", length=512, nullable=true)
     */
    protected $desc_rech;
	
    /**
     * @ORM\Column(name="tags", type="string", length=512, nullable=true)
     */
    protected $tags;

    /**
     * @ORM\Column(name="actvise", type="string", length=512, nullable=true)
     */
    protected $actvise;

    /**
     * @var integer
     *
     * @ORM\Column(name="credits", type="integer", nullable=true)
     */
    protected $credits;
	
    /**
     * @var integer
     *
     * @ORM\Column(name="note", type="integer", nullable=true)
     */
    protected $note;
	
    /**
     * @var integer
     *
     * @ORM\Column(name="point", type="integer", nullable=true)
     */
    protected $point;
	
    /**
     * @var integer
     *
     * @ORM\Column(name="plein", type="integer", nullable=true)
     */
    protected $plein;
	
    /**
     * @var string
     *
     * @ORM\Column(name="actconnexes", type="string", length=512, nullable=true))
     */
    protected $actconnexes;

    /**
     * @ORM\Column(name="parrain", type="string", length=255, nullable=true)
     *
     */
    protected $parrain;	

    /**
     * @ORM\Column(name="typeuser", type="string", length=255, nullable=true)
     *
     */
    protected $typeuser;		

    /**
     * @ORM\Column(name="usernomsociete", type="string", length=255, nullable=true)
     *
     */
    protected $usernomsociete;		

    /**
     * @ORM\Column(name="nomrep", type="string", length=255, nullable=true)
     *
     */
    protected $nomrep;			

    /**
     * @ORM\Column(name="typebacloo", type="string", length=255, nullable=true)
     *
     */
    protected $typebacloo;				

    /**
     * @ORM\Column(name="roleuser", type="string", length=255, nullable=true)
     *
     */
    protected $roleuser;	

    /**
     * @ORM\Column(name="textaccueil", type="string", length=255, nullable=true)
     */
    protected $textaccueil;
	
    /**
     * @var integer
     *
     * @ORM\Column(name="fichelimit", type="integer", nullable=true)
     */
    protected $fichelimit;

    /**
     * @var string
     *
     * @ORM\Column(name="logged", type="string", length=255, nullable=true)
     */
    private $logged;
	

    /**
     * @var string
     *
     * @ORM\Column(name="rib", type="string", length=255, nullable=true)
     */
    private $rib;

	

    /**
     *
     * @ORM\Column(name="cp", type="string", length=255, nullable=true)
     */
    protected $cp;

    /**
     *
     * @ORM\Column(name="cpuser", type="string", length=255, nullable=true)
     */
    protected $cpuser;
	
	/**
	  * @ORM\Column(name="charge_id", type="string", length=255, nullable=true)
	  */
	protected $chargeId;


    /**
     * @var string
     *
     * @ORM\Column(name="stripeid", type="string", length=255, nullable=true)
     */
    private $stripeid;

    /**
     * @var integer
     *
     * @ORM\Column(name="premium", type="integer", length=1, nullable=true)
     */
    private $premium;

    /**
     * @var \string
     *
     * @ORM\Column(name="datepremium", type="string", nullable=true)
     */
    private $datepremium;

    /**
     * @var \string
     *
     * @ORM\Column(name="finpremium", type="string", nullable=true)
     */
    private $finpremium;	

    /**
     * @var \Datetime
     *
     * @ORM\Column(name="datenaissance", type="string", length=255, nullable=true)
     */
    protected $datenaissance;

    /**
     * @var string
     *
     * @ORM\Column(name="tel", type="string", length=255, nullable=true)
     */
    protected $tel;

    /**
     * @var string
     *
     * @ORM\Column(name="adresse", type="string", length=255, nullable=true)
     */
    protected $adresse;

    /**
     * @var string
     *
     * @ORM\Column(name="codepostal", type="string", length=255, nullable=true)
     */
    protected $codepostal;

    /**
     * @var string
     *
     * @ORM\Column(name="ville", type="string", length=255, nullable=true)
     */
    protected $ville;


    /**
     * @var string
     *
     * @ORM\Column(name="photo", type="string", length=255, nullable=true)
     */
    protected $photo;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255, nullable=true)
     */
    protected $type;
	

    /**
     * Set nom
     *
     * @param string $nom
     *
     * @return User
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set prenom
     *
     * @param string $prenom
     *
     * @return User
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Get prenom
     *
     * @return string
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * Set datenaissance
     *
     * @param string $datenaissance
     *
     * @return User
     */
    public function setDatenaissance($datenaissance)
    {
        $this->datenaissance = $datenaissance;

        return $this;
    }

    /**
     * Get datenaissance
     *
     * @return string
     */
    public function getDatenaissance()
    {
        return $this->datenaissance;
    }

    /**
     * Set tel
     *
     * @param string $tel
     *
     * @return User
     */
    public function setTel($tel)
    {
        $this->tel = $tel;

        return $this;
    }

    /**
     * Get tel
     *
     * @return string
     */
    public function getTel()
    {
        return $this->tel;
    }

    /**
     * Set adresse
     *
     * @param string $adresse
     *
     * @return User
     */
    public function setAdresse($adresse)
    {
        $this->adresse = $adresse;

        return $this;
    }

    /**
     * Get adresse
     *
     * @return string
     */
    public function getAdresse()
    {
        return $this->adresse;
    }

    /**
     * Set codepostal
     *
     * @param string $codepostal
     *
     * @return User
     */
    public function setCodepostal($codepostal)
    {
        $this->codepostal = $codepostal;

        return $this;
    }

    /**
     * Get codepostal
     *
     * @return string
     */
    public function getCodepostal()
    {
        return $this->codepostal;
    }

    /**
     * Set ville
     *
     * @param string $ville
     *
     * @return User
     */
    public function setVille($ville)
    {
        $this->ville = $ville;

        return $this;
    }

    /**
     * Get ville
     *
     * @return string
     */
    public function getVille()
    {
        return $this->ville;
    }

    /**
     * Set rib
     *
     * @param string $rib
     *
     * @return User
     */
    public function setRib($rib)
    {
        $this->rib = $rib;

        return $this;
    }

    /**
     * Get rib
     *
     * @return string
     */
    public function getRib()
    {
        return $this->rib;
    }

    /**
     * Set photo
     *
     * @param string $photo
     *
     * @return User
     */
    public function setPhoto($photo)
    {
        $this->photo = $photo;

        return $this;
    }

    /**
     * Get photo
     *
     * @return string
     */
    public function getPhoto()
    {
        return $this->photo;
    }

    /**
     * Set type
     *
     * @param string $type
     *
     * @return User
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set usersociete
     *
     * @param string $usersociete
     *
     * @return User
     */
    public function setUsersociete($usersociete)
    {
        $this->usersociete = $usersociete;

        return $this;
    }

    /**
     * Get usersociete
     *
     * @return string
     */
    public function getUsersociete()
    {
        return $this->usersociete;
    }

    /**
     * Set activite
     *
     * @param string $activite
     *
     * @return User
     */
    public function setActivite($activite)
    {
        $this->activite = $activite;

        return $this;
    }

    /**
     * Get activite
     *
     * @return string
     */
    public function getActivite()
    {
        return $this->activite;
    }

    /**
     * Set descRech
     *
     * @param string $descRech
     *
     * @return User
     */
    public function setDescRech($descRech)
    {
        $this->desc_rech = $descRech;

        return $this;
    }

    /**
     * Get descRech
     *
     * @return string
     */
    public function getDescRech()
    {
        return $this->desc_rech;
    }

    /**
     * Set tags
     *
     * @param string $tags
     *
     * @return User
     */
    public function setTags($tags)
    {
        $this->tags = $tags;

        return $this;
    }

    /**
     * Get tags
     *
     * @return string
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * Set actvise
     *
     * @param string $actvise
     *
     * @return User
     */
    public function setActvise($actvise)
    {
        $this->actvise = $actvise;

        return $this;
    }

    /**
     * Get actvise
     *
     * @return string
     */
    public function getActvise()
    {
        return $this->actvise;
    }

    /**
     * Set credits
     *
     * @param integer $credits
     *
     * @return User
     */
    public function setCredits($credits)
    {
        $this->credits = $credits;

        return $this;
    }

    /**
     * Get credits
     *
     * @return integer
     */
    public function getCredits()
    {
        return $this->credits;
    }

    /**
     * Set note
     *
     * @param integer $note
     *
     * @return User
     */
    public function setNote($note)
    {
        $this->note = $note;

        return $this;
    }

    /**
     * Get note
     *
     * @return integer
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * Set point
     *
     * @param integer $point
     *
     * @return User
     */
    public function setPoint($point)
    {
        $this->point = $point;

        return $this;
    }

    /**
     * Get point
     *
     * @return integer
     */
    public function getPoint()
    {
        return $this->point;
    }

    /**
     * Set plein
     *
     * @param integer $plein
     *
     * @return User
     */
    public function setPlein($plein)
    {
        $this->plein = $plein;

        return $this;
    }

    /**
     * Get plein
     *
     * @return integer
     */
    public function getPlein()
    {
        return $this->plein;
    }

    /**
     * Set actconnexes
     *
     * @param string $actconnexes
     *
     * @return User
     */
    public function setActconnexes($actconnexes)
    {
        $this->actconnexes = $actconnexes;

        return $this;
    }

    /**
     * Get actconnexes
     *
     * @return string
     */
    public function getActconnexes()
    {
        return $this->actconnexes;
    }

    /**
     * Set parrain
     *
     * @param string $parrain
     *
     * @return User
     */
    public function setParrain($parrain)
    {
        $this->parrain = $parrain;

        return $this;
    }

    /**
     * Get parrain
     *
     * @return string
     */
    public function getParrain()
    {
        return $this->parrain;
    }

    /**
     * Set typeuser
     *
     * @param string $typeuser
     *
     * @return User
     */
    public function setTypeuser($typeuser)
    {
        $this->typeuser = $typeuser;

        return $this;
    }

    /**
     * Get typeuser
     *
     * @return string
     */
    public function getTypeuser()
    {
        return $this->typeuser;
    }

    /**
     * Set usernomsociete
     *
     * @param string $usernomsociete
     *
     * @return User
     */
    public function setUsernomsociete($usernomsociete)
    {
        $this->usernomsociete = $usernomsociete;

        return $this;
    }

    /**
     * Get usernomsociete
     *
     * @return string
     */
    public function getUsernomsociete()
    {
        return $this->usernomsociete;
    }

    /**
     * Set nomrep
     *
     * @param string $nomrep
     *
     * @return User
     */
    public function setNomrep($nomrep)
    {
        $this->nomrep = $nomrep;

        return $this;
    }

    /**
     * Get nomrep
     *
     * @return string
     */
    public function getNomrep()
    {
        return $this->nomrep;
    }

    /**
     * Set typebacloo
     *
     * @param string $typebacloo
     *
     * @return User
     */
    public function setTypebacloo($typebacloo)
    {
        $this->typebacloo = $typebacloo;

        return $this;
    }

    /**
     * Get typebacloo
     *
     * @return string
     */
    public function getTypebacloo()
    {
        return $this->typebacloo;
    }

    /**
     * Set roleuser
     *
     * @param string $roleuser
     *
     * @return User
     */
    public function setRoleuser($roleuser)
    {
        $this->roleuser = $roleuser;

        return $this;
    }

    /**
     * Get roleuser
     *
     * @return string
     */
    public function getRoleuser()
    {
        return $this->roleuser;
    }

    /**
     * Set textaccueil
     *
     * @param string $textaccueil
     *
     * @return User
     */
    public function setTextaccueil($textaccueil)
    {
        $this->textaccueil = $textaccueil;

        return $this;
    }

    /**
     * Get textaccueil
     *
     * @return string
     */
    public function getTextaccueil()
    {
        return $this->textaccueil;
    }

    /**
     * Set fichelimit
     *
     * @param integer $fichelimit
     *
     * @return User
     */
    public function setFichelimit($fichelimit)
    {
        $this->fichelimit = $fichelimit;

        return $this;
    }

    /**
     * Get fichelimit
     *
     * @return integer
     */
    public function getFichelimit()
    {
        return $this->fichelimit;
    }

    /**
     * Set logged
     *
     * @param string $logged
     *
     * @return User
     */
    public function setLogged($logged)
    {
        $this->logged = $logged;

        return $this;
    }

    /**
     * Get logged
     *
     * @return string
     */
    public function getLogged()
    {
        return $this->logged;
    }

    /**
     * Set adresse1
     *
     * @param string $adresse1
     *
     * @return User
     */
    public function setAdresse1($adresse1)
    {
        $this->adresse1 = $adresse1;

        return $this;
    }

    /**
     * Get adresse1
     *
     * @return string
     */
    public function getAdresse1()
    {
        return $this->adresse1;
    }

    /**
     * Set telephone
     *
     * @param string $telephone
     *
     * @return User
     */
    public function setTelephone($telephone)
    {
        $this->telephone = $telephone;

        return $this;
    }

    /**
     * Get telephone
     *
     * @return string
     */
    public function getTelephone()
    {
        return $this->telephone;
    }

    /**
     * Set cp
     *
     * @param string $cp
     *
     * @return User
     */
    public function setCp($cp)
    {
        $this->cp = $cp;

        return $this;
    }

    /**
     * Get cp
     *
     * @return string
     */
    public function getCp()
    {
        return $this->cp;
    }

    /**
     * Set cpuser
     *
     * @param string $cpuser
     *
     * @return User
     */
    public function setCpuser($cpuser)
    {
        $this->cpuser = $cpuser;

        return $this;
    }

    /**
     * Get cpuser
     *
     * @return string
     */
    public function getCpuser()
    {
        return $this->cpuser;
    }

    /**
     * Set chargeId
     *
     * @param string $chargeId
     *
     * @return User
     */
    public function setChargeId($chargeId)
    {
        $this->chargeId = $chargeId;

        return $this;
    }

    /**
     * Get chargeId
     *
     * @return string
     */
    public function getChargeId()
    {
        return $this->chargeId;
    }

    /**
     * Set stripeid
     *
     * @param string $stripeid
     *
     * @return User
     */
    public function setStripeid($stripeid)
    {
        $this->stripeid = $stripeid;

        return $this;
    }

    /**
     * Get stripeid
     *
     * @return string
     */
    public function getStripeid()
    {
        return $this->stripeid;
    }

    /**
     * Set premium
     *
     * @param integer $premium
     *
     * @return User
     */
    public function setPremium($premium)
    {
        $this->premium = $premium;

        return $this;
    }

    /**
     * Get premium
     *
     * @return integer
     */
    public function getPremium()
    {
        return $this->premium;
    }

    /**
     * Set datepremium
     *
     * @param string $datepremium
     *
     * @return User
     */
    public function setDatepremium($datepremium)
    {
        $this->datepremium = $datepremium;

        return $this;
    }

    /**
     * Get datepremium
     *
     * @return string
     */
    public function getDatepremium()
    {
        return $this->datepremium;
    }

    /**
     * Set finpremium
     *
     * @param string $finpremium
     *
     * @return User
     */
    public function setFinpremium($finpremium)
    {
        $this->finpremium = $finpremium;

        return $this;
    }

    /**
     * Get finpremium
     *
     * @return string
     */
    public function getFinpremium()
    {
        return $this->finpremium;
    }
}
