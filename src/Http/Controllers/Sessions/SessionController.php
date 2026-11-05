<?php

namespace Aliqsm\LaravelAuthkit\Http\Controllers\Sessions;

use Aliqsm\LaravelAuthkit\Actions\Sessions\LogoutOtherSessionsAction;
use Aliqsm\LaravelAuthkit\Http\Controllers\Controller;
use Aliqsm\LaravelAuthkit\Actions\Sessions\UserSessionsAction;
use Aliqsm\LaravelAuthkit\Http\Requests\Sessions\LogoutOtherSessionsRequest;
use Aliqsm\LaravelAuthkit\Http\Responses\Sessions\LogoutOtherSessionsResponse;
use Aliqsm\LaravelAuthkit\Http\Responses\Sessions\UserSessionsResponse;
use Illuminate\Http\Request;

class SessionController extends Controller
{
    // ------------------------------------
    // Get User Sessions
    // ------------------------------------
    public function index(Request $request, UserSessionsAction $action, UserSessionsResponse $response)
    {
        $sessions = $action->execute($request);

        return $response->toResponse($sessions);
    }


    // ------------------------------------
    // Logout Other Sessions
    // ------------------------------------
    public function destroyOthers(LogoutOtherSessionsRequest $request, LogoutOtherSessionsAction $action, LogoutOtherSessionsResponse $response)
    {
        $action->execute(
            request: $request,
            data: $request->validated()
        );

        return $response->toResponse();
    }
}
