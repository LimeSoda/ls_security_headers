<?php

declare(strict_types=1);

namespace LimeSoda\LsSecurityHeaders\Middleware;

use Doctrine\DBAL\DBALException;
use Doctrine\DBAL\Driver\Exception;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Service\FlexFormService;
use TYPO3\CMS\Core\Site\Entity\Site;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class SecurityHeadersMiddleware implements MiddlewareInterface
{
    /**
     * @var FlexFormService
     */
    protected $flexFormService;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->flexFormService = GeneralUtility::makeInstance(FlexFormService::class);
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

        if (isset($securityHeaders["referrer_policy"])) {
            $response = $response->withHeader('Referrer-Policy', $securityHeaders["referrer_policy"]);
        }

        if (isset($securityHeaders["http_strict_transport_security"])) {
            $response = $response->withHeader(
                'Strict-Transport-Security',
                $securityHeaders["http_strict_transport_security"]
            );
        }

        if (isset($securityHeaders["x_frame_options"])) {
            $response = $response->withHeader('X-Frame-Options', $securityHeaders["x_frame_options"]);
        }

        if (isset($securityHeaders["x_xss_protection"])) {
            $response = $response->withHeader('X-Xss-Protection', $securityHeaders["x_xss_protection"]);
        }

        if (isset($securityHeaders["content_security_policy"])) {
            $contentSecurityPolicy = $this->flexFormService->convertFlexFormContentToArray(
                $securityHeaders["content_security_policy"]
            );
            foreach ($contentSecurityPolicy as $key => $value) {
                if ($value) {
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
            $permissionsPolicy = $this->flexFormService->convertFlexFormContentToArray(
                $securityHeaders["permissions_policy"]
            );
            foreach ($permissionsPolicy as $key => $value) {
                if ($value) {
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
     * @throws DBALException
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
                    $qb->createNamedParameter($rootPageId, \PDO::PARAM_INT)
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
