<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Minmax;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class SupplierController extends Controller
{
    public function index()
    {
        $active = 'supplier';
        $active_detail = '';
        $data = Supplier::all();
        return view('pages.supplier', compact('active', 'active_detail', 'data'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'phone' => 'required|numeric',
            'address' => 'required',
            'norek' => 'required',
        ]);

        if ($validator->fails()) {
            Alert::toast($validator->messages()->all(), 'error');
            return back()->withInput();
        }

        unset($request['_token']);

        $data = new Supplier();
        $data->fill($request->all());
        $data->save();


        Alert::Toast('Sukses Menyimpan', 'success');
        return back();
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:suppliers,id',
            'name' => 'required',
            'phone' => 'required|numeric',
            'address' => 'required',
            'norek' => 'required',
        ]);

        if ($validator->fails()) {
            Alert::toast($validator->messages()->all(), 'error');
            return back()->withInput();
        }

        unset($request['_token']);

        $data = Supplier::findOrFail($request->id);
        $data->fill($request->all());
        $data->save();

        Alert::Toast('Sukses Merubah', 'success');
        return back();
    }

    public function delete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:suppliers,id'
        ]);

        if ($validator->fails()) {
            Alert::toast($validator->messages()->all(), 'error');
            return back()->withInput();
        }

        Supplier::where('id', $request->id)->delete();
        Alert::Toast('Sukses Menghapus', 'success');
        return back();
    }
}
