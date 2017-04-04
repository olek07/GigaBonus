<?php
return array(
	'ctrl' => array(
		'title'	=> 'LLL:EXT:gborderapi/Resources/Private/Language/locallang_db.xlf:tx_gborderapi_domain_model_order',
		'label' => 'partner_id',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => TRUE,
		// 'sortby' => 'sorting',
		'default_sortby' => 'ORDER BY crdate DESC',
		'versioningWS' => 2,
		'versioning_followPages' => TRUE,

		'languageField' => 'sys_language_uid',
		'transOrigPointerField' => 'l10n_parent',
		'transOrigDiffSourceField' => 'l10n_diffsource',
		'delete' => 'deleted',
		'enablecolumns' => array(
			'disabled' => 'hidden',

		),
		'searchFields' => 'partner, partner_id,partner_order_id,amount,fee,status,user_id,currency,data,',
		'iconfile' => 'EXT:gborderapi/Resources/Public/Icons/tx_gborderapi_domain_model_order.gif'
	),
	'interface' => array(
		'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, partner_id, partner, partner_order_id, amount, fee, status, user_id, currency, data',
	),
	'types' => array(
		'1' => array('showitem' => 'sys_language_uid,l10n_parent,l10n_diffsource,hidden,--palette--;;1,partner_id,partner,partner_order_id,amount,fee,status,user_id,currency,data'),
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
					array('LLL:EXT:lang/locallang_general.xlf:LGL.default_value', 0)
				),
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
				'foreign_table' => 'tx_gborderapi_domain_model_order',
				'foreign_table_where' => 'AND tx_gborderapi_domain_model_order.pid=###CURRENT_PID### AND tx_gborderapi_domain_model_order.sys_language_uid IN (-1,0)',
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

		'partner_id' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:gborderapi/Resources/Private/Language/locallang_db.xlf:tx_gborderapi_domain_model_order.partner_id',
			'config' => array(
				'type' => 'input',
				'size' => 4,
				'eval' => 'int,required'
			)
		),

		'partner' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:gbaccount/Resources/Private/Language/locallang_db.xlf:tx_gbaccount_domain_model_transaction.partner',
			'config' => array(
				'type' => 'select',
				'renderType' => 'selectSingle',
				'foreign_table' => 'tx_gbpartner_domain_model_partner',
				'foreign_table_where' => ' AND tx_gbpartner_domain_model_partner.sys_language_uid IN (-1, 0) ',
				'minitems' => 0,
				'maxitems' => 1,
			),
		),


		'partner_order_id' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:gborderapi/Resources/Private/Language/locallang_db.xlf:tx_gborderapi_domain_model_order.partner_order_id',
			'config' => array(
				'type' => 'none',
				'size' => 30,
				'eval' => 'trim,required'
			),
		),
		'amount' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:gborderapi/Resources/Private/Language/locallang_db.xlf:tx_gborderapi_domain_model_order.amount',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'double2,required'
			)
		),
		'fee' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:gborderapi/Resources/Private/Language/locallang_db.xlf:tx_gborderapi_domain_model_order.fee',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'double2'
			)
		),
		'status' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:gborderapi/Resources/Private/Language/locallang_db.xlf:tx_gborderapi_domain_model_order.status',
			'config' => array(
				'type' => 'input',
				'size' => 4,
				'eval' => 'int,required'
			)
		),
		'user_id' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:gborderapi/Resources/Private/Language/locallang_db.xlf:tx_gborderapi_domain_model_order.user_id',
			'config' => array(
				'type' => 'input',
				'size' => 4,
				'eval' => 'int,required'
			)
		),
		'currency' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:gborderapi/Resources/Private/Language/locallang_db.xlf:tx_gborderapi_domain_model_order.currency',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim,required'
			),
		),

		'crdate' => array(
			'exclude' => 1,
			'l10n_mode' => 'mergeIfNotBlank',
			'label' => 'Created',
			'config' => array(
				'type' => 'input',
				'size' => 13,
				'max' => 20,
				'eval' => 'datetime',
				'checkbox' => 0,
				'default' => 0,
			),

		),

		'data' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:gborderapi/Resources/Private/Language/locallang_db.xlf:tx_gborderapi_domain_model_order.data',
			'config' => array(
				'type' => 'text',
				'size' => 30,
				'eval' => 'trim'
			),
		),

	),
);