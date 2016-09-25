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
        $txGbfemanagerTelephonelastchanged = $this->user->getTxGbfemanagerTelephonelastchanged();
        $timeToPasswordChange = 0;
        if ($txGbfemanagerTelephonelastchanged !== NULL) {
            $t = time() - $this->user->getTxGbfemanagerTelephonelastchanged()->getTimeStamp();
            if ($t < 300) {
                $timeToPasswordChange = 300 - $t;
            }
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
        if (($user !== NULL) && ($GLOBALS['TSFE']->fe_user->user['uid']) ==  $user->getUid()) {
            $telephonelastchanged = ObjectAccess::getProperty($user, 'txGbfemanagerTelephonelastchanged');
            $user->setTxGbfemanagerTelephonelastchanged(time());
            parent::updateAction($user);
        }
        else {
            // Versuch die uid im FireBug oder Ähnlichem zu manipulieren 
            exit;
        }
    }

}