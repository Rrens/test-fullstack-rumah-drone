<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class CategoriesController extends Controller
{
    public function index()
    {
        $active = 'product';
        $active_detail = 'categories';
        $data = ProductCategory::all();
        return view('pages.Product.Categories', compact('active', 'active_detail', 'data'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required'
        ]);

        if ($validator->fails()) {
            Alert::toast($validator->messages()->all(), 'error');
            return back();
        }

        unset($request['_token']);

        $data = new ProductCategory();
        $data->fill($request->all());
        $data->save();

        Alert::toast('Sukses Menyimpan', 'success');
        return back()->withInput();
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:product_categories,id',
            'name' => 'required'
        ]);

        if ($validator->fails()) {
            Alert::toast($validator->messages()->all(), 'error');
            return back();
        }

        unset($request['_token']);

        $data = ProductCategory::findOrFail($request->id);
        $data->fill($request->all());
        $data->save();

        Alert::toast('Sukses Merubah', 'success');
        return back()->withInput();
    }

    public function delete(Request $request)
    { {
            $validator = Validator::make($request->all(), [
                'id' => 'required|exists:product_categories,id',
            ]);

            if ($validator->fails()) {
                Alert::toast($validator->messages()->all(), 'error');
                return back();
            }

            ProductCategory::where('id', $request->id)->delete();

            Alert::toast('Sukses Menghapus', 'success');
            return back();
        }
    }
}
