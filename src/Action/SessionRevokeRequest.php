<?php
namespace Citadel\Action;

use Citadel\Interface\CitadelRequestInstanceInterface;

readonly class SessionRevokeRequest implements CitadelRequestInstanceInterface
{
    public function __construct(
        public string $cookieHeader,
        public string $clientId,
        public string $clientSecret
    ) {}
}
