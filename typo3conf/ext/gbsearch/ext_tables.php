<?php
if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	'Gigabonus.' . $_EXTKEY,
	'Search',
	'Gigabonus Search'
);


\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	'Gigabonus.' . $_EXTKEY,
	'SuggestSearch',
	'Gigabonus SuggestSearch'
);
