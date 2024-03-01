<?php

namespace App\Traits;

use App\Models\ProductItems;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

trait MyTrait
{
    public function minmax($item_id = null, $jumlah = null)
    {
        // dd($item_id, $jumlah);
        try {
            $today = date("Y-m-d");
            $current = Carbon::now()->format('m');

            $jum_hari = DB::table('history')
                ->select(DB::raw('DAY(LAST_DAY(date)) as jum_hari'))
                ->whereMonth('date', $current)
                ->whereNull('deleted_at')
                ->get();

            foreach ($jum_hari as $data) {
                $jum_hari = $data->jum_hari;
            }


            $hitung = DB::table('history')
                //->select(DB::raw('MAX(total) as besar, ceil(SUM(total)/30) as rata'))
                ->select(DB::raw('MAX(total) as terbesar, SUM(total) as rata'))
                ->whereMonth('date', $current)
                ->where('item_id', $item_id)
                ->whereNull('deleted_at')
                ->get();

            foreach ($hitung as $data) {
                $rata = (int) $data->rata;
                $terbesar = $data->terbesar;
            }

            // $data_stok = DB::table('sparepart')
            //     ->select("*")
            //     ->where('item_id', $item_id)
            //     ->get();

            $data_stok = ProductItems::where('id', $item_id)
                ->get();

            foreach ($data_stok as $data) {
                $dt_stok =  $data->stock;
                $time =  $data->time;
            }

            // dd($jum_hari);
            // dd(ceil($rata / $jum_hari));

            $rata2 = ceil($rata /  $jum_hari);


            $cek = ceil($dt_stok - $jumlah);
            // dd($data_stok, $dt_stok, $jumlah);

            //ss=(maksimum permintaan - rata2 permintaan K ) x lead time W
            $ss = ($terbesar - $rata2) * $time;

            //min = (K x W) + SS
            $min = ceil(($rata2 * $time) + $ss);

            //max = (2x(K x W)) + SS
            $max = ceil((2 * ($rata2 * $time)) + $ss);

            // = max - min
            $Q = ceil($max - $min);


            //echo "<script>console.log('Debug Objects: " . $max . "' );</script>";

            $tgl = DB::table('history')
                ->select(DB::raw('COUNT(date) as tgl'))
                ->where('date', $today)
                ->whereNull('deleted_at')
                ->get();

            foreach ($tgl as $data) {
                $tgl = $data->tgl;
            }

            $part = DB::table('history')
                ->select(DB::raw('COUNT(item_id) as part'))
                ->where('item_id', $item_id)
                ->where('date', $today)
                ->whereNull('deleted_at')
                ->get();

            foreach ($part as $data) {
                $part = $data->part;
            }

            if ($tgl == 0) {
                if ($cek < 0) {
                    return back()->withErrors('Stock Tidak Mencukupi ' . $Q . '');
                } else if ($cek > $min) {

                    DB::table('history')
                        ->whereNull('deleted_at')
                        ->insert([
                            'date' => $today,
                            'item_id' => $item_id,
                            'total' => $jumlah
                        ]);
                } else if ($cek < $ss) {
                    if ($dt_stok <= $ss) {
                        return back()->withErrors('Sudah Mencapai Safety Stock Tidak Dapat Dilayani');
                    } else {

                        $sisa = $dt_stok - $ss;
                        // DB::table('transaksi')->insert([
                        //     'id_tran' => $value->id_tran,
                        //     'tgl_tran' => $today,
                        //     'id' => $value->id,
                        //     'item_id' => $item_id,
                        //     'jumlah' => $sisa
                        // ]);
                        DB::table('history')
                            ->whereNull('deleted_at')
                            ->insert([
                                'date' => $today,
                                'item_id' => $item_id,
                                'total' => $sisa
                            ]);

                        // DB::table('sparepart')
                        //     ->where('item_id', $item_id)
                        //     ->update(
                        //         [
                        //             'stok' => $ss
                        //         ]
                        //     );
                        return back()->withSuccess('Sudah Mencapai Safety Stock, Hanya Dapat Dilayani ' . $sisa . ' Item');
                    }
                } else {
                    // DB::table('transaksi')->insert([
                    //     'id_tran' => $value->id_tran,
                    //     'tgl_tran' => $today,
                    //     'id' => $value->id,
                    //     'item_id' => $item_id,
                    //     'jumlah' => $jumlah
                    // ]);
                    DB::table('history')
                        ->whereNull('deleted_at')
                        ->insert([
                            'date' => $today,
                            'item_id' => $item_id,
                            'total' => $jumlah
                        ]);

                    // DB::table('sparepart')
                    //     ->where('item_id', $item_id)
                    //     ->update(
                    //         [
                    //             'stok' => $cek
                    //         ]
                    //     );
                    return back()->with('toast_success', 'Minimal Stock, Waktunya Restock Spare Part');
                }
            } else {
                // dd(
                //     $tgl,
                //     $part,
                //     $cek
                // );

                ///CEK HISTORY PART ADA TIDAK
                if ($part == 1) {
                    if ($cek < 0) {
                        return back()->withSuccess('Stock Tidak Mencukupi');
                    } else if ($cek > $min) {
                        // DB::table('transaksi')->insert([
                        //     'id_tran' => $value->id_tran,
                        //     'tgl_tran' => $today,
                        //     'id' => $value->id,
                        //     'item_id' => $item_id,
                        //     'jumlah' => $jumlah
                        // ]);
                        $up = DB::table('history')
                            ->select("*")
                            ->where('date', $today)
                            ->where('item_id', $item_id)
                            ->get();
                        foreach ($up as $data) {
                            $total = $data->total;
                        }
                        $hasil = $total + $jumlah;

                        DB::table('history')
                            ->where('date', $today)
                            ->where('item_id', $item_id)
                            ->update(
                                [
                                    'total' => $hasil
                                ]
                            );

                        // DB::table('sparepart')
                        //     ->where('item_id', $item_id)
                        //     ->update(
                        //         [
                        //             'stok' => $cek
                        //         ]
                        //     );
                        return back()->with('toast_success', 'Data Berhasil Disimpan');
                    } else if ($cek < $ss) {
                        if ($dt_stok <= $ss) {
                            return back()->withErrors('Sudah Mencapai Safety Stock Tidak Dapat Dilayani');
                        } else {
                            $sisa1 = $dt_stok - $ss;
                            // DB::table('transaksi')->insert([
                            //     'id_tran' => $value->id_tran,
                            //     'tgl_tran' => $today,
                            //     'id' => $value->id,
                            //     'item_id' => $item_id,
                            //     'jumlah' => $sisa1
                            // ]);
                            $up12 = DB::table('history')
                                ->select("*")
                                ->where('date', $today)
                                ->where('item_id', $item_id)
                                ->get();
                            foreach ($up12 as $data) {
                                $total12 = $data->total;
                            }
                            $hasil12 = $total12 + $sisa1;

                            DB::table('history')
                                ->where('date', $today)
                                ->where('item_id', $item_id)
                                ->update(
                                    [
                                        'total' => $hasil12
                                    ]
                                );

                            // DB::table('sparepart')
                            //     ->where('item_id', $item_id)
                            //     ->update(
                            //         [
                            //             'stok' => $ss
                            //         ]
                            //     );
                            return back()->withSuccess('Sudah Mencapai Safety Stock, Hanya Dapat Dilayani ' . $sisa1 . ' Item');
                        }
                    } else {
                        // DB::table('transaksi')->insert([
                        //     'id_tran' => $value->id_tran,
                        //     'tgl_tran' => $today,
                        //     'id' => $value->id,
                        //     'item_id' => $item_id,
                        //     'jumlah' => $jumlah
                        // ]);
                        $up1 = DB::table('history')
                            ->select("*")
                            ->where('date', $today)
                            ->where('item_id', $item_id)
                            ->get();
                        foreach ($up1 as $data) {
                            $total1 = $data->total;
                        }
                        $hasil1 = $total1 + $jumlah;

                        DB::table('history')
                            ->where('date', $today)
                            ->where('item_id', $item_id)
                            ->update(
                                [
                                    'total' => $hasil1
                                ]
                            );

                        // DB::table('sparepart')
                        //     ->where('item_id', $item_id)
                        //     ->update(
                        //         [
                        //             'stok' => $cek
                        //         ]
                        //     );
                        return back()->with('toast_success', 'Minimal Stock, Waktunya Restock Spare Part');
                    }


                    ///TIDAK ADA PART YA INPUT
                } else {
                    if ($cek < 0) {
                        return back()->withSuccess('Stock Tidak Mencukupi');
                    } else if ($cek > $min) {
                        // DB::table('transaksi')->insert([
                        //     'id_tran' => $value->id_tran,
                        //     'tgl_tran' => $today,
                        //     'id' => $value->id,
                        //     'item_id' => $item_id,
                        //     'jumlah' => $jumlah
                        // ]);
                        DB::table('history')->insert([
                            'date' => $today,
                            'item_id' => $item_id,
                            'total' => $jumlah
                        ]);

                        // DB::table('sparepart')
                        //     ->where('item_id', $item_id)
                        //     ->update(
                        //         [
                        //             'stok' => $cek
                        //         ]
                        //     );
                        return back()->with('toast_success', 'Data Berhasil Disimpan');
                    } else if ($cek <= $ss) {
                        return back()->withWarning('Sudah Mencapai Safety Stock');
                    } else {
                        // DB::table('transaksi')->insert([
                        //     'id_tran' => $value->id_tran,
                        //     'tgl_tran' => $today,
                        //     'id' => $value->id,
                        //     'item_id' => $item_id,
                        //     'jumlah' => $jumlah
                        // ]);
                        DB::table('history')
                            ->whereNull('deleted_at')
                            ->insert([
                                'date' => $today,
                                'item_id' => $item_id,
                                'total' => $jumlah
                            ]);

                        // DB::table('sparepart')
                        //     ->where('item_id', $item_id)
                        //     ->update(
                        //         [
                        //             'stok' => $cek
                        //         ]
                        //     );
                        return back()->with('toast_success', 'Sudah Mencapai Minimal Stock');
                    }
                }
            }
        } catch (Exception $error) {
            dd($error->getMessage(), $error);
        }
    }
}
