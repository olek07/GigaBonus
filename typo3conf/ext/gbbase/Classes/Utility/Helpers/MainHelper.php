<?php
namespace Gigabonus\Gbbase\Utility\Helpers;

use TYPO3\CMS\Core\Utility\HttpUtility;

class MainHelper {
    
    const CHANGEPASSWORDPAGEID = 8;
    const CHANGEUSERDATAPAGEID = 6;
    const TRANSACTIONLISTPAGEUID = 14;
    const DELETEPROFILEPAGEID = 16;
    const PARTNERDETAILPAGEID = 17;

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


    /* ARRAY ID TO LANGUAGES WITH 2 LETTERS */

    public static $langIds = array(
        0   => 'ru',
        1   => 'uk',
    );


}