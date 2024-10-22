<?php

namespace LimeSoda\LsSecurityHeaders\Userfuncs;

use TYPO3\CMS\Core\Site\Entity\Site;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;

class Csp
{
    /**
     * @var ContentObjectRenderer
     */
    private ContentObjectRenderer $cObj;

    /**
     * @param ContentObjectRenderer $cObj
     * @return void
     */
    public function setContentObjectRenderer(ContentObjectRenderer $cObj): void
    {
        $this->cObj = $cObj;
    }

    /**
     * @param string $_
     * @param array $conf
     * @return string
     * @throws \Exception
     */
    public function generateNonce(string $_, array $conf): string
    {
        $length = $this->cObj->cObjGetSingle($conf['length'], $conf['length.']);
        $policy = $this->cObj->cObjGetSingle($conf['policy'], $conf['policy.']);

        $nonce = bin2hex(random_bytes($length));

        $GLOBALS['LS_SECURITY_HEADERS']['CSP_NONCE'][$policy][] = $nonce;

        return $nonce;
    }
}
