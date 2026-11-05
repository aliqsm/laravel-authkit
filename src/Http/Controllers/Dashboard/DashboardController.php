<?php

namespace Aliqsm\LaravelAuthkit\Http\Controllers\Dashboard;

use Aliqsm\LaravelAuthkit\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        return view('authkit::dashboard.index');
    }
}