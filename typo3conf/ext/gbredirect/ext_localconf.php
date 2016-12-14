<?php
if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['tslib/class.tslib_fe.php']['determineId-PostProc'][] = 'Gigabonus\Gbredirect\Classes\Services\Redirector->redirectIfLoggedIn';

