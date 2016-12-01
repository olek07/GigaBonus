<?php
namespace Gigabonus\Gborderapi\Partner;



abstract class AbstractPartner {

    /**
     * @param float $amount
     * @return float
     */
    public function calculateFee($amount) {
        $fee = $amount * 0.1;
        return $fee;
    }

    /**
     * @param float $amount
     * @return int
     */
    public function calculateBonus($amount) {
        $bonus = floor($amount * 1.5);
        return $bonus;
    }
    
}

