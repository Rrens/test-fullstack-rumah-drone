<?php

namespace App\Http\Controllers\Service;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SalesOutController extends Controller
{
    public function index()
    {
        $active = 'transaction';
        $active_detail = 'sales-out';
        return view('pages.Transaction.sales-out', compact('active', 'active_detail'));
    }
}
