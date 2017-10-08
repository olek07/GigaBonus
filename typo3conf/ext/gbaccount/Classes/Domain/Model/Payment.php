<?php
namespace Gigabonus\Gbaccount\Domain\Model;

/**
 * Payment
 */
class Payment extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {

    /**
     * amount
     *
     * @var integer
     * @validate Integer
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
     * paymentType
     *
     * @var \Gigabonus\Gbaccount\Domain\Model\PaymentType
     * @validate Integer
     */
    protected $paymentType;


    /**
     * paymentData
     *
     * @var string
     */
    protected $paymentData = '';


    /**
     * @var bool
     */
    protected $paidStatus = false;


    /**
     * crdate
     *
     * @var \DateTime
     */
    protected $crdate;


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
    public function getPaymentType()
    {
        return $this->paymentType;
    }

    /**
     * @param mixed $paymentType
     */
    public function setPaymentType($paymentType)
    {
        $this->paymentType = $paymentType;
    }

    /**
     * @return boolean
     */
    public function isPaidStatus()
    {
        return $this->paidStatus;
    }

    /**
     * @param boolean $paidStatus
     */
    public function setPaidStatus($paidStatus)
    {
        $this->paidStatus = $paidStatus;
    }

    /**
     * @return string
     */
    public function getPaymentData()
    {
        return $this->paymentData;
    }

    /**
     * @param string $paymentData
     */
    public function setPaymentData($paymentData)
    {
        $this->paymentData = $paymentData;
    }




}