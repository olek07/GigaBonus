<?php
namespace Gigabonus\Gbpartner\Backend;

use TYPO3\CMS\Core\Utility\DebugUtility;

class Category {
    public function countOfPartners(&$parameters, $parentObject) {


        // DebugUtility::debug($parameters);
        // DebugUtility::debug(\TYPO3\CMS\Backend\Utility\BackendUtility::getRecord($parameters['table'], $parameters['row']['uid']));


        $record = \TYPO3\CMS\Backend\Utility\BackendUtility::getRecord($parameters['table'], $parameters['row']['uid']);
        $newTitle = $record['name'];
        // $newTitle .= ' (' . substr(strip_tags($record['name']), 0, 10) . '...)';
        $parameters['title'] = $newTitle;

    }
}