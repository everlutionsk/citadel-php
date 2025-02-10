<?php
namespace Citadel\Action;

use Citadel\Interface\CitadelRequestInstanceInterface;

readonly class UserStopImpersonateRequest implements CitadelRequestInstanceInterface
{
    public function __construct(
        public string $sid
    ) {}
}
