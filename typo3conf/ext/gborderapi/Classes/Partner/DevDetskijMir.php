<?php
namespace Gigabonus\Gborderapi\Partner;

class DevDetskijMir extends AbstractPartner {

    /**
     * @param float $amount
     * @return float
     */
    public function calculateFee($amount) {
        $fee = $amount * 0.17;
        return $fee;
    }
}