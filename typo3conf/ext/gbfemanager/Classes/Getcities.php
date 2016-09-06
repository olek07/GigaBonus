<?php
namespace Productpilot\Ppbase\Utility;
use \TYPO3\CMS\Core\Utility\GeneralUtility;
use \TYPO3\CMS\Extbase\Utility\DebuggerUtility;
use \TYPO3\CMS\Frontend\Utility\EidUtility;

class CacheAjax {

    /**
     * @var string
     */
    protected $accountId = '';

    public function __construct($TYPO3_CONF_VARS, $language = 'de') {
        try {
            /**
            * @var \TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController
            */
            $GLOBALS['TSFE'] = GeneralUtility::makeInstance('\\TYPO3\\CMS\\Frontend\\Controller\\TypoScriptFrontendController', $TYPO3_CONF_VARS, null, 0, TRUE);
            $GLOBALS['TSFE']->initFeUser();
            $GLOBALS['TSFE']->set_no_cache();

            $GLOBALS['TSFE']->page['doktype'] = 0;
            $GLOBALS['TSFE']->lang = $language;


            if($GLOBALS['TSFE']->fe_user->user){
                $loginData = $GLOBALS['TSFE']->fe_user->getKey('ses', 'loginData');
                if(isset($loginData['accountId']) && $loginData['accountId'] != ''){
                     $this->accountId = $loginData['accountId'];
                }
                else {
                    throw new \Exception('No accountId found');
                }
            }
            else {
                throw new \Exception('No user logged in');
            }

        }
        catch (\Exception $e) {
            header('Content-Type: application/json');
            echo '{}';
            exit;
        }

    }

    public function run() {
        header('Content-Type: application/json');
        try {
            /** @var \Productpilot\Ppesb\Service\Requests\NotificationRequest $notificationRequest */
            $notificationRequest = GeneralUtility::makeInstance('Productpilot\\Ppesb\\Service\\Requests\\NotificationRequest');
            $response = $notificationRequest->getResponse();
            $data = $response->getRawData();

            // wenn newMatchings vorhanden sind, notifikaction zurücksetzen über den Request
            // http://esb-test.intern.messefrankfurt.com:8080/api/1.00/MF-APP-000003/profile/user/MF-ACC-THPOTX/bm-search/notifications
            if ($data->result->newMatchings && GeneralUtility::_GET('resetNotification') == 1) {
                /**
                 * delete the notifications
                 * @var $esbRequest \Productpilot\Ppesb\Service\Requests\BusinessMatchingSearchNotificationsDeleteRequest
                 */
                try {
                    $esbRequest = GeneralUtility::makeInstance('Productpilot\\Ppesb\\Service\\Requests\\BusinessMatchingSearchNotificationsDeleteRequest', $this->accountId);
                    $esbRequest->getResponse();
                }
                catch(\Exception $e) {
                    // the result is not relevant for this case
                }
            }
            $bubbles = '{}';
            if ($data->success) {
                unset($data->result->newsletter);
                $bubbles = json_encode($data->result);
            }


            /**
            * @var \Productpilot\Ppuserprofile\Utility\Helper\RequestDataHelper $requestDataHelper
            */
            $requestDataHelper = GeneralUtility::makeInstance('Productpilot\\Ppuserprofile\\Utility\\Helper\\RequestDataHelper');
            $userData = $requestDataHelper->getReducedProfileData($this->accountId);


            // Zuerst die Hauptfirma (isMainCompany : true) und dann alphabetisch sortieren
            usort($userData->companyWithRoles, array('Productpilot\Ppesb\Utility\Helpers\MainHelper', 'sortCompanies'));

            // Die 1. Firma finden, wo rewriteId != NULL (mainCompany kann rewriteId = NULL haben)
            $mainCompany = '{}';
            if (is_object($userData)) {
                foreach ((array)$userData->companyWithRoles as $companyData) {
                    if (isset($companyData->rewriteId) && $companyData->rewriteId != NULL) {
                        $mainCompany = '{"companyId":"' . $companyData->rewriteId . '"}';
                        break;
                    }
                }
            }

            echo "{\n"
                . '"bubbles":' . $bubbles
                . ",\n"
                . '"companyId":' . $mainCompany
                . "\n}"
            ;
        }
        catch(\Exception $e) {
            echo '{}';
        }

    }
}
$start = microtime(true);

global $TYPO3_CONF_VARS;
$eid = GeneralUtility::makeInstance('\\Productpilot\\Ppbase\\Utility\CacheAjax', $TYPO3_CONF_VARS, GeneralUtility::_GET('lang'));
$eid->run();

$end = microtime(true);

// \Productpilot\Ppesb\Utility\Helpers\MainHelper::writeEsbIdpTimesLog($start, $end);