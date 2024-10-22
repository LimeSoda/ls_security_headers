<?php

declare(strict_types=1);

namespace LimeSoda\LsSecurityHeaders\Middleware;

use Doctrine\DBAL\Exception;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use TYPO3\CMS\Core\Database\Connection;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Service\FlexFormService;
use TYPO3\CMS\Core\Site\Entity\Site;
use TYPO3\CMS\Core\Utility\GeneralUtility;

final class SecurityHeadersMiddleware implements MiddlewareInterface
{
    public function __construct(
        private readonly FlexFormService $flexFormService
    )
    {
    }

    public function process(
        ServerRequestInterface $request,
        RequestHandlerInterface $handler
    ): ResponseInterface {
        $response = $handler->handle($request);

        $site = $request->getAttribute('site');

        if (!$site instanceof Site) {
            return $response;
        }

        $securityHeaders = $this->getSecurityHeadersBySite($site->getRootPageId());

        if (!empty($securityHeaders["referrer_policy"])) {
            $response = $response->withHeader('Referrer-Policy', $securityHeaders["referrer_policy"]);
        }

        if (!empty($securityHeaders["http_strict_transport_security"])) {
            $response = $response->withHeader(
                'Strict-Transport-Security',
                $securityHeaders["http_strict_transport_security"],
            );
        }

        if (!empty($securityHeaders["x_frame_options"])) {
            $response = $response->withHeader('X-Frame-Options', $securityHeaders["x_frame_options"]);
        }

        if (!empty($securityHeaders["x_xss_protection"])) {
            $response = $response->withHeader('X-Xss-Protection', $securityHeaders["x_xss_protection"]);
        }

        if (isset($securityHeaders["content_security_policy"])) {
            $contentSecurityPolicy = $this->flexFormService
                ->convertFlexFormContentToArray($securityHeaders["content_security_policy"]);

            foreach ($contentSecurityPolicy as $key => $value) {
                foreach ($GLOBALS['LS_SECURITY_HEADERS']['CSP_NONCE'][preg_split("/[[:upper:]]/u", $key)[0]] ?? [] as $nonce) {
                    $value .= $value ? " 'nonce-{$nonce}'" : "'nonce-{$nonce}'";
                }

                if (!empty($value)) {
                    $contentSecurityPolicies[] = str_replace(
                        '_',
                        '-',
                        GeneralUtility::camelCaseToLowerCaseUnderscored($key)
                    ) . ' ' . $value;
                }
            }

            if (!empty($contentSecurityPolicies)) {
                $response = $response->withHeader('Content-Security-Policy', implode('; ', $contentSecurityPolicies));
            }
        }

        if (isset($securityHeaders["permissions_policy"])) {
            $permissionsPolicy = $this->flexFormService
                ->convertFlexFormContentToArray($securityHeaders["permissions_policy"]);

            foreach ($permissionsPolicy as $key => $value) {
                if (!empty($value)) {
                    $permissionsPolicies[] = str_replace(
                        '_',
                        '-',
                        GeneralUtility::camelCaseToLowerCaseUnderscored($key)
                    ) . "=($value)";
                }
            }

            if (!empty($permissionsPolicies)) {
                $response = $response->withHeader('Permissions-Policy', implode(', ', $permissionsPolicies));
            }
        }

        return $response;
    }

    /**
     * @param int $rootPageId
     * @return string[]
     * @throws Exception
     */
    public
    function getSecurityHeadersBySite(
        int $rootPageId
    ): array {
        $qb = GeneralUtility::makeInstance(ConnectionPool::class)
            ->getQueryBuilderForTable('tx_lssecurityheaders_headers');
        $qb->select('*')
            ->from('tx_lssecurityheaders_headers')
            ->where(
                $qb->expr()->eq(
                    'pid',
                    $qb->createNamedParameter($rootPageId, Connection::PARAM_INT)
                )
            )
            ->setMaxResults(1);

        $result = $qb->executeQuery()->fetchAssociative();

        if ($result !== false) {
            return $result;
        }

        return [];
    }
}
