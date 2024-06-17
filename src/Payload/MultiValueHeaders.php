<?php
namespace Citadel\Payload;

readonly class MultiValueHeaders
{
    public function __construct(
        public array $headers
    ) {}
}
