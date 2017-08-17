<?php
if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'Gigabonus.' . $_EXTKEY,
	'Partnerlisting',
	array(
		'Partner' => 'show,list,ajaxList,gotoPartner,getPartnerToken',
		
	),
	// non-cacheable actions
	array(
		'Partner' => 'ajaxList,gotoPartner,getPartnerToken',
		
	)
);


// generation of the goto link on the partner page (showAction)
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'Gigabonus.' . $_EXTKEY,
	'Generatelink',
	array(
		'Partner' => 'generateGotoLink',

	),
	// non-cacheable actions
	array(
		'Partner' => 'generateGotoLink',

	)
);


// used on the 'go-to-partner' page. gets by using ajax the session id and token from the partner website
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'Gigabonus.' . $_EXTKEY,
	'GotoPartner',
	array(
		'GotoPartner' => 'gotoPartner',
	),
	// non-cacheable actions
	array(
		'GotoPartner' => 'gotoPartner',
	)
);


// list of categories on the left side and Our partners menu
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

