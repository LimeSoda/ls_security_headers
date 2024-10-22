<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'LIMESODA Security Headers',
    'description' => 'Configures security headers like content security policy',
    'category' => 'misc',
    'author' => 'LIMESODA',
    'author_email' => 'typo3-ter@limesoda.com',
    'author_company' => 'LimeSoda Interactive Marketing GmbH',
    'state' => 'stable',
    'clearCacheOnLoad' => true,
    'version' => '2.0.0',
    'constraints' => [
        'depends' => [
            'typo3' => '13.4.0-13.4.99',
            'php' => '8.2.0-8.3.99',
        ],
        'conflicts' => [],
        'suggests' => [],
    ],
    'autoload' => [
        'psr-4' => [
            'LimeSoda\\LsSecurityHeaders\\' => 'Classes'
        ],
    ],
];
