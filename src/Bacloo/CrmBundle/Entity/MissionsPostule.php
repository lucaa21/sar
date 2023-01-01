<?php

namespace Bacloo\CrmBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MissionsPostule
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class MissionsPostule
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
     * @ORM\Column(name="titre", type="string", length=255)
     */
    private $titre;

    /**
     * @var string
     *
     * @ORM\Column(name="datedebut", type="string", length=255)
     */
    private $datedebut;

    /**
     * @var string
     *
     * @ORM\Column(name="datefin", type="string", length=255)
     */
    private $datefin;

    /**
     * @var string
     *
     * @ORM\Column(name="adresse", type="string", length=255)
     */
    private $adresse;

    /**
     * @var string
     *
     * @ORM\Column(name="codepostal", type="string", length=255, nullable=true)
     */
    private $codepostal;

    /**
     * @var string
     *
     * @ORM\Column(name="ville", type="string", length=255, nullable=true)
     */
    private $ville;

    /**
     * @var string
     *
     * @ORM\Column(name="raisonsociale", type="string", length=255, nullable=true)
     */
    private $raisonsociale;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="dresscode", type="string", length=255, nullable=true)
     */
    private $dresscode;

    /**
     * @var string
     *
     * @ORM\Column(name="agenceid", type="string", length=255, nullable=true)
     */
    private $agenceid;

    /**
     * @var integer
     *
     * @ORM\Column(name="profilid", type="integer")
     */
    private $profilid;

    /**
     * @var boolean
     *
     * @ORM\Column(name="postule", type="boolean")
     */
    private $postule;

    /**
     * @var boolean
     *
     * @ORM\Column(name="accepte", type="boolean")
     */
    private $accepte;

    /**
     * @var boolean
     *
     * @ORM\Column(name="refuse", type="boolean")
     */
    private $refuse;

    /**
     * @var boolean
     *
     * @ORM\Column(name="urgent", type="boolean")
     */
    private $urgent;

    /**
     * @var string
     *
     * @ORM\Column(name="missionid", type="string", length=255, nullable=true)
     */
    private $missionid;


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
     * Set titre
     *
     * @param string $titre
     *
     * @return MissionsPostule
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;

        return $this;
    }

    /**
     * Get titre
     *
     * @return string
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * Set datedebut
     *
     * @param string $datedebut
     *
     * @return MissionsPostule
     */
    public function setDatedebut($datedebut)
    {
        $this->datedebut = $datedebut;

        return $this;
    }

    /**
     * Get datedebut
     *
     * @return string
     */
    public function getDatedebut()
    {
        return $this->datedebut;
    }

    /**
     * Set datefin
     *
     * @param string $datefin
     *
     * @return MissionsPostule
     */
    public function setDatefin($datefin)
    {
        $this->datefin = $datefin;

        return $this;
    }

    /**
     * Get datefin
     *
     * @return string
     */
    public function getDatefin()
    {
        return $this->datefin;
    }

    /**
     * Set adresse
     *
     * @param string $adresse
     *
     * @return MissionsPostule
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
     * @return MissionsPostule
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
     * @return MissionsPostule
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
     * Set raisonsociale
     *
     * @param string $raisonsociale
     *
     * @return MissionsPostule
     */
    public function setRaisonsociale($raisonsociale)
    {
        $this->raisonsociale = $raisonsociale;

        return $this;
    }

    /**
     * Get raisonsociale
     *
     * @return string
     */
    public function getRaisonsociale()
    {
        return $this->raisonsociale;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return MissionsPostule
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
     * Set dresscode
     *
     * @param string $dresscode
     *
     * @return MissionsPostule
     */
    public function setDresscode($dresscode)
    {
        $this->dresscode = $dresscode;

        return $this;
    }

    /**
     * Get dresscode
     *
     * @return string
     */
    public function getDresscode()
    {
        return $this->dresscode;
    }

    /**
     * Set agenceid
     *
     * @param string $agenceid
     *
     * @return MissionsPostule
     */
    public function setAgenceid($agenceid)
    {
        $this->agenceid = $agenceid;

        return $this;
    }

    /**
     * Get agenceid
     *
     * @return string
     */
    public function getAgenceid()
    {
        return $this->agenceid;
    }

    /**
     * Set profilid
     *
     * @param string $profilid
     *
     * @return MissionsPostule
     */
    public function setProfilid($profilid)
    {
        $this->profilid = $profilid;

        return $this;
    }

    /**
     * Get profilid
     *
     * @return string
     */
    public function getProfilid()
    {
        return $this->profilid;
    }

    /**
     * Set postule
     *
     * @param integer $postule
     *
     * @return MissionsPostule
     */
    public function setPostule($postule)
    {
        $this->postule = $postule;

        return $this;
    }

    /**
     * Get postule
     *
     * @return integer
     */
    public function getPostule()
    {
        return $this->postule;
    }

    /**
     * Set accepte
     *
     * @param integer $accepte
     *
     * @return MissionsPostule
     */
    public function setAccepte($accepte)
    {
        $this->accepte = $accepte;

        return $this;
    }

    /**
     * Get accepte
     *
     * @return integer
     */
    public function getAccepte()
    {
        return $this->accepte;
    }

    /**
     * Set refuse
     *
     * @param integer $refuse
     *
     * @return MissionsPostule
     */
    public function setRefuse($refuse)
    {
        $this->refuse = $refuse;

        return $this;
    }

    /**
     * Get refuse
     *
     * @return integer
     */
    public function getRefuse()
    {
        return $this->refuse;
    }

    /**
     * Set urgent
     *
     * @param integer $urgent
     *
     * @return MissionsPostule
     */
    public function setUrgent($urgent)
    {
        $this->urgent = $urgent;

        return $this;
    }

    /**
     * Get urgent
     *
     * @return integer
     */
    public function getUrgent()
    {
        return $this->urgent;
    }

    /**
     * Set missionid
     *
     * @param string $missionid
     *
     * @return MissionsPostule
     */
    public function setMissionid($missionid)
    {
        $this->missionid = $missionid;

        return $this;
    }

    /**
     * Get missionid
     *
     * @return string
     */
    public function getMissionid()
    {
        return $this->missionid;
    }
}
