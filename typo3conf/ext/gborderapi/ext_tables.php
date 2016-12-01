<?php
if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	'Gigabonus.' . $_EXTKEY,
	'Pi1',
	'Order API Standard'
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'gborderapi');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_gborderapi_domain_model_order', 'EXT:gborderapi/Resources/Private/Language/locallang_csh_tx_gborderapi_domain_model_order.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_gborderapi_domain_model_order');


// allow to list Order table records in Page mode
$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['cms']['db_layout']['addTables']['tx_gborderapi_domain_model_order'][0] = array(
	'fList' => 'amount, fee, partner_id, user_id, currency, crdate',
	'icon' => TRUE
);
