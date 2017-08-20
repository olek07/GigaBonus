<?php
namespace Gigabonus\Gborderapi\Partner;

class DevRsvital extends AbstractPartner {

    /**
     * @param float $amount
     * @return float
     */
    public function calculateFee($amount) {
        $fee = $amount * 0.02;
        return $fee;
    }



    /**
     * @param float $amount
     * @return int
     */
    public function calculateBonus($amount) {
        $bonus = floor($amount * 1);
        return $bonus;
    }


}