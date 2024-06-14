<?php
namespace Citadel\Exception;

use Citadel\Interface\CitadelReportedExceptionInterface;
use Citadel\Interface\StatusCodeAwareExceptionInterface;
use Citadel\Trait\StatusCodeAwareTrait;

class InvalidTokenException extends CitadelBaseException implements StatusCodeAwareExceptionInterface,
     CitadelReportedExceptionInterface
{
    use StatusCodeAwareTrait;
}
