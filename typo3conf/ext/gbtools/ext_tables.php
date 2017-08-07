<?php
if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}


if (TYPO3_MODE === 'BE') {
/*

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
*/

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
			'BeTools' => 'overview, createOrderLink',
			'BeTransactions' => 'index,show'
		),
		array(
			'access' => 'user,group',
			'icon' => 'EXT:' . $_EXTKEY . '/Resources/Public/Icons/tx_ext_mymainmodule.gif',
			'labels' => 'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang_mod_file.xlf',
		)
	);

}

