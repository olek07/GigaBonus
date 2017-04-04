<?php
if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	'Gigabonus.' . $_EXTKEY,
	'Languagemenu',
	'Gigabonus Languages switch menu'
);

