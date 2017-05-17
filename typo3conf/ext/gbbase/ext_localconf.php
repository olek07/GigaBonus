<?php

if (!defined('TYPO3_MODE')) {
    die('Access denied.');
}

/**
 * XCLASS adjustment of fatal error page template
 */

$GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects']['TYPO3\\CMS\\Core\\Messaging\\ErrorpageMessage'] = array(
    'className' => 'Gigabonus\\Gbbase\\Xclass\\ErrorpageMessage'
);

/**
 * replace the title-tag if the page subtitle is set
 */
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_pagerenderer.php']['render-postProcess']['metaTags'] = 'Gigabonus\Gbbase\Hooks\MetaTagsHook->setPageTitle';