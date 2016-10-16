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
                    'ua' => '1',
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
			'newsDetailConfiguration' => array(
				array(
					'GETvar' => 'tx_gbpartner_partnerlisting[action]',
					'valueMap' => array(
						'detail' => '',
					),
					'noMatch' => 'bypass'
				),
				array(
					'GETvar' => 'tx_gbpartner_partnerlisting[controller]',
					'valueMap' => array(
						'News' => '',
					),
					'noMatch' => 'bypass'
				),


				array(
					'GETvar' => 'tx_gbpartner_partnerlisting[partner]',
					'lookUpTable' => array(
						'table' => 'tx_gbpartner_domain_model_partner',
						'id_field' => 'uid',
						'alias_field' => 'name',
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

			16 => 'newsDetailConfiguration'

		),
        'postVarSets' => array(

			'16' => array (

				'controller' => array(
					array(
						'GETvar' => 'tx_gbpartner_partnerlisting[action]',
						'noMatch' => 'bypass'
					),
					array(
						'GETvar' => 'tx_gbpartner_partnerlisting[controller]',
						'noMatch' => 'bypass'
					),
				),


				/*
				'partner' => array(
					array(
						'GETvar' => 'tx_gbpartner_partnerlisting[controller]',

					),

					array(
						'GETvar' => 'tx_gbpartner_partnerlisting[action]',
					),

					array(
						'GETvar' => 'tx_gbpartner_partnerlisting[partner]',
						'lookUpTable' => array(
							'table' => 'tx_gbpartner_domain_model_partner',
							'id_field' => 'uid',
							'alias_field' => 'name',
							'addWhereClause' => ' AND NOT deleted',
							'useUniqueCache' => 1,
							'useUniqueCache_conf' => array(
								'strtolower' => 1,
								'spaceCharacter' => '-',
							),
							'languageGetVar' => 'L',
							'languageExceptionUids' => '',
							'languageField' => 'sys_language_uid',
							'transOrigPointerField' => 'l10n_parent',
							'autoUpdate' => 1,
							'expireDays' => 180,
						),
					),



				),
				*/

			),

            '_DEFAULT' => array(








/*
				'addnew' => array(
					array(
						'GETvar' => 'tx_gbadvert_addadvert[action]',
						'valueMap' => array(
							'1' => 'new'
						)
					),

					array(
						'GETvar' => 'tx_gbadvert_addadvert[controller]',
						'valueMap' => array(
							'1' => 'Advert'
						)
					),



				),

				'show' => array(
					array(
						'GETvar' => 'tx_gbadvert_addadvert[advert]',
					),
					array(
						'GETvar' => 'tx_gbadvert_addadvert[action]',
						'valueMap' => array(
							'1' => 'show'
						)
					)


				),

*/
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



                'gagaga' => array(
                    array(
                        'GETvar' => 'fff' ,
                        'valueMap' => array(
                            'drei' => 3
                        )
                    )
                ),

				'birthday' => array(
					array(
						'GETvar' => 'monat' ,
					),

					array(
						'GETvar' => 'year' ,
					),


				),

                // news archive parameters
                'archive' => array(
                    array(
                        'GETvar' => 'tx_ttnews[year]' ,
                    ),
                    array(
                        'GETvar' => 'tx_ttnews[month]' ,
                        'valueMap' => array(
                            'january' => '01',
                            'february' => '02',
                            'march' => '03',
                            'april' => '04',
                            'may' => '05',
                            'june' => '06',
                            'july' => '07',
                            'august' => '08',
                            'september' => '09',
                            'october' => '10',
                            'november' => '11',
                            'december' => '12',
                        )
                    ),
                ),
                // news pagebrowser
                'browse' => array(
                    array(
                        'GETvar' => 'tx_ttnews[pointer]',
                    ),
                ),
                // news categories
                'select_category' => array (
                    array(
                        'GETvar' => 'tx_ttnews[cat]',
                    ),
                ),
                // news articles and searchwords
                'article' => array(
                    array(
                        'GETvar' => 'tx_ttnews[tt_news]',
                        'lookUpTable' => array(
                            'table' => 'tt_news',
                            'id_field' => 'uid',
                            'alias_field' => 'title',
                            'addWhereClause' => ' AND NOT deleted',
                            'useUniqueCache' => 1,
                            'useUniqueCache_conf' => array(
                                'strtolower' => 1,
                                'spaceCharacter' => '-',
                            ),
                        ),
                    ),
                    array(
                        'GETvar' => 'tx_ttnews[backPid]',
                    ),
                    array(
                        'GETvar' => 'tx_ttnews[swords]',
                    ),
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

$TYPO3_CONF_VARS['EXTCONF']['realurl']['_DEFAULT']['fixedPostVars']['6'] = 'news';