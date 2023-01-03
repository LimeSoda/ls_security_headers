<?php

defined('TYPO3') || die();

$lll = 'LLL:EXT:ls_security_headers/Resources/Private/Language/locallang_tca.xlf:';

return [
    'ctrl' => [
        'label' => 'uid',
        'label_userFunc' => \LimeSoda\LsSecurityHeaders\Userfuncs\Tca::class . '->securityHeaderTitle',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'title' => $lll . 'tx_lssecurityheaders_headers',
        'delete' => 'deleted',
        'versioningWS' => false,
        'hideAtCopy' => true,
        'prependAtCopy' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.prependAtCopy',
        'enablecolumns' => [
            'disabled' => 'hidden',
            'starttime' => 'starttime',
            'endtime' => 'endtime',
        ],
        'typeicon_classes' => [
            'default' => 'actions-shield',
        ]
    ],
    'types' => [
        '1' => [
            'showitem' => '
                --palette--;' . $lll . 'tx_lssecurityheaders_headers.referrer_policy;referrerPolicy,
                --palette--;' . $lll . 'tx_lssecurityheaders_headers.http_strict_transport_security;httpStrictTransportSecurity,
                --palette--;' . $lll . 'tx_lssecurityheaders_headers.x_frame_options;xFrameOptions,
                --palette--;' . $lll . 'tx_lssecurityheaders_headers.x_xss_protection;xXssProtection,
                --div--;' . $lll . 'tx_lssecurityheaders_headers.content_security_policy,
                    --palette--;' . $lll . 'tx_lssecurityheaders_headers.content_security_policy;contentSecurityPolicy,
                --div--;'.$lll . 'tx_lssecurityheaders_headers.permissions_policy,
                    --palette--;' . $lll . 'tx_lssecurityheaders_headers.permissions_policy;permissionPolicy,
                --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access,
                    --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.visibility;visibility,
                    --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.access;access,
            '
        ],
    ],
    'palettes' => [
        '1' => [
            'showitem' => ''
        ],
        'referrerPolicy' => [
            'showitem' => 'referrer_policy'
        ],
        'httpStrictTransportSecurity' => [
            'showitem' => 'http_strict_transport_security'
        ],
        'xFrameOptions' => [
            'showitem' => 'x_frame_options'
        ],
        'xXssProtection' => [
            'showitem' => 'x_xss_protection'
        ],
        'contentSecurityPolicy' => [
            'showitem' => 'content_security_policy'
        ],
        'permissionPolicy' => [
            'showitem' => 'permissions_policy'
        ],
        'access' => [
            'showitem' => '
                starttime;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:starttime_formlabel,
                endtime;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:endtime_formlabel
            '
        ],
        'visibility' => [
            'showitem' => '
                hidden;' . $lll . 'tx_lssecurityheaders_headers,
            '
        ],
    ],
    'columns' => [
        'hidden' => [
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.enabled',
            'config' => [
                'type' => 'check',
                'renderType' => 'checkboxToggle',
                'items' => [
                    [
                        0 => '',
                        1 => '',
                        'invertStateDisplay' => true
                    ]
                ],
            ]
        ],
        'starttime' => [
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.starttime',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'eval' => 'datetime,int',
                'default' => 0,
                'behaviour' => [
                    'allowLanguageSynchronization' => true,
                ]
            ]
        ],
        'endtime' => [
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.endtime',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'eval' => 'datetime,int',
                'default' => 0,
                'range' => [
                    'upper' => mktime(0, 0, 0, 1, 1, 2038),
                ],
                'behaviour' => [
                    'allowLanguageSynchronization' => true,
                ]
            ]
        ],
        'cruser_id' => [
            'label' => 'cruser_id',
            'config' => [
                'type' => 'passthrough'
            ]
        ],
        'pid' => [
            'label' => 'pid',
            'config' => [
                'type' => 'passthrough'
            ]
        ],
        'crdate' => [
            'label' => 'crdate',
            'config' => [
                'type' => 'passthrough',
            ]
        ],
        'tstamp' => [
            'label' => 'tstamp',
            'config' => [
                'type' => 'passthrough',
            ]
        ],
        'referrer_policy' => [
            'label' => $lll . 'tx_lssecurityheaders_headers.referrer_policy',
            'description' => $lll . 'tx_lssecurityheaders_headers.referrer_policy.description',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['', '',],
                    ['no-referrer', 'no-referrer',],
                    ['no-referrer-when-downgrade', 'no-referrer-when-downgrade',],
                    ['same-origin', 'same-origin',],
                    ['origin', 'origin',],
                    ['strict-origin', 'strict-origin',],
                    ['origin-when-cross-origin', 'origin-when-cross-origin',],
                    ['strict-origin-when-cross-origin', 'strict-origin-when-cross-origin',],
                    ['unsafe-url', 'unsafe-url',],
                ],
            ],
        ],
        'http_strict_transport_security' => [
            'label' => $lll . 'tx_lssecurityheaders_headers.http_strict_transport_security',
            'description' => $lll . 'tx_lssecurityheaders_headers.http_strict_transport_security.description',
            'config' => [
                'type' => 'input',
                'placeholder' => 'max-age=<expire-time>; includeSubDomains',
                'size' => 30,
                'eval' => 'trim',
            ],
        ],
        'x_frame_options' => [
            'label' => $lll . 'tx_lssecurityheaders_headers.x_frame_options',
            'description' => $lll . 'tx_lssecurityheaders_headers.x_frame_options.description',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['', '',],
                    ['SAMEORIGIN', 'SAMEORIGIN',],
                    ['DENY', 'DENY',],
                ],
            ],
        ],
        'x_xss_protection' => [
            'label' => $lll . 'tx_lssecurityheaders_headers.x_xss_protection',
            'description' => $lll . 'tx_lssecurityheaders_headers.x_xss_protection.description',
            'config' => [
                'type' => 'input',
                'placeholder' => '1; mode=block',
                'size' => 30,
                'eval' => 'trim',
            ],
        ],
        'content_security_policy' => [
            'label' => $lll . 'tx_lssecurityheaders_headers.content_security_policy',
            'description' => $lll . 'tx_lssecurityheaders_headers.content_security_policy.description',
            'config' => [
                'type' => 'flex',
                'ds' => [
                    'default' => 'FILE:EXT:ls_security_headers/Configuration/FlexForm/ContentSecurityPolicy.xml',
                ],
            ],
        ],
        'permissions_policy' => [
            'label' => $lll . 'tx_lssecurityheaders_headers.permissions_policy',
            'description' => $lll . 'tx_lssecurityheaders_headers.permissions_policy.description',
            'config' => [
                'type' => 'flex',
                'ds' => [
                    'default' => 'FILE:EXT:ls_security_headers/Configuration/FlexForm/PermissionPolicy.xml',
                ],
            ],
        ],
    ]
];
