<?php

use Illuminate\Support\Facades\DB;

function getResult($data)
{
    try {
        $rate = 1;
        $treshold = 0;
        $predicted = [];
        $latest_row =  DB::table('predicted')->latest('id')->first();
        // $v[$key] = $value->pecah_suara * $w1_baru + $value->audio_video * $w2_baru;
        // $w1_baru = $w1_baru + $rate * $error * $value->pecah_suara;
        // $v = $x1 * $latest_row->w1_baru + $x2 * $latest_row->w2_baru;

        foreach ($data as $key => $value) {
            $v[$key] = $value->pecah_suara * $latest_row->w1_baru + $value->audio_video * $latest_row->w2_baru;

            if ($v[$key] < $treshold) {
                $error = $latest_row->y_target - 0;
                $y_luaran = 0;
                $y_target = $value->pecah_suara > $value->audio_video ? 1 : 0;

                $w1_baru = $latest_row->w1_baru + $rate * $latest_row->error * $value->pecah_suara;
                $w2_baru = $latest_row->w2_baru + $rate * $latest_row->error * $value->audio_video;
                $delta_w1 = $w1_baru - $latest_row->w1_baru;
                $delta_w2 = $w2_baru - $latest_row->delta_w2;

                $predicted = [
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
                $error = $latest_row->y_target - 1;
                $y_luaran = 1;
                $y_target = $value->pecah_suara > $value->audio_video ? 1 : 0;

                $w1_baru = $latest_row->w1_baru + $rate * $latest_row->error * $value->pecah_suara;
                $w2_baru = $latest_row->w2_baru + $rate * $latest_row->error * $value->audio_video;
                $delta_w1 = $w1_baru - $latest_row->w1_baru;
                $delta_w2 = $w2_baru - $latest_row->delta_w2;

                $predicted = [
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
        return $predicted;
    } catch (\Exception $e) {
        return $e->getMessage();
    }
}
