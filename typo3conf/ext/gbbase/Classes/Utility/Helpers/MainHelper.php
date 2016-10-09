<?php
namespace Gigabonus\Gbbase\Utility\Helpers;

use TYPO3\CMS\Core\Utility\HttpUtility;

class MainHelper {
    
    const CHANGEPASSWORDPAGEID = 8;
    const CHANGEUSERDATAPAGEID = 6;
    const DELETEPROFILEPAGEID = 16;

    public static function redirect2Home() {
        $url = $GLOBALS['TSFE']->cObj->typoLink_URL(
            array(
                'parameter' => 1,
                // 'forceAbsoluteUrl' => true,
            )
        );
        HttpUtility::redirect($url);
    }
    
    public static function redirect2DeleteProfilePage() {
        $url = $GLOBALS['TSFE']->cObj->typoLink_URL(
            array(
                'parameter' => self::DELETEPROFILEPAGEID,
            )
        );
        HttpUtility::redirect($url);
        
    }
    
}