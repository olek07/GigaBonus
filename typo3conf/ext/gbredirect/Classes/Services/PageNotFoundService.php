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


        $res = GeneralUtility::getUrl('http://gigabonus.dev/uk/404/', 0, $headerArr);

        // Header and content are separated by an empty line
        list($header, $content) = explode(CRLF . CRLF, $res, 2);
        // There can be multiple header blocks when using a proxy with cURL
        while (substr($content, 0, 4) === 'HTTP') {
            list($header, $content) = explode(CRLF . CRLF, $content, 2);
        }
        $content .= CRLF;

        echo $res;

    }
}