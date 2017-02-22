<?php
if (!defined('TYPO3_MODE')) {
    die('Access denied.');
}

$GLOBALS['TYPO3_CONF_VARS']['BE']['sessionTimeout'] = '86400';

$GLOBALS['TYPO3_CONF_VARS']['FE']['pageNotFound_handling_redirectPageID'] = 18;     // 404-page. attention: this parameter is not provided by TYPO3, but needed for page-not-found-userfunction
$GLOBALS['TYPO3_CONF_VARS']['FE']['accessRestrictedPages_handling_statheader'] = 'HTTP/1.0 403 Forbidden'; // attention: this parameter is not provided by TYPO3, but needed for page-not-found-userfunction
$GLOBALS['TYPO3_CONF_VARS']['FE']['accessRestrictedPages_handling_redirectPageID'] = 3; // Login-page. attention: this parameter is not provided by TYPO3, but needed for page-not-found-userfunction

switch(true) {
    // Computer with Windows
    case ($_SERVER['DevelopComputer'] == 1):

        $GLOBALS['TYPO3_CONF_VARS']['GFX']['colorspace'] = 'RGB';
        $GLOBALS['TYPO3_CONF_VARS']['GFX']['gdlib_png'] = '1';
        $GLOBALS['TYPO3_CONF_VARS']['GFX']['im'] = 1;
        $GLOBALS['TYPO3_CONF_VARS']['GFX']['im_mask_temp_ext_gif'] = 1;
        $GLOBALS['TYPO3_CONF_VARS']['GFX']['im_path'] = 'C:/Program Files/GraphicsMagick-1.3.22-Q8/';
        $GLOBALS['TYPO3_CONF_VARS']['GFX']['im_path_lzw'] = 'C:/Program Files/GraphicsMagick-1.3.22-Q8/';
        $GLOBALS['TYPO3_CONF_VARS']['GFX']['im_v5effects'] = -1;
        $GLOBALS['TYPO3_CONF_VARS']['GFX']['im_version_5'] = 'gm';
        $GLOBALS['TYPO3_CONF_VARS']['GFX']['image_processing'] = 1;
        $GLOBALS['TYPO3_CONF_VARS']['GFX']['jpg_quality'] = '85';
        $GLOBALS['TYPO3_CONF_VARS']['MAIL']['transport_mbox_file'] = 'C:/projects/gigabonus/typo3conf/mail';


        $GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['cache_pages']['options']['compression'] = false;
        $GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['cache_pagesection']['options']['compression'] = false;
        break;
}

/*
$GLOBALS['TYPO3_CONF_VARS']['SYS']['useCachingFramework'] = '1';
$GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['cache_pages']['backend'] = 'TYPO3\\CMS\\Core\\Cache\\Backend\\MemcachedBackend';
$GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['cache_pages']['options'] = array('servers' => array('localhost:11211'),);

$GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['cache_pagesection']['backend'] = 'TYPO3\\CMS\\Core\\Cache\\Backend\\MemcachedBackend';
$GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['cache_pagesection']['options'] = array('servers' => array('localhost:11211'),);

$GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['cache_hash']['backend'] = 'TYPO3\\CMS\\Core\\Cache\\Backend\\MemcachedBackend';
$GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['cache_hash']['options'] = array('servers' => array('localhost:11211'),);

$GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['extbase_object']['backend'] = 'TYPO3\\CMS\\Core\\Cache\\Backend\\MemcachedBackend';
$GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['extbase_object']['options'] = array('servers' => array('localhost:11211'),);

$GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['extbase_reflection']['backend'] = 'TYPO3\\CMS\\Core\\Cache\\Backend\\MemcachedBackend';
$GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['extbase_reflection']['options'] = array('servers' => array('localhost:11211'),);
*/