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
     * partner
     * 
     * @var \Gigabonus\Gbpartner\Domain\Model\Partner
     */
    protected $partner = null;
    
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
    public function setPartner(\Gigabonus\Gbpartner\Domain\Model\Partner $partner)
    {
        $this->partner = $partner;
    }

}