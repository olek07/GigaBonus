<?php
$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['realurl'] = array(
	'_DEFAULT' => array(
		'init' => array(
			'enableCHashCache' => 1,
			'appendMissingSlash' => 'ifNotFile',
			'enableUrlDecodeCache' => 1,
			'enableUrlEncodeCache' => 1,
			'postVarSet_failureMode' => '',
		),
		'redirects' => array(),
		'preVars' => array(
            array(
                'GETvar' => 'L',
                'valueMap' => array(
                    'ru' => '0',
                    'uk' => '1',
                ),
                'valueDefault' => 'ru',
                'noMatch' => 'bypass',
            ),
            array(
                'GETvar' => 'no_cache',
                'valueMap' => array(
                    'nc' => 1,
                ),
                'noMatch' => 'bypass',
            ),

        ),
        'pagePath' => array(
            'type' => 'user',
            'userFunc' => 'EXT:realurl/class.tx_realurl_advanced.php:&tx_realurl_advanced->main',
            'spaceCharacter' => '-',
            'languageGetVar' => 'L',
            'expireDays' => 7,
            'rootpage_id' => 1,
            'firstHitPathCache' => 1,
        ),

		'fixedPostVars' => array(

			'confirmemail' => array(
				array(
					'GETvar' => 'tx_femanager_pi1[action]',
				),
				array(
					'GETvar' => 'tx_femanager_pi1[user]',
				),
				array(
					'GETvar' => 'tx_femanager_pi1[hash]',
				),
				array(
					'GETvar' => 'tx_femanager_pi1[status]',
					/*
					'valueMap' => array(

					),
					*/
					'noMatch' => 'bypass'
				),
				array(
					'GETvar' => 'tx_femanager_pi1[controller]',
					/*
					'valueMap' => array(

					),
					*/
					'noMatch' => 'bypass'
				),


			),

			'partnerListConfiguration' => array(
				array(
					'GETvar' => 'tx_gbpartner_partnerlisting[category]',
					'lookUpTable' => array(
						'table' => 'tx_gbpartner_domain_model_category',
						'id_field' => 'uid',
						'alias_field' => 'name',
						'enable404forInvalidAlias' => 1,
						'addWhereClause' => ' AND NOT deleted',
						'useUniqueCache' => 1,
						'useUniqueCache_conf' => array(
							'strtolower' => 1,
							'spaceCharacter' => '-'
						),
						'languageGetVar' => 'L',
						'languageExceptionUids' => '',
						'languageField' => 'sys_language_uid',
						'transOrigPointerField' => 'l10n_parent',
						'autoUpdate' => 1,
						'expireDays' => 180,
					)
				),

			),

			'partnerDetailConfiguration' => array(
				array(
					'GETvar' => 'tx_gbpartner_partnerlisting[action]',
					'valueMap' => array(

					),
					'noMatch' => 'bypass'
				),
				array(
					'GETvar' => 'tx_gbpartner_partnerlisting[controller]',
					'valueMap' => array(

					),
					'noMatch' => 'bypass'
				),

				array(
					'GETvar' => 'tx_gbpartner_partnerlisting[category]',
					'lookUpTable' => array(
						'table' => 'tx_gbpartner_domain_model_category',
						'id_field' => 'uid',
						'alias_field' => 'name',
						'enable404forInvalidAlias' => 1,
						'addWhereClause' => ' AND NOT deleted',
						'useUniqueCache' => 1,
						'useUniqueCache_conf' => array(
							'strtolower' => 1,
							'spaceCharacter' => '-'
						),
						'languageGetVar' => 'L',
						'languageExceptionUids' => '',
						'languageField' => 'sys_language_uid',
						'transOrigPointerField' => 'l10n_parent',
						'autoUpdate' => 1,
						'expireDays' => 180,
					)
				),


				array(
					'GETvar' => 'tx_gbpartner_partnerlisting[partner]',
					'lookUpTable' => array(
						'table' => 'tx_gbpartner_domain_model_partner',
						'id_field' => 'uid',
						'alias_field' => 'name',
						'enable404forInvalidAlias' => 1,
						'addWhereClause' => ' AND NOT deleted',
						'useUniqueCache' => 1,
						'useUniqueCache_conf' => array(
							'strtolower' => 1,
							'spaceCharacter' => '-'
						),
						'languageGetVar' => 'L',
						'languageExceptionUids' => '',
						'languageField' => 'sys_language_uid',
						'transOrigPointerField' => 'l10n_parent',
						'autoUpdate' => 1,
						'expireDays' => 180,
					)
				)

			),

			// 12 => 'partnerListConfiguration',					// partner list configuration
			17 => 'partnerDetailConfiguration',					    // registration confirmation E-Mail 
			4 => 'confirmemail',

		),
        'postVarSets' => array(

            '_DEFAULT' => array(

				'forgot' => array(
					array(
						'GETvar' => 'tx_felogin_pi1[forgot]',
					)
				),
				'forgothash' => array(
					array(
						'GETvar' => 'tx_femanager_pi1[forgothash]',
					)
				),

            ),
		),
		// configure filenames for different pagetypes
		'fileName' => array(
			'defaultToHTMLsuffixOnPrev' => 0,
			'index' => array(
				'print.html' => array(
					'keyValues' => array(
						'type' => 98,
					),
				),
				'rss.xml' => array(
					'keyValues' => array(
						'type' => 100,
					),
				),
				'rss091.xml' => array(
					'keyValues' => array(
						'type' => 101,
					),
				),
				'rdf.xml' => array(
					'keyValues' => array(
						'type' => 102,
					),
				),
				'atom.xml' => array(
					'keyValues' => array(
						'type' => 103,
					),
				),
			),
		),
	),
);
