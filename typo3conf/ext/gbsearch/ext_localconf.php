<?php
if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'Gigabonus.' . $_EXTKEY,
	'Search',
	array(
		'Search' => 'search,ajaxSearch',
		
	),
	// non-cacheable actions
	array(
		'Search' => 'search,ajaxSearch',
		
	)
);


\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'Gigabonus.' . $_EXTKEY,
	'SuggestSearch',
	array(
		'SuggestSearch' => 'search',
		
	),
	// non-cacheable actions
	array(
		'SuggestSearch' => 'search',
		
	)
);

