<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class AuthController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            return view('auth.pages.login');
        }

        return back();
    }

    public function post_login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            // 'email' => 'required|email:rfc,dns',
            'username' => 'required|exists:users,username',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            Alert::error($validator->messages()->all());
            return redirect()->route('auth.login');
        }


        $data = [
            'username' => $request->username,
            'password' => $request->password
        ];

        if (!User::where('username', $data['username'])->first()) {
            Alert::toast('Tidak ada Akses', 'error');
            return back();
        }
        // dd($request->all());

        if (!Auth::attempt($data)) {
            Session::flash('error', 'username or Password is wrong');
            Alert::toast('Email or Password is wrong', 'error');
            return redirect()->route('auth.login')->withInput();
        }

        return redirect()->route('product.items.index');
    }

    public function register()
    {
        $active = 'product';
        $active_detail = 'categories';

        $data = User::all();

        return view('auth.pages.register', compact('active', 'active_detail', 'data'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'username' => 'required',
            'email' => 'email|unique:users,email',
            'address' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            Alert::toast($validator->messages()->all(), 'error');
            return back()->withInput();
        }

        $data = new User();
        $data->fill($request->all());
        $data->password = Hash::make($request->password);
        $data->save();

        Alert::toast('Sukses bolo', 'success');
        return back();
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:users,id',
            'name' => 'required',
            'username' => 'required',
            'email' => 'email|unique:users,email',
            'address' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            Alert::toast($validator->messages()->all(), 'error');
            return back()->withInput();
        }

        $data = User::findOrFail($request->id);
        $data->fill($request->all());
        $data->password = Hash::make($request->password);
        $data->save();

        Alert::toast('Sukses bolo', 'success');
        return back();
    }

    public function delete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:users,id',
        ]);

        if ($validator->fails()) {
            Alert::toast($validator->messages()->all(), 'error');
            return back()->withInput();
        }

        User::where('id', $request->id)->delete();

        Alert::toast('Sukses bolo', 'success');
        return back();
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('auth.login');
    }
}
