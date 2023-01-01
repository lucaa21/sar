<?php

namespace Bacloo\CrmBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Missions
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Missions
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
     * @ORM\Column(name="codepostal", type="string", length=255)
     */
    private $codepostal;

    /**
     * @var string
     *
     * @ORM\Column(name="ville", type="string", length=255)
     */
    private $ville;

    /**
     * @var string
     *
     * @ORM\Column(name="raisonsociale", type="string", length=255)
     */
    private $raisonsociale;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="dresscode", type="string", length=255)
     */
    private $dresscode;

    /**
     * @var integer
     *
     * @ORM\Column(name="agenceid", type="integer")
     */
    private $agenceid;

    /**
     * @var integer
     *
     * @ORM\Column(name="urgent", type="integer")
     */
    private $urgent;

    /**
     * @var integer
     *
     * @ORM\Column(name="nbaccepte", type="integer", nullable=true)
     */
    private $nbaccepte;


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
     * @return Missions
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
     * @return Missions
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
     * @return Missions
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
     * @return Missions
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
     * @return Missions
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
     * @return Missions
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
     * @return Missions
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
     * @return Missions
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
     * @return Missions
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
     * @param integer $agenceid
     *
     * @return Missions
     */
    public function setAgenceid($agenceid)
    {
        $this->agenceid = $agenceid;

        return $this;
    }

    /**
     * Get agenceid
     *
     * @return integer
     */
    public function getAgenceid()
    {
        return $this->agenceid;
    }

    /**
     * Set urgent
     *
     * @param integer $urgent
     *
     * @return Missions
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
     * Set nbaccepte
     *
     * @param integer $nbaccepte
     *
     * @return Missions
     */
    public function setNbaccepte($nbaccepte)
    {
        $this->nbaccepte = $nbaccepte;

        return $this;
    }

    /**
     * Get nbaccepte
     *
     * @return integer
     */
    public function getNbaccepte()
    {
        return $this->nbaccepte;
    }
}
