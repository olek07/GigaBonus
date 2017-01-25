<?php
namespace Gigabonus\Gbfemanager\Controller;

use In2code\Femanager\Domain\Model\Log;
use In2code\Femanager\Utility\LogUtility;
use In2code\Femanager\Utility\LocalizationUtility;
use In2code\Femanager\Utility\StringUtility;
use In2code\Femanager\Utility\HashUtility;
use In2code\Femanager\Utility\UserUtility;
use Gigabonus\Gbbase\Utility\Helpers\MainHelper;


class NewController extends \In2code\Femanager\Controller\NewController {
    
    /**
     * Render registration form
     *
     * @param \Gigabonus\Gbfemanager\Domain\Model\User $user
     * @return void
     */
    public function newAction(\Gigabonus\Gbfemanager\Domain\Model\User $user = null)
    {
        // wenn angemeldet, redirect auf die Startseite
        if ($GLOBALS['TSFE']->fe_user->user) {
            MainHelper::redirect2Home();
            exit;
        }

        $pageRenderer = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Page\PageRenderer::class);

        $pageRenderer->addJsFooterInlineCode('',"
            $(document).ready(function(){
                $(document).on(Layout.EVENT_INIT_FORMS, function() {
                    GbfemanagerNew.init();
                });
                $(document).trigger(Layout.EVENT_INIT_FORMS);
            });
            "
        );


        parent::newAction($user);
    }
    
    /**
     * action create
     *
     * @param \Gigabonus\Gbfemanager\Domain\Model\User $user
     * @validate $user In2code\Femanager\Domain\Validator\ServersideValidator
     * @validate $user In2code\Femanager\Domain\Validator\PasswordValidator
     * @return void
     */
    public function createAction(\Gigabonus\Gbfemanager\Domain\Model\User $user) {
        $user->setLanguage('uk');
        parent::createAction($user);
    }


    public function registeredAction() {
        $this->controllerContext->getFlashMessageQueue()->clear();
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
                'hash' => HashUtility::createHashForUser($user),
                'registrationPageId' => 4,
                
            ],
            $this->config['new.']['email.']['createUserConfirmation.']
        );
    }
    
    /**
     * Some additional actions after profile creation
     *
     * @param \Gigabonus\Gbfemanager\Domain\Model\User $user
     * @param string $action
     * @param string $redirectByActionName Action to redirect
     * @param bool $login Login after creation
     * @param string $status
     * @return void
     */
    public function finalCreate($user, $action, $redirectByActionName, $login = true, $status = '')
    {
        $this->loginPreflight($user, $login);
        $variables = ['user' => $user, 'settings' => $this->settings];

        // send notify email to admin
        if ($this->settings['new']['notifyAdmin']) {
            $this->sendMailService->send(
                'createNotify',
                StringUtility::makeEmailArray(
                    $this->settings['new']['notifyAdmin'],
                    $this->settings['new']['email']['createAdminNotify']['receiver']['name']['value']
                ),
                StringUtility::makeEmailArray($user->getEmail(), $user->getUsername()),
                'Profile creation',
                $variables,
                $this->config['new.']['email.']['createAdminNotify.']
            );
        }
        $this->signalSlotDispatcher->dispatch(__CLASS__, __FUNCTION__ . 'AfterPersist', [$user, $action, $this]);
        $this->finisherRunner->callFinishers($user, $this->actionMethodName, $this->settings, $this->contentObject);

        $this->forward('registered');

        // $this->redirectByAction($action, ($status ? $status . 'Redirect' : 'redirect'));
        // $this->redirect($redirectByActionName);
    }
    
    
     /**
     * Prefix method to createAction(): Create must be confirmed by Admin or User
     *
     * @param \Gigabonus\Gbfemanager\Domain\Model\User $user
     * @return void
     */
    public function createRequest(\Gigabonus\Gbfemanager\Domain\Model\User $user)
    {
        $this->userRepository->add($user);
        $this->persistenceManager->persistAll();
        $this->addFlashMessage(LocalizationUtility::translate('create'));
        LogUtility::log(Log::STATUS_NEWREGISTRATION, $user);
        
        if (!empty($this->settings['new']['confirmByUser'])) {
            $this->createUserConfirmationRequest($user);
        }
        
        $this->finalCreate($user, 'new', 'createStatus');

    }

    /**
     * Log user in
     *
     * @param \Gigabonus\Gbfemanager\Domain\Model\User $user
     * @param $login
     * @throws IllegalObjectTypeException
     */
    protected function loginPreflight(\Gigabonus\Gbfemanager\Domain\Model\User $user, $login)
    {
        if ($login) {
            // persist user (otherwise login may not be possible)
            $this->userRepository->update($user);
            $this->persistenceManager->persistAll();
            if ($this->config['new.']['login'] === '1') {
                UserUtility::login($user, $this->allConfig['persistence']['storagePid']);
            }
        }
    }


}
