<?php

namespace Aliqsm\LaravelAuthkit\Actions\Sessions;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserSessionsAction
{
    public function execute(Request $request): object
    {
        $user = $request->user();
        $currentSessionId = $request->session()->getId();

        return DB::table('sessions')
            ->where('user_id', $user->id)
            ->orderByDesc('last_activity')
            ->get(['id', 'user_agent', 'last_activity'])
            ->map(function ($session) use ($currentSessionId) {

                $agent = strtolower($session->user_agent ?? '');

                // -------------------------------------
                // Detect Device
                // -------------------------------------
                $device = match (true) {
                    str_contains($agent, 'iphone') => 'iPhone',
                    str_contains($agent, 'ipad') => 'iPad',
                    str_contains($agent, 'android') => 'Android',
                    str_contains($agent, 'windows') => 'Windows',
                    str_contains($agent, 'macintosh'),
                    str_contains($agent, 'mac os') => 'Mac',
                    str_contains($agent, 'linux') => 'Linux',
                    default => 'Unknown',
                };

                // -------------------------------------
                // Format Session Data
                // -------------------------------------
                return (object) [
                    'id' => $session->id,
                    'device' => $device,
                    'last_activity' => $session->last_activity,
                    'isCurrent' => $session->id === $currentSessionId,
                ];
            });
    }
}
