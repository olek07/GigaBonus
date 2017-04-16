<?php

namespace Gigabonus\Gbredirect\Hooks;

use Gigabonus\Gbbase\Utility\Helpers\MainHelper;
use In2code\Femanager\Utility\StringUtility;
use TYPO3\CMS\Core\Utility\HttpUtility;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;

class TyposcriptFrontendConrollerHook  {

    /**
     * @param array $params
     * @param \TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController $obj
     */
    public function redirectToStandardLanguageIfNotSet($params, $obj) {

        $requestUri = $_SERVER['REQUEST_URI'];

        // cancel if no valid t3 Page link
        if ($this->isNotT3RealUrlPageLink($requestUri)) {
            return;
        }


        // wenn die Seite ohne Sprachkürzel aufgerufen, umleitung auf die 'ru'-Seite
        if (!preg_match('~^/[a-z]{2}/~', $requestUri)) {

            if ($GLOBALS['TSFE']->fe_user->user != NULL) {
                $lang = MainHelper::$langIds[$GLOBALS['TSFE']->fe_user->user['language']];
            }
            else {
                $lang = 'ru';
            }

            $redirectTo = $_SERVER["REQUEST_SCHEME"] . '://' . $_SERVER["HTTP_HOST"] . '/' . $lang . $requestUri;
            HttpUtility::redirect($redirectTo, HttpUtility::HTTP_STATUS_307);
            exit;
        }

    }

    protected function isNotT3RealUrlPageLink($url){

        $retVal = FALSE;

        $noPageUrlPattern = '/^(\/typo3temp|\/typo3conf|\/fileadmin)/';

        // first check for no realurl link
        if(stristr($url, 'index.php')
            || (isset($_GET['type']) && $_GET['type'] != 0)
            || preg_match($noPageUrlPattern, $url)
            || StringUtility::endsWith(strtolower($url),'.jpg')
            || StringUtility::endsWith(strtolower($url),'.png')
            || StringUtility::endsWith(strtolower($url),'.gif')
            || StringUtility::endsWith(strtolower($url),'.giff')
            || StringUtility::endsWith(strtolower($url),'.jpeg')
            || StringUtility::endsWith(strtolower($url),'.pdf')
            || StringUtility::endsWith(strtolower($url),'.doc')
            || StringUtility::endsWith(strtolower($url),'.xdoc')
            || StringUtility::endsWith(strtolower($url),'.otf')
            || StringUtility::endsWith(strtolower($url),'.ppt')
        )
        {
            $retVal = TRUE;
        }

        return $retVal;
    }


}