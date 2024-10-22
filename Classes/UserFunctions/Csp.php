<?php

namespace LimeSoda\LsSecurityHeaders\UserFunctions;

use Psr\Http\Message\ServerRequestInterface;

class Csp
{
    public function generateNonce(string $_, array $conf, ServerRequestInterface $request): string
    {
        if ($conf['asAttribute'] === '1') {
            $length = $conf['length'];
            $policy = $conf['policy'];
        } else {
            $length = $request->getAttribute('currentContentObject')->cObjGetSingle($conf['length'], $conf['length.']);
            $policy = $request->getAttribute('currentContentObject')->cObjGetSingle($conf['policy'], $conf['policy.']);
        }

        $nonce = bin2hex(random_bytes($length ?? 32));

        $GLOBALS['LS_SECURITY_HEADERS']['CSP_NONCE'][$policy][] = $nonce;

        if ($conf['asAttribute'] === '1') {
            return " nonce=\"$nonce\"";
        }

        return $nonce;
    }
}
