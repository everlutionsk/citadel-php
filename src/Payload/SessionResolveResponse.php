<?php
namespace Citadel\Payload;

readonly class SessionResolveResponse
{
    public function __construct(
        public ?ResolvedSession $session,
        public Recommended $recommended
    ) {}
}
