<?php
namespace Citadel\Interface;

use Citadel\Action\SessionResolveBearerRequest;
use Citadel\Action\SessionResolveRequest;
use Citadel\Action\SessionRevokeBearerRequest;
use Citadel\Action\SessionRevokeRequest;
use Citadel\Action\UserImpersonateRequest;
use Citadel\Action\UserStopImpersonateRequest;
use Citadel\Payload\SessionResolveBearerResponse;
use Citadel\Payload\SessionResolveResponse;
use Citadel\Payload\SessionRevokeBearerResponse;
use Citadel\Payload\SessionRevokeResponse;
use Citadel\Payload\UserImpersonateResponse;
use Citadel\Payload\UserStopImpersonateResponse;

interface ClientInterface
{
    public function sessionResolve(SessionResolveRequest $request): SessionResolveResponse;

    public function sessionRevoke(SessionRevokeRequest $request): SessionRevokeResponse;

    public function sessionResolveBearer(SessionResolveBearerRequest $request): SessionResolveBearerResponse;

    public function sessionRevokeBearer(SessionRevokeBearerRequest $request): SessionRevokeBearerResponse;

    public function userImpersonate(UserImpersonateRequest $request): UserImpersonateResponse;

    public function userStopImpersonate(UserStopImpersonateRequest $request): UserStopImpersonateResponse;
}
