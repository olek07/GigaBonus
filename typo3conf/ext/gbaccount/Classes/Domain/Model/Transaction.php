<?php
namespace Gigabonus\Gbaccount\Domain\Model;

/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2016
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 * Transaction
 */
class Transaction extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * amount
     * 
     * @var int
     * @validate NotEmpty
     */
    protected $amount = 0;
    
    /**
     *
     * @var boolean
     */
    protected $isOnHold = false;


    /**
     * @var bool
     */
    protected $rejected = false;


    /**
     * partnerOrder
     *
     * @var \Gigabonus\Gborderapi\Domain\Model\Order
     */
    protected $partnerOrder = null;

    /**
     * saldo
     *
     * @var int
     * @validate NotEmpty
     */
    protected $saldo = 0;
    
    /**
     * partner
     * 
     * @var \Gigabonus\Gbpartner\Domain\Model\Partner
     * @lazy
     */
    protected $partner = null;


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
     * @var int
     */
    protected $status = null;
    

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
        // $this->setSaldo($this->getSaldo() + $amount);
    }
    
    /**
     * @return boolean
     */
    public function getIsOnHold() {
        return $this->isOnHold;
    }

    /**
     * 
     * @param boolean $isOnHold
     * @return void
     */
    public function setIsOnHold($isOnHold) {
        $this->isOnHold = $isOnHold;
    }

    /**
     * @return boolean
     */
    public function isRejected()
    {
        return $this->rejected;
    }

    /**
     * @param boolean $rejected
     */
    public function setRejected($rejected)
    {
        $this->rejected = $rejected;
    }


    /**
     * @return int
     */
    public function getSaldo()
    {
        return $this->saldo;
    }

    /**
     * @param int $saldo
     */
    public function setSaldo($saldo)
    {
        $this->saldo = $saldo;
    }

    /**
     * @return mixed
     */
    public function getPartnerOrder()
    {
        return $this->partnerOrder;
    }

    /**
     * @param mixed $partnerOrder
     */
    public function setPartnerOrder($partnerOrder)
    {
        $this->partnerOrder = $partnerOrder;
    }

    
    /**
     * Returns the partner
     * 
     * @return \Gigabonus\Gbpartner\Domain\Model\Partner $partner
     */
    public function getPartner()
    {
        return $this->partner;
    }
    
    /**
     * Sets the partner
     * 
     * @param \Gigabonus\Gbpartner\Domain\Model\Partner|int $partner
     * @return void
     */
    public function setPartner($partner)
    {
        $this->partner = $partner;
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
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param int $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * __construct
     */
    public function __construct()
    {
        //Do not remove the next line: It would break the functionality
        $this->initStorageObjects();
    }

    /**
     * Initializes all ObjectStorage properties
     * Do not modify this method!
     * It will be rewritten on each save in the extension builder
     * You may modify the constructor of this class instead
     *
     * @return void
     */
    protected function initStorageObjects()
    {

    }


}