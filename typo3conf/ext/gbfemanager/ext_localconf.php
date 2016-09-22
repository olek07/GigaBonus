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

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'In2code.femanager',
    'Pi1',
    [
        'User' => 'list, show, fileUpload, fileDelete, validate, loginAs',
        'New' => 'create, new, confirmCreateRequest, createStatus',
        'Edit' => 'edit, update, delete, confirmUpdateRequest, sendConfirmMail, restorePassword, storeRestoredPassword',
        'ChangeMobileNumber' => 'edit, update',
        'Invitation' => 'new, create, edit, update, delete, status',
        'RestorePassword' => 'edit,save'
    ],
    [
        'User' => 'list, fileUpload, fileDelete, validate, loginAs',
        'New' => 'create, new, confirmCreateRequest, createStatus',
        'Edit' => 'edit, update, delete, confirmUpdateRequest, sendConfirmMail, restorePassword, storeRestoredPassword',
        'ChangeMobileNumber' => 'edit, update',
        'Invitation' => 'new, create, edit, update, delete',
        'RestorePassword' => 'edit,save'
    ]
);





/* 
$GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects']['In2code\\Femanager\\Controller\\NewController'] = array(
    'className' => 'Gigabonus\\Gbfemanager\\Xclass\\NewController'
);
*/



## EXTENSION BUILDER DEFAULTS END TOKEN - Everything BEFORE this line is overwritten with the defaults of the extension builder
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig('<INCLUDE_TYPOSCRIPT: source="FILE:EXT:' . $_EXTKEY . '/Configuration/PageTS/PageTS.ts">'); 



$GLOBALS['TYPO3_CONF_VARS']['SYS']['locallangXMLOverride']['EXT:femanager/Resources/Private/Language/locallang.xlf'][]
    = 'EXT:gbfemanager/Resources/Private/Language/locallang.xlf';


$TYPO3_CONF_VARS['FE']['eID_include']['cities'] = 'EXT:gbfemanager/Classes/Cities.php';