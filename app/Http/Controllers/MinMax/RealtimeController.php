<?php

namespace App\Http\Controllers\MinMax;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RealtimeController extends Controller
{
    public function index()
    {
        $active = 'min-max';
        $active_detail = 'realtime';

        $current = Carbon::now()->subMonth(1)->format('m');

        $jum_hari = DB::table('history')
            ->select(DB::raw('DAY(LAST_DAY(date)) as jum_hari'))
            ->whereMonth('date', $current)
            ->whereNull('deleted_at')
            ->get();
        foreach ($jum_hari as $data) {
            $jum_hari = $data->jum_hari;
        }

        $hitung = DB::table('history')
            ->join("product_items", function ($join) {
                $join->on("product_items.id", "=", "history.item_id");
            })
            //->select(DB::raw('MAX(total) as besar, round(SUM(total)/30) as rata'))
            ->select(DB::raw('*,MAX(total) as besar, SUM(total) as rata'))
            ->whereMonth('date', $current)
            ->groupBy('product_items.id')
            ->whereNull('product_items.deleted_at')
            ->whereNull('history.deleted_at')
            ->get();
        // dd($hitung);


        //	echo "<script>console.log('Debug Objects: " . $jum_hari . "' );</script>";

        $data_part = DB::table('product_items')
            ->join("history", function ($join) {
                $join->on("product_items.id", "=", "history.item_id");
            })
            ->whereMonth('history.date', $current)
            ->select("product_items.id as id_part", "product_items.name as nm_motor", "product_items.stock as stok", "product_items.lead_time as time")
            ->groupBy('product_items.id')
            ->whereNull('product_items.deleted_at')
            ->whereNull('history.deleted_at')
            ->get();
        // dd($hitung, $data_part);
        // dd($data_part, $hitung, $jum_hari);

        return view('pages.Minmax.realtime', compact(
            'active',
            'active_detail',
            'data_part',
            'jum_hari',
            'hitung'
        ));
    }

    public function next_periode()
    {
        $active = 'min-max';
        $active_detail = 'periode';

        $current = Carbon::now()->format('m');
        // dd($current);
        $jum_hari = DB::table('history')
            ->select(DB::raw('DAY(LAST_DAY(date)) as jum_hari'))
            ->whereMonth('date', $current)
            ->whereNull('deleted_at')
            ->get();
        foreach ($jum_hari as $data) {
            $jum_hari = $data->jum_hari;
        }

        $hitung = DB::table('history')
            ->join("product_items", function ($join) {
                $join->on("product_items.id", "=", "history.item_id");
            })
            //->select(DB::raw('MAX(total) as besar, round(SUM(total)/30) as rata'))
            ->select(DB::raw('*,MAX(total) as besar, SUM(total) as rata'))
            ->whereMonth('date', $current)
            ->groupBy('product_items.id')
            ->whereNull('product_items.deleted_at')
            ->whereNull('history.deleted_at')
            ->get();
        // dd($hitung->where('name', 'Busi Audi'), $current);


        //	echo "<script>console.log('Debug Objects: " . $jum_hari . "' );</script>";

        $data_part = DB::table('product_items')
            ->join("history", function ($join) {
                $join->on("product_items.id", "=", "history.item_id");
            })
            ->whereMonth('history.date', $current)
            ->select("product_items.id as id_part", "product_items.name as nm_motor", "product_items.stock as stok", "product_items.lead_time as time")
            ->groupBy('product_items.id')
            ->whereNull('product_items.deleted_at')
            ->whereNull('history.deleted_at')
            ->get();
        // dd($data_part, $hitung, $jum_hari);
        // dd($data_part->where('nm_motor', 'Wiper Volkswagen'));

        return view('pages.Minmax.realtime', compact(
            'active',
            'active_detail',
            'data_part',
            'jum_hari',
            'hitung'
        ));
    }
}
