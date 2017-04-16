<?php
if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['tslib/class.tslib_fe.php']['determineId-PostProc'][] = 'Gigabonus\Gbredirect\Classes\Services\Redirector->redirectIfLoggedIn';


/**
 * Hook redirect to language if not specified
 */
$TYPO3_CONF_VARS['SC_OPTIONS']['tslib/class.tslib_fe.php']['initFEuser']['langredirect'] =
    'EXT:gbredirect/Classes/Hooks/TyposcriptFrontendConrollerHook.php:Gigabonus\Gbredirect\Hooks\TyposcriptFrontendConrollerHook->redirectToStandardLanguageIfNotSet';
