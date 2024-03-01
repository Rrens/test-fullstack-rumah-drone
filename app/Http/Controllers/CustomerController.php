<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class CustomerController extends Controller
{
    public function index()
    {
        $active = 'customer';
        $active_detail = '';
        $data = Customer::all();
        return view('pages.customer', compact('active', 'active_detail', 'data'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'gender' => 'required|in:0,1',
            'phone' => 'required|numeric',
            'address' => 'required',
        ]);

        if ($validator->fails()) {
            Alert::toast($validator->messages()->all(), 'error');
            return back()->withInput();
        }

        unset($request['_token']);

        $data = new Customer();
        $data->fill($request->all());
        $data->save();

        Alert::toast('SuKses Menyimpan', 'success');
        return back();
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:customers,id',
            'name' => 'required',
            'gender' => 'required|in:0,1',
            'phone' => 'required|numeric',
            'address' => 'required',
        ]);


        if ($validator->fails()) {
            Alert::toast($validator->messages()->all(), 'error');
            return back()->withInput();
        }

        unset($request['_token']);

        $data = Customer::findOrFail($request->id);
        $data->fill($request->all());
        $data->save();

        Alert::toast('SuKses Merubah', 'success');
        return back();
    }

    public function delete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:customers,id',
        ]);

        if ($validator->fails()) {
            Alert::toast($validator->messages()->all(), 'error');
            return back();
        }

        Customer::where('id', $request->id)->delete();

        Alert::toast('SuKses Menghapus', 'success');
        return back();
    }
}
