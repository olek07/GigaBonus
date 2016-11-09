<?php
namespace Gigabonus\Gbfemanager\Controller;

use In2code\Femanager\Utility\StringUtility;
use In2code\Femanager\Utility\HashUtility;
use In2code\Femanager\Utility\LocalizationUtility;
use In2code\Femanager\Utility\UserUtility;
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
        $pageRenderer->addJsFooterInlineCode('',
            "jQuery(document).ready(function(){
                Gbfemanager.init($lang, $pageUid);
            });"
        );

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
            parent::updateAction($user);
        }
        else {
            // Versuch die uid im FireBug oder Ähnlichem zu manipulieren 
            throw new \Exception('');
            exit;
        }
        
        /*
        $dateOfBirth = \DateTime::createFromFormat('d.m.Y', $this->request->getArgument('user')['dateOfBirth']);
        $valid = \DateTime::getLastErrors();         
        
        if ($valid['warning_count'] == 0 && $valid['error_count'] == 0) {
            parent::updateAction($user);
        }
        else {
            $user->setDateOfBirth($dateOfBirth);
            $this->addFlashMessage('Date is false', '', \TYPO3\CMS\Core\Messaging\FlashMessage::ERROR);
            $this->forward('edit');
        }
         * 
         */
    }

}