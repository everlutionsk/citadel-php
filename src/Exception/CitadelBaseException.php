<?php
namespace Citadel\Exception;

use Exception;
use Throwable;

class CitadelBaseException extends Exception
{
    public function __construct(
        string $message = "Unidentified API error",
        int $code = 0,
        ?Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}
