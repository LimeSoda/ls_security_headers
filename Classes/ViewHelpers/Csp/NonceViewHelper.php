<?php

declare(strict_types=1);

namespace LimeSoda\ProjectBase\ViewHelpers\Csp;

use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3Fluid\Fluid\Core\ViewHelper\Traits\CompileWithContentArgumentAndRenderStatic;

class NonceViewHelper extends AbstractViewHelper
{
    use CompileWithContentArgumentAndRenderStatic;

    /**
     * @return void
     */
    public function initializeArguments(): void
    {
        $this->registerArgument(
            'policy',
            'string',
            'Define the CSP policy the nonce should be added to (script-src, style-src, ...).'
            . 'Only use the first part of the policy name (script, style, ...).',
            true,
        );

        $this->registerArgument('length', 'int', 'Length of nonce in bytes.', false, 32);
    }

    /**
     * @param array $arguments
     * @param \Closure $renderChildrenClosure
     * @param RenderingContextInterface $renderingContext
     * @return string
     * @throws \Exception
     */
    public static function renderStatic(
        array $arguments,
        \Closure $renderChildrenClosure,
        RenderingContextInterface $renderingContext
    ): string
    {
        $nonce = bin2hex(random_bytes($arguments['length']));

        $GLOBALS['LS_SECURITY_HEADERS']['CSP_NONCE'][$arguments['policy']][] = $nonce;

        return $nonce;
    }
}
