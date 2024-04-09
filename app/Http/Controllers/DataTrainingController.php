<?php

namespace App\Http\Controllers;

use App\Models\DataTraining;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

use function Laravel\Prompts\error;

class DataTrainingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title  = 'Data Training';
        $data   = DataTraining::all();
        return view('data-training.index', compact('title', 'data'));
    }

    private function import(Request $request)
    {
        $file = $request->file('file');

        try {
            if (isset($file)) {
                DB::table('data_training')->truncate();

                Excel::import(new \App\Imports\DataTrainingImport, $file);

                return back()->with('success', 'Data Berhasil dimport');
            }
        } catch (\Exception $e) {
            return back()->with('failed', $e->getMessage());
        }
    }

    public function process()
    {


        try {
            $data = DB::table('data_training')
                ->select('pecah_suara', 'audio_video',  'y_target')
                ->limit(3)
                ->get()
                ->toArray();
            $result = $this->recursive($data);
            dd($result);
        } catch (\Throwable $th) {
            return back()->with('failed', $th->getMessage());
        }
    }

    public function recursive($data)
    {
        $w1_awal  = 0;
        $w2_awal  = 0;
        $rate     = 1;
        $treshold = 0;

        (float) $w1_baru = null;

        (float) $w2_baru = null;
        $delta_w1 = null;
        $delta_w2 = null;
        $temp = [];
        $new_w = [];
        $score = [];
        foreach ($data as $key => $value) {
            if ($w1_baru != null && $w2_baru != null) {
                $v[$key] = $value->pecah_suara * $w1_baru + $value->audio_video * $w2_baru;
            } else {

                $v[$key]     = $value->pecah_suara * $w1_awal + $value->audio_video * $w2_awal;
            }

            $score[$key] = [$value->pecah_suara, $value->audio_video];
            if ($v[$key] < $treshold) {
                $error = $value->y_target - 0;
                if ($w1_baru == null && $w2_baru == null) {
                    $w1_baru = $w1_awal + $rate * $error * $value->pecah_suara;
                    $w2_baru = $w2_awal + $rate * $error * $value->audio_video;
                } else {
                    $w1_baru = $w1_baru + $rate * $error * $value->pecah_suara;
                    $w2_baru = $w2_baru + $rate * $error * $value->audio_video;
                }
                $new_w[$key] = [
                    'w1_baru' => $w1_baru,
                    'w2_baru' => $w2_baru,
                ];

                $temp[$key] = [
                    'pecah_suara' => $value->pecah_suara,
                    'audio_video' => $value->audio_video,
                    'v' => $v[$key],
                    'y' => 0,
                    'y_target' => $value->y_target,
                    'error' => $error,
                    'w1_baru' => $w1_baru,
                    'w2_baru' => $w2_baru,
                    'delta_w1' => $w1_baru - $w1_awal,
                    'delta_w2' => $w2_baru - $w2_awal,
                ];
            } else if ($v[$key] >= $treshold) {
                $error = $value->y_target - 1;
                if ($w1_baru == null && $w2_baru == null) {
                    $w1_baru = $w1_awal + $rate * $error * $value->pecah_suara;
                    $w2_baru = $w2_awal + $rate * $error * $value->audio_video;
                } else {
                    $w1_baru = $w1_baru + $rate * $error * $value->pecah_suara;
                    $w2_baru = $w2_baru + $rate * $error * $value->audio_video;
                }

                $new_w[$key] = [
                    'w1_baru' => round($w1_baru, 1, PHP_ROUND_HALF_UP),
                    'w2_baru' => round($w2_baru, 1, PHP_ROUND_HALF_UP),
                ];
                $temp[$key] = [
                    'pecah_suara' => $value->pecah_suara,
                    'audio_video' => $value->audio_video,
                    'v' => $v[$key],
                    'y' => 1,
                    'y_target' => $value->y_target,
                    'error' => $error,
                    'w1_baru' => $w1_baru,
                    'w2_baru' => $w2_baru,
                    'delta_w1' => $w1_baru - $w1_awal,
                    'delta_w2' => $w2_baru - $w2_awal,
                ];
            }
        }
        dd($new_w, $temp, $data, $score);
        // return [$temp, $new_w];
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
