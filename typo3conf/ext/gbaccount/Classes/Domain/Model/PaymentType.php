<?php
namespace Gigabonus\Gbaccount\Domain\Model;

/**
 * PaymentType
 */
class PaymentType extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {

    /**
     * name
     * 
     * @var string
     */
    protected $name = '';

    /**
     * @var string
     */
    protected $conditions = '';


    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getConditions()
    {
        return $this->conditions;
    }

    /**
     * @param string $conditions
     */
    public function setConditions($conditions)
    {
        $this->conditions = $conditions;
    }

    
}

