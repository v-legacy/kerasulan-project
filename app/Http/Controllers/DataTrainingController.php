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
        $w1_baru = null;
        $w2_baru = null;
        $delta_w1 = null;
        $delta_w2 = null;
        $delta_w2_current = [];
        $temp = [];
        $new_w = [];
        $iteration = 1;
        $start = 0;
        while ($start < $iteration) {
            foreach ($data as $key => $value) {
                if ($w1_baru != null && $w2_baru != null) {
                    $v[$key] = $value->pecah_suara * $w1_baru + $value->audio_video * $w2_baru;
                } else {
                    $v[$key]    = $value->pecah_suara * $w1_awal + $value->audio_video * $w2_awal;
                }
                if ($v[$key] < $treshold) {
                    $error = $value->y_target - 0;
                    if ($w1_baru == null && $w2_baru == null) {
                        $w1_baru = $w1_awal + $rate * $error * $value->pecah_suara;
                        $w2_baru = $w2_awal + $rate * $error * $value->audio_video;
                    } else {
                        $w1_baru = $w1_baru + $rate * $error * $value->pecah_suara;
                        $w2_baru = $w2_baru + $rate * $error * $value->audio_video;
                    }

                    $new_w1[$start][$key] = [
                        'w1_baru' => $w1_baru,

                    ];
                    $new_w2[$start][$key] = [
                        'w2_baru' => $w2_baru,
                    ];
                    if ($delta_w1 !== null) {
                        if (count($new_w1[$start]) > 1) {
                            $delta_w1 =  $w1_baru - $new_w1[$start][$key - 1]['w1_baru'];
                        } elseif (count($new_w1) > 1 && $new_w1[$start][0]) {
                            $count = count($new_w1[$start - 1]);
                            // dd('sini a', $new_w1[$start - 1][$count - 1],);
                            $delta_w1 =  $w1_baru - $new_w1[$start - 1][$count - 1]['w1_baru'];
                        }
                    } elseif ($delta_w1 === null) {
                        $delta_w1 = $w1_baru - $w1_awal;
                        $delta_w2 = $w2_baru - $w2_awal;
                    }
                    $delta_w2_current[$start][$key] = [
                        'delta_w2' => $delta_w2,
                    ];
                    $temp[$start][$key] = [
                        'pecah_suara' => $value->pecah_suara,
                        'audio_video' => $value->audio_video,
                        'v' => $v[$key],
                        'y' => 0,
                        'y_target' => $value->y_target,
                        'error' => $error,
                        'w1_baru' => $w1_baru,
                        'w2_baru' => $w2_baru,
                        'delta_w1' => $delta_w1,
                        'delta_w2' => $delta_w2,
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

                    $new_w1[$start][$key] = [
                        'w1_baru' => $w1_baru,
                    ];
                    $new_w2[$start][$key] = [
                        'w2_baru' => $w2_baru,
                    ];
                    if ($delta_w1 !== null) {

                        if (count($new_w1[$start]) > 1) {
                            $delta_w1 =  $w1_baru - $new_w1[$start][$key - 1]['w1_baru'];
                        } elseif (count($temp) > 1 && $new_w1[$start][0]) {
                            // dd('sini b');
                            $count = count($new_w1[$start - 1]);
                            $delta_w1 =  $w1_baru - $new_w1[$start - 1][$count - 1]['w1_baru'];
                        }
                    } elseif ($delta_w1 === null) {
                        $delta_w1 = $w1_baru - $w1_awal;
                        $delta_w2 = $w2_baru - $w2_awal;
                    }
                    $delta_w2_current[$start][$key] = [
                        'delta_w2' => $delta_w2,
                    ];
                    $temp[$start][$key] =  [
                        'pecah_suara' => $value->pecah_suara,
                        'audio_video' => $value->audio_video,
                        'v' => $v[$key],
                        'y' => 1,
                        'y_target' => $value->y_target,
                        'error' => $error,
                        'w1_baru' => $w1_baru,
                        'w2_baru' => $w2_baru,
                        'delta_w1' => $delta_w1,
                        'delta_w2' => $delta_w2,
                    ];
                }
            }
            // if (count($new_w1) > 1) {
            //     $x = array_key_last($new_w1[$start]);
            //     dd(
            //         'oke',
            //         $temp
            //     );
            // }
            // dd($new_w1);
            $result =  array_filter($temp[$start], function ($value) {
                return $value['y'] !== $value['y_target'];
            });
            if (count($result) > 0) {
                $iteration++;
            }
            $start++;
        }
        dd($temp, $new_w1, count($temp));
        // dd(
        //     $new_w1,
        //     $temp,
        //     $new_w1[1][0]['w1_baru'] - $new_w1[0][4]['w1_baru'],



        // );
        return $temp;


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
