<?php
namespace Citadel\Exception;

use Citadel\Interface\StatusCodeAwareExceptionInterface;
use Citadel\Trait\StatusCodeAwareTrait;

class InvalidSessionException extends CitadelBaseException implements StatusCodeAwareExceptionInterface
{
    use StatusCodeAwareTrait;
}
