<?php

namespace Bws\Core\Http\Controllers;

use Illuminate\Http\Request;

class AdminDashboardController extends CoreController
{
    public function __construct()
    {
        $this->middleware(['auth', 'can.access.dashboard']);
    }

    public function getDashboard(Request $request)
    {
        return view('bws@core::pages.dashboard');
    }
}
