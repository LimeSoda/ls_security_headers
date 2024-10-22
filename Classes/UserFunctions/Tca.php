<?php

namespace LimeSoda\LsSecurityHeaders\UserFunctions;

use TYPO3\CMS\Core\Site\Entity\Site;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;

class Tca
{
    public function securityHeaderTitle(&$parameters)
    {
        $site = $GLOBALS['TYPO3_REQUEST']->getAttribute('site');
        if (!$site instanceof Site) {
            return;
        }
        $parameters['title'] = LocalizationUtility::translate(
                'LLL:EXT:ls_security_headers/Resources/Private/Language/locallang_tca.xlf:tx_lssecurityheaders_headers'
            ) . ' (' . $site->getBase() . ')';
    }
}
