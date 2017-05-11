<?php
return array(
	'ctrl' => array(
		'title'	=> 'partner',
		'sortby' => 'crdate',
		// 'label_userFunc' => 'Gigabonus\\Gbpartner\\Backend\Category->countOfPartners',
		'label' => 'name',
		'label_alt' => 'uid',
        	'label_alt_force' => 1,
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => TRUE,
		'versioningWS' => 2,
		'versioning_followPages' => TRUE,

		'languageField' => 'sys_language_uid',
		'transOrigPointerField' => 'l10n_parent',
		'transOrigDiffSourceField' => 'l10n_diffsource',
		'delete' => 'deleted',
		'enablecolumns' => array(
			'disabled' => 'hidden',
			'starttime' => 'starttime',
			'endtime' => 'endtime',
		),
		'searchFields' => 'name,teaser,description,website_url,image,category,delivery_conditions',
		'iconfile' => 'EXT:gbpartner/Resources/Public/Icons/tx_gbpartner_domain_model_partner.png',
		'thumbnail' => 'image',
	),
	'interface' => array(
		'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, name, teaser, description, website_url, incentive, tags, image, category, delivery_conditions, main_category',
	),
	'types' => array(
		'1' => array('showitem' => 'sys_language_uid,l10n_parent,l10n_diffsource,hidden,--palette--;;1,name,teaser,description,website_url,incentive, tags, image,category,--div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access,starttime,endtime,--div--;API,api_key,class_name,--div--;Delivery,delivery_conditions,--div--;SEO,main_category'),
	),
	'palettes' => array(
		'1' => array('showitem' => ''),
	),
	'columns' => array(
	
		'sys_language_uid' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.language',
			'config' => array(
				'type' => 'select',
				'renderType' => 'selectSingle',
				'foreign_table' => 'sys_language',
				'foreign_table_where' => 'ORDER BY sys_language.title',
                                'items' => array(
					array('LLL:EXT:lang/locallang_general.xlf:LGL.allLanguages', -1),
					array('Русский', 0)
				),
                            
                            
//				'special' => 'languages',
//                            
//				'items' => [
//					[
//						'LLL:EXT:lang/locallang_general.xlf:LGL.allLanguages',
//						-1,
//						'flags-multiple'
//					],
//				],
//                              
//                             
//				'default' => 0,
			),
		),
		'l10n_parent' => array(
			'displayCond' => 'FIELD:sys_language_uid:>:0',
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.l18n_parent',
			'config' => array(
				'type' => 'select',
				'renderType' => 'selectSingle',
				'items' => array(
					array('', 0),
				),
				'foreign_table' => 'tx_gbpartner_domain_model_partner',
				'foreign_table_where' => 'AND tx_gbpartner_domain_model_partner.pid=###CURRENT_PID### AND tx_gbpartner_domain_model_partner.sys_language_uid IN (-1,0)',
			),
		),
		'l10n_diffsource' => array(
			'config' => array(
				'type' => 'passthrough',
			),
		),

		't3ver_label' => array(
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.versionLabel',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'max' => 255,
			)
		),
	
		'hidden' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.hidden',
			'config' => array(
				'type' => 'check',
			),
		),
		'starttime' => array(
			'exclude' => 1,
			'l10n_mode' => 'mergeIfNotBlank',
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.starttime',
			'config' => array(
				'type' => 'input',
				'size' => 13,
				'max' => 20,
				'eval' => 'datetime',
				'checkbox' => 0,
				'default' => 0,
				'range' => array(
					'lower' => mktime(0, 0, 0, date('m'), date('d'), date('Y'))
				),
			),
		),
		'endtime' => array(
			'exclude' => 1,
			'l10n_mode' => 'mergeIfNotBlank',
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.endtime',
			'config' => array(
				'type' => 'input',
				'size' => 13,
				'max' => 20,
				'eval' => 'datetime',
				'checkbox' => 0,
				'default' => 0,
				'range' => array(
					'lower' => mktime(0, 0, 0, date('m'), date('d'), date('Y'))
				),
			),
		),

		'name' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:gbpartner/Resources/Private/Language/locallang_db.xlf:tx_gbpartner_domain_model_partner.name',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim,required'
			),
		),
		'teaser' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:gbpartner/Resources/Private/Language/locallang_db.xlf:tx_gbpartner_domain_model_partner.teaser',
			'config' => array(
				'type' => 'text',
				'cols' => 40,
				'rows' => 15,
				'eval' => 'trim',
				/*
				'wizards' => array(
					'RTE' => array(
						'icon' => 'wizard_rte2.gif',
						'notNewRecords'=> 1,
						'RTEonly' => 1,
						'module' => array(
							'name' => 'wizard_rich_text_editor',
							'urlParameters' => array(
								'mode' => 'wizard',
								'act' => 'wizard_rte.php'
							)
						),
						'title' => 'LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:bodytext.W.RTE',
						'type' => 'script'
					)
				)
				*/
			),
		),
		'description' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:gbpartner/Resources/Private/Language/locallang_db.xlf:tx_gbpartner_domain_model_partner.description',
			'config' => array(
				'type' => 'text',
				'cols' => 40,
				'rows' => 15,
				'eval' => 'trim',
				/*
				'wizards' => array(
					'RTE' => array(
						'icon' => 'wizard_rte2.gif',
						'notNewRecords'=> 1,
						'RTEonly' => 1,
						'module' => array(
							'name' => 'wizard_rich_text_editor',
							'urlParameters' => array(
								'mode' => 'wizard',
								'act' => 'wizard_rte.php'
							)
						),
						'title' => 'LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:bodytext.W.RTE',
						'type' => 'script'
					)
				)
				*/
			),
			'defaultExtras' => 'richtext[]'
		),

		'website_url' => array(
			'exclude' => 0,
			'label' => 'Website',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),

		'incentive' => array(
			'exclude' => 0,
			'label' => 'incentive',
			'config' => array(
				'type' => 'text',
				'cols' => 40,
				'rows' => 2,
				'eval' => 'trim'
			),
			'defaultExtras' => 'richtext[]'
		),

		'tags' => array(
			'exclude' => 0,
			'label' => 'Tags',
			'config' => array(
				'type' => 'input',
				'size' => 60,
				'eval' => 'trim'
			),
		),


		'image' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:gbpartner/Resources/Private/Language/locallang_db.xlf:tx_gbpartner_domain_model_partner.image',
			'config' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig(
				'image',
				array(
					'appearance' => array(
						'createNewRelationLinkTitle' => 'LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:images.addFileReference'
					),
					'foreign_types' => array(
						'0' => array(
							'showitem' => '
							--palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
							--palette--;;filePalette'
						),
						\TYPO3\CMS\Core\Resource\File::FILETYPE_TEXT => array(
							'showitem' => '
							--palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
							--palette--;;filePalette'
						),
						\TYPO3\CMS\Core\Resource\File::FILETYPE_IMAGE => array(
							'showitem' => '
							--palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
							--palette--;;filePalette'
						),
						\TYPO3\CMS\Core\Resource\File::FILETYPE_AUDIO => array(
							'showitem' => '
							--palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
							--palette--;;filePalette'
						),
						\TYPO3\CMS\Core\Resource\File::FILETYPE_VIDEO => array(
							'showitem' => '
							--palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
							--palette--;;filePalette'
						),
						\TYPO3\CMS\Core\Resource\File::FILETYPE_APPLICATION => array(
							'showitem' => '
							--palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
							--palette--;;filePalette'
						)
					),
					'maxitems' => 1
				),
				$GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext']
			),
		),
		'category' => array(
			'exclude' => 1,
            'l10n_mode' => 'exclude',
			'label' => 'Partner categories',
			'config' => array(
				'type' => 'select',
				'renderType' => 'selectMultipleSideBySide',
				'foreign_table' => 'tx_gbpartner_domain_model_category',
				// 'foreign_table_where' => ' AND tx_gbpartner_domain_model_category.pid=###CURRENT_PID### AND tx_gbpartner_domain_model_category.sys_language_uid IN (-1, ###REC_FIELD_sys_language_uid###) ',
				'foreign_table_where' => ' AND (tx_gbpartner_domain_model_category.sys_language_uid = 0 OR tx_gbpartner_domain_model_category.l10n_parent = 0) ',
				// 'foreign_table_where' => ' AND (tx_gbpartner_domain_model_category.sys_language_uid = IF(###REC_FIELD_sys_language_uid###>0, ###REC_FIELD_sys_language_uid###,0) XOR tx_gbpartner_domain_model_category.sys_language_uid=-1 ) ',
				'MM' => 'tx_gbpartner_partner_category_mm',
				'size' => 10,
				'autoSizeMax' => 30,
				'maxitems' => 9999,
				'multiple' => 0,
				'wizards' => array(
					'_PADDING' => 1,
					'_VERTICAL' => 0,
					'_POSITION' => 'top',
					'suggest' => array(
						'type' => 'suggest'
					),

					'edit' => array(
						'module' => array(
							'name' => 'wizard_edit',
						),
						'type' => 'popup',
						'title' => 'Edit',
						'icon' => 'EXT:backend/Resources/Public/Images/FormFieldWizard/wizard_edit.gif',
						'popup_onlyOpenIfSelected' => 1,
						'JSopenParams' => 'height=350,width=580,status=0,menubar=0,scrollbars=1',
					),

					'add' => Array(
						'module' => array(
							'name' => 'wizard_add',
						),
						'type' => 'script',
						'title' => 'Create new',
						'icon' => 'EXT:backend/Resources/Public/Images/FormFieldWizard/wizard_add.gif',
						'params' => array(
							'table' => 'tx_gbpartner_domain_model_category',
							'pid' => '###CURRENT_PID###',
							'setValue' => 'prepend'
						),
					),
				),
			),
		),

		'api_key' => array(
			'exclude' => 0,
			'label' => 'API key',
			'config' => array(
				'type' => 'input',
				'size' => 50,
				'eval' => 'trim'
			),
		),

		'class_name' => array(
			'exclude' => 0,
			'label' => 'Class name',
			'config' => array(
				'type' => 'input',
				'size' => 50,
				'eval' => 'trim'
			),
		),

		'delivery_conditions' => array(
			'exclude' => 0,
			'label' => 'Delivery conditions',
			'config' => array(
				'type' => 'text',
				'cols' => 40,
				'rows' => 20,
				'eval' => 'trim'
			),
			'defaultExtras' => 'richtext[]'
		),

        'main_category' => array(
			'exclude' => 0,
			'l10n_mode' => 'exclude',
			'label' => 'Main category',
			'config' => array(
				'type' => 'select',
				// 'items' => [['0', 0], ['----------', -1]],
				'itemsProcFunc' => 'Gigabonus\Gbpartner\Utility\Tcahelper->getListOfCategories',
				'renderType' => 'selectSingleBox',
				/*
				'foreign_table' => 'tx_gbpartner_domain_model_category',
				'foreign_table_where' => ' AND (tx_gbpartner_domain_model_category.sys_language_uid = 0 OR tx_gbpartner_domain_model_category.l10n_parent = 0) 
										   AND tx_gbpartner_domain_model_category.uid IN (SELECT uid_foreign FROM tx_gbpartner_partner_category_mm WHERE uid_local=###THIS_UID###) ORDER BY tx_gbpartner_domain_model_category.uid',
				*/
			),
		),

		
	),
);