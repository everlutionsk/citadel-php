<?php
namespace Citadel\Interface;

interface StatusCodeAwareExceptionInterface
{
    public function getStatusCode(): ?int;

    public function setStatusCode(?int $responseStatusCode): void;
}
