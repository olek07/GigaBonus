<?php
if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}


$GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects']['TYPO3\\CMS\\Felogin\\Controller\\FrontendLoginController'] = array(
    'className' => 'Gigabonus\\Gbfelogin\\Xclass\\FrontendLoginController'
);


$GLOBALS['TYPO3_CONF_VARS']['SYS']['locallangXMLOverride']['EXT:felogin/Resources/Private/Language/locallang.xlf'][]
    = 'EXT:gbfelogin/Resources/Private/Language/locallang.xlf';
