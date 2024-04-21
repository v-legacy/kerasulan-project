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
        $role = ['Admin', 'User'];
        return view('user.create', compact('title', 'role'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'nama'      => $request->nama,
            'username'  => $request->username,
            'password'  => bcrypt($request->password),
            'role'      => $request->role
        ]);
        try {
            $user = new User();
            $user->name = $request->name;
            $user->username = $request->username;
            $user->password = bcrypt($request->password);
            $user->role = $request->role;
            $user->save();
            return redirect()->route('user.index')->with('success', 'Data Berhasil ditambahkan');
        } catch (\Exception $e) {
            return back()->with('failed', $e->getMessage());
        }
    }

    public function edit(User $user)
    {
        $title  = 'Users Edit Form';
        $role = ['Admin', 'User'];
        $data = User::where('id', $user->id)->first();

        return view('user.edit', compact('title', 'data', 'role'));
    }

    public function update(Request $request, User $user)
    {
        $this->validate($request, [
            'name'      => $request->name,
            'username'  => $request->username,
            'role'      => $request->role

        ]);
        try {

            $user->name = $request->name;
            $user->username = $request->username;
            $user->role = $request->role;
            $user->save();

            return redirect()->route('user.index')->with('success', 'Data Berhasil diubah');
        } catch (\Exception $e) {

            return back()->with('failed', $e->getMessage());
        }
    }

    public function destroy(User $user)
    {
        $user->delete();
        return back()->with('success', 'Data Berhasil dihapus');
    }
}
