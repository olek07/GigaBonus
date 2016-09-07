<?php

/**
 * Table configuration fe_users
 */
$feUsersColumns = [
    'language' => [
        'exclude' => 0,
        'label' => 'Language',
        'config' => [
            'type' => 'radio',
            'items' => [
                [
                    'ru',
                    'ru'
                ],
                [
                    'ua',
                    'ua'
                ]
            ],
        ]
    ],
    'cityId' => [
        'exclude' => 0,
        'label' => 'Cityid',
    ]
];


\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes(
    'fe_users',
    'language',
    '',
    'after:name'
);
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('fe_users', $feUsersColumns);
