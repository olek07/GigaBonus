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
        $pageUid = $GLOBALS['TSFE']->id;

        $pageRenderer = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Page\PageRenderer::class);
        $lang = (int) \TYPO3\CMS\Core\Utility\GeneralUtility::_GET('L');
        /*
        $pageRenderer->addJsFooterInlineCode('',
            "jQuery(document).ready(function(){
                Gbfemanager.init($lang, $pageUid);
            });"
        );
*/
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
    public function updateAction(\Gigabonus\Gbfemanager\Domain\Model\User $user = NULL) {
        if (($user !== NULL) && ($GLOBALS['TSFE']->fe_user->user['uid']) ==  $user->getUid()) {

            // $this->redirectIfDirtyObject($user);
            $user = FrontendUtility::forceValues($user, $this->config['edit.']['forceValues.']['beforeAnyConfirmation.']);
            $this->emailForUsername($user);
            UserUtility::convertPassword($user, $this->settings['edit']['misc']['passwordSave']);
            $this->signalSlotDispatcher->dispatch(__CLASS__, __FUNCTION__ . 'BeforePersist', [$user, $this]);
            if (!empty($this->settings['edit']['confirmByAdmin'])) {
                $this->updateRequest($user);
            } else {
                $this->updateAllConfirmed($user);
            }
            $this->forward('edit');


            // parent::updateAction($user);
        }
        else {
            // Versuch die uid im FireBug oder Ähnlichem zu manipulieren 
            throw new \Exception('');
        }
    }

}