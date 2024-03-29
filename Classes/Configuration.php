<?php
declare(strict_types=1);

namespace LimeSoda\LsSecurityHeaders;

class Configuration
{
    /**
     * Call from ext_tables.php
     *
     * @param string $extensionKey
     * @return void
     */
    public function extTables(string $extensionKey): void
    {
        // @TODO migrate to [ctrl][security][ignorePageTypeRestriction] for Typo3 13
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_lssecurityheaders_headers');
    }
}
