<?php
if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}


/** @var \TYPO3\CMS\Extbase\SignalSlot\Dispatcher $signalSlotDispatcher */
$signalSlotDispatcher = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Extbase\SignalSlot\Dispatcher::class);

$signalSlotDispatcher->connect(
    \In2code\Femanager\Controller\EditController::class,  // Signal class name
    'updateActionBeforePersist',                                  // Signal name
    \GigaBonus\Gbfemanager\Slots\BeforePersist::class,        // Slot class name
    'setUsernameEqualToEmail'                               // Slot name
);

/* 
$GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects']['In2code\\Femanager\\Controller\\NewController'] = array(
    'className' => 'Gigabonus\\Gbfemanager\\Xclass\\NewController'
);
*/



## EXTENSION BUILDER DEFAULTS END TOKEN - Everything BEFORE this line is overwritten with the defaults of the extension builder
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig('<INCLUDE_TYPOSCRIPT: source="FILE:EXT:' . $_EXTKEY . '/Configuration/PageTS/PageTS.ts">'); 


$TYPO3_CONF_VARS['FE']['eID_include']['cities'] = 'EXT:gbfemanager/Classes/Cities.php';