<?php

namespace Bacloo\CrmBundle\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Fiche
 * @ORM\Entity
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Bacloo\CrmBundle\Entity\FicheRepository")
 */
class Fiche
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="raison_sociale", type="string", length=255)
     */
    private $raisonSociale;

    /**
     * @var string
     *
     * @ORM\Column(name="adresse1", type="string", length=255, nullable=true)
     */
    private $adresse1;

    /**
     * @var string
     *
     * @ORM\Column(name="adresse2", type="string", length=255, nullable=true)
     */
    private $adresse2;

    /**
     * @var string
     *
     * @ORM\Column(name="adresse3", type="string", length=255, nullable=true)
     */
    private $adresse3;

    /**
     * @var string
     *
     * @ORM\Column(name="cp", type="string", length=255, nullable=true)
     */
    private $cp;

    /**
     * @var string
     *
     * @ORM\Column(name="ville", type="string", length=255, nullable=true)
     */
    private $ville;

    /**
     * @var string
     *
     * @ORM\Column(name="telephone", type="string", length=255, nullable=true)
     */
    private $telephone;

    /**
     * @var string
     *
     * @ORM\Column(name="fax", type="string", length=255, nullable=true)
     */
    private $fax;

    /**
     * @var string
     *
     * @ORM\Column(name="site_web", type="string", length=255, nullable=true)
     */
    private $siteWeb;

    /**
     * @var string
     *
     * @ORM\Column(name="user", type="string", length=255, nullable=true)
     */
    private $user;
	
    /**
     * @var string
     *
     * @ORM\Column(name="tags", type="string", length=255, nullable=true)
     */
    private $tags;

    /**
     * @var string
     *
     * @ORM\Column(name="activite", type="string", length=255, nullable=true)
     */
    private $activite;		

    /**
     * @var string
     *
     * @ORM\Column(name="a_vendre", type="boolean", length=255, nullable=true)
     */
    private $aVendre;

    /**
     * @var integer
     *
     * @ORM\Column(name="prixsscont", type="integer", nullable=true)
     */
    private $prixsscont;

    /**
     * @var integer
     *
     * @ORM\Column(name="prixavcont", type="integer", nullable=true)
     */
    private $prixavcont;

    /**
     * @var integer
     *
     * @ORM\Column(name="potentiel", type="integer", nullable=true)
     */
    private $potentiel;
	
    /**
     * @var string
     *
     * @ORM\Column(name="a_vendrec", type="boolean", length=255, nullable=true)
     */
    private $aVendrec;

    /**
     * @var string
     *
     * @ORM\Column(name="assurance", type="boolean", length=255, nullable=true)
     */
    private $assurance;

    /**
     * @var string
     *
     * @ORM\Column(name="statutcompte", type="boolean", length=255, nullable=true)
     */
    private $statutcompte;

    /**
     * @var string
     *
     * @ORM\Column(name="copyof", type="string", length=255, nullable=true)
     */
    private $copyof;

    /**
     * @var string
     *
     * @ORM\Column(name="compteurfiche", type="string", length=255, nullable=true)
     */
    private $compteurfiche;

    /**
     * @var decimal
     *
     * @ORM\Column(name="soldeimpayes", type="decimal", precision=12, scale=2, nullable=true)
     */
    private $soldeimpayes;

    /**
     * @var string
     *
     * @ORM\Column(name="nomartisan", type="string", length=255, nullable=true)
     */
    private $nomartisan;
	
    /**
     * @var string
     *
     * @ORM\Column(name="descbesoins", type="text", nullable=true)
     */
    private $descbesoins;
	
    /**
     * @var string
     *
     * @ORM\Column(name="useremail", type="text", nullable=true)
     */
    private $useremail;
	
    /**
     * @var string
     *
     * @ORM\Column(name="typefiche", type="text", nullable=true)
     */
    private $typefiche;
	
    /**
     * @var string
     *
     * @ORM\Column(name="typeclient", type="text", nullable=true)
     */
    private $typeclient;
	
    /**
     * @var string
     *
     * @ORM\Column(name="usersociete", type="text", nullable=true)
     */
    private $usersociete;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="lastmodif", type="date", nullable=true)
     */
    private $lastmodif;
	
    /**
     * @var string
     *
     * @ORM\Column(name="cperso1", type="text", nullable=true)
     */
    private $cperso1;
	
    /**
     * @var string
     *
     * @ORM\Column(name="cperso2", type="text", nullable=true)
     */
    private $cperso2;
	
    /**
     * @var string
     *
     * @ORM\Column(name="cperso3", type="text", nullable=true)
     */
    private $cperso3;

    /**
     * @var string
     *
     * @ORM\Column(name="delaireglement", type="string", length=255, nullable=true)
     */
    private $delaireglement;

    /**
     * @var decimal
     *
     * @ORM\Column(name="encours", type="decimal", precision=12, scale=2, nullable=true)
     */
    private $encours;

    /**
     * @var string
     *
     * @ORM\Column(name="chequeencoffre", type="boolean", length=255, nullable=true)
     */
    private $chequeencoffre;

    /**
     * @var integer
     *
     * @ORM\Column(name="montantcheque", type="integer", length=255, nullable=true)
     */
    private $montantcheque;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datedepot", type="string", length=255, nullable=true)
     */
    private $datedepot;

    /**
     * @var string
     *
     * @ORM\Column(name="raisonblocage", type="string", length=255, nullable=true)
     */
    private $raisonblocage;

    /**
     * @var decimal
     *
     * @ORM\Column(name="montantrc", type="decimal", precision=12, scale=2, nullable=true)
     */
    Public $montantrc;

    /**
     * @var decimal
     *
     * @ORM\Column(name="montanteco", type="decimal", precision=12, scale=2, nullable=true)
     */
    Public $montanteco;

    /**
     * @var string
     *
     * @ORM\Column(name="uniterc", type="string", length=255, nullable=true)
     */
    private $uniterc;

    /**
     * @var string
     *
     * @ORM\Column(name="uniteeco", type="string", length=255, nullable=true)
     */
    private $uniteeco;

    /**
     * @var string
     *
     * @ORM\Column(name="basecalculrc", type="string", length=255, nullable=true)
     */
    private $basecalculrc;

    /**
     * @var string
     *
     * @ORM\Column(name="basecalculeco", type="string", length=255, nullable=true)
     */
    private $basecalculeco;

    /**
     * @var string
     *
     * @ORM\Column(name="frsrc", type="boolean", length=255, nullable=true)
     */
    private $frsrc;

    /**
     * @var string
     *
     * @ORM\Column(name="frseco", type="boolean", length=255, nullable=true)
     */
    private $frseco;

    /**
     * @var string
     *
     * @ORM\Column(name="newid", type="string", length=255, nullable=true)
	 */
    private $newid;
    /**
     * @var string
     *
     * @ORM\Column(name="delaipaiement", type="string", length=255, nullable=true)
     */
    private $delaipaiement;

    /**
     * @var string
     *
     * @ORM\Column(name="typepaiement", type="string", length=255, nullable=true)
     */
    private $typepaiement;

    /**
     * @var string
     *
     * @ORM\Column(name="dureemoypaiement", type="string", length=255, nullable=true)
     */
    private $dureemoypaiement;

    /**
     * @var string
     *
     * @ORM\Column(name="typedebien", type="string", length=255, nullable=true)
     */
    private $typedebien;

    /**
     * @var string
     *
     * @ORM\Column(name="debuttravaux", type="string", nullable=true)
     */
    Public $debuttravaux;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="civilite", type="string", length=255, nullable=true)
     */
    private $civilite;

    /**
     * @var string
     *
     * @ORM\Column(name="prenom", type="string", length=255, nullable=true)
     */
    private $prenom;

    /**
     * @var string
     *
     * @ORM\Column(name="detail1", type="string", length=255, nullable=true)
     */
    private $detail1;

    /**
     * @var string
     *
     * @ORM\Column(name="typepersonne", type="string", length=255, nullable=true)
     */
    private $typepersonne;

    /**
     * @var string
     *
     * @ORM\Column(name="cleapi", type="string", length=255, nullable=true)
     */
    private $cleapi;

    /**
     * @var integer
     *
     * @ORM\Column(name="categorieid", type="integer", length=255, nullable=true)
     */
    private $categorieid;

    /**
     * @var string
     *
     * @ORM\Column(name="typedemandeur", type="string", length=255, nullable=true)
     */
    private $typedemandeur;

    /**
     * @var integer
     *
     * @ORM\Column(name="nbacheteur", type="integer", nullable=true)
     */
    private $nbacheteur;

    /**
     * @var integer
     *
     * @ORM\Column(name="nbacheteurexclusif", type="integer", nullable=true)
     */
    private $nbacheteurexclusif;

    /**
     * @var integer
     *
     * @ORM\Column(name="nbachatvite1devis", type="integer", nullable=true)
     */
    private $nbachatvite1devis;

    /**
     * @var integer
     *
     * @ORM\Column(name="exclusif", type="integer", length=1, nullable=true)
     */
    private $exclusif;

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
     * Constructor
     */
    public function __construct()
    {

    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set raisonSociale
     *
     * @param string $raisonSociale
     *
     * @return Fiche
     */
    public function setRaisonSociale($raisonSociale)
    {
        $this->raisonSociale = $raisonSociale;

        return $this;
    }

    /**
     * Get raisonSociale
     *
     * @return string
     */
    public function getRaisonSociale()
    {
        return $this->raisonSociale;
    }

    /**
     * Set adresse1
     *
     * @param string $adresse1
     *
     * @return Fiche
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
     * Set adresse2
     *
     * @param string $adresse2
     *
     * @return Fiche
     */
    public function setAdresse2($adresse2)
    {
        $this->adresse2 = $adresse2;

        return $this;
    }

    /**
     * Get adresse2
     *
     * @return string
     */
    public function getAdresse2()
    {
        return $this->adresse2;
    }

    /**
     * Set adresse3
     *
     * @param string $adresse3
     *
     * @return Fiche
     */
    public function setAdresse3($adresse3)
    {
        $this->adresse3 = $adresse3;

        return $this;
    }

    /**
     * Get adresse3
     *
     * @return string
     */
    public function getAdresse3()
    {
        return $this->adresse3;
    }

    /**
     * Set cp
     *
     * @param string $cp
     *
     * @return Fiche
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
     * Set ville
     *
     * @param string $ville
     *
     * @return Fiche
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
     * Set telephone
     *
     * @param string $telephone
     *
     * @return Fiche
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
     * Set fax
     *
     * @param string $fax
     *
     * @return Fiche
     */
    public function setFax($fax)
    {
        $this->fax = $fax;

        return $this;
    }

    /**
     * Get fax
     *
     * @return string
     */
    public function getFax()
    {
        return $this->fax;
    }

    /**
     * Set siteWeb
     *
     * @param string $siteWeb
     *
     * @return Fiche
     */
    public function setSiteWeb($siteWeb)
    {
        $this->siteWeb = $siteWeb;

        return $this;
    }

    /**
     * Get siteWeb
     *
     * @return string
     */
    public function getSiteWeb()
    {
        return $this->siteWeb;
    }

    /**
     * Set user
     *
     * @param string $user
     *
     * @return Fiche
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return string
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set tags
     *
     * @param string $tags
     *
     * @return Fiche
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
     * Set activite
     *
     * @param string $activite
     *
     * @return Fiche
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
     * Set aVendre
     *
     * @param boolean $aVendre
     *
     * @return Fiche
     */
    public function setAVendre($aVendre)
    {
        $this->aVendre = $aVendre;

        return $this;
    }

    /**
     * Get aVendre
     *
     * @return boolean
     */
    public function getAVendre()
    {
        return $this->aVendre;
    }

    /**
     * Set prixsscont
     *
     * @param integer $prixsscont
     *
     * @return Fiche
     */
    public function setPrixsscont($prixsscont)
    {
        $this->prixsscont = $prixsscont;

        return $this;
    }

    /**
     * Get prixsscont
     *
     * @return integer
     */
    public function getPrixsscont()
    {
        return $this->prixsscont;
    }

    /**
     * Set prixavcont
     *
     * @param integer $prixavcont
     *
     * @return Fiche
     */
    public function setPrixavcont($prixavcont)
    {
        $this->prixavcont = $prixavcont;

        return $this;
    }

    /**
     * Get prixavcont
     *
     * @return integer
     */
    public function getPrixavcont()
    {
        return $this->prixavcont;
    }

    /**
     * Set potentiel
     *
     * @param integer $potentiel
     *
     * @return Fiche
     */
    public function setPotentiel($potentiel)
    {
        $this->potentiel = $potentiel;

        return $this;
    }

    /**
     * Get potentiel
     *
     * @return integer
     */
    public function getPotentiel()
    {
        return $this->potentiel;
    }

    /**
     * Set aVendrec
     *
     * @param boolean $aVendrec
     *
     * @return Fiche
     */
    public function setAVendrec($aVendrec)
    {
        $this->aVendrec = $aVendrec;

        return $this;
    }

    /**
     * Get aVendrec
     *
     * @return boolean
     */
    public function getAVendrec()
    {
        return $this->aVendrec;
    }

    /**
     * Set assurance
     *
     * @param boolean $assurance
     *
     * @return Fiche
     */
    public function setAssurance($assurance)
    {
        $this->assurance = $assurance;

        return $this;
    }

    /**
     * Get assurance
     *
     * @return boolean
     */
    public function getAssurance()
    {
        return $this->assurance;
    }

    /**
     * Set statutcompte
     *
     * @param boolean $statutcompte
     *
     * @return Fiche
     */
    public function setStatutcompte($statutcompte)
    {
        $this->statutcompte = $statutcompte;

        return $this;
    }

    /**
     * Get statutcompte
     *
     * @return boolean
     */
    public function getStatutcompte()
    {
        return $this->statutcompte;
    }

    /**
     * Set copyof
     *
     * @param string $copyof
     *
     * @return Fiche
     */
    public function setCopyof($copyof)
    {
        $this->copyof = $copyof;

        return $this;
    }

    /**
     * Get copyof
     *
     * @return string
     */
    public function getCopyof()
    {
        return $this->copyof;
    }

    /**
     * Set compteurfiche
     *
     * @param string $compteurfiche
     *
     * @return Fiche
     */
    public function setCompteurfiche($compteurfiche)
    {
        $this->compteurfiche = $compteurfiche;

        return $this;
    }

    /**
     * Get compteurfiche
     *
     * @return string
     */
    public function getCompteurfiche()
    {
        return $this->compteurfiche;
    }

    /**
     * Set soldeimpayes
     *
     * @param string $soldeimpayes
     *
     * @return Fiche
     */
    public function setSoldeimpayes($soldeimpayes)
    {
        $this->soldeimpayes = $soldeimpayes;

        return $this;
    }

    /**
     * Get soldeimpayes
     *
     * @return string
     */
    public function getSoldeimpayes()
    {
        return $this->soldeimpayes;
    }

    /**
     * Set descbesoins
     *
     * @param string $descbesoins
     *
     * @return Fiche
     */
    public function setDescbesoins($descbesoins)
    {
        $this->descbesoins = $descbesoins;

        return $this;
    }

    /**
     * Get descbesoins
     *
     * @return string
     */
    public function getDescbesoins()
    {
        return $this->descbesoins;
    }

    /**
     * Set useremail
     *
     * @param string $useremail
     *
     * @return Fiche
     */
    public function setUseremail($useremail)
    {
        $this->useremail = $useremail;

        return $this;
    }

    /**
     * Get useremail
     *
     * @return string
     */
    public function getUseremail()
    {
        return $this->useremail;
    }

    /**
     * Set typefiche
     *
     * @param string $typefiche
     *
     * @return Fiche
     */
    public function setTypefiche($typefiche)
    {
        $this->typefiche = $typefiche;

        return $this;
    }

    /**
     * Get typefiche
     *
     * @return string
     */
    public function getTypefiche()
    {
        return $this->typefiche;
    }

    /**
     * Set typeclient
     *
     * @param string $typeclient
     *
     * @return Fiche
     */
    public function setTypeclient($typeclient)
    {
        $this->typeclient = $typeclient;

        return $this;
    }

    /**
     * Get typeclient
     *
     * @return string
     */
    public function getTypeclient()
    {
        return $this->typeclient;
    }

    /**
     * Set usersociete
     *
     * @param string $usersociete
     *
     * @return Fiche
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
     * Set lastmodif
     *
     * @param \DateTime $lastmodif
     *
     * @return Fiche
     */
    public function setLastmodif($lastmodif)
    {
        $this->lastmodif = $lastmodif;

        return $this;
    }

    /**
     * Get lastmodif
     *
     * @return \DateTime
     */
    public function getLastmodif()
    {
        return $this->lastmodif;
    }

    /**
     * Set cperso1
     *
     * @param string $cperso1
     *
     * @return Fiche
     */
    public function setCperso1($cperso1)
    {
        $this->cperso1 = $cperso1;

        return $this;
    }

    /**
     * Get cperso1
     *
     * @return string
     */
    public function getCperso1()
    {
        return $this->cperso1;
    }

    /**
     * Set cperso2
     *
     * @param string $cperso2
     *
     * @return Fiche
     */
    public function setCperso2($cperso2)
    {
        $this->cperso2 = $cperso2;

        return $this;
    }

    /**
     * Get cperso2
     *
     * @return string
     */
    public function getCperso2()
    {
        return $this->cperso2;
    }

    /**
     * Set cperso3
     *
     * @param string $cperso3
     *
     * @return Fiche
     */
    public function setCperso3($cperso3)
    {
        $this->cperso3 = $cperso3;

        return $this;
    }

    /**
     * Get cperso3
     *
     * @return string
     */
    public function getCperso3()
    {
        return $this->cperso3;
    }

    /**
     * Set delaireglement
     *
     * @param string $delaireglement
     *
     * @return Fiche
     */
    public function setDelaireglement($delaireglement)
    {
        $this->delaireglement = $delaireglement;

        return $this;
    }

    /**
     * Get delaireglement
     *
     * @return string
     */
    public function getDelaireglement()
    {
        return $this->delaireglement;
    }

    /**
     * Set encours
     *
     * @param string $encours
     *
     * @return Fiche
     */
    public function setEncours($encours)
    {
        $this->encours = $encours;

        return $this;
    }

    /**
     * Get encours
     *
     * @return string
     */
    public function getEncours()
    {
        return $this->encours;
    }

    /**
     * Set chequeencoffre
     *
     * @param boolean $chequeencoffre
     *
     * @return Fiche
     */
    public function setChequeencoffre($chequeencoffre)
    {
        $this->chequeencoffre = $chequeencoffre;

        return $this;
    }

    /**
     * Get chequeencoffre
     *
     * @return boolean
     */
    public function getChequeencoffre()
    {
        return $this->chequeencoffre;
    }

    /**
     * Set montantcheque
     *
     * @param integer $montantcheque
     *
     * @return Fiche
     */
    public function setMontantcheque($montantcheque)
    {
        $this->montantcheque = $montantcheque;

        return $this;
    }

    /**
     * Get montantcheque
     *
     * @return integer
     */
    public function getMontantcheque()
    {
        return $this->montantcheque;
    }

    /**
     * Set datedepot
     *
     * @param string $datedepot
     *
     * @return Fiche
     */
    public function setDatedepot($datedepot)
    {
        $this->datedepot = $datedepot;

        return $this;
    }

    /**
     * Get datedepot
     *
     * @return string
     */
    public function getDatedepot()
    {
        return $this->datedepot;
    }

    /**
     * Set raisonblocage
     *
     * @param string $raisonblocage
     *
     * @return Fiche
     */
    public function setRaisonblocage($raisonblocage)
    {
        $this->raisonblocage = $raisonblocage;

        return $this;
    }

    /**
     * Get raisonblocage
     *
     * @return string
     */
    public function getRaisonblocage()
    {
        return $this->raisonblocage;
    }

    /**
     * Set montantrc
     *
     * @param string $montantrc
     *
     * @return Fiche
     */
    public function setMontantrc($montantrc)
    {
        $this->montantrc = $montantrc;

        return $this;
    }

    /**
     * Get montantrc
     *
     * @return string
     */
    public function getMontantrc()
    {
        return $this->montantrc;
    }

    /**
     * Set montanteco
     *
     * @param string $montanteco
     *
     * @return Fiche
     */
    public function setMontanteco($montanteco)
    {
        $this->montanteco = $montanteco;

        return $this;
    }

    /**
     * Get montanteco
     *
     * @return string
     */
    public function getMontanteco()
    {
        return $this->montanteco;
    }

    /**
     * Set uniterc
     *
     * @param string $uniterc
     *
     * @return Fiche
     */
    public function setUniterc($uniterc)
    {
        $this->uniterc = $uniterc;

        return $this;
    }

    /**
     * Get uniterc
     *
     * @return string
     */
    public function getUniterc()
    {
        return $this->uniterc;
    }

    /**
     * Set uniteeco
     *
     * @param string $uniteeco
     *
     * @return Fiche
     */
    public function setUniteeco($uniteeco)
    {
        $this->uniteeco = $uniteeco;

        return $this;
    }

    /**
     * Get uniteeco
     *
     * @return string
     */
    public function getUniteeco()
    {
        return $this->uniteeco;
    }

    /**
     * Set basecalculrc
     *
     * @param string $basecalculrc
     *
     * @return Fiche
     */
    public function setBasecalculrc($basecalculrc)
    {
        $this->basecalculrc = $basecalculrc;

        return $this;
    }

    /**
     * Get basecalculrc
     *
     * @return string
     */
    public function getBasecalculrc()
    {
        return $this->basecalculrc;
    }

    /**
     * Set basecalculeco
     *
     * @param string $basecalculeco
     *
     * @return Fiche
     */
    public function setBasecalculeco($basecalculeco)
    {
        $this->basecalculeco = $basecalculeco;

        return $this;
    }

    /**
     * Get basecalculeco
     *
     * @return string
     */
    public function getBasecalculeco()
    {
        return $this->basecalculeco;
    }

    /**
     * Set frsrc
     *
     * @param boolean $frsrc
     *
     * @return Fiche
     */
    public function setFrsrc($frsrc)
    {
        $this->frsrc = $frsrc;

        return $this;
    }

    /**
     * Get frsrc
     *
     * @return boolean
     */
    public function getFrsrc()
    {
        return $this->frsrc;
    }

    /**
     * Set frseco
     *
     * @param boolean $frseco
     *
     * @return Fiche
     */
    public function setFrseco($frseco)
    {
        $this->frseco = $frseco;

        return $this;
    }

    /**
     * Get frseco
     *
     * @return boolean
     */
    public function getFrseco()
    {
        return $this->frseco;
    }

    /**
     * Set newid
     *
     * @param string $newid
     *
     * @return Fiche
     */
    public function setNewid($newid)
    {
        $this->newid = $newid;

        return $this;
    }

    /**
     * Get newid
     *
     * @return string
     */
    public function getNewid()
    {
        return $this->newid;
    }

    /**
     * Set delaipaiement
     *
     * @param string $delaipaiement
     *
     * @return Fiche
     */
    public function setDelaipaiement($delaipaiement)
    {
        $this->delaipaiement = $delaipaiement;

        return $this;
    }

    /**
     * Get delaipaiement
     *
     * @return string
     */
    public function getDelaipaiement()
    {
        return $this->delaipaiement;
    }

    /**
     * Set typepaiement
     *
     * @param string $typepaiement
     *
     * @return Fiche
     */
    public function setTypepaiement($typepaiement)
    {
        $this->typepaiement = $typepaiement;

        return $this;
    }

    /**
     * Get typepaiement
     *
     * @return string
     */
    public function getTypepaiement()
    {
        return $this->typepaiement;
    }

    /**
     * Set dureemoypaiement
     *
     * @param string $dureemoypaiement
     *
     * @return Fiche
     */
    public function setDureemoypaiement($dureemoypaiement)
    {
        $this->dureemoypaiement = $dureemoypaiement;

        return $this;
    }

    /**
     * Get dureemoypaiement
     *
     * @return string
     */
    public function getDureemoypaiement()
    {
        return $this->dureemoypaiement;
    }

    /**
     * Set typedebien
     *
     * @param string $typedebien
     *
     * @return Fiche
     */
    public function setTypedebien($typedebien)
    {
        $this->typedebien = $typedebien;

        return $this;
    }

    /**
     * Get typedebien
     *
     * @return string
     */
    public function getTypedebien()
    {
        return $this->typedebien;
    }

    /**
     * Set debuttravaux
     *
     * @param string $debuttravaux
     *
     * @return Fiche
     */
    public function setDebuttravaux($debuttravaux)
    {
        $this->debuttravaux = $debuttravaux;

        return $this;
    }

    /**
     * Get debuttravaux
     *
     * @return string
     */
    public function getDebuttravaux()
    {
        return $this->debuttravaux;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Fiche
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set civilite
     *
     * @param string $civilite
     *
     * @return Fiche
     */
    public function setCivilite($civilite)
    {
        $this->civilite = $civilite;

        return $this;
    }

    /**
     * Get civilite
     *
     * @return string
     */
    public function getCivilite()
    {
        return $this->civilite;
    }

    /**
     * Set prenom
     *
     * @param string $prenom
     *
     * @return Fiche
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
     * Set detail1
     *
     * @param string $detail1
     *
     * @return Fiche
     */
    public function setDetail1($detail1)
    {
        $this->detail1 = $detail1;

        return $this;
    }

    /**
     * Get detail1
     *
     * @return string
     */
    public function getDetail1()
    {
        return $this->detail1;
    }

    /**
     * Set typepersonne
     *
     * @param string $typepersonne
     *
     * @return Fiche
     */
    public function setTypepersonne($typepersonne)
    {
        $this->typepersonne = $typepersonne;

        return $this;
    }

    /**
     * Get typepersonne
     *
     * @return string
     */
    public function getTypepersonne()
    {
        return $this->typepersonne;
    }

    /**
     * Set cleapi
     *
     * @param string $cleapi
     *
     * @return Fiche
     */
    public function setCleapi($cleapi)
    {
        $this->cleapi = $cleapi;

        return $this;
    }

    /**
     * Get cleapi
     *
     * @return string
     */
    public function getCleapi()
    {
        return $this->cleapi;
    }

    /**
     * Set categorieid
     *
     * @param integer $categorieid
     *
     * @return Fiche
     */
    public function setCategorieid($categorieid)
    {
        $this->categorieid = $categorieid;

        return $this;
    }

    /**
     * Get categorieid
     *
     * @return integer
     */
    public function getCategorieid()
    {
        return $this->categorieid;
    }

    /**
     * Set typedemandeur
     *
     * @param string $typedemandeur
     *
     * @return Fiche
     */
    public function setTypedemandeur($typedemandeur)
    {
        $this->typedemandeur = $typedemandeur;

        return $this;
    }

    /**
     * Get typedemandeur
     *
     * @return string
     */
    public function getTypedemandeur()
    {
        return $this->typedemandeur;
    }

    /**
     * Set nomartisan
     *
     * @param string $nomartisan
     *
     * @return Fiche
     */
    public function setNomartisan($nomartisan)
    {
        $this->nomartisan = $nomartisan;

        return $this;
    }

    /**
     * Get nomartisan
     *
     * @return string
     */
    public function getNomartisan()
    {
        return $this->nomartisan;
    }

    /**
     * Set exclusif
     *
     * @param integer $exclusif
     *
     * @return Fiche
     */
    public function setExclusif($exclusif)
    {
        $this->exclusif = $exclusif;

        return $this;
    }

    /**
     * Get exclusif
     *
     * @return integer
     */
    public function getExclusif()
    {
        return $this->exclusif;
    }

    /**
     * Set nbacheteur
     *
     * @param integer $nbacheteur
     *
     * @return Fiche
     */
    public function setNbacheteur($nbacheteur)
    {
        $this->nbacheteur = $nbacheteur;

        return $this;
    }

    /**
     * Get nbacheteur
     *
     * @return integer
     */
    public function getNbacheteur()
    {
        return $this->nbacheteur;
    }

    /**
     * Set nbacheteurexclusif
     *
     * @param integer $nbacheteurexclusif
     *
     * @return Fiche
     */
    public function setNbacheteurexclusif($nbacheteurexclusif)
    {
        $this->nbacheteurexclusif = $nbacheteurexclusif;

        return $this;
    }

    /**
     * Get nbacheteurexclusif
     *
     * @return integer
     */
    public function getNbacheteurexclusif()
    {
        return $this->nbacheteurexclusif;
    }

    /**
     * Set nbachatvite1devis
     *
     * @param integer $nbachatvite1devis
     *
     * @return Fiche
     */
    public function setNbachatvite1devis($nbachatvite1devis)
    {
        $this->nbachatvite1devis = $nbachatvite1devis;

        return $this;
    }

    /**
     * Get nbachatvite1devis
     *
     * @return integer
     */
    public function getNbachatvite1devis()
    {
        return $this->nbachatvite1devis;
    }

    /**
     * Set premium
     *
     * @param integer $premium
     *
     * @return Fiche
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
     * @param \DateTime $datepremium
     *
     * @return Fiche
     */
    public function setDatepremium($datepremium)
    {
        $this->datepremium = $datepremium;

        return $this;
    }

    /**
     * Get datepremium
     *
     * @return \DateTime
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
     * @return Fiche
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
