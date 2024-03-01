<?php

namespace App\Http\Controllers\Service;

use App\Http\Controllers\Controller;
use App\Models\ProductItems;
use App\Models\Stock;
use App\Models\Supplier;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

use function Psy\Test\Command\ListCommand\Fixtures\bar;

class SalesInController extends Controller
{
    public function index()
    {
        $active = 'transaction';
        $active_detail = 'sales-in';
        $items = ProductItems::all();
        $suppliers = Supplier::all();
        $today = Carbon::today()->toDateString();
        return view('pages.Transaction.sales-in
        ', compact(
            'active',
            'active_detail',
            'items',
            'suppliers',
            'today',
        ));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'date' => 'required|date',
            'item_id' => 'required|exists:product_items,id',
            'supplier_id' => 'required|exists:suppliers,id',
            'quantity' => 'required'
        ]);

        if ($validator->fails()) {
            Alert::toast($validator->messages()->all(), 'error');
            return back()->withInput();
        }

        unset($request['_token']);

        $data = new Stock();
        $data->fill($request->all());
        $data->type = 'in';
        $data->save();

        Alert::toast('Sukses Menyimpan', 'success');
        return back();
    }
}
