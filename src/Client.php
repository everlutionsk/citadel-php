<?php

namespace Citadel;

use Citadel\Action\SessionResolveBearerRequest;
use Citadel\Action\SessionResolveRequest;
use Citadel\Action\SessionRevokeBearerRequest;
use Citadel\Action\SessionRevokeRequest;
use Citadel\Exception\ExceptionFactory;
use Citadel\Exception\MalformedPayloadException;
use Citadel\Exception\MalformedTimestampException;
use Citadel\Interface\CitadelReportedExceptionInterface;
use Citadel\Interface\CitadelRequestInstanceInterface;
use Citadel\Interface\ClientInterface;
use Citadel\Payload\MultiValueHeaders;
use Citadel\Payload\Recommended;
use Citadel\Payload\ResolvedIdentity;
use Citadel\Payload\ResolvedSession;
use Citadel\Payload\ResolvedValue;
use Citadel\Payload\SessionResolveBearerResponse;
use Citadel\Payload\SessionResolveResponse;
use Citadel\Payload\SessionRevokeBearerResponse;
use Citadel\Payload\SessionRevokeResponse;
use GuzzleHttp\Client as GuzzleClient;

class Client implements ClientInterface
{
    private const string SDK_VERSION = '0.4.0-php';

    private GuzzleClient $guzzleClient;

    public function __construct(
        private readonly string $baseUrl,
        private readonly string $preSharedKey,
        ?GuzzleClient $guzzleClient = null
    ) {

        if (is_null($guzzleClient)) {
            $guzzleClient = new GuzzleClient();
        }
        $this->guzzleClient = $guzzleClient;
    }

    /**
     * @throws MalformedPayloadException
     */
    public function sessionResolve(SessionResolveRequest $request): SessionResolveResponse
    {
        return $this->sendRequest('/sessions.resolve', $request, function ($responseData) {
            $session = isset($responseData['session']) ? $this->mapResolvedSession($responseData['session']) : null;
            $recommended = new Recommended(
                $responseData['recommended']['action'] ?? null,
                new MultiValueHeaders($responseData['recommended']['responseHeaders'] ?? []),
                $responseData['recommended']['reason'] ?? 'Not specified'
            );
            return new SessionResolveResponse($session, $recommended);
        });
    }

    public function sessionRevoke(SessionRevokeRequest $request): SessionRevokeResponse
    {
        return $this->sendRequest('/sessions.revoke', $request, function ($responseData) {
            return new SessionRevokeResponse($responseData['responseHeaders']);
        });
    }

    public function sessionResolveBearer(SessionResolveBearerRequest $request): SessionResolveBearerResponse
    {
        return $this->sendRequest('/sessions.bearerResolve', $request, function ($responseData) {
            $session = isset($responseData['session']) ? $this->mapResolvedSession($responseData['session']) : null;
            return new SessionResolveBearerResponse($session);
        });
    }

    public function sessionRevokeBearer(SessionRevokeBearerRequest $request): SessionRevokeBearerResponse
    {
        return $this->sendRequest('/sessions.bearerRevoke', $request, function ($responseData) {
            return new SessionRevokeBearerResponse($responseData['status']);
        });
    }

    /**
     * @throws MalformedPayloadException|CitadelReportedExceptionInterface
     */
    private function sendRequest(
        string $action,
        CitadelRequestInstanceInterface $request,
        callable $mapper
    ) {
        try {
            $requestBody = json_encode($request, JSON_THROW_ON_ERROR);
        } catch (\JsonException) {
            throw new MalformedPayloadException(
                sprintf(
                    "The request instance %s could not be JSON encoded",
                    $request::class
                )
            );
        }

        $response = $this->guzzleClient->post($this->baseUrl . $action, [
            'headers' => [
                'Content-Type' => 'application/json',
                'x-sdk-version' => self::SDK_VERSION
            ],
            'body' => $requestBody
        ]);

        $statusCode = $response->getStatusCode();
        $body = $response->getBody()->getContents();

        if ($statusCode >= 400) {
            ExceptionFactory::generateExceptionFromResponse($response);
        }

        try {
            $responseData = json_decode($body, true, 512, JSON_THROW_ON_ERROR);

            return $mapper($responseData);
        } catch (\JsonException $e) {
            throw new MalformedPayloadException("The response data is not valid JSON");
        }
    }

    /**
     * @throws MalformedTimestampException
     */
    private function mapResolvedSession(array $sessionData): ResolvedSession
    {
        try {
            $issuedAt = new \DateTime($sessionData['issuedAt']);
            $refreshedAt = new \DateTime($sessionData['refreshedAt']);
            $expiresAt = new \DateTime($sessionData['expiresAt']);
            $resolvedAt = new \DateTime($sessionData['resolvedAt']);
        } catch (\Exception) {
            throw new MalformedTimestampException(
                "The payload contains date/times that could not be used to initialise DateTime instances"
            );
        }

        return new ResolvedSession(
            $sessionData['id'],
            $sessionData['sid'],
            array_map(static function ($identity) {
                try {
                    $assignedAt = new \DateTime($identity['assignedAt']);
                } catch (\Exception) {
                    throw new MalformedTimestampException(
                        "The assignedAt field contains an invalid timestamp"
                    );
                }

                return new ResolvedIdentity(
                    $identity['id'],
                    $assignedAt,
                    $identity['user'],
                    array_map(static function ($value) {
                        return new ResolvedValue(
                            $value['name'],
                            $value['value'],
                            $value['from']
                        );
                    }, $identity['data']),
                    $identity['status']
                );
            }, $sessionData['identities']),
            $sessionData['audience'],
            $issuedAt,
            $refreshedAt,
            $expiresAt,
            $resolvedAt
        );
    }
}
