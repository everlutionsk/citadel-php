<?php
namespace Citadel\Payload;

readonly class ResolvedIdentity
{
    public function __construct(
        public string $id,
        public \DateTime $assignedAt,
        public string $user,
        public array $data,
        public string $status
    ) {
    }
}
