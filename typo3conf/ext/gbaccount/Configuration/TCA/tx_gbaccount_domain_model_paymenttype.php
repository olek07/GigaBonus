<?php
return array(
	'ctrl' => array(
		'title'	=> 'LLL:EXT:gbaccount/Resources/Private/Language/locallang_db.xlf:tx_gbaccount_domain_model_paymenttype',
		'sortby' => 'sorting',
		'label' => 'name',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'dividers2tabs' => TRUE,
		'default_sortby' => 'ORDER BY crdate DESC',
		'versioningWS' => 2,
		'versioning_followPages' => TRUE,

		'delete' => 'deleted',
		'enablecolumns' => array(
			'disabled' => 'hidden',
		),

		'languageField' => 'sys_language_uid',
		'transOrigPointerField' => 'l10n_parent',
		'transOrigDiffSourceField' => 'l10n_diffsource',


		'searchFields' => '',
		'iconfile' => 'EXT:gbaccount/Resources/Public/Icons/tx_gbaccount_domain_model_payment.gif'
	),
	'interface' => array(
		'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, name',
	),
	'types' => array(
		'1' => array('showitem' => 'sys_language_uid, l10n_parent, l10n_diffsource,hidden,--palette--;;1,name,conditions'),
	),
	'palettes' => array(
		'1' => array('showitem' => ''),
	),
	'columns' => array(

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

		'hidden' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.hidden',
			'config' => array(
				'type' => 'check',
			),
		),

		'name' => array(
			'exclude' => 0,
			'label' => 'Name',
			'config' => array(
				'type' => 'input',
				'size' => 20,
				'eval' => 'required'
			)
		),

		'conditions' => array(
			'exclude' => 0,
			'label' => 'Conditions',
			'config' => array(
				'type' => 'text',
				'eval' => 'required'
			)
		),

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
				'foreign_table' => 'tx_gbaccount_domain_model_paymenttype',
				'foreign_table_where' => 'AND tx_gbaccount_domain_model_paymenttype.pid=###CURRENT_PID### AND tx_gbaccount_domain_model_paymenttype.sys_language_uid IN (-1,0)',

			),
		),
		'l10n_diffsource' => array(
			'config' => array(
				'type' => 'passthrough',
			),
		),

	),
);