<?php
namespace Gigabonus\Gbfemanager\Controller;

use TYPO3\CMS\Extbase\Reflection\ObjectAccess;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;
use In2code\Femanager\Utility\ObjectUtility;
use In2code\Femanager\Utility\LocalizationUtility;
use TYPO3\CMS\Core\Messaging\FlashMessage;



class ChangeMobileNumberController extends \In2code\Femanager\Controller\EditController {
    
    
    
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




        // $timeToPasswordChange = 0;
        $this->view->assign('timeToPasswordChange', $timeToPasswordChange);

        parent::editAction();
    }
    
    
    /**
     * action update
     *
     * @param \Gigabonus\Gbfemanager\Domain\Model\User $user
     * @validate $user In2code\Femanager\Domain\Validator\ServersideValidator
     * @validate $user In2code\Femanager\Domain\Validator\CaptchaValidator
     * @return void
     */
    public function updateAction(\In2code\Femanager\Domain\Model\User $user = null) {
        
        if (($user !== NULL) && ($GLOBALS['TSFE']->fe_user->user['uid']) ==  $user->getUid()) {

            if (!ObjectUtility::isDirtyObject($user)) {
                $this->addFlashMessage(LocalizationUtility::translate('noChanges'), '', FlashMessage::NOTICE);
                $this->forward('edit');
            }

            $telephonelastchanged = ObjectAccess::getProperty($user, 'txGbfemanagerTelephonelastchanged');



            $date = new \DateTime();
            $date->setTimestamp(time());

            $user->setTxGbfemanagerTelephonelastchanged($date);


            $this->updateAllConfirmed($user);
            $this->forward('edit');


            # parent::updateAction($user);
        }
        else {
            // Versuch die uid im FireBug oder Ähnlichem zu manipulieren 
            exit;
        }
    }

}