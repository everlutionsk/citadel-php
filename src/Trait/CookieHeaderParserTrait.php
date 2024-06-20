<?php
namespace Citadel\Trait;

use Citadel\Exception\MalformedCookieHeaderException;

trait CookieHeaderParserTrait
{
    private const string HOST_PATTERN = '/(?<host>__Host-CSID=[^;]+)/';
    private const string SECURE_PATTERN = '/(?<secure>__Secure-CSIDa=[^;]+)/';

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
