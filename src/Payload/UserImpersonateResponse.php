<?php
namespace Citadel\Payload;

readonly class UserImpersonateResponse
{
    public function __construct(
        public string $status
    ) {}
}
