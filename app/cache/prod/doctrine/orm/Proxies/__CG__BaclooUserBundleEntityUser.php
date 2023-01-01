<?php

namespace Proxies\__CG__\Bacloo\UserBundle\Entity;

/**
 * DO NOT EDIT THIS FILE - IT WAS CREATED BY DOCTRINE'S PROXY GENERATOR
 */
class User extends \Bacloo\UserBundle\Entity\User implements \Doctrine\ORM\Proxy\Proxy
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
            return ['__isInitialized__', 'usersociete', 'id', 'nom', 'prenom', 'activite', 'desc_rech', 'tags', 'actvise', 'credits', 'note', 'point', 'plein', 'actconnexes', 'parrain', 'typeuser', 'usernomsociete', 'nomrep', 'typebacloo', 'roleuser', 'textaccueil', 'fichelimit', '' . "\0" . 'Bacloo\\UserBundle\\Entity\\User' . "\0" . 'logged', '' . "\0" . 'Bacloo\\UserBundle\\Entity\\User' . "\0" . 'adresse1', '' . "\0" . 'Bacloo\\UserBundle\\Entity\\User' . "\0" . 'telephone', 'cp', 'cpuser', 'chargeId', '' . "\0" . 'Bacloo\\UserBundle\\Entity\\User' . "\0" . 'stripeid', '' . "\0" . 'Bacloo\\UserBundle\\Entity\\User' . "\0" . 'premium', '' . "\0" . 'Bacloo\\UserBundle\\Entity\\User' . "\0" . 'datepremium', '' . "\0" . 'Bacloo\\UserBundle\\Entity\\User' . "\0" . 'finpremium', 'datenaissance', 'tel', 'adresse', 'codepostal', 'ville', 'rib', 'photo', 'type', 'username', 'usernameCanonical', 'email', 'emailCanonical', 'enabled', 'salt', 'password', 'plainPassword', 'lastLogin', 'confirmationToken', 'passwordRequestedAt', 'groups', 'locked', 'expired', 'expiresAt', 'roles', 'credentialsExpired', 'credentialsExpireAt'];
        }

        return ['__isInitialized__', 'usersociete', 'id', 'nom', 'prenom', 'activite', 'desc_rech', 'tags', 'actvise', 'credits', 'note', 'point', 'plein', 'actconnexes', 'parrain', 'typeuser', 'usernomsociete', 'nomrep', 'typebacloo', 'roleuser', 'textaccueil', 'fichelimit', '' . "\0" . 'Bacloo\\UserBundle\\Entity\\User' . "\0" . 'logged', '' . "\0" . 'Bacloo\\UserBundle\\Entity\\User' . "\0" . 'adresse1', '' . "\0" . 'Bacloo\\UserBundle\\Entity\\User' . "\0" . 'telephone', 'cp', 'cpuser', 'chargeId', '' . "\0" . 'Bacloo\\UserBundle\\Entity\\User' . "\0" . 'stripeid', '' . "\0" . 'Bacloo\\UserBundle\\Entity\\User' . "\0" . 'premium', '' . "\0" . 'Bacloo\\UserBundle\\Entity\\User' . "\0" . 'datepremium', '' . "\0" . 'Bacloo\\UserBundle\\Entity\\User' . "\0" . 'finpremium', 'datenaissance', 'tel', 'adresse', 'codepostal', 'ville', 'rib', 'photo', 'type', 'username', 'usernameCanonical', 'email', 'emailCanonical', 'enabled', 'salt', 'password', 'plainPassword', 'lastLogin', 'confirmationToken', 'passwordRequestedAt', 'groups', 'locked', 'expired', 'expiresAt', 'roles', 'credentialsExpired', 'credentialsExpireAt'];
    }

    /**
     * 
     */
    public function __wakeup()
    {
        if ( ! $this->__isInitialized__) {
            $this->__initializer__ = function (User $proxy) {
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
    public function setNom($nom)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setNom', [$nom]);

        return parent::setNom($nom);
    }

    /**
     * {@inheritDoc}
     */
    public function getNom()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getNom', []);

        return parent::getNom();
    }

    /**
     * {@inheritDoc}
     */
    public function setPrenom($prenom)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setPrenom', [$prenom]);

        return parent::setPrenom($prenom);
    }

    /**
     * {@inheritDoc}
     */
    public function getPrenom()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getPrenom', []);

        return parent::getPrenom();
    }

    /**
     * {@inheritDoc}
     */
    public function setDatenaissance($datenaissance)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setDatenaissance', [$datenaissance]);

        return parent::setDatenaissance($datenaissance);
    }

    /**
     * {@inheritDoc}
     */
    public function getDatenaissance()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getDatenaissance', []);

        return parent::getDatenaissance();
    }

    /**
     * {@inheritDoc}
     */
    public function setTel($tel)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setTel', [$tel]);

        return parent::setTel($tel);
    }

    /**
     * {@inheritDoc}
     */
    public function getTel()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getTel', []);

        return parent::getTel();
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
    public function setRib($rib)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setRib', [$rib]);

        return parent::setRib($rib);
    }

    /**
     * {@inheritDoc}
     */
    public function getRib()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getRib', []);

        return parent::getRib();
    }

    /**
     * {@inheritDoc}
     */
    public function setPhoto($photo)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setPhoto', [$photo]);

        return parent::setPhoto($photo);
    }

    /**
     * {@inheritDoc}
     */
    public function getPhoto()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getPhoto', []);

        return parent::getPhoto();
    }

    /**
     * {@inheritDoc}
     */
    public function setType($type)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setType', [$type]);

        return parent::setType($type);
    }

    /**
     * {@inheritDoc}
     */
    public function getType()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getType', []);

        return parent::getType();
    }

    /**
     * {@inheritDoc}
     */
    public function setUsersociete($usersociete)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setUsersociete', [$usersociete]);

        return parent::setUsersociete($usersociete);
    }

    /**
     * {@inheritDoc}
     */
    public function getUsersociete()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getUsersociete', []);

        return parent::getUsersociete();
    }

    /**
     * {@inheritDoc}
     */
    public function setActivite($activite)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setActivite', [$activite]);

        return parent::setActivite($activite);
    }

    /**
     * {@inheritDoc}
     */
    public function getActivite()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getActivite', []);

        return parent::getActivite();
    }

    /**
     * {@inheritDoc}
     */
    public function setDescRech($descRech)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setDescRech', [$descRech]);

        return parent::setDescRech($descRech);
    }

    /**
     * {@inheritDoc}
     */
    public function getDescRech()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getDescRech', []);

        return parent::getDescRech();
    }

    /**
     * {@inheritDoc}
     */
    public function setTags($tags)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setTags', [$tags]);

        return parent::setTags($tags);
    }

    /**
     * {@inheritDoc}
     */
    public function getTags()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getTags', []);

        return parent::getTags();
    }

    /**
     * {@inheritDoc}
     */
    public function setActvise($actvise)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setActvise', [$actvise]);

        return parent::setActvise($actvise);
    }

    /**
     * {@inheritDoc}
     */
    public function getActvise()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getActvise', []);

        return parent::getActvise();
    }

    /**
     * {@inheritDoc}
     */
    public function setCredits($credits)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setCredits', [$credits]);

        return parent::setCredits($credits);
    }

    /**
     * {@inheritDoc}
     */
    public function getCredits()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getCredits', []);

        return parent::getCredits();
    }

    /**
     * {@inheritDoc}
     */
    public function setNote($note)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setNote', [$note]);

        return parent::setNote($note);
    }

    /**
     * {@inheritDoc}
     */
    public function getNote()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getNote', []);

        return parent::getNote();
    }

    /**
     * {@inheritDoc}
     */
    public function setPoint($point)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setPoint', [$point]);

        return parent::setPoint($point);
    }

    /**
     * {@inheritDoc}
     */
    public function getPoint()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getPoint', []);

        return parent::getPoint();
    }

    /**
     * {@inheritDoc}
     */
    public function setPlein($plein)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setPlein', [$plein]);

        return parent::setPlein($plein);
    }

    /**
     * {@inheritDoc}
     */
    public function getPlein()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getPlein', []);

        return parent::getPlein();
    }

    /**
     * {@inheritDoc}
     */
    public function setActconnexes($actconnexes)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setActconnexes', [$actconnexes]);

        return parent::setActconnexes($actconnexes);
    }

    /**
     * {@inheritDoc}
     */
    public function getActconnexes()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getActconnexes', []);

        return parent::getActconnexes();
    }

    /**
     * {@inheritDoc}
     */
    public function setParrain($parrain)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setParrain', [$parrain]);

        return parent::setParrain($parrain);
    }

    /**
     * {@inheritDoc}
     */
    public function getParrain()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getParrain', []);

        return parent::getParrain();
    }

    /**
     * {@inheritDoc}
     */
    public function setTypeuser($typeuser)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setTypeuser', [$typeuser]);

        return parent::setTypeuser($typeuser);
    }

    /**
     * {@inheritDoc}
     */
    public function getTypeuser()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getTypeuser', []);

        return parent::getTypeuser();
    }

    /**
     * {@inheritDoc}
     */
    public function setUsernomsociete($usernomsociete)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setUsernomsociete', [$usernomsociete]);

        return parent::setUsernomsociete($usernomsociete);
    }

    /**
     * {@inheritDoc}
     */
    public function getUsernomsociete()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getUsernomsociete', []);

        return parent::getUsernomsociete();
    }

    /**
     * {@inheritDoc}
     */
    public function setNomrep($nomrep)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setNomrep', [$nomrep]);

        return parent::setNomrep($nomrep);
    }

    /**
     * {@inheritDoc}
     */
    public function getNomrep()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getNomrep', []);

        return parent::getNomrep();
    }

    /**
     * {@inheritDoc}
     */
    public function setTypebacloo($typebacloo)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setTypebacloo', [$typebacloo]);

        return parent::setTypebacloo($typebacloo);
    }

    /**
     * {@inheritDoc}
     */
    public function getTypebacloo()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getTypebacloo', []);

        return parent::getTypebacloo();
    }

    /**
     * {@inheritDoc}
     */
    public function setRoleuser($roleuser)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setRoleuser', [$roleuser]);

        return parent::setRoleuser($roleuser);
    }

    /**
     * {@inheritDoc}
     */
    public function getRoleuser()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getRoleuser', []);

        return parent::getRoleuser();
    }

    /**
     * {@inheritDoc}
     */
    public function setTextaccueil($textaccueil)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setTextaccueil', [$textaccueil]);

        return parent::setTextaccueil($textaccueil);
    }

    /**
     * {@inheritDoc}
     */
    public function getTextaccueil()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getTextaccueil', []);

        return parent::getTextaccueil();
    }

    /**
     * {@inheritDoc}
     */
    public function setFichelimit($fichelimit)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setFichelimit', [$fichelimit]);

        return parent::setFichelimit($fichelimit);
    }

    /**
     * {@inheritDoc}
     */
    public function getFichelimit()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getFichelimit', []);

        return parent::getFichelimit();
    }

    /**
     * {@inheritDoc}
     */
    public function setLogged($logged)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setLogged', [$logged]);

        return parent::setLogged($logged);
    }

    /**
     * {@inheritDoc}
     */
    public function getLogged()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getLogged', []);

        return parent::getLogged();
    }

    /**
     * {@inheritDoc}
     */
    public function setAdresse1($adresse1)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setAdresse1', [$adresse1]);

        return parent::setAdresse1($adresse1);
    }

    /**
     * {@inheritDoc}
     */
    public function getAdresse1()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getAdresse1', []);

        return parent::getAdresse1();
    }

    /**
     * {@inheritDoc}
     */
    public function setTelephone($telephone)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setTelephone', [$telephone]);

        return parent::setTelephone($telephone);
    }

    /**
     * {@inheritDoc}
     */
    public function getTelephone()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getTelephone', []);

        return parent::getTelephone();
    }

    /**
     * {@inheritDoc}
     */
    public function setCp($cp)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setCp', [$cp]);

        return parent::setCp($cp);
    }

    /**
     * {@inheritDoc}
     */
    public function getCp()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getCp', []);

        return parent::getCp();
    }

    /**
     * {@inheritDoc}
     */
    public function setCpuser($cpuser)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setCpuser', [$cpuser]);

        return parent::setCpuser($cpuser);
    }

    /**
     * {@inheritDoc}
     */
    public function getCpuser()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getCpuser', []);

        return parent::getCpuser();
    }

    /**
     * {@inheritDoc}
     */
    public function setChargeId($chargeId)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setChargeId', [$chargeId]);

        return parent::setChargeId($chargeId);
    }

    /**
     * {@inheritDoc}
     */
    public function getChargeId()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getChargeId', []);

        return parent::getChargeId();
    }

    /**
     * {@inheritDoc}
     */
    public function setStripeid($stripeid)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setStripeid', [$stripeid]);

        return parent::setStripeid($stripeid);
    }

    /**
     * {@inheritDoc}
     */
    public function getStripeid()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getStripeid', []);

        return parent::getStripeid();
    }

    /**
     * {@inheritDoc}
     */
    public function setPremium($premium)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setPremium', [$premium]);

        return parent::setPremium($premium);
    }

    /**
     * {@inheritDoc}
     */
    public function getPremium()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getPremium', []);

        return parent::getPremium();
    }

    /**
     * {@inheritDoc}
     */
    public function setDatepremium($datepremium)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setDatepremium', [$datepremium]);

        return parent::setDatepremium($datepremium);
    }

    /**
     * {@inheritDoc}
     */
    public function getDatepremium()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getDatepremium', []);

        return parent::getDatepremium();
    }

    /**
     * {@inheritDoc}
     */
    public function setFinpremium($finpremium)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setFinpremium', [$finpremium]);

        return parent::setFinpremium($finpremium);
    }

    /**
     * {@inheritDoc}
     */
    public function getFinpremium()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getFinpremium', []);

        return parent::getFinpremium();
    }

    /**
     * {@inheritDoc}
     */
    public function addRole($role)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'addRole', [$role]);

        return parent::addRole($role);
    }

    /**
     * {@inheritDoc}
     */
    public function serialize()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'serialize', []);

        return parent::serialize();
    }

    /**
     * {@inheritDoc}
     */
    public function unserialize($serialized)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'unserialize', [$serialized]);

        return parent::unserialize($serialized);
    }

    /**
     * {@inheritDoc}
     */
    public function eraseCredentials()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'eraseCredentials', []);

        return parent::eraseCredentials();
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
    public function getUsername()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getUsername', []);

        return parent::getUsername();
    }

    /**
     * {@inheritDoc}
     */
    public function getUsernameCanonical()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getUsernameCanonical', []);

        return parent::getUsernameCanonical();
    }

    /**
     * {@inheritDoc}
     */
    public function getSalt()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getSalt', []);

        return parent::getSalt();
    }

    /**
     * {@inheritDoc}
     */
    public function getEmail()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getEmail', []);

        return parent::getEmail();
    }

    /**
     * {@inheritDoc}
     */
    public function getEmailCanonical()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getEmailCanonical', []);

        return parent::getEmailCanonical();
    }

    /**
     * {@inheritDoc}
     */
    public function getPassword()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getPassword', []);

        return parent::getPassword();
    }

    /**
     * {@inheritDoc}
     */
    public function getPlainPassword()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getPlainPassword', []);

        return parent::getPlainPassword();
    }

    /**
     * {@inheritDoc}
     */
    public function getLastLogin()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getLastLogin', []);

        return parent::getLastLogin();
    }

    /**
     * {@inheritDoc}
     */
    public function getConfirmationToken()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getConfirmationToken', []);

        return parent::getConfirmationToken();
    }

    /**
     * {@inheritDoc}
     */
    public function getRoles()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getRoles', []);

        return parent::getRoles();
    }

    /**
     * {@inheritDoc}
     */
    public function hasRole($role)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'hasRole', [$role]);

        return parent::hasRole($role);
    }

    /**
     * {@inheritDoc}
     */
    public function isAccountNonExpired()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'isAccountNonExpired', []);

        return parent::isAccountNonExpired();
    }

    /**
     * {@inheritDoc}
     */
    public function isAccountNonLocked()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'isAccountNonLocked', []);

        return parent::isAccountNonLocked();
    }

    /**
     * {@inheritDoc}
     */
    public function isCredentialsNonExpired()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'isCredentialsNonExpired', []);

        return parent::isCredentialsNonExpired();
    }

    /**
     * {@inheritDoc}
     */
    public function isCredentialsExpired()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'isCredentialsExpired', []);

        return parent::isCredentialsExpired();
    }

    /**
     * {@inheritDoc}
     */
    public function isEnabled()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'isEnabled', []);

        return parent::isEnabled();
    }

    /**
     * {@inheritDoc}
     */
    public function isExpired()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'isExpired', []);

        return parent::isExpired();
    }

    /**
     * {@inheritDoc}
     */
    public function isLocked()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'isLocked', []);

        return parent::isLocked();
    }

    /**
     * {@inheritDoc}
     */
    public function isSuperAdmin()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'isSuperAdmin', []);

        return parent::isSuperAdmin();
    }

    /**
     * {@inheritDoc}
     */
    public function isUser(\FOS\UserBundle\Model\UserInterface $user = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'isUser', [$user]);

        return parent::isUser($user);
    }

    /**
     * {@inheritDoc}
     */
    public function removeRole($role)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'removeRole', [$role]);

        return parent::removeRole($role);
    }

    /**
     * {@inheritDoc}
     */
    public function setUsername($username)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setUsername', [$username]);

        return parent::setUsername($username);
    }

    /**
     * {@inheritDoc}
     */
    public function setUsernameCanonical($usernameCanonical)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setUsernameCanonical', [$usernameCanonical]);

        return parent::setUsernameCanonical($usernameCanonical);
    }

    /**
     * {@inheritDoc}
     */
    public function setCredentialsExpireAt(\DateTime $date)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setCredentialsExpireAt', [$date]);

        return parent::setCredentialsExpireAt($date);
    }

    /**
     * {@inheritDoc}
     */
    public function setCredentialsExpired($boolean)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setCredentialsExpired', [$boolean]);

        return parent::setCredentialsExpired($boolean);
    }

    /**
     * {@inheritDoc}
     */
    public function setEmail($email)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setEmail', [$email]);

        return parent::setEmail($email);
    }

    /**
     * {@inheritDoc}
     */
    public function setEmailCanonical($emailCanonical)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setEmailCanonical', [$emailCanonical]);

        return parent::setEmailCanonical($emailCanonical);
    }

    /**
     * {@inheritDoc}
     */
    public function setEnabled($boolean)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setEnabled', [$boolean]);

        return parent::setEnabled($boolean);
    }

    /**
     * {@inheritDoc}
     */
    public function setExpired($boolean)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setExpired', [$boolean]);

        return parent::setExpired($boolean);
    }

    /**
     * {@inheritDoc}
     */
    public function setExpiresAt(\DateTime $date)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setExpiresAt', [$date]);

        return parent::setExpiresAt($date);
    }

    /**
     * {@inheritDoc}
     */
    public function setPassword($password)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setPassword', [$password]);

        return parent::setPassword($password);
    }

    /**
     * {@inheritDoc}
     */
    public function setSuperAdmin($boolean)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setSuperAdmin', [$boolean]);

        return parent::setSuperAdmin($boolean);
    }

    /**
     * {@inheritDoc}
     */
    public function setPlainPassword($password)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setPlainPassword', [$password]);

        return parent::setPlainPassword($password);
    }

    /**
     * {@inheritDoc}
     */
    public function setLastLogin(\DateTime $time)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setLastLogin', [$time]);

        return parent::setLastLogin($time);
    }

    /**
     * {@inheritDoc}
     */
    public function setLocked($boolean)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setLocked', [$boolean]);

        return parent::setLocked($boolean);
    }

    /**
     * {@inheritDoc}
     */
    public function setConfirmationToken($confirmationToken)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setConfirmationToken', [$confirmationToken]);

        return parent::setConfirmationToken($confirmationToken);
    }

    /**
     * {@inheritDoc}
     */
    public function setPasswordRequestedAt(\DateTime $date = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setPasswordRequestedAt', [$date]);

        return parent::setPasswordRequestedAt($date);
    }

    /**
     * {@inheritDoc}
     */
    public function getPasswordRequestedAt()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getPasswordRequestedAt', []);

        return parent::getPasswordRequestedAt();
    }

    /**
     * {@inheritDoc}
     */
    public function isPasswordRequestNonExpired($ttl)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'isPasswordRequestNonExpired', [$ttl]);

        return parent::isPasswordRequestNonExpired($ttl);
    }

    /**
     * {@inheritDoc}
     */
    public function setRoles(array $roles)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setRoles', [$roles]);

        return parent::setRoles($roles);
    }

    /**
     * {@inheritDoc}
     */
    public function getGroups()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getGroups', []);

        return parent::getGroups();
    }

    /**
     * {@inheritDoc}
     */
    public function getGroupNames()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getGroupNames', []);

        return parent::getGroupNames();
    }

    /**
     * {@inheritDoc}
     */
    public function hasGroup($name)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'hasGroup', [$name]);

        return parent::hasGroup($name);
    }

    /**
     * {@inheritDoc}
     */
    public function addGroup(\FOS\UserBundle\Model\GroupInterface $group)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'addGroup', [$group]);

        return parent::addGroup($group);
    }

    /**
     * {@inheritDoc}
     */
    public function removeGroup(\FOS\UserBundle\Model\GroupInterface $group)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'removeGroup', [$group]);

        return parent::removeGroup($group);
    }

    /**
     * {@inheritDoc}
     */
    public function __toString()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, '__toString', []);

        return parent::__toString();
    }

}