<?php
namespace Gigabonus\Gbfemanager\Domain\Validator;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;

class ServersideValidator extends \In2code\Femanager\Domain\Validator\ServersideValidator {

    /**
     * @param $user
     * @return bool
     */
    public function isValid($user) {

        $txFemanagerPi1 = GeneralUtility::_GP('tx_femanager_pi1');

        if (isset($txFemanagerPi1['user']['dateOfBirth'])) {
            if (preg_match('/^(\d\d)\.(\d\d)\.(\d\d\d\d)$/', $txFemanagerPi1['user']['dateOfBirth'], $matches)) {
                if (!checkdate($matches[2], $matches[1], $matches[3])) {
                    $user->setDateOfBirth(null);
                }
            }
        else {
                $user->setDateOfBirth(null);
            }
        }

        // allowed values of gender are: w,m
        if (isset($txFemanagerPi1['user']['gender'])) {
            if (!in_array($txFemanagerPi1['user']['gender'], array('m', 'w'))) {
                $user->setGender(null);
            }
        }


        return parent::isValid($user);

    }
}
