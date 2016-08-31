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
    public function getLanguage()
    {
        return $this->language;
    }

}
