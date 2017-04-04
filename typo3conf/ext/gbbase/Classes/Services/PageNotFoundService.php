<?php
namespace Gigabonus\Gbbase\Services;

class PageNotFoundService {
    
    /**
     * Redirect to 404 error page with language-ID provided by ext. "realurl_force404lang" (if installed)
     * Redirect to login page
     *
     * @param array $params: "currentUrl", "reasonText" and "pageAccessFailureReasons"
     * @param object $tsfeObj: object type "tslib_fe"
     */
    function pageNotFound(&$params, &$pObj) {
        // access restricted page
        if(array_shift($params['pageAccessFailureReasons']['fe_group'])) {

            $pObj->pageErrorHandler(
                '/index.php?id=' . $GLOBALS['TYPO3_CONF_VARS']['FE']['accessRestrictedPages_handling_redirectPageID'] . '&redirect_url=' . urlencode($params['currentUrl']),
                $GLOBALS['TYPO3_CONF_VARS']['FE']['accessRestrictedPages_handling_statheader'],
                $params['pageAccessFailureReasons']['reasonText']
            );
            // 404 not found
        } else {
            // handle default language
            $pObj->pageErrorHandler('/index.php?id=' . $GLOBALS['TYPO3_CONF_VARS']['FE']['pageNotFound_handling_redirectPageID'] . (array_key_exists('L', $_GET) ? '&L=' . $_GET['L'] : ''));
        }
    }
}