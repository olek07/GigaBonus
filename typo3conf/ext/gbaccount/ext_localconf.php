<?php
if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'Gigabonus.' . $_EXTKEY,
	'Transactions',
	array(
		'Transaction' => 'list, show',
		
	),
	// non-cacheable actions
	array(
		'Transaction' => 'list, show',
		
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

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'Gigabonus.' . $_EXTKEY,
	'Dashboard',
	array(
		'Dashboard' => 'index',

	),
	// non-cacheable actions
	array(
                'Dashboard' => 'index',
	)
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'Gigabonus.' . $_EXTKEY,
	'Payment',
	array(
		'Payment' => 'index',

	),
	// non-cacheable actions
	array(
                'Payment' => 'index',
	)
);

