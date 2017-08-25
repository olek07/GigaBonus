<?php
namespace Gigabonus\Gbaccount\Domain\Model;

/**
 * Payment
 */
class Payment extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {

    /**
     * amount
     *
     * @var int
     * @validate NotEmpty
     */
    protected $amount = 0;

    /**
     * user
     *
     * @var \Gigabonus\Gbfemanager\Domain\Model\User
     * @lazy
     */
    protected $user = null;

    /**
     * crdate
     *
     * @var \DateTime
     */
    protected $crdate;

    /**
     * paymentMethod
     *
     */
    protected $paymentMethod;


    /**
     * paymentData
     *
     * @var string
     */
    protected $paymentData = '';


    /**
     * Returns the amount
     *
     * @return int $amount
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Sets the amount
     *
     * @param int $amount
     * @return void
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
    }


    /**
     * @return \Gigabonus\Gbfemanager\Domain\Model\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param \Gigabonus\Gbfemanager\Domain\Model\User|int $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }


    /**
     * @return \DateTime
     */
    public function getCrdate()
    {
        return $this->crdate;
    }

    /**
     * @param \DateTime $crdate
     */
    public function setCrdate($crdate)
    {
        $this->crdate = $crdate;
    }

    /**
     * @return mixed
     */
    public function getPaymentMethod()
    {
        return $this->paymentMethod;
    }

    /**
     * @param mixed $paymentMethod
     */
    public function setPaymentMethod($paymentMethod)
    {
        $this->paymentMethod = $paymentMethod;
    }

    

}