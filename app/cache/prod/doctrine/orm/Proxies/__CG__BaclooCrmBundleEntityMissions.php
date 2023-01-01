<?php

namespace Proxies\__CG__\Bacloo\CrmBundle\Entity;

/**
 * DO NOT EDIT THIS FILE - IT WAS CREATED BY DOCTRINE'S PROXY GENERATOR
 */
class Missions extends \Bacloo\CrmBundle\Entity\Missions implements \Doctrine\ORM\Proxy\Proxy
{
    /**
     * @var \Closure the callback responsible for loading properties in the proxy object. This callback is called with
     *      three parameters, being respectively the proxy object to be initialized, the method that triggered the
     *      initialization process and an array of ordered parameters that were passed to that method.
     *
     * @see \Doctrine\Common\Persistence\Proxy::__setInitializer
     */
    public $__initializer__;

    /**
     * @var \Closure the callback responsible of loading properties that need to be copied in the cloned object
     *
     * @see \Doctrine\Common\Persistence\Proxy::__setCloner
     */
    public $__cloner__;

    /**
     * @var boolean flag indicating if this object was already initialized
     *
     * @see \Doctrine\Common\Persistence\Proxy::__isInitialized
     */
    public $__isInitialized__ = false;

    /**
     * @var array properties to be lazy loaded, with keys being the property
     *            names and values being their default values
     *
     * @see \Doctrine\Common\Persistence\Proxy::__getLazyProperties
     */
    public static $lazyPropertiesDefaults = [];



    /**
     * @param \Closure $initializer
     * @param \Closure $cloner
     */
    public function __construct($initializer = null, $cloner = null)
    {

        $this->__initializer__ = $initializer;
        $this->__cloner__      = $cloner;
    }







    /**
     * 
     * @return array
     */
    public function __sleep()
    {
        if ($this->__isInitialized__) {
            return ['__isInitialized__', '' . "\0" . 'Bacloo\\CrmBundle\\Entity\\Missions' . "\0" . 'id', '' . "\0" . 'Bacloo\\CrmBundle\\Entity\\Missions' . "\0" . 'titre', '' . "\0" . 'Bacloo\\CrmBundle\\Entity\\Missions' . "\0" . 'datedebut', '' . "\0" . 'Bacloo\\CrmBundle\\Entity\\Missions' . "\0" . 'datefin', '' . "\0" . 'Bacloo\\CrmBundle\\Entity\\Missions' . "\0" . 'adresse', '' . "\0" . 'Bacloo\\CrmBundle\\Entity\\Missions' . "\0" . 'codepostal', '' . "\0" . 'Bacloo\\CrmBundle\\Entity\\Missions' . "\0" . 'ville', '' . "\0" . 'Bacloo\\CrmBundle\\Entity\\Missions' . "\0" . 'raisonsociale', '' . "\0" . 'Bacloo\\CrmBundle\\Entity\\Missions' . "\0" . 'description', '' . "\0" . 'Bacloo\\CrmBundle\\Entity\\Missions' . "\0" . 'dresscode', '' . "\0" . 'Bacloo\\CrmBundle\\Entity\\Missions' . "\0" . 'agenceid', '' . "\0" . 'Bacloo\\CrmBundle\\Entity\\Missions' . "\0" . 'urgent'];
        }

        return ['__isInitialized__', '' . "\0" . 'Bacloo\\CrmBundle\\Entity\\Missions' . "\0" . 'id', '' . "\0" . 'Bacloo\\CrmBundle\\Entity\\Missions' . "\0" . 'titre', '' . "\0" . 'Bacloo\\CrmBundle\\Entity\\Missions' . "\0" . 'datedebut', '' . "\0" . 'Bacloo\\CrmBundle\\Entity\\Missions' . "\0" . 'datefin', '' . "\0" . 'Bacloo\\CrmBundle\\Entity\\Missions' . "\0" . 'adresse', '' . "\0" . 'Bacloo\\CrmBundle\\Entity\\Missions' . "\0" . 'codepostal', '' . "\0" . 'Bacloo\\CrmBundle\\Entity\\Missions' . "\0" . 'ville', '' . "\0" . 'Bacloo\\CrmBundle\\Entity\\Missions' . "\0" . 'raisonsociale', '' . "\0" . 'Bacloo\\CrmBundle\\Entity\\Missions' . "\0" . 'description', '' . "\0" . 'Bacloo\\CrmBundle\\Entity\\Missions' . "\0" . 'dresscode', '' . "\0" . 'Bacloo\\CrmBundle\\Entity\\Missions' . "\0" . 'agenceid', '' . "\0" . 'Bacloo\\CrmBundle\\Entity\\Missions' . "\0" . 'urgent'];
    }

