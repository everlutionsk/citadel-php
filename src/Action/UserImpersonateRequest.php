<?php
namespace Citadel\Action;

use Citadel\Interface\CitadelRequestInstanceInterface;

readonly class UserImpersonateRequest implements CitadelRequestInstanceInterface
{
    public function __construct(
        public string $sid,
        public string $userId
    ) {}
}
