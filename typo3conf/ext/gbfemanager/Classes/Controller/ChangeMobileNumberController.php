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
        $t = time() - $this->user->getTxGbfemanagerTelephonelastchanged()->getTimeStamp();
        $timeToPasswordChange = 0;
        if ($t < 300) {
            $timeToPasswordChange = 300 - $t;
        }
        $this->view->assign('timeToPasswordChange', $timeToPasswordChange);
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
    public function updateAction(\Gigabonus\Gbfemanager\Domain\Model\User $user = null) {
        $telephonelastchanged = ObjectAccess::getProperty($user, 'txGbfemanagerTelephonelastchanged');
        $user->setTxGbfemanagerTelephonelastchanged(time());
        parent::updateAction($user);
    }

}