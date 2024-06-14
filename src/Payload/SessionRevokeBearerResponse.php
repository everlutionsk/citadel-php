<?php
namespace Citadel\Payload;

readonly class SessionRevokeBearerResponse
{
    public function __construct(
        public string $status
    ) {}
}
