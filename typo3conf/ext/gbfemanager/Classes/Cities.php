<?php
namespace Gigabonus\Gbfemanager\Utility;
use \TYPO3\CMS\Core\Utility\GeneralUtility;
use \TYPO3\CMS\Extbase\Utility\DebuggerUtility;
use \TYPO3\CMS\Frontend\Utility\EidUtility;

class Cities {

    /**
     * @var string
     */
    protected $accountId = '';

    public function __construct($TYPO3_CONF_VARS, $term, $language = 'ru') {
        $citiesList = array();
        $term = trim($term);
        $term = preg_replace('~\s{1,}~' , ' ',  $term);
        
        if (!in_array($language, array('ru', 'ua'))) {
            exit;
        }
        
        try {
            
            $res = $GLOBALS['TYPO3_DB']->exec_SELECTquery('*', 'cities', 'name_' . $language . ' LIKE "' . $term .'%"', $groupBy, 'name_' . $language, '');

            
            if ($GLOBALS['TYPO3_DB']->sql_num_rows($res)) {                             
                while($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res)){
                  $citiesList[] = array('id' => $row['id'], 'value' => trim($row['name_' . $language]));  
                }
            }
            
            if (is_array($citiesList) && count($citiesList) > 0)
            {
                header('Content-Type: application/json');
                echo json_encode($citiesList);
            }
            
             exit;
            
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

            // wenn newMatchings vorhanden sind, notifikaction zur�cksetzen �ber den Request
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

global $TYPO3_CONF_VARS;

# echo '[{"id":"17206","value":"\u0412\u0438\u043d\u043d\u0438\u043a\u0438 (\u0411\u0440\u0435\u0443\u0441\u0438\u0432\u0441\u044c\u043a\u0430), \u041a\u043e\u0437\u0435\u043b\u044c\u0449\u0438\u043d\u0441\u043a\u0438\u0439 \u0440\u0430\u0439\u043e\u043d, \u041f\u043e\u043b\u0442\u0430\u0432\u0441\u043a\u0430\u044f \u043e\u0431\u043b\u0430\u0441\u0442\u044c"},{"id":"12906","value":"\u0412\u0438\u043d\u043d\u0438\u043a\u0438, \u0414\u0440\u043e\u0433\u043e\u0431\u044b\u0447\u0441\u043a\u0438\u0439 \u0440\u0430\u0439\u043e\u043d, \u041b\u044c\u0432\u043e\u0432\u0441\u043a\u0430\u044f \u043e\u0431\u043b\u0430\u0441\u0442\u044c"},{"id":"23329","value":"\u0412\u0438\u043d\u043d\u0438\u043a\u0438, \u041d\u043e\u0432\u043e\u0432\u043e\u0434\u043e\u043b\u0430\u0436\u0441\u043a\u0438\u0439 \u0440\u0430\u0439\u043e\u043d, \u0425\u0430\u0440\u044c\u043a\u043e\u0432\u0441\u043a\u0430\u044f \u043e\u0431\u043b\u0430\u0441\u0442\u044c"},{"id":"630","value":"\u0412\u0438\u043d\u043d\u0438\u043a\u043e\u0432\u0446\u044b, \u041b\u0438\u0442\u0438\u043d\u0441\u043a\u0438\u0439 \u0440\u0430\u0439\u043e\u043d, \u0412\u0438\u043d\u043d\u0438\u0446\u043a\u0430\u044f \u043e\u0431\u043b\u0430\u0441\u0442\u044c"},{"id":"141","value":"\u0412\u0438\u043d\u043d\u0438\u0446\u0430"},{"id":"22207","value":"\u0412\u0438\u043d\u043d\u0438\u0446\u043a\u0438\u0435 \u0418\u0432\u0430\u043d\u044b, \u0411\u043e\u0433\u043e\u0434\u0443\u0445\u043e\u0432\u0441\u043a\u0438\u0439 \u0440\u0430\u0439\u043e\u043d, \u0425\u0430\u0440\u044c\u043a\u043e\u0432\u0441\u043a\u0430\u044f \u043e\u0431\u043b\u0430\u0441\u0442\u044c"},{"id":"10639","value":"\u0412\u0438\u043d\u043d\u0438\u0446\u043a\u0438\u0435 \u0421\u0442\u0430\u0432\u044b, \u0412\u0430\u0441\u0438\u043b\u044c\u043a\u043e\u0432\u0441\u043a\u0438\u0439 \u0440\u0430\u0439\u043e\u043d, \u041a\u0438\u0435\u0432\u0441\u043a\u0430\u044f \u043e\u0431\u043b\u0430\u0441\u0442\u044c"},{"id":"146","value":"\u0412\u0438\u043d\u043d\u0438\u0446\u043a\u0438\u0435 \u0425\u0443\u0442\u043e\u0440\u0430, \u0412\u0438\u043d\u043d\u0438\u0446\u043a\u0438\u0439 \u0440\u0430\u0439\u043e\u043d, \u0412\u0438\u043d\u043d\u0438\u0446\u043a\u0430\u044f \u043e\u0431\u043b\u0430\u0441\u0442\u044c"},{"id":"2284","value":"\u0412\u0438\u043d\u043d\u0438\u0446\u043a\u043e\u0435, \u0421\u0438\u043c\u0444\u0435\u0440\u043e\u043f\u043e\u043b\u044c\u0441\u043a\u0438\u0439 \u0440\u0430\u0439\u043e\u043d, \u0410\u0420 \u041a\u0440\u044b\u043c"},{"id":"6275","value":"\u0412\u0438\u043d\u043d\u0438\u0446\u043a\u043e\u0435, \u0428\u0430\u0445\u0442\u0435\u0440\u0441\u043a\u0438\u0439 \u0440\u0430\u0439\u043e\u043d, \u0414\u043e\u043d\u0435\u0446\u043a\u0430\u044f \u043e\u0431\u043b\u0430\u0441\u0442\u044c"},{"id":"13700","value":"\u0412\u0438\u043d\u043d\u0438\u0447\u043a\u0438, \u041f\u0443\u0441\u0442\u043e\u043c\u044b\u0442\u043e\u0432\u0441\u043a\u0438\u0439 \u0440\u0430\u0439\u043e\u043d, \u041b\u044c\u0432\u043e\u0432\u0441\u043a\u0430\u044f \u043e\u0431\u043b\u0430\u0441\u0442\u044c"}]';
# exit;
$eid = GeneralUtility::makeInstance(\Gigabonus\Gbfemanager\Utility\Cities::class, $TYPO3_CONF_VARS, GeneralUtility::_GET('term'), GeneralUtility::_GET('lang'));
# $eid->run();
