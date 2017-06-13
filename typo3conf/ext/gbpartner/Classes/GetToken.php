<?php
use \TYPO3\CMS\Core\Utility\GeneralUtility;


global $TYPO3_CONF_VARS;

/**
 * @var \TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController
 */
$GLOBALS['TSFE'] = GeneralUtility::makeInstance('TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController', $TYPO3_CONF_VARS, null, 0, TRUE);
$GLOBALS['TSFE']->initFeUser();

if ($GLOBALS['TSFE']->fe_user->user == NULL) {
    exit;
}

echo GeneralUtility::getUrl('http://typo3eight.dev/go.php?getToken=1');



?>