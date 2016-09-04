<?php

namespace Gigabonus\Gbfemanager\ViewHelpers;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;
class BirthdayViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper {

    /**
     */
    public function render() {
        $content = '<select data-birthday-day>';
        for ($i=1; $i<=31; $i++) {
            $content .= '<option>' . sprintf('%02d', $i) . '</option>';
        }
        $content .= '</select>' . "\n";
        
        $content.= '<select data-birthday-month>';
        for ($i=1; $i<=12; $i++) {
            $monthName = LocalizationUtility::translate('gbbase.month.name_' . $i, 'gbbase');
            $content .= '<option value="' . sprintf('%02d', $i) . '">' . $monthName . '</option>';
        }
        $content .= '</select>' . "\n";
        
        $currentYear = date('Y', time());
        $content.= '<select data-birthday-year>';
        for ($i=$currentYear - 15; $i>=$currentYear - 80; $i--) {
            $content .= '<option>' . $i . '</option>';
        }
        $content .= '</select>' . "\n";
        
        return $content;
    }
}
