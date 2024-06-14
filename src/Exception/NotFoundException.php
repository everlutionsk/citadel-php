<?php
namespace Citadel\Exception;

use Citadel\Interface\StatusCodeAwareExceptionInterface;
use Citadel\Trait\StatusCodeAwareTrait;

class NotFoundException extends CitadelBaseException implements StatusCodeAwareExceptionInterface
{
    use StatusCodeAwareTrait;
}
