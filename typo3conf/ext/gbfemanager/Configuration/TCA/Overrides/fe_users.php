<?php

/**
 * Table configuration fe_users
 */
$feUsersColumns = [
    'gender' => [
        'exclude' => 0,
        'label' => 'LLL:EXT:femanager/Resources/Private/Language/locallang_db.xlf:' .
            'tx_femanager_domain_model_user.gender',
        'config' => [
            'type' => 'radio',
            'items' => [
                [
                    'LLL:EXT:femanager/Resources/Private/Language/locallang_db.xlf:' .
                    'tx_femanager_domain_model_user.gender.item0',
                    'm'
                ],
                [
                    'LLL:EXT:femanager/Resources/Private/Language/locallang_db.xlf:' .
                    'tx_femanager_domain_model_user.gender.item1',
                    'w'
                ]
            ],
        ]
    ],



    'language' => [
        'exclude' => 0,
        'label' => 'Language',
        'config' => [
            'type' => 'radio',
            'items' => [
                [
                    'ru',
                    '0'
                ],
                [
                    'ua',
                    '1'
                ]
            ],
        ]
    ],
    'city' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.city',
            'config' => array(
                'type' => 'input',
                'size' => '20',
                'eval' => 'trim',
                'max' => '100'
            )
    ), 
    'city_id' => [
        'exclude' => 0,
        'label' => 'Cityid',
        'config' => [
            'type' => 'input',
        ]
    ],
    
    'telephone' => array(
        'exclude' => 1,
        'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.phone',
        'config' => array(
            'type' => 'input',
            'eval' => 'trim,uniqueInPid',
            'size' => '20',
            'max' => '20'
        )
    ),

    
    'tx_gbfemanager_telephonelastchanged' => [
        'exclude' => 0,
        'label' => 'Telephone last changed',
        'config' => [
            'type' => 'input',
            'eval' => 'datetime',
        ]
    ]
];


\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes(
    'fe_users',
    'language,tx_gbfemanager_telephonelastchanged',
    '',
    'after:name'
);

/*
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes(
    'fe_users',
    'city_id',
    '',
    'after:language'
);
*/

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('fe_users', $feUsersColumns);
