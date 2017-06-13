<?php
if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'Gigabonus.' . $_EXTKEY,
	'Partnerlisting',
	array(
		'Partner' => 'show,list,ajaxList,gotoPartner',
		
	),
	// non-cacheable actions
	array(
		'Partner' => 'ajaxList,gotoPartner',
		
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


$GLOBALS['TYPO3_CONF_VARS']['FE']['eID_include']['getToken'] = 'EXT:gbpartner/Classes/GetToken.php';