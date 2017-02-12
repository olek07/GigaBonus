<?php

namespace Gigabonus\Gbfemanager\ViewHelpers;

use TYPO3\CMS\Extbase\Utility\DebuggerUtility;

class HighlightErrorFieldViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper {
    /**
     * @param string $fieldName Fieldname
     * @param array $validationResults
     * 
     */
    public function render($fieldName, $validationResults) {
        $content = '';
        if (count($validationResults) > 0) {
            foreach ($validationResults as $validationResult) {
                if ($validationResult->getCode() == $fieldName) {
                    $content = 'error';
                    break;
                }
            }
        }

        return $content;
    }
}


