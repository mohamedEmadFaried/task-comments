<?php

namespace App\Http\Controllers\System;

use Illuminate\Http\Request;

// use Session;

class DashboardController extends SystemController
{

    public function index(Request $request)
    {
       
        return view('dashboard');
    }
}
