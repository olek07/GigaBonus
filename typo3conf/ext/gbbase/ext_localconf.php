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

### $TYPO3_CONF_VARS['SC_OPTIONS']['tslib/class.tslib_fe.php']['hook_eofe']['metaTags'] = 'Gigabonus\Gbbase\Hooks\MetaTagsHook->hookEofe';


### $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['tslib/class.tslib_fe.php']['settingLanguage_postProcess']['metaTags'] = 'Gigabonus\Gbbase\Hooks\MetaTagsHook->setPageTitle';
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['tslib/class.tslib_fe.php']['contentPostProc-all']['metaTags'] = 'Gigabonus\Gbbase\Hooks\MetaTagsHook->setPageTitle';