<?php
namespace Gigabonus\Gbfemanager\Controller;

use TYPO3\CMS\Extbase\Reflection\ObjectAccess;

class ChangeMobileNumberController extends \In2code\Femanager\Controller\EditController {
    
    
    /**
    * initialize create action
    *
    * @return void
    */
    public function initializeUpdateAction() {
        

    }
    
        /**
     * action edit
     *
     * @return void
     */
    public function editAction()
    {
        \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($this->user);
        parent::editAction();
    }
    
    
    /**
     * action update
     *
     * @param User $user
     * @validate $user In2code\Femanager\Domain\Validator\ServersideValidator
     * @validate $user In2code\Femanager\Domain\Validator\CaptchaValidator
     * @return void
     */
    public function updateAction(\Gigabonus\Gbfemanager\Domain\Model\User $user) {
        
        $telephonelastchanged = ObjectAccess::getProperty($user, 'txGbfemanagerTelephonelastchanged');
        \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($telephonelastchanged);
        $user->setTxGbfemanagerTelephonelastchanged(time());
        \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($user);exit;
        parent::updateAction($user);
    }

}