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

        
        $config['items'][] = ['Not selected', 0];
        
        if (count($config['row']['category']) > 0) {
            $res = @$GLOBALS['TYPO3_DB']->exec_SELECTquery(
                    '*', 'tx_gbpartner_domain_model_category', 
                    'uid IN (' . join(',', $config['row']['category']) . ')', '', ''
            );

            if ($res) {
                while ($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res)) {
                    $config['items'][] = array($row['name'] . ' (id=' . $row['uid'] . ')', $row['uid']);
                }
            }
        }
        
        
        /*
        $items = [];
        $items[] = ['Not selected', 0];
        if (count($config['row']['category']) > 0) {
            foreach ($config['row']['category'] as $category) {
                $items[] = [$category, $category];
            }
        }
        */
        
        // $config['items'] = $items;
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
