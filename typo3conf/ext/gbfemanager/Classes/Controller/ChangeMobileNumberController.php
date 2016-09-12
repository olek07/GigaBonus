<?php
namespace Gigabonus\Gbfemanager\Controller;
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
        parent::updateAction($user);
    }

}