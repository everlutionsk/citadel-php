<?php
namespace Citadel\Payload;

readonly class ResolvedSession
{
    public function __construct(
        public string $id,
        public string $sid,
        public array $identities,
        public string $audience,
        public \DateTime $issuedAt,
        public \DateTime $refreshedAt,
        public \DateTime $expiresAt,
        public \DateTime $resolvedAt
    ) {
    }
}
