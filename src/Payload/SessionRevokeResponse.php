<?php
namespace Citadel\Payload;

readonly class SessionRevokeResponse
{
    public function __construct(
        public array $responseHeaders
    ) {}
}
