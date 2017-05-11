<?php
namespace Gigabonus\Gbpartner\Utility;


use TYPO3\CMS\Core\Utility\DebugUtility;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;

class Tcahelper {

    /**
    * prepare the category list
    *
    */

    public function getListOfCategories(&$config) {


        DebugUtility::debug($config);

        $config['items'] = [['Not selected', 0], ['1', 1], ['2', 2]];
        /*
        $beLang = $GLOBALS['BE_USER']->uc['lang'] != '' ? $GLOBALS['BE_USER']->uc['lang'] : 'en';
        $res = @$GLOBALS['TYPO3_DB']->exec_SELECTquery('iso2, label_' . $beLang, 'tx_ppbase_country', '', '', 'label_' . $beLang);

        if ($res) {
            while ($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res)) {
                $config['items'][] = array($row['label_' . $beLang], strtolower($row['iso2']));
            }
        } else {
            $GLOBALS['BE_USER']->writelog(-1, 0, 1, '', 'Couldn\'t read the countries list', array());
        }
        */
    }

}
