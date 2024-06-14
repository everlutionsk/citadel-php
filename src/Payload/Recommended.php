<?php
namespace Citadel\Payload;

readonly class Recommended
{
    public function __construct(
        public string $action,
        public MultiValueHeaders $responseHeaders,
        public string $reason
    ) {}
}
