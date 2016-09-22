<?php
namespace GigaBonus\Gbfemanager\Slots;


class BeforePersist {
    public function setUsernameEqualToEmail($user, $class) {
        $user->setUsername($user->getEmail());
    }
}