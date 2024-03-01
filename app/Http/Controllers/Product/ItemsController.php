<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Models\ProductCategory;
use App\Models\ProductItems;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class ItemsController extends Controller
{

    public function generate_id()
    {
        $lastId = ProductItems::count();
        $nextId = 'A' . str_pad($lastId + 1, 3, '0', STR_PAD_LEFT);

        return $nextId;
    }

    public function index()
    {
        $active = 'product';
        $active_detail = 'items';
        $data = ProductItems::with('category')
            ->orderBy('id', 'DESC')
            ->whereHas(
                'category',
                function ($query) {
                    $query->whereNull('deleted_at');
                }
            )->get();
        $category = ProductCategory::all();
        $barcode = $this->generate_id();
        return view('pages.Product.Items', compact('active', 'active_detail', 'data', 'category', 'barcode'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'barcode' => 'required|unique:product_items,barcode',
            'name' => 'required',
            'category_id' => 'required|exists:product_categories,id',
            'price' => 'required',
            'stock' => 'required',
        ]);

        if ($validator->fails()) {
            Alert::toast($validator->messages()->all(), 'error');
            return back()->withInput();
        }

        unset($request['_token']);

        $data = new ProductItems();
        $data->fill($request->all());
        $data->save();

        Alert::toast('Sukses Menambah', 'success');
        return back();
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:product_items,id',
            'barcode' => 'required',
            'name' => 'required',
            'category_id' => 'required|exists:product_categories,id',
            'price' => 'required',
            'stock' => 'required',
        ]);

        if ($validator->fails()) {
            Alert::toast($validator->messages()->all(), 'error');
            return back()->withInput();
        }

        unset($request['_token']);
        $check_barcode = ProductItems::where('barcode', $request->barcode)
            ->first();

        // dd($this->generate_id());
        if (empty($check_barcode)) {

            $data = ProductItems::findOrFail($request->id);
            $data->fill($request->all());
            $data->save();
            Alert::toast('Sukses Merubah', 'success');
            return back();
        } else {
            unset($request['barcode']);
            $check_barcode->fill($request->all());
            $check_barcode->save();
            Alert::toast('Gagal Merubah', 'error');
            return back();
        }
    }

    public function delete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:product_items,id'
        ]);

        if ($validator->fails()) {
            Alert::toast($validator->messages()->all(), 'error');
            return back()->withInput();
        }

        ProductItems::where('id', $request->id)->delete();

        Alert::toast('Sukses Menghapus', 'success');
        return back();
    }
}
