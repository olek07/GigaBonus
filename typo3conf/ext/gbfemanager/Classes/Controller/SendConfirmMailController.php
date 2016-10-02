<?php
namespace Gigabonus\Gbfemanager\Controller;

use In2code\Femanager\Utility\StringUtility;
use In2code\Femanager\Utility\HashUtility;


class SendConfirmMailController extends \In2code\Femanager\Controller\EditController {

    public function sendAction() {
       
        /*
        if ($GLOBALS['TSFE']->fe_user->user['uid'] === NULL) {
            // redirect to the login page pid=3
            $this->redirect(null, null, null, null, 3);
            exit;
        }
         */
        
        if ($this->user->getTxFemanagerConfirmedbyuser()) {
            $this->view->assign('alreadyConfimed', TRUE);
        }
        else {
            $this->createUserConfirmationRequest($this->user);
        }
    }
    
    
    /**
     * Send email to user for confirmation
     *
     * @param \Gigabonus\Gbfemanager\Domain\Model\User $user
     * @return void
     * @throws UnsupportedRequestTypeException
     */
    protected function createUserConfirmationRequest(\Gigabonus\Gbfemanager\Domain\Model\User $user)
    {
        $this->sendMailService->send(
            'createUserConfirmation',
            StringUtility::makeEmailArray($user->getEmail(), $user->getUsername()),
            [
                $this->settings['new']['email']['createUserConfirmation']['sender']['email']['value'] =>
                    $this->settings['settings']['new']['email']['createUserConfirmation']['sender']['name']['value']
            ],
            'Confirm your profile creation request',
            [
                'user' => $user,
                'hash' => HashUtility::createHashForUser($user)
            ],
            $this->config['new.']['email.']['createUserConfirmation.']
        );
    }
    
}