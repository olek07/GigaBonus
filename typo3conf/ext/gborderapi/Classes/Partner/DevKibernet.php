<?php
namespace Gigabonus\Gborderapi\Partner;

class DevKibernet extends AbstractPartner {

    /**
     * @param float $amount
     * @return float
     */
    public function calculateFee($amount) {
        $fee = $amount * 0.20;
        return $fee;
    }
}