<?php
if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	'Gigabonus.' . $_EXTKEY,
	'Partnerlisting',
	'Gigabonus Partnerlisting'
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	'Gigabonus.' . $_EXTKEY,
	'Categorylisting',
	'Partners in category'
);


$pluginSignature = 'Partnerlisting';

$TCA['tt_content']['types']['list']['subtypes_addlist'][$_EXTKEY.'_'.strtolower($pluginSignature)] = 'pi_flexform';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue($_EXTKEY.'_'.strtolower($pluginSignature), 'FILE:EXT:'.$_EXTKEY.'/Configuration/FlexForms/'.$pluginSignature.'.xml');


\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'Gigabonus Partners');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_gbpartner_domain_model_partner', 'EXT:gbpartner/Resources/Private/Language/locallang_csh_tx_gbpartner_domain_model_partner.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_gbpartner_domain_model_partner');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_gbpartner_domain_model_category', 'EXT:gbpartner/Resources/Private/Language/locallang_csh_tx_gbpartner_domain_model_category.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_gbpartner_domain_model_category');


$GLOBALS['TCA']['tx_gbpartner_domain_model_partner']['columns']['api_key']['l10n_mode'] = 'exclude';
$GLOBALS['TCA']['tx_gbpartner_domain_model_partner']['columns']['class_name']['l10n_mode'] = 'exclude';
$GLOBALS['TCA']['tx_gbpartner_domain_model_partner']['columns']['website_url']['l10n_mode'] = 'exclude';
$GLOBALS['TCA']['tx_gbpartner_domain_model_partner']['columns']['category']['l10n_mode'] = 'exclude';

$GLOBALS['TCA']['tx_gbpartner_domain_model_category']['columns']['sorting']['l10n_mode'] = 'exclude';

