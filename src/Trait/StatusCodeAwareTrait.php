<?php
namespace Citadel\Trait;

trait StatusCodeAwareTrait
{
    protected ?int $responseStatusCode = null;

    public function getStatusCode(): ?int
    {
        return $this->responseStatusCode;
    }

    public function setStatusCode(?int $responseStatusCode): void
    {
        $this->responseStatusCode = $responseStatusCode;
    }
}
