<?php
namespace Gigabonus\Gbredirect\Services;


use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;

class PageNotFoundService {

    /**
     * pageNotFound
     *
     * @param $params
     * @param $conf
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

        $linkConf = array(
            'parameter' => 18,
            'additionalParams' => '&L=' . GeneralUtility::_GET('L'),
        );


        // Link to the 404-page (uid = 18)
        $url = 'http://' . $_SERVER["HTTP_HOST"] . '/index.php?id=18&L=' . GeneralUtility::_GET('L');
        $content= GeneralUtility::getUrl($url, 0, $headerArr);
        echo $content;
        exit;
    }

}