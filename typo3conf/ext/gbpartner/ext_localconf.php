<?php
if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'Gigabonus.' . $_EXTKEY,
	'Partnerlisting',
	array(
		'Partner' => 'show,list,gotoPartner',
		
	),
	// non-cacheable actions
	array(
		'Partner' => 'gotoPartner',
		
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
		'Category' => '',
		
	)
);
