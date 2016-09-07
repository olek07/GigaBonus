<?php
namespace Gigabonus\Gbfemanager\Utility;
use \TYPO3\CMS\Core\Utility\GeneralUtility;

class Cities {

    /**
     * 
     * @var string
     */
    protected $term = '';
    
    /**
     *
     * @var int
     */
    protected $lang = '';
    
    /**
     *
     * @var array
     */
    protected $languages = array(0 => 'ru', 1 => 'ua');
    

    public function __construct($TYPO3_CONF_VARS, $term, $lang = 0) {
        if (!array_key_exists($lang, $this->languages)) {
            exit;
        }
        $this->lang = $lang;
        $this->term = trim(addslashes($term));
        $this->term = preg_replace('~\s{1,}~' , ' ',  $this->term);
    }

    
    /**
     * 
     * @param string $term
     * @param int $lang
     */
    private function doSearch($term, $lang) {
        $citiesList = array();
        $tableName = 'tx_gbfemanager_cities';
        $fieldName = 'name_' . $this->languages[$lang];
            
        // $GLOBALS['TYPO3_DB']->store_lastBuiltQuery = true;
        $res = $GLOBALS['TYPO3_DB']->exec_SELECTquery('*', $tableName, $fieldName . ' LIKE "' . $term .'%"', 
                                                      '', $fieldName, ''
                                                     );

        // echo $GLOBALS['TYPO3_DB']->debug_lastBuiltQuery;
        if ($GLOBALS['TYPO3_DB']->sql_num_rows($res)) {                             
            while($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res)){
              $citiesList[] = array('id' => $row['id'], 'value' => trim($row[$fieldName]));  
            }
        }
        return $citiesList;
    }
    
    public function run() {
        header('Content-Type: application/json');
        try {
            
            $citiesList = $this->doSearch($this->term, $this->lang);
            
            // Wenn nichts gefunden, dann in der anderen Sprache suchen
            if (count($citiesList) == 0) {
                $citiesList = $this->doSearch($this->term, 1 - $this->lang);
            }
            
            if (count($citiesList) > 0) {
                header('Content-Type: application/json');
                echo json_encode($citiesList);
            }
        }
        catch(\Exception $e) {
            echo '{}';
        }

    }
}

global $TYPO3_CONF_VARS;
$eid = GeneralUtility::makeInstance(\Gigabonus\Gbfemanager\Utility\Cities::class, $TYPO3_CONF_VARS, GeneralUtility::_GET('term'), GeneralUtility::_GET('L'));
$eid->run();
