<?php
if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'Gigabonus.' . $_EXTKEY,
	'Transactions',
	array(
		'Transaction' => 'list, show, new, create, edit, update',
		
	),
	// non-cacheable actions
	array(
		'Transaction' => 'list, show, new, create, edit, update',
		
	)
);


\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'Gigabonus.' . $_EXTKEY,
	'Pi2',
	array(
		'Transaction' => 'bonusBalance',

	),
	// non-cacheable actions
	array(
		'Transaction' => 'bonusBalance',

	)
);
