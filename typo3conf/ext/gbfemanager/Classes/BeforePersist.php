<?php
namespace Gigabonus\Gbfemanager\Slots;

use Gigabonus\Gbbase\Utility\Helpers\MainHelper;

class BeforePersist {
    public function setUsernameEqualToEmail($user, $class) {
        $user->setUsername($user->getEmail());
    }

    // This function is not in use now
    public function confirmCreateRequestAction($user, $hash, $status, $obj) {
        if ($user !== NULL) {
            if ($user->getTxFemanagerConfirmedbyuser()) {
                MainHelper::redirect2DeleteProfilePage();
            }
        }
    }
}