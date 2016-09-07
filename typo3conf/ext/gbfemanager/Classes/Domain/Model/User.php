<?php

namespace Gigabonus\Gbfemanager\Domain\Model;

class User extends \In2code\Femanager\Domain\Model\User {

    /**
     * language
     *
     * @var string
     */
    protected $language;

    /**
     *
     * @var int
     */
    protected $cityid;

    /**
     * Sets the language
     *
     * @param string $language
     * @return User
     */
    public function setLanguage($language) {
        $this->language = $language;
        return $this;
    }

    /**
     * Returns the language
     *
     * @return string
     */
    public function getLanguage() {
        return $this->language;
    }
    
    /**
     * Sets the cityId
     *
     * @param int $cityid
     * @return User
     */
    public function setCityid($cityid) {
        $this->cityid = $cityid;
        return $this;
    }

    /**
     * Returns the cityid
     *
     * @return string
     */
    public function getCityid() {
        return $this->cityid;
    }

}
