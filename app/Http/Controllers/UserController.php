<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $title  = 'Users Page';
        $data   = User::all();
        return view('user.index', compact('title', 'data'));
    }

    public function create()
    {
        $title  = 'Users Form';

        return view('user.create', compact('title'));
    }

    public function store(Request $req)
    {
    }

    public function edit(User $user)
    {

        $title  = 'Users Edit Form';
    }

    public function update(Request $request, User $user)
    {
        return redirect()->route('user.index')->with('success', 'Data Berhasil diubah');
    }

    public function destroy(User $user)
    {
        return back()->with('success', 'Data Berhasil dihapus');
    }
}
