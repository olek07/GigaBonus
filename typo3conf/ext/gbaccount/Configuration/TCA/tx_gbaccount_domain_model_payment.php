<?php
return array(
	'ctrl' => array(
		'title'	=> 'LLL:EXT:gbaccount/Resources/Private/Language/locallang_db.xlf:tx_gbaccount_domain_model_payment',
		'label' => 'amount',
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
		'searchFields' => 'amount, user',
		'iconfile' => 'EXT:gbaccount/Resources/Public/Icons/tx_gbaccount_domain_model_payment.gif'
	),
	'interface' => array(
		'showRecordFieldList' => 'hidden, user, crdate, amount,paid_status',
	),
	'types' => array(
		'1' => array('showitem' => 'hidden,--palette--;;1,user,crdate,amount,paid_status'),
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


		'amount' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:gbaccount/Resources/Private/Language/locallang_db.xlf:tx_gbaccount_domain_model_transaction.amount',
			'config' => array(
				'type' => 'input',
				'size' => 4,
				'eval' => 'int,required'
			)
		),


		'user' => array(
			'exclude' => 0,
			'label' => 'User',
			'config' => array(
				'type' => 'select',
				'renderType' => 'selectSingle',
				'foreign_table' => 'fe_users',
				'minitems' => 0,
				'maxitems' => 1,
			),
		),

		'paid_status' => array(
			'exclude' => 0,
			'label' => 'Paid out?',
			'config' => array(
				'type' => 'check',
			)
		),

	),
);