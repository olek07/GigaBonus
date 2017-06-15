<?php
namespace Gigabonus\Gborderapi\Partner;


use TYPO3\CMS\Core\SingletonInterface;

abstract class AbstractPartner implements SingletonInterface {

    /**
     * calculates our fee (Provision), that we receive from partner
     *
     * @param float $amount
     * @return float
     */
    abstract function calculateFee($amount);

    /**
     * calculates bonus (points), that the user receives from us
     *
     *
     * @param float $amount
     * @return int
     */
    abstract function calculateBonus($amount);
    
}

