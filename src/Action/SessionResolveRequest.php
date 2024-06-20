<?php
namespace Citadel\Action;

use Citadel\Exception\MalformedCookieHeaderException;
use Citadel\Interface\CitadelRequestInstanceInterface;
use Citadel\Trait\CookieHeaderParserTrait;

class SessionResolveRequest implements CitadelRequestInstanceInterface
{
    use CookieHeaderParserTrait;

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
}
