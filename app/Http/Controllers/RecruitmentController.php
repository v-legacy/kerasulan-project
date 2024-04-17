<?php

namespace App\Http\Controllers;

use App\Models\Recruitment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

use Maatwebsite\Excel\Facades\Excel;

class RecruitmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title  = 'Recruitment Page';
        $data   = Recruitment::all();

        return view('recruitment.index', compact('title', 'data'));
    }

    public function import(Request $request)
    {
        $file = $request->file('file');
        // dd($file);
        try {
            if (isset($file)) {
                DB::table('recruitment')->truncate();

                Excel::import(new \App\Imports\RecruitmentImport, $file);
                return back()->with('success', 'Data Berhasil dimport');
            }
        } catch (\Exception $e) {
            return back()->with('failed', $e->getMessage());
        }
    }

    public function process()

    {
        $title = 'Recruitment Process';
        try {
            $data =  DB::table('recruitment')->get();
            $results = getResult($data);
            return view('recruitment.process', compact('title', 'results'));
        } catch (\Exception $e) {
            return back()->with('failed', $e->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Recruitment Form';

        return view('recruitment.create', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $this->validate($request, [
            'nik' => 'required',
            'nama_lengkap' => 'required',
            'email' => 'required',
            'pekerjaan' => 'required',
            'umur' => 'required',
            'pendidikan_terakhir' => 'required',
            'no_telp' => 'required',
            'alamat' => 'required',
        ]);
        dd($request->all());
        DB::beginTransaction();
        try {
            $recruitment                        = new Recruitment();
            $recruitment->nik                   = $request->nik;
            $recruitment->nama_lengkap          = $request->nama_lurator;
            $recruitment->email                 = $request->email;
            $recruitment->pekerjaan             = $request->pekerjaan;
            $recruitment->umur                  = $request->umur;
            $recruitment->pendidikan_terakhir   = $request->pendidikan_terakhir;
            $recruitment->no_telp               = $request->no_telp;
            $recruitment->alamat                = $request->alamat;


            $user = new User();
            $user->name                         = $request->name;
            $user->email                        = $request->email;
            $user->password                     = bcrypt($request->email);

            $user->save();

            $recruitment->id_user               = $user->id;

            $recruitment->save();
            DB::commit();
            return redirect()->route('recruitment.index')->with('success', 'Data Berhasil');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('failed', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Recruitment $recruitment)
    {
        $recruitment = Recruitment::where('id', $recruitment->id)->first();

        return view('recruitment.show', compact('recruitment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Recruitment $recruitment)
    {
        $title = 'Recruitment Form Edit';
        $data = Recruitment::where('id', $recruitment->id)->first();

        return view('recruitment.edit', compact('title', 'data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Recruitment $recruitment)
    {
        $this->validate($request, [
            'nik' => 'required',
            'nama_lengkap' => 'required',
            'email' => 'required',
            'pekerjaan' => 'required',
            'umur' => 'required',
            'pendidikan_terakhir' => 'required',
            'no_telp' => 'required',
            'alamat' => 'required',
        ]);

        DB::beginTransaction();
        try {
            $recruitment                = Recruitment::where('id', $recruitment->id)->first();
            $recruitment->nik                   = $request->nik;
            $recruitment->nama_lengkap          = $request->nama_lurator;
            $recruitment->email                 = $request->email;
            $recruitment->pekerjaan             = $request->pekerjaan;
            $recruitment->umur                  = $request->umur;
            $recruitment->pendidikan_terakhir   = $request->pendidikan_terakhir;
            $recruitment->no_telp               = $request->no_telp;
            $recruitment->alamat                = $request->alamat;

            $user = new User();
            $user->name                         = $request->name;
            $user->email                        = $request->email;
            $user->password                     = bcrypt($request->email);

            $user->save();

            $recruitment->id_user               = $user->id;

            $recruitment->save();
            DB::commit();
            return redirect()->route('recruitment.index')->with('success', 'Data Berhasil diupdate');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('failed', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Recruitment $recruitment)
    {
        DB::beginTransaction();
        try {
            $recruitment = Recruitment::where('id', $recruitment->id)->first();
            $recruitment->delete();
            DB::commit();
            return redirect()->route('recruitment.index')->with('success', 'Data Berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('failed', $e->getMessage());
        }
    }
}
