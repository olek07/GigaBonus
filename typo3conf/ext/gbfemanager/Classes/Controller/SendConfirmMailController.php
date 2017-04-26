<?php
namespace Gigabonus\Gbfemanager\Controller;

use Gigabonus\Gbbase\Utility\Helpers\MainHelper;
use In2code\Femanager\Utility\StringUtility;
use In2code\Femanager\Utility\HashUtility;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;


class SendConfirmMailController extends \Gigabonus\Gbfemanager\Controller\NewController {

    /**
     * userRepository
     * 
     * @var \In2code\Femanager\Domain\Repository\UserRepository
     * @inject
     */
    protected $userRepository = NULL;

    /**
     * @var \TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager
     * @inject
     */
    protected $persistenceManager;



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

            /**
             * @var \Gigabonus\Gbfemanager\Domain\Model\User $user
             */
            $user = $this->user;
            
            $this->createUserConfirmationRequest($user);

            $confirmmailSentCount = $user->getTxGbfemanagerConfirmmailSentCount();

            if ($confirmmailSentCount < 5) {
                $user->setTxGbfemanagerConfirmmailSentCount(++$confirmmailSentCount);
                $this->userRepository->update($user);
                $this->view->assign('limitReached', FALSE);
            }
            else {
                $this->view->assign('limitReached', TRUE);
            }


            $this->view->assign('contactPageUid', MainHelper::CONTACTPAGEID);
            $this->view->assign('alreadyConfimed', FALSE);
            $this->view->assign('user', $user);
        }
    }
    
    
    /**
     * Send email to user for confirmation
     *
     * @param \Gigabonus\Gbfemanager\Domain\Model\User $user
     * @return void
     * @throws UnsupportedRequestTypeException
     */
    protected function ___createUserConfirmationRequest(\Gigabonus\Gbfemanager\Domain\Model\User $user)
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
                'hash' => HashUtility::createHashForUser($user),
                'registrationPageId' => 4,
            ],
            $this->config['new.']['email.']['createUserConfirmation.']
        );
    }
    
}