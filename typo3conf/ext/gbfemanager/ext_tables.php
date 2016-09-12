<?php

/**
 * Flexform
 */
$pluginSignature = str_replace('_', '', 'femanager') . '_pi1';
$TCA['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
    $pluginSignature,
    'FILE:EXT:gbfemanager/Configuration/FlexForms/FlexFormPi1.xml'
);
