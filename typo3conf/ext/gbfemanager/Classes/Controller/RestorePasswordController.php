<?php
namespace Gigabonus\Gbfemanager\Controller;

use \In2code\Femanager\Utility\UserUtility;


class RestorePasswordController extends \In2code\Femanager\Controller\AbstractController {
    
    /**
     * 
     * @param string $forgothash 
     */
    public function editAction($forgothash = null) {
        
        if ($forgothash == NULL) {
            exit;
        }
        else {
            // $user = $this->userRepository->findByUid(1);
            $compareHash = explode('|', $forgothash);
            if ($compareHash[0] < time()) {
                /**
                 * @todo: change_password_notvalid_message
                 */
            }
            else {
                $query = $this->userRepository->createQuery();
                $query->matching(
                    $query->equals("felogin_forgothash", $compareHash[0] . '|' . md5($compareHash[1]))
                );
                $user = $query->execute()->getFirst();
                
                if ($user !== NULL) {
                    $this->view->assign('user', $user);
                }
                else {
                    echo 123;
                    exit;
                }
            }
        }
    }
    
    
    /**
     * action update
     *
     * @param User $user
     * @validate $user In2code\Femanager\Domain\Validator\ServersideValidator
     * @validate $user In2code\Femanager\Domain\Validator\PasswordValidator
     * @return void
     */
    public function saveAction(\Gigabonus\Gbfemanager\Domain\Model\User $user) {
        // \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($user);
        
        UserUtility::convertPassword($user, $this->settings['edit']['misc']['passwordSave']);
        $this->userRepository->update($user);
        $this->persistenceManager->persistAll();
        $this->addFlashMessage('Password changed');

       // $this->redirectToUri('/ru/my-account/login/');

    }
}

