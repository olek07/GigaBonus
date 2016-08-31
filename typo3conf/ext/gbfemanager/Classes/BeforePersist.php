<?php
namespace GigaBonus\Gbfemanager\Slots;


class BeforePersist {
    public function setUsernameEqualToEmail($params, $class) {
        
        $class->user->setUsername($class->user->getEmail());
    }
}