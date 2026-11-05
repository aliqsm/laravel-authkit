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

        $sessions = DB::table('sessions')
            ->where('user_id', $user->id)
            ->orderByDesc('last_activity')
            ->get(['id', 'user_agent', 'last_activity'])
            ->map(function ($session) use ($currentSessionId) {

                $agent = strtolower($session->user_agent ?? '');

                // -------------------------------------
                // Detect Device
                // -------------------------------------
                $device = match (true) {
                    str_contains($agent, 'iphone') => 'Laptop',
                    str_contains($agent, 'ipad') => 'Laptop',
                    str_contains($agent, 'android') => 'Laptop',
                    str_contains($agent, 'mobile') => 'Mobile',
                    default => 'Unknown',
                };

                // -------------------------------------
                // Detect Platform
                // -------------------------------------
                $platform = match (true) {
                    str_contains($agent, 'windows') => 'Windows',
                    str_contains($agent, 'iphone'),
                    str_contains($agent, 'ipad') => 'iOS',
                    str_contains($agent, 'android') => 'Android',
                    str_contains($agent, 'macintosh'),
                    str_contains($agent, 'mac os') => 'macOS',
                    str_contains($agent, 'linux') => 'Linux',
                    default => 'Unknown',
                };

                // -------------------------------------
                // Format Session Data
                // -------------------------------------
                return [
                    'id' => $session->id,
                    'device' => $device,
                    'platform' => $platform,
                    'lastActivity' => $session->last_activity,
                    'isCurrent' => $session->id === $currentSessionId,
                ];
            });


          return $sessions;
    }
}
