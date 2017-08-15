<?php
namespace Gigabonus\Gbpartner\Utility;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;

class Token {

    private $tableName = 'tx_gbpartner_gbtoken';

    /**
     * life time in seconds
     *
     * @var int
     */
    private $tokenLifeTime = 1800;

    /**
     * @param string $token
     * @param int $partnerId
     * @param int $userId
     */
    public function setToken($token, $partnerId, $userId) {
        $fieldsValues = array('token' => $token, 'partner' => $partnerId, 'user' => $userId, 'crdate' => time());
        $res = $GLOBALS['TYPO3_DB']->exec_INSERTquery($this->tableName, $fieldsValues);
        
        return $res;
    }

    /**
     * @param string $token
     * @return mixed
     */
    public function getToken($token) {
        $token = $GLOBALS['TYPO3_DB']->fullQuoteStr($token, $this->tableName);
        $res = $GLOBALS['TYPO3_DB']->exec_SELECTgetSingleRow('*', $this->tableName, 'token = ' . $token, '', '');

        return $res;
    }

    /**
     * @param string $token
     * @return mixed
     */
    public function deleteToken($token) {
        $token = $GLOBALS['TYPO3_DB']->fullQuoteStr($token, $this->tableName);
        $res = $GLOBALS['TYPO3_DB']->exec_DELETEquery($this->tableName, 'token = ' . $token);

        return $res;
    }

    /**
     * garbage collector
     *
     */
    public function gc() {
        $res = $GLOBALS['TYPO3_DB']->exec_DELETEquery($this->tableName, 'crdate < ' . (time() - $this->tokenLifeTime));

        return $res;
    }

}

