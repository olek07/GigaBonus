<?php
if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'Gigabonus.' . $_EXTKEY,
	'Partnerlisting',
	array(
		'Partner' => 'list,show',
		
	),
	// non-cacheable actions
	array(
		'Partner' => 'list,show',
		
	)
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'Gigabonus.' . $_EXTKEY,
	'Categorylisting',
	array(
		'Category' => 'list',
		
	),
	// non-cacheable actions
	array(
		'Category' => 'list',
		
	)
);
