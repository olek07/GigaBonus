<?php
namespace Gigabonus\Gbbase\Utility\Helpers;

use TYPO3\CMS\Core\Utility\HttpUtility;

class MainHelper {
    
    const LOGINPAGEID = 3;
    const CHANGEPASSWORDPAGEID = 8;
    const CHANGEUSERDATAPAGEID = 6;
    const TRANSACTIONLISTPAGEUID = 14;
    const DELETEPROFILEPAGEID = 16;
    const PARTNERDETAILPAGEID = 17;
    const CONTACTPAGEID = 24;
    const DASHBOARDPAGEID = 23;

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

    public static function redirect2ChangePasswordPage() {
        self::redirect2Page(self::CHANGEPASSWORDPAGEID);
    }

    
    public static function getDashboardPageUrl() {
        $url = $GLOBALS['TSFE']->cObj->typoLink_URL(
            array(
                'parameter' => self::DASHBOARDPAGEID,
            )
        );
        
        return $url;
    }
    
    public static function redirect2Page($pageId) {
        $url = $GLOBALS['TSFE']->cObj->typoLink_URL(
            array(
                'parameter' => $pageId,
            )
        );
        HttpUtility::redirect($url);
    }

    public static function setTitleTag($title) {
        $GLOBALS['TSFE']->page['title'] = $title . ' - ' . self::$titleSuffix[$GLOBALS['TSFE']->lang];
    }


    /* ARRAY ID TO LANGUAGES WITH 2 LETTERS */

    public static $langIds = array(
        0   => 'ru',
        1   => 'uk',
    );

    public static $titleSuffix = array(
        'ru' => 'Бонусная система GigaBonus',
        'uk' => 'Бонусна система GigaBonus'
    );


}