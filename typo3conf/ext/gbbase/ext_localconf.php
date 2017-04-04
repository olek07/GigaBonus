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
