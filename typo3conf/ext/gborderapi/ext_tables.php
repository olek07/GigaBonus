<?php
if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	'Gigabonus.' . $_EXTKEY,
	'Pi1',
	'Order API Standard'
);


\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	'Gigabonus.' . $_EXTKEY,
	'Tracking',
	'Tracking Pixel'
);


\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'gborderapi');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_gborderapi_domain_model_order', 'EXT:gborderapi/Resources/Private/Language/locallang_csh_tx_gborderapi_domain_model_order.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_gborderapi_domain_model_order');


$pluginSignature = str_replace('_','',$_EXTKEY) . '_pi1';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue($pluginSignature, 'FILE:EXT:' . $_EXTKEY . '/Configuration/FlexForms/OrderAPI.xml');




// allow to list Order table records in Page mode
$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['cms']['db_layout']['addTables']['tx_gborderapi_domain_model_order'][0] = array(
	'fList' => 'amount, fee, partner, user_id, partner_order_id, currency, crdate',
	'icon' => TRUE
);



\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	'Gigabonus.' . $_EXTKEY,
	'Pi1',
	'GigaBonus Orders'
);


if (TYPO3_MODE === 'BE') {


	if (!isset($TBE_MODULES['gbtools'])) {
		$temp_TBE_MODULES = array();
		foreach ($TBE_MODULES as $key => $val) {
			if ($key == 'user') {
				$temp_TBE_MODULES[$key] = $val;
				$temp_TBE_MODULES['gbtools'] = '';
			} else {
				$temp_TBE_MODULES[$key] = $val;
			}
		}
		$TBE_MODULES = $temp_TBE_MODULES;
	}

/*
	\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
		'Gigabonus.' . $_EXTKEY,
		'gbtools',
		'',
		'',
		array(
		),
		array(
			'access' => 'user,group',
			'icon' => 'EXT:' . $_EXTKEY . '/Resources/Public/Icons/tx_ext_mymainmodule.gif',
			'labels' => 'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang_mod_file.xlf',
		)
	);


	\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
		'Gigabonus.' . $_EXTKEY,
		'gbtools',
		'pi1',
		'',
		array(
			'BeTools' => 'overview'
		),
		array(
			'access' => 'user,group',
			'icon' => 'EXT:' . $_EXTKEY . '/Resources/Public/Icons/tx_ext_mymainmodule.gif',
			'labels' => 'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang_mod_file.xlf',
		)
	);
*/


	/**
	 * Registers a Backend Module
	 */
	\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
		'Gigabonus.' . $_EXTKEY,
		'web',	 		// Make module a submodule of 'web'
		'pi1',		// Submodule key
		'',						// Position
		array(
			'BeOrder' => 'list',
		),
		array(
			'access' => 'user,group',
			'icon'   => 'EXT:' . $_EXTKEY . '/ext_icon.gif',
			'labels' => 'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang_gborders.xlf',
		)
	);

}

