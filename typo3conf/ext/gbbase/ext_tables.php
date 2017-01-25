<?php
if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}


\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'GiGaBonus TypoScript');

$GLOBALS['TCA']['tx_powermail_domain_model_field']['columns']['feuser_value']['config']['items'][] = array('Firstname', 'first_name');
