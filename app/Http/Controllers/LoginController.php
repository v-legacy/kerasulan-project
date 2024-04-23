<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('login.index');
    }

    public function login(Request $request)
    {

        $data = $this->validate($request, [
            'username' => 'required',
            'password' => 'required'
        ]);
        $user  = User::where('username', $request->username)->first();
        try {

            if (auth()->attempt($request->only('username', 'password'))) {
                return redirect()->route('dashboard.index')->with('success', 'Login Berhasil');
            } else {
                return back()->with('failed', 'Login Gagal');
            }
        } catch (\Exception $th) {

            return back()->with('failed', $th->getMessage());
        }
    }
}
