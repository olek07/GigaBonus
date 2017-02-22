<?php
if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'Gigabonus.' . $_EXTKEY,
	'Languagemenu',
	array(
		'Menu' => 'show',
		
	),
	// non-cacheable actions
	array(
		'Menu' => '',
		
	)
);


