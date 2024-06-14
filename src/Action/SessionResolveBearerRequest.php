<?php
namespace Citadel\Action;

use Citadel\Interface\CitadelRequestInstanceInterface;

readonly class SessionResolveBearerRequest implements CitadelRequestInstanceInterface
{
    public function __construct(
        public string $token
    ) {}
}
