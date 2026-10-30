<?php

namespace Aliqsm\LaravelAuthkit\Http\Controllers\Dashboard\Web;

use Aliqsm\LaravelAuthkit\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard.index');
    }
}