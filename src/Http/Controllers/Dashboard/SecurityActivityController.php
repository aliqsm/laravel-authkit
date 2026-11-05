<?php

namespace Aliqsm\LaravelAuthkit\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use Aliqsm\LaravelAuthkit\Http\Controllers\Controller;
use Aliqsm\LaravelAuthkit\Actions\Dashboard\SecurityActivitiesAction;
use Aliqsm\LaravelAuthkit\Http\Responses\Dashboard\SecurityActivitiesResponse;

class SecurityActivityController extends Controller
{
    // -------------------------------------
    // Security Activities
    // -------------------------------------
    public function index(Request $request, SecurityActivitiesAction $action, SecurityActivitiesResponse $response)
    {
        $activities = $action->execute($request);

        return $response->toResponse($activities);
    }
}