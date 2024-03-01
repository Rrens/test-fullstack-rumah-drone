<?php

namespace App\Http\Controllers\Restcok;

use App\Http\Controllers\Controller;
use App\Models\Minmax;
use App\Models\Pembelian;
use App\Models\PembelianDetail;
use App\Models\Penerimaan;
use App\Models\PenerimaanDetail;
use App\Models\ProductItems;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class PenerimaanController extends Controller
{
    public function index()
    {
        $active = 'restock';
        $active_detail = 'penerimaan';
        $data = DB::table('penerimaans as pn')
            ->join('pembelians as pb', 'pb.id', '=', 'pn.pembelian_id')
            ->join('pembelian_details as pd', 'pb.id', '=', 'pd.pembelian_id')
            ->join('suppliers as s', 's.id', '=', 'pb.supplier_id')
            ->join('product_items as pi', 'pi.id', '=', 'pd.item_id')
            ->select(
                'pb.id as id_pembelian',
                'pn.id as id_penerimaan',
                's.name as supplier_name',
                'pi.name as item_name',
                'pn.tanggal_penerimaan',
                'pb.tanggal_pembelian',
                'pn.jumlah_penerimaan',
                'pd.jumlah_pembelian',
                'pn.pembelian_id'
            )
            ->where('pd.pembelian_id', '!=', null)
            ->whereNull('pd.deleted_at')
            ->whereNull('pb.deleted_at')
            ->whereNull('pn.deleted_at')
            ->groupBy('pn.pembelian_id')
            ->orderBy('pb.tanggal_pembelian', 'desc')
            ->get();
        // dd($data);

        $pembelian = Pembelian::all();
        $pembelian_detail = PembelianDetail::with('item')->get();
        $penerimaan_detail = PenerimaanDetail::with('penerimaan')->get();
        // dd($penerimaan_detail);
        return view('pages.restock.penerimaan', compact('active', 'active_detail', 'data', 'pembelian_detail', 'pembelian', 'penerimaan_detail'));
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_pembelian' => 'required|exists:pembelians,id',
            'id' => 'required|exists:penerimaans,id',
            'jumlah_pembelian.*' => 'required|numeric',
            'jumlah_penerimaan.*' => 'required|numeric|lte:jumlah_pembelian.*',
            'pembelian_detail_id.*' => 'required|numeric',
            'tanggal_pembelian' => 'required|date',
            'tanggal_penerimaan' => 'required|date'
        ]);

        if ($validator->fails()) {
            // dd($validator->messages()->all());
            Alert::toast($validator->messages()->all(), 'error');
            return back()->withInput();
        }
        // dd($request->all());


        if ($request->tanggal_pembelian > $request->tanggal_penerimaan) {
            Alert::toast('the tanggal penerimaan must not exceed the tanggal pembelian', 'error');
            return back()->withInput();
        }

        unset($request['_token']);
        // dd($request->all());

        $data = Penerimaan::findOrFail($request->id);
        $data->fill($request->all());
        $data->save();

        $count = count($request->jumlah_penerimaan);

        $tanggalPembelian = Carbon::createFromFormat('Y-m-d', $request->tanggal_pembelian);
        $tanggalPenerimaan = Carbon::createFromFormat('Y-m-d', $request->tanggal_penerimaan);
        $selisihHari = $tanggalPembelian->diffInDays($tanggalPenerimaan);

        for ($i = 0; $i < $count; $i++) {

            if ($request->jumlah_penerimaan[$i] <= 0) {
                Alert::toast('Stok yang diterima tidak boleh kurang dari 1', 'error');
                return back()->withInput();
            }

            $item = ProductItems::where('name', $request->nama_sparepart[$i])->first();
            $item->stock += $request->jumlah_penerimaan[$i];
            $item->lead_time = $selisihHari;
            $item->save();

            $detail = PenerimaanDetail::where('item_id', $item->id)
                ->where('date', $data->tanggal_penerimaan)
                ->first();
            // // dd($detail);

            if (empty($detail)) {
                $detail = new PenerimaanDetail();
                $detail->penerimaan_id = $data->id;
                $detail->date = $data->tanggal_penerimaan;
                $detail->pembelian_detail_id = $request->pembelian_detail_id[$i];
            }
            $detail->item_id = $item->id;
            $detail->jumlah_penerimaan = $request->jumlah_penerimaan[$i];
            $detail->save();
        }

        // dd($request->all(), $item);
        // $minmax = Minmax::where('item_id', $item->id)->first();

        // if (empty($minmax)) {
        //     $minmax = new Minmax();
        // }


        // $minmax->item_id = $item->id;
        // $minmax->lead_time = $selisihHari;
        // $minmax->save();

        Alert::toast('Sukses Merubah', 'success');
        return back();
    }

    public function delete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_penerimaan' => 'required|exists:penerimaans,id',
            'id_pembelian' => 'required|exists:pembelians,id'
        ]);

        if ($validator->fails()) {
            Alert::toast($validator->messages()->all(), 'error');
            return back();
        }


        $penerimaan = Penerimaan::where('id', $request->id_penerimaan)->first();
        $item = ProductItems::findOrFail(Pembelian::where('id', $request->id_pembelian)->first()['item_id']);
        // dd($item, $penerimaan->jumlah_penerimaan);
        $item->stock -= $penerimaan->jumlah_penerimaan;
        $item->save();

        // $minmax = Minmax::where('item_id', $item->id)->delete();

        Pembelian::where('id', $request->id_pembelian)->delete();
        $penerimaan->delete();


        Alert::toast('Sukses Menghapus', 'success');
        return back();
    }
}
