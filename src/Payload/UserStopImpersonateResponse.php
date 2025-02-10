<?php
namespace Citadel\Payload;

readonly class UserStopImpersonateResponse
{
    public function __construct(
        public string $status
    ) {}
}
