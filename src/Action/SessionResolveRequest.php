<?php
namespace Citadel\Action;

use Citadel\Exception\MalformedCookieHeaderException;
use Citadel\Interface\CitadelRequestInstanceInterface;

class SessionResolveRequest implements CitadelRequestInstanceInterface
{
    private const string HOST_PATTERN = '/(?<host>__Host-CSID=[^;]+)/';
    private const string SECURE_PATTERN = '/(?<secure>__Secure-CSIDa=[^;]+)/';

    /**
     * @throws MalformedCookieHeaderException
     */
    public function __construct(
        public string $cookieHeader,
        public readonly string $clientId,
        public readonly string $clientSecret
    ) {
        $this->cookieHeader = $this->parseAndValidateCookieHeader($this->cookieHeader);
    }

    /**
     * @throws MalformedCookieHeaderException
     */
    private function parseAndValidateCookieHeader(string $cookieHeader): string
    {
        $cookieHeaderComponentsFound = [];

        if (preg_match(self::HOST_PATTERN, $cookieHeader, $hostMatches)) {
            $cookieHeaderComponentsFound[] = $hostMatches['host'];
        }

        if (preg_match(self::SECURE_PATTERN, $cookieHeader, $secureMatches)) {
            $cookieHeaderComponentsFound[] = $secureMatches['secure'];
        }

        if (empty($cookieHeaderComponentsFound)) {
            throw new MalformedCookieHeaderException(
                "The required components of the header value could not be found"
            );
        }

        return implode('; ', $cookieHeaderComponentsFound) . ';';
    }
}
