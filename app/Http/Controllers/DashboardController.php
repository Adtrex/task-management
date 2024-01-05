<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return view('layout.dashboard.app');
    }

    public function view()
    {
        return view('layout.dashboard.app');
    }
}
