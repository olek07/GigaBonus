<?php
namespace Gigabonus\Gbfelogin\Xclass;

use \TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Mail\MailMessage;

class FrontendLoginController extends \TYPO3\CMS\Felogin\Controller\FrontendLoginController {
    
    /**
     * Object Manager
     *
     * @var \TYPO3\CMS\Extbase\Object\ObjectManagerInterface
     */
    protected $objectManager;


    /**
     * Generates a hashed link and send it with email
     *
     * @param array $user Contains user data
     * @return string Empty string with success, error message with no success
     */
    protected function generateAndSendHash($user)
    {
        $hours = (int)$this->conf['forgotLinkHashValidTime'] > 0 ? (int)$this->conf['forgotLinkHashValidTime'] : 24;
        $validEnd = time() + 3600 * $hours;
        $validEndString = date($this->conf['dateFormat'], $validEnd);
        $hash = md5(GeneralUtility::generateRandomBytes(64));
        $randHash = $validEnd . '|' . $hash;
        $randHashDB = $validEnd . '|' . md5($hash);
        // Write hash to DB
        $res = $this->databaseConnection->exec_UPDATEquery('fe_users', 'uid=' . $user['uid'], array('felogin_forgotHash' => $randHashDB));
        // Send hashlink to user
        $this->conf['linkPrefix'] = -1;
        $isAbsRefPrefix = !empty($this->frontendController->absRefPrefix);
        $isBaseURL = !empty($this->frontendController->baseUrl);
        $isFeloginBaseURL = !empty($this->conf['feloginBaseURL']);
        $link = $this->pi_getPageLink($this->conf['restorePasswordPageUid'], '', array(
            rawurlencode('tx_femanager_pi1[forgothash]') => $randHash,
            'L' => 1
        ));
        
        // Prefix link if necessary
        if ($isFeloginBaseURL) {
            // First priority, use specific base URL
            // "absRefPrefix" must be removed first, otherwise URL will be prepended twice
            if ($isAbsRefPrefix) {
                $link = substr($link, strlen($this->frontendController->absRefPrefix));
            }
            $link = $this->conf['feloginBaseURL'] . $link;
        } elseif ($isAbsRefPrefix) {
            // Second priority
            // absRefPrefix must not necessarily contain a hostname and URL scheme, so add it if needed
            $link = GeneralUtility::locationHeaderUrl($link);
        } elseif ($isBaseURL) {
            // Third priority
            // Add the global base URL to the link
            $link = $this->frontendController->baseUrlWrap($link);
        } else {
            // No prefix is set, return the error
            return $this->pi_getLL('ll_change_password_nolinkprefix_message');
        }
        \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($user);
                
        $this->sendMailWithLink($user['email'], $link);
        echo $link;exit;
        $msg = sprintf($this->pi_getLL('ll_forgot_validate_reset_password'), $user['username'], $link, $validEndString);
        // Add hook for extra processing of mail message
        if (
            isset($GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['felogin']['forgotPasswordMail'])
            && is_array($GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['felogin']['forgotPasswordMail'])
        ) {
            $params = array(
                'message' => &$msg,
                'user' => &$user
            );
            foreach ($GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['felogin']['forgotPasswordMail'] as $reference) {
                if ($reference) {
                    GeneralUtility::callUserFunction($reference, $params, $this);
                }
            }
        }
        if ($user['email']) {
            $this->cObj->sendNotifyEmail($msg, $user['email'], '', $this->conf['email_from'], $this->conf['email_fromName'], $this->conf['replyTo']);
        }

        return '';
    }
    
    private function sendMailWithLink($receiver, $link) {
        
        $this->objectManager = GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');
        $email = $this->objectManager->get(MailMessage::class);
        $email
            ->setTo($receiver)
            ->setFrom('sashaost@mail.ru')
            ->setSubject($subject)
            ->setCharset($GLOBALS['TSFE']->metaCharset)
            ->setBody('<a href="' . $link . '">dddd</a>', 'text/html');
        $email->send();
        
        \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($email->isSent());
        

    }

}
