<?php
return [
    'frontend' => [
        'limesoda/security-headers' => [
            'target' => \LimeSoda\LsSecurityHeaders\Middleware\SecurityHeadersMiddleware::class,
            'before' => [
                'typo3/cms-frontend/content-length-headers',
            ],
            'after' => [
                'typo3/cms-frontend/site',
            ],
        ]
    ]
];
