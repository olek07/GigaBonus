<?php
if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'Gigabonus.' . $_EXTKEY,
	'Pi1',
	array(
		'Order' => 'new, create, reject, changeStatus',
		
	),
	// non-cacheable actions
	array(
		'Order' => 'create, reject, changeStatus',
		
	)
);


// Tracking pixel
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'Gigabonus.' . $_EXTKEY,
	'Tracking',
	array(
		'Order' => 'tracking',

	),
	// non-cacheable actions
	array(
		'Order' => 'tracking',

	)
);




$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['realurl']['_DEFAULT']['fixedPostVars']['orderapi'] = [
	[
		'GETvar'   => 'type',
		'valueMap' => [
			'orderapi' => 1452982642
		],
	],

	[
		'cond'        => [
			'prevValueInList' => '1452982642'
		],
		'GETvar'	=> 'version',
		'optional'  => false
	],

	[

		'GETvar'      => 'tx_gborderapi_pi1[action]',
		'valueMap'	=> array(
			'change' => 'changeStatus'
		),
		'optional'    => false
	]
];
$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['realurl']['_DEFAULT']['fixedPostVars'][41] = 'orderapi';



$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['realurl']['_DEFAULT']['fixedPostVars']['tracking'] = [

	[
		'GETvar'	=> 'version',
		'optional'  => false
	],

];

$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['realurl']['_DEFAULT']['fixedPostVars'][42] = 'tracking';