<?php
namespace Citadel\Payload;

readonly class SessionResolveBearerResponse
{
    public function __construct(
        public ?ResolvedSession $session
    ) {}
}
