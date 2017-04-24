<?php
namespace Gigabonus\Gbredirect\Services;


use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;

class PageNotFoundService {

    /**
     * pageNotFound
     *
     * @param $params
     * @param \TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController $conf
     */
    public function pageNotFound($params, $conf = null)
    {

        // Prepare headers
        $headerArr = [
            'User-agent: ' . GeneralUtility::getIndpEnv('HTTP_USER_AGENT'),
            'Referer: ' . GeneralUtility::getIndpEnv('TYPO3_REQUEST_URL'),
        ];

        // keep session and cookies
        $curl_COOKIE_arr = array();

        if(sizeof($_COOKIE)){
            foreach($_COOKIE as $name => $value){
                $curl_COOKIE_arr[] = $name .'=' . $value;
            }
            $curl_COOKIE = implode('; ', $curl_COOKIE_arr);

            $headerArr[] = 'Cookie: ' . $curl_COOKIE;
        }


        /**
            check if the page belongs to the restricted area (my account)
            if yes, show the page "Please login"
            pageAccessFailureReasons is set in \TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController::getPageAccessFailureReasons
        */
        
        $requestedId = NULL;
        if ($conf != NULL) {
            $requestedId = $conf->getRequestedId();
        }
        if (($requestedId !== NULL) && isset($params['pageAccessFailureReasons']['fe_group'][$requestedId])) {
            $url = 'http://' . $_SERVER["HTTP_HOST"] . '/index.php?id=' . $GLOBALS['TYPO3_CONF_VARS']['FE']['accessRestrictedPages_handling_redirectPageID'] . '&L=' . GeneralUtility::_GET('L');
            $content = GeneralUtility::getUrl($url, 0, $headerArr);
        }
        else {
            // Link to the 404-page (uid = 18)
            $url = 'http://' . $_SERVER["HTTP_HOST"] . '/index.php?id=' . $GLOBALS['TYPO3_CONF_VARS']['FE']['pageNotFound_handling_redirectPageID'] . '&L=' . GeneralUtility::_GET('L');
            $content = GeneralUtility::getUrl($url, 0, $headerArr);
        }

        echo $content;
        exit;
    }

}