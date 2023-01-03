<?php
defined('TYPO3') || die();

\TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\LimeSoda\LsSecurityHeaders\Configuration::class)
    ->extTables('ls_security_headers');
