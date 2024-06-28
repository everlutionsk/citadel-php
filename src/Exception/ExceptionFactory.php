<?php
namespace Citadel\Exception;

use Citadel\Interface\CitadelReportedExceptionInterface;
use Citadel\Interface\StatusCodeAwareExceptionInterface;
use Psr\Http\Message\ResponseInterface;

class ExceptionFactory
{
    public const string INVALID_JSON_PAYLOAD = 'The identity provider returned an invalid JSON payload';

    private const array EXCEPTION_CLASS_MAP = [
        'generic' => CitadelBaseException::class,
        'bearerExpired' => ExpiredTokenException::class,
        'bearerMalformed' => InvalidTokenException::class,
        'configError' => ConfigurationErrorException::class,
        'sessionInvalid' => InvalidSessionException::class,
        'notFound' => NotFoundException::class
    ];

    /**
     * @throws CitadelReportedExceptionInterface
     * @throws InternalServerErrorException
     * @throws MalformedPayloadException|CitadelBaseException
     */
    public static function generateExceptionFromResponse(ResponseInterface $response) :never
    {
        $body = $response->getBody()->getContents();
        $statusCode = $response->getStatusCode();

        if ($statusCode >= 500) {
            throw new InternalServerErrorException("Citadel reported internal server error", $statusCode);
        }

        try {
            $errorResponse = json_decode($body, true, 512, JSON_THROW_ON_ERROR);
        } catch (\JsonException $e) {
            throw new MalformedPayloadException(self::INVALID_JSON_PAYLOAD, 0, $e);
        }

        $errorType = $errorResponse['error']['type'] ?? null;
        $errorMessage = $errorResponse['error']['message'] ?? 'An unspecified error occurred';
        $errorId = $errorResponse['errorId'] ?? 'Not specified';
        $exceptionMessage = sprintf("%s: %s (%s)", $errorType, $errorMessage, $errorId);
        $exceptionClass = self::EXCEPTION_CLASS_MAP[$errorType] ?? CitadelBaseException::class;
        $exception = new $exceptionClass($exceptionMessage, 0);

        if ($exception instanceof StatusCodeAwareExceptionInterface) {
            $exception->setStatusCode($statusCode);
        }

        throw $exception;
    }
}
