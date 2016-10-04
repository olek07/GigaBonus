<?php
namespace Gigabonus\Gbbase\Utility\Helpers;

use TYPO3\CMS\Core\Utility\HttpUtility;

class MainHelper {

    public static function redirect2Home() {
        $url = $GLOBALS['TSFE']->cObj->typoLink_URL(
            array(
                'parameter' => 1,
                // 'forceAbsoluteUrl' => true,
            )
        );
        HttpUtility::redirect($url);
    }
    
}