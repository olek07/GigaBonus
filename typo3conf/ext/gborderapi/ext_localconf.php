<?php
if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'Gigabonus.' . $_EXTKEY,
	'Pi1',
	array(
		'Order' => 'new, create',
		
	),
	// non-cacheable actions
	array(
		'Order' => 'create',
		
	)
);
