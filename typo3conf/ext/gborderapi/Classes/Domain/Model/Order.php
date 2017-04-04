<?php
namespace Gigabonus\Gborderapi\Domain\Model;

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
 * Order
 */
class Order extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * partnerId
     * 
     * @var int
     * @validate NotEmpty
     */
    protected $partnerId = 0;


    /**
     * partner
     *
     * @var \Gigabonus\Gbpartner\Domain\Model\Partner
     * @lazy
     */
    protected $partner = null;

    
    /**
     * partnerOrderId
     * 
     * @var string
     * @validate NotEmpty
     */
    protected $partnerOrderId = '';
    
    /**
     * amount
     * 
     * @var float
     * @validate NotEmpty
     */
    protected $amount = 0.0;
    
    /**
     * fee
     * 
     * @var float
     */
    protected $fee = 0.0;
    
    /**
     * status
     * 
     * @var int
     * @validate NotEmpty
     */
    protected $status = 0;
    
    /**
     * userId
     * 
     * @var int
     * @validate NotEmpty
     */
    protected $userId = 0;
    
    /**
     * currency
     * 
     * @var string
     * @validate NotEmpty
     */
    protected $currency = '';
    
    /**
     * data
     * 
     * @var string
     */
    protected $data = '';
    
    /**
     * Returns the partnerId
     * 
     * @return int $partnerId
     */
    public function getPartnerId()
    {
        return $this->partnerId;
    }
    
    /**
     * Sets the partnerId
     * 
     * @param int $partnerId
     * @return void
     */
    public function setPartnerId($partnerId)
    {
        $this->partnerId = $partnerId;
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
     * @param \Gigabonus\Gbpartner\Domain\Model\Partner $partner
     * @return void
     */
    public function setPartner($partner)
    {
        $this->partner = $partner;
    }

    
    /**
     * Returns the partnerOrderId
     * 
     * @return string
     */
    public function getPartnerOrderId()
    {
        return $this->partnerOrderId;
    }
    
    /**
     * Sets the partnerOrderId
     * 
     * @param string $partnerOrderId
     * @return void
     */
    public function setPartnerOrderId($partnerOrderId)
    {
        $this->partnerOrderId = $partnerOrderId;
    }
    
    /**
     * Returns the amount
     * 
     * @return float $amount
     */
    public function getAmount()
    {
        return $this->amount;
    }
    
    /**
     * Sets the amount
     * 
     * @param float $amount
     * @return void
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
    }
    
    /**
     * Returns the status
     * 
     * @return int $status
     */
    public function getStatus()
    {
        return $this->status;
    }
    
    /**
     * Sets the status
     * 
     * @param int $status
     * @return void
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }
    
    /**
     * Returns the userId
     * 
     * @return int $userId
     */
    public function getUserId()
    {
        return $this->userId;
    }
    
    /**
     * Sets the userId
     * 
     * @param int $userId
     * @return void
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;
    }
    
    /**
     * Returns the currency
     * 
     * @return string $currency
     */
    public function getCurrency()
    {
        return $this->currency;
    }
    
    /**
     * Sets the currency
     * 
     * @param string $currency
     * @return void
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;
    }
    
    /**
     * Returns the data
     * 
     * @return string $data
     */
    public function getData()
    {
        return $this->data;
    }
    
    /**
     * Sets the data
     * 
     * @param string $data
     * @return void
     */
    public function setData($data)
    {
        $this->data = $data;
    }
    
    /**
     * Returns the fee
     * 
     * @return float $fee
     */
    public function getFee()
    {
        return $this->fee;
    }
    
    /**
     * Sets the fee
     * 
     * @param float $fee
     * @return void
     */
    public function setFee($fee)
    {
        $this->fee = $fee;
    }

}