<?php
namespace Gigabonus\Gbbase\Hooks;


use Gigabonus\Gbbase\Utility\Helpers\MainHelper;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\HttpUtility;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;
use TYPO3\CMS\Frontend\Exception;

/**
 *
 * @author Alexander Averbuch <alav@gmx.net>
 */
class MetaTagsHook  {


    public function setPageTitle($params, $obj) {
        $pageTitle = $obj->page['subtitle'] ? $obj->page['subtitle'] : $obj->page['title'];
        $GLOBALS['TSFE']->altPageTitle = $pageTitle;
        // DebuggerUtility::var_dump($GLOBALS['TSFE']->page);
    }


    /**
     * @param array $params
     * @param \TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController $obj
     */
    public function hookEofe($params, $obj)
    {

        $pageTitle = $obj->page['subtitle'] ? $obj->page['subtitle'] : $obj->page['title'];
        // $obj->content = str_replace('###PRODUCTPILOT_DESCRIPTION###', $obj->page['description'], $obj->content);
        $obj->content = str_replace('###GIGABONUS_TITLE###', $pageTitle . ' — ' . MainHelper::$titleSuffix[$GLOBALS['TSFE']->lang], $obj->content);
        // $obj->content = str_replace('###PRODUCTPILOT_KEYWORDS###', $obj->page['keywords'], $obj->content);

        /* PPR-1727 -> Meta-Tag Generator raus nehmen */
        // $obj->content = str_replace('<meta name="generator" content="TYPO3 CMS" />', "", $obj->content);

    }

}
