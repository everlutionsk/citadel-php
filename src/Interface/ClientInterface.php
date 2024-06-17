<?php
namespace Citadel\Interface;

use Citadel\Action\SessionResolveBearerRequest;
use Citadel\Action\SessionResolveRequest;
use Citadel\Action\SessionRevokeBearerRequest;
use Citadel\Action\SessionRevokeRequest;
use Citadel\Payload\SessionResolveBearerResponse;
use Citadel\Payload\SessionResolveResponse;
use Citadel\Payload\SessionRevokeBearerResponse;
use Citadel\Payload\SessionRevokeResponse;

interface ClientInterface
{
    public function sessionResolve(SessionResolveRequest $request): SessionResolveResponse;

    public function sessionRevoke(SessionRevokeRequest $request): SessionRevokeResponse;

    public function sessionResolveBearer(SessionResolveBearerRequest $request): SessionResolveBearerResponse;

    public function sessionRevokeBearer(SessionRevokeBearerRequest $request): SessionRevokeBearerResponse;
}