    /**
     * 
     */
    public function __wakeup()
    {
        if ( ! $this->__isInitialized__) {
            $this->__initializer__ = function (Missions $proxy) {
                $proxy->__setInitializer(null);
                $proxy->__setCloner(null);

                $existingProperties = get_object_vars($proxy);

                foreach ($proxy->__getLazyProperties() as $property => $defaultValue) {
                    if ( ! array_key_exists($property, $existingProperties)) {
                        $proxy->$property = $defaultValue;
                    }
                }
            };

        }
    }

    /**
     * 
     */
    public function __clone()
    {
        $this->__cloner__ && $this->__cloner__->__invoke($this, '__clone', []);
    }

    /**
     * Forces initialization of the proxy
     */
    public function __load()
    {
        $this->__initializer__ && $this->__initializer__->__invoke($this, '__load', []);
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __isInitialized()
    {
        return $this->__isInitialized__;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __setInitialized($initialized)
    {
        $this->__isInitialized__ = $initialized;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __setInitializer(\Closure $initializer = null)
    {
        $this->__initializer__ = $initializer;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __getInitializer()
    {
        return $this->__initializer__;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __setCloner(\Closure $cloner = null)
    {
        $this->__cloner__ = $cloner;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific cloning logic
     */
    public function __getCloner()
    {
        return $this->__cloner__;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     * @static
     */
    public function __getLazyProperties()
    {
        return self::$lazyPropertiesDefaults;
    }

    
    /**
     * {@inheritDoc}
     */
    public function getId()
    {
        if ($this->__isInitialized__ === false) {
            return (int)  parent::getId();
        }


        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getId', []);

        return parent::getId();
    }

    /**
     * {@inheritDoc}
     */
    public function setTitre($titre)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setTitre', [$titre]);

        return parent::setTitre($titre);
    }

    /**
     * {@inheritDoc}
     */
    public function getTitre()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getTitre', []);

        return parent::getTitre();
    }

    /**
     * {@inheritDoc}
     */
    public function setDatedebut($datedebut)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setDatedebut', [$datedebut]);

        return parent::setDatedebut($datedebut);
    }

    /**
     * {@inheritDoc}
     */
    public function getDatedebut()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getDatedebut', []);

        return parent::getDatedebut();
    }

    /**
     * {@inheritDoc}
     */
    public function setDatefin($datefin)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setDatefin', [$datefin]);

        return parent::setDatefin($datefin);
    }

    /**
     * {@inheritDoc}
     */
    public function getDatefin()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getDatefin', []);

        return parent::getDatefin();
    }

    /**
     * {@inheritDoc}
     */
    public function setAdresse($adresse)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setAdresse', [$adresse]);

        return parent::setAdresse($adresse);
    }

    /**
     * {@inheritDoc}
     */
    public function getAdresse()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getAdresse', []);

        return parent::getAdresse();
    }

    /**
     * {@inheritDoc}
     */
    public function setCodepostal($codepostal)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setCodepostal', [$codepostal]);

        return parent::setCodepostal($codepostal);
    }

    /**
     * {@inheritDoc}
     */
    public function getCodepostal()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getCodepostal', []);

        return parent::getCodepostal();
    }

    /**
     * {@inheritDoc}
     */
    public function setVille($ville)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setVille', [$ville]);

        return parent::setVille($ville);
    }

    /**
     * {@inheritDoc}
     */
    public function getVille()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getVille', []);

        return parent::getVille();
    }

    /**
     * {@inheritDoc}
     */
    public function setRaisonsociale($raisonsociale)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setRaisonsociale', [$raisonsociale]);

        return parent::setRaisonsociale($raisonsociale);
    }

    /**
     * {@inheritDoc}
     */
    public function getRaisonsociale()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getRaisonsociale', []);

        return parent::getRaisonsociale();
    }

    /**
     * {@inheritDoc}
     */
    public function setDescription($description)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setDescription', [$description]);

        return parent::setDescription($description);
    }

    /**
     * {@inheritDoc}
     */
    public function getDescription()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getDescription', []);

        return parent::getDescription();
    }

    /**
     * {@inheritDoc}
     */
    public function setDresscode($dresscode)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setDresscode', [$dresscode]);

        return parent::setDresscode($dresscode);
    }

    /**
     * {@inheritDoc}
     */
    public function getDresscode()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getDresscode', []);

        return parent::getDresscode();
    }

    /**
     * {@inheritDoc}
     */
    public function setAgenceid($agenceid)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setAgenceid', [$agenceid]);

        return parent::setAgenceid($agenceid);
    }

    /**
     * {@inheritDoc}
     */
    public function getAgenceid()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getAgenceid', []);

        return parent::getAgenceid();
    }

    /**
     * {@inheritDoc}
     */
    public function setUrgent($urgent)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setUrgent', [$urgent]);

        return parent::setUrgent($urgent);
    }

    /**
     * {@inheritDoc}
     */
    public function getUrgent()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getUrgent', []);

        return parent::getUrgent();
    }

}