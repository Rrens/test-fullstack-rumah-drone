<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $active = 'dashboard';
        $active_detail = '';

        return view('pages.dashboard', compact('active', 'active_detail'));
    }
}
