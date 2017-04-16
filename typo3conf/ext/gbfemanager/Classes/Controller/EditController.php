<?php
namespace Gigabonus\Gbfemanager\Controller;

use In2code\Femanager\Utility\StringUtility;
use In2code\Femanager\Utility\HashUtility;
use In2code\Femanager\Utility\LocalizationUtility;
use In2code\Femanager\Utility\UserUtility;
use In2code\Femanager\Utility\FrontendUtility;
use Gigabonus\Gbbase\Utility\Helpers\MainHelper;

class EditController extends \In2code\Femanager\Controller\EditController {
    

    /**
     * action edit
     *
     * @return void
     */
    public function editAction()
    {

        $pageRenderer = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Page\PageRenderer::class);

        $pageRenderer->addJsFooterInlineCode('',"
            $(document).ready(function(){
                $(document).on(Layout.EVENT_INIT_FORMS, function() {
                    GbfemanagerEdit.init();
                });
                $(document).trigger(Layout.EVENT_INIT_FORMS);
            });
            "
        );

        parent::editAction();
    }

    
    /**
     * action update
     *
     * @param \Gigabonus\Gbfemanager\Domain\Model\User $user
     * @validate $user In2code\Femanager\Domain\Validator\ServersideValidator
     * @validate $user In2code\Femanager\Domain\Validator\PasswordValidator
     * @validate $user In2code\Femanager\Domain\Validator\CaptchaValidator
     * @return void
     */
    public function updateAction(\In2code\Femanager\Domain\Model\User $user = NULL) {
        // $this->redirectIfDirtyObject($user);
        UserUtility::convertPassword($user, $this->settings['edit']['misc']['passwordSave']);
        $this->updateAllConfirmed($user);
        $this->forward('edit');
    }

}