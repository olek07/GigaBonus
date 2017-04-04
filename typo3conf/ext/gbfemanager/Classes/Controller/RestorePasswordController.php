<?php
namespace Gigabonus\Gbfemanager\Controller;

use Gigabonus\Gbbase\Utility\Helpers\MainHelper;
use \In2code\Femanager\Utility\UserUtility;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;


class RestorePasswordController extends \In2code\Femanager\Controller\AbstractController {
    
    /**
     * 
     * @param string $forgothash 
     */
    public function editAction($forgothash = null) {
        
        $compareHash = $this->getCompareHash($forgothash);
        
        if ($compareHash === NULL) {
            MainHelper::redirect2Home();
            exit;
        }
        
        if ($compareHash[0] < time()) {
            /**
             * @todo: change_password_notvalid_message
             */
            $this->view->assign('changePasswordNotvalid', TRUE);
        }
        else {
            $user = $this->findUserByForgotHash($compareHash);

            if ($user !== NULL) {
                $this->view->assign('user', $user);
                $this->view->assign('forgothash', $forgothash);
            }
            else {
                $this->view->assign('changePasswordNotvalid', TRUE);
            }
        }
    }
    
    
    /**
     * action update
     *
     * @param \Gigabonus\Gbfemanager\Domain\Model\User $user
     * @param string $forgothash
     * @validate $user In2code\Femanager\Domain\Validator\ServersideValidator
     * @validate $user In2code\Femanager\Domain\Validator\PasswordValidator
     * @return void
     */
    public function saveAction(\Gigabonus\Gbfemanager\Domain\Model\User $user = null, $forgothash = null) {
        $compareHash = $this->getCompareHash($forgothash);

        if ($compareHash === NULL) {
            exit;
        }
        if ($compareHash[0] < time() || $user === NULL) {
            /**
             * @todo: change_password_notvalid_message
             */
            $this->view->assign('changePasswordNotvalid', TRUE);
        }
        else {
            UserUtility::convertPassword($user, $this->settings['edit']['misc']['passwordSave']);

            // Save new password and clear DB-hash
            $GLOBALS['TYPO3_DB']->exec_UPDATEquery(
                'fe_users',
                'felogin_forgothash="' . $compareHash[0] . '|' . md5($compareHash[1]) . '"',
                array('password' => $user->getPassword(), 'felogin_forgotHash' => '', 'tstamp' => $GLOBALS['EXEC_TIME'])
            );

            $count = $GLOBALS['TYPO3_DB']->sql_affected_rows();

            // $this->userRepository->update($user);
            // $this->persistenceManager->persistAll();
            if ($count > 0) {
                $this->addFlashMessage('Password changed');
            }

            /**
             * @todo: what to do, if the page was reloaded after password saving?
             */
            
        }
       // $this->redirectToUri('/ru/my-account/login/');

    }
    
    /**
     * 
     * @param string $forgothash
     * @return array
     */
    private function getCompareHash($forgothash) {
        $compareHash = explode('|', $forgothash);
        
        if (!is_array($compareHash) || count($compareHash) !== 2) {
            return NULL;
        }
        return $compareHash;
    }
    
    /**
     * 
     * @param array $compareHash
     * @return \Gigabonus\Gbfemanager\Domain\Model\User $user
     */
    private function findUserByForgotHash($compareHash) {
        $query = $this->userRepository->createQuery();
        $query->matching(
            $query->equals("felogin_forgothash", $compareHash[0] . '|' . md5($compareHash[1]))
        );
        $user = $query->execute()->getFirst();
        
        return $user;
    }
}

