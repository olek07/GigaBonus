<?php
if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'Gigabonus.' . $_EXTKEY,
	'Search',
	array(
		'Search' => 'search',
		
	),
	// non-cacheable actions
	array(
		'Search' => 'search',
		
	)
);

