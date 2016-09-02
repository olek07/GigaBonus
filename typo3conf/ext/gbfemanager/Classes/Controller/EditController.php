<?php
namespace Gigabonus\Gbfemanager\Controller;

class EditController extends \In2code\Femanager\Controller\EditController {
    
    
    /**
    * initialize create action
    *
    * @return void
    */
    public function initializeUpdateAction() {
        if ($this->arguments->hasArgument('user')) {
                $this->arguments->getArgument('user')
                        ->getPropertyMappingConfiguration()
                        ->skipProperties('day', 'month', 'year');
        }
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
     * @validate $user In2code\Femanager\Domain\Validator\PasswordValidator
     * @validate $user In2code\Femanager\Domain\Validator\CaptchaValidator
     * @return void
     */
    public function updateAction(\Gigabonus\Gbfemanager\Domain\Model\User $user) {
        $formData = $this->request->getArgument('user');
        // \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($formData);exit;
                
        $date = new \DateTime();
        $date->setDate((int)$formData['year'], (int)$formData['month'], (int)$formData['day']);
        $user->setDateOfBirth($date);
        parent::updateAction($user);
    }

}