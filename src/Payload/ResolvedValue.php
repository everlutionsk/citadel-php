<?php
namespace Citadel\Payload;

readonly class ResolvedValue
{
    public function __construct(
        public string $name,
        public string|int|bool|null $value,
        public string $from
    ) {
    }
}
