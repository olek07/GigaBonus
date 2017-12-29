<?php
defined('TYPO3_MODE') or die();

call_user_func(
    function($extKey, $extConf)
    {
		// Setting the encryption algorithm
		$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['sr_freecap']['encryptionAlgorithm'] = isset($extConf['encryptionAlgorithm']) ? $extConf['encryptionAlgorithm'] : 'AES-256-CBC';
		$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['sr_freecap']['salt'] = isset($extConf['salt']) ? $extConf['salt'] : 'cH!swe!retReGu7W6bEDRup7usuDUh9THeD2CHeGE*ewr4n39=E@rAsp7c-Ph@pH';

		// Dispatching requests to image generator and audio player
		$GLOBALS['TYPO3_CONF_VARS']['FE']['eID_include']['sr_freecap_EidDispatcher'] = 'EXT:sr_freecap/Resources/Private/Eid/EidDispatcher.php';

		// Configuring the captcha image generator
		\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
			// The extension name (in UpperCamelCase) or the extension key (in lower_underscore)
			'SJBR' . '.' . $extKey,
			// A unique name of the plugin in UpperCamelCase
			'ImageGenerator',
			// An array holding the controller-action-combinations that are accessible
			[
				// The first controller and its first action will be the default
				'ImageGenerator' => 'show',
			],
			// An array of non-cachable controller-action-combinations (they must already be enabled)
			[
				'ImageGenerator' => 'show',
			]
		);

		// Configuring the audio captcha player
		\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
			// The extension name (in UpperCamelCase) or the extension key (in lower_underscore)
			'SJBR' . '.' . $extKey,
			// A unique name of the plugin in UpperCamelCase
			'AudioPlayer',
			// An array holding the controller-action-combinations that are accessible
			[
				// The first controller and its first action will be the default
				'AudioPlayer' => 'play',
			],
			// An array of non-cachable controller-action-combinations (they must already be enabled)
			[
				'AudioPlayer' => 'play',
			]
		);
	},
	'sr_freecap',
	unserialize($_EXTCONF)
);