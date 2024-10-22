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
    'version' => '1.3.2',
    'constraints' => [
        'depends' => [
            'typo3' => '11.5.0-12.9.99',
            'php' => '7.4.0-8.2.99',
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
