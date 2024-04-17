<?php

use Illuminate\Support\Facades\DB;

function getResult($data)
{
    try {
        $rate = 1;
        $treshold = 0;
        $predicted = [];
        $latest_row =  DB::table('predicted')->latest('id')->first();
        $w1_baru = null;
        $w2_baru = null;
        $delta_w1 = null;
        $delta_w2 = null;
        $delta_w1_current = [];
        $delta_w2_current = [];

        // $v[$key] = $value->pecah_suara * $w1_baru + $value->audio_video * $w2_baru;
        // $w1_baru = $w1_baru + $rate * $error * $value->pecah_suara;
        // $v = $x1 * $latest_row->w1_baru + $x2 * $latest_row->w2_baru;

        foreach ($data as $key => $value) {
            $v[$key] = $value->pecah_suara * $latest_row->w1_baru + $value->audio_video * $latest_row->w2_baru;

            if ($v[$key] < $treshold) {

                $y_luaran = 0;
                $y_target = $value->bidang == 'Choir' ? 1 : 0;
                $error = $y_target - $y_luaran;


                if ($w1_baru == null) {
                    $w1_baru = $latest_row->w1_baru + $rate * $latest_row->error * $value->pecah_suara;
                    $w2_baru = $latest_row->w2_baru + $rate * $latest_row->error * $value->audio_video;
                } elseif ($w1_baru != null) {

                    $w1_baru = $w1_baru + $rate * $error * $value->pecah_suara;
                    $w2_baru = $w2_baru + $rate * $error * $value->audio_video;
                }
                $n_w1[$key] = $w1_baru;

                if ($delta_w1 === null && $delta_w2 === null) {
                    $delta_w1 = $w1_baru - $latest_row->w1_baru;
                    $delta_w2 = $w2_baru - $latest_row->delta_w2;
                } else if (count($delta_w1_current) > 0 && count($delta_w2_current) > 0) {
                    $delta_w1 = $n_w1[$key] - $n_w1[$key - 1];
                    $delta_w2 = $w2_baru - $delta_w2;
                }
                $delta_w1_current[$key] = $delta_w1;
                $delta_w2_current[$key] = $delta_w2;

                $predicted[$key] = [
                    'nama' => $value->nama,
                    'x1' => $value->pecah_suara,
                    'x2' => $value->audio_video,
                    'v' => $v[$key],
                    'y_luaran' => $y_luaran,
                    'y_target' => $y_target,
                    'error' => $error,
                    'w1_baru' => $w1_baru,
                    'w2_baru' => $w2_baru,
                    'delta_w1' => $delta_w1,
                    'delta_w2' => $delta_w2
                ];
            } else {

                $y_luaran = 1;
                $y_target = $value->bidang == 'Choir' ? 1 : 0;
                $error = $y_target - $y_luaran;


                if ($w1_baru == null) {
                    $w1_baru = $latest_row->w1_baru + $rate * $latest_row->error * $value->pecah_suara;
                    $w2_baru = $latest_row->w2_baru + $rate * $latest_row->error * $value->audio_video;
                } elseif ($w1_baru != null) {

                    $w1_baru = $w1_baru + $rate * $error * $value->pecah_suara;
                    $w2_baru = $w2_baru + $rate * $error * $value->audio_video;
                }
                $n_w1[$key] = $w1_baru;

                if ($delta_w1 == null && $delta_w2 == null) {
                    $delta_w1 = $w1_baru - $latest_row->w1_baru;
                    $delta_w2 = $w2_baru - $latest_row->delta_w2;
                } else if (count($delta_w1_current) > 0 && count($delta_w2_current) > 0) {
                    $delta_w1 = $n_w1[$key] - $n_w1[$key - 1];
                    $delta_w2 = $w2_baru - $delta_w2;
                }
                $delta_w1_current[$key] = $delta_w1;
                $delta_w2_current[$key] = $delta_w2;

                $predicted[$key] = [
                    'nama' => $value->nama,
                    'x1' => $value->pecah_suara,
                    'x2' => $value->audio_video,
                    'v' => $v[$key],
                    'y_luaran' => $y_luaran,
                    'y_target' => $y_target,
                    'error' => $error,
                    'w1_baru' => $w1_baru,
                    'w2_baru' => $w2_baru,
                    'delta_w1' => $delta_w1,
                    'delta_w2' => $delta_w2
                ];
            }
        }
        // dd($predicted, $n_w1, $delta_w1_current, $delta_w2_current);
        return $predicted;
    } catch (\Exception $e) {
        return $e->getMessage();
    }
}
