<?php
if (!defined('TYPO3_MODE')) {
    die('Access denied.');
}

$GLOBALS['TYPO3_CONF_VARS']['BE']['sessionTimeout'] = '86400';

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


        // $GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['cache_pages']['options']['compression'] = false;
        // $GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['cache_pagesection']['options']['compression'] = false;
        break;
}