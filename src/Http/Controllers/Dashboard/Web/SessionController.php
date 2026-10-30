<?php

namespace Aliqsm\LaravelAuthkit\Http\Controllers\Dashboard\Web;

use Aliqsm\LaravelAuthkit\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SessionController extends Controller
{
    public function index(Request $request)
    {
        $userId = $request->user()->getAuthIdentifier();

        $sessions = DB::table('sessions')
            ->where('user_id', $userId)
            ->orderByDesc('last_activity')
            ->get()
            ->map(function ($session) {
                $agent = strtolower($session->user_agent ?? '');

                $session->device = match (true) {
                    str_contains($agent, 'iphone') => 'iPhone',
                    str_contains($agent, 'ipad') => 'iPad',
                    str_contains($agent, 'android') => 'Android',
                    str_contains($agent, 'windows') => 'Windows',
                    str_contains($agent, 'macintosh'),
                    str_contains($agent, 'mac os') => 'Mac',
                    str_contains($agent, 'linux') => 'Linux',
                    default => 'Unknown Device',
                };

                $session->browser = match (true) {
                    str_contains($agent, 'edg') => 'Edge',
                    str_contains($agent, 'firefox') => 'Firefox',
                    str_contains($agent, 'opr'),
                    str_contains($agent, 'opera') => 'Opera',
                    str_contains($agent, 'chrome') => 'Chrome',
                    str_contains($agent, 'safari') => 'Safari',
                    default => 'Unknown Browser',
                };

                return $session;
            });

        return view('dashboard.sessions.index', [
            'sessions' => $sessions,
        ]);
    }
}