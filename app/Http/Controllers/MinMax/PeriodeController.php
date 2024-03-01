<?php

namespace App\Http\Controllers\MinMax;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PeriodeController extends Controller
{
    public function index()
    {
        $active = 'min-max';
        $active_detail = 'periode';
        return view('pages.transaksi-service', compact('active', 'active_detail'));
    }
}
